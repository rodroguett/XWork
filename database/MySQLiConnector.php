<?php

namespace XWork\Database;

if (!defined('XWORK'))
          exit('ERROR: No se puede lanzar Directamente');

use \mysqli as mysqli;
use \XWork\Excepciones\DatabaseException as DatabaseException;
use \XWork\Errors as Errors;
use \Exception as Exception;

/**
  @package Database
 * 
 * Motor de Conexion a Mysql a travez de Mysqli
 *
 * @category   database
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    1.3
 * 
 */
final class MySQLiConnector extends DatabaseConfig implements database {

          /**
           * Variables para la interaccion de la base de datos
           */
          private static $_singleInstance;
          private $_sqlLink;
          private $_sqlExec;
          private $_sqlArray        = array();
          private $_sqlAffectedRows = array();
          private $_sqlRows         = array();
          private $_lastID;
          private $_autocommit      = true;

          /**
           * Create la unica instancia de la clase
           * 
           * @param Sring $host Host de la Base de Datos
           * @param Sring $user Usuario de la Base de Datos
           * @param Sring $pass Contraseña del usuario de la Base de Datos
           * @param Sring $name Nombre del Esquema
           * @param Sring $port Puerto de Conexion
           * @return Object self::$_singleInstance Instance
           */
          public static function _getInstance($host, $user, $pass, $name, $port) {
                    if (!self::$_singleInstance instanceof self) {
                              self::$_singleInstance = new self($host, $user, $pass, $name, $port);
                    }
                    return self::$_singleInstance;
          }

          /**
           * Constructor tPara crear la configuracion Inicial
           * 
           * @param Sring $host Host de la Base de Datos
           * @param Sring $user Usuario de la Base de Datos
           * @param Sring $pass Contraseña del usuario de la Base de Datos
           * @param Sring $name Nombre del Esquema
           * @param Sring $port Puerto de Conexion
           * @return none
           */
          private function __construct($host, $user, $pass, $name, $port) {
                    $this->_initializeConfiguration($host, $user, $pass, $name, $port);
                    $this->_connect();
          }

          /**
           * Abre la Conexion a Mysql
           * 
           * @param none
           * @return Object $this
           */
          public function _connect() {
                    try{
                              $this->_sqlLink = new mysqli($this->_sqlHost, $this->_sqlUser, $this->_sqlPass, $this->_sqlDB);
                    }  catch (\Exception $e){
                              XWork\Errors::launch($e);
                    }
                    return $this;
          }

          /**
           * Permite cambiar el esquema
           * 
           * @param String $db_name Nombre del esquema
           * @return Object $this 
           */
          public function _selectDB($db_name = false) {
                    try {
                              if (!$db_name) {
                                        throw new DatabaseException('Para Cambiar de Base de Datos, Tiene que pasar el Nombre de la Misma', -1);
                              } else {
                                        $this->_sqlLink->select_db($db_name);
                                        return $this;
                              }
                    } catch (DatabaseException $exc) {
                              Errors::launch($exc);
                    } catch (Exception $exc) {
                              Errors::launch($exc);
                    }
          }

          /**
           * Ejecuta una consulta
           * 
           * @param String $_query
           * @return Object $this 
           */
          public function _query($_query) {
                    try {
                              @$this->_nextResult();
                              if ($this->_sqlExec = $this->_sqlLink->query($_query)) {
                                        return $this->_sqlExec;
                              } else {
                                        throw new DatabaseException('No se ha Podido ejecutar la query: ' . $this->_sqlLink->error, -3);
                              }
                    } catch (DatabaseException $e) {
                              Errors::launch($e);
                    } catch (Exception $e) {
                              Errors::launch($e);
                    }
          }

          /**
           * Quita AutoCommit de las QUERYS
           * @param bool $bool Habilita o deshabilita Autocommit
           */
          public function _autocommit($bool) {
                    $this->_autocommit = $bool;
                    $this->_sqlLink->autocommit($bool);
          }

          /**
           * Comienza una transaccion
           * 
           * @deprecated desde version 0.3
           * @param none
           * @return Object $this Current object
           */
          public function _begin() {
                    if (!$this->_autocommit) {
                              return $this;
                    }
          }

          /**
           * Commit a los cambios
           * 
           * @param none
           * @return Object $this Current object
           */
          public function _commit() {
                    if (!$this->_autocommit) {
                              $this->_sqlLink->commit();
                              return $this;
                    }
          }

          /**
           * Rollback a los cambios
           * 
           * @param none
           * @return Object $this Current object
           */
          public function _rollback() {
                    if (!$this->_autocommit) {
                              $this->_sqlLink->rollback();
                              return $this;
                    }
          }

          /**
           * Fetch al resultado tipo asociativo
           * 
           * @param none
           * @return Object $this
           */
          public function _fetchAssoc() {
                    $_sqlStoreValues = array();
                    while ($this->_sqlRows  = $this->_sqlExec->fetch_assoc()) {
                              $_sqlStoreValues[] = $this->_sqlRows;
                    }
                              $this->_sqlExec->free();
                              $this->_sqlLink->next_result();
                    return $_sqlStoreValues;
          }

          /**
           * Fetch al resultado tipo asociativo y array enumerado
           * 
           * @param none
           * @return Array $this->_sqlStoreValues
           */
          public function _fetchArray() {
                    $_sqlStoreValues = array();
                    while ($this->_sqlArray = $this->_sqlExec->fetch_array(MYSQL_BOTH)) {
                              $_sqlStoreValues[] = $this->_sqlArray;
                    }
                              $this->_sqlExec->free();
                              $this->_sqlLink->next_result();
                    return $_sqlStoreValues;
          }

          /**
           * Fetch al resultado tipo objeto
           * 
           * @param none
           * @return Array $this->_sqlStoreValues
           */
          public function _fetchObject() {
                    try {
                              $ii = 0;
                              $_sqlStoreValues = array();
                              while ($this->_sqlRows = $this->_sqlExec->fetch_object()) {
                                        $_sqlStoreValues[] = $this->_sqlRows;
                                        $ii++;
                              }
                              $this->_sqlExec->free();
                              if($ii>1){
                                        $this->_sqlLink->next_result();
                              } else {
                                        
                              }
                              return $_sqlStoreValues;
                    } catch (DatabaseException $e) {
                              Errors::launch($e);
                    } catch (Exception $e) {
                              Errors::launch($e);
                    }
          }
          
          /**
           * Permite Continuar la Ejecucion
           * 
           * @param none
           * @return none 
           */
          
          public function _nextResult() {
                    $this->_sqlLink->next_result();
          }
          
          /**
           * Permite Continuar la Ejecucion
           * 
           * @param none
           * @return none 
           */
          
          public function _moreResults() {
                    $this->_sqlLink->more_results();
          }

          /**
           * Devuelve la cantidad de objetos afectados
           * 
           * @param none
           * @return Object $this
           */
          public function _affectedRows() {
                    return $this->_sqlAffectedRows = $this->_sqlLink->affected_rows;
          }

          /**
           * Retorna el utimo id  de una query
           * 
           * @param none
           * @return Int $this->_lastID Last id
           */
          public function _lastID() {
                    return $this->_lastID = $this->_sqlLink->insert_id;
          }

          /**
           * Retorna los ultimos id de una consulta
           *  
           * @param Int $_size Count of insert statements
           * @return array
           */
          public function _multipleID($_size) {
                    for ($i = $this->_sqlLink->insert_id; $i < ($this->_sqlLink->insert_id + $_size); $i++) {
                              $_lastIDs[] = $i;
                    }
                    return $_lastIDs;
          }

          /**
           * Limpia Resultado de la Memoria
           * 
           * @param none
           * @return none
           */
          public function _freeResult() {
//                    mysqli_free_result($this->_sqlExec);
                    $this->_sqlExec->free_result();
          }

          /**
           * Limpia inyecciones sql
           * 
           * @param none
           * @return none
           */
          public function _sanitize($var) {
                    $a = ($var);
                    $r = $this->_sqlLink->real_escape_string($a);
                    return $r;
          }

          /**
           * Impide Clonar el Objeto
           * 
           * @param none
           * @return none
           */
          private function __clone() {
                    throw new DatabaseException("Cloning is disabled.");
          }

          /**
           * Destruye la Conexion
           * 
           * @param none
           * @return none
           */
          public function __destruct() {
                    try {
                              @$this->_sqlLink->close();
                    } catch (\XWork\Excepciones\DatabaseException $e) {
                              print_r($e);
                    } catch (\Exception $e) {
                              print_r($e);
                    }
          }

          public function _callRoutine($routine, array $data) {
                    $it = "";
                    foreach ($data as $key => $value) {
                              $n = "SET @" . $key . " = '" . $value . "';";
                              $this->_query($n);
                              $it .= " @" . $key . ",";
                    }
                    $it = substr($it, 0, -1);
                    $q  = "CALL " . $routine . "(" . $it . ");";
                    return $this->_query($q);
          }

}

<?php
namespace XWork\Database;
if (!defined('XWORK'))
          exit('ERROR: No se puede lanzar Directamente');

use \XWork\Excepciones\DatabaseException as DatabaseException;
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

final class MySQLConnector extends DatabaseConfig implements database {

          /**
           * Variables for database interaction
           */
          private static $_singleInstance;
          private $_sqlLink;
          private $_sqlExec;
          private $_sqlArray        = array();
          private $_sqlAffectedRows = array();
          private $_sqlRows         = array();
          private $_lastID;

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
          public static function _getInstance($host,$user,$pass,$name,$port) {
                    if (!self::$_singleInstance instanceof self) {
                              self::$_singleInstance = new self($host,$user,$pass,$name,$port);
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
          private function __construct($host,$user,$pass,$name,$port) {
                    $this->_initializeConfiguration($host,$user,$pass,$name,$port);
                    $this->_connect()->_selectDB();
          }

          /**
           * Abre la Conexion a Mysql
           * 
           * @param none
           * @return Object $this
           */
          public function _connect() {
                    $this->_sqlLink = mysql_connect($this->_sqlHost, $this->_sqlUser, $this->_sqlPass);
                    return $this;
          }

          /**
           * Selecciona un Esquema
           * 
           * @param none
           * @return Object $this 
           */
          public function _selectDB() {
                    mysql_select_db($this->_sqlDB, $this->_sqlLink);
          }

          /**
           * Ejecuta una Consulta
           * 
           * @param String $_query
           * @return Object $this 
           */
          public function _query($_query) {
                    $this->_sqlExec = mysql_query($_query);
                    return $this;
          }

          /**
           * Comienza una Transaccion
           * 
           * @param none
           * @return Object $this Current object
           */
          public function _begin() {
                    mysql_query("BEGIN");
                    return $this;
          }

          /**
           * Commit a los cambios
           * 
           * @param none
           * @return Object $this Current object
           */
          public function _commit() {
                    mysql_query("COMMIT");
                    return $this;
          }

          /**
           * Rollback a los cambios
           * 
           * @param none
           * @return Object $this Current object
           */
          public function _rollback() {
                    mysql_query("ROLLBACK");
                    return $this;
          }

          /**
           * Fetch al resultado tipo asociativo
           * 
           * @param none
           * @return Object $this
           */
          public function _fetchAssoc() {
                    $_sqlStoreValues = array();
                    while ($this->_sqlRows  = mysql_fetch_assoc($this->_sqlExec)) {
                              $_sqlStoreValues[] = $this->_sqlRows;
                    }
                    $this->_freeResult();
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
                    while ($this->_sqlArray = mysql_fetch_array($this->_sqlExec, MYSQL_BOTH)) {
                              $_sqlStoreValues[] = $this->_sqlArray;
                    }
                    $this->_freeResult();
                    return $_sqlStoreValues;
          }

          /**
           * Fetch al resultado tipo objeto
           * 
           * @param none
           * @return Array $this->_sqlStoreValues
           */
          public function _fetchObject() {
                    $_sqlStoreValues = array();
                    while ($this->_sqlRows  = mysql_fetch_object($this->_sqlExec)) {
                              $_sqlStoreValues[] = $this->_sqlRows;
                    }
                    $this->_freeResult();
                    return $_sqlStoreValues;
          }

          /**
           * Devuelve la cantidad de objetos afectados
           * 
           * @param none
           * @return Object $this
           */
          public function _affectedRows() {
                    return $this->_sqlAffectedRows = mysql_affected_rows();
          }

          /**
           * Retorna el utimo id  de una query
           * 
           * @param none
           * @return Int $this->_lastID Last id
           */
          public function _lastID() {
                    return mysql_insert_id();
          }

          /**
           * Retorna los ultimos id de una consulta
           *  
           * @param Int $_size Count of insert statements
           * @return array
           */
          public function _multipleID($_size) {
                    for ($i = mysql_insert_id(); $i < (mysql_insert_id() + $_size); $i++) {
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
                    mysql_free_result($this->_sqlExec);
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
                    mysql_close($this->_sqlLink);
          }

          /**
           *Limpia Inyecciones SQL
           * 
           * @param none
           * @return none
           */

          public function _sanitize($var) {
                    return htmlentities($var);
          }

}
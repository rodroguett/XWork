<?php

namespace XWork\Database;

if (!defined('XWORK')) {
          exit('ERROR: No se puede lanzar Directamente');
}

/**
 *  Manager de los motores de conexion a Bases de Datos
 * 
 * @category   core
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    1.2
 * @since version 2(1.36)
 */

use \XWork\Excepciones\DatabaseException as DatabaseException;
use \XWork\Errors as Errors;

class DatabaseManager {

          /**
           * @var Object $_dataObject Conector a los Motores
           */
          public $_dataObject;

          /**
           * Inicializa el conector, segun especificacion
           * 
           * @param String $driver Nombre del Driver, por defecto Vacio
           * @param Sring $host Host de la Base de Datos
           * @param Sring $user Usuario de la Base de Datos
           * @param Sring $pass Contraseña del usuario de la Base de Datos
           * @param Sring $name Nombre del Esquema
           * @param Sring $port Puerto de Conexion
           * @return Object $this->_dataObject Objeto del Motor
           */
          public function __construct($driver = DB_DRVR,$host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $name = DB_NAME, $port = DB_PORT) {
                    try {
                              switch (strtoupper($driver)) {
                                        case 'MYSQL':
                                                  $this->_dataObject = MySQLConnector::_getInstance($host,$user,$pass,$name,$port);
                                                  break;

                                        case 'MYSQLI':
                                                  $this->_dataObject = MySQLiConnector::_getInstance($host,$user,$pass,$name,$port);
                                                  break;

                                        case 'ORACLE':
                                                  $this->_dataObject = OracleConector::_getInstance($host,$user,$pass,$name,$port);
                                                  break;

                                        case 'PGSQL':
                                                  $this->_dataObject = PostgreConector::_getInstance($host,$user,$pass,$name,$port);
                                                  break;

                                        case 'SQLITE':
                                                  $this->_dataObject = SqliteConector::_getInstance($host,$user,$pass,$name,$port);
                                                  break;

                                        case 'MSSQL':
                                                  $this->_dataObject = MSSqlConector::_getInstance($host,$user,$pass,$name,$port);
                                                  break;
                                        default:
                                                  throw new DatabaseException('Motor inexistente, no disponible o no instalado');
                                                  break;
                              }
                    } catch (DatabaseException $e){
                              Errors::launch($e);
                    } catch (Exception $e){
                              Errors::launch($e);
                    }
          }

}
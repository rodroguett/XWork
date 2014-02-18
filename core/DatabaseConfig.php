<?php
namespace XWork\Database;

if (!defined('XWORK')) {
          exit('ERROR: No se puede lanzar Directamente');
}

/**
  @package Database
 * 
 * Clase Abstracta que permite obtener todos loas parametros de conexion
 *  
 * @category   core
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    1.0
 * @since version 2(1.36)
 */

abstract class DatabaseConfig {

          /**
           * @var $_sqlHost Host de la Base de Datos
           * @access protected
           */
          protected $_sqlHost;

          /**
           * @var $_sqlUser Usuario de la Base de Datos
           * @access protected
           */
          protected $_sqlUser;

          /**
           * @var $_sqlPass Contraseña del usuario de la Base de Datos
           * @access protected
           */
          protected $_sqlPass;

          /**
           * @var $_sqlDB Nombre del Esquema
           * @access protected
           */
          protected $_sqlDB;

          /**
           * @var $_sqlDB Puerto de Conexion
           * @access protected
           */
          protected $_sqlPort;

          /**
           * Genera la configuracion
           * 
           * @param Sring $host Host de la Base de Datos
           * @param Sring $user Usuario de la Base de Datos
           * @param Sring $pass Contraseña del usuario de la Base de Datos
           * @param Sring $name Nombre del Esquema
           * @param Sring $port Puerto de Conexion
           * @return none
           */
          protected function _initializeConfiguration($host = DB_HOST,$user = DB_USER,$pass = DB_PASS,$name = DB_NAME,$port = DB_PORT) {
                    $this->_sqlHost = $host;
                    $this->_sqlUser = $user;
                    $this->_sqlPass = $pass;
                    $this->_sqlDB   = $name;
                    $this->_sqlPort   = $port;
          }

}

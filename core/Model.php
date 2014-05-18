<?php

namespace XWork;

if (!defined('XWORK')) {
          exit('ERROR: No se puede lanzar Directamente');
}

/**
 * Sistema de manejo de Modelos
 * 
 * @category   core
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.3
 * @since version 0(0.12)
 */


use \XWork\Database\DatabaseManager as Database;

use XWork\Models\model as modelInterface;

class Model implements modelInterface{

          protected $_database;

          function __construct() {
                    $db = new Database();
                    $this->_database = $db->_dataObject;
          }

          function __destruct() {
                    $this->_database->__destruct();
          }

}

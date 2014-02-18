<?php

namespace XWork\Database;

if (!defined('XWORK'))
          exit('ERROR: No se puede lanzar Directamente');

/**
 * Interface que define a todos los conectores de Bases de Datos
 * 
 * @category   database
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.8
 */

interface database {

          public static function _getInstance($host,$user,$pass,$name,$port);
          public function _connect();
          public function _query($_query);
          public function _begin();
          public function _commit();
          public function _rollback();
          public function _fetchAssoc();
          public function _fetchArray();
          public function _fetchObject();
          public function _affectedRows();
          public function _lastID();
          public function _multipleID($_size);
          public function _freeResult();
}

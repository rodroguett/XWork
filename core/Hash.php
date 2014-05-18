<?php

namespace XWork;

if (!defined('XWORK')) {
          exit('ERROR: No se puede lanzar Directamente');
}

use \XWork\Database\DatabaseManager as Database;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hash
 *
 * @author mrojas
 */
class Hash {

          private $salt;
          private $hash;
          private $_database;

          public function __construct() {
                    $db              = new Database();
                    $this->_database = $db->_dataObject;
          }

          public function HashID($id) {
                    if ($this->getSalt($id)) {
                              return $this->hash;
                    } else {
                              return false;
                    }
          }

          public function HashIDVerification($id, $salt) {
                    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
                              $hs = str_replace('/','_',crypt($id, $salt));
                    } else {
                              $hs = str_replace('/','_',crypt($id));
                    }
                    return $hs;
          }

          private function getSalt($id) {
                    $this->hash = $this->blowfish($id);
                    $this->_database->_query("SET @iVuserID = '" . $this->_database->_sanitize($id) . "'");
                    $this->_database->_query("SET @iVsalt = '" . $this->salt . "'");
                    if ($this->_database->_query("CALL `" . DB_NAME . "`.`alterSalt`(@iVsalt,@iVuserID)")) {
                              return true;
                    } else {
                              return false;
                    }
          }

          public function check($in, $hash) {
                    
          }

          public function blowfish($in, $digito = 7) {
                    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
                              $set_salt = '.1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                              $salt     = sprintf('$2a$%02d$', $digito);
                              for ($i = 0; $i < 22; $i++) {
                                        $salt .= $set_salt[mt_rand(0, 63)];
                              }
                              $this->salt = $salt;
                              return str_replace('/','_',crypt($in, $salt));
                    } else {
                              return str_replace('/','_',crypt($in));
                    }
          }

}

<?php
namespace XWork\Helpers;

use XWork\Helper as Hlp;
use XWork\Hash as hsh;

/**
 * Helper de funciones de fechas
 * 
 * @category   controllers
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.7
 */

class hashHelper extends Hlp {
          
          private $hasher;
          
          public function __construct() {
                    parent::__construct();
                    $this->hasher  = new hsh();
          }
          
          public function index() {
                    
          }
          
          public function getNewUserHashVerify($userID) {
                    return $this->hasher->HashID($userID);
          }
          
          public function verifyHashVerification($iduser,$salt) {
                    return $this->hasher->HashIDVerification($iduser,$salt);
          }
}

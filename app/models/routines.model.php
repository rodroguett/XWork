<?php
namespace XWork\Models;

use XWork\Model as Mdl;

/**
 * Description of fecha
 *
 * @author mrojas
 */
class routinesModel extends Mdl {
          
          public function __construct() {
                    parent::__construct();
          }
          
          public function getLogin($mail,$pass) {
                    $mail = $this->_database->_sanitize($mail);
                    $pass = md5($this->_database->_sanitize($pass));
                    
                    $this->_database->_query('SET @idusuario = -1;');
                    $this->_database->_query("CALL login('" . $mail . "','" . $pass . "',@idusuario);");
                    $l = $this->_database->_query('SELECT @idusuario as idusuario;');
                    $k = $l->fetch_object();
                    return $k->idusuario;
                    //$b = $this->_database->_fetchObject();
                    
//                    $a = $this->_database->_fetchObject();
//                    $r = $a[0]->idusuario;
//                    $this->_database->_moreResults();
                    //return $r;
                    
          }
          
          public function getInfoUsuario($id) {
                    $this->_database->_callRoutine("getInfoUser",array('id'=>$id));
                    $a = $this->_database->_fetchObject();
                    $r = $a[0];
                    return $r;
          }
          
          public function getAllMenu() {
                    $this->_database->_callRoutine("ifkeirl_mc.getAllMenu",array());
                    return $this->_database->_fetchObject();
          }
          
          public function getAllPermisos($id) {
                    $arr = array();
                    $this->_database->_callRoutine("getAllPermisos",array('id'=>$id));
                    $a = $this->_database->_fetchObject();
                    for ($i = 0; $i < count($a); $i++) {
                              $ares = $a[$i];
                              array_push($arr, $ares->href);
                    }
                    return $arr;
                    
          }
          
          public function getSelectRegion() {
                    $this->_database->_query('SET @res = "";');
                    $this->_database->_query("CALL getSelectRegion(@res);");
                    $l = $this->_database->_query('SELECT @res AS res;');
                    $n =  $l->fetch_object();
                    return $n->res;
          }
          
          public function getSelectComunaGroupRegion() {
                    $this->_database->_query('SET @res = "";');
                    $this->_database->_query("CALL getSelectComunaGroupRegion(@res);");
                    $l = $this->_database->_query('SELECT @res AS res;');
                    $n =  $l->fetch_object();
                    return utf8_encode($n->res);
          }
          
          public function getEmpresasFromUser($idusuario) {
                    $this->_database->_query('SET @res = "";');
                    $this->_database->_query('SET @idusuario = "' . $idusuario . '";');
                    $this->_database->_query("CALL getEmpresasFromUser(@idusuario, @res);");
                    $l = $this->_database->_query('SELECT @res AS res;');
                    $n =  $l->fetch_object();
                    return utf8_encode($n->res);
          }
          
          public function __destruct() {
                    parent::__destruct();
          }
          
}

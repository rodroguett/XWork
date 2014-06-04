<?php
namespace XWork\Models;

use XWork\Model as Model;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 class AdminModel extends Model {
     
      
 public function getUsuario(){
   
     $sql="select * from DEMO.USUARIOS_CLINICA";      
     $r=$this->_database->fetch_object();
             
     return $r;
//     echo 'hola';
     
   }
 }
 

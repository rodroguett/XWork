<?php
namespace XWork\Models;

use XWork\Model as adm;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 class AdminModel extends adm {
     
     /*public function getUsuario(){
   
         if ($this->_database->_query("select idUsuario, mailUsuario from " . DB_NAME . ".USUARIOS_CLINICA")) {
             $p = $this->_database->_fetchObject();
             $r = '';
            for ($i = 0; $i < count($p); $i++) {
                $ares = $p[$i];
                $r .= "<div> " . $ares->idUsuario . "  " . $ares->mailUsuario . "</div>";
            }
            return $r;
         }  else {
             echo 'hola';
         }
     
     
     
     //echo 'hola';
     
   }*/
     
   public function getUsuario(){
       
       $query  = "SELECT * FROM ".DB_NAME. ".USUARIOS_CLINICA";
       $result = $this->_database->_query($query);       
       $num = $result->num_rows;
       $var = '';
            
       
       for($x=0;$x<$num;$x++){
           
          $fila = $result->fetch_object();
          $var.="<tr>";
          $var.="<td>".$fila->mailUsuario."</td>";
          $var.="<td>".$fila->passUsuario."</td>";
          $var.="</tr>";
          
       }
       
       return $var;
       
   } 
     
 }
 

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace XWork\Controllers;

/**
 * Description of administrador
 *
 * @author rodroguett
 */
class administradorController extends \XWork\Controller{
    
    private $userDatos;
    
    public function __construct() {
            parent::__construct();                    
            $this->userDatos = $this->loadModel('admin');
    }
    
    public function index() {
        $this->_view->load('index', false);       
        $this->_view->renderizar();

    }

    public function usuarios() {
        $this->_view->load('usuarios', false);
        $this->_view->assign('user',$this->userDatos->getUsuario());
        $this->_view->assign('EXPLICIT_SCRIPT',$this->_view->loadJavascriptScript('usuarios'));
        $this->_view->renderizar();
    }
    
   public function EnviarUsuarios(){
       $p = $_POST;
       $mail = $p['txtemail'];
       $pass = $p['txtpass'];
       $id = $this->userDatos->saveUser($mail,$pass);
       echo $id;
      
//      $this->_view->load('usuarios',false);
//      $this->_view->assign('getUser',$this->userDatos->saveUsuario($data));
       
   }
    
}

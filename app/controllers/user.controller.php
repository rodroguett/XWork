<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace XWork\Controllers;

/**
 * Description of user
 *
 * @author mrojas
 */
class userController extends \XWork\Controller {
          
          private $userDatos;
          
          public function __construct() {
                    parent::__construct();                    
                    $this->userDatos = $this->loadModel('users');
          }
          
          public function index() {
                    $this->redireccionar("user/profile");
          }
          
          public function profile() {
                    $n = $this->_request->getArgs(0);
                    $this->_view->load('profile',false);
                    $a = $this->userDatos->getAllDatos(\XWork\Session::get('idusuario'));
                    if($n == 'act'){
                              $this->_view->assign('SCRIPT_ALTER','$(function(){launchModalEdit();});');
                    } 
                    $pp = \XWork\Session::get('perfil');
                    if($pp != 'administrador'){
                              $this->_view->assign('USER_MAIL_EXC',' disabled="disabled" ');
                    }
                    echo $pp;// if() $pp = administrador poder editar correo, else no
                    $this->_view->assign('USER_NAME',$a->nombre);
                    $this->_view->assign('USER_LNAME',$a->apellido);
                    $this->_view->assign('USER_CARGO',$a->cargo);
                    $this->_view->assign('USER_PHONE',$a->telefono);
                    $this->_view->assign('USER_EMAIL',$a->mail);
                    $this->_view->assign('USER_SKYPE',$a->skype);
                    $this->_view->assign('USER_FROM',$a->fecha_creacion);
                    $this->_view->renderizar();
          }

}

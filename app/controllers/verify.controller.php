<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author mrojas
 */

namespace XWork\Controllers;

class verifyController extends \XWork\Controller {
          
          private $userModel;
          private $routinesModel;
          private $hashHelper;
          
          public function __construct() {
                    parent::$_loginException = true;
                    parent::__construct(TRUE);
                    $this->userModel = $this->loadModel('users');
                    $this->hashHelper = $this->loadHelper('hash');
                    $this->routinesModel = $this->loadModel('routines');
          }
          
          public function index() {
                    $this->redireccionar();
          }
          
          public function user() {
                    $hash = $this->_request->getArgs(0);
                    $mail = $this->_request->getArgs(1);
                    $a = $this->userModel->getSaltInfo($mail);
                    if(!is_int($a)){
                              $sSalt = $a->salt;
                              $sId = $a->idusuario;
                              $sVs = $this->hashHelper->verifyHashVerification($sId,$sSalt);
                              if($sVs == $hash){
                                        //verificado
                                        $this->userModel->verificarUsuario($sId);
                                        $all = $this->routinesModel->getInfoUsuario($sId);
                                        $perm = $this->routinesModel->getAllPermisos($sId);
                                        \XWork\Session::set('idusuario', $sId);
                                        \XWork\Session::set('user_permisos', $perm);
                                        \XWork\Session::set('mail', $all->mail);
                                        \XWork\Session::set('nombre', $all->nombre);
                                        \XWork\Session::set('apellido', $all->apellido);
                                        \XWork\Session::set('fcreacion', $all->fcreacion);
                                        \XWork\Session::set('telefono', $all->telefono);
                                        \XWork\Session::set('perfil', $all->perfil);
                                        \XWork\Session::set('cargo', $all->cargo);
                                        \XWork\Session::set('fmodificacion', $all->fmodificacion);
                                        //echo \XWork\Session::set('onlogin', 1);
                                        $this->redireccionar('#user/profile/act');
                              } else {
                                        $this->redireccionar('../');
                              }
                              
                    } else {
                              //$this->redireccionar();
                              echo 'NO';
                    }
          }
          
          public function verifyLogin() {
                    $localTimeStamp = \XWork\Session::get('localtimestamp');
                    $diff = $localTimeStamp+(SESSION_TIME * 60);
                    $act = date('U');
                    $min = $diff-$act;
                    if($min<0){
                              \XWork\Session::set('onlogin', 0);
                              \XWork\Session::destroy();
                              echo 0;
                    } else {
                              echo 1;
                    }
          }

}

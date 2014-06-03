<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author mrojas
 */

namespace XWork\Controllers;

use \XWork\Controller as Ctrl;

class loginController extends Ctrl {
          
          private $_userModel;
          private $userModel;
          private $mailHelper;
          private $hashHelper;
          
          public function __construct() {
                    parent::$_loginException = TRUE;
                    parent::__construct(TRUE);
                    $this->_userModel = $this->loadModel('routines');
                    $this->userModel = $this->loadModel('users');
                    $this->mailHelper = $this->loadHelper('mail');
                    $this->hashHelper = $this->loadHelper('hash');
          }
          
          public function index() {
                    $this->_view->load('index',false);        
                    //$this->_view->assign('VAR','Cancino estas puro odiando!');
                    $this->_view->assign('HOLA','Bienvenido login');
                    
                    $this->_view->renderizar();                    
          }
          
          public function login() {
                    $p = $_POST;
                    $mail = $p['email'];
                    $pass = $p['password'];
                    $r = $this->_userModel->getLogin($mail,$pass);
                    if($r > 0){
//                              $all = $this->_userModel->getInfoUsuario($r);
//                              $perm = $this->_userModel->getAllPermisos($r);
                              \XWork\Session::set('idusuario', $r);
//                              \XWork\Session::set('user_permisos', $perm);
//                              \XWork\Session::set('mail', $all->mail);
                              \XWork\Session::set('nombre', 'Pepito');
                              \XWork\Session::set('apellido', 'Ramos');
//                              \XWork\Session::set('fcreacion', $all->fcreacion);
//                              \XWork\Session::set('telefono', $all->telefono);
                              \XWork\Session::set('perfil', 'administrador');
//                              \XWork\Session::set('cargo', $all->cargo);
//                              \XWork\Session::set('fmodificacion', $all->fmodificacion);
                              echo \XWork\Session::set('onlogin', 1);
                    } else {
                              echo "Usuario no Válido";
                    }
          }
          
          public function logout() {
                    \XWork\Session::destroy();
                    $this->redireccionar('../');
          }
          
          public function singup() {
                    $p = $_POST;
                    $mail = $p['mail'];
                    $pass = $p['pass'];
                    try{
                              $m = $this->userModel->singUp($mail,$pass);
                              if($m>0){
                                        $destinatario_mail = $p['mail'];
                                        $hash = $this->hashHelper->getNewUserHashVerify($m);
                                        $subject = "LLAE.CL | Verificacion de Cuentas";
                                        $mensaje = '
                                                            <html>
                                                            <head>
                                                            <title>Sistema de Creacion de Usuarios - LLAE.CL</title>
                                                            </head>
                                                            <body>    
                                                            <p>Saludos:</p>
                                                            <p>Se ha creado su usuario para LLAE.cl<br>
                                                            Primero debe verificar su cuenta desde <a href="'. BASE_URL .'verify/user/' . $hash . '/' . $destinatario_mail . '">aqui</a>, luego <br />
                                                            vaya al login del sistema desde <a href="'. BASE_URL_PROYECT .'">aqui</a>, colocando su<br> 
                                                            actual Mail y la siguiente contrase&ntilde;a:<br><br></p>
                                                            <p><center><b>' . $_POST['pass'] . '</b></center>
                                                            <br><br></p>
                                                            <p>Si  desea modificar su contrase&ntilde;a, dirijase a <a href="'.BASE_URL.'#user/profile/">Su Perfil</a> una vez ya logueado</p>
                                                            </body>
                                                            </html>';
                                        $this->mailHelper->sendSimpleMail($mensaje,$destinatario_mail,"Usuario",$subject);
                                        echo 1;
                              } else {
                                        echo $m;
                              }
                              die();
                    }  catch (\Exception $e){
                              echo "No hemos podido registrar el usuario, intentelo mas tarde ";
                              die();
                    }
//                    if($r > 0){
//                    
//                    } else {
//                              echo "No hemos podido registrar el usuario, intentelo mas tarde";
//                    }
          }

}

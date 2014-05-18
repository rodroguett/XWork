<?php

namespace XWork;

if (!defined('XWORK')) {
          exit('ERROR: No se puede lanzar Directamente');
}

/**
 * Sistema de Arranque del Framework
 * 
 * @category   core
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    1.3
 */


use XWork\Excepciones\BootstrapException as BootstrapException;
use XWork\Excepciones\XWorkException as XWorkException;
use XWork\Errors as Errors;
use \Exception as Exception;


class Bootstrap {

          public function __construct() {
                    
          }
          
          public static function run(request $q){
                    $controlador = $q->getControlador();
                    $metodo = $q->getMetodo();
                    $argumentos = $q->getArgs();
                    $modulo = $q->getModulo();

                    if ($modulo) {
                              try {
                                        $mainctrlmod = ($controlador) ? $controlador : DEFAULT_CONTROLLER;
                                        $rutaModulo  = MODULOS . $modulo . DS . 'app' . DS . 'controller' . DS . $mainctrlmod . '.controller.php';
                                        if (is_readable($rutaModulo)) {
                                                  $rutaControlador = $rutaModulo;
                                                  $controllerName  = '\XWork\Controllers\\' . $controlador . 'Controller';
                                        } else {
                                                  $handler =  MODULOS . $modulo . DS .  DEFAULT_MODULE_HANDLER;
                                                  if(is_readable($handler)){
                                                            require_once $handler;
                                                            die();
                                                  } else {
                                                            throw new BootstrapException('Error de base de modulo (<b>' . $rutaModulo . '</b>)');
                                                  }
                                        }
                              } catch (BootstrapException $e){
                                        Errors::launch($e);
                              }
                    } else {
                              if(PERMISSION_TYPE == 0){
                                        $var_x = Session::get(DEFAULT_USER_PERMISOS);
                                        if ($controlador == DEFAULT_CONTROLLER OR $controlador == DEFAULT_VERIFY  OR $controlador == DEFAULT_LOGIN OR $controlador == DEFAULT_ERROR OR $controlador == DEFAULT_MENU OR $controlador == DEFAULT_PROFILE_USER) {
                                                  $rutaControlador = CONTROLLERS . $controlador . '.controller.php';
                                                  $controllerName  = '\XWork\Controllers\\' . $controlador . 'Controller';
                                        } elseif (!empty($var_x)) {
                                                  if (in_array(strtolower($controlador), Session::get(DEFAULT_USER_PERMISOS)) 
                                                          OR in_array(strtolower($metodo), Session::get(DEFAULT_USER_PERMISOS)) 
                                                          OR strtolower(substr($controlador, 0, 3)) == DEFAULT_AJAX_PREFIX 
                                                          OR is_array($controlador) OR $controlador == DEFAULT_ERROR 
                                                          OR $metodo == 'index') {

                                                            $rutaControlador = CONTROLLERS . $controlador . '.controller.php';
                                                            $controllerName  = '\XWork\Controllers\\' . $controlador . 'Controller';
                                                  } else {
                                                            header('location:' . BASE_URL . DEFAULT_ERROR . '/404');
                                                  }
                                        } else {
                                                  //die(" No Puede estar aqui, por error de permiso, este mensaje desaparecera cuando edites la linea 46 de Bootstrap del Nucleo " . DEFAULT_VERIFY . $controlador );
                                                  header('location:' . BASE_URL . DEFAULT_LOGIN . '/'. DEFAULT_LOGOUT);
                                        }
                              } else {
                                        $rutaControlador = CONTROLLERS . $controlador . '.controller.php';
                                        $controllerName  = '\XWork\Controllers\\' . $controlador . 'Controller';
                              }
                    }

                    if (is_readable($rutaControlador)) {
                              require_once $rutaControlador;
                              try{
                                        if (class_exists($controllerName)) {
                                                  $controller = new $controllerName;
                                        } else {
                                                  echo $controllerName;
                                                  throw new BootstrapException("Problema con el controlador de funcionamiento en: <b>'" . $controllerName . "'</b>, al parecer no existe o no puedeser instanciado");
                                        }
                                        if (method_exists($controller, 'index')) {
                                                  if (is_callable(array($controller, $metodo))) {
                                                            $metodo = $q->getMetodo();
                                                  } else {
                                                            $metodo = 'index';
                                                  }

                                                  if (isset($argumentos)) {
                                                            call_user_func_array(array($controller, $metodo), $argumentos);
                                                  } else {
                                                            call_user_func(array($controller, $metodo));
                                                  }
                                        } else {
                                                  throw new BootstrapException("Error en el controlador <b>'" . $controllerName . "'</b>: no tiene metodo index");
                                        }
                              } catch (XWorkException $exc) {
                                        Errors::launch($exc);
                              } catch (Exception $exc) {
                                        Errors::launch($exc);
                              }
                    } else {
//                              echo $rutaControlador;
                              header('location:' . BASE_URL . DEFAULT_ERROR . '/404');
                              //throw new XWorkException('controlador no encontrado: <b>'.$controller.'</b> (ruta: <b>'.$rutaControlador.'</b>)');
                    }
          }

}

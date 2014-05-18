<?php

namespace XWork;

if (!defined('XWORK')) {
          exit('ERROR: No se puede lanzar Directamente');
}

use XWork\Excepciones\SessionException as SessionException;
/**
 * Sistema de Gestion de Sesiones PHP
 * 
 * @category   core
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.3
 * @since version 0(0.12)
 */
class Session {

          private static $excLogin = false;

          public static function init() {
                    session_start();
                    self::set('tiempo', time());
          }

          public static function destroy($clave = false) {
                    if ($clave) {
                              if (is_array($clave)) {
                                        for ($i = 0; $i < count($clave); $i++) {
                                                  if (isset($_SESSION[$clave[$i]])) {
                                                            unset($_SESSION[$clave[$i]]);
                                                  }
                                        }
                              } else {
                                        if (isset($_SESSION[$clave])) {
                                                  unset($_SESSION[$clave]);
                                        }
                              }
                    } else {
                              log::session('LOGOUT', 'Usuario ha cerrado su sesion');
                              unset($_SESSION['onlogin']);
                              session_unset();
                              session_destroy();
                    }
          }

          public static function get($target) {
                    if (isset($_SESSION[$target])) {
                              return $_SESSION[$target];
                    } else {
                              return false;
                    }
          }

          public static function set($target, $value) {
                    return $_SESSION[$target] = $value;
          }

          public static function tiempo() {
                    if (!session::get('tiempo') || !defined('SESSION_TIME')) {
                              throw new SessionException('No se ha definido el tiempo de sesion');
                    }

                    if (SESSION_TIME == 0) {
                              return;
                    }

                    if (time() - session::get('tiempo') > (SESSION_TIME * 60)) {
                              log::session('LOGOUT', 'Sesion cerrada por tiempo inactiva');
                              session::destroy();
                              header('location:' . BASE_URL . 'login/logout');
                    } else {
                              session::set('tiempo', time());
                    }
          }

          public static function onlogin() {
                    if (!session::get('onlogin')) {
                              if (!self::$excLogin) {
                                        $url = "http://" . $_SERVER['HTTP_HOST'] . ":" . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
                                        log::session('ACCESO_RESTRINGIDO', 'Usuario ha Intentado acceder sin estar logueado a: ' . $url);
                                        header('location:' . BASE_URL . 'login/');
                                        exit;
                              }
                    }
          }

}

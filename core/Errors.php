<?php

namespace XWork;

if (!defined('XWORK')) {
          exit('ERROR: No se puede lanzar Directamente');
}

/**
 * Sistema de Acontrol y manejo de errores
 * 
 * @category   core
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.4
 * @since version 1.6(0.87)
 */
class Errors {

          private static $_view;

          public static function launch($exc) {
                    self::$_view = new View(new Request(), 'ErrorHandler');
                    $a = get_class($exc);
                    $b = explode('\\', $a);
                    $c = $b[(count($b) - 1)];
                    switch ($c) {
                              case 'ServerException': self::serverException_handler($exc);
                                        break;
                              case 'LibsException': self::libsException_handler($exc);
                                        break;
                              case 'DatabaseException': self::databaseException_handler($exc);
                                        break;
                              case 'PDOException': self::PDOException_handler($exc);
                                        break;
                              case 'ViewException': self::ViewsException_handler($exc);
                                        break;
                              default: self::unknown_handler($exc);
                                        break;
                    }
          }

          public static function serverException_handler($exc) {
                    self::$_view->load('server', FALSE);
                    switch ($exc->getCode()) {
                              case 404:header("HTTP/1.0 404 No Encontrado");
                                        break;
                              case 500:header("HTTP/1.0 500 Error interno del Servidor");
                                        break;
                              default:header("HTTP/1.0 200 OK");
                                        break;
                    }
                    self::$_view->assign(array('CONTENT' => $exc->getMessage(), 'TITLE_NAME' => $exc->getCode()));
                    self::$_view->renderizar();
                    die();
          }

          public static function libsException_handler($exc) {
                    self::$_view->load('libs', FALSE);
                    self::$_view->assign(array('CONTENT'    => $exc->getExplicitMSG(),
                        'TITLE_NAME' => $exc->getCode()
                    ));
                    if (DEVELOPMENT_ENVIRONMENT) {
                              $trace = str_replace('#', '</br>#', $exc->getTraceAsString());
                              self::$_view->assign('ADVANCED', self::advanced($exc->getFile(), $exc->getLine(), $trace));
                    }
                    self::$_view->renderizar(true);
                    die();
          }

          public static function databaseException_handler($exc) {
                    self::$_view->load('db', FALSE);
                    self::$_view->setJs(array('test'));
                    self::$_view->setScript(array('test'));
                    self::$_view->setCss(array('test'));
                    self::$_view->assign(array('CONTENT'    => $exc->getExplicitMSG(),
                        'TITLE_NAME' => $exc->getCode()
                    ));
                    if (DEVELOPMENT_ENVIRONMENT) {
                              $trace = str_replace('#', '</br>#', $exc->getTraceAsString());
                              self::$_view->assign('ADVANCED', self::advanced($exc->getFile(), $exc->getLine(), $trace));
                    }
                    self::$_view->renderizar(true);
                    die();
          }

          public static function PDOException_handler($exc) {
                    self::$_view->load('db', FALSE);
                    self::$_view->setJs(array('test'));
                    self::$_view->setScript(array('test'));
                    self::$_view->setCss(array('test'));
                    self::$_view->assign(array('CONTENT'    => $exc->getExplicitMSG(),
                        'TITLE_NAME' => $exc->getCode()
                    ));
                    if (DEVELOPMENT_ENVIRONMENT) {
                              $trace = str_replace('#', '</br>#', $exc->getTraceAsString());
                              self::$_view->assign('ADVANCED', self::advanced($exc->getFile(), $exc->getLine(), $trace));
                    }
                    self::$_view->renderizar();
                    die();
          }

          public static function ViewsException_handler($exc) {
                    self::$_view->load('db', FALSE);
                    self::$_view->setJs(array('test'));
                    self::$_view->setScript(array('test'));
                    self::$_view->setCss(array('test'));
                    self::$_view->assign(array('CONTENT'    => $exc->getExplicitMSG(),
                        'TITLE_NAME' => $exc->getCode()
                    ));
                    if (DEVELOPMENT_ENVIRONMENT) {
                              $trace = str_replace('#', '</br>#', $exc->getTraceAsString());
                              self::$_view->assign('ADVANCED', self::advanced($exc->getFile(), $exc->getLine(), $trace));
                    }
                    self::$_view->renderizar();
                    die();
          }

          public static function unknown_handler($exc) {
                    self::$_view->load('unknown', FALSE);
                    self::$_view->setJs(array('test'));
                    self::$_view->setScript(array('test'));
                    self::$_view->setCss(array('test'));
                    self::$_view->assign(array('CONTENT'    => $exc->getExplicitMSG(),
                        'TITLE_NAME' => $exc->getCode()
                    ));
                    if (DEVELOPMENT_ENVIRONMENT) {
                              $trace = str_replace('#', '</br>#', $exc->getTraceAsString());
                              self::$_view->assign('ADVANCED', self::advanced($exc->getFile(), $exc->getLine(), $trace));
                    }
                    self::$_view->renderizar();
                    die();
          }

          private static function advanced($file = 'unknown', $line = 0, $trace = 'NULL') {
                    $_view = new View(new Request(), 'ErrorHandler');
                    $_view->load('advanced', FALSE);
                    $_view->assign(array('FILE'  => $file,
                        'LINE'  => $line,
                        'TRACE' => $trace));
                    return $_view->renderizar(false);
          }

}

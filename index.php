<?php

/**
 * -----------------------------------------------------------------------------
 * XWork Framework
 * -----------------------------------------------------------------------------
 * @author      Marcel Rojas Abarca <marcelrojas16@gmail.com>
 * @github      https://github.com/mrojas16
 * @package  XWork
 *
 * @copyright   (c) 2014 Marcel Rojas Abarca <http://github.com/mrojas16>
 * @license     [pordefinir]
 * -----------------------------------------------------------------------------
 *
 * @name        index.php
 * @desc        Arranque inicial del Sistema
 *
 */

namespace XWork;

use \Exception as PHPException;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP', ROOT . 'app' . DS);
define('EXCEPTIONS', ROOT . 'exceptions' . DS);
define('XWORK', ROOT . 'core' . DS);
define('DBCONNECTORS', ROOT . 'database' . DS);
define('INTERFACES', ROOT . 'interfaces' . DS);
define('CONFIGS', ROOT . 'config' . DS);

final class index {

          private static $_conf;

          private function __construct() {
                    
          }

          public static function init() {
                    self::getConfigs();
                    self::getInterfaces();
                    self::getCore();
                    self::getExceptions();
                    self::getDBConnectors();
                    try {
                              Bootstrap::run(new Request);
                              Session::init();
                    } catch (BootstrapException $exc) {
                              Errors::launch($exc);
                    } catch (Exception $exc) {
                              Errors::launch($exc);
                    }
          }

          public static function conf() {
                    if (self::$_conf === NULL) {
                              self::$_conf = new Config;
                    }
                    return self::$_conf;
          }

          private static function getCore() {
                    try {
                              self::verify(XWORK, 'Exceptions.php');
                              self::verify(XWORK, 'Errors.php');
                              self::verify(XWORK, 'Bootstrap.php');
                              self::verify(XWORK, 'Request.php');
                              self::verify(XWORK, 'Session.php');
                              self::verify(XWORK, 'Controller.php');
                              self::verify(XWORK, 'Model.php');
                              self::verify(XWORK, 'Helper.php');
                              self::verify(XWORK, 'DatabaseManager.php');
                              self::verify(XWORK, 'DatabaseConfig.php');
                              self::verify(XWORK, 'View.php');
                              self::verify(XWORK, 'DOM.php');
                              self::verify(XWORK, 'Misc.php');
                              self::verify(XWORK, 'Translator.php');
                              self::verify(XWORK, 'Log.php');
                    } catch (PHPException $exc) {
                              self::exception_error_printer($exc);
                    }
          }

          private static function getDBConnectors() {
                    try {
                              self::verify(DBCONNECTORS, 'MySQLConnector.php');
                              self::verify(DBCONNECTORS, 'MySQLiConnector.php');
                    } catch (PHPException $exc) {
                              self::exception_error_printer($exc);
                    }
          }

          private static function getInterfaces() {
                    try {
                              self::verify(INTERFACES, 'database.interface.php');
                              self::verify(INTERFACES, 'controller.interface.php');
                              self::verify(INTERFACES, 'model.interface.php');
                              self::verify(INTERFACES, 'helper.interface.php');
                    } catch (PHPException $exc) {
                              self::exception_error_printer($exc);
                    }
          }

          public static function getExceptions() {
                    try {
                              self::verify(EXCEPTIONS, 'BootstrapException.php');
                              self::verify(EXCEPTIONS, 'HelperException.php');
                              self::verify(EXCEPTIONS, 'ServerException.php');
                              self::verify(EXCEPTIONS, 'ControllerException.php');
                              self::verify(EXCEPTIONS, 'ViewException.php');
                              self::verify(EXCEPTIONS, 'ModelException.php');
                              self::verify(EXCEPTIONS, 'DatabaseException.php');
                    } catch (PHPException $exc) {
                              Errors::launch($exc);
                    }
          }

          public static function getConfigs() {
                    try {
                              self::verify(XWORK, 'Config.php');
                              self::verify(CONFIGS, 'database.php');
                              self::verify(CONFIGS, 'constant.php');
                              self::verify(CONFIGS, 'misc.php');
                    } catch (PHPException $exc) {
                              Errors::launch($exc);
                    }
          }

          private static function verify($dir, $file) {
                    if (file_exists($dir . $file)) {
                              require_once $dir . $file;
                    } else {
                              throw new PHPException('Error al intentar cargar el modulo "' . str_replace('.php', '', $file) . '" no se ha encontrado o no existe! es necesario para iniciar los servicios, contacte a su administrador<br />');
                    }
          }

          public static function exception_error_printer($exc) {
                    echo '<pre>';
                    die(print_r($exc));
          }

          public static function benchmark($html = false) {
                    $tiempo_fin = self::getmicrotime();   
                    $tiempo_total = round($tiempo_fin - START_TIME,3);
                    if ($html) {
                              return '<!-- Generado en ' . $tiempo_total . ' segundos -->';
                    } else {
                              return $duration;
                    }
                    return $duration;
          }
          
          public static function getmicrotime() {
                    list($usec, $sec) = explode(" ", microtime());
                    return ((float) $usec + (float) $sec);
          }

          public static function powerby() {
                    return 'Powered by <a href="http://www.xwork.com/">XWork Framework</a>.';
          }

          public static function version() {
                    return '0.4.1';
          }
          
          public function __clone() {
                    try{
                              throw new BootstrapException('Clone no esta Permitido!');
                    } catch (BootstrapException $ex) {
                              die($ex->getMessage());
                    }
          }

}

index::init();

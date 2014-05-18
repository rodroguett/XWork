<?php

if (!defined('XWORK'))
          exit('ERROR: No se puede lanzar Directamente');

/**
 * Controles miscelaneos de la aplicacion
 * 
 * @category   configuraciones
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.8
 */
if (DEVELOPMENT_ENVIRONMENT) {
          ini_set('display_errors', 1);
          error_reporting(E_ALL);
          ini_set('error_reporting', E_ALL);
} else {
          ini_set('display_errors', 1);
          error_reporting(E_ALL ^ E_NOTICE);
          ini_set('error_reporting', E_ALL ^ E_NOTICE);
} 
date_default_timezone_set(TIMEZONE);
setlocale(LC_ALL, "es_CL");


function myErrorHandler($errno, $errstr, $errfile, $errline) {
          if (!(error_reporting() & $errno) || !(DEVELOPMENT_ENVIRONMENT)) {
                    // This error code is not included in error_reporting
                    return;
          }

          switch ($errno) {
                    case 2:
                              echo "<b>ERROR - Warning:</b> [$errno] $errstr<br />\n";
                              break;

                    case 8:
                              echo "<b>ERROR - Notice: </b> [$errno] $errstr<br />\n";
                              break;

                    case 4096:
                              echo "<b>ERROR - Catchable Fatal Error: </b> [$errno] $errstr<br />\n";
                              break;

                    default:
                              echo "<b>ERROR - Unknown: </b> [$errno] $errstr<br />\n";
                              break;
          }

          /* Don't execute PHP internal error handler */
          return true;
}



$old_error_handler = set_error_handler("myErrorHandler");
//set_error_handler(array(&$this, "handleError"));

//set_exception_handler(array("\XWork\Errors", "unknown_handler"));


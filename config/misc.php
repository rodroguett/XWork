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


if(DEVELOPMENT_ENVIRONMENT){
          ini_set('display_errors', 1);
          error_reporting (E_ALL);
          ini_set('error_reporting', E_ALL);
} else {
          ini_set('display_errors', 0);
          error_reporting (E_ALL);
          ini_set('error_reporting', E_ALL);
}
date_default_timezone_set(TIMEZONE);
setlocale(LC_ALL,"es_CL");

//set_exception_handler(array("\XWork\Errors", "unknown_handler"));


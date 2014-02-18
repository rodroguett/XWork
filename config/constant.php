<?php

/** Configuration Variables **/

/**
 * Define si esta en desarrollo (TRUE) o en produccion(FALSE)
 */
define('DEVELOPMENT_ENVIRONMENT',true);

/**
 * Define la zona horaria <https://php.net/manual/es/timezones.php>
 */
define('TIMEZONE','America/Santiago');

/**
 * No cambiar,, arranque del benchmark
 */
define('START_TIME', XWork\index::getmicrotime());

/**
 * Permite definir el Lugar donde se encuentran los Controladores de la Aplicacion
 */
define('CONTROLLERS', APP . 'controllers' . DS);

/**
 * Permite definir el Lugar donde se encuentran las vistas de la Aplicacion
 */
define('VIEWS', APP . 'views' . DS);

/**
 * Permite definir el Lugar donde se encuentran los modelos de la Aplicacion
 */
define('MODELS', APP . 'models' . DS);

/**
 * Permite definir el Lugar donde se encuentran los modulos de la Aplicacion
 */
define('MODULOS', ROOT . 'modules' . DS);

/**
 * Permite definir el Lugar donde se encuentran los helpers de la Aplicacion
 */
define('HELPERS', ROOT . 'helpers' . DS);

/**
 * Permite definir el Lugar donde se encuentran el Layout de la Aplicacion
 */
define('LAYOUTS', ROOT . 'layout' );



/**
 * Permite definir cual es el controlador por defecto
 */
define('DEFAULT_CONTROLLER', 'index');
/**
 * Permite definir cual es el controlador del Login
 */
 define('DEFAULT_LOGIN', 'login');
/**
 * Permite definir cual es el controlador del Logout
 */
define('DEFAULT_LOGOUT', 'logout');
/**
 * Permite definir cual es el controlador de errores, para los handlers
 */
define('DEFAULT_ERROR', 'error');
/**
 * Permite definir cual es la variable de sesion donde se guardan los permisos del usuario, si es que aplica
 */
define('DEFAULT_USER_PERMISOS', 'usr_permisos');
/**
 * Permite definir cual es el prefijo para controladores de Ajax
 */
define('DEFAULT_AJAX_PREFIX', 'app');
/**
 * Permite definir cual es el layout Predeterminado
 */
define('DEFAULT_LAYOUT', 'xworks');
/**
 * Permite definir cual es el handler de los modulos
 */
define('DEFAULT_MODULE_HANDLER', '__handler.php');


/**
 * Define cual es la direccion donde se ejecutara el framework
 */
define('BASE_URL', 'http://codestore.cod/X-Frame2/');
/*
 * Define El tiempo predeterminado de Session en minutos
 */
define('SESSION_TIME',5);


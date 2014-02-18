<?php

namespace XWork\Helpers;

if (!defined('XWORK'))
          exit('ERROR: No se puede lanzar Directamente');

/**
 * Interface que define a todos los helpers
 * 
 * @category   controllers
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.8
 */

interface helper {
          
          public function __construct();
          public function index();
}

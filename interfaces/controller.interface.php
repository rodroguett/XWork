<?php

namespace XWork\Controllers;

if (!defined('XWORK'))
          exit('ERROR: No se puede lanzar Directamente');

/**
 * Interface que define a todos los controladores
 * 
 * @category   controllers
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.8
 */

interface controller {
          
          public function __construct();
          public function index();
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace XWork\Controllers;

use \XWork\Controller as Controller;

class indexController extends Controller {
          
          public function __construct() {
                    parent::__construct();
          }
          
          public function index() {
                    echo 'Hola Mundo desde un Modulo';
          }
          
}

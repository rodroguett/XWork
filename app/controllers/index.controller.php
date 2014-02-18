<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author mrojas
 */

namespace XWork\Controllers;

use \XWork\Controller as Controller;

class indexController extends Controller {
          
          public function __construct() {
                    parent::__construct();
          }
          
          public function index() {
                    $h = $this->loadHelper('fecha');
                    $this->_view->load();
                    $this->_view->assign('TEST','Prueba terminada');
                    $this->_view->assign('CANCINO','Daniel');
                    $this->_view->setScript(array('example'));
                    $this->_view->renderizar();
                    
          }
          
          public function model(){
                    $m = $this->loadModel('item');
                    $t = "";
                    $b = $m->getAllCities();
                    $this->_view->load('model');
                    for($i=0;$i<count($b);$i++){
                              $ares = $b[$i];
                              $t .= $ares->name . '</br>';
                    }
                    $this->_view->assign(array('TEST'=>$t,'TITLE'=>  $this->_request->getMetodo()));
                    $this->_view->renderizar();
          }
          
}

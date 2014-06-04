<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace XWork\Controllers;

/**
 * Description of administrador
 *
 * @author rodroguett
 */
class administradorController extends \XWork\Controller{
    
    private $userDatos;
    
    public function __construct() {
            parent::__construct();                    
            $this->userDatos = $this->loadModel('admin');
    }
    
    public function index() {
        $this->_view->load('index', false);
        echo 'index';
        $this->_view->renderizar();

    }

    public function usuarios() {
        $this->_view->load('usuarios', false);
        $this->_view->hola = $this->userDate->getUsuario();
        $this->_view->renderizar();
    }
    
}
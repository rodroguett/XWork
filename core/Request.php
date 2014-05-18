<?php

namespace XWork;

if (!defined('XWORK')) {
          exit('ERROR: No se puede lanzar Directamente');
}

/**
 * Gestiona los request
 * 
 * @category   core
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.3
 * @since version 0(0.12)
 */


class Request {

          private $_modulo;
          private $_controlador;
          private $_metodo;
          private $_argumentos;

          public function __construct() {
                    if (isset($_GET['request'])) {
                              $u                  = filter_input(INPUT_GET, 'request', FILTER_SANITIZE_URL);
                              $ur                 = explode('/', $u);
                              $url                = array_filter($ur);
                              $this->_controlador = strtolower(array_shift($url));

                              if (!$this->_controlador) {
                                        $this->_controlador = DEFAULT_CONTROLLER;
                              } else {
                                        $aux = explode('.', $this->_controlador);
                                        if(count($aux)==2){
                                                  $this->_controlador = $aux[1];
                                                  $this->_modulo = $aux[0];
                                        } else {
                                                  $this->_modulo = FALSE;
                                        }
                              }

                              $this->_metodo     = strtolower(array_shift($url));
                              $this->_argumentos = $url;
                    }

                    if (!$this->_controlador) {
                              $this->_controlador = DEFAULT_CONTROLLER;
                    }

                    if (!$this->_metodo) {
                              $this->_metodo = 'index';
                    }

                    if (!isset($this->_argumentos)) {
                              $this->_argumentos = array();
                    }
          }

          public function getModulo() {
                    return $this->_modulo;
          }

          public function getControlador() {
                    return $this->_controlador;
          }

          public function getMetodo() {
                    return $this->_metodo;
          }

          public function getArgs($index = false) {
                    if(is_int($index)){
                              if(isset($this->_argumentos[$index])){
                                        return $this->_argumentos[$index];
                              } else {
                                        return false;
                              }
                    } else {
                              return $this->_argumentos;
                    }
                              
          }

}

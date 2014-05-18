<?php

namespace XWork\Helpers;

use XWork\Helper as Hlp;

/**
 * Helper de funciones de fechas
 * 
 * @category   controllers
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.7
 */
class strHelper extends Hlp {

          public function __construct() {
                    parent::__construct();
          }

          public function index() {
                    
          }

          public function recortar_texto($texto, $limite = 100) {
                    $texto     = trim($texto);
                    $texto     = strip_tags($texto);
                    $tamano    = strlen($texto);
                    $resultado = '';
                    if ($tamano <= $limite) {
                              return $texto;
                    } else {
                              $texto     = substr($texto, 0, $limite);
                              $palabras  = explode(' ', $texto);
                              $resultado = implode(' ', $palabras);
                              $resultado .= '...';
                    }
                    return $resultado;
          }

}

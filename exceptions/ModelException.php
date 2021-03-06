<?php

namespace XWork\Excepciones;

if (!defined('XWORK')) {
          exit('ERROR: No se puede lanzar Directamente');
}

/**
 * -----------------------------------------------------------------------------
 * XWork Framework
 * -----------------------------------------------------------------------------
 * @author          Marcel Rojas Abarca <marcelrojas16@gmail.com>
 * @github          https://github.com/mrojas16
 * @package      XWork
 *
 * @copyright    Copyright (c) 2014 Marcel Rojas Abarca <http://github.com/mrojas16>
 * @license         [pordefinir]
 * 
 * @version         0.5b
 * -----------------------------------------------------------------------------
 *
 * @abstract 
 * @name            ModelException.php
 * @abstract      Gestion de errores para el modelo
 *
 */


class ModelException extends XWorkException{

          public function __construct($message, $code = 0, $previous = null) {
                    parent::__construct($message, $code, $previous);
          }
          
          public function __toString() {
                    return $this->getMessage();
          }
}

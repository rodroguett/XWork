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
 * @name            Exception.php
 * @abstract       Excepciones BASE
 *
 */


use \Exception as Exception;

class XWorkException extends Exception {

          public function __construct($message, $code = NULL, $previous = NULL) {
                    parent::__construct($message, $code, $previous);
          }

          public function __toString() {
                    return "Code: " . $this->getCode() . "<br />Message: " .
                            htmlentities($this->getMessage());
          }

          public function getException() {
                    return $this;
          }

          public static function getStaticException($exception) {
                    $exception->getException();
          }

          public function getExplicitMSG() {
                    return 'Error : ' . $this->getMessage();
          }

}

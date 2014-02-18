<?php

namespace XWork;

if (!defined('XWORK')) {
          exit('ERROR: No se puede lanzar Directamente');
}

/**
 * Sistema de Controladores
 * 
 * @category   core
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    1.3
 */

use XWork\Excepciones\ModelException as ModelException;
use XWork\Excepciones\HelperException as HelperException;
use \Exception as Exception;
use XWork\Controllers\controller as controllerInterface;

abstract class Controller implements controllerInterface {

          protected $_request;
          protected $_view;

          public function __construct() {
                    $this->_request = new Request();
                    $this->_view    = new View(new Request);
          }

          public abstract function index();

          protected function loadModel($model) {
                    $ruta = MODELS . $model . '.model.php';
                    try {
                              if (is_file($ruta)) {
                                        if (is_readable($ruta)) {
                                                  $class = '\XWork\Models\\' . $model . 'Model';
                                                  require_once $ruta;
                                                  return new $class;
                                        } else {
                                                  throw new ModelException('El modelo: <b>' . $model . '</b> no es accesible!');
                                        }
                              } else {
                                        throw new ModelException('El modelo: <b>' . $model . '</b> no existe!');
                              }
                    } catch (ModelException $exc) {
                              Errors::launch($exc);
                    } catch (Exception $exc) {
                              Errors::launch($exc);
                    }
          }

          protected function loadHelper($helper) {
                    $ruta = HELPERS . $helper . '.helper.php';
                    try {
                              if (is_file($ruta)) {
                                        if (is_readable($ruta)) {
                                                  $class = '\XWork\Helpers\\' . $helper . 'Helper';
                                                  require_once $ruta;
                                                  return new $class;
                                        } else {
                                                  throw new HelperException('El Helper: <b>' . $helper . '</b> no es accesible!');
                                        }
                              } else {
                                        throw new HelperException('El Helper: <b>' . $helper . '</b> no existe!');
                              }
                    } catch (HelperException $exc) {
                              Errors::launch($exc);
                    } catch (\Exception $exc) {
                              Errors::launch($exc);
                    }
          }
          
          protected function createNewInstanceOfView($handler = False){
                    return new View(new Request, $handler);
          }
          
          protected function redireccionar($where = ''){
                    header('Location:'.BASE_URL.$where);
                    exit;
          }

}

<?php
namespace XWork;

use XWork\Helpers\helper as helperInterface;
use XWork\Excepciones\LibsException as LException;

/**
 * Description of Helper
 *
 * @author mrojas
 */
abstract class Helper implements helperInterface{
          
          public function __construct() {
                    
          }
          
          protected function loadLib($name) {
                    $ruta = LIBS . $name;
                    try {
                              if (is_file($ruta)) {
                                        if (is_readable($ruta)) {
                                                  require_once $ruta;
                                        } else {
                                                  throw new LException('La Libreria: <b>' . $name . '</b> no es accesible!');
                                        }
                              } else {
                                        throw new LException('La Libreria: <b>' . $name . '</b> no existe!');
                              }
                    } catch (LException $exc) {
                              Errors::launch($exc);
                    } catch (\Exception $exc) {
                              Errors::launch($exc);
                    }
          }

          protected function loadModel($model) {
                    $ruta = MODELS . $model . '.model.php';
                    try {
                              if (is_file($ruta)) {
                                        if (is_readable($ruta)) {
                                                  $class = '\XWork\Models\\' . $model . 'Model';
                                                  require_once $ruta;
                                                  if(class_exists($class)){
                                                            return new $class;
                                                  } else {
                                                            throw new ModelException('El modelo: <b>' . $model . '</b> no es accesible, la clase esta mal instanciada');
                                                  }
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
}

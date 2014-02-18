<?php

namespace XWork;

if (!defined('XWORK'))
          exit('ERROR: No se puede lanzar Directamente');

/**
 * Sistema de Gestion de Vistas
 * 
 * @category   core
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    1.3
 */

use \XWork\Excepciones\ViewException as ViewException;

class View {

          private $controlador;
          private $template;
          private $_js      = array();
          private $_css     = array();
          private $_scripts = array();
          private $_handler;

          public function __construct(Request $q, $handler = FALSE) {
                    $this->_handler = $handler;
                    $this->controlador = $q->getControlador();
          }

          public function load($template = 'index', $sandwich = TRUE, $layout = DEFAULT_LAYOUT, $controller = FALSE) {
                    $header_sandwich = LAYOUTS . DS . $layout . DS . 'header.xview';
                    $footer_sandwich = LAYOUTS . DS . $layout . DS . 'footer.xview';
                    try {
                              if (!$controller) {
                                        if($this->_handler){
                                                  $controller = $this->switchHandler();//$this->_handler;
                                        } else {
                                                  $controller = $this->controlador;
                                        }
                              }
                              $ruta = VIEWS . $controller . DS . $template . '.xview';

                              if (is_readable($ruta)) {
                                        if ($sandwich) {
                                                  if (file_exists($header_sandwich) and file_exists($footer_sandwich)) {
                                                            echo $this->build($header_sandwich, $footer_sandwich, $ruta);
                                                  } else {
                                                            throw new ViewException('Error de template (<b>No se han encontrado los archivos principales de las plantillas</b>)', 1);
                                                  }
                                        } else {
                                                  echo $this->build(FALSE, FALSE, $ruta);
                                        }
                              } else {
                                        throw new ViewException('Vista No Encontrada("' . $ruta . '"), Imposible renderizar la Aplicacion', 2);
                              }
                    } catch (ViewException $exc) {
                              $this->handle_exception($exc);
                    }
          }
          
          public function loadAjax($template = 'index',$layout = DEFAULT_LAYOUT, $controller = FALSE){
                    $this->load($template, false, $layout, $controller);
          }

          private function handle_exception($exc) {
                    echo '<pre>';
                    die(print_r($exc));
          }

          private function build($header_sandwich, $footer_sandwich, $ruta) {
                    $hs = '';
                    $fs = '';
                    if ($header_sandwich) {
                              $hs = file_get_contents($header_sandwich);
                    }
                    if ($footer_sandwich) {
                              $fs = file_get_contents($footer_sandwich);
                    }
                    $r              = file_get_contents($ruta);
                    $this->template = $hs . $r . $fs;
          }

          public function assign($var, $content = '') {
                    if (is_array($var)) {
                              foreach ($var as $key => $value) {
                                        if (!is_array($value)) {
                                                  $this->template = str_replace("[:" . $key . ":]", $value, $this->template);
                                        }
                              }
                    } else {
                              $this->template = str_replace("[:" . $var . ":]", $content, $this->template);
                    }
          }

          private function removeEmpty() {
                    $this->template = preg_replace('^\[:.*:\]^', "", $this->template);
          }

          public function renderizar($bool = true) {
                    $this->loadScripts('_js','__PLUGIN_JS');
                    $this->loadScripts('_scripts', '__SCRIPTS_JS');
                    $this->loadScripts('_css', '__STYLE_SHEETS');
                    $this->loadConstats();
                    $this->removeEmpty();
                    if($bool) {
                              eval ("?>" . $this->template . "<?");
                              die();
                    } else {
                              return $this->template;
                    }
          }
          
          private function loadScripts($var,$to) {
                    if(count($this->{$var})){
                              $r = '';
                              for ($i = 0; $i < count($this->{$var}); $i++) {
                                        $r .= '<script  type="text/javascript" src="' . $this->{$var}[$i] . '"></script>'; 
                              }
                              $this->template = str_replace("[:" . $to . ":]", $r, $this->template);
                    }
          }

          public function setJs(array $js, $layout = DEFAULT_LAYOUT) {
                    try {
                              if (is_array($js) && count($js)) {
                                        for ($i = 0; $i < count($js); $i++) {
                                                  array_push($this->_js, BASE_URL . 'layout/' . $layout . '/js/' . $js[$i] . '.js');
                                        }
                              } else {
                                        throw new ViewException('Error de js', 3);
                              }
                    } catch (ViewException $exc) {
                              $this->handle_exception($exc);
                    }
          }

          public function setCss(array $js, $layout = DEFAULT_LAYOUT) {
                    try {
                              if (is_array($js) && count($js)) {
                                        for ($i = 0; $i < count($js); $i++) {
                                                  array_push($this->_js, BASE_URL . 'layout/' . $layout . '/css/' . $js[$i] . '.js');
                                        }
                              } else {
                                        throw new ViewException('Error de js', 3);
                              }
                    } catch (ViewException $exc) {
                              $this->handle_exception($exc);
                    }
          }

          public function setScript(array $js) {
                    try {
                              if (is_array($js) && count($js)) {
                                        for ($i = 0; $i < count($js); $i++) {
                                                  array_push($this->_scripts, BASE_URL . 'scripts/' . $js[$i] . '.js');
                                        }
                              } else {
                                        throw new ViewException('Error de js', 4);
                              }
                    } catch (ViewException $exc) {
                              $this->handle_exception($exc);
                    }
          }

          public function loadConstats() {
                    $this->assign('__BASE_URL',BASE_URL);
                    $this->assign('__POWEREDBY',  index::powerby());
                    $this->assign('__BENCHMARK',  index::benchmark(TRUE));
          }

          private function switchHandler() {
                    switch ($this->_handler) {
                              case 'ErrorHandler': return 'error';
                              default: return 'index';
                    }
          }

}

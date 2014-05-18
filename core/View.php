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
          private $_staticResources;
          private $statusTitle = false;

          public function __construct(Request $q, $handler = FALSE, $staticResources = FALSE) {
                    $this->_handler = $handler;
                    $this->_staticResources = $staticResources;
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
                              if(!$this->_staticResources){
                                        $ruta = VIEWS . $controller . DS . $template . '.xview';
                              } else {
                                        $ruta = $template;
                              }

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
                              Errors::launch($exc);
                    } catch (\Exception $exc) {
                              Errors::launch($exc);
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
                                                  if($value!=""){
                                                            $this->template = preg_replace('^\[IF\[:'. $key . ':\]THEN\[\?(.*)\?\]OR\[\?.*\?\]\|\]^', '${1}',$this->template);
                                                            $this->template = str_replace("[:" . $key . ":]", $value, $this->template);
                                                  }
                                        }
                              }
                    } else {
                              if($content!=""){
                                        $this->template = preg_replace('^\[IF\[:'. $var . ':\]THEN\[\?(.*)\?\]OR\[\?(.*)\?\]ENDIF\]^', '${1}',$this->template);
                                        $this->template = str_replace("[:" . $var . ":]", $content, $this->template);
                              }
                    }
          }

          private function removeEmpty() {
                    $this->template = preg_replace('^\[IF\[:.*:\]THEN\[\?.*\?\]OR\[\?(.*)\?\]ENDIF\]^', '${1}', $this->template);
                    $this->template = preg_replace('^\[:.*:\]^', "", $this->template);
          }

          public function renderizar($bool = true) {
                    $this->loadScripts('_js','__PLUGIN_JS');
                    $this->loadScripts('_scripts', '__SCRIPTS_JS');
                    $this->loadScripts('_css', '__STYLE_SHEETS');
                    $this->loadConstants();
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
          
          public function assignTitle($title) {
                    if(!$this->statusTitle){
                              $this->assign('__MAIN_TITLE', APP_NAME_TITLE.' '.APP_NAME_TITLE_SEPARATOR.' '.$title);
                              $this->statusTitle = TRUE;
                    }
          }

          private function loadConstants() {
                    $t = BASE_URL . 'layout' . '/' . DEFAULT_LAYOUT . '/';
                    if(!$this->statusTitle){
                              $this->assign('__MAIN_TITLE', APP_NAME_TITLE);
                              $this->statusTitle = true;
                    }
                    $this->assign('__BASE_URL',BASE_URL);
                    $this->assign('__POWEREDBY',  index::powerby());
                    $this->assign('__BENCHMARK',  index::benchmark(TRUE));
                    $this->assign('__TPL_JS', $t.'js/');
                    $this->assign('__TPL_CSS', $t.'css/');
                    $this->assign('__TPL_IMG', $t.'img/');
                    $this->assign('__TODAY', date('d-m-Y'));
                    
          }

          private function switchHandler() {
                    switch ($this->_handler) {
                              case 'ErrorHandler': return 'error';
                              case 'MenuHandler': return 'menu';
                              default: return 'index';
                    }
          }
          
          public function loadJavascriptScript($dir) {
                    $fdr = ROOT . 'scripts/' . $dir . '.js';
                    $v = new View(new Request(), TRUE, TRUE);
                    $v->loadAjax($fdr, DEFAULT_LAYOUT, "staticResources");
                    $n = $v->renderizar(false);
                    $src = "<script type=\"text/javascript\">" . $n . "</script>";
                    return $src;
          }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of error
 *
 * @author mrojas
 */

namespace XWork\Controllers;

use \XWork\Controller as Controller;
use \XWork\Errors as Errors;
use \XWork\Excepciones\ServerException as ServerException;
use \XWork\Excepciones\ModelException as ModelException;
use \XWork\Excepciones\ViewException as ViewException;
use \XWork\Excepciones\ControllerException as ControllerException;
use \XWork\Excepciones\BootstrapException as BootstrapException;
use \XWork\Excepciones\XWorkException as XWorkException;

class errorController extends Controller {

          public function __construct() {
                    parent::__construct();
          }

          public function index() {
                    try {
                              switch ($this->_request->getMetodo()) {
                                        case '404': throw new ServerException('Pagina No Encontrada',404);
                                        case '500': throw new ServerException('Internal Server Error',500);
                                        default: throw new XWorkException('Error Desconocido',-1);
                              }
                    } catch (XWorkException $exc) {
                              Errors::launch($exc);
                    } catch (BootstrapException $exc){
                              Errors::launch($exc);
                    } catch (ControllerException $exc){
                              Errors::launch($exc);
                    } catch (ServerException $exc){
                              Errors::launch($exc);
                    } catch (ModelException $exc){
                              Errors::launch($exc);
                    } catch (ViewException $exc){
                              Errors::launch($exc);
                    } catch (\Exception $exc){
                              Errors::launch($exc);
                    }
          }

}

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

use \XWork\Controller as ctrl;
use XWork\Errors as err;
use \XWork\Excepciones\ServerException as SrvException;
use \XWork\Excepciones\ModelException as MdlException;
use \XWork\Excepciones\ViewException as VwException;
use \XWork\Excepciones\ControllerException as CtrlException;
use \XWork\Excepciones\BootstrapException as BootException;
use \XWork\Excepciones\XWorkException as XWException;

class errorController extends ctrl {

          public function __construct() {
                    parent::__construct();
          }

          public function index() {
                    try {
                              switch ($this->_request->getMetodo()) {
                                        case '404': throw new SrvException('Pagina No Encontrada',404);
                                        case '500': throw new SrvException('Internal Server Error',500);
                                        default: throw new XWException('Error Desconocido',-1);
                              }
                    } catch (XWException $exc) {
                              err::launch($exc);
                    } catch (BootException $exc){
                              err::launch($exc);
                    } catch (CtrlException $exc){
                              err::launch($exc);
                    } catch (SrvException $exc){
                              err::launch($exc);
                    } catch (MdlException $exc){
                              err::launch($exc);
                    } catch (VwException $exc){
                              err::launch($exc);
                    } catch (\Exception $exc){
                              err::launch($exc);
                    }
          }

}

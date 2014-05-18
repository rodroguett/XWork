<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menu
 *
 * @author mrojas
 */

namespace XWork\Controllers;

use \XWork\Controller as Ctrl;
use XWork\Session as ses;

class menuController extends Ctrl {
          
          private $_stm;
          private $_routines;
          private $_userRole;
          
          public function __construct() {
                    parent::__construct();
                    $this->_routines = $this->loadModel('routines');
          }
          
          public function index() {
                    $this->_stm = $this->_routines->getAllMenu();
                    switch (ses::get('perfil')) {
                              case 'administrador':$this->_userRole = 1;break;
                              case 'responsable':$this->_userRole = 2;break;
                              case 'excavador':$this->_userRole = 3;break;
                              default:$this->_userRole = 0; break;
                    }
                    $_view = new \XWork\View(new \XWork\Request(),'MenuHandler');
                    $_view->load('menu',FALSE, DEFAULT_LAYOUT, 'menu');
                    $name = \XWork\Session::get('nombre'). ' ' . \XWork\Session::get('apellido');
                    $_view->assign('USERNAME',$name);
                    $_view->assign('BODY_ALL_MENU',  $this->getBody());
                    return $_view->renderizar(false);
                    
          }
          
          private function getBody(){
                    $r = '';
                    for ($i = 0; $i < count($this->_stm); $i++) {
                              $ares = $this->_stm[$i];
                              if($this->_userRole == 1){
                                        if($ares->idpadre == 0){
                                                  $r .= '<li>';
                                                  if($ares->hijos == 1){
                                                            $r .= '<a href="#" title="' . $ares->nombre . '"  aria-id="' . $ares->idmenu . '"><i class="fa fa-lg fa-fw ' . $ares->clase . '"></i> <span class="menu-item-parent">' . $ares->nombre . '</span></a>';
                                                            $r .= '<ul>';
                                                            $r .= $this->getHijos($ares->idmenu,$ares->href);
                                                            $r .= '</ul>';
                                                  } else {
                                                            $r .='<a href="' . $ares->href . '" title="' . $ares->nombre . '" aria-id="' . $ares->idmenu . '">'
                                                                    . '<i class="fa fa-lg fa-fw ' . $ares->clase . '"></i> <span class="menu-item-parent">' . $ares->nombre . '</span>'
                                                                    . '</a>';
                                                  }
                                                  $r .= '</li>';
                                        }
                              } else if($this->_userRole == 2){
                                        if($ares->rol == 2){
                                                  if($ares->idpadre == 0){
                                                            $r .= '<li>';
                                                            if($ares->hijos == 1){
                                                                      $r .= '<a href="#" title="' . $ares->nombre . '"  aria-id="' . $ares->idmenu . '"><i class="fa fa-lg fa-fw ' . $ares->clase . '"></i> <span class="menu-item-parent">' . $ares->nombre . '</span></a>';
                                                                      $r .= '<ul>';
                                                                      $r .= $this->getHijos($ares->idmenu,$ares->href);
                                                                      $r .= '</ul>';
                                                            } else {
                                                                      $r .='<a href="' . $ares->href . '" title="' . $ares->nombre . '" aria-id="' . $ares->idmenu . '">'
                                                                              . '<i class="fa fa-lg fa-fw ' . $ares->clase . '"></i> <span class="menu-item-parent">' . $ares->nombre . '</span>'
                                                                              . '</a>';
                                                            }
                                                            $r .= '</li>';
                                                  }
                                        }
                              } else if($this->_userRole == 3){
                                        if($ares->rol == 3){
                                                  if($ares->idpadre == 0){
                                                            $r .= '<li>';
                                                            if($ares->hijos == 1){
                                                                      $r .= '<a href="#" title="' . $ares->nombre . '"  aria-id="' . $ares->idmenu . '"><i class="fa fa-lg fa-fw ' . $ares->clase . '"></i> <span class="menu-item-parent">' . $ares->nombre . '</span></a>';
                                                                      $r .= '<ul>';
                                                                      $r .= $this->getHijos($ares->idmenu,$ares->href);
                                                                      $r .= '</ul>';
                                                            } else {
                                                                      $r .='<a href="' . $ares->href . '" title="' . $ares->nombre . '" aria-id="' . $ares->idmenu . '">'
                                                                              . '<i class="fa fa-lg fa-fw ' . $ares->clase . '"></i> <span class="menu-item-parent">' . $ares->nombre . '</span>'
                                                                              . '</a>';
                                                            }
                                                            $r .= '</li>';
                                                  }
                                        }
                              }
                    }
                    return $r;
          }
          
          public function getHijos($id,$href) {
                    $r = '';
                    for ($i = 0; $i < count($this->_stm); $i++) {
                              $ares = $this->_stm[$i];
                              if($ares->idpadre == $id){
                                        $r .= '<li>';
                                        if($ares->hijos == 1){
                                                  $r .= '<a href="#" title="' . $ares->nombre . '"  aria-id="' . $ares->idmenu . '">' . $ares->nombre . '</a>';
                                                  $r .= '<ul>';
                                                  $r .= $this->getHijos($ares->idmenu,$href);
                                                  $r .= '</ul>';
                                        } else {
                                                  $r .= '<a href="' . $href . '/' . $ares->href . '" title="' . $ares->nombre . '"  aria-id="' . $ares->idmenu . '">' . $ares->nombre . '</a>';
                                        }
                                        $r .= '</li>';
                              }
                    }
                    return $r;
          }
          
}

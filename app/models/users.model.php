<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace XWork\Models;

use XWork\Model as mdl;

/**
 * Description of users
 *
 * @author michael
 */
class UsersModel extends mdl {

          public function save_user($p) {
                    if ($p['profile'] == 'responsable') {
                              if (count($p['cboxBiz']) == 0) {
                                        return 0;
                              }
                    }
                    $fname = $this->_database->_sanitize($p['fname']);
                    $lname = $this->_database->_sanitize($p['lname']);
                    $email = $this->_database->_sanitize($p['email']);
                    $phone = $this->_database->_sanitize($p['phone']);
                    if (isset($p['password'])) {
                              $password = md5($p['password']);
                    } else {
                              $password = "";
                    }
                    $profile = $this->_database->_sanitize($p['profile']);
                    $cargo   = $this->_database->_sanitize($p['cargo']);

                    $this->_database->_query("SET @aVfname = '" . $fname . "'");
                    $this->_database->_query("SET @aVlname = '" . $lname . "'");
                    $this->_database->_query("SET @aVemail = '" . $email . "'");
                    $this->_database->_query("SET @aVphone = '" . $phone . "'");
                    $this->_database->_query("SET @aVpassword = '" . ($password) . "'");
                    $this->_database->_query("SET @aVprofile = '" . $profile . "'");
                    $this->_database->_query("SET @aVcargo = '" . $cargo . "'");
                    $this->_database->_query("SET @oVuserID = 0");
                    $this->_database->_query("CALL `" . DB_NAME . "`.`saveUser`(@aVfname, @aVlname, @aVemail, @aVphone, @aVpassword, @aVprofile, @aVcargo, @oVuserID)");
                    $this->_database->_query("SELECT @oVuserID AS lastID");
                    $a = $this->_database->_fetchObject();
                    $r = $a[0]->lastID;
                    if ($p['profile'] == 'responsable') {
                              $ty = $p['cboxBiz'];
                              if (count($ty)) {
                                        $this->_database->_query("SET @aVidUser = '" . $r . "'");
                                        for ($i = 0; $i < count($ty); $i++) {
                                                  $ares = $ty[$i];
                                                  $tt   = explode('%%', $ares);
//                                                  print_r($tt);
//                                                  die();
                                                  $ide  = $tt[0];
                                                  $idr  = $tt[1];
                                                  $this->_database->_query("SET @aVidBiz = '" . $this->_database->_sanitize($ide) . "'");
                                                  $this->_database->_query("SET @aVidRegion = '" . $this->_database->_sanitize($idr) . "'");
                                                  $this->_database->_query("CALL `" . DB_NAME . "`.`addResponsable`(@aVidUser, @aVidBiz, @aVidRegion)");
                                        }
                              }
                    }
                    return $r;
          }

          public function getAllDatos($idusuario) {
                    $this->_database->_query("SET @iVidusuario = '" . $idusuario . "'");
                    $this->_database->_query("CALL `" . DB_NAME . "`.`getInfoUser`(@iVidusuario)");
                    $a = $this->_database->_fetchObject();
                    return $a[0];
          }

          public function edit_my_user($p) {
                    $fname = $this->_database->_sanitize($p['fname']);
                    $lname = $this->_database->_sanitize($p['lname']);
                    $pp    = \XWork\Session::get('perfil');

                    if ($pp == 'administrador') {
                              $email = $this->_database->_sanitize($p['email']);
                    } else {
                              $email = "";
                    }

                    $phone     = $this->_database->_sanitize($p['phone']);
                    $skype     = $this->_database->_sanitize($p['skype']);
                    $cargo     = $this->_database->_sanitize($p['cargo']);
                    $idusuario = \XWork\Session::get('idusuario');

                    if ($pp == 'administrador') {
                              $this->_database->_query("SET @iVtype = 1");
                    } else {
                              $this->_database->_query("SET @iVtype = 4");
                    }
                    $this->_database->_query("SET @aVfname = '" . $fname . "'");
                    $this->_database->_query("SET @aVlname = '" . $lname . "'");
                    $this->_database->_query("SET @aVemail = '" . $email . "'");

                    $this->_database->_query("SET @aVphone = '" . $phone . "'");
                    $this->_database->_query("SET @aVskype = '" . $skype . "'");
                    $this->_database->_query("SET @aVcargo = '" . $cargo . "'");
                    $this->_database->_query("SET @iVperfil = ''");
                    $this->_database->_query("SET @iVpassword = ''");

                    $this->_database->_query("SET @oVuserID = '" . $idusuario . "'");

                    $this->_database->_query("CALL `" . DB_NAME . "`.`editUser`(@iVtype, @aVfname, @aVlname, @aVemail, @aVphone, @aVskype, @aVcargo, @iVperfil, @iVpassword, @oVuserID)");
                    $this->_database->_query("SELECT @oVuserID AS lastID");
                    $a = $this->_database->_fetchObject();
                    $r = $a[0]->lastID;
                    return $r;
          }

          public function edit_user($p) {
                    if ($p['profile'] == 'responsable') {
                              if (count($p['cboxBiz']) == 0) {
                                        return 0;
                              }
                    }
                    $fname     = $this->_database->_sanitize($p['fname']);
                    $lname     = $this->_database->_sanitize($p['lname']);
                    $email     = $this->_database->_sanitize($p['email']);
                    $phone     = $this->_database->_sanitize($p['phone']);
                    $cargo     = $this->_database->_sanitize($p['cargo']);
                    $idusuario = $this->_database->_sanitize($p['idusuario']);
                    $profile   = $this->_database->_sanitize($p['profile']);

                    $this->_database->_query("SET @iVtype = 3");
                    $this->_database->_query("SET @aVfname = '" . $fname . "'");
                    $this->_database->_query("SET @aVlname = '" . $lname . "'");
                    $this->_database->_query("SET @aVemail = '" . $email . "'");
                    $this->_database->_query("SET @aVphone = '" . $phone . "'");
                    $this->_database->_query("SET @aVskype = ''");
                    $this->_database->_query("SET @aVcargo = '" . $cargo . "'");
                    $this->_database->_query("SET @iVperfil = '" . $profile . "'");
                    $this->_database->_query("SET @iVpassword = ''");

                    $this->_database->_query("SET @oVuserID = '" . $idusuario . "'");

                    $this->_database->_query("CALL `" . DB_NAME . "`.`editUser`(@iVtype, @aVfname, @aVlname, @aVemail, @aVphone, @aVskype, @aVcargo, @iVperfil, @iVpassword, @oVuserID)");
                    $this->_database->_query("SELECT @oVuserID AS lastID");
                    $a = $this->_database->_fetchObject();
                    $r = $a[0]->lastID;
                    if ($p['profile'] == 'responsable') {
                              $ty = $p['cboxBiz'];
                              if (count($ty)) {
                                        $this->_database->_query("SET @aVidUser = '" . $r . "'");
                                        if($this->_database->_query("CALL `" . DB_NAME . "`.`dropResponsablesU`(@aVidUser)")){
                                                  for ($i = 0; $i < count($ty); $i++) {
                                                            $ares = $ty[$i];
                                                            $tt   = explode('%%', $ares);
          //                                                  print_r($tt);
          //                                                  die();
                                                            $ide  = $tt[0];
                                                            $idr  = $tt[1];
                                                            $this->_database->_query("SET @aVidBiz = '" . $this->_database->_sanitize($ide) . "'");
                                                            $this->_database->_query("SET @aVidRegion = '" . $this->_database->_sanitize($idr) . "'");
                                                            $this->_database->_query("CALL `" . DB_NAME . "`.`addResponsable`(@aVidUser, @aVidBiz, @aVidRegion)");
                                                  }
                                        }
                              }
                    }
                    return $r;
          }

          public function edit_my_pass($p) {
                    $pass      = $p['password'];
                    $idusuario = \XWork\Session::get('idusuario');

                    $this->_database->_query("SET @iVtype = 2");
                    $this->_database->_query("SET @aVfname = ''");
                    $this->_database->_query("SET @aVlname = ''");
                    $this->_database->_query("SET @aVemail = ''");
                    $this->_database->_query("SET @aVphone = ''");
                    $this->_database->_query("SET @aVskype = ''");
                    $this->_database->_query("SET @aVcargo = ''");
                    $this->_database->_query("SET @iVperfil = ''");
                    $this->_database->_query("SET @iVpassword = '" . md5($pass) . "'");

                    $this->_database->_query("SET @oVuserID = '" . $idusuario . "'");

                    $this->_database->_query("CALL `" . DB_NAME . "`.`editUser`(@iVtype, @aVfname, @aVlname, @aVemail, @aVphone, @aVskype, @aVcargo, @iVperfil, @iVpassword, @oVuserID)");
                    $this->_database->_query("SELECT @oVuserID AS lastID");
                    $a = $this->_database->_fetchObject();
                    $r = $a[0]->lastID;
                    return $r;
          }

          public function delete($id) {
                    $this->_database->_query("SET @oVuserID = '" . $this->_database->_sanitize($id) . "'");
                    if ($this->_database->_query("CALL `" . DB_NAME . "`.`deleteUser`(@oVuserID)")) {
                              return 1;
                    } else {
                              return 0;
                    }
          }

          public function get_user($id) {
                    $this->_database->_query("SET @oVuserID = '" . $id . "'");
                    if ($this->_database->_query("CALL `" . DB_NAME . "`.`getInfoUser`(@oVuserID)")) {
                              $a = $this->_database->_fetchObject();
                              return $a[0];
                    } else {
                              return 0;
                    }
          }

          public function get_user_biz($id) {
                    $this->_database->_query("SET @oVuserID = '" . $id . "'");
                    if ($this->_database->_query("CALL `" . DB_NAME . "`.`getEmpresasUser`(@oVuserID)")) {
                              $a = $this->_database->_fetchObject();
                              $b = array();
                              for($i = 0; $i<count($a); $i++){
                                        $ares = $a[$i];
                                        foreach ($ares as $key => $value) {
                                                  array_push($b, $value);
                                        }
                              }
                              return $b;
                    } else {
                              return 0;
                    }
          }

          public function getSaltInfo($mail) {
                    $this->_database->_query("SET @iVmail = '" . $this->_database->_sanitize($mail) . "'");
                    if ($this->_database->_query("CALL `" . DB_NAME . "`.`getSalt`(@iVmail)")) {
                              $a = $this->_database->_fetchObject();
                              return $a[0];
                    } else {
                              return 0;
                    }
          }

          public function check_mail($mail) {
                    $q = "SELECT COUNT(mail) AS num FROM llae_usuario WHERE mail = '" . $mail . "' AND activo = 1";
                    $n = $this->_database->_query($q);
                    $f = $n->fetch_object();
                    echo $f->num;
          }

          public function verificarUsuario($id) {
                    $this->_database->_query("SET @iVid = '" . $this->_database->_sanitize($id) . "'");
                    if ($this->_database->_query("CALL `" . DB_NAME . "`.`verificarUsuario`(@iVid)")) {
                              return true;
                    } else {
                              return false;
                    }
          }

          public function singUp($mail, $pass) {
                    $this->_database->_query("SET @iVemail = '" . $this->_database->_sanitize($mail) . "'");
                    $this->_database->_query("SET @iVpass = '" . md5($pass) . "'");
                    $this->_database->_query("SET @iVresponse = 'Error Desconocido'");
                    if ($this->_database->_query("CALL `" . DB_NAME . "`.`singUpUser`(@iVemail,@iVpass,@iVresponse)")) {
                              $this->_database->_query("SELECT @iVresponse AS response");
                              $a = $this->_database->_fetchObject();
                              $r = $a[0]->response;
                              return $r;
                    } else {
                              return false;
                    }
          }

          /*           * ********************************************************\
           *                                      DATA TABLE                                        *
            \********************************************************* */

          public function getTable() {
                    $aColumns     = array('idusuario', 'CONCAT(nombre,\' \', apellido)', 'mail', 'date_format(fcreacion,\'%d-%m-%Y\')', 'CONCAT(UCASE(SUBSTRING(perfil, 1, 1)),SUBSTRING(perfil, 2))', 'validado');
                    $sIndexColumn = "idusuario";
                    $sTable       = DB_PRFX . "usuario";
                    $this->_database->_query("SELECT COUNT(" . $sIndexColumn . ") as num FROM   $sTable WHERE activo=1");
                    $resTot       = $this->_database->_fetchObject();
                    $iTotal1      = $resTot[0];
                    $iTotal       = $iTotal1->num;

                    $sLimit = "";
                    if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
                              $sLimit = "LIMIT " . addslashes($_GET['iDisplayStart']) . ", " .
                                      addslashes($_GET['iDisplayLength']);
                    }

                    if (isset($_GET['iSortCol_0'])) {
                              $sOrder = "ORDER BY  ";
                              for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                                        if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                                                  $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
	      			" . addslashes($_GET['sSortDir_' . $i]) . ", ";
                                        }
                              }
                              $sOrder = substr_replace($sOrder, "", -2);
                              if ($sOrder == "ORDER BY") {
                                        $sOrder = "";
                              }
                    }

                    $sWhere = "";
                    if ($_GET['sSearch'] != "") {
                              $sWhere = "WHERE (";
                              for ($i = 0; $i < count($aColumns); $i++) {
                                        $sWhere .= $aColumns[$i] . " LIKE '%" . addslashes($_GET['sSearch']) . "%' OR ";
                              }
                              $sWhere = substr_replace($sWhere, "", -3);
                              $sWhere .= ") AND activo=1";
                    } else {
                              $sWhere = " WHERE activo=1";
                    }

                    for ($i = 0; $i < count($aColumns); $i++) {
                              if ($_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                                        if ($sWhere == "") {
                                                  $sWhere = "WHERE ";
                                        } else {
                                                  $sWhere .= " AND ";
                                        }
                                        $sWhere .= $aColumns[$i] . " LIKE '%" . addslashes($_GET['sSearch_' . $i]) . "%' ";
                              }
                    }

                    $t = $this->_database->_query("
		      	SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
		      	FROM   $sTable
		      	$sWhere 
		      	$sOrder
		      	$sLimit
		      	");

                    $iFilteredTotal = $t->num_rows;

                    $output = array(
                        "sEcho"                => intval($_GET['sEcho']),
                        "iTotalRecords"        => $iTotal,
                        "iTotalDisplayRecords" => $iFilteredTotal,
                        "aaData"               => array()
                    );

                    while ($aRow = $t->fetch_array()) {

                              $row = array();
                              for ($i = 1; $i < (count($aColumns) - 1); $i++) {
                                        $row[] = $aRow[$aColumns[$i]];
                              }

                              if ($aRow[(count($aColumns) - 1)] == 1) {
                                        $row[] = '<center data-useridfunctional="' . $aRow[$aColumns[0]] . '"><i class="glyphicon glyphicon-ok txt-color-green"></i></center>';
                              } else {
                                        $row[] = '<center data-useridfunctional="' . $aRow[$aColumns[0]] . '"><i class="glyphicon glyphicon-remove txt-color-red"></i></center>';
                              }
                              $row[]              = '<div class="btn-group">
                                                  <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-gear"></i>  <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu fixed-dropdown-menu1">
                                                            <li>
                                                                      <a class="txt-color-green" href="#" onclick="editarUsuario(\'' . $aRow[$aColumns[0]] . '\');return false;"><i class="fa fa-edit"></i> Editar</a>
                                                            </li>
                                                            
                                                            <li>
                                                                      <a class="txt-color-red" href="#" onclick="eliminarUsuario(\'' . $aRow[$aColumns[0]] . '\');return false;"><i class="fa fa-trash-o"></i> Eliminar</a>
                                                            </li>
                                                  </ul>
                                        </div>';
                              $output['aaData'][] = $row;
                    }

                    return json_encode($output);
          }

}

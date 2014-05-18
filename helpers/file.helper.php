<?php
namespace XWork\Helpers;

use XWork\Helper as Hlp;

/**
 * Helper de funciones de fechas
 * 
 * @category   controllers
 * @author     Marcel Rojas <marcelrojas16@gmail.com>
 * @copyright  2013 by Codestore
 * @version    0.7
 */

class fileHelper extends Hlp {
          
          public function __construct() {
                    parent::__construct();
          }
          
          public function index() {
                    
          }
          
          public function getBlobString($tmpName) {
                    $fp      = fopen($tmpName, 'r');
                    $content = fread($fp, filesize($tmpName));
                    //$content = addslashes($content);
                    fclose($fp);
                    return $content;
          }
          
          public function downloadBlob($blob,$mime,$file,$size) {
                    header("Content-Type: $mime");
                    header("Content-Disposition: attachment; filename=$file");
                    header("Content-Transfer-Encoding: binary");
                    header("Content-Length: " . $size);
                    echo $blob;
          }
          
          public function getIco($mime) {
                    $maincontainer = BASE_URL.'public/img/';
                    $flags = array(
                        0=>'archive.png',
                        1=>'acrobat.png',
                        2=>'css.png',
                        3=>'excel.png',
                        4=>'gif.png',
                        5=>'html.png',
                        6=>'jpg.png',
                        7=>'js.png',
                        8=>'music.png',
                        9=>'php.png',
                        10=>'png.png',
                        11=>'powerpoint.png',
                        12=>'svg.png',
                        13=>'txt.png',
                        14=>'video.png',
                        15=>'wav.png',
                        16=>'word.png',
                    );
                    $ico = "";
                    switch ($mime) {
                              case 'video/3gpp'://video
                              case 'video/x-msvideo':
                              case 'video':
                                        $ico = $maincontainer.$flags[14];
                                        break;
                              case 'audio/x-aiff'://audio
                              case 'audio':
                                        $ico = $maincontainer.$flags[15];
                                        break;
                              case 'image/jpg'://imagen
                              case 'image/bmp':
                              case 'image/jpeg':
                              case 'image/gif':
                              case 'image/vnd.adobe.photoshop':
                              case 'image/png':
                                        $ico = $maincontainer.$flags[6];
                                        break;
                              case 'image/vnd.dxf'://planos
                              case 'image/vnd.dwg':
                              case 'image/svg+xml':
                              case 'application/pdf':
                                        $ico = $maincontainer.$flags[12];
                                        break;
                              case 'application/vnd.kde.kword'://word
                              case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                              case 'application/msword':
                              case 'application/vnd.wordperfect':
                                        $ico = $maincontainer.$flags[16];
                                        break;
                              case 'application/vnd.ms-powerpoint'://ppt
                              case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                                        $ico = $maincontainer.$flags[11];
                                        break;
                              case 'application/vnd.ms-excel'://excel
                              case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                                        $ico = $maincontainer.$flags[3];
                                        break;

                              default:
                                        $ico = $maincontainer.$flags[0];
                                        break;
                    }
                    
                    return $ico;
                    
          }
}

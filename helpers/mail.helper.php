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

class mailHelper extends Hlp {
          
          private $mailLib;
          
          public function __construct() {
                    parent::__construct();
                    $this->mailLib = $this->loadLib('phpmailer/class.phpmailer.php');
          }
          
          public function index() {
                    
          }
          
          public function sendSimpleMail($mensaje,$destinatario_mail,$destinatario_nombre,$subject) {                
                              $mail = new \PHPMailer(true); 
                              
                              $mail->IsSMTP();
                              $mail->Host       = SMTP_STD_SERVER;
                              $mail->SMTPDebug  = 0; 
                              $mail->SMTPAuth   = true;
                              $mail->SMTPSecure = "ssl";
                              
                              $mail->Port       = SMTP_STD_SERVER_PORT;
                              $mail->Username   = SMTP_STD_MAIL;
                              $mail->Password   = SMTP_STD_MAIL_PASS;
                              
                              $mail->AddAddress($destinatario_mail,$destinatario_nombre);
                              $mail->SetFrom(SMTP_STD_MAIL, SMTP_STD_MAIL_NAME);
                              
                              $mail->Subject    = $subject;
                              $mail->Body       = $mensaje;
                              $mail->AltBody    = 'Para ver este mensaje, por favor use un visor de de email compatible con HTML!';
                              $mail->Send();
          }
}

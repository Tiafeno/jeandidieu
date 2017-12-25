<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';
require 'engine.php';
require_once('inc/services.request.php');

class Controller {
  public $mail;
  public $recipient;
  public $sender;
  public $engine;
  public function __construct() {
    $this->engine = new Engine();
  }

  protected function getBodyHtml() {
    
  }

  public function sendMail() {
    $this->mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    $this->recipient = "francisco_28@ymail.com";
    $this->sender = Request::getValue('sender');
    $this->sender = (false == $this->sender) ? "no-reply@falicrea.com" : $this->sender;
    try {
      //Recipients
      $this->mail->setFrom($this->sender, 'Demandeur');
      $this->mail->addAddress($this->recipient);     // Add a recipient

      $this->mail->isHTML(true);                                  // Set email format to HTML
      $this->mail->Subject = 'Demande de contact';
      $this->mail->Body    = 'This is the HTML message body <b>in bold!</b>';
      $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
      $this->mail->send();
      echo json_encode(["success" => true, "message" => 'Message has been sent']);
    } catch (Exception $e) {
      echo json_encode(["message" => $this->mail->ErrorInfo, "success" => false]);
    }
  }

}

$reflexionController = new ReflectionClass( 'Controller' );
if ($reflexionController->hasMethod( Request::getValue( 'method' ) )) {
  $method = $reflexionController->getMethod( Request::getValue( 'method' ) );
  return $method->invoke( new Controller() );
} else {
  echo json_encode([ 'success' => false, 'message' => "Methode doesn't existe"]);
}
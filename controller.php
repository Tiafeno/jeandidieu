<?php

define("EXEC", true)
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
  public $templateEngine;
  public function __construct() {
    $this->templateEngine = new Engine();
  }

  protected function getBodyHtml() {
    
  }

  public function sendMail() {
    $this->mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    $this->recipient = ["francisco_28@ymail.com"];
    $this->sender = Request::getValue('sender');
    $this->sender = (false == $this->sender) ? "no-reply@falicrea.com" : $this->sender;
    try {
      //Recipients
      $this->mail->setFrom($this->sender, 'Demandeur');
      for ($ctp = 0; $ctp < count($this->recipient); $ctp++)
        $this->mail->addAddress($this->recipient[ $cpt ]);     // Add a recipient

      $this->templateEngine->assign('email', $this->sender);
      $this->mail->isHTML(true);                                  // Set email format to HTML
      $this->mail->Subject = 'Demande de contact - Jean Didieu';
      $this->mail->Body    = $this->templateEngine->fetch('mail.tpl');
      $this->mail->AltBody = "Je vous remercie d'envoyer votre proposition de tarif à l'adresse indiquée en en-tête ou à 
      l'adresse électronique suivante : {$this->sender}";
  
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
  try {
    $method->invoke( new Controller() );
  } catch(Exception $e) {
    echo json_encode(['success' => false, "message" => $e->getMessage()]);
  }
} else {
  echo json_encode([ 'success' => false, 'message' => "Methode doesn't existe"]);
}
<?php
define("EXEC", true);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

require 'engine/Engine.php';

class Controller {
  public $mailEngine; 
  public $templateEngine;
  protected $sender;
  public function __construct() {
    $this->mailEngine = new PHPMailer(true);
    $this->templateEngine = new Engine();
  }
  public function sendCommandeFn() {
    $expediteur = isset($_GET['email']) ? trim($_GET['mail']) : null;
    if (null == $expediteur) throw new Exception("INVOKE: Param email is missing!", 1);
    $this->sender = &$expediteur;
    if ($this->mailEngine instanceof PHPMailer) {
      //Recipients
      $this->mailEngine->setFrom($this->sender, 'Mailer');
      // $this->mailEngine->addAddress('francisco_28@ymail.com', 'Francisco Arinjaka');     // Add a recipient
      // $this->mailEngine->addAddress('contact@societe-jeandidieu.com', 'Jean Didieu');     // Add a recipient
      $this->mailEngine->addAddress('tiafenofnel@gmail.com', 'Tiafeno Finel');     // Add a recipient

      $this->templateEngine->assign('email', $this->sender);

      $this->mailEngine->isHTML(true);                                  // Set email format to HTML
      $this->mailEngine->Subject = 'Demande de devis & commande - Jean DIDIEU';
      $this->mailEngine->Body    = $this->templateEngine->fetch('mail.tpl');
      $this->mailEngine->AltBody = "Je vous remercie d'envoyer votre proposition de tarif à l'adresse indiquée en en-tête ou à 
      l'adresse électronique suivante : {$this->sender}";
      $this->mailEngine->send();
      echo true;
    }
  }
}

$ctrl = new ReflectionClass( 'Controller' );
if ($ctrl->hasMethod( $input->get( 'method' ) )) {
  $method = $ctrl->getMethod( $_GET( 'method' ) );
  try {
    $method->invoke( new Controller() );
  } catch(Exception $e) {
    echo $e->getMessage();
  }
  
} else echo "WARN: method is missing!";
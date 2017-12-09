<?php
class Controller {
  public function __construct() {}
}

$ctrl = new ReflectionClass( 'Controller' );
if ($ctrl->hasMethod( $input->get( 'method' ) )) {
  $method = $ctrl->getMethod( $_GET( 'method' ) );
  return $method->invoke( new Controller() );
} else {
  return false;
}
<?php

require_once('libs/smarty/Smarty.class.php');
class Engine extends Smarty {
  public function __construct() {
    parent::__construct();
    $this->setTemplateDir('templates/');
    $this->setCompileDir('templates_c/');
    $this->setConfigDir('configs/');
    $this->setCacheDir('cache/');
    $this->caching = 0;
    $this->force_compile = true;
    $this->debugging = true;
  }
}
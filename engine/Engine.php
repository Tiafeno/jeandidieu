<?php
defined('EXEC') or die('Restricted access');
class Engine extends Smarty {
  function __construct() {
    parent::__construct();
    $this->setTemplateDir(__DIR__ . '/templates/');
    $this->setCompileDir(__DIR__ . '/templates_c/');
    $this->setConfigDir(__DIR__ . '/configs/');
    $this->setCacheDir(__DIR__ . '/cache/');
    $this->caching = 0;
    $this->force_compile = true;
    $this->debugging = true;
  }
}
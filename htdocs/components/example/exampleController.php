<?php
defined('_AMSgo') or die;

Class exampleController Extends baseController {

  public function prime(){
    $this->aReg->template->exampleContent = 'This is the Example default page';
    $title = 'AMS | '. $this->aReg->router->controller;
    $this->aReg->template->show('example');
  }

  public function view(){
  	/**
     * The vars should be done in a model
     * @todo use a model for data processing
     */
    $this->aReg->title = 'AMS | Title Override';
  	$this->aReg->template->exampleHeader = 'This is the heading';
  	$this->aReg->template->exampleContent = 'This is the content';
  	$this->aReg->template->show('example2');
  }

  public function view2(){
    $template = $this->aReg->config->TEMPLATE_PATH . DS . $this->aReg->config->SITE_TEMPLATE;
    $this->aReg->lastCSS = array('<link rel="stylesheet" type="text/css" href="'.AMS_URL.$template.'/static/src/css/dashboard.css" />');
    $this->aReg->title = 'AMS | Title Override';
  	$this->aReg->template->exampleHeader = 'This is the heading';
  	$this->aReg->template->exampleContent = 'This is the content';
  	$this->aReg->template->show('example3');
  }

}

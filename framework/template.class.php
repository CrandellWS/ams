<?php
/*
 * The MIT License
 *
 * Copyright 2014 William Crandell <dev at crandell.ws>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * The base Template Class file.
 *
 * @version 1.0
 * @package AMS\Framework
 * @see Template
 * @see Templates
 */

/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;

Class Template {

  /*
   * @the aReg
   * @access private
   */
  private $aReg;

  public $error;

  /*
   * @Variables array
   * @access private
   */
  private $vars = array();

  /**
   * @constructor
   * @access public
   * @return void
   */
  function __construct($aReg) {
    $this->aReg = $aReg;
  }

/**
 * @set undefined vars
 * @param string $prime
 * @param mixed $value
 * @return void
 */
  public function __set($prime, $value){
    $this->vars[$prime] = $value;
  }

  public function show($name, $type='component') {
    if ($type === 'modal') {
      $path = AMSDIR_BASE . DS . 'components' . DS . $this->aReg->router->controller . DS . 'modal' . DS . $name . 'Modal.php';
    } else if ($type === 'component'){
      $path = AMSDIR_BASE . DS . 'components' . DS . $this->aReg->router->controller . DS . 'view' . DS . $name . '.php';
    } else {
      $this->show404();
      //alternativly an exception could help resolve the problem
      //this should be a configurable option.
      //such as is shown below
      //throw new Exception('Type not found |-->'. $type);
    }

    if (file_exists($path) === false) {
      $this->show404();
      return false;
    }
    // Load variables
    foreach ($this->vars as $key => $value) {
      $$key = $value;
    }
    $template = $this->aReg->config->TEMPLATE_PATH . DS . $this->aReg->config->SITE_TEMPLATE;
    if ($type === 'modal') {
      include $path;
    } else {
      include AMSDIR_BASE . DS . $template . DS . 'index.php';
    }
  }

  function show404() {
    try {
      throw new Exception();
    } catch(Exception $e) {
      $exception = $e->getTrace();
      $header = 'Exception';
    }

    $path = AMSDIR_BASE . DS . 'components' . DS . 'error' . DS . 'view' . DS . 'error404.php';
    if (file_exists($path) === false) {
      throw new Exception('Template not found in '. $path);
      return false;
    }
    // Load variables
    foreach ($this->vars as $key => $value) {
      $$key = $value;
    }
    include ($path);
  }
}

?>

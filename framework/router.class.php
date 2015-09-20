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
 * The base router file.
 *
 * @version 1.0
 * @package AMS\Framework
 * @todo null check ie "index.php/"
 * @todo work on functions for router class...
 * @see router
 */

/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;

/**
 * The base router class
 *
 * This class does most directional handling ie routing.
 *
 * @todo make it route more
 * @version 1.0
 * @package AMS\Framework
 */
class router {

  /**
   * @var object the Main Registry
   */
  private $aReg;

  /**
   *
   * @var string the controller path
   */
  private $path;

  private $args = array();

  public $file;

  public $controller;

  public $model;

  public $action;

  function __construct($aReg) {
    $this->aReg = $aReg;
  }

  /**
   *
   * @param type directory path
   * @throws Exception
   */
  function setPath($path) {
    /**
     * check if path is a directory
     */
    if (is_dir($path) == false){
      throw new Exception ('Invalid controller path: `' . $path . '`');
    }
    /**
     *  set the path
     */
    $this->path = $path;
  }

  /**
   * Load the controller
   * @return void
   * @todo get the 404 to display more info
   */
  public function loader() {
    /**
     * @see getController()
     */
    $this->getController();
    /**
     * @todo if the file is not there send to 404
     */
    if (is_readable($this->file) === false) {
      $this->aReg->error =array('controller' => $this->controller, '404' => true);
      if(isset($this->model)) {
        $array = $this->aReg->error;
        $array['model'] = $this->model;
        $this->aReg->error = $array;
      }
      // Example for future use...
      /** @todo remove or use */
      if(isset($this->action)){
        $array = $this->aReg->error;
        $array['action'] = $this->action;
        $this->aReg->error = $array;
      }
      /**
       * @todo get the 404 to display more info
       */
      $this->file = AMSDIR_BASE . DS . 'components' . DS . 'error' . DS .'errorController.php';
      $this->controller = 'error';
      }
      /**
       * include the controller
       */
      if($this->aReg->router->controller !== 'prime'){
        include $this->file;
      } else {
        include AMSDIR_BASE . DS . 'components' . DS . 'prime' . DS .'primeController.php';
        //~ die('testing');
      }
      /**
       * a new controller class instance
       * @todo make more use of this
       * @var object this will be the loaded object
       */
      $class = $this->controller . 'Controller';
      $this->aReg->$class = new $class($this->aReg);
      /**
       * check if the action is callable
       */
      if (is_callable(array($this->aReg->$class, $this->model)) === false) {
        $model = 'prime';
      } else {
        $model = $this->model;
      }
      /**
       * this may not need to be changed rather override from the controllers
       * @todo Basic example of passing dynamic var to template.
       */

      /**
       * @todo  create title => disrciption registry to build better titles with discriptions.
       * @todo This may also be a good point to add head meta tag info...
       */

      $tmpTitle = $this->aReg->router->controller;
      $this->aReg->title = 'AMS | '. $tmpTitle;
      $this->aReg->firstJS = array();
      $this->aReg->firstCSS = array();
      $this->aReg->lastJS = array();
      $this->aReg->lastCSS = array();

      $this->aReg->$class->$model();
    }


  /**
  *
  * @get the controller
  *
  * @access private
  *
  * @return void
  *
  */

  /**
   * Get the requested url and process for controller
   *
   * The check is preformed as first does the file exsist and second
   * is it a callable class.
   */
  private function getController() {

    /**
    * @todo better routing
    */
    $route = (empty($_GET['a'])) ? '' : $_GET['a'];
    if (empty($route)){
      $route = 'prime';
    } else {
     /**
      * @todo can this be more secure or is it fine??
      */
     $parts = explode(DS, $route);
     $this->controller = $parts[0];
     if(isset( $parts[1])) {
       $this->model = $parts[1];
     }
     // Example for future use...
     /** @todo remove or use */
     if(isset($parts[2])) {
      $this->action = $parts[2];
     }
    }
    if (empty($this->controller)) {
      $this->controller = 'prime';
    }
    if (empty($this->model)) {
      $this->model = 'prime';
    }
    if ($this->controller === 'error'){
      $this->aReg->error = array();
    }
    $this->file = AMSDIR_BASE . DS . 'components' . DS . $this->controller . DS . $this->controller. 'Controller.php';
  }
}

?>

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
 * The base blog controller file.
 *
 * @version 1.0
 * @package AMS\Componets\Blog
 */

/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;

/**
 * Class for blogController name handling
 *
 * This could be renamed as needed and reused easily...
 * @version 1.0
 * @package AMS\Componets\Blog
 */
Class blogController Extends baseController {

  /**
   * @see router::loader()
   */
  public function prime(){
    $this->aReg->template->blog_heading = 'This is currently being built and worked on and the editor will only load for specific users.';
    $this->aReg->lastCSS = array(
      PHP_EOL."<link rel='stylesheet' type='text/css' href='".AMS_URL.TEMPLATE_PATH.DS.TEMPLATE."/static/src/css/dashboard.css' />"
      ,PHP_EOL."<link rel='stylesheet' type='text/css' href='".AMS_URL.TEMPLATE_PATH.DS.TEMPLATE."/static/src/css/extra.css' />"
      //,PHP_EOL."<link rel ='stylesheet' type='text/css' href='".AMS_URL.TEMPLATE_PATH.DS.TEMPLATE."/static/src/css/carousel.css' />"
    );
    /**
     * @see blogIndex.php
     * @see Template::show();
     */
    $this->aReg->template->show('blogIndex');
  }

  /**
   * Done purely for example
   * This will be called when visiting index.php?a=blog/myexample
   */
  public function myexample(){
    $this->aReg->template->show('mypage');
  }

  /**
   * this the base work for ajax requests
   * The modal is to provide an interface to communicate through while making
   * ajax calls that can be authenicated
   *
   *Currently defaults to the ckeditor configurtation
   * @todo create authenication
   * @param string $view
   */
  private function modal($view){
    if ($this->aReg->auth->loggedIn($this->aReg->db)){
      $this->aReg->template->show($view, 'modal');
    } else {
      die();
    }
  }

 public function editwindow(){
   if ($this->aReg->auth->loggedIn($this->aReg->db)){
     $this->modal('edit');
   } else {
     die();
   }
 }
  /**
   * Done purely for example
   * This will be called when visiting index.php?a=blog/editor
   */
  public function editor(){
    if ($this->aReg->auth->loggedIn($this->aReg->db)){
      if ($_SESSION['userTypeID'] === 1 || $_SESSION['userTypeID'] === 2 ) {
        $jsArray = $this->aReg->firstJS;
        $ckeditorJS = "ckeditor/ckeditor.js";
        // $ckconfigJS = "ckeditor/config.main.js";
        $ckconfigJS = "ckeditor/ckeditor.php";
        array_push($jsArray, $ckeditorJS, $ckconfigJS);
        $this->aReg->firstJS = $jsArray;
        $NewlastCSS = $this->aReg->lastCSS;
        $ckeditorCSS = PHP_EOL."<link rel='stylesheet' type='text/css' href='".AMS_URL."ckeditor/css/neo.css' />";
        $extraCSS = PHP_EOL."<link rel='stylesheet' type='text/css' href='".AMS_URL."ckeditor/css/extra.css' />";
        $dashcss = PHP_EOL."<link rel='stylesheet' type='text/css' href='".AMS_URL.TEMPLATE_PATH.DS.TEMPLATE."/static/src/css/dashboard.css' />";
        array_push($NewlastCSS, $ckeditorCSS, $extraCSS);
        $this->aReg->lastCSS = $NewlastCSS;
        $this->aReg->template->show('editor');
      } else {
        $this->prime();
      }
    } else {
      $this->prime();
    }
  }
}
?>

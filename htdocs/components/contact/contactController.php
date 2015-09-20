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
 * The base contact controller file.
 *
 * @version 1.0
 * @package AMS\Componets\Contact
 */

/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;

/**
 * Class for contactController name handling
 *
 * This could be renamed as needed and reused easily...
 * @version 1.0
 * @package AMS\Componets\Contact
 */
Class contactController Extends baseController {

    /**
     * @see router::loader()
     */
    public function prime()
    {
      //extra line ending
      $this->aReg->lastCSS = array(
        PHP_EOL."<link rel='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/dashboard.css' />"
        ,PHP_EOL."<link rel='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/extra.css' />"
        //,PHP_EOL."<link rel ='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/carousel.css' />"
      );
      /**
       * @see contactIndex.php
       * @see Template::show();
       */
      $this->aReg->template->show('contactView');
    }

    /**
     * This will be called when visiting index.php?a=contact/view
     * Not really have any data makes a model useless.
     * @todo make a model to set the data rather than doing it here
     */
    public function view(){
        $this->aReg->template->contact_heading = 'This is currently being built and worked on and the editor will only load for specific users.';

        $this->aReg->template->contact_content = 'This is the contact content';
        $this->aReg->lastCSS = array(
            PHP_EOL."<link rel='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/dashboard.css' />"
            ,PHP_EOL."<link rel='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/extra.css' />"
            );
        $this->aReg->template->show('contactView');
    }

}
?>

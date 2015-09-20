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


defined('_AMSgo') or die;


Class userModel Extends userController {


    public function start() {

        $dir = 'components' . DS . $this->aReg->router->controller . DS;
        $css = $dir.'static/src/css/';
        $this->aReg->firstCSS = array($css.'signin.css');
        if ($this->aReg->auth->loggedIn($this->aReg->db)){
//            $this->mfile = AMSDIR_BASE . DS . $dir . 'model/class/userProfile.class.php';
//            require_once $this->mfile;
//            $this->aReg->router->profile = new userProfile($this->aReg);
            $this->aReg->template->show('myprofile');
        } else {
            $this->prime();
        }
    }

    public function manageUsers(){
        $dir = 'components' . DS . $this->aReg->router->controller . DS;
        if ($this->aReg->auth->loggedIn($this->aReg->db)){
            if($_SESSION['userTypeID'] === 1 ){
                $this->mfile = AMSDIR_BASE . DS . $dir . 'model/class/userManagement.class.php';
                require_once $this->mfile;
                $this->aReg->router->modelClass = new userManagement($this->aReg);
                $this->aReg->router->modelClass->managePage();
            } else {
                $this->start();
            }
        } else {
            $this->prime();
        }
    }
}

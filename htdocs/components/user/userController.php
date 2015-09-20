<?php
defined('_AMSgo') or die;

Class userController Extends baseController {

  public function prime(){
    if ($this->aReg->auth->loggedIn($this->aReg->db)){
      $dir = 'components' . DS . $this->aReg->router->controller . DS;
      $this->mfile = AMSDIR_BASE . DS . $dir .'model/userModel.php';
      require_once $this->mfile;
      $this->aReg->router->modelClass = new userModel($this->aReg);
      $this->aReg->router->modelClass->start();
    } else {
      $this->signin();
    }
  }

  public function signin(){
    /** @todo make use of the userModel for logins/logout ect */
    $dir = 'components' . DS . $this->aReg->router->controller . DS;
    $css = $dir.'static/src/css/';
    $this->aReg->firstCSS = array($css.'signin.css');
    $this->aReg->template->show('signin');
  }

  public function manage() {
    $action = $this->aReg->router->action;
    if(isset($this->aReg->router->action)){
      if($this->aReg->router->action === 'manage'){
        $this->aReg->router->action ='start';
      }
    }
    if(isset($_SESSION['userTypeID'])){
      if($_SESSION['userTypeID'] === 1 ){
        $dir = 'components' . DS . $this->aReg->router->controller . DS;
        $this->mfile = AMSDIR_BASE . DS . $dir .'model/userModel.php';
        require_once $this->mfile;
        $this->aReg->router->modelClass = new userModel($this->aReg);
        $this->aReg->router->modelClass->manageUsers();
      } else {
        header('Location: '.AMS_SEO_URL.'prime');
        die('Well Just in case we killed the process alltogether.');
      }
    } else {
      $this->prime();
    }
  }

  public function login(){
    $formKey = new $this->aReg->auth;
    /** @todo create standard filters for inputs */
    $post = filter_input_array(INPUT_POST);
    if(!isset($post['form_key']) || !$formKey->validate()){
      // Form key error
      header('Location: '.AMS_SEO_URL.'user/signin');
    } else if(isset($post['email'], $post['password'])) {
      $lp = $this->aReg->auth->login($post['email'], $post['password'], $this->aReg->db);

      /**
      * @todo login default actions
      * example $lp = loginprocessed return..
      * if($lp){$this->otherAction()}else{ $this->prime();}
      */
      if($lp){
        //no differnce between mobile and classic views but it could be done here.
        if($_SESSION['layoutType'] !== 'classic'){
          header('Location: '.AMS_SEO_URL.'prime');
        } else {
          header('Location: '.AMS_SEO_URL.'prime');
        }
      } else {
        $this->prime();
      }
    } else {
      header('Location: '.AMS_SEO_URL.'user/signin');
    }
  }

  public function logout(){
    $this->aReg->auth->logout($this->aReg->db);
  }
}

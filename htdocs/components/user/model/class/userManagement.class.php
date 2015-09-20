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
/**
 * Description of usermanagement
 *
 * @author William Crandell <dev at crandell.ws>
 */
class userManagement Extends userModel {

   public function managePage() {

        $action = $this->aReg->router->action;
        if(method_exists($this->aReg->router->modelClass, $action)){
            $this->$action();
        } else {
            $get = filter_input_array(INPUT_GET);
            if(!isset($get['userid'])){
                $this->aReg->template->show('userManagement');
                return true;
            }
            if(is_numeric($get['userid'])){
                // echo 'Cheers';

                $this->aReg->template->show('modifyUser');
                return true;
            } else {
                $this->aReg->template->show('userManagement');
                return true;
            }
        }
   }

   private function  addUsers(){
        $this->aReg->template->show('addUsers');
   }

    private function profile(){
        $dir = 'components' . DS . $this->aReg->router->controller . DS;
        $this->mfile = AMSDIR_BASE . DS . $dir . 'model/class/manageProfile.class.php';
        require_once $this->mfile;
        $this->aReg->router->manageProfile = new manageProfile($this->aReg);
        $this->aReg->router->manageProfile->editProfile();
        //~ $this->aReg->template->show('addUsers');
    }

   private function createUser($post){
       if(strlen($post['userPassword']) < 5){
           $this->aReg->router->addedUser = '<p class="text-muted alert-danger">PASSWORD INVALID</p>';
           return false;
       }
        $uPass = $this->aReg->auth->createPassword($post['userPassword']);
        $sqlArray = array(
            ':username' => $post['userName'], ':email' => $post['userEmail'],
            ':userType_iduserType' => $post['userType'],
            ':password' => $uPass['pass'], 'salt' => $uPass['salt']
        );
        $sql = "INSERT INTO `users` "
            . "(`username`, `email`, `userType_iduserType`, `password`, `salt`) "
            . " VALUES "
            . " (:username, :email, :userType_iduserType, :password, :salt)";
        $pd = '<p class="text-muted btn-danger">';
        try{
            $q = $this->aReg->db->prepare($sql);
            $q->execute($sqlArray);
        } catch (PDOException $e) {
            $this->aReg->router->addedUser = "$pd DataBase Error:<br>".$e->getMessage().'</p>';
            return false;
        } catch (Exception $e) {
            $this->aReg->router->addedUser = "$pd General Error: <br>".$e->getMessage().'</p>';
            return false;
        }
        $uID = $this->getUserIdByName($post['userName']);
        if($uID !==false){
          $dir = 'components' . DS . $this->aReg->router->controller . DS;
          $this->mfile = AMSDIR_BASE . DS . $dir . 'model/class/manageProfile.class.php';
          require_once $this->mfile;
          $this->aReg->router->manageProfile = new manageProfile($this->aReg);
          $this->aReg->router->manageProfile->editProfile($uID);
          return true;
        } else {
          $this->aReg->router->addedUser ='Could not retrieve user id after creation, this is unexpected error.';
          return false;
        }
   }

   private function getUserIdByName($username){
        $sql1 = "SELECT id FROM users WHERE username = :username";
        $sql1Array = array(
            ':username' => $username
        );
        $pd = '<p class="text-muted btn-danger">';
        try{
            $q1 = $this->aReg->db->prepare($sql1);
            $q1->execute($sql1Array);
            $userId = $q1->fetchColumn(0);
        } catch (PDOException $e) {
            $this->aReg->router->addedUser = "$pd DataBase Error:<br>".$e->getMessage().'</p>';
            return false;
        } catch (Exception $e) {
            $this->aReg->router->addedUser = "$pd General Error: <br>".$e->getMessage().'</p>';
            return false;
        }
        return $userId;
   }

   private function  addUser(){
        $post = filter_input_array(INPUT_POST);
        if(!$this->createUser($post)){
            $this->aReg->router->refill= true;
            $this->addUsers();
            return false;
        };
   }

   public function getUser($userName){
        $sql = 'SELECT u.username, u.email, ut.`type` '
                . 'FROM users u '
                . ' JOIN userType ut ON '
                . ' u.userType_iduserType = ut.iduserType '
                . ' WHERE u.username = '."'$userName'";
        $q = $this->aReg->db->prepare($sql);
        $q->execute();
        $data = $q->fetchAll();
        return $data;
    }

    public function listUsers(){
        $sql = 'SELECT u.id, u.username, u.email, ut.`type`  '
                . ' FROM users u '
                . ' JOIN userType ut ON '
                . ' u.userType_iduserType = ut.iduserType '
                . ' ORDER BY u.username';
        $q = $this->aReg->db->prepare($sql);
        $q->execute();
        $data = $q->fetchAll();
        return $data;
    }

   public function listUserTypes(){
        $sql = 'SELECT iduserType, `type` FROM userType ORDER BY iduserType DESC';
        $q = $this->aReg->db->prepare($sql);
        $q->execute();
        $data = $q->fetchAll();
        return $data;
    }

}

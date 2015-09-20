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
 * Description of userProfile
 *
 * @author William Crandell <dev at crandell.ws>
 */
class manageProfile Extends userModel {
    //put your code here
    public function editProfile($uid=false){
      if($uid === false){
        if(isset($_GET['userid'])){
            if($this->doesUserExist($_GET['userid'])){
                $this->getUserInfo($_GET['userid']);
            } else {
                $this->aReg->template->show('userManagement');
            }
        } else {
            $this->aReg->template->show('userManagement');
        }
      } else {
        if($this->doesUserExist($uid)){
            $this->getUserInfo($uid);
        } else {
            $this->aReg->template->show('userManagement');
        }
      }
    }

    private function doesUserExist($id){
        $sql1 = "SELECT EXISTS(SELECT id FROM users WHERE id = :id)";
        $sql1Array = array(
            ':id' => $id
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


    private function modifyUserPassword($id, $password){
        $uPass = $this->aReg->auth->createPassword($password);
        if(!isset($this->aReg->router->modifyUser) || $this->aReg->router->modifyUser = null)$this->aReg->router->modifyUser = '';
        $sqlArray = array(
            ':id' => $id,
            ':password' => $uPass['pass'], 'salt' => $uPass['salt']
        );
        $sql = 'UPDATE users '
            . ' set password = :password, salt = :salt'
            . ' where id = :id ';
        $pd = '<p class="text-muted btn-danger">';
        try{
            $q = $this->aReg->db->prepare($sql);
            $q->execute($sqlArray);
        } catch (PDOException $e) {
            $this->aReg->router->modifyUser .= "$pd DataBase Error:<br>".$e->getMessage().'</p>';
            return false;
        } catch (Exception $e) {
            $this->aReg->router->modifyUser .= "$pd General Error: <br>".$e->getMessage().'</p>';
            return false;
        }
        $this->aReg->router->modifyUser .= '<p class="text-muted alert-success">PASSWORD CHANGED</p>';
        return true;
    }

    private function modifyUserBasicInfo($sqlArray){
      if(!isset($this->aReg->router->modifyUser) || $this->aReg->router->modifyUser = null)$this->aReg->router->modifyUser = '';
      $sql = 'UPDATE users '
            . ' set username = :username, email = :email,'
            . ' userType_iduserType = :userType_iduserType'
            . ' where id = :id';
        $pd = '<p class="text-muted btn-danger">';
        try{
            $q = $this->aReg->db->prepare($sql);
            $q->execute($sqlArray);
        } catch (PDOException $e) {
            $this->aReg->router->modifyUser .= "$pd DataBase Error:<br>".$e->getMessage().'</p>';
            return false;
        } catch (Exception $e) {
            $this->aReg->router->modifyUser .= "$pd General Error: <br>".$e->getMessage().'</p>';
            return false;
        }
        $this->aReg->router->modifyUser .= '<p class="text-muted alert-success">Basic Info Updated</p>';
        $this->getUserInfo($sqlArray[':id']);
        return true;
    }


    private function modifyUserInfo(){
      if(!isset($this->aReg->router->modifyUser) || $this->aReg->router->modifyUser = null)$this->aReg->router->modifyUser = '';
      $post = filter_input_array(INPUT_POST);
        if(strlen($post['userPassword']) < 8){
            $this->aReg->router->modifyUser .= '<p class="text-muted alert-warning">PASSWORD NOT CHANGED It must be 8 characters long</p>';
        } else {
            $this->modifyUserPassword($post['id'], $post['userPassword']);
        }
        $sqlArray = array(
            ':id' => $post['id'],
            ':username' => $post['userName'], ':email' => $post['userEmail'],
            ':userType_iduserType' => $post['userType']
        );
        $this->modifyUserBasicInfo($sqlArray);
        return;
    }


    private function getUserInfo($id){

        if(isset($_POST['id']) && !isset($this->aReg->router->modifyUser)){
            //  if($_POST['id'] !== 1 && $_POST['id'] !== '1'){
                if($id === $_POST['id']){
                    $this->modifyUserInfo();
                    return;
                }
            // }
        }
        $sql = 'SELECT '
            . ' u.id, '
            . ' u.username as userName, u.email as userEmail, '
            . ' u.userType_iduserType as userType '
            . ' FROM users u '
        . ' WHERE u.id = :id ';
        $sqlArray = array(
            ':id' => $id
        );
        $pd = '<p class="text-muted btn-danger">';
        try{
            $q = $this->aReg->db->prepare($sql);
            $q->execute($sqlArray);
            $userInfo = $q->fetchAll();
        } catch (PDOException $e) {
            $this->aReg->router->addedUser = "$pd DataBase Error:<br>".$e->getMessage().'</p>';
            echo "$pd DataBase Error:<br>".$e->getMessage().'</p>';
            return false;
        } catch (Exception $e) {
            $this->aReg->router->addedUser = "$pd General Error: <br>".$e->getMessage().'</p>';
            echo "$pd General Error: <br>".$e->getMessage().'</p>';
            return false;
        }
        $this->aReg->router->userInfo = $userInfo;
        $this->aReg->template->show('modifyUser');
    }

}

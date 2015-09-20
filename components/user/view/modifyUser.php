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

?>
<div class="container-fluid">
    <div class="main">
        <div class="row">
            <?php include 'menus/main.tabs.php'; ?>
        </div>
        <div class='panel panel-info'>
            <div class='panel-heading'>
                <strong>Modify User</strong>
            </div>
            <div class='panel-body'>



                <?php

                if (isset($this->aReg->router->modifyUser)) {
                    echo '<pre>';
                        print_r($this->aReg->router->modifyUser);
                    echo '</pre>';
                }

                if(isset($this->aReg->router->userInfo[0])){
                    $userInfo = $this->aReg->router->userInfo[0];
                }
                
                ?>
                <!--<form action="<?php echo AMS_URL ?>index.php?a=user/manage/modify" method="post" role="form">-->
                <form action="<?php echo AMS_URL ?>index.php?a=user/manage/profile<?php if(isset($userInfo['id'])) echo '&userid='.$userInfo['id'].''; ?>" method="post" role="form" autocomplete="off" >
                <!--<form action="<?php echo AMS_URL ?>post.php" method="post" role="form" enctype="multipart/form-data">-->
                    <div class='div col-sm-12 center'>
                        <div class="row">
                            <div class='panel panel-primary'>
                                <div class='panel-heading text-center'>
                                    <strong>Basic Info</strong>
                                </div>
                                <div class='panel-body bg-info'>
                                    <div class="row">
                                        <div class='col-sm-6 col-xs-12'>
                                            <div class="form-group">
                                                <div id="userNameDiv"  class="input-group">
                                                    <span class="input-group-addon"><strong>UserName</strong></span>
                                                    <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter username" <?php if(isset($userInfo['userName'])) echo 'value = "'.$userInfo['userName'].'"'; ?> />
                                                    <input type="hidden" class="form-control" id="id" name="id" <?php if(isset($userInfo['id'])) echo 'value = "'.$userInfo['id'].'"'; ?> />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <div id="userEmailDiv"  class="input-group">
                                                    <span class="input-group-addon"><strong>Email</strong></span>
                                                    <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter email" <?php if(isset($userInfo['userEmail'])) echo 'value = "'.$userInfo['userEmail'].'"'; ?> />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <div id="userTypeDiv"  class="input-group">
                                                    <span class="input-group-addon"><strong>Type</strong></span>
                                                    <select class="form-control" id="userType" name="userType">
                                                        <?php
                                                            //print_r($this->aReg->router->modelClass->listUserTypes());
                                                            $userTypes = $this->aReg->router->modelClass->listUserTypes();
                                                        foreach ($userTypes as $key => $value) {
                                                            if(isset($userInfo['userType'])){
                                                                if($userInfo['userType']===$value['iduserType']){
                                                                    echo '<option value="'.$value['iduserType'].'" selected>'.$value['type'].'</option>';
                                                                } else {
                                                                    echo '<option value="'.$value['iduserType'].'">'.$value['type'].'</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="'.$value['iduserType'].'">'.$value['type'].'</option>';
                                                            }
                                                        }
                                                        if(isset($userInfo['userType']) && isset($userType)) echo '<option selected value="'.$userInfo['userMarket'].'>'.$thisType.'</option>';
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div id="userPassDiv"  class="input-group">
                                                    <span class="input-group-addon"><strong>Password</strong></span>
                                                    <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Password" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-primary pull-right" onclick="this.form.submit();">Submit</button>
                            <div class='clearfix'></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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


            <div class="container-fluid">
               <div class='panel panel-primary'>
                   <div class="panel-heading"><h3 class="center">User Management Form</h3></div>
                        <div class="panel-body alert-info">
                            <div class="row">
 <?php
//~ //start of accordian
?>
            <div class="panel-group col-sm-8 col-md-6 center" id="accordion">
    <?php
    //~ // start of panel;
    $UserGroup = 'UserGroup'
    ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading text-center">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $UserGroup;?>">
                          <?php echo $UserGroup;?>
                                </a>
                            </h4>
                        </div>
                        <div id="<?php echo $UserGroup;?>" class="panel-collapse collapse">
                            <div class="panel-body ">
                                <div class="list-group center col-md-10">
<?php
foreach($this->aReg->router->modelClass->listUsers() as $user => $info){

 ?>
                                <div class="list-group-item">
                                    <h4 class="list-group-item-heading">
                                        <a href="<?php echo AMS_SEO_URL ?>user/manage/profile&userid=<?php echo $info['id']; ?>">
                                        <?php echo $info['username']; ?>
                                        </a>
                                        <span class="badge pull-right alert-info"><?php echo $info['type']; ?></span>
                                    </h4>
                                </div>
<?php
}
?>
                            </div>
                        </div>
                    </div>
                </div>
<?php
//~ // end of panel;
?>
        </div>
 <?php
//~ //end of accordian
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

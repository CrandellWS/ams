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
 * @version 1.0
 * @package AMS\Templates
 * @see Template
 */

/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;

$loggedIn = $this->aReg->auth->loggedIn($this->aReg->db);
if($loggedIn){
    preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
    if (count($matches)>1){
      //Then we're using IE
      $version = $matches[1];
      switch(true){
        case ($version<=8):
          //IE 8 or under!
            header('refresh:5; url=http://support.microsoft.com/kb/956196');
            exit('AMS Recommened browser is FireFox please visit <a href="http://getfirefox.com">http://getfirefox.com</a>.');
            break;
         //~case ($version>=9):
             //~header('refresh:5; url=http://support.microsoft.com/kb/956196');
             //~die('AMS Recommened browser is FireFox please visit <a href="http://getfirefox.com">http://getfirefox.com</a>.');
             //~break;
        default:
          //You should get the idea
      }
    }
}
if(array_shift((explode(".",$_SERVER['HTTP_HOST']))) === 'www'){$www = 'www.';} else {$www = '';}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->aReg->title ?></title>
        <meta charset="utf-8">
        <link rel="canonical" href="<?php
        if($this->aReg->router->controller === 'prime' && $this->aReg->router->model === 'prime'){
          echo AMS_SEO_URL;
        } else if($this->aReg->router->model === 'prime'){
          echo AMS_SEO_URL.$this->aReg->router->controller;
        } else {
          echo AMS_SEO_URL.$this->aReg->router->controller.'/'.$this->aReg->router->model;
        }?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<?php

  foreach( $this->aReg->firstCSS as $CSS){
    echo '        <link rel="stylesheet" type="text/css" href="'.AMS_URL.$CSS.'" />';
  }
  foreach( $this->aReg->firstJS as $JS){
    if(isset(pathinfo($JS)['extension']))
      if(pathinfo($JS)['extension']==='js'){
        echo '        <script type="text/javascript" src="'.AMS_URL.$JS.'"></script>'.PHP_EOL;
      } else if(pathinfo($JS)['extension']==='php'){
        echo '        <script>'.PHP_EOL;
        include AMSDIR_BASE.$JS;
        echo '        </script>'.PHP_EOL;
      } else {
        //there was not a file extension
      }
  }

 ?>

        <link rel="stylesheet" type="text/css" href="<?php echo AMS_URL.$template; ?>/static/src/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo AMS_URL.$template; ?>/static/src/css/bootstrap-toggle.min.css" />

        <link rel="stylesheet" type="text/css" href="<?php echo AMS_URL.$template; ?>/static/src/css/jquery.bootstrap-touchspin.min.css" />
<?php if ($loggedIn === true) { ?>
        <link rel="stylesheet" type="text/css" href="<?php echo AMS_URL.$template; ?>/static/src/css/dashboard.css" />
<?php
      } else {
        $test = $this->aReg->lastCSS;
        if(empty($test)){
?>
        <link rel="stylesheet" type="text/css" href="<?php echo AMS_URL.$template; ?>/static/src/css/cover.css" />
<?php
        }
    }
?>
        <link rel="stylesheet" type="text/css" href="<?php echo AMS_URL.$template; ?>/static/src/css/sticky-footer.css?v=1" />
<?php
  foreach( $this->aReg->lastCSS as $CSS){
    // echo '<link rel="stylesheet" type="text/css" href="'.AMS_URL.$CSS.'" />';
    echo PHP_EOL.$CSS;
  }
?>
        <link rel="stylesheet" type="text/css" href="<?php echo AMS_URL.$template; ?>/static/src/css/last.css" />
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "LocalBusiness",
  "url" : "<?php   echo PREFERED_PROTOCOL.AMS_SEO_URL; ?>",
  "logo" : "<?php   echo PREFERED_PROTOCOL.AMS_URL.TEMPLATE_PATH.DS.TEMPLATE; ?>/static/src/img/logo_584x150.png",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "City",
    "addressRegion": "State",
    "streetAddress": "123 Any Street"
  },
  "description": "SEO Discription Goes here",
  "name": "<?php   echo AMS_SITE_NAME; ?>",
  "telephone" : "+1-999-999-9999",
  "contactPoint" : [{
    "@type" : "ContactPoint",
    "telephone" : "+1-999-999-9999",
      "contactOption" : "TollFree",
    "contactType" : "customer service",
      "areaServed" : "US"
  }]
}
</script>
    </head>
    <body>
  <!-- Start Site wrappers -->
  <div class="site-wrapper">
    <div class="site-wrapper-inner">
      <div class="cover-container">

        <!-- Start Site navigation -->
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="container-fluid ">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php
              echo AMS_SEO_URL;
              ?>">
                <img src='<?php echo AMS_URL.$template; ?>/static/src/img/logo_150x50.png' style="margin-top:-15px;"/>
              </a>
            </div>
            <!-- Start Site collapse Navigation Menu -->
            <div class="navbar-collapse collapse" id="top-navbar-collapse">
              <ul class="nav navbar-nav navbar-right">
              <?php
                if ($loggedIn === true) {
                  if($_SESSION['userTypeID'] === 1 ) {
                    echo PHP_EOL.'<li><a href="'.AMS_SEO_URL.'blog">Blog</a></li>';
                  }
                  echo PHP_EOL.'<li><a href="'.AMS_SEO_URL.'user">Profile</a></li>';
                  echo PHP_EOL.'<li><a href="'.AMS_SEO_URL.'user/logout">Logout</a></li>';
                } else {
                  echo PHP_EOL.'<li><a href="'.AMS_SEO_URL.'user/signin">Login</a></li>';
                }
              ?>


              </ul>
            </div>
            <!-- End Site collapse Navigation Menu -->
          </div>
        </div>
        <!-- End Site navigation -->

        <!-- Page Start-->
        <?php
            if(isset($this->aReg->topbanner))
            if ($loggedIn === true && $this->aReg->topbanner === true) { ?>
        <div class="col-xs-12 text-center label-info" style="margin-right: 15px;margin-bottom:5px;">
            <h5>AMS/Website Top banner</h5>
        </div>
        <?php } ?>

        <?php
        include ($path);
        ?>


        <!-- Page End-->
        <div class="clearfix"></div>
        <div class="footSpace"></div>
      </div>
    </div>
  </div>
  <!-- End Site wrappers -->

<!-- Start Site Footer -->
<div id="footer">
  <div class="container" style="margin: 0 auto;">
    <p class="text-muted" style="margin: 0 auto;">
      <?php echo AMS_SITE_NAME; ?> &copy; <?php echo date('Y'); ?>. All rights reserved.
    </p>
  </div>
</div>
<!-- End Site Footer -->

  <script src="<?php echo AMS_URL.$template; ?>/static/src/js/jquery.2.1.4.min.js"></script>
  <script src="<?php echo AMS_URL.$template; ?>/static/src/js/bootstrap.min.js"></script>
  <script src="<?php echo AMS_URL.$template; ?>/static/src/js/bootstrap-toggle.min.js?v0"></script>
  <script src="<?php echo AMS_URL.$template; ?>/static/src/js/jquery.bootstrap-touchspin.min.js?v0"></script>
<?php foreach( $this->aReg->lastJS as $JS){echo $JS;}  ?>
    </body>
</html>

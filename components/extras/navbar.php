<?php
defined('_AMSgo') or die;

?>




    <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              MENU <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="<?php echo AMS_SEO_URL; ?>"><?php echo AMS_SITE_NAME; ?></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">

            <ul class="nav navbar-nav">

              <li class="<?php
              if($this->aReg->router->controller === 'blog'
              && (!$this->aReg->auth->loggedIn($this->aReg->db) || $this->aReg->router->model !== 'editor')){
                echo ' active ';}
              ?>"><a href="<?php echo AMS_SEO_URL; ?>blog">Blog<?php if($this->aReg->router->controller === 'blog' ){echo ' <span class="sr-only">(current)</span> ';} ?></a></li>
              <?php
              if($this->aReg->router->controller === 'blog' && $this->aReg->auth->loggedIn($this->aReg->db)){
                if ($_SESSION['userTypeID'] === 1 || $_SESSION['userTypeID'] === 2 ) {
                ?>
                <li class="<?php if($this->aReg->router->model === 'editor'){echo ' active ';}?>"><a href="<?php echo AMS_SEO_URL; ?>blog/editor">Blog Editor<?php if($this->aReg->router->model === 'editor'){echo ' <span class="sr-only">(current)</span> ';} ?></a></li>
                <?php
                }
              }
              ?>

            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="<?php if($this->aReg->router->controller === 'contact'){echo ' active ';}?>"><a href="<?php echo AMS_SEO_URL; ?>contact">Contact Us <?php if($this->aReg->router->controller === 'prime'){echo ' <span class="sr-only">(current)</span> ';}?></a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

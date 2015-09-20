

<?php
/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;
$showNavbar = true;
$showCarousel = false;
$pageFooter = true;

?>
<div class="row row-centered">
    <div class="col-md-9 col-centered" role="main">


<?php if($showNavbar){ //show navbar ?>
<?php
include( AMSDIR_BASE . DS . 'components/extras/navbar.php');

?>
<?php } //end navbar ?>

      <div class="jumbotron padOneEM" itemscope itemtype="http://schema.org/BlogPosting">
        <h2 itemprop="headline">SEO Blog Title</h2>

        <div class="clearfix">
            <p class="lead" itemprop="description">SEO Blog Discription</p>
            <div class="pull-right">
                <a href="#collapseDiv"
                role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseDiv"
                class="btn btn-lg btn-success">
                    Expand Collapse Button
                </a>
            </div>
        </div>



        <div class="collapse" id="collapseDiv">
          <div class="well">
            <p class="lead" itemprop="articleBody">
SEO Blog Body content goes here.
            </p>

          </div>
        </div>
      </div>
<?php
        //start navbar
        include( AMSDIR_BASE . DS . 'components/extras/footer.php');
        //end navbar
?>
    </div>
</div>

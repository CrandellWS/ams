<?php
/**
 * @see _AMSgo
 *
 * Need to update with schema info...
 *
 */
defined('_AMSgo') or die;

?>
<div class="row row-centered">
    <div class="col-md-9 col-centered" role="main">

<?php
include( AMSDIR_BASE . DS . 'components/extras/navbar.php');
?>


      <div class="jumbotron padOneEM">
        <h2>Contact Us</h2>

        <div class="clearfix">
            <p class="lead">
                <!-- Contact Leading Paragraph -->
                Call us at 1 (999) 999-9999
            </p>
            <div class="pull-right">
                <a href="#collapseContactUs"
                role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseContactUs"
                class="btn btn-lg btn-success">
                    Contact Us Today
                </a>
            </div>
        </div>



        <div class="collapse" id="collapseContactUs">
          <div class="well">
            <p class="lead">
                <!-- Contact Form -->
                <!-- Use php Include... -->
                This is for a form or other contact type info
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

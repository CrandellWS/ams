<?php
defined('_AMSgo') or die;

$formKey = new $this->aReg->auth;

$loggedIn = $this->aReg->auth->loggedIn($this->aReg->db);

if ($loggedIn === true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<div class="signin-container">
    <p>You are currently logged <?php echo $logged ?>.</p>
<?php if ($loggedIn === true) { ?>

    <p>If you are done, please <a href="<?php echo AMS_SEO_URL ?>user/logout">log out now</a>.</p>

<?php } else { ?>
        <form action="<?php echo AMS_SEO_URL ?>user/login" method="post" name="login_form"  class="form-signin" role="form">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="email" class="form-control" placeholder="Email address" required autofocus/>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required/>
        <div>
			<div class="pull-right">
				<script type="text/javascript">function loadUrl(location){this.document.location.href = location;}</script>
				<button type="button" class="btn btn-info btn-block btn-signin" onclick="loadUrl('<?php echo AMS_URL ?>resetpw.php');">&nbsp; Reset Password &nbsp;</button>
			</div>
			<div class="pull-left">
				<button class="btn btn-primary btn-block btn-signin" onclick="this.form.submit();">&nbsp; Sign in &nbsp;</button>
			</div>
		</div>
            <?php $formKey->outputKey(); ?>
        </form>
    <div class="clearfix"></div>
<?php } ?>
</div>

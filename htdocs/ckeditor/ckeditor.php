<?php
defined('_AMSgo') or die;
$AMS_URL = AMS_URL;
echo "
CKEDITOR.editorConfig = function( config ) {
	config.language = 'en';
	config.uiColor = '#27c0d8';
	//~ config.height = 600;
	config.toolbarCanCollapse = true;
	config.contentsCss = [
		'{$AMS_URL}templates/base/static/src/css/bootstrap.min.css',
		'{$AMS_URL}templates/base/static/src/css/bootstrap-toggle.min.css',
		'{$AMS_URL}templates/base/static/src/css/jquery.bootstrap-touchspin.min.css',
		'{$AMS_URL}templates/base/static/src/css/dashboard.css',
		'{$AMS_URL}templates/base/static/src/css/sticky-footer.css?v=1'
		];
		config.allowedContent = true;
		config.extraAllowedContent = '*(*)';
};
";

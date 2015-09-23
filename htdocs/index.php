<?php
//~die('The Aerotek web site is under maintence untill further notice.');

error_reporting(E_ALL);
ini_set('display_errors','On');

/**
 * Based on Joomla's _JEXEC, prevent unwanted code execution
 *
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 *
 * @name _AMSgo
 */
define('_AMSgo', 1);
/**
 * include the config.php file
 */

if (!defined('AMSDIR_BASE')) {
  define('AMSDIR_BASE', __DIR__);
  define( "DS", '/');
  require_once AMSDIR_BASE . DS . 'includes' . DS . 'config.php';
}


ob_start();
/**
 * include the ini.php file
 */
require_once AMSDIR_BASE . DS . 'includes' . DS . 'ini.php';

/**
 * load the router
 * This needs examined
 */
$aReg->router = new router($aReg);

/**
 * set the controller path
 * This needs examined
 * @TODO set controller base path to components directory
 */
$aReg->router->setPath (AMSDIR_BASE . DS . 'components');

/**
 * load up the template
 * This needs examined
 */
$aReg->template = new template($aReg);


//This could be used to prevent login access for specfic userTypes
// if(isset($_SESSION['userTypeID'])){
//     if(intval($_SESSION['userTypeID']) === 5){
//         die();
//     }
// }

/**
 * load the controller
 * This needs examined
 */
$aReg->router->loader();

ob_end_flush();

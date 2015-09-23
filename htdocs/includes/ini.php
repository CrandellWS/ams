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
 * All site wide init should be done here
 *
 * @version 1.0
 * @package AMS\Includes
 */

/**
 * @see _AMSgo
 */
 defined('_AMSgo') or die;


 /**
  * @todo revert display_errors back to a config option
  * see DEVELOPMENT_ENVIRONMENT
  */
 ini_set( "display_errors", true );

 /**
  * @todo set timezone as a config option
  *
  */
 date_default_timezone_set( "America/New_York" );

/**
 * @see baseController
 */
 require_once AMSDIR_BASE . DS .'framework'. DS . 'controllerBase.class.php';

/** @see aReg */
 require_once AMSDIR_BASE . DS .'framework'. DS . 'aReg.class.php';

 /** @see router */
 require_once AMSDIR_BASE . DS .'framework'. DS . 'router.class.php';

 /** @see template */
 require_once AMSDIR_BASE . DS .'framework'. DS . 'template.class.php';

 /** @see db */
 require_once AMSDIR_BASE . DS .'framework'. DS . 'db.class.php';

 /** @see amsAuth */
 require_once AMSDIR_BASE . DS .'framework'. DS . 'amsAuth.class.php';

/**
 * This is to auto load model classes currently unused
 * @param type $class_name
 * @return boolean|require_once
 * @todo rework model loading to use this autoload
 */
 function __autoload($class_name) {
  $filename = strtolower($class_name) . '.class.php';
  $file = AMSDIR_BASE . DS . 'components' . DS . $class_name . DS . 'model' . DS . $filename;

  if (file_exists($file) == false) {
    return false;
  }
  require_once ($file);
 }


/**
 * @see aReg
 * @var $aReg aReg
 */
$aReg = new aReg;

/**
 * @see amsConfig
 * @var $aReg->config amsConfig
 */
$aReg->config = new amsConfig;

/**
 * create the database aReg object
 *
 * @todo More elegant way to create database object??
 * @var $db db
 * @see db
 * @see AMS/Includes
 */
$aReg->db = db::getInstance(
    $aReg->config->DB_DSN,
    $aReg->config->DB_USERNAME,
    $aReg->config->DB_PASSWORD
);

/**
 * @see amsAuth
 * @var $aReg->auth amsAuth
 */
$aReg->auth = new amsAuth;

/**
 * @see amsAuth::ams_session_start()
 */
$aReg->auth->ams_session_start($aReg->db);

/**
 * A default exception handle.
 * @param Exception $exception
 * @todo ingrate the error handling into base site template...
 */
function handleException( $exception ) {
  echo "Error Occured:\n<br>". $exception->getMessage();
  error_log( $exception->getMessage() );
}

// TODO combine with xdebug
//set_exception_handler( 'handleException' );

/**
 * Set defaults on error display.
 *
 * Perhaps should be used within the source as well but is not at this time.
 * @see AMS/Includes
 */

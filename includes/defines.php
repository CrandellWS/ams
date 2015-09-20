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
 * All site wide defined vars should be placed here
 *
 * @version 1.0
 * @package AMS\Includes
 */

/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;

if (!function_exists('array_column')) {
  die('array_column does not exist.');
  // See Ben Ramsey <http://benramsey.com> OR USE PHP 5.5
}

ob_start();
    $domain = $_SERVER['HTTP_HOST'];
    $docRoot = realpath($_SERVER['DOCUMENT_ROOT']);
    $dirRoot = __DIR__;
    /**
     * @todo convert ssl to configurable across whole application
     */
    $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
    $urlDir = str_replace('includes', '',str_replace($docRoot, '', $dirRoot));
    $urlDir = str_replace('\\', '/',$urlDir);
    $rootDir = str_replace('includes', '',$dirRoot);
    $site_path = $protocol.$domain.$urlDir;
    define ('AMS_URL', $site_path);
    define ('AMS_DOMAIN', $protocol.$domain);
    define ('AMS_SITE_NAME', 'Company Name');
    define ('AMS_ROOT', $rootDir);


    /**
     * AMS_SEO_URL is to be used to control the urls
     * This should be set based on if url rewriting is used or not
     * use ('AMS_SEO_URL', $site_path.'index.php?a='); when not utilizing Mod_rewrite
     * or for Mod_rewrite use you might use the root like so
     * ('AMS_SEO_URL', '/');
     * @var string
    */
    //define ('AMS_SEO_URL', $protocol.$domain.'/ams/');
    define ('AMS_SEO_URL', $protocol.$domain.'/');

/**
 * @todo doc each define
 */
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
define( "DEVELOPMENT_ENVIRONMENT", true);
define( "SYS_DS", DIRECTORY_SEPARATOR);
define( "DS", '/');

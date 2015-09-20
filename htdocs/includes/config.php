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
 * The base amsConfig Class file.
 *
 * @version 1.0
 * @package AMS\Includes
 * @see amsConfig
 */

/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;

class amsConfig {

    public $DB_HOST = 'localhost';
    public $DB_DATABASE = 'sample1';
    public $DB_USERNAME = 'user1';
    public $DB_PASSWORD = 'password1';
    public $DB_DSN;

    //Template configurations
    public $ADMIN_TEMPLATE = 'base';
    public $SITE_TEMPLATE = 'base';
    public $TEMPLATE_PATH = 'templates';

    /**
     * new creates a db object
     * should be changed
     */
    function __construct() {
        $this->DB_DSN = 'mysql:host='.$this->DB_HOST.';dbname='.$this->DB_DATABASE;
    }
}

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
 * The base databases Class file.
 *
 * @version 1.0
 * @package AMS\Framework
 * @see db
 */

/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;
/**
 * The main databse class for connection to the database.
 * @todo security evaulations.
 * @package AMS\Framework
 */
class db{

  /**
   * @var db base connection
   */
  private static $connection = NULL;

  /**
  * the constructor is set to private so
  * so nobody can create a new instance using new
  */
  private function __construct() {
  }

  /**
  *
  * Return DB instance or create intitial connection
  *
  * @return object (PDO)
  *
  * @access public
  *
  */
  public static function getInstance($DB_DSN, $DB_USERNAME, $DB_PASSWORD) {

    if (!self::$connection) {
      try {
        self::$connection = new PDO($DB_DSN, $DB_USERNAME, $DB_PASSWORD);
        self::$connection-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        die('Can\'t connect to AMS Database');
      } catch (Exception $exc) {
        die('Can\'t connect to Database');
      }
    }
    return self::$connection;
  }

  /**
  *
  * Like the constructor, we make __clone private
  * so nobody can clone the instance
  *
  */
  private function __clone(){
  }

} /*** end of class ***/

?>

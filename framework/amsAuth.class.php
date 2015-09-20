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
 * The base amsAuth file.
 *
 * @version 1.0
 * @package AMS\Framework
 * @see amsAuth
 */

/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;

/**
 * @package AMS\Framework
 */
class amsAuth{
  /**
   * store the generated form key
   *  @var string
   */
  private $formKey;

  /**
   * store the old key
   * @var string
   */
  private $old_formKey;

  /**
   * session name
   * @var string
   */
  private $session_name;

  /**
   * @TODO Need to check value of this var
   * @var boolean
   */
  private $secure;

  /**
   * @TODO Need to check value of this var
   * @var boolean
   */
  private $httponly;

  /**
   * @var object
   */
   private $cookieParams;

  /**
   * Store the old key for later comparison
   */
  function __construct(){
    /**
     * first check if old key is available
     * if so, then store it.
     */
    if(isset($_SESSION['form_key']))
    {
        $this->old_formKey = $_SESSION['form_key'];
    }
  }

  //Function to generate the form key
  private function generateKey(){
    //Get the IP-address of the user
    $ip = $_SERVER['REMOTE_ADDR'];

    //We use mt_rand() instead of rand() because it is better for generating random numbers.
    //We use 'true' to get a longer string.
    //See http://www.php.net/mt_rand for a precise description of the function and more examples.
    $uniqid = uniqid(mt_rand(), true);

    //Return the hash
    return md5($ip . $uniqid);
  }

  //Function to output the form key
  public function outputKey(){
    if(isset($_SESSION['form_key'])){
      $_SESSION['old_form_key'] = $_SESSION['form_key'];
    }
    //Generate the key and store it inside the class
    $this->formKey = $this->generateKey();
    //Store the form key in the session
    $_SESSION['form_key'] = $this->formKey;

    //Output the form key
    echo "<input type='hidden' name='form_key' id='form_key' value='".$this->formKey."' />";
  }

  //Function that validated the form key POST data
  public function validate(){
    //the old formKey is used and not the new generated version
    /**
     * @todo use filter_input(INPUT_POST, $POST)
     * @see getPost($POST)|getPost|superAMS
     */
    $post = filter_input_array(INPUT_POST);
    if($post['form_key'] === $this->old_formKey || $post['form_key']  === $_SESSION['old_form_key']){
      //The key is valid, return true.
      return true;
    } else {
      return false;
    }
  }

  public function ams_session_start($pdo){
    $this->session_name = 'ams_session_id';   // Set a custom session name
    //@todo Security configuration ...
    if(true){
      $this->secure = false;
    } else {
      $this->secure = true;
    }
    // This stops JavaScript being able to access the session id.
    $this->httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
      header("Location: ".AMS_URL."index.php?a=error&err=Could not initiate a safe session (ini_set)");
      exit();
    }
    // Gets current cookies params.
    $this->cookieParams = session_get_cookie_params();
    session_set_cookie_params($this->cookieParams["lifetime"],
      $this->cookieParams["path"],
      $this->cookieParams["domain"],
      $this->secure,
      $this->httponly);
    // Sets the session name to the one set above.
    session_name($this->session_name);
    session_start();// Start the PHP session
    if(isset($_SESSION['user_id'])){
      $this->dbSession($_SESSION['user_id'], session_id(), $pdo);
    } else {
      session_regenerate_id(true);    // regenerated the session, delete the old one.
    }
  }

  public function loggedIn($pdo) {
    // Check if all session variables are set
    if(isset($_SESSION['user_id'],
      $_SESSION['username'],
      $_SESSION['login_string'])){

      $user_id = $_SESSION['user_id'];
      $login_string = $_SESSION['login_string'];
      $username = $_SESSION['username'];

      // Get the user-agent string of the user.
      $user_browser = $_SERVER['HTTP_USER_AGENT'];

      if($stmt = $pdo->prepare(
        "SELECT password, userType_iduserType
          FROM users
          WHERE id = :user_id LIMIT 1")
      ){
        // Bind "$user_id" to parameter.
        $params = array(':user_id' => $user_id);
        $stmt->execute($params);   // Execute the prepared query.

        if ($stmt->rowCount() === 1) {
          // If the user exists get variables from result.
          $row = $stmt->fetch();
          $login_check = hash('sha512', $row['password'] . $user_browser);

          if ($login_check === $login_string) {
            //~ die($row['userType_iduserType']);
            $_SESSION['userTypeID'] = intval($row['userType_iduserType']);
            // Logged In!!!!
            return true;
          } else {
            // Not logged in
            return false;
          }
        } else {
          // Not logged in
          return false;
        }
      } else {
        // Not logged in
        return false;
      }
    } else {
      // Not logged in
      return false;
    }
  }

  private function checkbrute($user_id, $pdo){
    // Get timestamp of current time
    $now = time();
    // All login attempts are counted from the past 5 minutes.
    $valid_attempts = $now - (5 * 60);
    if ($stmt = $pdo->prepare(
      "SELECT time
      FROM login_attempts
      WHERE user_id = :user_id
      AND time > '$valid_attempts'")
    ){
      $params = array(':user_id' => $user_id);
      // Execute the prepared query.
      $stmt->execute($params);
      // If there have been more than 5 failed logins
      if ($stmt->rowCount() > 5) {
          return true;
      } else {
          return false;
      }
    }
  }

  public function createPassword($password) {
    $salt = hash('sha512',md5(uniqid(mt_rand(), true)));
    $dbPwd = hash('sha512', $password.$salt);
    return array('pass' => $dbPwd, 'salt' => $salt);
  }

  /**
   * @todo delete unauthenticated session and cookie
   */
  public function logout($pdo){
    // get session parameters
    $params = session_get_cookie_params();
    header_remove("Set-Cookie");
    $cName = isset($_COOKIE[session_name()])? $_COOKIE[session_name()] : '';
    setcookie(
      session_name(),
      $cName, time() - 42000,
      $params["path"],
      $params["domain"],
      $params["secure"],
      $params["httponly"]
    );
    if(isset($_SESSION['user_id'])){
      // Destroy session
      $user = array(':user_id' => $_SESSION['user_id'] );
    }
    // Unset all session values
    $_SESSION = array();
    if(isset($user)){
      try{
        $sql = "DELETE FROM userSessions "
          . "WHERE user_id = :user_id";
        $q = $pdo->prepare($sql);
        $q->execute($user);
      } catch (PDOException $e) {
        echo "Please Report DataBase Error:<br>".$e->getMessage();
      } catch (Exception $e) {
        echo "Please Report General Error: <br>".$e->getMessage();
      }
    }
    session_unset();
    session_destroy();
    header('Location: '. AMS_SEO_URL);
  }

  private function dbSession($user_id, $userSessionId, $pdo) {
    if ($stmt = $pdo->prepare(
        "SELECT userSessionId, sessionTimeStamp,
        NewFormKey, CurrentFormKey, OldFormKey
        FROM userSessions
        WHERE user_id = :user_id
        LIMIT 1")) {
        $params = array(':user_id' => $user_id);
        $stmt->execute($params);
        $results  = $stmt->fetch();
        $ts = date('Y-m-d H:i:s');
        if (empty($results) || (strtotime($results['sessionTimeStamp']) < strtotime('120 minutes ago'))){
          // reduce security for easier logins...(remove line below)
          session_regenerate_id(true);
          $values = array(':user_id' => $user_id, ':userSessionId' => session_id());
          try{
            $sql = "INSERT INTO userSessions "
                  . " (user_id, userSessionId) "
                  . " VALUES "
                  . " ( :user_id, :userSessionId) "
                  . " ON DUPLICATE KEY UPDATE "
                  . " user_id = :user_id, userSessionId = :userSessionId, sessionTimeStamp = '".$ts."'";
            $q = $pdo->prepare($sql);
            $q->execute($values);
          } catch (PDOException $e) {
            echo "Please Report DataBase Error:<br>".$e->getMessage();
          } catch (Exception $e) {
            echo "Please Report General Error: <br>".$e->getMessage();
          }
        } elseif($userSessionId === $results['userSessionId']) {
          $values = array(':user_id' => $user_id, ':userSessionId' => session_id());
          if(isset($_SESSION['form_key']) && isset($_SESSION['old_form_key'])){
            $nFormKey = $_SESSION['form_key'];
            $cFormKey = $_SESSION['old_form_key'];
            $_SESSION['old_form_key'] = $results['NewFormKey'];
          } elseif(isset($_SESSION['form_key'])) {
            $nFormKey = $_SESSION['form_key'];
            $cFormKey= 'cFormKey';
          } else {
            $nFormKey = 'MissingFormKey';
            $cFormKey= 'NoFormKey';
          }
          try{
            $sql = "INSERT INTO userSessions "
                  . " (user_id, userSessionId) "
                  . " VALUES "
                  . " ( :user_id, :userSessionId) "
                  . " ON DUPLICATE KEY UPDATE "
                  . " user_id = :user_id, userSessionId = :userSessionId, sessionTimeStamp = '".$ts."', "
                  . " NewFormKey ='".$nFormKey."', CurrentFormKey = '".$cFormKey."'";
            $q = $pdo->prepare($sql);
            $q->execute($values);
          } catch (PDOException $e) {
            echo "Please Report DataBase Error:<br>".$e->getMessage();
          } catch (Exception $e) {
            echo "Please Report General Error: <br>".$e->getMessage();
          }
        } else {
            $sid = session_id();
            session_write_close();
            session_id($results['userSessionId']);
            session_start();
            session_destroy();
            session_write_close();
            session_id($sid);
            session_start();
            session_regenerate_id(true);
            $values = array(':user_id' => $user_id, ':userSessionId' => session_id());
            try{
              $sql = "INSERT INTO userSessions "
                    . " (user_id, userSessionId) "
                    . " VALUES "
                    . " ( :user_id, :userSessionId) "
                    . " ON DUPLICATE KEY UPDATE "
                    . " user_id = :user_id, userSessionId = :userSessionId, sessionTimeStamp = '".$ts."'";
              $q = $pdo->prepare($sql);
              $q->execute($values);
            //~ die($sid.'<|>'.$results['userSessionId'].'<|>'.session_id());
            } catch (PDOException $e) {
              echo "Please Report DataBase Error:<br>".$e->getMessage();
            } catch (Exception $e) {
              echo "Please Report General Error: <br>".$e->getMessage();
            }
        }
    }
  }


  public function login($email, $password, $pdo) {
    // Using prepared statements means that SQL injection is not possible.
    if ($stmt = $pdo->prepare(
      "SELECT id, username, password, salt, userType_iduserType
        FROM users
        WHERE email = :email
        or username = :email
        LIMIT 1")){
      $params = array(':email' => $email);
      $stmt->execute($params);
      $row  = $stmt->fetch();
      $user_id = $row['id'];
      $username = $row['username'];
      $db_password = $row['password'];
      $salt = $row['salt'];
      $userTypeID = $row['userType_iduserType'];

      // hash the password with the unique salt.
      $password = hash('sha512', $password . $salt);
      //return $password;
      if ($stmt->rowCount() == 1) {
        // If the user exists we check if the account is locked
        // from too many login attempts
        if ($this->checkbrute($user_id, $pdo) == true) {
          // Account is locked
          // Send an email to user saying their account is locked
          // at least this could be done here.\
          // could also send email to admin notifying of failed attempts
          return false;
        } else {
          // Check if the password in the database matches
          // the password the user submitted.
          if ($db_password == $password) {
            // Password is correct!
            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            // XSS protection as we might print this value
            $user_id = preg_replace("/[^0-9]+/", "", $user_id);
            $userTypeID = preg_replace("/[^0-9]+/", "", $userTypeID);
            $_SESSION['user_id'] = $user_id;
            // XSS protection as we might print this value
            $username = preg_replace("/[^a-zA-Z0-9_\-\s]+/", "", $username);
            $_SESSION['username'] = $username;
            $_SESSION['login_string'] = hash('sha512',
                      $password . $user_browser);
            settype($userTypeID, 'int');
           $_SESSION['userTypeID'] =  $userTypeID;
            // Login successful.
            $this->dbSession($user_id, session_id(), $pdo);
            return true;
          } else {
            // Password is not correct
            // We record this attempt in the database
            $ip = $_SERVER['REMOTE_ADDR'];
            $now = time();
            $pdo->query(
              "INSERT INTO login_attempts(user_id, time, ipaddress)
                VALUES ('$user_id', '$now', '$ip')");
            return false;
          }
        }
      } else {
        // No user exists.
        return false;
      }
    }
  }
}
?>

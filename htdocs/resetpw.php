<?php

//you will need to expicitly set below var to true to complete a password change
$SafeForUse = false;

date_default_timezone_set( "America/New_York" );
error_reporting(0);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', FALSE);

class aConfig {

  public $DB_HOST = 'localhost';
  public $DB_DATABASE = 'sample1';
  public $DB_USERNAME = 'user1';
  public $DB_PASSWORD = 'password1';
  public $DB_DSN;
  function __construct() {
    $this->DB_DSN = 'mysql:host='.$this->DB_HOST.';dbname='.$this->DB_DATABASE;
  }
}
function crypto_rand_secure($min, $max) {
  $range = $max - $min;
  if ($range < 0) return $min; // not so random...
  $log = log($range, 2);
  $bytes = (int) ($log / 8) + 1; // length in bytes
  $bits = (int) $log + 1; // length in bits
  $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
  do {
    $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
    $rnd = $rnd & $filter; // discard irrelevant bits
  } while ($rnd >= $range);
  return $min + $rnd;
}
function getToken($length){
  $token = "";
  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
  $codeAlphabet.= "0123456789";
  for($i=0;$i<$length;$i++){
    $token .= $codeAlphabet[crypto_rand_secure(0,strlen($codeAlphabet))];
  }
  return $token;
}
$token = getToken(35);
class db {

  private static $connection = NULL;

  public static function getInstance($DB_DSN, $DB_USERNAME, $DB_PASSWORD) {
    if (!self::$connection) {
      try {
        self::$connection = new PDO($DB_DSN, $DB_USERNAME, $DB_PASSWORD);
        self::$connection-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        die('Can\'t connect to AMS Database');
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      } catch (Exception $exc) {
        die('Can\'t connect to Database');
      }
    }
    return self::$connection;
  }
  public static function executeSql($sql, $array=array()){
    $conf = new aConfig;
    $db = self::getInstance(
      $conf->DB_DSN,
      $conf->DB_USERNAME,
      $conf->DB_PASSWORD
    );
    try{
      $q = $db->prepare($sql);
      $q->execute($array);
      $data = $q->fetchAll();
    } catch (PDOException $e) {
      echo "DataBase Error:<br>".$e->getMessage();
      die('DataBase Error'.$e->getMessage());
    } catch (Exception $e) {
      echo "General Error: <br>".$e->getMessage();
      die("General Error: <br>".$e->getMessage());
    }
    return $data;
  }

  public static function executeISql($sql, $array=array()){
    $conf = new aConfig;
    $db = self::getInstance(
      $conf->DB_DSN,
      $conf->DB_USERNAME,
      $conf->DB_PASSWORD
    );
    try{
      $q = $db->prepare($sql);
      $q->execute($array);
    } catch (PDOException $e) {
      echo "DataBase Error:<br>".$e->getMessage();
      return false;
      die('DataBase Error'.$e->getMessage());
    } catch (Exception $e) {
      echo "General Error: <br>".$e->getMessage();
      return false;
      die("General Error: <br>".$e->getMessage());
    }
    return true;
  }

  public static function executeSqlColumn($sql, $column=0, $array=array()){
    $conf = new aConfig;
    $db = self::getInstance(
      $conf->DB_DSN,
      $conf->DB_USERNAME,
      $conf->DB_PASSWORD
    );
    try{
      $q = $db->prepare($sql);
      $q->execute($array);
      $data = $q->fetchAll(PDO::FETCH_COLUMN, $column);
    } catch (PDOException $e) {
      echo "DataBase Error:<br>".$e->getMessage();
      die('DataBase Error'.$e->getMessage());
    } catch (Exception $e) {
      echo "General Error: <br>".$e->getMessage();
      die("General Error: <br>".$e->getMessage());
    }
    return $data;
  }
}
function baseForm(){
    echo '
  <form method="POST" autocomplete="off" action="'.curPageURL().'" >
    <fieldset>
      <legend>Password Reset Form</legend>
      <p>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" class="textbox-300"/>
      </p>
      <p>
        <input type="submit"/>
      </p>
    </fieldset>
  </form>';
}
function resetForm($email='', $rToken='', $headerMsg =''){
    echo "
    <h3>{$headerMsg}</h3>
  <form method='POST' autocomplete='off' action='".curPageURL()."' >
    <fieldset>
      <legend>Password Reset Form</legend>
      <p>
        <label for='email'>Email</label>
        <input type='text' name='email' id='email' value='{$email}' class='textbox-300'/>
        <input type='hidden' name='reset' id='reset'/>
      </p>
      <p>
        <label for='token'>Token</label>
        <input type='text' name='token' id='token' value='{$rToken}' class='textbox-300'/>
      </p>
      <p>
        <input type='submit'/><br>
      </p>
    </fieldset>
  </form>
        ";
    exit;
}
function changePwForm($userid='', $cToken='', $email='', $msg=''){
    if(false){
        die('changePwForm disabled');
    }
    if($msg !== '')
    echo "
    <h3>
    {$msg}
    </h3>";
    echo "
    <form method='POST' autocomplete='off' action='".curPageURL()."' onsubmit='return checkPassReturn();' >
      <fieldset>
        <legend>Password Reset Form</legend>
        <p>
          <label for='token'>Token</label>
          <input type='text' name='token' id='token' value='{$cToken}' class='textbox-300' readonly/>
          <input type='hidden' name='change' id='change'/>
          <input type='hidden' name='userid' id='userid' value='{$userid}'/>
        </p>
        <p>
          <label for='email'>Email</label>
          <input type='text' name='email' id='email' value='{$email}' class='textbox-300' readonly/>
        </p>
        <fieldset>
        <legend>New Password Form</legend>
          <p>
            <label for='pass1'>Password</label>
            <input type='password' name='pass1' id='pass1' value='' class='textbox-300' />
          </p>
          <p>
            <label for='pass2'>Passwor2</label>
            <input type='password' name='pass2' id='pass2' value='' class='textbox-300' onkeyup='checkPass(); return false;' />
            <span id='confirmMessage' class='confirmMessage'></span>
          </p>
        </fieldset>
        <p>
          <input type='submit'/><br>
        </p>
      </fieldset>
    </form>
        ";
    echo '<script>'.checkPass().'</script>';
    exit;
    die();
}
function checkPass(){
  return "
  function checkPass(){
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    " . '
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field
    //and the confirmation field
    if(pass1.value == pass2.value){
      //The passwords match.
      //Set the color to the good color and inform
      //the user that they have entered the correct password
      pass2.style.backgroundColor = goodColor;

      if(pass1.value.length < 8){
        pass1.style.backgroundColor = badColor;
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Password must be at least 8 characters."
        return false;
      } else {
        pass1.style.backgroundColor = goodColor;
      }
      message.style.color = goodColor;
      message.innerHTML = "Passwords Match!"
    } else {
      //The passwords do not match.
      //Set the color to the bad color and
      //notify the user.
      pass2.style.backgroundColor = badColor;
      message.style.color = badColor;
      message.innerHTML = "Passwords Do Not Match!"
    }
  }
  '."
  function checkPassReturn() {
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    pass1.style.backgroundColor = '#ffffff';
    pass2.style.backgroundColor = '#ffffff';
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    " . '
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    if(pass1.value !== pass2.value){
      pass2.style.backgroundColor = badColor;
      message.style.color = badColor;
      message.innerHTML = "Passwords Do Not Match!"
      return false;
    }
    if(pass1.value.length < 8){
      pass1.style.backgroundColor = badColor;
      pass2.style.backgroundColor = badColor;
      message.style.color = badColor;
      message.innerHTML = "Password must be at least 8 characters."
      return false;
    }
    return true;
  }';
}
function changePassword($userid, $token, $email){

    $tokenSQL = "SELECT EXISTS (
    SELECT * FROM pwReset where user_id = {$userid} AND token='{$token}' AND ts + INTERVAL 20 MINUTE > NOW())";
    $tokenData = db::executeSqlColumn($tokenSQL);
    if($tokenData[0] === 0)
            resetForm($email);
    if(!isset($_POST['pass1']) || !isset($_POST['pass2']))
        changePwForm($userid, $token, $email, 'Passwords not set, it must be at least 8 characters');

    if(($_POST['pass1'] !== $_POST['pass2']) && (strlen($_POST['pass1']) < 8))
        changePwForm($userid, $token, $email, 'Passwords do not match or is less than 8 characters');

    $uPass = createPassword($_POST['pass1']);

    $sql = "UPDATE `users` set "
        . "`password`= '".$uPass['pass']."', "
        ." `salt` = '".$uPass['salt']."' "
        . " WHERE "
        . " id = ".$userid;
        //~ db::executeISql();
    $pwChanged = db::executeISql($sql);
    if($pwChanged){
        echo '<p>Password has been reset.</p>';
    } else {
        die('Unknown Error Occured please contact support');
    }
    exit;
    die();
}

function createPassword($password) {
    $salt = hash('sha512',md5(uniqid(mt_rand(), true)));
    $dbPwd = hash('sha512', $password.$salt);
    return array('pass' => $dbPwd, 'salt' => $salt);
}

function newToken($userid, $email, $Safe4Use=false){
  $token = getToken(35);
  $pwSQL = "INSERT INTO pwReset (user_id, token) VALUES ({$userid}, '{$token}')
    ON DUPLICATE KEY UPDATE ts = CURRENT_TIMESTAMP, token = '{$token}'";
  $pwDr = db::executeISql($pwSQL);
  if($pwDr===false)
      die('Error Occured Please restart process.');
  $to = $email;
  $from = "noreply@localhost";
  $subject = 'AMS Password Reset';
  $mySig = <<<MESSAGE
<br><br>
<p>
  <i>
    <span style="font-size:8pt">
      "The information contained in the above e-mail message or messages (which include any attachments) may contain confidential, proprietary, or legally privileged information. It is intended only for the use of the person or entity to which it is addressed. If you are not the addressee, any form of disclosure, copying, modification, distribution, or any action taken or omitted in reliance on the information is unauthorized. If you received this communication in error, please notify the sender immediately and delete it from your computer system."&nbsp;
    </span>
  </i>
</p>
MESSAGE;
  $msg = 'A password reset has been initiated for AMS user '.$email.'<br>'
    .'Your reset token is <br> '.$token.' <br>and is valid for 20 minutes <br>'
    .'<br>'
    .'Please use the following link/url:<br>'
    .'<a href="'.curPageURL().'?email='.$email.'&token='.$token.'&reset">'.curPageURL().'</a>'
    .'<br>'
    .'<br>';
  $message = $msg;
  $headers = "From: $from" . "\n";
  $semi_rand = md5(time());
  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
  $headers .= "MIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
  $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
  $message .= "--{$mime_boundary}\n";
  //not sending emails at this point but should use the ok var to do so.
  $ok = false;

  var_dump( $Safe4Use);
  if($Safe4Use){
    echo '<pre>'.print_r($msg, true).'</pre>';
    resetForm($email);
  } else {
    resetForm($email, '', 'You will not be able to complete the password change process at this time.');
  }
  exit();
}
function resetCheck($userID, $gToken, $email, $SafeForUse=false){
  echo 'Checking Data...<br>';
  $dbToken = db::executeSqlColumn("select token FROM pwReset where user_id = {$userID}");
  echo 'getting db token...<br>';
  if(($dbToken[0] !== $gToken) || (empty($gToken)))
    newToken($userID, $email, $SafeForUse);
  echo 'loading form since a valid token was provided...<br>';
  changePwForm($userID, $gToken, $email);
  die('die');
}

function curPageURL() {
 $pageURL = 'http';
 if (@$_SERVER["HTTPS"] === "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] !== "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 $value = explode('?', $pageURL);
 return $value[0];
}

if(isset($_GET['email'])){
  $email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
  $_POST['email'] = $email;
}
if(!isset($_POST['email'])){
  baseForm();
  die();
}
if(!isset($email))
  $email = filter_input(INPUT_POST, 'email');
if($email === false){
  echo "E-Mail is not valid <br>";
  baseForm();
  die();
}
$userID = db::executeSqlColumn("select id FROM users where email = '{$email}'");
if(!empty($userID)){
  $userID = $userID[0];
  if(isset($_GET['change'])){
    $check = filter_input(INPUT_GET, 'change', FILTER_VALIDATE_EMAIL);
    if($check!==false)
      $_POST['change'] = $check;
  }
  if(isset($_GET['token'])){
    if(ctype_alnum(filter_input(INPUT_POST, 'token')))
      if(strlen($_GET['token']) !==35){
        resetForm($email);
      }
  }
  if(isset($_POST['token'])){
    if(ctype_alnum(filter_input(INPUT_POST, 'token')))
      if(strlen($_POST['token']) !==35){
        resetForm($email);
      }
  }
  if(isset($_POST['change'])){
    changePassword($userID, $_POST['token'], $email);
    die();
  }
  if(isset($_POST['reset']) || isset($_GET['reset'])){
    if(isset($_GET['token']) || isset($_POST['token'])){
      $ts = db::executeSqlColumn("select UNIX_TIMESTAMP(ts) FROM pwReset where user_id = {$userID}");
      if(empty($ts))
        $ts[0]=0;
        var_dump( $ts);
        echo strtotime('now').'<br>';
        echo strtotime('200 minutes', $ts[0]).'<br>';
        echo strtotime('200 minutes', 0).'<br>';
        // echo print_r(date("Y-m-d H:i:s", strtotime($ts[0])), true). '<-->'. print_r(date("Y-m-d H:i:s", strtotime('now')), true);
      if(strtotime('200 minutes', $ts[0]) < strtotime('now')){
        echo '<br>Auto sent Email with new token and please check your email box<br>';
        newToken($userID, $email, $SafeForUse);
      } else {
        if($ts[0] !== 0 && $ts[0] !== false && !empty($ts[0])){
          echo '<br>Token Received<br>';
        } else {
          newToken($userID, $email, $SafeForUse);
        }
      }
      $gToken = ctype_alnum(filter_input(INPUT_GET, 'token'));
      if($gToken===false)
        $gToken = ctype_alnum(filter_input(INPUT_POST, 'token'));
      if($gToken!==false)
        if(strlen(filter_input(INPUT_GET, 'token')) === 35){
          resetCheck($userID, filter_input(INPUT_GET, 'token'), $email, $SafeForUse);
        } else {
          resetForm($email);
        }
      resetForm($email);
    } else {
      resetForm($email);
    }
  } else {
    newToken($userID, $email, $SafeForUse);
  }
} else {
  echo ' user id Not Found';
}

<?php

error_reporting(E_ALL);
ini_set('display_errors','On');
if (isset($_POST['dbhost'])) {

preg_match( '/^[^-][a-z0-9-]{0,63}([^-]\.([a-z]{0,9}))?(;port=[0-9]{2,6})?$/i', $_POST['dbhost'], $matches);
echo "<pre>".print_r($matches, true)."</pre>";

die();


       $DB_HOST = $_POST['dbhost'];
       $DB_DATABASE = $_POST['dbname'];
       $DB_USERNAME = $_POST['dbuser'];
       $DB_PASSWORD = $_POST['dbpass'];

      $DB_DSN = 'mysql:host='.$DB_HOST.';dbname='.$DB_DATABASE;


  function installDB($DB_DSN, $DB_USERNAME,$DB_PASSWORD) {
  try{
      // Insert the tables
      $conn = new PDO( $DB_DSN, $DB_USERNAME, $DB_PASSWORD );
      $conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = file_get_contents('install.sql');
      $st = $conn->prepare ( $sql );
      $installed = $st->execute();
      } catch (PDOException $e) {
        die("$pd DataBase Error:<br>".$e->getMessage().'</p>');
        return "$pd DataBase Error:<br>".$e->getMessage().'</p>';
      } catch (Exception $e) {
        die("$pd DataBase Error:<br>".$e->getMessage().'</p>');
        return "$pd General Error: <br>".$e->getMessage().'</p>';
      }
      $conn = null;
      if($installed == 1){
          echo 'well not really a installer yet but database has been wiped and redone';
      } else {
          echo 'better get Houston on the line...';
					exit();
      }
      return $installed;
    }
  print_r(installDB($DB_DSN, $DB_USERNAME,$DB_PASSWORD));


  // unlink('install.sql');
  // unlink(__FILE__);
  // rmdir(__DIR__);
  // header('Location: ../');

} else {


?>


<script src='install.js' type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href='install.css'>
<div class='wrap'>
  <div class='outer'>
    <div class='inner'>
      <form name="Config Creation" method="post" action="">
        <fieldset>
          <legend>MySQL Database Configuration</legend>
          <label>Database Host:
            <div class="inLabel">
                <span class="inBlockRight"></span>
                <span class="inBlockLeft"></span>
                <span class="blockOfHid">
                    <input class="width100" type="text" name="dbhost" placeholder="localhost or localhost;port=3307" value="">
                </span>
            </div>
            <span class="text-center width100">(Do Not Include http:// or https://)</span>
          </label>
          <div class="clearSpace"></div>
          <label>Database Name:
            <div class="inLabel">
                <span class="inBlockRight"></span>
                <span class="inBlockLeft"></span>
                <span class="blockOfHid">
                    <input class="width100" type="text" name="dbname" placeholder="dbname" value="sample1">
                </span>
            </div>
          </label>
          <div class="clearSpace"></div>
          <label>Database Username:
            <div class="inLabel">
                <span class="inBlockRight"></span>
                <span class="inBlockLeft"></span>
                <span class="blockOfHid">
                    <input class="width100" type="text" name="dbuser" placeholder="username" value="user1">
                </span>
            </div>
          </label>
          <div class="clearSpace"></div>
          <label>Database Pass:
            <div class="inLabel">
                <span class="inBlockRight"></span>
                <span class="inBlockLeft"></span>
                <span class="blockOfHid">
                    <input class="width100" type="text" name="dbpass" placeholder="password1" value="password1">
                </span>
            </div>
          </label>
          <div class="clearSpace"></div>
        </fieldset>
        <div class="clearSpace"></div>
        <input type="submit" value="Create Config"><input type="reset" value="Reset">
      </form>
    </div>
  </div>
</div>

  <?php
}


?>

<?php

error_reporting(E_ALL);
ini_set('display_errors','On');
if (isset($_POST['dbhost'])) {

echo "<pre>".print_r($_POST, true)."</pre>";
die();

  $includesDir = str_replace('install', 'includes/', __DIR__);
  $amsConfigSource='<?php
    defined(\'_AMSgo\') or die;

    class amsConfig {

        public $DB_HOST = \''.$_POST['dbhost'].'\';
        public $DB_DATABASE = \''.$_POST['dbname'].'\';
        public $DB_USERNAME = \''.$_POST['dbuser'].'\';
        public $DB_PASSWORD = \''.$_POST['dbpass'].'\';
        public $DB_DSN;

        //Template configurations
        //Largly unused at this point
        public $ADMIN_TEMPLATE = \'base\';
        public $SITE_TEMPLATE = \'base\';
        public $TEMPLATE_PATH = \'templates\';

        function __construct() {
            $this->DB_DSN = \'mysql:host=\'.$this->DB_HOST.\';dbname=\'.$this->DB_DATABASE;
        }
    }

    define (\'AMS_SEO_URL\', AMS_DOMAIN.\''.$_POST['seovalue'].'\');
    define (\'AMS_SITE_NAME\', \''.$_POST['sitename'].'\');
    ';

    // if(){
    //
    // }else{
    //
    // }


  $configFile = $includesDir . 'config.php';

  $handle = fopen($configFile, 'w');
  if (fwrite($handle, $amsConfigSource) === false) {
    echo "Can not write to (".$configFile.")";
  } else {
    echo "Succesfully Wrote to (".$configFile.")";
    fclose($handle);
    // unlink(__FILE__);
  }

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
  header('Location: ../');

} else {


?>

<script>
  function swapConfig(x) {
    var radioEls = document.getElementsByName(x.name);
    for(i = 0 ; i < radioEls.length; i++){
      document.getElementById(radioEls[i].id.concat("Settings")).style.display="none";
    }
    document.getElementById(x.id.concat("Settings")).style.display="initial";
  }
</script>
<form name="Config Creation" method="post" action="">


  <fieldset>
    <legend>MySQL Database Configuration</legend>

      <label>Database Host:
        <input type="text" name="dbhost" id="dbhost" value="localhost">
      </label>

      <label>Database Name:
        <input type="text" name="dbname" value="sample1">
      </label>

      <label>Database User:
        <input type="text" name="dbuser" value="user1">
      </label>

      <label>Database Pass:
        <input type="password" name="dbpass" value="password1">
      </label>

      <label>Website Root Folder:
        <input type="text" name="seovalue" value="/">
      </label>

      <label>Site Name:
        <input type="text" name="sitename" value="Comapny Name">
      </label>

</fieldset>
  <fieldset>
    <legend>Url and Domain Configuration</legend>
    <p>
      <label>Production
        <input type="radio" onchange="swapConfig(this)" name="urlOptions" id="production" checked="checked" />
      </label>
      <label>
        Development
        <input type="radio" onchange="swapConfig(this)" name="urlOptions" id="development" />
      </label>
    </p>
    <div id="productionSettings">
      Production Settings
      <p>
        <label>Production
          <input type="text" name="p1" value="/">
        </label>
      <p/>
    </div>
    <div id="developmentSettings" style="display:none">
      <br/>Development Settings
      <p>
        <label>
          Developent
          <input type="text" name="d1" value="/">
        </label>
      <p/>
    </div>
  </fieldset>
  <input type="submit" value="Create Config"><input type="reset" value="Reset">
</form>

  <?php
}


?>

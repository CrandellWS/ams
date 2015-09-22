<?php

if (isset($_POST['dbhost'])) {

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

  $domain = $_SERVER['HTTP_HOST'];
  $docRoot = realpath($_SERVER['DOCUMENT_ROOT']);
  $dirRoot = __DIR__;
  $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
  $urlDir = str_replace('install', '',str_replace($docRoot, '', $dirRoot));
  $urlDir = str_replace('\\', '/',$urlDir);
  $rootDir = str_replace('install', '',$dirRoot);
  $site_path = $protocol.$domain.$urlDir;
  unlink('install.sql');
  unlink(__FILE__);
  rmdir(__DIR__);
  header('Location: ../');

} else {
  echo "<form name=\"Config Creation\" method=\"post\" action=\"".$PHP_SELF."\">";
  echo "Database Host: <input type=\"text\" name=\"dbhost\" value=\"localhost\"><br>";
  echo "Database Name: <input type=\"text\" name=\"dbname\" value=\"sample1\"><br>";
  echo "Database User: <input type=\"text\" name=\"dbuser\" value=\"user1\"><br>";
  echo "Database Pass: <input type=\"password\" name=\"dbpass\" value=\"password1\"><br>";
  echo "Website Root Folder: <input type=\"text\" name=\"seovalue\" value=\"/\"><br>";
  echo "Site Name: <input type=\"text\" name=\"sitename\" value=\"Comapny Name\"><br>";
  echo "<input type=\"submit\" value=\"Create Config\"><input type=\"reset\" value=\"Reset\">";
  echo "</form>";
}


?>

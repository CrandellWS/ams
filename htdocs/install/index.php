<?php

	error_reporting(E_ALL);
	ini_set('display_errors','On');

     $DB_HOST = 'localhost';
     $DB_DATABASE = 'sample1';
     $DB_USERNAME = 'user1';
     $DB_PASSWORD = 'password1';

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
    }
    return $installed;
  }
print_r(installDB($DB_DSN, $DB_USERNAME,$DB_PASSWORD));


    echo "<-|<br><br><br>";

    // Insert the tables
    $conn = new PDO( $DB_DSN, $DB_USERNAME, $DB_PASSWORD );
    $sql = 'SELECT assignedName FROM assignedName';

    $st = $conn->prepare ( $sql );
    $st->execute();
       $a2n = $st->fetchAll();
       $chkA2 = 0;
       $an = array();
       foreach ($a2n as $key => $value) {
           array_push($an, $value);
       }

       if(in_array('will', $an)){echo 'true';} else{ echo 'false';};
        echo '<br><pre>';
        print_r($an);
        echo '</pre>';

//unlink(install.sql);
// unlink(__FILE__);

<?php
/*
 * Core file for library and parameter handling:
 *
 * - $LastChangedDate: 2009-12-09 23:39:18 +0100 (Mi, 09 Dez 2009) $
 * - $Rev: 276 $
 */

// include("config/config.php");

  $dbname     = "miniwrike";
  /*$dbserver   = " 127.0.0.1";
  $dbuser     = "miniwrike";
  $dbpass     = "q3qpwtki";*/

  date_default_timezone_set('Europe/Bratislava');
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
// --- Connect to DB, retry 5 times ---
for ($i = 0; $i < 5; $i++) {
    //$db = mysqli_connect("mariadb55.websupport.sk", "miniwrike","Rw0ofT3v","miniwrike",3310);
    $db = mysqli_connect("localhost", "root","","miniwrike",3306); 
	 $errno = mysqli_errno($db);
    if ($errno == 1040 || $errno == 1226 || $errno == 1203) {
        sleep(1);
    }  else {
        break;
    }
}
mysqli_select_db($db, $dbname);

//
// Setup the UTF-8 parameters:
// * http://www.phpforum.de/forum/showthread.php?t=217877#PHP
//
// header('Content-type: text/html; charset=utf-8');
mysqli_query($db,'set character set utf8;');
mysqli_query($db,"SET NAMES `utf8`");


?>

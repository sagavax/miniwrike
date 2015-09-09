<?php
/*
 * Core file for library and parameter handling:
 *
 * - $LastChangedDate: 2009-12-09 23:39:18 +0100 (Mi, 09 Dez 2009) $
 * - $Rev: 276 $
 */

// include("config/config.php");

  $dbname     = "miniwrike"; 
  $dbserver   = ":/tmp/mariadb55.sock"; 
  $dbuser     = "q3qpwtki"; 
  $dbpass     = "q3qpwtki"; 

  date_default_timezone_set('Europe/Bratislava');

// --- Connect to DB, retry 5 times ---
for ($i = 0; $i < 5; $i++) {
	
    $db = mysql_connect("$dbserver", "$dbuser", "$dbpass");
    $errno = mysql_errno();
    if ($errno == 1040 || $errno == 1226 || $errno == 1203) {
        sleep(1);
    }  else {
        break;
    }
}
mysql_select_db("$dbname", $db);

//
// Setup the UTF-8 parameters:
// * http://www.phpforum.de/forum/showthread.php?t=217877#PHP
//
// header('Content-type: text/html; charset=utf-8');
mysql_query('set character set utf8;');
mysql_query("SET NAMES `utf8`");


?>

<?php
  date_default_timezone_set('Europe/Bratislava');


 //$link = mysqli_connect("mariadb101.websupport.sk", "minecraft_db", "eTIZAAMcSL", "minecraft_db", 3312);
 $db = mysqli_connect("mariadb105.r6.websupport.sk", "miniwrike", "Ul0XB&a@%d","miniwrike",3315);



  if (!$db) {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    exit;
  }

//
// Setup the UTF-8 parameters:
// * http://www.phpforum.de/forum/showthread.php?t=217877#PHP
//
// header('Content-type: text/html; charset=utf-8');
mysqli_query($db,'set character set utf8;');
mysqli_query($db,"SET NAMES `utf8`");
?>

<?php session_start() ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
 
      <title>Miniwrike - simple project task manager</title>
      <link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
      <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
      <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
      <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
      <link rel='shortcut icon' href='project.ico'>
   </head>
   <body>
      <?php 
         $project_id=$_GET['project_id'];
         $project_id=$_SESSION['project_id'];
          $user_id=$_SESSION['user_id'];
         ?>
      <div id="main">
         <!-- header -->
         <?php include ("include/header.php"); ?>
         <?php include ("include/menu.php"); ?>
         <!-- header -->
         <div id="middle">
            <!-- middle section -->
            <div id="project_title">
               <!-- project title -->
               <?php
                  $sql="SELECT * from projects where id=$project_id";
                  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
                  while ($row = mysqli_fetch_array($result)) {
                      $project_name=$row['project_name'];
                      $project_description=$row['project_descr'];
                  
                      //echo "<div id='project_short_details_wrap'>";
                      echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name</span>";   //boldovo
                      echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
                      //echo "</div>";
                  
                  }
                  
                  ?>
            </div>
            <!-- project title -->
            <div id="project_stream_wrap">
               <h3> Project stream </h3>
               <ul>
                  <?php 
                     $sql="SELECT * from project_stream where project_id=$project_id ORDER by id DESC";
                     $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
                     	while ($row = mysqli_fetch_array($result)) {
                     	$text_of_stream = $row['text_of_stream'];
                     	$date_added = $row['date_added'];
                     
                     	echo "<li><div class='stream_post'><span style='margin-left:5px;float:left'><i class='fa fa-clock-o'></i></span><span class='stream_post_text'>$text_of_stream</span><span class='stream_post_date'>$date_added</span></div></li>";
                     
                     		}	
                     	?>
               </ul>
            </div>
         </div>
         <!-- middle section -->
         <?php include ("include/footer.php"); ?>
      </div>
      <!--main wrap -->
   </body>
</html>
<?php session_start();?>
<?php include "include/dbconnect.php"?>
<?php include "include/functions.php"?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
      <title>Miniwrike - simple project task manager</title>
      <link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
      <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
      <script type="text/javascript" src="js/facebox.js"></script>
      <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
      <link rel='shortcut icon' href='project.ico'>
   </head>
   <body>
      <?php

      $project_id = $_SESSION['project_id'];

?>
      <div id="main">
         <!-- header -->
         <?php include "include/header.php";?>
         <!-- header -->
         <?php
?>
         <?php include "include/menu.php";?>

          <?php echo ProjectTitle($project_id); ?>

         <!-- project title -->
         <div id="middle">
            <div id="project_meetings_wrap">
               <div id="add_file">
                  <form action='project_docs.php' method='post'><input type="hidden" name="project_id" value="<?php echo $project_id; ?>"><input type="hidden" name="user_id" value="<?php echo $user_id; ?>">  <button type="submit" class="blue-badge" name="add_file">+Add file</button></form>
               </div>
            </div>
            <div id="project_attachements_wrap">
               <?php
echo "<table id='project_docs'>";

$sql = "SELECT * from project_documents";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {

	//$id=$row['id'];
	$meeting_id = $row['meeting_iid'];
	$project_id = $row['project_id'];
	$path = $row['path']; // user ktory pridal ten attachement
	$file_name = $row['atendees'];
	$file_type = $row['location'];
	$date_added = $row['meeting_type'];
	$added_by = $row['user_id'];
	$added_date = $row['added_date'];
	//   $meeting_log=$row['meeting_log'];

	echo "<tr>";
	echo "<td>$icon</td><td>file_name</td><td>path</td><td><td>$added_by</td><td>$added_date</td>";
	echo "</tr>";

}

echo "</table>";

?>
            </div><!--project_attachement_wrap -->
         </div><!--middle -->
         <!-- wrapper-->

      <!--middle part -->
      <?php include "include/footer.php";?>
      <!--main wrap -->
   </body>
</html>
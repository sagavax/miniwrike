<?php session_start(); ?>
<?php include ("include/dbconnect.php") ?>
<?php include ("include/functions.php") ?>
<?php
   if (isset($_POST['add_file'])){
      $project_id=$_POST['project_id'];
      $user_id=$_POST['user_id'];
      $url="project_docs_upload.php?project_id=$project_id";
      header('location:'.$url.'');
   }
   
   ?>  
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
 
      <title>Miniwrike - simple project task manager</title>
      <link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
      <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
      <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
      <script type="text/javascript" src="js/facebox.js"></script>
      <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' 
      <link rel='shortcut icon' href='project.ico'>
   </head>
   <body>
      <?php 
         
         $project_id=$_SESSION['project_id'];
         $user_id = $_SESSION['user_id'];
         
         ?>
      <div id="main">
         <!-- header -->
         <?php include ("include/header.php"); ?>
         <!-- header -->
         <?php 
            $project_id=$_GET['project_id'];
            
            ?>
         <?php include ("include/menu.php"); ?>
         <div id="project_title">
            <!-- project title -->
            <?php
               $project_id=$_GET['project_id'];
               $sql="SELECT * from projects where id=$project_id";
               $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
                  while ($row = mysqli_fetch_array($result)) {
                     $project_name=$row['project_name'];
                     $project_description=$row['project_descr'];
               
                     //echo "<div id='project_short_details_wrap'>";
                     echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Roboto, Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";   //boldovo
                     echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Roboto, Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
                     //echo "</div>";
               
                  }
               
                  ?>
         </div>
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
                  
                  
                   $sql="SELECT * from project_documents";
                        $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
                              while ($row = mysqli_fetch_array($result)) {
                              
                              //$id=$row['id'];
                              $meeting_id=$row['meeting_iid'];
                              $project_id=$row['project_id'];
                              $path=$row['path']; // user ktory pridal ten attachement
                              $file_name=$row['atendees'];
                              $file_type=$row['location'];
                              $date_added=$row['meeting_type'];
                              $added_by=$row['user_id'];
                              $added_date=$row['added_date'];
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
      <?php include ("include/footer.php"); ?>
      <!--main wrap -->
   </body>
</html>
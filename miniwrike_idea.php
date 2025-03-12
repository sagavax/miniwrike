<?php session_start();
 include "include/dbconnect.php";
 include "include/functions.php";

  if(isset($_POST['save_idea_comment'])){
        $comment_header = $_POST['idea_comment_header'];
        $comment = $_POST['idea_comment'];
        $idea_id = $_SESSION['idea_id'];

        $save_comment = "INSERT into ideas_comments (idea_id,idea_comm_header, idea_comment, comment_date) VALUES ($idea_id,'$comment_header','$comment',now())";
         //echo $save_comment;
         $result=mysqli_query($db, $save_comment);

      
        $diary_text="Minecraft IS: Bolo pridany novy kommentar k idei id <b>$idea_id</b>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($db, $sql) or die("MySQLi ERROR: ".mysqli_error($db));
       
         header("Location: " . $_SERVER['REQUEST_URI']);
         exit();

      }

      
      if(isset($_POST['delete_comm'])){
        $comm_id = $_POST['comm_id'];
        //var_dump($_POST);
        $delete_comment = "DELETE from ideas_comments WHERE comm_id = $comm_id";
        //echo $delete_comment;
        $result=mysqli_query($db, $delete_comment);

         echo "<script>message('Comment deleted','success')</script>";
      }

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <title>Miniwike</title>
    <link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="css/ideas.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel='shortcut icon' href='project.ico'>
    <script type="text/javascript" src="js/ideas.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
</head>

  </head>
<body>
		<div id="main">
			 <?php include "include/header.php";?>
		
        	<div id="middle">
            </div>
        </div>        
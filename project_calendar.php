<? ob_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>



<?php
            
 ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		    
		<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/facebox.js"></script> -->
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' 
		<link rel='shortcut icon' href='project.ico'>
				
	</head>
<body>

        <?php 
			$project_id = $_GET ['project_id'];
			$user_id = $_GET['user_id'];
		
		?>
         
		<div id="main">
			
			<!-- header -->
				 <?php include("include/header.php"); ?>
			<!-- header -->	 
             
             <div id="menu">
               	<?php include("include/menu.php"); ?>
            </div>
			


            <div id="project_title"><!-- project title -->
               <?php

                $sql="SELECT * from projects where id=$project_id";
                $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
                while ($row = mysql_fetch_array($result)) {
                    $project_name=$row['project_name'];
                    $project_description=$row['project_descr'];

                    echo "<div id='project_short_details_wrap'>";
                    echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";   //boldovo
                    echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#ddd;margin-left:15px'>$project_description</span>"; //italikom
                    echo "</div>";

                }

                ?>
            </div><!-- project title -->

			<!-- header -->
			
			<!--- middle section -->
			
			            
			<div id="middle"> <!-- middle section -->
        	
			
            </div>
            <div style="clear:both;"></div>
            
						
			<?php include("include/footer.php"); ?>
			
		</div>
</body>
</html>
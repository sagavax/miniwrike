<? ob_start(); ?>
<?php 
  $dbname     = "miniwrike"; 
  $dbserver   = "localhost"; 
  $dbuser     = "root"; 
  $dbpass     = ""; 


  $db = mysql_connect("$dbserver", "$dbuser", "$dbpass");
  $errno = mysql_errno();
  mysql_select_db("$dbname", $db);
  mysql_query('set character set utf8;');
  mysql_query("SET NAMES `utf8`");

 ?>
 
 <?


/*	Názov	Typ	Zotriedenie	Atribúty	Nulový	Predvolené	Extra	Akcia
	 1	id	int(11)	
	 2	date_of_meeting	datetime
	 3	start_time
	 4	end_time
	 5	atendees
	 6	meeting_log	text
	 7	created_date
*/
 ?> 

 <?php 

 	if (isset($_POST['update_miting'])) {
 		$id=$_POST['id'];
 		$meeting_record=htmlspecialchars($_POST['meeting_record']);
 		//echo "$id";
 		$sql="UPDATE project_meetings SET meeting_log='$meeting_record' WHERE id=$id";
 		//echo "$sql";
 		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
 		header('Location: project_meetings.php');
 		

 		//$id=$_POST['id'];
 		# code...
 	}

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
		    
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
		<script type="text/javascript" src="js/facebox.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' 
		<link rel='shortcut icon' href='project.ico'>
				
	</head>
<body>

        <?php 
			$project_id = $_GET ['project'];
			$user_id = $_GET['user_id'];
		
		?>
         
		<div id="main">
			
			<!-- header -->
			
			<div id="header">miniwrike<div class="logged_user"><div class="circle"></div><div class="user">Tomas Misura</div></div></div>
             <div id="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="project_details.php?project=<?php echo $project_id ?>">Project details</a></li>
                    <li><a href="project_tasks.php?project=<?php echo $project_id ?>">Tasks</a></li>
                    <li><a href="project_comments.php?project=<?php echo $project_id ?>">Comments</a></li>
					<li><a href="project_meetings.php?project=<?php echo $project_id ?>">Meetings*</a></li>
					<li><a href="project_calendar.php?project=<?php echo $project_id ?>">Calendar*</a></li>
                    <li><a href="project_stream.php?project=<?php echo $project_id ?>">Time stream*</a></li>
					<li><a href="project_docs.php?project=<?php echo $project_id ?>">Docs*</a></li>
					
                </ul>
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
				<div id="project_attachements_wrap">
					<?php 
					  
						$id=$_GET['m_id'];


					 echo "<table id='project_docs'>";	

						 $id=2;
						 $sql="SELECT * from project_attachements";
								// $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
										while ($row = mysql_fetch_array($result)) {
										
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
				</div> <!-- wrapper-->
			</div><!-- middle section -->
				
			<div id="footer"><!-- FOOTER -->
					<ul id="footer-left">
						<li>Simple miniproject administrator/manager</li>
						<li>Created by Tomas Misura</li>
					</ul>		
			</div> <!-- FOOTER -->
			
			
		</div> <!--main wrap -->
			


</body>
</html>
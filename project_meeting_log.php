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
		    
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/facebox.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
				
	</head>
<body>

        <?php 
			$project_id = $_GET ['project_id'];
			$user_id = $_GET['user_id'];
		
		?>
         
		<div id="main">
			
			<!-- header -->
			
			<div id="header"><div style="position:relative; top:30%;">miniwrike - simple project manager tool - meeting logger</div></div>
             <div id="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="project_details.php">Project details</a></li>
                    <li><a href="project_tasks.php">Tasks</a></li>
                    <li><a href="project_comments.php">Comments</a></li>
					<li><a href="project_meetings.php">Meetings*</a></li>
					<li><a href="project_calendar.php">Calendar*</a></li>
                    <li><a href="project_stream.php">Time stream*</a></li>
					<li><a href="project_docs.php">Docs*</a></li>					
                </ul>
            </div>
			


            <div id="project_title"><!-- project title --->
                <?php
                //get project name and description
                $sql="SELECT * from projects where id=2";
                //echo $sql;
                $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
                while ($row = mysql_fetch_array($result)) {
                    $project_name=$row['project_name'];
                    $project_description=$row['project_descr'];

                    echo "<div id='project_short_details_wrap'>";
                    echo "<span style='font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;'>$project_name<br></span>";   //boldovo
                    echo "<span style='font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif; margin-top:10px; color:#ddd'>$project_description</span>"; //italikom
                    echo "</div>";

                }

                ?>
            </div><!-- project title --->

			<!-- header -->
			
			<!--- middle section -->
			<div id="middle"> <!-- middle section -->
				<div id="project_meetings_wrap">
					<?php 
					  
						$id=$_GET['m_id'];


					  echo "<form action='log_meeting.php' method='post' id='uprav_meeting_form'>";
							echo "<table id='meeting_logger'>";	

					 $id=1;
					 $sql="SELECT * from project_meetings WHERE id=$id";
							 $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
									while ($row = mysql_fetch_array($result)) {
									
									//$id=$row['id'];
									$date_of_meeting=$row['date_of_meeting'];
									$start_time=$row['start_time'];
									$end_time=$row['end_time'];
									$atendees=$row['atendees'];
									$location=$row['location'];
									$meeting_type=$row['meeting_type'];
								 //   $meeting_log=$row['meeting_log'];	


					 
								echo "<input type='hidden' value='$id' name='id'>";
								echo "<tr><td>Datum meetingu:</td><td><input type='text' name='datum_mitingu' value='$date_of_meeting' /></td></tr>";
								echo "<tr><td>Zaciatok:</td><td><input type='text' name='start_time' value='$start_time' /></td></tr>";
								echo "<tr><td>Koniec:</td><td><input type='text' name='end_time' value='$end_time' /></td></tr>";
								echo "<tr><td>Typ mitingu:</td><td><input type='text' name='meeting_type' value='$meeting_type' /></td></tr>";
								echo "<tr><td>Miesto konania:</td><td><input type='text' name='location' value='$location' /></td></tr>";
								echo "<tr><td>Ucastnici</td><td><input type='text' name='atendees' value='$atendees' /></td></tr>";
								echo "<tr><td>Zaznam</td><td><textarea name='meeting_record'></textarea></tr>";
								echo "<tr><td colspan='2' style='text-align: right'><button type='submit' name='update_miting'>Uprav meeting</button>";
							}
																				//echo "<tr><td>Text:</td><td><textarea name='text_clanku'>$text_clanku</textarea></td></tr>";
							echo "</table>";
						echo "</form>";	

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
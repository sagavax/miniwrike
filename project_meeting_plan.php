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

 	if (isset($_POST['novy_miting'])) {
 		$datum_mitingu=$_POST['datum_mitingu'];
 		$start_time=$_POST['start_time'];
 		$end_time=$_POST['end_time'];
 		$meeting_type=$_POST['meeting_type'];
 		$location=$_POST['location'];
 		$atendees=$_POST['atendees'];
 		$datum = date('Y-m-d H:i:s');

 		
 		$sql="INSERT INTO meetings (date_of_meeting, start_time, end_time, meeting_type, location,atendees, meeting_log, created_date) VALUES ('$datum_mitingu','$start_time','$end_time','$meeting_type','$location','$atendees','', '$datum')";
 		//echo "$sql";
 		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
 		 header('Location: project_meetings.php');
 	}

 ?>

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
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>
		<div id="main">
			
			<!-- header -->
			
			<div id="header">miniwrike - simple project manager tool - project details</div>
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
			
			
			
			<?php 
				
				$project_id= $_GET['$id']; // proketove id
				$user_id=$_GET['uid'];      //uzivatelske id
			
			?>
			
			
						
			<div id="middle"> <!-- middle section -->
				<div id="project_meetings_wrap">
				  <h3>Meeting scheduler</h3>
				  <?php 
				  echo "<form action='project_meeting_plan.php' method='post' id='new_meeting_form'>";
						echo "<table id='project_meeting_planner'>";
							echo "<tr><td>Datum meetingu:</td><td><input type='text' name='datum_mitingu' value='' /></td></tr>";
							echo "<tr><td>Zaciatok:</td><td><input type='text' name='start_time' value='' /></td></tr>";
							echo "<tr><td>Koniec:</td><td><input type='text' name='end_time' value='' /></td></tr>";
							echo "<tr><td>Typ mitingu:</td><td><input type='text' name='meeting_type' value='' /></td></tr>";
							echo "<tr><td>Miesto konania:</td><td><input type='text' name='location' value='' /></td></tr>";
							echo "<tr><td>Ucastnici</td><td><input type='text' name='atendees' value='' /></td></tr>";
							echo "<tr><td colspan='2'><button type='submit' name='novy_miting'>New meeting</button>";
																			//echo "<tr><td>Text:</td><td><textarea name='text_clanku'>$text_clanku</textarea></td></tr>";
						echo "</table>";
					echo "</form>";	

				 ?>
				
				</div>
		
			</div>
			
			<!-- FOOTER -->
			
			<div id="footer">
				<ul id="footer-left">
					<li>Simple miniproject administrator/manager</li>
					<li>Created by Tomas Misura</li>
				</ul>		
			</div> <!-- FOOTER -->
			
		</div>
			
</body>
</html>
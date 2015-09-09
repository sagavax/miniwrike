<? session_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>

 <!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />
	<title>Meetings - meeting minutes</title>
	
</head>
<body>
	<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
	<body>
		<div id="main">
			<!-- header -->
			
			<?php include ("include/header.php"); ?>
           <?php include ("include/menu.php"); ?>
			
			<!-- header -->
			
			<?php 
				
				$project_id= $_GET['$id']; // proketove id
				$user_id=$_GET['uid'];      //uzivatelske id
			
			?>
			
				<div id="middle"> <!-- middle section -->
					
					<div id="project_title"><!-- project title -->
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
            </div><!-- project title -->

					<div id="project_meetings_wrap"><!-- project_meetings_wrap -->
      
					  <?php

					$id=$_GET['m_id'];
					
					echo "<table id='project_meeting_viewer'>";		
						$sql="SELECT * from project_meetings WHERE id=$id";
						//echo "$sql";	
							$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
								while ($row = mysql_fetch_array($result)) {
								$i++;
								$id=$row['id'];
								$project_id=$row['project_id'];
								$meeting_title=$row['meeting_title'];
								$date_of_meeting=$row['date_of_meeting'];
								$start_time=$row['start_time'];
								$end_time=$row['end_time'];
								$atendees=$row['atendees'];
								$location=$row['location'];
								$meeting_type=$row['meeting_type'];
								$meeting_log=$row['meeting_log'];
					   

								echo "<tr><td class='bold'>Nazov meetingu:</td><td><input type='text' name='nazov_mitingu' value='$meeting_title' /></td></tr>";
								echo "<tr><td class='bold'>Datum meetingu:</td><td><input type='text' name='datum_mitingu' value='$date_of_meeting' /></td></tr>";
								echo "<tr><td class='bold'>Zaciatok:</td><td><input type='text' name='start_time' value='$start_time' /></td></tr>";
								echo "<tr><td class='bold'>Koniec:</td><td><input type='text' name='end_time' value='$end_time' /></td></tr>";
								echo "<tr><td class='bold'>Typ mitingu:</td><td><input type='text' name='meeting_type' value='$meeting_type' /></td></tr>";
								echo "<tr><td class='bold'>Miesto konania:</td><td><input type='text' name='location' value='$location' /></td></tr>";
								echo "<tr><td class='bold'>Ucastnici</td><td><input type='text' name='atendees' value='$atendees' /></td></tr>";
								echo "<tr><td>Zaznam</td><td><div id='meeting_log'>".nl2br($meeting_log)."</div></tr>";
								//echo "<tr><td colspan='2'><button type='submit' name='update_miting'>Novy meetingk</button>";
							}					                       				//echo "<tr><td>Text:</td><td><textarea name='text_clanku'>$text_clanku</textarea></td></tr>";
					echo "</table>";


					 ?>
					<a href="project_meetings.php?project_id=<?php echo $project_id ?>"><< Back</a>						
					</div> <!-- project_meetings_wrap -->
					

			</div><!-- middle section -->
				
			<?php include ("include/footer.php"); ?>
			
			
		</div> <!--main wrap -->
</body>
</html>
<?php session_start(); ?>
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
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>
	<div id="main">
						
			<!-- header -->
				<?php include ("include/header.php"); ?>
            <!-- header -->
            
				<?php 

				//$project_id=$_GET['project_id'];
				$project_id=$_SESSION['project_id'];
				$user_id=$_SESSION['user_id'];

				?>
           <?php include ("include/menu.php"); ?>

            <div id="project_title"><!-- project title -->
					<?php
					//$project_id=$_GET['project_id'];
					$sql="SELECT * from projects where id=$project_id";
					$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						while ($row = mysql_fetch_array($result)) {
							$project_name=$row['project_name'];
							$project_description=$row['project_descr'];

							//echo "<div id='project_short_details_wrap'>";
							echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Roboto, Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";   //boldovo
							echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Roboto, Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
							//echo "</div>";

						}

						?>
				</div><!-- project title -->

            <div id="middle"> <!-- middle section -->
            <div id="cal_nav_bar"><form action="project_calendar.php" method="post"> 
            							<select name="calendars">
            								<option value="event_cal">Event calendar</option>
            								<option value="team_cal">Team calendar</option>						
            							</select><button name="sel_cal" class="blue-badge">OK</button>
            					   </form>	
            </div>	
            	<?php 
        			  	if(isset($_POST['sel_cal'])){
        			  		// /var_dump($_POST);
        			  		$cal=$_POST['calendars'];
        			  		//echo $cal;
        			  		if($cal=='event_cal'){ //event kalendar
        			  			$month=date('m');
	                  		//echo "$mmonth";
	                  		$year = date('Y');
	                  		if ((isset($_GET['date'])) && ($_GET['date']))
	                    	list($month, $year) = explode('-', $_GET['date']);	
        		         	$project_id=$_SESSION['project_id'];
        		         	echo draw_project_calendar($month,$year,$project_id);
        		         	
        			  		} elseif ($cal='team_cal') {

        			  		$sql="SELECT * from project_assigned_people WHERE project_id=$project_id";
		            		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());	
		            		echo "<table class='team_list'>";	
		            		echo "<tr><td style='width:15%'></td><td style='width:85%'></td></tr>";
		            		echo "<tr><td></td><td></td></tr>";
		            			while ($row = mysql_fetch_array($result)) {
		            				$user_id=$row['user_id'];
						             $user_name = GetUserNameById($user_id);
						             echo "<tr><td>$user_name</td><td></td></tr>";
		            			}
		            			echo "</table>";	
        			  		}
        			  	}
        			        
        		?>
				
           
            
            

            </div><!-- div middle -->
           
            
						
			<?php include ("include/footer.php"); ?>
			
		</div><!-- main -->	

</body>
<html>
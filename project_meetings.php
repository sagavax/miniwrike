
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>
<?php session_start(); ?>
<?php 
	if(isset($_POST['add_meeting'])){
		$project_id=$_POST['project_id'];
		var_dump($_POST);
		$url="project_meeting_plan.php?project_id=$project_id";
		echo $url;
		header('location:'.$url.'');
	}
?>

 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'> 
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
	<body>
		<?php 
			$project_id = $_GET ['project_id'];
			$user_id = $_SESSION['user_id'];
			//$day=$_GET['day'];
		  //echo "Project: ".$_SESSION['project_id'];
		
		?>

		<div id="main">
			<!-- header -->
		
		<?php include ("include/header.php"); ?>
           <?php include ("include/menu.php"); ?>
				
				<div id="middle"> <!-- middle section -->
				
					<div id="project_title"><!-- project title -->
		               <?php
		               	
		                $sql="SELECT * from projects where id=$project_id";
		                $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
		                while ($row = mysqli_fetch_array($result)) {
		                    $project_name=$row['project_name'];
		                    $project_description=$row['project_descr'];

		                    
		                    echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";   //boldovo
		                    echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#ddd;margin-left:15px'>$project_description</span>"; //italikom
		                    

		                }

		                ?>
            		</div><!-- project title -->
					
					<div id="project_calendar">
						<?php
							//$month = idate('m');
	                  		$month=date('m');
	                  		//echo "$mmonth";
	                  		$year = date('Y');
	                  		if ((isset($_GET['date'])) && ($_GET['date']))
	                    	list($month, $year) = explode('-', $_GET['date']);

							 echo draw_project_meeting_calendar($month,$year,$project_id);

						 ?>	
					</div>				
					
					<div id="project_meetings_wrap">
						<div id="add_meeting"><form action='project_meetings.php' method='post'><input type="hidden" name="project_id" value="<?php echo $project_id; ?>"><button type="submit" class='blue-badge' name="add_meeting"><i class="fa fa-plus"></i> Add meeting</button></form></div>
						<div id="project_meetings_list"><!-- project_meetings_list -->
						<h3>Meetings:</h3>	


							<table>
								
								<?php
								$i=0;
								
								//list of the meetings
								 $sql="SELECT * from project_meetings where project_id=$project_id";
								 $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
										while ($row = mysqli_fetch_array($result)) {
										$i++;
										$id=$row['id'];
										$created_by=$row['created_by'];
										$meeting_title=$row['meeting_title'];
										$date_of_meeting=$row['date_of_meeting'];
										$start_time=$row['start_time'];
										$end_time=$row['end_time'];
										//$atendees=$row['atendees'];
										$meeting_log=$row['meeting_log'];
										$location=$row['location'];
										$meeting_type= $row['meeting_type'];
										$updated=$row['updated'];
										
								 echo "<tr><td>$i.</td><td style='width:450px'>$meeting_title</td><td><a href='project_user_profile.php?user_id=$user_id'><span style='color:#666'>".GetUserNameById($user_id)."</span></a></td><td>$date_of_meeting</td><td>$start_time</td><td>$end_time</td><td><span class='blue-badge'>". NrOfAttendees($id)."</span></td><td>$location</td><td>$meeting_type</td>";
									if ($updated==0)  { //nie je tam ziaden zaznam, je len napplanovany, respe
										
										echo "<td><a href='project_meeting_edit.php?m_id=$id&project_id=$project_id' class='blue-badge'><i class='fa fa-pencil-square-o'></i></a></td>"; //tak zacni pisat zaznam o mitingu
										echo "<td><a href='project_meeting_log.php?m_id=$id&project_id=$project_id' class='blue-badge'><i class='fa fa-play'></i></a></td>"; //tak zacni pisat zaznam o mitingu

									} else {
										
										echo "<td><a href='project_meeting_edit.php?m_id=$id&project_id=$project_id' class='blue-badge'><i class='fa fa-pencil-square-o'></i></a></td>";
										echo "<td><a href='project_meeting_minutes.php?m_id=$id' class='blue-badge'><i class='fa fa-eye'></i></a></td>";  //prezri si miting

									}

								 echo "</tr>";      
								 } //koniec cyklu 
								?>
							</table>
						</div><!-- project_meetings_list -->
					</div>	
					
					
						
				</div><!-- middle section -->
				
			<?php include ("include/footer.php"); ?>
			
			
		</div> <!--main wrap -->
			
</body>
</html>
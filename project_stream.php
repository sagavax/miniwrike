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
		<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' 
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
	<body>
		

			 <?php 
				$project_id=$_GET['project_id'];
			?>
         

		<div id="main">
						
			<!-- header -->
				<div id="header">miniwrike<div class="logged_user"><div class="circle"></div><div class="user">Tomas Misura</div></div></div>
            <!-- header -->
            
            <div id="menu">
                <ul>
                    <li><a href="index.php"><i class="icon-home"></i>Home</a></li>
                    <li><a href="project_details.php?project_id=<?php echo $project_id ?>"><i class="icon-info-sign"></i>Project details</a></li>
                    <li><a href="project_tasks.php?project_id=<?php echo $project_id ?>"><i class="icon-tasks"></i>Tasks</a></li>
                    <li><a href="project_comments.php?project_id=<?php echo $project_id ?>"><i class="icon-comments"></i>Comments</a></li>
					<li><a href="project_meetings.php?project_id=<?php echo $project_id ?>"><i class="icon-chat"></i>Meetings*</a></li>
					<li><a href="project_calendar.php?project_id=<?php echo $project_id ?>"><i class="icon-calendar"></i>Calendar*</a></li>
                    <li><a href="project_stream.php?project_id=<?php echo $project_id ?>"><i class="icon-time"></i>Time stream*</a></li>
					<li><a href="project_docs.php?project_id=<?php echo $project_id ?>"><i class="icon-folder-close"></i>Docs*</a></li>
					
					
                </ul>
            </div>
			
			
			
			
			
				<div id="middle"> <!-- middle section -->
					<div id="project_title"><!-- project title -->
			            <?php

			                $sql="SELECT * from projects where id=$project_id";
			                $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
			                while ($row = mysql_fetch_array($result)) {
			                    $project_name=$row['project_name'];
			                    $project_description=$row['project_descr'];

			                    //echo "<div id='project_short_details_wrap'>";
			                    echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name</span>";   //boldovo
			                    echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
			                    //echo "</div>";

			                }

                		?>
            </div><!-- project title -->
					<div id="project_stream_wrap">
						<h3> Project stream </h3>
						<ul>
						<?php 
					 		$sql="SELECT * from project_stream where project_id=$project_id ORDER by date_added DESC";
					 		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						 		while ($row = mysql_fetch_array($result)) {
						 		$text_of_stream = $row['text_of_stream'];
						 		$date_added = $row['date_added'];

						 		echo "<li><div class='stream_post'><span style='margin-left:0px;float:left'><i class='icon-time'></i></span><span class='stream_post_text'>$text_of_stream</span><span class='stream_post_date'>$date_added</span></div></li>";

					  			}	
				    	?>
				       </ul>	
				    </div> 
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
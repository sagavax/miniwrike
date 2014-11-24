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
 
<?php include("include/functions.php"); ?>

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
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
	<body>
		

			 <?php 
				$customer_id=$_GET['cid'];
			
			?>
         

		<div id="main">
						
			<!-- header -->
				<div id="header">miniwrike<div class="logged_user"><div class="circle"></div><div class="user">Tomas Misura</div></div></div>
            <!-- header -->
            
            <div id="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="project_details.php?project_id=<?php echo $project_id ?>">Project details</a></li>
                    <li><a href="project_tasks.php?project_id=<?php echo $project_id ?>">Tasks</a></li>
                    <li><a href="project_comments.php?project_id=<?php echo $project_id ?>">Comments</a></li>
					<li><a href="project_meetings.php?project_id=<?php echo $project_id ?>">Meetings*</a></li>
					<li><a href="project_calendar.php?project_id=<?php echo $project_id ?>">Calendar*</a></li>
                    <li><a href="project_stream.php?project_id=<?php echo $project_id ?>">Time stream*</a></li>
					<li><a href="project_docs.php?project_id=<?php echo $project_id ?>">Docs*</a></li>
					
					
                </ul>
            </div>
			
			
			<!-- project title -->
            	
            	<h3 style="font-family:Helvetica, Arial, sans-serif; font-size:14px; color:#222; float:left; margin-left:10px"><?php echo GetCustomerName($customer_id); ?></h3>
            <!-- project title -->
			
			<div id="middle"> <!-- middle section -->
					<?php 
						$sql="SELECT * from project_customers WHERE id=$customer_id";
						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
      					while ($row = mysql_fetch_array($result)) {
      						$customer_name=$row['customer_name'];
      						$customer_description=$row['customer_description'];
      						$customer_url=$row['customer_url'];
      					}	
					?>			
					<div id="view_customer_wrap">
						 
							<table id="view_customer">
									
								<tr>
									<td>Name:</td><td><input name="customer_name" type="text" value="<?php echo $customer_name ?>"></td>
								</tr>
								<tr>	
									<td>Descripton:</td><td><textarea  name="customer_description"><?php echo $customer_description; ?></textarea></td>
								</tr>
								<tr>
									<td>URL:</td><td><input name="customer_url" type="text" value="<?php echo $customer_url; ?>"></td>
								</tr>
								
					    	</table> 
					    
				</div><!-- add new customer wrap -->
				<div id="customer_contacts">
					<h3>Customer contacts</h3>
					<ul>
					<?php
						$sql="SELECT * from project_customer_contacts WHERE customer_id=$customer_id";
						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
      					while ($row = mysql_fetch_array($result)) {
      						$full_name=$row['full_name'];
      						$email_address=$row['email_address'];
      						$tel_numer=$row['tel_numer'];
      						$cell_phone=$row['cell_phone'];

      						
      							echo "<li><div class='customer'>";
      								echo "<table>";
      									echo "<tr>";
      										echo "<td>Full name:</td><td>$full_name</td>";
      									echo "</tr>";
      										echo "<td>email_address:</td><td>$email_address</td>";
      									echo "<tr>";	
      										echo "<td>Tel number:</td><td>$tel_numer</td>";
      									echo "</tr>";
      									echo "<tr>";
      										echo "<td>Cell phone:</td><td>$cell_phone</td>";
      									echo "</tr>";
      								echo "</table>";	
     							echo "</div></li>";
      						

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
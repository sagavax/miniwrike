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
 
<?php 
	if(isset($_POST['new_customer'])) {
		//llllllllllllllleeeeeeeeeeeee";
		$customer_name=$_POST['customer_name'];
		$customer_description=addslashes($_POST['customer_description']);
		$customer_added=date('Y-m-d H:m:s');
		$created_by=$_POST['user_id'];
		$sql="INSERT INTO project_customers (customer_name, customer_description,customer_added,created_by) VALUES ('$customer_name','$customer_description','$customer_added',$created_by)";
		//echo "$sql";
		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
		header('Location: project_add.php');

		// echo AddToHistoryLog('');

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
		<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
	<body>
		

			 <?php 
				$action = $_GET['action']
				

				$project_id=$_GET['project_id'];
				$user_id=$_GET['user_id'];
				$user_id=1;
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
            	<h3 style="font-family:Helvetica, Arial, sans-serif; font-size:14px; color:#222; float:left; margin-left:10px">Add new customer</h3>
            <!-- project title -->
			
			<div id="middle"> <!-- middle section -->
					<?php $action = $_GET['action'];

	 				switch ($action) { 
	 					case 'new': ?>

					<div id="new_customer_wrap">
						 <form accept-charset="utf-8" method="post" action="project_customer_add.php">
							<table id="add_new_customer">
									<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
								<tr>
									<td>Name:</td><td><input name="customer_name" type="text" value=""></td>
								</tr>
								<tr>	
									<td>Descripton:</td><td><textarea  name="customer_description"></textarea></td>
								</tr>
								<tr>	
									<td colspan="2" style="text-align:right"><button type="submit" name="new_customer">+ Add new customer</button></td>
								</tr>
					    	</table> 
					    </form>	
				</div><!-- add new customer wrap -->
			</div><!-- middle section -->
		<?php break;

			case 'edit':

		?>

		<?php break;

			case 'delete':

		?>

		<?php break;

			case 'view_all':

		?>


			<div id="footer"><!-- FOOTER -->
					<ul id="footer-left">
						<li>Simple miniproject administrator/manager</li>
						<li>Created by Tomas Misura</li>
					</ul>		
			</div> <!-- FOOTER -->
			
			
		</div> <!--main wrap -->
			
</body>
</html>
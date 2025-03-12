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
		$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
		header('Location: project_add.php');

		// echo AddToHistoryLog('');

	}
	
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
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
				<?php include ("include/header.php"); ?>
            <!-- header -->
            
        	

           <?php include ("include/menu.php"); ?>
			
			
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


			<?php include ("include/footer.php"); ?>
			
			
		</div> <!--main wrap -->
			
</body>
</html>
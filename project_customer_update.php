<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?> 

 <?php 
 	if isset($_POST['customer_update']) {
 		$customer_description=$_POST['customer_description'];
 		$customer_url=$_POST['customer_url'];
 		$sql="UPDATE "
 		$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
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
				$customer_id=$_GET['cid'];
			
			?>
         

		<div id="main">
						
			<!-- header -->
				<?php include ("include/header.php"); ?>
            <!-- header -->
            
           <?php include ("include/menu.php"); ?>
			
			
			<!-- project title -->
            	
            	<h3 style="font-family:Helvetica, Arial, sans-serif; font-size:14px; color:#222; float:left; margin-left:10px"><?php echo GetCustomerName($customer_id); ?></h3>
            <!-- project title -->
			
			<div id="middle"> <!-- middle section -->
					<?php 
						$sql="SELECT * from project_customers WHERE id=$customer_id";
						$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error()); 
      					while ($row = mysqli_fetch_array($result)) {
      						$customer_name=$row['customer_name'];
      						$customer_description=$row['customer_description'];
      						$customer_url=$row['customer_url'];
      					}	
					?>			
					<div id="view_customer_wrap">
						 <form accept-charset="utf-8" method="post" action="project_customer_update.php"> 
							<table id="update_the_customer">
								<input type="hidden" name="customer_id" value="<?php echo $customer_id ?>">	
								<tr>
									<td>Name:</td><td><input name="customer_name" type="text" value="<?php echo $customer_name ?>"></td>
								</tr>
								<tr>	
									<td>Descripton:</td><td><textarea  name="customer_description"><?php echo $customer_description; ?></textarea></td>
								</tr>
								<tr>
									<td>URL:</td><td><input name="customer_url" type="text" value="<?php echo $customer_url; ?>"></td>
								</tr>
								<tr>
									<td style="2" style="text-align:right"><button type="submit" name="update_customer">Update</button></td>
								</tr>
								
					    	</table> 
					    </form>	
					    
				</div><!-- add new customer wrap -->
				<div id="customer_contacts">
					<h3>Customer contacts</h3>
					<ul>
					<?php
						$sql="SELECT * from project_customer_contacts WHERE customer_id=$customer_id";
						$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error()); 
      					while ($row = mysqli_fetch_array($result)) {
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
				
			<?php include ("include/footer.php"); ?>
			
			
		</div> <!--main wrap -->
			
</body>
</html>
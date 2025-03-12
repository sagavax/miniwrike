<?php
include "include/dbconnect.php";
include "include/functions.php";
session_start();
?>


<?php
if (isset($_POST['new_customer'])) {
	//llllllllllllllleeeeeeeeeeeee";
	$customer_name = $_POST['customer_name'];
	$customer_description = addslashes($_POST['customer_description']);
	$customer_url = $_POST['customer_url'];
	$customer_added = date('Y-m-d H:m:s');
	$created_by = $_POST['user_id'];
	$sql = "INSERT INTO project_customers (customer_name, customer_description,customer_url,customer_added,created_by) VALUES ('$customer_name','$customer_description','$customer_url','$customer_added',$created_by)";
	//echo "$sql";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
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
		<link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="js/customer_check.js" defer></script>
		<script type="text/javascript" src="js/clock.js" defer></script>
		<link rel='shortcut icon' href='project.ico'>
	</head>
	<body>
		<div id="main">

			<!-- header -->
				<?php include "include/header.php";?>
            <!-- header -->

           		<?php include "include/menu.php";?>


			 <?php $user_id = 1; ?>

			<div id="middle"> <!-- middle section -->
				<div id="add_new_customer">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
						<input name="customer_name" type="text" onkeyup="checkCustomerExists(this.value)" placeholder="customer name..." autocomplete="off" id="customer_name">
						<textarea  name="customer_description" id="customer_description" onkeyup="textAreaAdjust(this)" placeholder="customer description ..."></textarea>
						<input name="customer_url" type="text" value="" placeholder="customer url" autocomplete="off" id="customer_url">
						<div class="add_customer_action">
							<button type="buttont" name="new_customer" onclick="AddNewCustomer()"><i class='fa fa-plus'></i> Add new customer</button>
						</div>	
					</div><!-- add new_customer -->
			</div><!-- middle section -->

			<?php include "include/footer.php";?>
		</div> <!--main wrap -->
		<script type="text/javascript">
			function textAreaAdjust(element) {
				  element.style.height = "1px";
				  element.style.height = (25+element.scrollHeight)+"px";
				}
		</script>
</body>
</html>
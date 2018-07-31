<?php session_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>

<?php
	if(isset($_POST['add_contact'])){
		header("HTTP/1.1 301 Moved Permanently");
		header('location:project_create_user.php');

	}

	if(isset($_POST['remove_contact'])){

	}

	if(isset($_POST['view_contact'])){

	}

	if(isset($_POST['send_message'])){
		$_SESSION['receiver_id']=intval($_POST['receiver_id']);
		header("HTTP/1.1 301 Moved Permanently");
		header('location:project_send_message.php');
	}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>
	<div id="main">
			<?php
				$project_id=$_SESSION['project_id'];
				$user_id=$_SESSION['user_id'];
			?>			
			<!-- header -->
				<?php include ("include/header.php"); ?>
				<?php include ("include/menu.php"); ?>
            <!-- header -->
            
           
            <div id="middle"> <!-- middle section -->
            	<div id="project_title"><!-- project title -->
		               <?php
		               	
		                $sql="SELECT * from projects where id=$project_id";
		                $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
		                while ($row = mysqli_fetch_array($result)) {
		                    $project_name=$row['project_name'];
		                    $project_description=$row['project_descr'];

		                    
		                   echo "<span class='project_title'>$project_name</span>";   //boldovo
		                    echo "<span class='project_describtion'>$project_description</span>"; //italikom
		                    

		                }

		                ?>
            	</div><!-- project title --> 
            <div id="project_contacs_wrap">
            	<div id="add_contact"><form action="project_contacts.php" method="post"><button name="add_contact" class="blue-badge"><i class="fa fa-plus"></i> Add contact</button></form></div> <!--pridaj novy kontakt -->
            	<div id="sort_contacts"></div> <!-- filtrovanie, zobrazenie kontaktov -->
            	<div id="contacts">
            		<table id="project_contacts">
            			<?php 
	            			$sql="SELECT a.user_id, a.full_name, a.login, a.email, a.phone, a.type_of_user,a.technology,c.techn_id,c.technology_descr, b.project_id from project_users a, project_assigned_people b, project_technologies c where a.user_id=b.user_id and c.techn_id=a.technology and b.project_id=$project_id";
	            			 $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
			                while ($row = mysqli_fetch_array($result)) {

			                echo "<tr><td>".$row['full_name']." ( ".$row['technology_descr']." )</td><td>".$row['login']."</td><td><i class='fa fa-envelope'></i> ".$row['email']."</td><td><i class='fa fa-phone'></i> ".$row['phone']."</td><td>".$row['type_of_user']."</td><td style='width:120px'><ul><li><form action='project_contacts.php' method='post'><button name='view_contact' class='blue-badge' title='View details'><i class='fa fa-eye'></i></button></form></li><li><form action='project_contacts.php' method='post'><button name='edit_contact' class='blue-badge' title='Edit details'><i class='fa fa-edit'></i></button></form></li><li><form action='project_contacts.php' method='post'><input type='hidden' name='receiver_id' value='".$row['user_id']."'><button name='send_message' class='blue-badge' title='Send message'><i class='fa fa-envelope-o'></i></button></form></li><li><form action='project_contacts.php' method='post'><button name='remove_contact' class='blue-badge' title='Remove contact'><i class='fa fa-times'></i></button></form></li></ul></td></tr>";
			             	

			               } 	
            			?>
            		</table>
            	</div><!--zoznam kontaktov -->
            </div>  
            </div><!-- div middle -->
            <div style="clear:both;"></div>
            
						
			<!-- FOOTER -->
			
			<div id="footer"><!-- FOOTER -->

				<ul id="footer-left">
					<li>Simple miniproject administrator/manager</li>
					<li>Created by Tomas Misura</li>
				</ul>

			</div> <!-- FOOTER -->
			
		</div><!-- main -->	

</body>
<html>
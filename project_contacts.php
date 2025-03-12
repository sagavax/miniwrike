<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<!DOCTYPE html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css"?<?php echo time(); ?> rel="stylesheet" type="text/css" />
		<link href="css/contacts.css?<?php echo time()?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/contacts.js?<?php echo time()?>" defer></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel='shortcut icon' href='project.ico'>



	</head>
<body>
	<div id="main">
				<?php
				$project_id = $_SESSION['project_id'];
				$user_id = $_SESSION['user_id'];
				echo "<script>sessionStorage.setItem('project_id',$project_id)</script>";
				?>
			<!-- header -->
				<?php include "include/header.php";?>
            <!-- header -->

           <?php include "include/menu.php";?>

             <?php echo ProjectTitle($project_id); ?>
        <div class="middle">
            <div id="project_contacs_wrap">
            	<div class="manage_contacts"><button type="button" class="blue-badge" name="sort_ascending" title='Sort ascending'><i class="fas fa-sort-up"></i></button><button type="button" class="blue-badge" name="sort_descending" title='Sort descending'><i class="fas fa-sort-down"></i></button><button name="add_contact" type="button" class="blue-badge"><i class="fa fa-plus"></i> Add contact</button></div> <!--pridaj novy kontakt -->
            	<div id="sort_contacts"></div> <!-- filtrovanie, zobrazenie kontaktov -->
            	<div class="project_contacts">
										<?php
										//$get_assigned_people = "SELECT a.user_id, a.full_name, a.login, a.email, a.phone, a.type_of_user,a.pref_technology,c.tech_id,c.technology_description, b.project_id from project_users a, project_assigned_people b, project_technologies c where a.user_id=b.user_id and c.tech_id=b.project_technology and b.project_id=$project_id";

										
										$get_assigned_people = "SELECT * 
                        FROM project_assigned_people a
                        JOIN project_users b ON a.user_id = b.user_id
                        WHERE a.project_id = $project_id";


										//echo $get_assigned_people;

										$result = mysqli_query($db, $get_assigned_people) or die("MySQLi ERROR: " . mysqli_error($db));
										while ($row = mysqli_fetch_array($result)) {

											$full_name = $row['full_name'];
											$id =$row['user_id'];

											echo "<div class='contact' contact-id='$id'><div class='full_name'>$full_name</div>
										   <div class='contact_button_group'><button type='button' name='view_contact' class='blue-badge' title='View details'><i class='fa fa-eye'></i></button>
										    <button type='button' name='edit_contact' class='blue-badge' title='Edit details'><i class='fa fa-edit'></i></button>
										    <button type='button' name='send_message' class='blue-badge' title='Send Email'><i class='fa fa-envelope'></i></button>
										    <button type='button' name='remove_contant' class='blue-badge' title='Delete Contact'><i class='fa fa-times'></i></button>
										    </div>
										  </div>";

											//echo "<td>" . $row['full_name'] . " ( " . $row['technology_descr'] . " )</td><td>" . $row['login'] . "</td><td><i class='fa fa-envelope'></i> " . $row['email'] . "</td><td><i class='fa fa-phone'></i> " . $row['phone'] . "</td><td>" . $row['type_of_user'] . "</td><td style='width:120px'><ul><li><form action='project_contacts.php' method='post'><button name='view_contact' class='blue-badge' title='View details'><i class='fa fa-eye'></i></button></form></li><li><form action='project_contacts.php' method='post'><button name='edit_contact' class='blue-badge' title='Edit details'><i class='fa fa-edit'></i></button></form></li><li><form action='project_contacts.php' method='post'><input type='hidden' name='receiver_id' value='" . $row['user_id'] . "'><button name='send_message' class='blue-badge' title='Send message'><i class='fa fa-envelope-o'></i></button></form></li><li><form action='project_contacts.php' method='post'><button name='remove_contact' class='blue-badge' title='Remove contact'><i class='fa fa-times'></i></button></form></li></ul></td></tr>";

										}
										?>
                      	</div><!--project_contacts -->
              </div><!-- contants wrap-->
            </div><!-- div middle -->

     				<dialog id="add_contact_dialog">
     					<h3>Add new contact</h3>
     					<input type="text" name="first_name" placeholder="First name" autocomplete="off" spellcheck="false">
     					<input type="text" name="first_name" placeholder="Last name" autocomplete="off" spellcheck="false">
     					<input type="text" name="email" placeholder="email" autocomplete="off" spellcheck="false">
     					<input type="text" name="login" placeholder="login" autocomplete="off" spellcheck="false">
     					<input type="text" name="phone" placeholder="phone" autocomplete="off" spellcheck="false">
     					<div class="add_contacts_action"><button name="add_new_contact" class="button" title="save changes">Add contact</button></div>
     				</dialog>

     				 <dialog id="send_new_mail_dialog">
     				 		<input type="text" name="message_sender" placeholder="from..." readonly="true">
     				 		<input type="text" name="message_recipient" placeholder="to..." readonly="true">
     				 		<textarea name="message" placeholder="write message here..."></textarea>
     				 		<div class="send_message_action"><button name="send_message" class="button" title="send new message">send message</button></div>
     				 </dialog>

     				 <dialog id="view_user_details_dialog">
     				 	<input type="text" name="first_name" placeholder="First name" autocomplete="off" spellcheck="false">
     					<input type="text" name="last_name" placeholder="Last name" autocomplete="off" spellcheck="false">
     					<input type="text" name="email" placeholder="email" autocomplete="off" spellcheck="false">
     					<input type="text" name="login" autocomplete="off" spellcheck="false">
     					<input type="text" name="phone" placeholder="phone" autocomplete="off" spellcheck="false">
     					<input type="text" name="created_date" placeholder="phone" autocomplete="off" spellcheck="false">
     					<div class="add_contacts_action"><button name="view_details" class="button" title="save changes">More ...</button></div>
     				 </dialog>

     				  <dialog id="edit_user_details_dialog">
	     				 	<input type="text" name="first_name" placeholder="First name" autocomplete="off" spellcheck="false">
	     					<input type="text" name="last_name" placeholder="Last name" autocomplete="off" spellcheck="false">
	     					<input type="text" name="email" placeholder="email" autocomplete="off" spellcheck="false">
	     					<input type="text" name="login" placeholder="login" autocomplete="off" spellcheck="false">
	     					<input type="text" name="phone" placeholder="phone" autocomplete="off" spellcheck="false">
	     					<div class="add_contacts_action"><button name="save_changes" class="button" title="save changes">save changes</button></div>
     				 </dialog>
			<div id="footer"><!-- FOOTER -->

				<ul id="footer-left">
					<li>Simple miniproject administrator/manager</li>
					<li>Created by Tomas Misura</li>
				</ul>

			</div> <!-- FOOTER -->

		</div><!-- main -->

</body>
<html>
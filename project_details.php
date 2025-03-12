<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();?>



<?php
if (isset($_POST['update_basic_info'])) {

    //var_dump($_POST);
    $project_name  = mysqli_real_escape_string($db,$_POST['project_name']);
    $project_description = mysqli_real_escape_string($db,$_POST['project_description']); //update description
    $project_id = $_POST['project_id'];
    $project_status = $_POST['project_status'];
    $user_id = 1;
    $project_name = GetProjectName($project_id);
    $user_name = GetUserNameById($user_id);
    $project_code = mysqli_real_escape_string($db, $_POST['project_code']);

    $sql = "UPDATE projects set project_name = '".mysqli_real_escape_string($db,$_POST['project_name'])."', project_code='$project_code',project_descr='$project_description', project_status='$project_status' WHERE id=$project_id";
    //$sql = "UPDATE projects set project_name = '".$project_name."', project_code='$project_code',project_descr='$project_description', project_status='$project_status' WHERE id=$project_id";
    //echo $sql;
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

    //pridat do streamu
    if ($project_status == 'complete') {$text_streamu = "Project :<a href='project_details.php?project_id=$project_id'>" . $project_name . "</a> has been finished at " . date('d-m-y');} elseif ($project_status == 'Cancelled') {$text_streamu = "Project :<a href='project_details.php?project_id=$project_id'>" . $project_name . "</a> has been cancelled";} else {
        $text_streamu = "User <a href='project_user_profile.php?id=$user_id'>" . $user_name . "</a> has updated project details for the project:<a href='project_details.php?project_id=$project_id'>" . $project_name . "</a>";}
    $text_streamu = addslashes($text_streamu);
    $datum = date('Y-m-d H:m:s');
    $sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu','$datum')";
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

    echo "<script>alert('the information have been updated');
                window.location.href='project_details.php?project_id=$project_id';
            </script>";
}

if (isset($_POST['assign_person'])) { //assign uz existujucicj ludi do projektu
    $user_id = $_POST['user_id'];
    $project_id = $_POST['project_id'];	
    if ($user_id == 0) {
        echo "<script>alert('Pls you have chose any person from the list. Try again');
		window.location.href='project_details.php?project_id='.$project_id;
		</script>";
		
    } else { 
		$project_id = $_POST['project_id'];	
			$user_name = GetFullNameById($user_id);
			$user_email = GetUserEmailbyId($user_id);
			$project_name = GetProjectName($project_id);
			//$assigned_by=$_POST['user_id'];
			$assigned_by = 1;
			$assigned_date = date('Y-m-d H:i:s');
			//print_r($_POST);
	
			$sql = "INSERT INTO project_assigned_people (project_id, user_id,assigned_by,assigned_date ) VALUES ($project_id,$user_id,".$_SESSION['user_id'].",'$assigned_date')";
			//echo $sql;
			$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	
			//pridanie do streamu / logu / wallu
			$text_streamu = "User <a href='project_user_profile.php?id=$user_id'>" . $user_name . "</a> has been added to the project <a href='project_details.php?project_id=$project_id'>" . $project_name . "</a>";
			$text_streamu = mysqli_real_escape_string($db, $text_streamu);
			$datum = date('Y-m-d H:m:s');
			$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu', '$datum')";
			//echo $sql;
			$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
            
            echo "<script>alert('The user $user_name has been assigned to this project');
            window.location.href='project_details.php?project_id=$project_id';
             </script>";   
			//TODO: mail          //posle mu email,ze bol priradeny do nejakeho projektu
	
			//header('Location: project_details.php?&project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
		} 
        //var_dump($_POST);
    
}

if (isset($_POST['new_person'])) { // vytvorit noveho usera
    $project_id = $_POST['project_id'];
    header('Location: project_details.php?project_id=' . $_POST['project_id'] . ''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
}

if (isset($_POST['remove_from_project'])) { //remove cloveka z projectu
    $project_id = $_POST['project_id']; //project id
    $user_id = $_POST['user_id']; // id of user to be remove from the project
    $user_name = GetUserNameById($user_id);
    $project_name = GetProjectName($project_id);
    $duration = GetPPlProjectDuration($user_id, $project_id);
    $finished_date = date('Y-m-d H:m:s');

    //vymaze uzvatela z projektu nastavenim datumu kedy projekt ukoncil

    $sql = "DELETE from project_assigned_people WHERE user_id=$user_id and project_id=$project_id";
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

    //nastavi pripadne tasky za ukoncene

    //takisto subtasky

    //posle to este mail

    //pridanie do streamu
    $text_streamu = "User <a href='project_user_profile.php?id=$user_id'> " . $user_name . "</a> has been removed from the project <a href='project_details.php?project_id=$project_id'>" . $project_name . "</a>. Time spent on this project is ";
    $text_streamu = addslashes($text_streamu);
    $datum = date('Y-m-d H:m:s');
    $sql1 = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu', '$datum')";
    //echo $sql1;
    $result = mysqli_query($db,$sql1) or die("MySQL ERROR: " . mysqli_error($db));
    //echo "vlozenie do streamu";
    echo "<script>alert('The user  $user_name has been removed from the project');
                window.location.href='project_details.php?project_id=$project_id';
            </script>";
    //header('Location: project_details.php?&project_id='.$_POST['project_id'].''); // presmeruje to spat
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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/clock.js" defer></script>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic'
        rel='stylesheet' type='text/css'>
    <link rel='shortcut icon' href='project.ico'>



</head>

<body>

    <?php

if(isset($_SESSION['project_id'])){
	$project_id = $_SESSION['project_id'];
} else {
	$project_id = $_GET['project_id']; // projektove id
	$_SESSION['project_id']=$project_id;
}

?>


    <div id="main">
        <!-- main wrapper -->
        <!-- header -->

        <?php include "include/header.php";
            include "include/menu.php";?>
                    <?php

            echo ProjectTitle($project_id);

            ?>
        <!-- header -->
        <!--- middle section -->

        <div id="middle">
            <!-- middle section -->

            <section id="project_header">

                <h3>Project details</h3>

                        <form action="project_details.php" method="post" id="project_details">
                            <?php
                                $sql = "SELECT *,ABS(DATEDIFF(established_date, now())) AS duration from projects WHERE id=$project_id";
                                $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
                                while ($row = mysqli_fetch_array($result)) {
                                    $id = $row['id'];
                                    $project_code = $row['project_code'];
                                    $project_name = $row['project_name'];
                                    $project_description = $row['project_descr'];
                                    $project_status = $row['project_status'];
                                    $project_created = $row['established_date'];
                                    $customer_id = $row['project_customer'];
                                    $customer_name = GetCustomerName($customer_id);
                                    $duration = $row['duration'];

                                    echo "<input type='hidden' name='project_id' value='$project_id'>";
                                        echo "Project name:<td style='font-weight:bold; font-size:14px'><input type='text' name='project_name' value='$project_name'>";
                                        echo "Project code:<input type='text' name='project_code' value='$project_code'>";
                                        echo "Project description:<textarea name='project_description'>$project_description</textarea>";
                                    echo "Customer:<input type='text' name='project_customer' value='$customer_name'>";
                                    echo "Project status:<select name='project_status'>";

                                    if($project_status == 'new'){
                                        $status_name = "New";
                                    }
                                    if($project_status == 'ongoing'){
                                        $status_name = "In progress";
                                    }
                                    if($project_status == 'pending'){
                                        $status_name = "Pending";
                                    }
                                    if($project_status == 'cancelled'){
                                        $status_name = "Cancelled";
                                    }
                                    if($project_status == 'finished'){
                                        $status_name = "Finished";
                                    }
                                            echo "<option value='$project_status' selected='selected'>$status_name</option>
                                            <option value='new'>New</option>
                                            <option value='ongoing'>In progress</option>
                                            <option value='pending'>Pending</option>
                                            <option value='cancelled'>Cancelled</option>
                                            <option value='finished'>Finished</option>
                                      </select>";
                              echo "Project created:<span style='font-weight:bold; font-size:14px'>$project_created</span>";
                                    echo "<td colspan='2' style='text-align:right'><button type='submit' name='update_basic_info' class='blue-badge-large'>Update</button>";
                                }
                                ?>

                </form>
            </section>

            <div id="project_details_dashboard">
                <!--project_details_dashboard -->

                <h3>Dashboard</h3>

                <div class="info_box">
                    <span class="info_box_title">Status:</span>
                    <span class="info_box_value"><?php echo $project_status; ?></span>
                </div>
                <div class="info_box">
                    <span class="info_box_title">Total tasks</span>
                    <span class="info_box_value"><?php echo NrofTasks($project_id); ?></span>
                </div>
                <div class="info_box">
                    <span class="info_box_title">Total subtasks</span>
                    <span class="info_box_value"><?php echo NrofSubTasks($project_id); ?></span>
                </div>
                <div class="info_box">
                    <span class="info_box_title">Total comments</span>
                    <span class="info_box_value"><?php echo NrofComments($project_id); ?></span>
                </div>
                <div class="info_box">
                    <span class="info_box_title">Total people: </span>
                    <span class="info_box_value"><?php echo NrofAssignedppl($project_id); ?></span>
                </div>
                <div class="info_box">
                    <span class="info_box_title">Total meetings:</span>
                    <span class="info_box_value"><?php echo NrofProjMeetings($project_id); ?></span>
                </div>
                <div class="info_box">
                    <span class="info_box_title">Number of docs</span>
                    <span class="info_box_value"><?php echo NumberofDocs($project_id); ?></span>
                </div>
                <div class="info_box">
                    <span class="info_box_title">Total duration</span>
                    <span class="info_box_value"><?php echo $duration; ?></span>
                </div>



            </div>
            <!--project_details_dashboard -->


            <div id="assigned_ppl_list">
                <!-- list of assigned ppl to project, add ppl, created new ppl -->
                <h3> Assigned people to the project </h3>
                <?php
							$sql = "SELECT *,ABS(DATEDIFF(assigned_date, now())) as duration from project_assigned_people WHERE project_id=$project_id"; //get list of ppl assigned to project including his duration
							$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
							$numrows = mysqli_num_rows($result);
							if ($numrows == 0) {
								echo "<span>No ppl assigned to this project</span>";} 
								else {
								echo "<ul>";	
									while ($row = mysqli_fetch_array($result)) {
									$id = $row['id'];
									$user_id = $row['user_id'];
									$user_name = GetUserNameById($user_id);
									$assigned_date = $row['assigned_date'];
									$image = "img/non-avatar_32.jpg";
									$duration = $row['duration'];
									echo "<li>";
									echo "<div class='assigned_person'>";
										echo "<div class='person_image'><img src='" . $image . "' alt='" . $user_id . "'></div>";
											echo "<div class='assigned_person_details'>
													<span class='person_name'><a href='project_user_profile.php?user_id=$user_id'>$user_name</a></span>
													<span class='assigned_date'>$assigned_date</span>
												    <span class='assigned_duration'>$duration days</span>
													<form action='project_details.php?project_id=$project_id' method='post'><input type='hidden' name='project_id' value=$project_id><input type='hidden' name='user_id' value=$user_id><button type='submit' class='blue-badge' name='remove_from_project' alt='Remove user from the project'><i class='fa fa-times'></i></button></form>";
											echo "</div>"; //assigned person details
											echo "</div>";//assigned person
									echo "</li>";

								}
							}
							echo "</ul>";
							?>

                <div id="assigned_ppl_action">
                    <form action="" method="post">
                        <input type="hidden" name="project_id" value="<?php echo $project_id; ?> ">
                        <select name="user_id">
                            <option value="0">----------</option>
                            <?php
									$sql = "SELECT * from project_users WHERE user_id NOT IN (SELECT user_id from project_assigned_people WHERE project_id=$project_id)";
                                    //echo $sql;
							    	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
									while ($row = mysqli_fetch_array($result)) {
											$full_name = $row['full_name'];
											$user_id = $row['user_id'];
								    		echo "<option value=$user_id>$full_name</option>";
									}
								?>
                        </select>
                        <button type="submit" name="assign_person" alt="Add ppl to project" class="button"><i
                                class="fa fa-plus"></i> Assign person</button>
                        <button type="submit" name="create_person" alt="Create new project user" class="button"><i
                                class="fa fa-plus"></i> New user </button>
                        </div><!-- asdigned people list --> 

                        <div class="assigned_projecT_roles">
                            <select name="project_role"> 
                        
                            <?php
                                $get_roles = "SELECT * from project_roles";
                                $result = mysqli_query($db, $get_roles) or die("MySQL ERROR: " . mysqli_error($db));
                                            while ($row = mysqli_fetch_array($result)) {
                                                $role_id = $row['role_id'];
                                                $role_name= $row['role_name'];
                               echo "<option value='role_id'>$role_name</option>";           
                               }             
                            ?>
                            </select>
                        </div><!-- project_roles --> 
                </form>
                
                
            </div><!-- list of assigned ppl to project, add ppl, created new ppl -->
            <div style="clear:both;"></div>
        </div><!-- middle section -->

        <?php include "include/footer.php";?>

    </div>
    <!--main wrap -->
</body>

</html>
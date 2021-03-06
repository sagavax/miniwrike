<?php session_start();
	include("include/dbconnect.php");
	include("include/functions.php");
?>



<?php

if(isset($_POST['finish_subtasks'])){
    $task_id=$_POST['task_id'];
    $user_id=$_SESSION['user_id'];
    $project_id=$_SESSION['project_id'];

    global $db;
  //get all subtasks for the task
   $sql="SELECT task_id from project_task_subtasks where parent_id=$task_id and task_status in ('new','in progress','pending')";
   $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
   $subtasks=array();
   //$subtask_list=array();
   while ($row = mysqli_fetch_array($result)) {
    $task_id=$row['task_id']; 
    //echo $task_id; 
    array_push($subtasks,$task_id);//vytvorime zoznam nezavretych subtaskov
   }   

   $subtask_list="";

   if(count($subtasks>0)){ // mam neukoncene subtasky a posupne ich zavrieme
    foreach ($subtasks as $subtask){
        $subtask_list=implode(",", $subtasks); //vytvaram zoznam taskov pre project stream
      
        $sql="update project_task_subtasks set task_finished=now(), is_complete=1,task_status='finished'";
        echo $sql;
        $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());

        $sql="update project_task_subtasks set=task_duration=DATEDIFF(task_finished,task_created)";
        $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
        } 
    }else {
        echo "<script>alert('No opened subtasks for this task')</script>";
    
  }
    $user_name=GetUserNameById($user_id);
    $text_streamu = "User <a href='project_user_profile.php?id=$user_id'> ".$user_name."</a> has finished subtasks with id <span class='link'>$subtask_list</span> of task id = <a href='project_task.php?task_id=$task_id'>".$task_id."</a>";
    $stream_group='task';
    $text_streamu=mysqli_real_escape_string($db,$text_streamu);
    $date_added=date('Y-m-d H:i:s');
    $sql="INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu', '$date_added')";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));

   unset($subtasks); 
   
   $url = "project_task.php?task_id=$task_id&project_id=$project_id";
   
   header('location:' . $url . '');
  
}


if(isset($_POST['finish_subtask'])){//ukoncenie subtasku{
  $subtask_id=$_POST['subtask_id'];
  $task_id=$_POST['task_id'];
  $task_finished=date('Y-m-d H:m:s');

  $sql="UPDATE project_task_subtasks SET is_complete=1, task_finished='$task_finished',task_status='finished' WHERE task_id=$subtask_id"; //nastavime datum ukoncenia
  $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

  $sql="UPDATE project_task_subtasks SET task_duration=(SELECT DATEDIFF(task_finished,task_created)) where task_id=$subtask_id "; //dlzka trvania
  $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

  $user_name=GetUserNameById($_SESSION['user_id']);
  $text_streamu = "User <a href='project_user_profile.php?id=".$_SESSION['user_id']."'> ".$user_name."</a> has finshed the subtask id ".$subtask_id." of task id = <a href='project_task.php?task_id=$task_id'>".$task_id."</a>";
        $stream_group='task';
        $text_streamu=mysqli_real_escape_string($text_streamu);
        $datum = date('Y-m-d H:m:s');
        $sql="INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu', '$datum')";
        $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));


        $url = "project_task.php?task_id=$task_id&project_id=$project_id";
        header('location:' . $url . '');
  

}

if (isset($_POST['add_task_comment'])) { //pridanie komentu

    $project_id = $_POST['project_cislo'];
    //$user_id=$_POST['user_id'];
    $task_id    = $_POST['task_id'];
    $user_id    = 1;
    $user_name  = GetUserNameById($user_id);
    $comment    = mysqli_real_escape_string($db, $_POST['task_comment']);
    $date_added = date('Y-m-d H:i:s');

    global $db;
    $sql = "INSERT INTO project_task_comments (task_id,project_id, user_id, post_text, date_added) VALUES ($task_id,$project_id, $user_id, '$comment', '$date_added')";
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

     mysqli_query("INSERT INTO project_statement_log (action,date_added,statement) VALUES ('added_comment',now(),'$sql')");


    //add to stream
    $sql="SELECT MAX(id) as task_comment_id from project_task_comments where project_id=$project_id and task_id=$task_id";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
    $task_comment_id=$row['task_comment_id'];
        }

        //pridenie informacie do streamu / logu / wallu
        $text_streamu = "User <a href='project_user_profile.php?id=$user_id'> ".$user_name."</a> has created a new comment id ".$task_comment_id." of task id = <a href='project_task.php?task_id=$task_id'>".$task_id."</a>";
        $stream_group='task';
        $text_streamu=mysqli_real_escape_string($text_streamu);
        $datum = date('Y-m-d H:m:s');
        $sql="INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu', '$datum')";
        $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));


        $url = "project_task.php?task_id=$task_id&project_id=$project_id";
        header('location:' . $url . '');

}


if (isset($_POST['add_subtask'])) { //pridanie subtasku
    $parent_id      = $_POST['task_id'];
    $project_id   = $_POST['project_id'];
    $user_id      = $_POST['user_id'];
    $user_name    = GetUserNameById($user_id);
    $task_name = mysqli_real_escape_string($db, $_POST['subtask_name']);
		if(!isset($_POST['task_description'])){
			$task_description=$task_name;
		}
    $date_added       = date('Y-m-d H:m:s');
    $task_deadline = strtotime(date('Y-m-d', strtotime($date_added)) . " +5 day");
    $task_deadline= date("Y-m-d H:m:s",$task_deadline);
    //$end_date         = date('Y-m-d', $date);

    
    $sql = "INSERT INTO project_task_subtasks (parent_id, project_id, user_id, task_name,task_status, task_priority,is_complete, task_created, task_deadline) VALUES ($parent_id,$project_id, $user_id,'$task_name', 'new','normal',0,'$date_added','$task_deadline')";
    echo $sql;

    
    $result = mysqli_query($sql) or die("MySQL ERROR: " . mysqli_error($db));

 	mysqli_query("INSERT INTO project_statement_log (action,date_added,statement) VALUES ('create_subtask',now(),'$sql')"); //dame to do logu

    $sql="SELECT max(task_id) from project_task_subtasks where parent_id=$task_id"; //ziskame id naposledy vytvoreneho subtasku
    $result = mysqli_query($sql) or die("MySQL ERROR: " . mysqli_error($db));


    $text_streamu = "User <a href='project_user_profile.php?id=$user_id'> ".$user_name."</a> has created a new subtask id ".$new_subtask_id." of task id = <a href='project_task.php?task_id=$task_id'>".$task_id."</a>";
    $stream_group='task';
    $text_streamu=mysqli_real_escape_string($text_streamu);
    
    $sql="INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu', '$date_added')";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));


   $url = "project_task.php?task_id=$task_id&project_id=$project_id";
   header('location:' . $url . '');

}



if (isset($_POST['upload_file'])) { // uploadujem file


    $sql = "";
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

    $text_streamu = "User " . $user_id . " has attached a new file " . $file_name . " to task id = " . $task_id;
    $sql          = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',date('Y-m-d H:i:s'))";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    header('Location: project_task.php?task_id='.$_POST['task_id'].'&project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity

}

if (isset($_POST['assign_the_task'])) { //priradim userovi task, od tej doby sa bude pocitat ucast agenta na projecte

    $project_id    = $_POST['project_id'];
    $task_id       = $_POST['task_id'];
    $user_name     = $_POST['users'];
    $user_id       = GetUserIdbyname($user_name);
    $assignee_id   = $user_id;
    $user_email    = GetUserEmailbyname($user_name);
    $assigned_by   = $_POST['user_id'];
    $assigned_date = date('Y-m-d H:i:s');
    //print_r($_POST);

    //skontrolujem ci user uz nie je assignuty


    $sql="SELECT count(*) as nr_ppl from project_task_assigned_people where user_id=$user_id and task_id=$task_id";

    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

    mysqli_query("INSERT INTO project_statement_log (action,date_added,statement) VALUES ('check_nr_assigned_ppl',now(),'$sql')");
    while ($row = mysqli_fetch_array($result)) {
          $nr_ppl=$row['nr_ppl'];
        }


    if ($nr_ppl>1){ // user uz je assignuty
    	 $url = "project_task.php?task_id=$task_id&project_id=$project_id";
      		 header('location:' . $url . '');
    } else {


    $sql = "INSERT INTO project_task_assigned_people (task_id, project_id, user_id, assignee_id, email, assigned_by, assigned_date) VALUES ($task_id, $project_id, $user_id,$assignee_id,'$user_email',$assigned_by,'$assigned_date')";
    //echo "$sql";
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

    mysqli_query("INSERT INTO project_statement_log (action,date_added,statement) VALUES ('assign_task',now(),'$sql')");

    //pridat do streamu

    $text_streamu = "The task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been re-assigned to user <a href='project_user_profile.php?user_id=$user_id' class='link'>" . $user_name . "</a>";
    $text_streamu = mysqli_real_escape_string($text_streamu);
    $datum        = date('Y-m-d H:m:s');
    $stream_group = 'task';
    $sql          = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";

   mysqli_query("INSERT INTO project_statement_log (action,date_added,statement) VALUES ('add_to_stream',now(),'$sql')");

    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
    $url = "project_task.php?task_id=$task_id&project_id=$project_id&user_id=$user_id";
    header('location:' . $url . ''); // presmeruje spat aby sa zbranilo vkladaniu duplicity*/
 }
}

if(isset($_POST['unassign_task'])){
	$task_id=intval($_POST['task_id']);
	$user_id=intval($_POST['user_id']);
	$date_added = date('Y-m-d H:m:s');
    $assigment_id=intval($_POST['assigment_id']);

    //$myfile = fopen("log.txt", "w");
    //fwrite($myfile, $task_id);
    //fclose($myfile);

    $sql="DELETE from project_task_assigned_people where task_id=$task_id and user_id=$user_id and id=$assigment_id;";

    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

    mysqli_query("INSERT INTO project_statement_log (action,date_added,statement) VALUES ('unassigned_user',now(),'$sql')");

   $url = "project_task.php?task_id=$task_id&project_id=$project_id";
   header('location:' . $url . '');

}

if (isset($_POST['edit_task_details'])) { //kliknem na update button
    $task_id       = $_POST['task_id'];
    $project_id    = $_POST['project_id'];
    $task_status   = mysqli_real_escape_string($db, $_POST['task_status']);
    $task_priority = mysqli_real_escape_string($db, $_POST['task_priority']);
    $task_deadline = $_POST['task_deadline'];
    $task_description=trim(mysqli_real_escape_string($db, $_POST['task_description']));

    $user_id = 1;
    if($task_status=='finished' || $task_status=='cancelled'){
        $date_finished = date('Y-m-d');
         if($task_status=='finished'){
         $text_streamu = "The task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been set as finished";
        } elseif($task_status == 'cancelled'){
        $text_streamu = "The task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been set as cancelled";
    }
     
    $sql = "UPDATE project_tasks SET task_finished='$date_finished',task_status='$task_status',is_complete=1 WHERE task_id=$task_id";    

   } else {
        //$date_finished="";
        //$sql = "UPDATE project_tasks SET task_description='$task_description',task_finished='$date_finished',task_status='$task_status',task_priority='$task_priority',task_deadline='$task_deadline' WHERE task_id=$task_id";
        $sql = "UPDATE project_tasks SET task_description='$task_description',task_status='$task_status',task_priority='$task_priority',task_deadline='$task_deadline' WHERE task_id=$task_id";
        $text_streamu = "The task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been modified";
    }
   
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

    //zalogujeme si pouzity statement
    $date=date('Y-m-d');
    $sql=mysqli_real_escape_string($db,$sql);
    //echo $sql;
    $query="INSERT INTO project_statement_log (action,date_added,statement) VALUES ('edit_task','$date','$sql')";
    echo $query;
    mysqli_query($query);

  
    //prepocitame kolko trval task ak bol ukonceny alebo zruseny
    $sql="update project_tasks SET task_final_duration=DATEDIFF(task_finished,task_created) where task_id=$task_id and is_complete=1";
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));


    //zalogujeme si pouzity statement
    mysqli_query("INSERT INTO project_statement_log (action,date_added,statement) VALUES ('edit_task',now(),'$sql')");

    //pridat do projektoveho streamu
    $text_streamu = mysqli_real_escape_string($db,$text_streamu);
    $datum        = date('Y-m-d H:m:s');
    $stream_group = 'task';
    $sql          = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";

    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));


	$url = "project_task.php?task_id=$task_id";
    //echo $url;
    header('location:' . $url . '');
}

if(isset($_POST['view_subtask'])){
    $subtask_id=$_POST['subtask_id'];
    $url = "project_task_subtask.php?subtask_id=$subtask_id&task_id=".$_SESSION['task_id'];
    //echo $url;
    header('location:' . $url . '');
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
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	   	<script src="ckeditor/ckeditor.js"></script>
         <script src="http://code.highcharts.com/highcharts.js"></script>
		<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>

	</head>
<body>

       <?php
           $project_id=$_SESSION['project_id'];
           $user_id=$_SESSION['user_id'];
           $task_id=$_GET['task_id'];
           $_SESSION['task_id']=$task_id;
       ?>
<div id="main">
   <!-- header -->
        <?php include ("include/header.php"); ?>
        <?php include ("include/menu.php"); ?>
            <!-- header --><!-- header -->
   <!--- middle section -->
   <div id="project_title">
      <!-- project title -->
      <?php
				global $db;
				 $sql="SELECT * from projects where id=$project_id";
         $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
         while ($row = mysqli_fetch_array($result)) {
             $project_name=$row['project_name'];
             $project_description=$row['project_descr'];

             //echo "<div id='project_short_details_wrap'>";
         echo "<span style='float:left;font-weight:bold; font-size:26px; font-family:Roboto, Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";   //boldovo
         echo "<span style='float:left;font-style:italic; font-size:12px; font-family:Roboto,Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
             //echo "</div>";

         }

         ?>
   </div>
   <!-- project title -->
   <div id="middle">
     <script type="text/javascript">
            document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.value;
     };
     </script>
      <!-- middle section -->
      <?php
				global $db;
				 $sql = "SELECT * from project_tasks WHERE task_id=$task_id";
         			//echo "$sql"; TIMESTAMPDIFF(MONTH,'{$start_time_str}','{$end_time_str}') AS m
         $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
         while ($row = mysqli_fetch_array($result)) {
             $task_name        = $row['task_name'];
             $status           = $row['task_status'];
             $task_priority    = $row['task_priority'];
             $date_created     = $row['task_created'];
             $date_finished    = $row['task_finished'];
             $deadline         = $row['task_deadline'];
             $is_complete     = $row['is_complete'];
             $task_description = $row['task_description'];


             $diff = strtotime($date_finished) - strtotime($date_created);
             $diff = date('m/d/Y', 1299446702);

             if ($date_finished == '0000-00-00') {
                 $date_finished = 'N/A';
							global $db;
            	$sql="SELECT ABS(DATEDIFF(task_created,now() )) AS DiffDate from project_tasks where task_id=$task_id";
             $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
         	while ($row = mysqli_fetch_array($result)) {
         		$duration=$row['DiffDate'];
                 }
             } elseif ($date_finished<>'0000-00-00'){
						 global $db;
             $sql="SELECT ABS(DATEDIFF(task_created,task_finished)) AS DiffDate from project_tasks where task_id=$task_id";
             $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
         	while ($row = mysqli_fetch_array($result)) {
         		$duration=$row['DiffDate'];
              }

             }

         }
         ?>
      <div id="project_task_title">
         <?php echo "<span style='margin-left:10px'>$task_name</span>" ?>
      </div>
      <div id="project_task_details_dashboard">
         
      <!-- project_task_details_dashboard -->
         <h3>Dashboard</h3>
         <div id="info_box_wrap" style="width:100%;float:left; min-height:250px">
            <form action="project_task.php" method="POST">
               <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
               <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
               <div class="info_box">
                  <span class="info_box_title">Task status</span>
                  <span class="info_box_value">
                     <?php
                        //echo "status=".$status;
                        if($status=='finished'){
                        	echo "<select name='task_status' disabled>";
                        } elseif ($status=='cancelled'){
                        	echo "<select name='task_status' disabled>";
                        } else  {echo "<select name='task_status'>";}

                        ?>
                     <!-- <select name="task_status">-->
                     <option value="<?php echo $status; ?>" selected="selected"><?php echo $status; ?></option>
                     ";
                     <option value="new">new</option>
                     <option value="in progress">in progress</option>
                     <option value="pending">pending</option>
                     <option value="finished">finished</option>
                     <option value="cancelled">cancelled</option>
                     </select>
                  </span>
               </div>
               <div class="info_box">
                  <span class="info_box_title">Priority</span>
                  <span class="info_box_value">
                     <?php
                        if($status=='finished'){
                        		echo "<select name='task_priority' disabled>";
                        	} elseif ($status=='cancelled'){
                        		echo "<select name='task_priority' disabled>";
                        	} else  {echo "<select name='task_priority'>";}
                        ?>
                     <option value="<?php echo $task_priority; ?>" selected="selected"><?php echo $task_priority; ?></option>
                     ";
                     <option value="low">low</option>
                     <option value="normal">normal</option>
                     <option value="high">high</option>
                     </select>
                  </span>
               </div>
               <div class="info_box">
                  <span class="info_box_title">Date created:</span>
                  <span class="info_box_value"><?php echo $date_created ?></span>
               </div>
               <div class="info_box">
                  <span class="info_box_title">Date finished:</span>
                  <span class="info_box_value"><?php echo $date_finished ?>
               </div>
               <div class="info_box">
                  <span class="info_box_title">Planned deadline:</span>
                  <span class="info_box_value"><input type='text' name='task_deadline' value="<?php echo $deadline ?>"> <i class="fa fa-calendar"></i></span>
               </div>
               <div class="info_box">
                  <span class="info_box_title">Total duration:</span>
                  <span class="info_box_value"><?php echo $duration ?> day(s)</span>
               </div>
               <div class="task_description">
                  <textarea class="ckeditor" name="task_description" id="task_description"><?php echo $task_description?></textarea>
               </div>
               <div style="width:100%;height:40px; line-height:40px;margin-bottom:0px;float:left;margin-top:10px">
                  <span style="float:right;margin-right:5px"><button class="blue-badge-large" type="submit" name="edit_task_details">Save</button></span>
               </div>
         </div>
         <!--info box wrap -->
         </form>
         <div style="clear:both"></div>
      </div>
      <!-- project_task_details_dashboard -->
			<div id="project_task_timelines">
              <h3>Task timeline:</h3>
            <div id="task_timeline">
					<?php
							global $db;
							$sql="SELECT * from project_task_timeline where task_id=$task_id";
							$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
							$num_rows=mysqli_num_rows($result);
							if($num_rows==0) {
							echo "<span style='font-style:italic; font-size:12px; font-family:'Roboto', Helvetica, Arial,sans-serif;color:#ddd;margin-left:10px; margin-top:10px'>No timeline available</span>";
							} else {
								while ($row = mysqli_fetch_array($result)) {
										$time_id=$row['time_id'];
										$action_type=$row['action_type'];
										$action_text=$row['action_text'];
										$action_time=$row['action_time'];
								}
							}
					?>
				</div><div style="clear:both"></div>
			</div>

			<div id="project_task_details_comments">
         <!-- vsetky taskove komentare  + moznost pridat novy komentar-->
         <h3>Task comments</h3>

         <div id="task_commnets_wrap"><!--task_comments_wrap -->
            <ul>
               <?php
                  // get all previous task comments
									global $db;
                  $sql="SELECT * from project_task_comments WHERE task_id=$task_id";
                  // in addition get information from use based on user_id
                  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
                  mysqli_query($db,"INSERT INTO project_statement_log (action,date_added,statement) VALUES ('list_of_all_comments',now(),'$sql')");

                  $numrows= mysqli_num_rows($result);

                  if ($numrows==0) {echo "<div style='font-style:italic; font-size:12px; font-family:'Roboto', Helvetica, Arial,sans-serif;color:#ddd;margin-left:10px; margin-top:10px'>No task comments available</div>";} else {

                  	while ($row = mysqli_fetch_array($result)) {
                  		$id=$row['id'];
                  		$user_id=$row['user_id'];
                        $user_name=GetUserNameById($user_id);
                  		$date_added=$row['date_added'];
                  		$post_text=$row['post_text'];

                  		$image="img/users_pics/".$user_id."/user_".$user_id."_32x32.jpg";

                  		echo "<li>"; //project_task_comments

                  			echo "<div class='project_task_post_wrap'>
                  						<div class='project_task_user_image'><img src='".$image."' alt='".$user_id."'></div>
                  						<div class='task_commented_by'><a href='project_user_profile.php?user_id=$user_id' class='link'>$user_name</a></div>
                                        <div class='project_task_post'>$post_text</div>
                                        <div class='task_comment_date'>$date_added</div>";
                  			echo "</div>";
                  		echo "</li>";
                  	}
                  }
                  ?>
            </ul>
            <div style="clear:both"></div>
         </div><!--task_comments_wrap -->

         <table>
            <tr>
               <td>
                  <form action="project_task.php?project_id=<?php echo $project_id; ?>&task_id=<?php echo $task_id; ?>" method="post">
                     <input type="hidden" name="project_cislo" value="<?php echo $project_id; ?>">
                     <input type="hidden" name="task_id" value="<?php echo $task_id ?>"/>
                     <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                     <input type="text" name="task_comment"><button type="submit" class="blue-badge" name="add_task_comment" alt="Add task comment"><i class="fa fa-plus"></i></button>
                  </form>
               </td>
            </tr>
         </table>
      </div>
      <!-- vsetky taskove komentare  + moznost pridat novy komentar-->

      <div id="project_task_subtasks">
      <h3>Subtasks:</h3>    
        <div id="task_subtasks_wrap">
                <div id="close_all_subtasks"><form action="" method="post"><input type="hidden" name=task_id value="<?php echo $task_id ?>"><button type='submit' name="finish_subtasks" class="blue-badge"><i class="fa fa-check"></i></button></form></div>
                <!--subtask wrap -->
                <ul>
                <?php
                    //get all subtasks
                                        global $db;
                    $sql="SELECT * from project_task_subtasks WHERE parent_id=$task_id";
                        $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
                    $numrows= mysqli_num_rows($result);
                    
                    mysqli_query($db,"INSERT INTO project_statement_log (action,date_added,statement) VALUES ('list_of_all_subtasks',now(),'$sql')");


                    if ($numrows==0) {echo "<span style='font-style:italic; width:100%;font-size:12px; font-family:'Roboto', Helvetica, Arial,sans-serif;color:#ddd;margin-left:10px; margin-top:10px'>No subtasks available</span>";} else {

                        while ($row = mysqli_fetch_array($result)) {

                            $subtask_id=$row['task_id'];
                            $user_id=$row['user_id'];
                            $task_created=$row['task_created'];
                            $task_deadline=$row['task_deadline'];
                            $task_name=$row['task_name'];
                            $post_text=$row['task_description'];
                            $status=$row['task_status'];
                            $priority=$row['task_priority'];
                            $deadline=$row['task_deadline'];
                            $is_complete=$row['is_complete'];
                            $dStart = strtotime($task_created);
                            $dEnd = strtotime(date('Y-m-d'));
                            $dDiff = $dEnd - $dStart;
                            $duration=date('j',$dDiff);


                            echo "<li>"; //project_task_comments
                                echo "<div class='project_subtask_post'>
                                        <div class='subtask_title'><a href='project_task_subtask.php?subtask_id=$subtask_id&project_id=$project_id&task_id=$task_id'>$task_name</a></div>
                                        <div class='subtask_priority'><div class='status_badge'>$priority</div></div>
                                        <div class='subtask_date'>$task_created</div>
                                        <div class='subtask_status'><div class='status_badge'>$status</div></div>
                                        <div class='subtask_action'><form action='' method='post'><input type='hidden' name=subtask_id value='$subtask_id'><input type='hidden' name='task_id' value='$task_id'><button type='submit' name='view_subtask' class='blue-badge'><i class='fa fa-eye'></i></button>";
                                        
                                        if($is_complete==0){ //subtask ukonceny                                        
                                        echo "<button type='submit' name='finish_subtask' class='blue-badge' title='finish task'><i class='fa fa-check'></i></button><button type='submit' name='cancel_subtask' class='blue-badge' title='cancel task'><i class='fa fa-times'></i></button></form></div>"; } elseif ($is_complete==1) {
                                        echo "</div>";
                                        }
                                     echo "</div>";   
                                echo "</li>";
                        }
                    }
                    
                    ?>
                </ul>
            </div><div style="clear:both"></div><!--subtask wrap --> 
            <div class="task_subtask_add_subtask_wrap">
                <form action="project_task.php?task_id=<?php echo $task_id; ?>" method="post">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
                    <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                  
                    <table>
                        <tr>
                            <td><input name="subtask_name" type="text" value="">
                            <button type="submit" class="blue-badge" name="add_subtask" alt="Add subtask"><i class="fa fa-plus"></i></button>
                            </td>                           
                        </tr>    
                    </table>
                </form> 
            </div> <div style="clear:both"></div>
      </div><!-- subtasks -->


         
      <!-- vsetky taskove komentare  + moznost pridat novy komentar-->
      <div id="project_task_details_attachements">
         <!--project_task_details_attachements -->
         <h3>Attachements:</h3>

         <!--- formular na upload -->
         <div id="project_task_details_filelist">
            <?php
							 global $db;
               $sql="SELECT * from project_task_attachements WHERE task_id=$task_id";
               $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
               $numrows= mysqli_num_rows($result);

               if ($numrows==0) {echo "<span style='font-style:italic; font-size:12px; font-family:'Roboto', Helvetica, Arial,sans-serif;color:#ddd;margin-left:10px; margin-top:10px'>No attachements available</span>";} else {

               while ($row = mysqli_fetch_array($result)) {

               $id=$row['id'];
               $user_id=$row['$user_id'];
               $path=$row['path'];
               $file_name=$row['file_name'];
               $file_type=$row['file_type'];
               $date_added=$row['date_added'];
               $image="img/users_pics/".$_SESSION['user_id']."/user_".$_SESSION['user_id']."_32x32.jpg";
                //echo "<img src='".$image."' alt='".$_SESSION['user_id']."' class='circle'>";


                echo "<li>"; //project_task_comments
               		echo "<div class='project_subtask_post'><div class='project_task_user_image'><img src='".$image."' alt='".$user_id."'></div>
                        <div class='project_task_post'>$file_name, $date_added</div></div>";
               	echo "</li>";

               }

                                    }
               ?>
         </div>
         <!-- UPLOAD FILE INTO THE TASK -->
         <div id="project_task_details_upload_form">
            <form action="project_task.php" method="post" enctype="multipart/form-data">
               <input type="file" name="upload_doc"><button type="submit" name="upload_file" class="blue-badge">Upload</button>
            </form>
         </div>
      </div>
      <!--project_task_details_attachements -->
      <div style="clear:both;"></div>
      <!--                                             PROJECT TASK ASSIGNED PERSON  -->
      <div id="project_task_assigned_person">
         <!--project_assigned_person -->
         <h3>Task assigned to person:</h3>
         <ul>
            <?php
               // get all previous task comments

               $sql="SELECT *,ABS(DATEDIFF(assigned_date,  now() ) ) AS duration from project_task_assigned_people WHERE task_id=$task_id";
               //echo "$sql";
               // in addition get information from use based on user_id
							 global $db;

               $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
               $numrows= mysqli_num_rows($result);

               if ($numrows==0) {echo "<span style='font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#ccc;margin-left:10px; margin-top:10px'>No ppl assigned to this task</span>";} else { //ak existuju nejake poznamky tak ich vypis

                   while ($row = mysqli_fetch_array($result)) {
                       $id=$row['id'];
                       $user_id=$row['user_id'];
                       $user_name=GetUserNameById($user_id);
                       $email=$row['email'];
                       $assigned_date=$row['assigned_date'];
                       $image="img/users_pics/".$user_id."/user_".$user_id."_32x32.jpg";
                        //echo "<img src='".$image."' alt='".$_SESSION['user_id']."' class='circle'>";
                        $duration=$row['duration'];

                       echo "<li>"; //project_task_comments

                           echo "<div class='project_assigned_ppl_post'>";

                           echo "<div class='project_assigned_ppl_image'><img src='".$image."'>";
                           echo "</div>"; //image
                           echo "<div class='project_assigned_ppl_name'>
                                <a href='project_user_profile.php?user_id=$user_id'>$user_name</a>";
                           echo "</div>";
                           echo "<div class='project_assigned_ppl_duration'>$duration days</div>";
                           echo "<div class='project_assigned_ppl_button'>";
                           echo "<form action='project_task.php' method='post'>
                                    <input type='hidden' name='task_id' value=$task_id>
                                    <input type='hidden' name='user_id' value=$user_id>
                                    <input type='hidden' name='assigment_id' value=$id>";

                           echo "<button type='submit' name='unassign_task' class='blue-badge'><i class='fa fa-times'></i></button>";

                           echo "</form>";
                           echo "</div>"; //button

                           echo "</div>"; //ppl_post

               echo "</li>";

                   }
               }
               ?>
         </ul>
         <table>
            <tr>
               <td>
                  <form action="project_task.php" method="post">
                     <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
                     <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
                     <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                     <input list="users" name="users" value="">
                     <datalist id="users">
                        <?php
												global $db;
                           $sql="SELECT * from project_task_assigned_people WHERE project_id=$project_id"; //budem vyberat iba z ludi, ktory su do tohto projektu priradeni
                           $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
                           while ($row = mysqli_fetch_array($result)) {
                           	$full_name=$row['full_name'];

                           	echo "<option value='$full_name'>";
                           }
                           ?>
                     </datalist>
                     <button type="submit" name="assign_the_task" alt="Assign the user this task" class="blue-badge"><i class="fa fa-plus"></i></button>
                  </form>
               </td>
            </tr>
            <tr>
               <td><a href="project_tasks.php?project_id=<?php echo $project_id ?>" class="link"><< Back</a></td>
            </tr>
         </table>
      </div>
      <!--project_task_quick_notes -->
   </div>
   <!-- div middle -->
   <div style="clear:both;"></div>
   <?php include ("include/footer.php"); ?>
</div>
<!-- main -->
</body>
</html>

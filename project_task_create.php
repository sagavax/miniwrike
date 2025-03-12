<?php include "include/dbconnect.php";

	//var_dump($_POST);
    $project_id = $_POST['project_id'];
    $task_name = $_POST['task_name'];
	$user_id = 0;
	$task_name = $_POST['task_name'];
	$curr_date = date('Y-m-d H:i:s');
	$date = strtotime(date('Y-m-d H:i:s', strtotime($curr_date)) . " +5 day");
	$end_date = date('Y-m-d H:i:s', $date);

	//check if this taks already exist for this projeck

	$check_task_dupl = "SELECT * from projects_tasks WHERE task_name=$task_name and project_id=$project_id";
	$result_check_dupl = mysqli_query($db, $check_task_dupl) or die("MySQL ERROR: " . mysqli_error($db));
	if(mysqli_num_rows($result_check_dupl))==0{

	$sql = "INSERT INTO project_tasks (project_id, user_id, task_name, task_status,task_priority,task_created) VALUES ($project_id,$user_id,'$task_name','new','normal',now())";

	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

	mysqli_query($db, "INSERT INTO project_statement_log (action,date_added,statement) VALUES ('added_task',now())");
	//zapisanie do project streamu/historie

	
	$user_id = 1;
	$text_streamu = "The task for project $project_id has been created";
	$text_streamu = mysqli_real_escape_string($db, $text_streamu);
	$stream_group = 'task';
	$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu',now())";

	}
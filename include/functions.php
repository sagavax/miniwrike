<?php include "dbconnect.php";


function GetTaskOwner($task_id){
	global $db;
	$query = "SELECT a.task_id, a.user_id, LEFT(b.first_name,1) as first_name, LEFT(b.last_name,1) as last_name from project_tasks a, project_users b WHERE a.task_id = $task_id and a.user_id = b.user_id";
	
    $result=mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);
	
	if(!isset($row['user_id'])){
		$task_owner = "<i class='fa-regular fa-user'></i>";
	} else {	

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];

		$task_owner = $first_name.$last_name;

	}	
	return $task_owner;
			
}


function GetCountTaskUpdates($task_id){
	global $db;
	$query = "SELECT COUNT(*) as nr_of_updates from project_task_comments WHERE task_id=$task_id";
	$result=mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_updates= $row['nr_of_updates'];
	 if($nr_of_updates==0){
	 	$nr_of_updates="<i class='fas fa-plus-circle' title='Add first update'></i>";
	 }
	return $nr_of_updates;			

}	


function GetCountProjectTasks($project_id){
	$query = "SELECT COUNT(*) as nr_of_tasks from project_tasks WHERE project_id=$project_id";
	$result=mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_tasks= $row['nr_of_tasks'];
	return $nr_of_tasks;			
}	

	

function GetCountIdeaComments($idea_id){
	global $db;
	$query = "SELECT COUNT(*) as nr_of_comms from ideas_comments WHERE idea_id=$idea_id";
	$result=mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_comms= $row['nr_of_comms'];
	return $nr_of_comms;			
}	

function GetCountBugComments($bug_id){
	global $db;
	$query = "SELECT COUNT(*) as nr_of_comms from bugs_commnents WHERE bug_id=$bug_id";
	$result=mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_comms= $row['nr_of_comms'];
	return $nr_of_comms;			
}	


function GetProjectStatus($project_id){
	global $db;
	$get_project_ststus = "SELECT project_status from projects WHERE project_id=$project_id";
	$result = mysqli_query($db, $get_project_ststus) or die("MySQLi ERROR: " . mysqli_error($db));
	$row = mysqli_fetch_array($result);
	$status = $row['status'];

	return $status;
}


function GetTechName($tech_id){
	global $db;
	$get_tech_name = "SELECT technology_name from project_technologies WHERE tech_id=$tech_id";
	$result = mysqli_query($db, $get_tech_name) or die("MySQLi ERROR: " . mysqli_error($db));
	$row = mysqli_fetch_array($result);
	$tech_name = $row['technology_name'];

	return $tech_name;
}

function GetRoleName($role_id){
	global $db;
	$get_role_name = "SELECT role_name from project_roles WHERE role_id=$role_id";
	$result = mysqli_query($db, $get_role_name) or die("MySQLi ERROR: " . mysqli_error($db));
	$row = mysqli_fetch_array($result);
	$role_name = $row['role_name'];

	return $role_name;
}


function WorkloadTask(){
	$task = "<div class='w_task'>";
	$task .="<head></heady>";
	$task.="<main>".$TaskName($task_id1)."</main>";
	$task.="<footer></footer>";	
	$task.="</div>";
}


function GetCustomers($customer_id){
	global $db;
	$customer = "<select name='customer'>";
	$get_customers = "SELECT * from project_customers";
	$result = mysqli_query($db, $get_customers) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$customer_name = $row['customer_name'];
		$customer.="<option value='$id'>$customer_name</option>";
	}
	$customer.="</select>";
	$customer = str_replace("value='$customer_id'", "value='customer_id' selected", $customer);

	return $customer;
}

function GetCustomerList(){
	global $db;
	$customer = "<select name='customer'>";
	$get_customers = "SELECT * from project_customers";
	$result = mysqli_query($db, $get_customers) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$customer_name = $row['customer_name'];
		$customer.="<option value='$id'>$customer_name</option>";
	}
	$customer.="</select>";
	return $customer;
}



function GetPriorityList($severity){
    $priority = "<select name='priority'>";
    $priority .= "<option value='low'>low</option>";
    $priority .= "<option value='normal'>normal</option>";
    $priority .= "<option value='high'>high</option>";
    $priority .= "<option value='critical'>critical</option>";
    $priority .= "</select>";

    // Add the selected attribute to the option corresponding to the given severity
    $priority = str_replace("value='$severity'", "value='$severity' selected", $priority);

    return $priority;
}


function GetStatusList($state){
    $status = "<select name='status'>";
    $status .= "<option value='new'>new</option>";
    $status .= "<option value='in progress'>in progress</option>";
    $status .= "<option value='complete'>complete</option>";
    $status .= "<option value='cancelled'>cancelled</option>";
    $status .= "</select>";

    // Set the selected attribute for the option corresponding to the given state
    $status = str_replace("value='$state'", "value='$state' selected", $status);

    return $status;
}


function NrofTasks($project_id) {
	global $db;
	$sql = "SELECT count(*) as task_count from project_tasks WHERE project_id='$project_id'";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$task_count = $row['task_count'];
	}
	return $task_count;
}

function NrofSubTasks($task_id) {
	global $db;
	$sql = "SELECT count(*) as subtask_count from project_tasks WHERE parent_id=$task_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$subtask_count = $row['subtask_count'];
	}
	return $subtask_count;
}

function NrofTaskComments($task_id) {
	global $db;
	$sql = "SELECT count(*) as task_comments_count from project_task_comments where task_id=$task_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$task_comments_count = $row['task_comments_count'];
	}
	return $task_comments_count;
}

function NrofComments($project_id) {
	global $db;
	$sql = "SELECT count(*) as comment_count from project_comments WHERE project_id='$project_id'";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$comment_count = $row['comment_count'];
	}
	return $comment_count;
}

function NrofAssignedppl($project_id) {
	global $db;
	$sql = "SELECT count(*) as ppl_count from project_assigned_people WHERE project_id='$project_id'";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$ppl_count = $row['ppl_count'];
	}
	return $ppl_count;
}
function NrofProjMeetings($project_id) {
	global $db;
	$sql = "SELECT count(*) as meeting_count from project_meetings WHERE project_id=$project_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$meeting_count = $row['meeting_count'];
	}
	return $meeting_count;
}

/* function ProjectDuration($project_id) {
	global $db;
$sql = "SELECT project_status, established_date, finished_date from projects where id=$project_id";
$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
while ($row = mysqli_fetch_array($result)) {
    $project_status = $row['project_status'];
    $established_date = new DateTime($row['established_date']);
    $finished_date = new DateTime($row['finished_date']);

    if ($project_status != 'finished') {
        $now = new DateTime('now', new DateTimeZone('Europe/Bratislava'));
        $duration = $established_date->diff($now);
    } else {
        $duration = $finished_date->diff($established_date);
    }
    // Extract relevant information from DateInterval object
    $years = $duration->y;
    $months = $duration->m;
    $days = $duration->d;
    $hours = $duration->h;
    $minutes = $duration->i;
    $seconds = $duration->s;

    // Format the duration as per your requirement
    $formatted_duration = "$years years, $months months, $days days, $hours hours, $minutes minutes, $seconds seconds";

    return $formatted_duration;
}



} */

function ProjectDuration($project_id, $rowData = null) {
    global $db;

    if ($rowData === null) {
        // Use prepared statement to prevent SQL injection
        $sql = "SELECT project_status, established_date, finished_date FROM projects WHERE id = ?";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "i", $project_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            return "Error: " . mysqli_error($db);
        }

        $row = mysqli_fetch_array($result);
        if (!$row) {
            return "Error: Project not found";
        }
    } else {
        $row = $rowData;
    }

    $project_status = $row['project_status'];

    // Check if established_date is valid
    if (empty($row['established_date'])) {
        return "Error: Established date is not set";
    }

    try {
        $established_date = new DateTime($row['established_date']);

        // Handle finished_date based on project status
        if ($project_status != 'finished') {
            $now = new DateTime('now', new DateTimeZone('Europe/Bratislava'));
            $duration = $established_date->diff($now);
        } else {
            // Check if finished_date is valid for completed projects
            if (empty($row['finished_date'])) {
                return "Error: Finished date is not set for completed project";
            }
            $finished_date = new DateTime($row['finished_date']);
            $duration = $established_date->diff($finished_date);
        }

        // Extract relevant information from DateInterval object
        $years = $duration->y;
        $months = $duration->m;
        $days = $duration->d;
        $hours = $duration->h;
        $minutes = $duration->i;
        $seconds = $duration->s;

        // Build duration string only including non-zero values
        $duration_parts = [];
        if ($years > 0) $duration_parts[] = "$years " . ($years == 1 ? "year" : "years");
        if ($months > 0) $duration_parts[] = "$months " . ($months == 1 ? "month" : "months");
        if ($days > 0) $duration_parts[] = "$days " . ($days == 1 ? "day" : "days");
        if ($hours > 0) $duration_parts[] = "$hours " . ($hours == 1 ? "hour" : "hours");
        if ($minutes > 0) $duration_parts[] = "$minutes " . ($minutes == 1 ? "minute" : "minutes");
        if ($seconds > 0) $duration_parts[] = "$seconds " . ($seconds == 1 ? "second" : "seconds");

        return empty($duration_parts) ? "0 seconds" : implode(", ", $duration_parts);

    } catch (Exception $e) {
        return "Error: Invalid date format - " . $e->getMessage();
    }

    return "Error: Project not found";
}


function GetProjectName($project_id) {
	global $db;
	$sql = "SELECT project_name from projects where id=$project_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$project_name = $row['project_name'];
	}
	return $project_name;

}

function NumberofMeetings($project_id) {
	global $db;
	$sql = "SELECT count(*) as meet_count from project_meetings where project_id=$project_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$meet_count = $row['meet_count'];
	}
	return $meet_count;

}

function NumberofDocs($project_id) {
	global $db;
	$sql = "SELECT count(*) as doc_count from project_task_attachements where project_id=$project_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$doc_count = $row['doc_count'];
	}
	return $doc_count;

}

function GetCustomerName($customer_id) {
	global $db;

	$sql = "SELECT customer_name from project_customers where id=$customer_id";
	//echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$customer_name = $row['customer_name'];
	}
	return $customer_name;

}

function GetUserIdbyname($user_name) {
	global $db;
	$sql = "SELECT user_id from project_users WHERE full_name='$user_name'";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$user_id = $row['user_id'];
	}
	return $user_id;

}

function GetUserNameById($user_id) {
	global $db;
	$sql = "SELECT full_name FROM project_users WHERE user_id = $user_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	$full_name = ""; // Initialize $full_name outside the loop
	while ($row = mysqli_fetch_array($result)) {
	    $full_name = $row['full_name'];
	}
	return $full_name;
}

function GetUserEmailbyname($user_name) {
	global $db;
	$sql = "SELECT email from project_users WHERE full_name='$user_name'";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$email = $row['email'];
	}
	return $email;
}

function GetFullNameById($user_id) {
	global $db;
	$sql = "SELECT full_name from project_users WHERE user_id=$user_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$full_name = $row['full_name'];
	}
	return $full_name;

}

function GetUserEmailbyID($user_id) {
	global $db;
	$sql = "SELECT email from project_users WHERE user_id='$user_id'";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$email = $row['email'];
	}
	return $email;

}

function GetProjectNameById($project_id) {
	global $db;
	$sql = "SELECT project_name from projects WHERE id=$project_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$project_name = $row['project_name'];
	}
	return $project_name;
}

function GetTaskName($task_id) {
	global $db;
	$sql = "SELECT task_name from project_tasks WHERE task_id=$task_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$task_name = $row['task_name'];
	}
	return $task_name;

}

function GetTaskStatus($task_id) {
	global $db;
	$sql = "SELECT status from project_tasks WHERE task_id=$task_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$task_status = $row['status'];
	}
	return $task_status;

}

function GetPPlProjectDuration($user_id, $project_id) {
	global $db;
	$sql = "SELECT ABS(DATEDIFF(assigned_date, now())) as duration from project_assigned_people WHERE user_id=$user_id and project_id=$project_id";
//echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));

	while ($row = mysqli_fetch_array($result)) {
		print_r($row);
		$duration = $row['duration'];
	}
	return $duration;
}

function GetCountAllAssignedTasks($project_id) {
	$sql = "SELECT COUNT(a.task_name, a.task_id, a.project_id) FROM project_tasks a, project_task_assigned_people b WHERE a.project_id =$project_id AND a.task_id = b.task_id AND a.project_id = b.project_id";
}

function draw_project_meeting_calendar($month, $year, $project_id) {
	global $db;
	$running_month = date('F', mktime(0, 0, 0, $month, 1, $year));

	// echo "Rok:".$year;
	//echo "Aktualny mesiac:".$running_month;

	/* draw table */
	$calendar = "<table cellpadding='0' cellspacing='0' id='month_calendar'>";

	$previous_month = ($month - 1) > 0 ? $month - 1 : 12;
	$next_month = ($month % 12) + 1;
	$previous_year = $previous_month > $month ? $year - 1 : $year;
	$next_year = $next_month < $month ? $year + 1 : $year;

	/*$prev_month=$month-1;
 $next_moth=$month+1;*/

// echo "$next_moth";

	$calendar .= "<tr class='calendar-row'><td class='calendar-day-head' colspan='7'><span style='float:left;'><a  style='font-size:15px !important' href='project_meetings.php?project_id=$project_id&date=$previous_month-$previous_year'>&laquo;</a></span> " . date('F', mktime(0, 0, 0, $month, 10)) . "," . $year . " <span style='float:right;'><a href='project_meetings.php?project_id=$project_id&date=$next_month-$next_year' style='font-size:15px !important'>&raquo;</a></span></td></tr>";
	/* table headings */
	$headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	$calendar .= "<tr class='calendar-row'><td class='calendar-day-head'>" . implode("</td><td class='calendar-day-head'>", $headings) . "</td></tr>";

	/* days and weeks vars now ... */
	$running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
	$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar .= "<tr class='calendar-row'>";

	/* print "blank" days until the first of the current week */
	for ($x = 0; $x < $running_day; $x++):
		$calendar .= "<td class='calendar-day-np'> </td>";
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for ($list_day = 1; $list_day <= $days_in_month; $list_day++):

		if ($list_day > 0 and $list_day < 10) {$list_day = '0' . $list_day;}

		$mmonth = date('m', $month);

		$sql = "SELECT * from project_meetings where date_of_meeting='" . $year . "-" . $mmonth . "-" . $list_day . "' and project_id=$project_id";
		//echo $sql;
		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
		$num = MySQLi_num_rows($result);

		if ($num > 0) // mame nejaky event planovany na tento den
	{ $calendar .= '<td class="calendar-event-day">';} else { $calendar .= '<td class="calendar-day">';}

		/* add in the day number */
		$calendar .= "<div class='add-meeting'><a href='project_meeting_plan.php?day=" . $year . "-" . $month . "-" . $list_day . "&project_id=$project_id' class='link'><span style='font-size:18px; font-weight:bold'>+</span></a></div><div class='day-number'><a href='project_meetings.php?view_day=" . $year . "-" . $month . "-" . $list_day . "'>" . $list_day . "</a></div>";

		/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
		// $calendar.= str_repeat('<p> </p>',2);

		$calendar .= '</td>';
		if ($running_day == 6):
			$calendar .= '</tr>';
			if (($day_counter + 1) != $days_in_month):
				$calendar .= "<tr class='calendar-row'>";
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++;
		$running_day++;
		$day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if ($days_in_this_week < 8):
		for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar .= "<td class='calendar-day-np'> </td>";
		endfor;
	endif;

	/* final row */
	$calendar .= '</tr>';

	/* end the table */
	$calendar .= '</table>';

	/* all done, return result */
	return $calendar;
}

function draw_project_calendar($month, $year, $project_id) {
	$running_month = date('F', mktime(0, 0, 0, $month, 1, $year));
	// echo "Rok:".$year;
	//echo "Aktualny mesiac:".$running_month;

	/* draw table */
	$calendar = "<table cellpadding='0' cellspacing='0' id='month_calendar'>";

	$previous_month = ($month - 1) > 0 ? $month - 1 : 12;
	$next_month = ($month % 12) + 1;
	$previous_year = $previous_month > $month ? $year - 1 : $year;
	$next_year = $next_month < $month ? $year + 1 : $year;

	/*$prev_month=$month-1;
 $next_moth=$month+1;*/

// echo "$next_moth";

	$calendar .= "<tr class='calendar-row'><td class='calendar-day-head' colspan='7'><span style='float:left;'><a  style='font-size:15px !important' href='project_calendar.php?project_id=$project_id&date=$previous_month-$previous_year'>&laquo;</a></span> " . date('F', mktime(0, 0, 0, $month, 10)) . "," . $year . " <span style='float:right;'><a href='project_calendar.php?project_id=$project_id&date=$next_month-$next_year' style='font-size:15px !important'>&raquo;</a></span></td></tr>";
	/* table headings */
	$headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	$calendar .= "<tr class='calendar-row'><td class='calendar-day-head'>" . implode("</td><td class='calendar-day-head'>", $headings) . "</td></tr>";

	/* days and weeks vars now ... */
	$running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
	$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar .= "<tr class='calendar-row'>";

	/* print "blank" days until the first of the current week */
	for ($x = 0; $x < $running_day; $x++):
		$calendar .= "<td class='calendar-day-np'> </td>";
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for ($list_day = 1; $list_day <= $days_in_month; $list_day++):

		if ($list_day > 0 and $list_day < 10) {$list_day = '0' . $list_day;}
		global $db;
		$sql = "SELECT * from project_meetings where date_of_meeting='" . $year . "-" . $month . "-" . $list_day . "' and project_id=$project_id";
		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
		$num = MySQLi_num_rows($result);

		if ($num > 0) // mame nejaky event planovany na tento den
	{ $calendar .= '<td class="calendar-event-day">';} else { $calendar .= '<td class="calendar-day">';}

		/* add in the day number */
		//$calendar.= "<div class='add-meeting'><a href='project_meeting_plan.php?day=".$year."-".$month."-".$list_day."' class='btn'><span style='font-size:18px; font-weight:bold'>+</span></a></div><div class='day-number'><a href='project_meetings.php?view_day=".$year."-".$month."-".$list_day."'>".$list_day."</a></div>";
		$calendar .= "<div class='day-number'><a href='project_calendar.php?view_day=" . $year . "-" . $month . "-" . $list_day . "&project_id=$project_id'>" . $list_day . "</a></div>";
		/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
		// $calendar.= str_repeat('<p> </p>',2);

		$calendar .= '</td>';
		if ($running_day == 6):
			$calendar .= '</tr>';
			if (($day_counter + 1) != $days_in_month):
				$calendar .= "<tr class='calendar-row'>";
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++;
		$running_day++;
		$day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if ($days_in_this_week < 8):
		for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar .= "<td class='calendar-day-np'> </td>";
		endfor;
	endif;

	/* final row */
	$calendar .= '</tr>';

	/* end the table */
	$calendar .= '</table>';

	/* all done, return result */
	return $calendar;
}

function ProjectTitle($project_id) {
	echo "<div class='project_header'>";

	global $db;
	$sql = "SELECT project_name, project_descr from projects where id=$project_id";
	//echo "$sql";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$project_name = $row['project_name'];
		$project_description = $row['project_descr'];

		//echo "<div id='project_short_details_wrap'>";
		echo "<span class='project_name'>$project_name</span>"; //boldovo
		echo "<span class='project_description'>$project_description</span>"; //italikom
		//echo "</div>";

	}

	echo "</div>";
}
function add_to_stream($action, $project_id, $user_id, $object_id) {
	if ($action == 'new_comment') {

		$sql = "SELECT MAX(comment_id) as comment_id from project_comments where project_id=$project_id"; //ziskanie max comment id z tabulky
		global $db;
		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));

		while ($row = mysqli_fetch_array($result)) {
			$comment_id = $row['comment_id'];
		}

		$user_name = GetUserNameById($user_id);
		$stream_group = 'comment';
		$text_streamu = "User <a href='project_user_profile.php?id=$user_id'> " . $user_name . "</a> has created a new comment id <span class='link'>$comment_id</span>";
		$text_streamu = addslashes($text_streamu);
		
		$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu',now())";
		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));

	} elseif ($action == 'remove_comment') {

		$stream_group = 'comment';
		$user_name = GetUserNameById($user_id);
		$text_streamu = "User <a href='project_user_profile.php?id=$user_id'> " . $user_name . "</a> has removed comment id <span class='link'>$comment_id</span>";
		$text_streamu = addslashes($text_streamu);
		
		global $db;
		$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu',now())";

		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));

	} elseif ($action == 'new_task') {

		//ziskanie max task id z tabulky
		global $db;
		$sql = "SELECT MAX(task_id) as task_id from project_tasks where project_id=$project_id";

		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
		while ($row = mysqli_fetch_array($result)) {
			$task_id = $row['task_id'];
		}

		//pridenie do streamu
		$user_name = GetUserNameById($user_id);
		$stream_group = 'task';
		$text_streamu = "User <a href='project_user_profile.php?user_id=$user_id'> " . $user_name . "</a> has created a new task id <a href='project_task.php?task_id=$task_id&project_id=$project_id'>" . $task_id . "</a>";
		$text_streamu = addslashes($text_streamu);
		$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu',now())";
		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));

	} elseif ($action == 'task_comment') {
		//ziskanie max task id z tabulky
		$ask_id = $object_id;
		$sql = "SELECT MAX(id) as task_comment_id from project_task_comments where project_id=$project_id and task_id=$task_id";
		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
		while ($row = mysqli_fetch_array($result)) {
			$task_comment_id = $row['task_comment_id'];
		}

		//pridenie informacie do streamu / logu / wallu
		$text_streamu = "User <a href='project_user_profile.php?id=$user_id'> " . $user_name . "</a> has created a new comment id " . $task_comment_id . " of task id = <a href='project_task.php?task_id=$task_id'>" . $task_id . "</a>";
		$stream_group = 'task';
		$text_streamu = MySQLi_real_escape_string($text_streamu);
		$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu', now()";
		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
		//project stream

	} elseif ($action == 'new_subtask') {

		//ziskanie max task id z tabulky
		$sql = "SELECT MAX(subtask_id) as subtask_id from project_task_subtasks";
		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
		while ($row = mysqli_fetch_array($result)) {
			$subtask_id = $row['subtask_id'];
		}

		$text_streamu = "User " . $user_name . " has created a new subtask id <a href='project_task_subtasks_details.php?subtask_id =$subtask_id'> " . $subtask_id . "</a> of task id = <a href='project_task.php?task_id=$task_id'>" . $task_id . "</a>";
		$text_streamu = MySQLi_real_escape_string($text_streamu);
		$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',now())";
		$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
		$url = "project_task_subtask_details.php?subtask_id=$subtask_id&project_id=$project_id";

		header('location:' . $url . '');

	}
}

function NrofMessages($user_id) {
	global $db;
	$sql = "SELECT COUNT(*) nr_of_msgs from project_mailbox_inbox WHERE receiver_id=$user_id";
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$nr_of_msgs = $row['nr_of_msgs'];
	}
	return $nr_of_msgs;

}

function TaskName($task_id) {
	$sql = "SELECT task_id, task_name from project_tasks where task_id=$task_id";
	global $db;
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$task_name = $row['task_name'];
	}
	return $task_name;
}

function time_elapsed_string($ptime) {
	$etime = time() - $ptime;

	if ($etime < 1) {
		return '0 seconds';
	}

	$a = array(365 * 24 * 60 * 60 => 'year',
		30 * 24 * 60 * 60 => 'month',
		24 * 60 * 60 => 'day',
		60 * 60 => 'hour',
		60 => 'minute',
		1 => 'second',
	);
	$a_plural = array('year' => 'years',
		'month' => 'months',
		'day' => 'days',
		'hour' => 'hours',
		'minute' => 'minutes',
		'second' => 'seconds',
	);

	foreach ($a as $secs => $str) {
		$d = $etime / $secs;
		if ($d >= 1) {
			$r = round($d);
			return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
		}
	}
}


function time_ago($date) {
	if (empty($date)) {
		return "No date provided";
	}

	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

	$lengths = array("60", "60", "24", "7", "4.35", "12", "10");

	$now = time();

	$unix_date = strtotime($date);

	// check validity of date

	if (empty($unix_date)) {
		return "Bad date";
	}

	// is it future date or past date

	if ($now > $unix_date) {
		$difference = $now - $unix_date;
		$tense = "ago";
	} else {
		$difference = $unix_date - $now;
		$tense = "from now";
	}

	for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
		$difference /= $lengths[$j];
	}

	$difference = round($difference);

	if ($difference != 1) {
		$periods[$j] .= "s";
	}

	return "$difference $periods[$j] {$tense}";

}

function GetNrofFeeds($project_id, $group_id) {
	$sql = "SELECT count(*) as nr_feeds from project_conversation_feeds where project_id=$project_id and conv_group_id=$group_id";
	global $db;
	//  echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$nr_feeds = $row['nr_feeds'];
	}
	return $nr_feeds;
}

function NrOfAttendees($meeting_id) {
	$sql = "SELECT count(*) as nr_assigness from project_meetings_atendees where meeting_id=$meeting_id";
	global $db;
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$nr_assigness = $row['nr_assigness'];
	}
	return $nr_assigness;

}

function check_email($email) {
	$atom = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]'; // znaky tvořící uživatelské jméno
	$domain = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])'; // jedna komponenta domény
	return eregi("^$atom+(\\.$atom+)*@($domain?\\.)+$domain\$", $email);
}

function check_projects_assignee($user_id, $project_id) {
	global $db;
	$user_exists = "SELECT count(*) as nr_of_assignees FROM project_assigned_people WHERE user_id = $user_id and project_id=$project_id";
	//echo $user_exists;
	$result = mysqli_query($db, $user_exists) or die("MySQLi ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$nr_assignees = $row['nr_of_assignees'];

	}
	return $nr_assignees;

}

function project_name_and_description($project_id) {
	global $db;
	$sql = "SELECT * from projects where id=$project_id";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
	$row = mysqli_fetch_array($result);
		$project_name = $row['project_name'];
		$project_description = $row['project_descr'];
	//echo "<div id='project_short_details_wrap'>";
	$project = "<span style='float:left;font-weight:bold; font-size:26px; font-family:Roboto, Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";
	$project .= "<span style='float:left;font-style:italic; font-size:12px; font-family:Roboto,Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>";

	return $project;

}

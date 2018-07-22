<?php include ("dbconnect.php"); ?>
<?php
    function NrofTasks($project_id) {
      global $db;
      $sql="SELECT count(*) as task_count from project_tasks WHERE project_id='$project_id'";
      $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
       while ($row = mysqli_fetch_array($result)) {
        $task_count=$row ['task_count'];
    } return $task_count;
}

function CloseAllSubtasks($task_id){
  $task_id=$_POST['task_id'];
    $user_id=$_SESSION['user_id'];
    $project_id=$_SESSION['project_id'];

    global $db;
  //get all subtasks for the task
   $sql="SELECT task_id from project_task_subtasks where parent_id=$task_id and task_status in ('new','in progress','pending')";
   $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
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
        $subtask_list=implode(",", $subtasks); 
      
       $sql="update project_task_subtasks set task_finished=now(), is_complete=1,task_status='finished'";
       echo $sql;
         $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));

         $sql="update project_task_subtasks set=task_duration=DATEDIFF(task_finished,task_created)";
         $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    }
    
  }
}

function NrofSubTasks($task_id) {
     global $db;
      $sql="SELECT count(*) as subtask_count from project_task_subtasks WHERE parent_id=$task_id";
      //echo $sql."<br>";
      $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
       while ($row = mysqli_fetch_array($result)) {
        $subtask_count=$row ['subtask_count'];
    } return $subtask_count;
}

function TotalNrProjectSubtasks($project_id){
  global $db;
  $sql="SELECT count(*) as subtasks_count from project_task_subtasks WHERE project_id=$project_id";
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
        $subtasks_count=$row ['subtasks_count'];
    } return $subtasks_count;
}

function CurrSubTaskDuration($subtask_id){
  global $db;
  $sql="SELECT DATEDIFF(now(), task_created) as temp_subtask_duration from project_task_subtasks where task_id=$subtask_id";
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
  while ($row = mysqli_fetch_array($result)) {
    $temp_subtask_duration=$row ['temp_subtask_duration'];
} return  $temp_subtask_duration;
}

function CurrTaskDuration($task_id){
  global $db;
  $sql="SELECT DATEDIFF(now(), task_created) as temp_task_duration from project_tasks where task_id=$task_id";
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
  while ($row = mysqli_fetch_array($result)) {
    $temp_task_duration=$row ['temp_task_duration'];
} return  $temp_task_duration;
}

    function NrofTaskComments($task_id){
      global $db;
      $sql="SELECT count(*) as task_comments_count from project_task_comments where task_id=$task_id";
      $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
       while ($row = mysqli_fetch_array($result)) {
        $task_comments_count=$row ['task_comments_count'];
    } return $task_comments_count;
    }

     function NrofComments($project_id) {
       global $db;
      $sql="SELECT count(*) as comment_count from project_comments WHERE project_id='$project_id'";
      $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
       while ($row = mysqli_fetch_array($result)) {
        $comment_count=$row ['comment_count'];
    } return $comment_count;
   }

    function NrofAssignedppl($project_id) {
      global $db;
      $sql="SELECT count(*) as ppl_count from project_assigned_people WHERE project_id='$project_id'";
      $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
       while ($row = mysqli_fetch_array($result)) {
        $ppl_count=$row ['ppl_count'];
    } return $ppl_count;
  }
    function NrofProjMeetings($project_id) {
      global $db;
      $sql="SELECT count(*) as meeting_count from project_meetings WHERE project_id=$project_id";
      $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
       while ($row = mysqli_fetch_array($result)) {
        $meeting_count=$row['meeting_count'];
    } return $meeting_count;
   }

   /*function ProjectDuration ($project_id) {
    global $db;
    $sql="SELECT project_status, established_date, finished_date from projects where id=$project_id";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
       $project_status=$row['project_status'];
       $established_date=$row['established_date'];
       $finished_date=$row['finished_date'];

      if ($project_status!='finished') {// project este bezi
            $duration = date_diff(date('Y-m-d') - $established_date );
          } else { $duration = date_diff($finished_date - $established_date); } //project uz skoncil

    } return $duration;

   }*/
  
   function ProjectDuration ($project_id){
    global $db;
    $sql="SELECT project_status, established_date, finished_date from projects where id=$project_id";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
      if($row['finished_date']==""){ //project nie je ukonceny
       $sql="SELECT DATEDIFF(now(), established_date) as curr_proj_duration from projects where finished_date is NULL";
      } else { //project je ukonceny
        $sql="SELECT DATEDIFF(finished_date, established_date) as curr_proj_duration from projects";
      }
      $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
       while ($row = mysqli_fetch_array($result)) {
          $duration=$row['curr_proj_duration'];
       } return $duration;
     }  
   }


   function GetProjectName($project_id) {
     global $db;
    $sql="SELECT project_name from projects where id=$project_id";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
       $project_name=$row['project_name'];
   }return $project_name;

  }

  function NumberofDocs($project_id) {
    global $db;
    $sql="SELECT count(*) as doc_count from project_task_attachements where project_id=$project_id";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
       $doc_count=$row['doc_count'];
   }return $doc_count;

  }

    function GetCustomerName($customer_id) {
      global $db;
    $sql="SELECT customer_name from project_customers where id=$customer_id";
    //echo "$sql";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
      while ($row = mysqli_fetch_array($result)) {
         $customer_name=$row['customer_name'];
    }return $customer_name;

  }

  function GetUserIdbyname($user_name) {
    global $db;
    $sql="SELECT user_id from project_users WHERE full_name='$user_name'";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
     while ($row = mysqli_fetch_array($result)) {
         $user_id=$row['user_id'];
    }return $user_id;

  }

  function GetUserNameById($user_id) {
  global $db;
  $sql="SELECT full_name from project_users WHERE user_id=$user_id";
  //echo $sql;
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
     while ($row = mysqli_fetch_array($result)) {
         $full_name=$row['full_name'];
    } return $full_name;

  }

  function GetUserEmailbyname($user_name) {
  global $db;
	$sql="SELECT email from project_users WHERE full_name='$user_name'";
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
     while ($row = mysqli_fetch_array($result)) {
         $email=$row['email'];
    }return $email;


  }

  function GetProjectNameById($project_id) {
  global $db;
  $sql="SELECT project_name from projects WHERE id=$project_id";
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
     while ($row = mysqli_fetch_array($result)) {
         $project_name=$row['project_name'];
    }return $project_name;
  }

 function GetTaskName($task_id) {
 global $db;
 $sql="SELECT task_name from project_tasks WHERE task_id=$task_id";
 //echo $sql;
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
     while ($row = mysqli_fetch_array($result)) {
     $task_name=$row['task_name'];
 } return $task_name;

}

 function GetTaskStatus($task_id) {
  global $db;
  $sql="SELECT task_status from project_tasks WHERE task_id=$task_id";
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
     while ($row = mysqli_fetch_array($result)) {
     $task_status=$row['task_status'];
 } return $task_status;

}

function GetPPlProjectDuration($user_id,$project_id) {
global $db;
$sql="SELECT  ABS(DATEDIFF(assigned_date, now() ) ) AS duration from project_assigned_people WHERE user_id=$user_id and project_id=$project_id";
$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
     while ($row = mysqli_fetch_array($result)) {
     $duration=$row['status'];
 } return $duration;
}


function GetCountAllAssignedTasks($project_id) {
  $sql="SELECT COUNT(a.task_name, a.task_id, a.project_id) FROM project_tasks a, project_task_assigned_people b WHERE a.project_id =$project_id AND a.task_id = b.task_id AND a.project_id = b.project_id";
}


function draw_project_meeting_calendar($month,$year,$project_id){
   $running_month=date('F',mktime(0,0,0,$month,1,$year));

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


  $calendar.="<tr class='calendar-row'><td class='calendar-day-head' colspan='7'><span style='float:left;'><a  style='font-size:15px !important' href='project_meetings.php?project_id=$project_id&date=$previous_month-$previous_year'>&laquo;</a></span> ".date('F', mktime(0, 0, 0, $month, 10)).",".$year." <span style='float:right;'><a href='project_meetings.php?project_id=$project_id&date=$next_month-$next_year' style='font-size:15px !important'>&raquo;</a></span></td></tr>";
  /* table headings */
  $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
  $calendar.= "<tr class='calendar-row'><td class='calendar-day-head'>".implode("</td><td class='calendar-day-head'>",$headings)."</td></tr>";

  /* days and weeks vars now ... */
  $running_day = date('w',mktime(0,0,0,$month,1,$year));
  $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  $days_in_this_week = 1;
  $day_counter = 0;
  $dates_array = array();

  /* row for week one */
  $calendar.= "<tr class='calendar-row'>";

  /* print "blank" days until the first of the current week */
  for($x = 0; $x < $running_day; $x++):
    $calendar.= "<td class='calendar-day-np'> </td>";
    $days_in_this_week++;
  endfor;

  /* keep going with days.... */
  for($list_day = 1; $list_day <= $days_in_month; $list_day++):

    if($list_day>0 and $list_day<10) {$list_day='0'.$list_day;}

   $mmonth=date('m',$month);

   $sql="SELECT * from project_meetings where date_of_meeting='".$year."-".$mmonth."-".$list_day."' and project_id=$project_id";
   global $db;
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
          $num = mysqli_num_rows($result);

          if ($num>0) // mame nejaky event planovany na tento den
           {$calendar.= '<td class="calendar-event-day">';} else {$calendar.= '<td class="calendar-day">';}


      /* add in the day number */
      $calendar.= "<div class='add-meeting'><a href='project_meeting_plan.php?day=".$year."-".$month."-".$list_day."&project_id=$project_id' class='link'><span style='font-size:18px; font-weight:bold'>+</span></a></div><div class='day-number'><a href='project_meetings.php?view_day=".$year."-".$month."-".$list_day."'>".$list_day."</a></div>";

      /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
     // $calendar.= str_repeat('<p> </p>',2);

    $calendar.= '</td>';
    if($running_day == 6):
      $calendar.= '</tr>';
      if(($day_counter+1) != $days_in_month):
        $calendar.= "<tr class='calendar-row'>";
      endif;
      $running_day = -1;
      $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
  endfor;

  /* finish the rest of the days in the week */
  if($days_in_this_week < 8):
    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
      $calendar.= "<td class='calendar-day-np'> </td>";
    endfor;
  endif;

  /* final row */
  $calendar.= '</tr>';

  /* end the table */
  $calendar.= '</table>';

  /* all done, return result */
  return $calendar;
}



function draw_project_calendar($month,$year,$project_id){
   $running_month=date('F',mktime(0,0,0,$month,1,$year));
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


  $calendar.="<tr class='calendar-row'><td class='calendar-day-head' colspan='7'><span style='float:left;'><a  style='font-size:15px !important' href='project_calendar.php?project_id=$project_id&date=$previous_month-$previous_year'>&laquo;</a></span> ".date('F', mktime(0, 0, 0, $month, 10)).",".$year." <span style='float:right;'><a href='project_calendar.php?project_id=$project_id&date=$next_month-$next_year' style='font-size:15px !important'>&raquo;</a></span></td></tr>";
  /* table headings */
  $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
  $calendar.= "<tr class='calendar-row'><td class='calendar-day-head'>".implode("</td><td class='calendar-day-head'>",$headings)."</td></tr>";

  /* days and weeks vars now ... */
  $running_day = date('w',mktime(0,0,0,$month,1,$year));
  $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  $days_in_this_week = 1;
  $day_counter = 0;
  $dates_array = array();

  /* row for week one */
  $calendar.= "<tr class='calendar-row'>";

  /* print "blank" days until the first of the current week */
  for($x = 0; $x < $running_day; $x++):
    $calendar.= "<td class='calendar-day-np'> </td>";
    $days_in_this_week++;
  endfor;

  /* keep going with days.... */
  for($list_day = 1; $list_day <= $days_in_month; $list_day++):

    if($list_day>0 and $list_day<10) {$list_day='0'.$list_day;}
    global $db;
    $sql="SELECT * from project_meetings where date_of_meeting='".$year."-".$month."-".$list_day."' and project_id=$project_id";
    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
          $num = mysqli_num_rows($result);

          if ($num>0) // mame nejaky event planovany na tento den
           {$calendar.= '<td class="calendar-event-day">';} else {$calendar.= '<td class="calendar-day">';}


      /* add in the day number */
      //$calendar.= "<div class='add-meeting'><a href='project_meeting_plan.php?day=".$year."-".$month."-".$list_day."' class='btn'><span style='font-size:18px; font-weight:bold'>+</span></a></div><div class='day-number'><a href='project_meetings.php?view_day=".$year."-".$month."-".$list_day."'>".$list_day."</a></div>";
      $calendar.= "<div class='day-number'><a href='project_calendar.php?view_day=".$year."-".$month."-".$list_day."&project_id=$project_id'>".$list_day."</a></div>";
      /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
     // $calendar.= str_repeat('<p> </p>',2);

    $calendar.= '</td>';
    if($running_day == 6):
      $calendar.= '</tr>';
      if(($day_counter+1) != $days_in_month):
        $calendar.= "<tr class='calendar-row'>";
      endif;
      $running_day = -1;
      $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
  endfor;

  /* finish the rest of the days in the week */
  if($days_in_this_week < 8):
    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
      $calendar.= "<td class='calendar-day-np'> </td>";
    endfor;
  endif;

  /* final row */
  $calendar.= '</tr>';

  /* end the table */
  $calendar.= '</table>';

  /* all done, return result */
  return $calendar;
}

function ProjectTitle($project_id){
  echo "<div id='project_title'>";

            global $db;
            $sql = "SELECT project_name, project_descr from projects where id=$project_id";
            //echo "$sql";
            $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
            while ($row = mysqli_fetch_array($result)) {
                $project_name        = $row['project_name'];
                $project_description = $row['project_descr'];

                //echo "<div id='project_short_details_wrap'>";
                echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name</span>"; //boldovo
                echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
                //echo "</div>";

            }


           echo "</div>";
}
function add_to_stream($action,$project_id,$user_id,$object_id){
  if($action=='new_comment'){

     $sql="SELECT MAX(comment_id) as comment_id from project_comments where project_id=$project_id"; //ziskanie max comment id z tabulky
          global $db;
            $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));

            while ($row = mysqli_fetch_array($result)) {
                  $comment_id=$row['comment_id'];
            }

            $user_name = GetUserNameById($user_id);
            $stream_group='comment';
            $text_streamu = "User <a href='project_user_profile.php?id=$user_id'> ".$user_name."</a> has created a new comment id <span class='link'>$comment_id</span>";
            $text_streamu=addslashes($text_streamu);
            $datum=date('Y-m-d H:m:s');
            $sql="INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";
            $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));

  } elseif ($action=='remove_comment'){

    $stream_group='comment';
  $user_name = GetUserNameById($user_id);
  $text_streamu = "User <a href='project_user_profile.php?id=$user_id'> ".$user_name."</a> has removed comment id <span class='link'>$comment_id</span>";
  $text_streamu=addslashes($text_streamu);
  $datum=date('Y-m-d H:m:s');

  global $db;
  $sql="INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";

  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));

  } elseif ($action=='new_task'){

    //ziskanie max task id z tabulky
          global $db;
          $sql="SELECT MAX(task_id) as task_id from project_tasks where project_id=$project_id";

          $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
          while ($row = mysqli_fetch_array($result)) {
                $task_id=$row['task_id'];
          }

          //pridenie do streamu
          $user_name = GetUserNameById($user_id);
          $stream_group='task';
          $text_streamu = "User <a href='project_user_profile.php?user_id=$user_id'> ".$user_name."</a> has created a new task id <a href='project_task.php?task_id=$task_id&project_id=$project_id'>".$task_id."</a>";
          $text_streamu=addslashes($text_streamu);
          $datum=date('Y-m-d H:m:s');
          global $db;
          $sql="INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";
           $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));


  } elseif ($action=='task_comment'){
    //ziskanie max task id z tabulky
        global $db;
        $ask_id=$object_id;
        $sql="SELECT MAX(id) as task_comment_id from project_task_comments where project_id=$project_id and task_id=$task_id";
        $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
        while ($row = mysqli_fetch_array($result)) {
          $task_comment_id=$row['task_comment_id'];
        }

        //pridenie informacie do streamu / logu / wallu
        global $db;
        $text_streamu = "User <a href='project_user_profile.php?id=$user_id'> ".$user_name."</a> has created a new comment id ".$task_comment_id." of task id = <a href='project_task.php?task_id=$task_id'>".$task_id."</a>";
        $stream_group='task';
        $text_streamu=mysql_real_escape_string($text_streamu);
        $datum = date('Y-m-d H:m:s');
        $sql="INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu', '$datum')";
        $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
        //project stream

  } elseif ($action=='new_subtask') {

    //ziskanie max task id z tabulky
        global $db;
        $sql="SELECT MAX(subtask_id) as subtask_id from project_task_subtasks";
        $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
        while ($row = mysqli_fetch_array($result)) {
          $subtask_id=$row['subtask_id'];
        }

        global $db;
        $text_streamu = "User ".$user_name." has created a new subtask id <a href='project_task_subtasks_details.php?subtask_id =$subtask_id'> ".$subtask_id."</a> of task id = <a href='project_task.php?task_id=$task_id'>".$task_id."</a>";
        $text_streamu=mysql_real_escape_string($text_streamu);
        $datum=date('Y-m-d H:m:s');
        $sql="INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu','$datum')";
        $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
         $url = "project_task_subtask_details.php?subtask_id=$subtask_id&project_id=$project_id";

    header('location:' . $url . '');

  }
}

function NrofMessages($user_id){
  global $db;
  $sql="SELECT COUNT(*) nr_of_msgs from project_mailbox WHERE receiver_id=1";
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
  while ($row = mysqli_fetch_array($result)) {
    $nr_of_msgs=$row['nr_of_msgs'];
  } return $nr_of_msgs;

}

function TaskName($task_id){
  $sql="SELECT task_id, task_name from project_tasks where task_id=$task_id";
  global $db;
   $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
        $task_name=$row['task_name'];
   }   return $task_name;
}

function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}

function ago($time)
{
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j] 'ago' ";
}

function time_ago( $date )
{
    if( empty( $date ) )
    {
        return "No date provided";
    }

    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

    $lengths = array("60","60","24","7","4.35","12","10");

    $now = time();

    $unix_date = strtotime( $date );

    // check validity of date

    if( empty( $unix_date ) )
    {
        return "Bad date";
    }

    // is it future date or past date

    if( $now > $unix_date )
    {
        $difference = $now - $unix_date;
        $tense = "ago";
    }
    else
    {
        $difference = $unix_date - $now;
        $tense = "from now";
    }

    for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ )
    {
        $difference /= $lengths[$j];
    }

    $difference = round( $difference );

    if( $difference != 1 )
    {
        $periods[$j].= "s";
    }

    return "$difference $periods[$j] {$tense}";

}

function GetNrofFeeds($project_id,$group_id){
  $sql="SELECT count(*) as nr_feeds from project_conversation_feeds where project_id=$project_id and conv_group_id=$group_id";
  global $db;
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
        $nr_feeds=$row['nr_feeds'];
     } return $nr_feeds;
}

function GetCovGroupName($con_group_id){
  $sql="SELECT group_title from project_conversation_group where group_id=$con_group_id";
  //echo $sql;
  global $db;
  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
      $group_name = $row['group_title'];
    } return $group_name;
}


function NrOfAttendees($meeting_id){
  $sql="SELECT count(*) as nr_assigness from project_meetings_atendees where meeting_id=$meeting_id";
  global $db;
   $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
        $nr_assigness=$row['nr_assigness'];
     } return $nr_assigness;

}




function check_email($email) {
    $atom = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]'; // znaky tvořící uživatelské jméno
    $domain = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])'; // jedna komponenta domény
    return eregi("^$atom+(\\.$atom+)*@($domain?\\.)+$domain\$", $email);
}

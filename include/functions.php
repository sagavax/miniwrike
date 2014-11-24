<?php 
    function NrofTasks($project_id) {
      $sql="SELECT count(*) as task_count from project_tasks WHERE project_id='$project_id'";
      $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
       while ($row = mysql_fetch_array($result)) {
        $task_count=$row ['task_count'];
    } return $task_count;
}
  
   function NrofSubTasks($project_id) {
      $sql="SELECT count(*) as subtask_count from project_task_subtasks WHERE project_id='$project_id'";
      $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
       while ($row = mysql_fetch_array($result)) {
        $subtask_count=$row ['subtask_count'];
    } return $subtask_count;
}
     function NrofComments($project_id) {
      $sql="SELECT count(*) as comment_count from project_comments WHERE project_id='$project_id'";
      $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
       while ($row = mysql_fetch_array($result)) {
        $comment_count=$row ['comment_count'];
    } return $comment_count;
   } 

    function NrofAssignedppl($project_id) {
      $sql="SELECT count(*) as ppl_count from project_assigned_people WHERE project_id='$project_id'";
      $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
       while ($row = mysql_fetch_array($result)) {
        $ppl_count=$row ['ppl_count'];
    } return $ppl_count;
  }
    function NrofProjMeetings($project_id) {
      $sql="SELECT count(*) as meeting_count from project_meetings WHERE project_id=$project_id";
      $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
       while ($row = mysql_fetch_array($result)) {
        $meeting_count=$row['meeting_count'];
    } return $meeting_count;
   } 

   function ProjectDuration ($project_id) {
    $sql="SELECT project_status, established_date, finished_date from projects where id=$project_id";
    $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
    while ($row = mysql_fetch_array($result)) {
       $project_status=$row['project_status']; 
       $established_date=$row['established_date'];
       $finished_date=$row['finished_date'];

      if ($project_status!='finished') {// project este bezi
            $duration = date_diff(date('Y-m-d') - $established_date );
          } else { $duration = date_diff($finished_date - $established_date); } //project uz skoncil

    } return $duration;

   }

   function GetProjectName($project_id) {
    $sql="SELECT project_name from projects where id=$project_id";
    $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
    while ($row = mysql_fetch_array($result)) {
       $project_name=$row['project_name']; 
   }return $project_name;

  } 
  
  function NumberofDocs($project_id) {
    $sql="SELECT count(*) as doc_count from project_task_attachements where project_id=$project_id";
    $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
    while ($row = mysql_fetch_array($result)) {
       $doc_count=$row['doc_count']; 
   }return $doc_count;

  } 
  
    function GetCustomerName($customer_id) {
    $sql="SELECT customer_name from project_customers where id=$customer_id";
    //echo "$sql";
    $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
      while ($row = mysql_fetch_array($result)) {
         $customer_name=$row['customer_name']; 
    }return $customer_name;

  }

  function GetUserIdbyname($user_name) {

    $sql="SELECT user_id from project_users WHERE full_name='$user_name'";
   
    $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
     while ($row = mysql_fetch_array($result)) {
         $user_id=$row['user_id']; 
    }return $user_id;

  }
  
  function GetUserNameById($user_id) {
  $sql="SELECT full_name from project_users WHERE user_id=$user_id";
  
  $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
     while ($row = mysql_fetch_array($result)) {
         $full_name=$row['full_name']; 
    }return $full_name;

  }
  
  function GetUserEmailbyname($user_name) {
	$sql="SELECT email from project_users WHERE full_name='$user_name'";
	
  $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
     while ($row = mysql_fetch_array($result)) {
         $email=$row['email']; 
    }return $email;

  
  }

  function GetProjectNameById($project_id) {
  $sql="SELECT project_name from projects WHERE id=$project_id";
  $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
     while ($row = mysql_fetch_array($result)) {
         $project_name=$row['project_name']; 
    }return $project_name;    
  }

 function GetTaskName($task_id) {
 $sql="SELECT colNoteText from project_tasks WHERE task_id=$task_id";
  $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
     while ($row = mysql_fetch_array($result)) {
     $task_name=$row['colNoteText'];
 } return $task_name;

}

 function GetTaskStatus($task_id) {
  $sql="SELECT status from project_tasks WHERE task_id=$task_id";
  $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
     while ($row = mysql_fetch_array($result)) {
     $task_status=$row['status'];
 } return $task_status;

}

function GetPPlProjectDuration($user_id,$project_id) {

$sql="SELECT  ABS(DATEDIFF(assigned_date, now() ) ) AS duration from project_project_assigned_people WHERE user_id=$user_id and project_id=$project_id";
$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
     while ($row = mysql_fetch_array($result)) {
     $duration=$row['status'];
 } return $duration;
}


function GetCountAllAssignedTasks($project_id) {
  $sql="SELECT COUNT(a.colNoteText, a.task_id, a.project_id) FROM project_tasks a, project_task_assigned_people b WHERE a.project_id =$project_id AND a.task_id = b.task_id AND a.project_id = b.project_id";
}

?>


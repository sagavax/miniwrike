<?php session_start();
include("include/dbconnect.php");

$sql="UPDATE project_task_assigned_people SET  user_id=$user_id WHERE  task_id=$task_id and project=$project_id";
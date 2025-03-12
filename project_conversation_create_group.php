<?php

    include "include/dbconnect.php";
    include "include/functions.php";


    $user_id = $_POST['user_id']; // Assuming the user ID is 1
    $project_id = $_POST['project_id'];
    $user_name = GetUserNameById($user_id);
    $group_name = mysqli_real_escape_string($db, $_POST['group_name']);
    $project_name = GetProjectName($project_id);
    

    //check duplicates
    $check_existing_group = "SELECT * from project_conversation_group WHERE group_title='$group_name'";
    $result = mysqli_query($db, $check_existing_group) or die("MySQL ERROR: " . mysqli_error($db));
    if(mysqli_num_rows($result)==0){
        $create_group = "INSERT INTO project_conversation_group (project_id, created_by, group_title, created_date) VALUES ($project_id, $user_id, '$group_name', now())";
      $result = mysqli_query($db, $create_group) or die("MySQL ERROR: " . mysqli_error($db));
     } else {
        echo "group_exists";
     } 
    $get_latest_id = "SELECT MAX(group_id) AS group_id FROM project_conversation_group WHERE project_id = $project_id";
    $result = mysqli_query($db, $get_latest_id) or die("MySQL ERROR: " . mysqli_error($db));

    while ($row = mysqli_fetch_array($result)) {
        $conv_group_id = $row['group_id'];
    }

    // Add to project log / stream
    $stream_group = "chat_group";
    $text_streamu = "User <a href='project_user_profile.php?id=$user_id'>$user_name</a> has created a new conversation group $group_name for the project: <a href='project_details.php?project_id=$project_id'>$project_name</a>";
    $text_streamu = addslashes($text_streamu);
    $sql = "INSERT INTO project_stream (project_id, stream_group, user_id, text_of_stream, date_added) VALUES ($project_id, '$stream_group', $user_id, '$text_streamu', now())";
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
    


    
<?php

    include "include/dbconnect.php";
    include "include/functions.php";


    $chat_comment = mysqli_real_escape_string($db, $_POST['text']);
    $project_id = $_POST['project_id'];
    $conv_group_id = intval($_POST['groupId']);
    $user_id = $_POST['userId'];
    
        $create_feed = "INSERT INTO project_conversation_feeds (project_id, user_id, conv_group_id, conversation_text, date_created) VALUES ($project_id, $user_id, $conv_group_id, '$chat_comment', now())";
        echo $create_feed;
        $result = mysqli_query($db, $create_feed) or die("MySQL ERROR: " . mysqli_error($db));

        $get_latest_id = "SELECT MAX(id) AS feed_id FROM project_conversation_feeds WHERE project_id = $project_id";
        $result = mysqli_query($db, $get_latest_id) or die("MySQL ERROR: " . mysqli_error($db));

        while ($row = mysqli_fetch_array($result)) {
            $feed_id = $row['feed_id'];
        }

        // Add to project log / stream
        $user_name = GetUserNameById($user_id);
        $project_name = GetProjectName($project_id);
        $stream_group = "chat_feed";
        $text_streamu = "User <a href='project_user_profile.php?id=$user_id'>$user_name</a> has added a new conversation feed id $feed_id in chat room id <a href='project_conversation.php?project_id=$project_id&conv_group_id=$conv_group_id' class='link'>$conv_group_id</a> for the project: <a href='project_details.php?project_id=$project_id'>$project_name</a>";
        $text_streamu = addslashes($text_streamu);
        $sql = "INSERT INTO project_stream (project_id, stream_group, user_id, text_of_stream, date_added) VALUES ($project_id, '$stream_group', $user_id, '$text_streamu', now())";
        $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
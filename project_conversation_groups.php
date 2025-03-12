<?php
    include "include/dbconnect.php";
    include "include/functions.php";

    $project_id = $_GET['project_id'];

    $sql = "SELECT group_id, group_title FROM project_conversation_group WHERE project_id = $project_id";
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
    while ($row = mysqli_fetch_array($result)) {
        $group_id = $row['group_id'];
        $group_title = $row['group_title'];
        $feeds = GetNrofFeeds($project_id, $group_id);
        echo "<button type='button' data-id='$group_id'>$group_title<div class='conv_group_feed_count'>$feeds</div></button>";
    }
    ?>
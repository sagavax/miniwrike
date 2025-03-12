<?php 
session_start();
include "include/dbconnect.php";
include "include/functions.php";

$groupId = $_GET['groupId'];

$sql = "SELECT * FROM project_conversation_feeds WHERE conv_group_id = $groupId";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

while ($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
    $user_id = $row['user_id'];
    $conversation_text = $row['conversation_text'];
    $date_created = $row['date_created'];
    $user_name = GetUserNameById($user_id);

    echo "<div feed-id='$id' class='feed'>
            <div class='feed_user_name'>
                <a href='project_user_profile.php?id=$user_id'>$user_name</a>
            </div>
            <div class='feed_text'>$conversation_text</div>
            <div class='feed_time'>" . time_ago($date_created) . "</div>
            <div class='feed_del'>
                <a href='project_conversation.php?feed_id=$id' class='link'><i class='fa fa-times'></i></a>
            </div>
          </div>";
}
?>

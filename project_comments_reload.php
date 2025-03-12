<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";

$project_id = $_SESSION['project_id'];



$sql = "SELECT * from project_comments where project_id=$project_id ORDER BY comment_id DESC";
//echo $sql;
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
while ($row = mysqli_fetch_array($result)) {
	$comment_id = $row['comment_id'];
	$user_id = $row['user_id'];
	$user_name = GetUserNameById($user_id);
	$project_id = $row['project_id'];
	$comment = $row['comment'];
	$date_added = $row['date_added'];
	$image = "img/users_pics/" . $user_id . "/user_" . $user_id . "_32x32.jpg";

	echo "<div class='comment_post'>";
			echo "<div class='comment_user_picture'><img src='" . $image . "' alt='" . $user_id . "'></div>";
		  echo "<div class='commented_by'><a href='project_user_profile.php?user_id=$user_id' class='link'>$user_name</a></div>";
		  echo "<div class='comment_body'>$comment</div>
			<div class='comment_date'>" . time_ago($date_added) . "</div>
			<div class='comment_delete'><a href='project_comment.php?comm_id=$comment_id&project_id=$project_id&action=delete' class='link'><i class='fa fa-times'></i></a></div>";		
	echo "</div>";//comment post
	}



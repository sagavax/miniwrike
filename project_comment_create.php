<?php

	include("include/dbconnect.php");


	$comment = mysqli_real_escape_string($db, $_POST['comment']);
	$project_id = $_POST['project_id'];

	$user_id = 1;

	$sql = "INSERT INTO project_comments (project_id, user_id, comment, date_added) VALUES ($project_id, $user_id, '$comment', now())";
    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());


	$sql = "SELECT MAX(comment_id) as project_comment_id from project_comments where project_id=$project_id";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$project_comment_id = $row['project_comment_id'];
	}

	$text_streamu = "a new comment id $project_comment_id has been added";
	$text_streamu = mysqli_real_escape_string($db, $text_streamu);
	$stream_group = 'comments';
	$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu',now())";

	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
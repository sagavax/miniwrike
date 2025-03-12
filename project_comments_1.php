<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start()?>


<?php
if (isset($_POST['add_new_comment'])) {
	$comment = mysqli_real_escape_string($db, $_POST['comment']);
	$project_id = $_POST['project_id'];

	if ($comment == '') {
		header('Location: project_comments.php?project_id=' . $_POST['project_id'] . '');
	} else {

		$user_id = 1;

		$sql = "INSERT INTO project_comments (project_id, user_id, comment, date_added) VALUES ($project_id, $user_id, '$comment', now())";

		$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

		// ****************           pridenie do streamu	************************

		$project_id = $_SESSION['project_id'];
		$user_id = $_SESSION['user_id'];
		$user_id = 1;

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

		// ****************           pridenie do streamu	************************//

		header('Location: project_comments.php?project_id=' . $_POST['project_id'] . ''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
	}

}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
		<link href="css/comments.css" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/comments.js" defer></script>
		<script type="text/javascript" src="js/clock.js" defer></script>
		<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel='shortcut icon' href='project.ico'>



	</head>
<body>
	<div id="main">
			<?php
				$project_id = $_SESSION['project_id'];
				$user_id = $_SESSION['user_id'];

				?>
			<!-- header -->
				<?php include "include/header.php";?>
            <!-- header -->

           <?php include "include/menu.php";?>

             <?php echo ProjectTitle($project_id); ?>

			<!--- middle section -->

			<div id="add_project_comment">
				 <form accept-charset="utf-8" method="post" id="dev_notes" name="new_dev_note" action="project_comments.php?project_id=<?php echo $project_id; ?>">
		                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
						<!-- <input type="hidden" name="user" value="<?php echo $user_id; ?>">-->
					
            		<input type='text' name='comment' autocomplete='off' value="">
            	<button type="submit" name="add_new_comment" class="blue-badge">+ Add</button>
           </form>

			</div> <!--- add comment -->


			<div id="middle"> <!-- middle section -->
				<div class="project_comments_wrap">

					<?php
							$sql = "SELECT * from project_comments where project_id=" . $_GET['project_id'] . " ORDER BY comment_id DESC";
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
									  echo "<div class='comment_body'><a href='project_comment.php?comm_id=$comment_id&&project_id=$project_id&action=view'>$comment</a></div>
														<div class='comment_date'>" . time_ago($date_added) . "</div>
														<div class='comment_delete'><a href='project_comment.php?comm_id=$comment_id&project_id=$project_id&action=delete' class='link'><i class='fa fa-times'></i></a></div>";		
								echo "</div>";//comment post
								
								
								
								}

							?>
				
				</div><!-- project comment wrap -->

			</div>	

		    <?php include "include/footer.php";?>

		</div><!-- main -->

</body>
<html>
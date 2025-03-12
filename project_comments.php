<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start()?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
		<link href="css/comments.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
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
				echo "<script>sessionStorage.setItem('project_id',$project_id)</script>";
				?>
			<!-- header -->
				<?php include "include/header.php";?>
            <!-- header -->

           <?php include "include/menu.php";?>

             <?php echo ProjectTitle($project_id); ?>

			<!--- middle section -->

			<div class="add_project_comment">
		 		<input type='text' name='comment' autocomplete='off' value="">
       	<button type="submit" name="add_new_comment" class="blue-badge"><i class="fa fa-plus"></i> Add</button>
     	</div> <!--- add comment -->


			<div id="middle"> <!-- middle section -->
				<div class="project_comments">

					<?php
							$itemsPerPage = 10;

             $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
             $offset = ($current_page - 1) * $itemsPerPage;

							$get_project_comments = "SELECT * from project_comments where project_id=" . $_SESSION['project_id'] . " ORDER BY comment_id DESC  LIMIT $itemsPerPage OFFSET $offset";
							//echo $sql;
							$result = mysqli_query($db, $get_project_comments) or die("MySQL ERROR: " . mysqli_error($db));
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

							?>
							</div><!-- project comment wrap -->
							<?php
                // Calculate the total number of pages
                $sql = "SELECT COUNT(*) as total FROM project_comments where project_id=$project_id";
                $result=mysqli_query($db, $sql);
                $row = mysqli_fetch_array($result);
                $totalItems = $row['total'];
                $totalPages = ceil($totalItems / $itemsPerPage);

                // Display pagination links
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<a href="?page=' . $i . '"">' . $i . '</a>';
                    //echo '<a href="?project_id='.$project_id.'&page=' . $i . '"">' . $i . '</a>';
                    //echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                }
                echo '</div>';
             ?>
			</div>	

		    <?php include "include/footer.php";?>

		</div><!-- main -->

</body>
<html>
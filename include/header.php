<?php 
 // Start the session at the beginning of the script

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to the login page
    exit(); // Ensure no further code is executed
} else {
    $user_id = $_SESSION['user_id']; // Retrieve the user ID from the session
    // You can now use $user_id in your script
    //echo "User ID: " . htmlspecialchars($user_id); // Example usage
}
?>

<div id="header">
	<div class="header_title">miniwrike</div>
	<div class="logged_user">

				<div class="user_picture">
    			<?php
              $image = "img/users_pics/" . $_SESSION['user_id'] . "/user_" . $_SESSION['user_id'] . "_32x32.jpg";
              echo "<img src='" . $image . "' alt='" . $_SESSION['user_id'] . "' class='circle'>";
              ?>
    			</div>
    			<a href="project_user_profile.php?user_id=<?php echo $_SESSION['user_id'] ?>"><?php echo GetUserNameByid($_SESSION['user_id']) ?></a></li>
    			<?php
              $msg_count = NrofMessages($_SESSION['user_id']);
              echo "<a href='project_inbox.php?user_id=1' class='small-blue-badge'>$msg_count</a>";
              ?>
    			<div id="clock"></div>
                </div><!-- logged_user -->
</div><!-- header -->

<script type="text/javascript">
        
    </script>
			 <?php
if (isset($_GET['project_id'])) {
	$project_id = $_GET['project_id'];
} else {
	$project_id = $_SESSION['project_id'];
}
?>
<div class="menu">
	<ul>
		<li><a href="projects.php">Home</a></li>
		<li><a href="project.php?project_id=<?php echo $project_id ?>">Project details</a></li>
		<li><a href="project_tasks.php?project_id=<?php echo $project_id ?>">Tasks</a></li>
		<li><a href="project_comments.php?project_id=<?php echo $project_id ?>">Comments</a></li>
		<li><a href="project_events.php?project_id=<?php echo $project_id ?>">Events*</a></li>
		<li><a href="project_stream.php?project_id=<?php echo $project_id ?>">Project stream</a></li>
		<li><a href="project_docs.php?project_id=<?php echo $project_id ?>">Docs*</a></li>
		<li><a href="project_conversation.php?project_id=<?php echo $project_id ?>">Chat</a></li>
		<!--<li><a href="project_links.php?project_id=<?php echo $project_id ?>">Links</a></li>-->
		<li><a href="project_workload.php?project_id=<?php echo $project_id ?>">Workload</a></li>
		<li><a href="project_contacts.php?project_id=<?php echo $project_id ?>">Contacts*</a></li>
		<li><a href="miniwrike_ideas.php">Ideas</a></li>
	 </ul>
</div>
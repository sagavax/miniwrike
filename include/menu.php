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
		<li><a href="project.php">Project details</a></li>
		<li><a href="project_tasks.php">Tasks</a></li>
		<li><a href="project_comments.php">Comments</a></li>
		<li><a href="project_events.php">Events*</a></li>
		<li><a href="project_stream.php">Project stream</a></li>
		<li><a href="project_docs.php">Docs*</a></li>
		<li><a href="project_conversation.php">Chat</a></li>
		<!--<li><a href="project_links.php">Links</a></li>-->
		<li><a href="project_workload.php">Workload</a></li>
		<li><a href="project_contacts.php">Contacts*</a></li>
		<li><a href="miniwrike_ideas.php">Ideas</a></li>
	 </ul>
</div>
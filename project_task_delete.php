 <?php

	include ("include/dbconnect.php");
	
?>	

<meta HTTP-EQUIV="REFRESH" content="3;url=index.php">

<link href="css/style.css" rel="stylesheet" type="text/css">

<div id="container">
  <div id="center" class="column">

	
        
<?php	
	//$q=$_GET["q"];
	//echo "$q";
	//$sql="DELETE FROM tbldev_notepad WHERE NoteID = '".$q."'";
        $sql="DELETE FROM project_tasks WHERE NoteID = $id";
        echo "$sql";
	$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
	echo "<br /><div class='msgbox'><b>The note has been deleted successfuly.</b></div>";
	
?>

</div>
</div>

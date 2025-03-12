<?php

include ("include//dbconnect.php");

$conv_group_id=$_GET['conv_group_id'];

$sql="SELECT COUNT(*) as nr_feeds from project_conversation_feeds where conv_group_id=$conv_group_id";
$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
$row = mysqli_fetch_array($result);
$nr_feeds=$row['nr_feeds'];
if ($nr_feeds>0){ //mame zaznamy

	$sql="DELETE from project_conversation_feeds where conv_group_id=$conv_group_id"; //najprv vymzeme chatove feedy
	$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());

	$sql="DELETE from project_conversation_groups where id=$conv_group_id"; //a potom vymazeme samotnu grupu
	$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());


} elseif ($nr_feeds==0){ // ak je konverzacna grupa prazdna

	$sql="DELETE from project_conversation_groups where id=$conv_group_id"; //potom vymazeme samotnu grupu
	$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
}

echo "<script>
		alert('Done!');
     </script>";	

/*

		echo "<script>
	if(confirm('We do have records here!');
	else ('')
    </script>";	

*/
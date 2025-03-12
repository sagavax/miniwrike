<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Miniwrike - links</title>
    <link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel='shortcut icon' href='project.ico'>

</head>

<body>

    <?php $project_id = $_GET['project_id'];
$project_id = $_SESSION['project_id'];?>

    <div id="main">
        <!-- main wrapper -->


        <!-- header -->

        <?php include "include/header.php";?>
        <?php include "include/menu.php";?>

         <?php echo ProjectTitle($project_id); ?>


         <div id="middle">

            <div id="new_link">
                <a href="project_link.php?action=new&project_id=<?php echo $project_id; ?>" class="blue-badge">+ New link</a>
            </div>
            <div style="width:100%">
                <table id="link_maintable">

                    <?php
$sql = "SELECT * from project_links WHERE project_id=$project_id";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());while ($row = mysqli_fetch_array($result)) {
	$project_id = $row['project_id'];
	$link_id = $row['link_id'];
	$link_name = $row['link_name'];
	$link_url = $row['link_url'];
	$created_date = $row['created_date'];
	$added_by = $row['added_by'];
	$added_by = GetUserNamebyId($added_by);
	echo "<tr>";if ($link_url != '') {echo "
                    <td><a href=$link_url class='link'>$link_name</a>
                    </td>";} else {echo "
                    <td>$link_name</td>";}
	echo "
                    <td><a href='project_user_profile.php?user_id=$added_by' class='link'>$added_by</a>
                    </td>
                    <td>$created_date</td>
                    <td><a href='project_link.php?action=view&link_id=$link_id&project_id=$project_id' class='link'>view</a>
                        <td><a href='project_link.php?action=edit&link_id=$link_id&project_id=$project_id' class='link'>edit</a>
                        </td>
                        <td>
                            <a href='project_link.php?action=delete&link_id=$link_id&project_id=$project_id' ' class='link '>delete</a></td>";
	echo "</tr>";

}

?>
					</table>
				</div>
			</div><!-- middle -->

			<?php include "include/footer.php";?>


		</div> <!--main wrap -->



</body>
</html>
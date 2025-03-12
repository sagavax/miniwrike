<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>


<?php

if (isset($_POST['add_new_project'])) {
	header('Location: project_add.php');
}

?>

<html>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />
	<title>Miniwike</title>
    <link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
    <link rel='shortcut icon' href='project.ico'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        function startTime()
        {
        var today=new Date();
        var h=today.getHours();
        var m=today.getMinutes();
        var s=today.getSeconds();

        // add a zero in front of numbers<10
        m=checkTime(m);
        s=checkTime(s);
        if(h<12)
        document.getElementsByClassName('clock').innerHTML=h+":"+m+":"+s + " AM";
        else
        document.getElementsByClassName('clock').innerHTML=h+":"+m+":"+s + " PM";

        t=setTimeout('startTime()',500);
        }

        function checkTime(i)
        {
        if (i<10)
          {
          i="0" + i;
          }
        return i;
        }
    </script>


</head>


<body>

        <?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$_SESSION['user_id'] = $user_id;
$_SESSION['user_id'] = 1;
?>
      <div id="main">

      <?php include "include/header.php";?>
      	<!-- <div class="logged_user">Tomas Misura</div> -->
			<!-- <div class="circle"></div> -->
			<div class="menu">
                <ul>
                    <li><a href=".">Home</a></li>
                </ul>
            </div>
		    <div id="add_project"> <!--- add task -->
						<form accept-charset="utf-8" method="post" action="index.php">
		                    	<span style="margin-top:10px; margin-left:10px"><button type="submit" name="add_new_project" class="blue-badge-large">+ Project</button></span>
						</form>

            </div> <!--- add task -->


			<div id="middle"> <!-- list of projects -->
               <div> <!-- list of projects -->
                <table id="projects_new">
                  <th>Project name</th><th>Project description</th><th>Customer</th><th># of tasks</th><th>Established</th><th>Status</th><th></th>

                    <?php
$sql = "SELECT * FROM projects where project_status not in ('Cancelled','Completed')  ORDER BY id DESC";
$result = mysqli_query($db, $sql);

$alternate = "2";

while ($row = mysqli_fetch_array($result)) {
	$id = $row['id'];
	$project_name = $row['project_name'];
	//$project_code = $row['project_code'];
	$project_descr = $row['project_descr'];
	$customer_id = $row['project_customer'];
	$established_date = $row['established_date'];
	$project_status = $row['project_status'];

	if ($established_date == '0000-00-00') {$established_date = 'N/A';}

	if ($alternate == "1") {
		$color = "even";
		$alternate = "2";
	} else {
		$color = "odd";
		$alternate = "1";
	}

	$NrofTask = NrofTasks($id);
	$customer_name = GetCustomerName($customer_id);

	echo "<tr id='" . $id . "'>";
	echo "<td style='width:120px;font-weight:bold;text-transform:uppercase'><i class='fa fa-briefcase'></i><a href='project_details.php?project_id=$id'><span style='margin-left:5px'>$project_name<span></a></td>";
	echo "<td style='width:450px'>$project_descr</td>";
	echo "<td><a href='project_customer_view.php?cid=$customer_id'>$customer_name</a></td>";
	echo "<td><a href='project_tasks.php?project_id=$id'><div class='grey-badge'>$NrofTask</div></a></td>";
	echo "<td style='width:80px'>$established_date</td>";
	echo "<td><div class='status_badge'>$project_status</div></td>";
	echo "<td><a href='project_details.php?project_id=$id' class='blue-badge'>Enter</a></td>";

	echo "</tr>";
}
?>
                   </table>
                </div> <!-- list of projects -->
                <div style="clear:both;"></div>

            </div> <!-- middle -->

            <div style="clear:both;"></div>
			<?php include "include/footer.php";?>
		</div>
</body>
</html>

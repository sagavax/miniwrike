
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();?>

<?php

global $db;
if (isset($_POST['login'])) {
	$user_name = mysqli_real_escape_string($db, $_POST['login_name']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	$sql = "SELECT * from users where login = '$user_name' and heslo = '$password'";
	//echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQLi ERROR: " . mysqli_error($db));
	$overeni = mysqli_num_rows($result);
	$rows = mysqli_fetch_array($result);
	//print_r($rows);
	if (mysqli_num_rows($result) == 1) {
		$id = $rows['id'];
		$_SESSION['user_id'] = $id;
		echo "<script>sessionStorage.setItem('logged_user_id',$id)</script>";
		echo "<script>alert('Login successful!');

        window.location.href='projects.php';
        </script>";
	} else {
		echo "<script>alert('Bad user name or password');
        window.location.href='index.php';
        </script>";
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Miniwike</title>
    <link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="css/login.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel='shortcut icon' href='project.ico'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="js/clock.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
	   <div id="main">

      <!-- <div class="logged_user">Tomas Misura</div> -->
			<!-- <div class="circle"></div> -->
		  <div class="login_wrap">
              <div class="login">

                <form action="" method="post">
                  <h3>miniwrike login</h3>
                  <input type="text" name="login_name">
                  <input type="password" name="password">
                  <button type="submit" name="login">Login</button>
                </form>
              </div><!-- login -->

        </div><!-- login_wrap -->
		</div>
  </body>
</html>

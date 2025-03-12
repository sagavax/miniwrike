<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();


$char = $_GET['char'];


$get_peple = "SELECT * from project_users WHERE LEFT(last_name,1)='$char'";
$result = mysqli_query($db, $get_peple) or die(mysqli_error($db));

while ($row = mysqli_fetch_array($result)) {
        $user_id = $row['user_id'];
        $user_name = GetUserNameById($user_id);
        
echo "<button type='button' class='button'>$user_name</button>";   
}
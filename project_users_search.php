<?php 
include "include/dbconnect.php";
include "include/functions.php";
session_start();

if (isset($_GET['search_string']) && !empty($_GET['search_string'])) {
    $search_string = htmlspecialchars($_GET['search_string'], ENT_QUOTES, 'UTF-8');
    $get_people = "SELECT * FROM project_users WHERE last_name LIKE '%" . $search_string . "%'";
    $result = mysqli_query($db, $get_people) or die(mysqli_error($db));

    while ($row = mysqli_fetch_array($result)) {
        $user_id = $row['user_id'];
        $user_name = GetUserNameById($user_id);
        echo "<button type='button' class='button'>$user_name</button>";   
    }
} 
?>

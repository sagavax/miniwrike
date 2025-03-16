<?php include "include/dbconnect.php";
      include "include/functions.php";
      session_start();
           
           $bug_title = mysqli_real_escape_string($db,$_POST['bug_title']);
            $bug_text = mysqli_real_escape_string($db,$_POST['bug_text']);
            $is_fixed = 0;

           //var_dump($_POST);

            $save_bug = "INSERT INTO bugs (bug_title, bug_text, is_fixed, added_date) VALUES ('$bug_title','$bug_text',$is_fixed,now())";
            $result=mysqli_query($db, $save_bug) or die(mysqli_error($db))  ;
        
        echo "<script>alert('Minecraft IS: Bol vtytvoreny nova bug');
        window.location.href='miniwrike_bugs.php';
        </script>";
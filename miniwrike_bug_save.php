<?php include "include/dbconnect.php";
      include "include/functions.php";
      session_start();
           
           $idea_title = $_POST['bug_title'];
            $idea_text = $_POST['bug_text'];
            $is_fixed = 0;

           //var_dump($_POST);

            $save_idea = "INSERT INTO bugs (bug_title, bug_text, is_applied, added_date) VALUES ('$bug_title','$bug_text', $is_fxed,now())";
            $result=mysqli_query($db, $save_idea) or die(mysqli_error($db))  ;
        
        echo "<script>alert('Minecraft IS: Bola vtytvorena nova idea');
        window.location.href='miniwrike_ideas.php';
        </script>";
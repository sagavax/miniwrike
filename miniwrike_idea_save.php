<?php include "include/dbconnect.php";
      include "include/functions.php";
      session_start();
           
           $idea_title = $_POST['idea_title'];
            $idea_text = $_POST['idea_text'];
            $is_applied = 0;

           //var_dump($_POST);

            $save_idea = "INSERT INTO ideas (idea_title, idea_text, is_applied, added_date) VALUES ('$idea_title','$idea_text', $is_applied,now())";
            $result=mysqli_query($db, $save_idea);
        
        echo "<script>alert('Minecraft IS: Bola vtytvorena nova idea');
        window.location.href='miniwrike_ideas.php';
        </script>";
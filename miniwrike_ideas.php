<?php session_start();
 include "include/dbconnect.php";
 include "include/functions.php";
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<title>Miniwike</title>
    <link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="css/ideas.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel='shortcut icon' href='project.ico'>
    <script type="text/javascript" src="js/ideas.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
		<div id="main">
			 <?php
			 	 include "include/header.php";
			 	  include "include/menu.php";
			 ?>
		
    	<div id="middle">
    		 <h3>Ideas for the informating system</h3>
              <div class="new_idea">
                <form action="miniwrike_idea_save.php" method="post">
                      <input type="text" name="idea_title" placeholder="idea title here" id="idea_title" autocomplete="off">
                      <textarea name="idea_text" placeholder="Put a your idea(s) here..." id="idea_text"></textarea>
                      <div class="new_idea_action">
                        <button type="submit" name="save_idea" class="button">Save</button>
                      </div>
               </form>
              </div><!-- new idea-->
              
              <div class="ideas_list">
                  <?php

                          $itemsPerPage = 10;

                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                     $offset = ($current_page - 1) * $itemsPerPage;


                        $get_ideas = "SELECT * from ideas ORDER BY idea_id DESC LIMIT $itemsPerPage OFFSET $offset";
                        $result=mysqli_query($db, $get_ideas);
                        while ($row = mysqli_fetch_array($result)) {
                              $idea_id = $row['idea_id'];
                              $idea_title = $row['idea_title'];
                              $idea_text = $row['idea_text'];
                              $is_applied = $row['is_applied'];
                              $added_date = $row['added_date'];

                              echo "<div class='idea'>";
                                    echo "<form action='' method='post'>";
                                    echo "<div class='idea_title'>$idea_title</div>";
                                    echo "<div class='idea_text'>$idea_text</div>";
                                    echo "<div class='idea_footer'>";
                                    
                                      echo "<input type='hidden' name='idea_id' value=$idea_id>";
                                      echo "<input type='hidden' name='is_applied' value=$is_applied>";
                                      $nr_of_comments = GetCountIdeaComments($idea_id);
                                      echo "<div class='span_modpack'>$nr_of_comments comment(s)</div>";
                                      
                                      echo "<button type='submit' name='see_idea_details' class='button small_button'><i class='fa fa-eye'></i></button>";
                                      

                                   if($is_applied==0){
                                      echo "<button type='submit' name='delete_idea' class='button small_button'><i class='fa fa-times'></i></button>";
                                        echo "<button type='submit' name='to_apply' class='button small_button'><i class='fa fa-check'></i></button>";
                                          
                                    } else {

                                          echo "<div class='span_modpack'>applied</div>";
                                    }        


                                    echo "</form>";      
                                    echo "</div>";
                              echo "</div>"; // idea
                        }      
                  ?>
              </div>
             <?php
                // Calculate the total number of pages
                $sql = "SELECT COUNT(*) as total FROM ideas";
                $result=mysqli_query($db, $sql);
                $row = mysqli_fetch_array($result);
                $totalItems = $row['total'];
                $totalPages = ceil($totalItems / $itemsPerPage);

                // Display pagination links
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<a href="?page=' . $i . '"">' . $i . '</a>';
                      //echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                }
                echo '</div>';
             ?>
    	</div><!--middle -->
    	</div><!-- main-->	
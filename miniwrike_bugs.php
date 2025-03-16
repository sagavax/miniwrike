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
	<title>Miniwike - bugs</title>
    <link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="css/bugs.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel='shortcut icon' href='project.ico'>
    <script type="text/javascript" src="js/bugs.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
		<div id="main">
			 <?php
			 	 include "include/header.php";
			 	  include "include/menu.php";
			 ?>
		
    	<div id="middle">
    		 <h3>bugs for the informating system</h3>
              <div class="new_bug">
                <form action="miniwrike_bug_save.php" method="post">
                      <input type="text" name="bug_title" placeholder="bug title here" id="bug_title" autocomplete="off">
                      <textarea name="bug_text" placeholder="Put a your bug / error(s) here..." id="bug_text"></textarea>
                      <div class="new_bug_action">
                        <button type="submit" name="save_bug" class="button">Save</button>
                      </div>
               </form>
              </div><!-- new bug-->
              
              <div class="bugs_list">
                  <?php

                          $itemsPerPage = 10;

                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                     $offset = ($current_page - 1) * $itemsPerPage;


                        $get_bugs = "SELECT * from bugs ORDER BY bug_id DESC LIMIT $itemsPerPage OFFSET $offset";
                        $result=mysqli_query($db, $get_bugs);
                        while ($row = mysqli_fetch_array($result)) {
                              $bug_id = $row['bug_id'];
                              $bug_title = $row['bug_title'];
                              $bug_text = $row['bug_text'];
                              $is_fixed = $row['is_fixed'];
                              $added_date = $row['added_date'];

                              echo "<div class='bug'>";
                                    echo "<form action='' method='post'>";
                                    echo "<div class='bug_title'>$bug_title</div>";
                                    echo "<div class='bug_text'>$bug_text</div>";
                                    echo "<div class='bug_footer'>";
                                    
                                      echo "<input type='hidden' name='bug_id' value=$bug_id>";
                                      echo "<input type='hidden' name='is_applied' value=$is_fixed>";
                                      $nr_of_comments = GetCountbugComments($bug_id);
                                      echo "<div class='span_modpack'>$nr_of_comments comment(s)</div>";
                                      
                                      echo "<button type='submit' name='see_bug_details' class='button small_button'><i class='fa fa-eye'></i></button>";
                                      

                                   if($is_fixed==0){
                                      echo "<button type='submit' name='delete_bug' class='button small_button'><i class='fa fa-times'></i></button>";
                                        echo "<button type='submit' name='mark_as_fixed' class='button small_button'><i class='fa fa-check'></i></button>";
                                          
                                    } else {

                                          echo "<div class='span_modpack'>fixed/div>";
                                    }        


                                    echo "</form>";      
                                    echo "</div>";
                              echo "</div>"; // bug
                        }      
                  ?>
              </div>
             <?php
                // Calculate the total number of pages
                $sql = "SELECT COUNT(*) as total FROM bugs";
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
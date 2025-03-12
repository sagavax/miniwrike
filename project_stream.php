<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";
session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

      <title>Miniwrike - simple project task manager</title>
      <link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
      <link href="css/stream.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
      <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
      <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
      <link rel='shortcut icon' href='project.ico'>
   </head>
   <body>

      <div id="main">
         <!-- header -->
         <?php include "include/header.php";?>
         <?php include "include/menu.php";?>
         <!-- header -->

         <?php

            $project_id = $_SESSION['project_id'];
            //echo $project_id;
            $user_id = $_SESSION['user_id'];

            ?>

          <?php echo ProjectTitle($project_id); ?>


         <div id="middle">
            <!-- middle section -->

            <div class="project_stream_wrap">
               <h3> Project stream </h3>
               <?php
                     $recordsPerPage = 10;

                  // Get the current page number, default to 1 if not provided
                  $page = isset($_GET['page']) ? $_GET['page'] : 1;

                  // Calculate the offset for the SQL query
                  $offset = ($page - 1) * $recordsPerPage;

                  // Construct the SQL query with pagination
                  $sql = "SELECT COUNT(*) AS total_records FROM project_stream WHERE project_id=$project_id";
                  $result = mysqli_query($db, $sql);
                  $row = mysqli_fetch_assoc($result);
                  $totalRecords = $row['total_records'];

                  $sql = "SELECT * FROM project_stream WHERE project_id=$project_id ORDER BY id DESC LIMIT $offset, $recordsPerPage";
                  $result = mysqli_query($db, $sql);

                  // Display the fetched records
                  while ($row = mysqli_fetch_assoc($result)) {
                      $text_of_stream = $row['text_of_stream'];
                      $date_added = $row['date_added'];

                      echo "<div class='stream_post'><span><i class='fa fa-clock-o'></i></span><span class='stream_post_text'>$text_of_stream</span><span class='stream_post_date'>$date_added</span></div>";
                  }

                  // Calculate total number of pages
                  $totalPages = ceil($totalRecords / $recordsPerPage);

                  // Display pagination links
                  echo "<div class='pagination'>";
                  for ($i = 1; $i <= $totalPages; $i++) {
                      $activeClass = ($i == $page) ? 'active' : '';
                      echo "<a class='pagination-link $activeClass' href='?project_id=$project_id&page=$i'>$i</a>";
                  }
                  echo "</div>";
                     ?>
               </div>
         </div>
         <!-- middle section -->
         <?php include "include/footer.php";?>
      </div>
      <!--main wrap -->
   </body>
</html>
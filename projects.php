<?php
include "include/dbconnect.php";
include "include/functions.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Miniwike</title>
  <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
  <link href="css/projects.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
  <link rel='shortcut icon' href='project.ico'>
  <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="js/clock.js" defer></script>
  <script type="text/javascript" src="js/projects.js" defer></script>
</head>

<body>
  <div id="main">
    <?php include "include/header.php"; ?>

    <div class="add_project">
      <button type="button" name="add_new_project" class="blue-badge-large"><i class="fa fa-plus"></i> Project
      </button>
    </div>

    <div class="search">
      <input type="text" name="search_project" id="search_project" placeholder="Search project here..." autocomplete="off">
    </div>

    <div class="projects_sort">
      <button type="button" name="grid" class="blue-badge-large">Grid</button>
      <button type="button" name="list" class="blue-badge-large">List</button>
      <button type="button" name="active" class="blue-badge-large">Active</button>
      <button type="button" name="notactive" class="blue-badge-large">Inactive</button>
      <button type="button" name="all_projects" class="blue-badge-large">All</button>
      <button type="button" name="show_groups" class="blue-badge-large">Groups</button>
    </div>

    <div id="projects_grid">
      <?php
      $sql = "SELECT * FROM projects WHERE project_status='new' 
              UNION ALL 
              SELECT * FROM projects WHERE project_status='in progress' 
              UNION ALL 
              SELECT * FROM projects WHERE project_status='pending'";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));

      $alternate = "2";

      while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $project_name = $row['project_name'];
        $project_descr = $row['project_descr'];
        $customer_id = $row['project_customer'];
        $established_date = $row['established_date'];
        $project_status = $row['project_status'];

        $established_date = ($established_date == '0000-00-00') ? 'N/A' : $established_date;
        $color = ($alternate == "1") ? "even" : "odd";
        $alternate = ($alternate == "1") ? "2" : "1";

        $NrofTask = NrofTasks($id);
        $customer_name = GetCustomerName($customer_id);

        echo "<div class='project' project-id='$id' project-status='$project_status'>";
        echo "<div class='project_priority'></div>";
        echo "<h2>$project_name</h2>";
        echo "<p>$project_descr</p>";
        echo "<span>" . ProjectDuration($id) . "</span>";
        echo "<div class='project_status'>$project_status</div>";
        echo "</div>";
      }
      ?>
    </div>
    <?php include "include/footer.php"; ?>
  </div>

  <dialog id="create_new_project">
    <input type="text" name="project_name" id="project_name" placeholder="Project Name" autocomplete="off" />
    <input type="text" name="project_code" id="project_code" placeholder="Project Code" autocomplete="off" />
    <div class="customer_wrap">
      <?php echo GetCustomerList(); ?>
      <button type="button" name="new_customer" title="Add new customer"><i class="fa fa-plus"></i></button>
    </div>
    <textarea name="project_description" onkeyup="textAreaAdjust(this)" id="project_description" placeholder="Describe this project..."></textarea>
    <div class="project_action">
      <button type="button" name="history_back">Back</button>
      <button type="button" name="new_project"><i class="fa fa-plus"></i> New Project</button>
    </div>
  </dialog>
</body>
</html>

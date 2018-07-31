<?php
/*
* Author : Ali Aboussebaba
* Email : bewebdeveloper@gmail.com
* Website : http://www.bewebdeveloper.com
* Subject : Dynamic Drag and Drop with jQuery and PHP
*/

// including the config file
include('config.php');
$pdo = connect();
// select all items ordered by item_order
$sql = 'SELECT * FROM items ORDER BY item_order ASC';
$query = $pdo->prepare($sql);
$query->execute();
$list = $query->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Drag and Drop using jQuery and Ajax</title>
<link rel="stylesheet" href="css/style.css" />
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="images/BeWebDeveloper.png" alt="BeWebDeveloper" />
        </div><!-- header -->
        <h1 class="main_title">Drag and Drop using jQuery and Ajax</h1>
        <div class="content">

        <ul id="sortable">
            <?php
            foreach ($list as $rs) {
            ?>
            <li id="<?php echo $rs['id']; ?>">
                <span></span>
                <img src="<?php echo $rs['photo']; ?>">
                <div><h2><?php echo $rs['title']; ?></h2><?php echo $rs['description']; ?></div>
            </li>
            <?php
            }
            ?>
        </ul>
        </div><!-- content -->    
        <div class="footer">
            Powered by <a href="http://www.bewebdeveloper.com/">bewebdeveloper.com</a>
        </div><!-- footer -->
    </div><!-- container -->
</body>
</html>

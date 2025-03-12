<?php 
session_start();
include "include/dbconnect.php";
include "include/functions.php";

if (isset($_POST['add_conv_group'])) {
    // Adding a new group
    
}

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Miniwrike - simple project task manager</title>
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href="css/conversation.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="js/conversation.js?v=<?php echo time(); ?>" defer></script>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic" rel="stylesheet">
    <link rel="shortcut icon" href="project.ico">
</head>
<body>
    <?php
    error_reporting(0);
    $project_id = $_GET['project_id'];
    $user_id = $_SESSION['user_id'];
    echo "<script>sessionStorage.setItem('user_id',$user_id)</script>";

    if (isset($_GET['conv_group_id'])) {
        $conv_group_id = $_GET['conv_group_id'];
        echo "<script>sessionStorage.setItem('conv_group',$conv_group_id)</script>";
    } else {
        echo "<script>sessionStorage.setItem('conv_group',0)</script>";
    }
    ?>
    <div id="main">
        <!-- header -->
        <?php include "include/header.php"; ?>
        <!-- header -->
        <?php include "include/menu.php"; ?>
        <?php echo ProjectTitle($project_id); ?>
        <!-- project title -->
        <div id="middle">
            <!-- middle section -->
            <div id="add_group">
                    <input type="text" name="group_title" placeholder="Enter name of conversation group" autocomplete="off">
                    <button type="submit" name="add_conv_group"><i class="fa fa-plus"></i> <i class="fa fa-users"></i></button>
                </form>
            </div>
            <div id="conversation_wrap">
                <div class="conv_group_list">
                    <?php
                    $sql = "SELECT group_id, group_title FROM project_conversation_group WHERE project_id = $project_id";
                    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
                    while ($row = mysqli_fetch_array($result)) {
                        $group_id = $row['group_id'];
                        $group_title = $row['group_title'];
                        $feeds = GetNrofFeeds($project_id, $group_id);
                        echo "<button type='button' data-id='$group_id'>$group_title<div class='conv_group_feed_count'>$feeds</div></button>";
                    }
                    ?>
                </div>
                <div class="conv_group_chat_wrap">
                    <div class="chat">
                        <?php
                        if (!isset($_GET['conv_group_id'])) {
                            echo "<div class='msg_box'>No conversation group has been selected!</div>";
                        } else {
                            $conv_group_id = $_GET['conv_group_id'];
                            $sql = "SELECT * FROM project_conversation_feeds WHERE project_id = $project_id AND conv_group_id = $conv_group_id";
                            $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
                            while ($row = mysqli_fetch_array($result)) {
                                $id = $row['id'];
                                $user_id = $row['user_id'];
                                $conversation_text = $row['conversation_text'];
                                $date_created = $row['date_created'];
                                $user_name = GetUserNameById($user_id);

                                echo "<div feed-id='$id' class='feed'><div class='feed_user_name'><a href='project_user_profile.php?id=$user_id'>$user_name</a></div><div class='feed_text'>$conversation_text</div><div class='feed_time'>" . time_ago($date_created) . "</div><div class='feed_del'><a href='project_conversation.php?feed_id=$id' class='link'><i class='fa fa-times'></i></a></div></div>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <!-- conversation_wrap -->
             </div>
             <div id="add_comment">
                    <?php
                    if (!isset($_GET['conv_group_id'])) {
                        $conv_group_id = 0;
                    } else {
                        $conv_group_id = $_GET['conv_group_id'];
                    }
                    ?>
                    
                        <textarea class="ckeditor" name="chat_comment" id="chat_editor" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
                        <button name="add_feed" type="button">Send</button>
                </div><!-- add comment -->
            <!-- div middle -->
            <?php include "include/footer.php"; ?>
        </div>
        <!-- main -->
    </div>
</body>
</html>
<?php session_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>
<?php 
   if(isset($_POST['add_conv_group'])){ // pridavame novu groupu
   	$project_id=intval($_POST['project_id']);
   	$user_id=1;
   	$user_name=GetUserNameById($user_id);
   	$project_name=GetProjectName($project_id);
   	$group_title=mysql_real_escape_string($_POST['group_title']);
   	$date_created=date('Y-m-s H:i:s');
   	
   	$sql="INSERT INTO project_conversation_group (project_id,created_by,group_title,created_date) VALUES ($project_id,$user_id,'$group_title','$date_created')";
   		
   	//echo $sql;
   	$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
   
   	$sql="SELECT max(group_id) as group_id from project_conversation_group WHERE project_id=$project_id";
   	$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
   	
   	while ($row = mysql_fetch_array($result)) {
   		$conv_group_id=$row['group_id'];
   	} 
   
   	//pridat do projektoveho logu /  streamu
   	
   	$stream_group="chat_group";
   	$text_streamu = "User <a href='project_user_profile.php?id=$user_id'>".$user_name."</a> has created a new conversation group id ".$group_id." for the project:<a href='project_details.php?project_id=$project_id'>".$project_name."</a>";
   				$text_streamu=addslashes($text_streamu);
   				$datum=date('Y-m-d H:i:s');
   				$sql="INSERT INTO project_stream (project_id,stream_group,user_id,text_of_stream, date_added) VALUES ($project_id,'$stream_group',$user_id,'$text_streamu','$datum')";
                      $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
            //echo $sql; */
            $url="project_conversation.php?project_id=$project_id&user_id=$user_id&conv_group_id=$conv_group_id";
            //echo $url;
            header('location:'.$url.'');
   	} 
   
   	/*----------------------------------------------------------		
   			
   			CHAT
   	
   	-----------------------------------------------------------*/
     
     if(isset($_POST['add_feed'])) { // chatujem
     	$chat_comment=mysql_real_escape_string($_POST['chat_comment']);
     	$conv_group_id=intval($_POST['conv_group_id']);
   		$project_id=$_POST['project_id'];
     	
     	$user_id=$_POST['user_id'];
     	$date_added=date('Y-m-d H:i:s');
     	
     	if($chat_comment==''){
     		echo "Empty feed";
     		$url="project_conversation.php?project_id=$project_id&user_id=$user_id&conv_group_id=conv_group_id";
     		header('location:'.$url.'');
     	} elseif ($conv_group_id==0){
     		echo "No group has been selected";
     		$url="project_conversation.php?project_id=$project_id&user_id=$user_id";
     		header('location:'.$url.'');
     		
     		
     	} 	else {  	
   
   
     	$sql="INSERT INTO project_conversation_feeds (project_id,user_id,conv_group_id,conversation_text,date_created) VALUES ($project_id,$user_id,$conv_group_id,'$chat_comment','$date_added')";
     	//echo $sql;
     	$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
   
   
   
   	$sql="SELECT max(id) as feed_id from project_conversation_feeds WHERE project_id=$project_id";
   	$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
   	
   	while ($row = mysql_fetch_array($result)) {
   		$feed_id=$row['feed_id'];
   	} 
   
   	//pridat do projektoveho logu /  streamu
   	$user_name=GetUserNameById($user_id);
   	$project_name=GetProjectName($project_id);
   	$stream_group="chat_feed";
   	$text_streamu = "User <a href='project_user_profile.php?id=$user_id'>".$user_name."</a> has added a new conversation feed id ".$feed_id." in chat room id <a href='project_conversation.php?project_id=$project_id&conv_group_id=$conv_group_id' class='link'>".$conv_group_id."</a> for the project:<a href='project_details.php?project_id=$project_id'>".$project_name."</a>";
   				$text_streamu=addslashes($text_streamu);
   				$datum=date('Y-m-d H:i:s');
   				$sql="INSERT INTO project_stream (project_id,stream_group,user_id,text_of_stream, date_added) VALUES ($project_id,'$stream_group',$user_id,'$text_streamu','$datum')";
                      $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
   
     	$url="project_conversation.php?project_id=$project_id&user_id=1&conv_group_id=$conv_group_id";
     	header('location:'.$url.'');
     	
     	}
     }	
   ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
      <title>Miniwrike - simple project task manager</title>
      <link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
      <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
      <script src="ckeditor/ckeditor.js"></script>
      <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
      <link rel='shortcut icon' href='project.ico'>
   </head>
   <body>
      <?php
         error_reporting(0);
         
         $project_id=$_GET['project_id'];
         $user_id=$_SESSION['user_id'];
         //$user_id=1;
         if(isset($_GET['conv_group_id'])){
         	$conv_group_id=$_GET['conv_group_id'];
         }
         
         ?>	
      <div id="main">
         <script type="text/javascript">	
            $( document ).ready( function() {
            	$( 'textarea#chat_editor' ).ckeditor();
            	} );
            
         </script>	
         <!-- header -->
         <?php include ("include/header.php"); ?>
         <!-- header -->
         <?php 
            ?>
         <?php include ("include/menu.php"); ?>
         <div id="project_title">
            <!-- project title -->
            <?php
               $sql="SELECT * from projects where id=$project_id";
               $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
               	while ($row = mysql_fetch_array($result)) {
               		$project_name=$row['project_name'];
               		$project_description=$row['project_descr'];
               
               		//echo "<div id='project_short_details_wrap'>";
               		echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Roboto, Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";   //boldovo
               		echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Roboto, Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
               		//echo "</div>";
               
               	}
               
               	?>
         </div>
         <!-- project title -->
         <div id="middle">
            <!-- middle section -->
            <div id="add_group">
               <form action="project_conversation.php" method="post">
                  <input type="hidden" name=project_id value=<?php echo $project_id; ?>>
                  <input type="hidden" name=user_id value=<?php echo $user_id; ?>>
                  <input type="text" name="group_title" placeholder="enter name of conversation group"><button type="submit" name="add_conv_group">+ <i class="fa fa-users"></i></button>
               </form>
            </div>
            <div id="conversation_wrap">
               <div id="conv_group_list">
                  <ul>
                     <?php
                        $sql="SELECT group_id,group_title from project_conversation_group WHERE project_id=$project_id";
                        $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
                        while ($row = mysql_fetch_array($result)) {
                        $group_id=$row['group_id'];
                        $group_title=$row['group_title'];
                        $feeds=GetNrofFeeds($project_id,$group_id);
                        echo "<li><a href='project_conversation.php?project_id=$project_id&conv_group_id=$group_id'><div class='conv_group_name'>$group_title</div></a><div class='conv_grop_feed_count'>$feeds</div><div style='float:right;margin-right:10px'><a href='project_conv_group_delete.php?conv_group_id=$conv_group_id' class='link'>x</a></div></li>";
                        }
                        echo "<div style='clear:both'></div>";
                        ?>
                  </ul>
               </div>
               <?php 
                  if(!isset($_GET['conv_group_id'])){
                  	echo "<div class='msg_box'>No conversation group has been selected!</div>";
                  } else {
                  	$conv_group_id=$_GET['conv_group_id'];
                  ?>	
               <div id="conv_group_chat_wrap">
                  <div class="chat">
                     <!--feeds -->		
                     <?php		
                        $sql="SELECT * from project_conversation_feeds where project_id=$project_id and conv_group_id=$conv_group_id";
                        //echo $sql;
                        $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
                        while ($row = mysql_fetch_array($result)) {
                        	$id=$row['id'];
                        	$user_id=$row['user_id'];
                        	$conversation_text=$row['conversation_text'];
                        	$date_created=$row['date_created'];
                        
                        	$user_name=GetUserNameById($user_id);
                        
                          echo "<div feed_id=$id class='feed'><div class='feed_user_name link' ><a href='project_user_profile.php?=$user_id'>$user_name</a></div><div class='feed_text'>$conversation_text</div><div class='feed_time'>".time_ago($date_created)."</div><div class='feed_del'><a href='project_conversation.php?feed_id=$id' class='link'><i class='fa fa-times'></i></a></div><div style='clear:both'></div></div>";	
                         // echo "<div style='clear:both'></div>";
                        } /*end while */
                        
                        ?>
                  </div>
                  <!--feeds -->
               </div>
               <!--chat wrap -->
               <div style="clear:both"></div>
               <?php 
                  }
                  ?>	
            </div>
            <!-- conversation_wrap -->
            <div id="add_comment">
               <?php 
                  if(!isset($_GET['conv_group_id'])){
                  $conv_group_id='';
                  }else { $conv_group_id=$_GET['conv_group_id'];
                  }	
                  ?>
               <form action="project_conversation.php" method="post">
                  <input type="hidden" name="project_id" value="<?php echo $project_id?>">
                  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                  <input type="hidden" name="conv_group_id" value="<?php echo $conv_group_id; ?>">
                  <textarea class="ckeditor" name="chat_comment" id="chat_editor"></textarea>
                  <button name="add_feed" type="submit">Send</button>
               </form>
            </div>
         </div>
         <!-- div middle -->
         <div style="clear:both"></div>
         <?php include ("include/footer.php"); ?>
      </div>
      <!-- main -->	
   </body>
   <html>

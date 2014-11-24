<?php ob_start();?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>


<?php
      	
		if (isset($_POST['add_new_project'])) {
			header('Location: project_add.php');
		}
		
 ?>

<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />
	<title>Miniwike</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link rel='shortcut icon' href='project.ico'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">

</script>
</head>
<body>
		<div id="main">
			
      <div id="header">miniwrike<div class="logged_user"><div class="circle"></div><div class="user">Tomas Misura</div></div></div>
            
			<!-- <div class="logged_user">Tomas Misura</div> -->
			<!-- <div class="circle"></div> -->
			<div id="menu">
                <ul>
                    <li><a href=".">Home</a></li>                       
                </ul>
            </div>
		    <div id="add_project"> <!--- add task -->
						<form accept-charset="utf-8" method="post" action="index.php">
		                    	<span style="margin-top:10px; margin-left:10px"><button type="submit" name="add_new_project" class="blue-badge-large">+ Project</button></span>
						</form>		
		    
            </div> <!--- add task -->			

			
			<div id="middle"> <!-- list of projects -->
               <div> <!-- list of projects -->
                <table id="projects">
                  <th>Project name</th><th>Project description</th><th>Customer</th><th># of tasks</th><th>Established</th><th>Status</th><th></th>
                 
                    <?php
                    $sql="SELECT DISTINCT * FROM projects ORDER BY id DESC";
                    $result = mysql_query($sql);
                    
                    $alternate = "2"; 
                    
                    while ($row = mysql_fetch_array($result)) {
                    		$id=$row['id'];
                            $project_name=$row['project_name'];
                            //$project_code = $row['project_code'];
                            $project_descr=$row['project_descr'];
                            $customer_id=$row['project_customer'];
                            $established_date=$row['established_date'];
                            $project_status=$row['project_status'];
                    		
                            if ($established_date=='0000-00-00') {$established_date='N/A';}

                            if ($alternate == "1") { 
                    			$color = "even"; 
                    			$alternate = "2"; 
                    		} 
                    		else { 
                    			$color = "odd"; 
                    			$alternate = "1";
                    		}
                             
                          $NrofTask =  NrofTasks($id);
                          $customer_name = GetCustomerName($customer_id);
 
                            echo "<tr class='$color' id='".$id."'>";	
        	              	   echo "<td style='width:100px'>$project_name</td>";
                                echo "<td>$project_descr</td>";
                                echo "<td><a href='project_customer_view.php?cid=$customer_id'>$customer_name</a></td>";
								                echo "<td><a href='project_tasks.php?project_id=$id'><span class='grey-badge'>$NrofTask</span></a></td>";
                                echo "<td style='width:80px'>


                                $established_date</td>";
                                echo "<td>$project_status</td>";
								              echo "<td><a href='project_details.php?project_id=$id' class='blue-badge'>Enter</a></td>";
								
                                
        	               echo "</tr>";
                        }   
                        ?>
                   </table> 
                </div> <!-- list of projects -->  
                <div style="clear:both;"></div> 
                
            </div> <!-- middle -->
            
            <div style="clear:both;"></div>
			<div id="footer"><!-- FOOTER -->
					<ul id="footer-left">
						<li>Simple miniproject administrator/manager</li>
						<li>Created by Tomas Misura</li>
					</ul>		
			</div> <!-- FOOTER -->
		</div>
</body>
</html>
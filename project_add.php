<?php ob_start();?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>


<?php
            if (isset($_POST['new_project'])) {

                    $project_name=$_POST['project_name'];
                    $project_code=$_POST['project_code'];
                    $project_descr=$_POST['project_description'];
                    $project_status=$_POST['project_status'];
					$project_customer=$_POST['project_customer'];
                    /*if ($project_name=='All') { //ak si zvolim vsetky projekty a
                              echo "<script language=javascript>alert('Zvol si spravny projekt')</script>";
                    } else {*/

                    
                    $curr_date=(date('Y-m-d'));
                    //date=strtotime(date('Y-m-d', strtotime($curr_date)) . " +10 day");
                    //$end_date= date('Y-m-d', $date);
                
                    $sql = "INSERT INTO projects (project_name,project_code, project_customer,project_descr, established_date, project_status) VALUES ('$project_name','$project_code','$project_customer','$project_descr','$curr_date','$project_status')";
                    //echo "<span style='position:absolute; top:0px; left:0px'>$sql</span>";
                    $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
                    header('Location: index.php');
            } 
			
			if (isset($_POST['new_customer'])) {//idem zadat noveho zakaznika
				
				header('Location: project_customer_add.php');

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
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    </head>
<body>
		<div id="main">
			<div id="header">miniwrike - add project<div class="logged_user"><div class="circle"></div><div class="user">Tomas Misura</div></div></div>
            
			<!-- <div class="logged_user">Tomas Misura</div> -->
			<!-- <div class="circle"></div> -->
			<div id="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>                       
                </ul>
            </div>
		        	

			<div id="middle"> <!-- list of projects -->
                         <!-- project managament - adding of a new project -->
					<!---<span style="position:relative; float: left; margin-left: 5px; margin-top: 5px; font-size: 16px; font-weight: bold;">Add new project</span>	-->
					<div id="project_management_wrap">
						
						 <form accept-charset="utf-8" method="post" action="project_add.php">
						  <table id="project-management">
							<tr>
								<td>Project name:</td><td><input type="text" name="project_name" id="project_name"/></td> <!-- meno projektu -->
							</tr>
							<tr>
								<td>Project code:</td><td><input type="text" name="project_code" id="project_code"/></td> <!-- kod projectu -->
							</tr>
							
							<tr>
								<td>Customer:</td><td><select name="project_customer"> <!--meno zakaznika -->
									<?php
											$sql="SELECT id, customer_name from project_customers";
											$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
											while ($row = mysql_fetch_array($result)) {
												$id=$row['id'];
												$customer_name=$row['customer_name'];
												echo "<option value='$id'>$customer_name</option>";
											}
									
								?>
								<select><button type="submit" name="new_customer">+</button></td>
								
							</tr>
							
							
							<tr>
								<td>Description:</td><td><textarea name="project_description" id="project_description"></textarea></td><!-- popis projectu -->
							</tr>
							
							
							<tr>
								<td>Status:</td><td><select name="project_status">
														<option value="New">New</option>
														<option value="Pending">Pending</option>
														<option value="finished">Finished</option>
														<option value="Canceled">Canceled</option>
														<option value="Postponed">Postponed</option>
														</select></td>
							</tr>
							
							<tr>
								<td><button type="submit" name="new_project">New project</button></td>
							</tr>
						</table>
					  </form>                                          
					</div> <!-- project mgmt -->
					
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
<?php ob_start();?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>


<?php
            if (isset($_POST['new_project'])) {

                    $project_name=$_POST['project_name'];
                    $project_code=$_POST['project_code'];
                    $project_descr=$_POST['project_description'];
                    $project_status=$_POST['project_status'];
                    /*if ($project_name=='All') { //ak si zvolim vsetky projekty a
                              echo "<script language=javascript>alert('Zvol si spravny projekt')</script>";
                    } else {*/

                    
                    //$curr_date=(date('Y-m-d'));
                    //$date=strtotime(date('Y-m-d', strtotime($curr_date)) . " +5 day");
                    //$end_date= date('Y-m-d', $date);
                
                    $sql = "INSERT INTO projects (project_name,project_code, project_descr, established_date, project_status) VALUES ('$project_name','$project_code', '$project_descr',now(),'$project_status')";
                    //echo "<span style='position:absolute; top:0px; left:0px'>$sql</span>";
                    $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
                    header('Location: projects.php');
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
    <script type="text/javascript">
function show_project_tasks(str)
{
if (str=="")
  {
  document.getElementById("tasks").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("tasks").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","project_tasks.php?q="+str,true);
xmlhttp.send();
}
</script>
</head>
<body>
		<div id="main">
			<div id="header"><div style="position:relative; top:30%;">miniwrike - simple project manager tool</div></div>
            <div id="menu">
                <ul>
                    <li><a href=".">Home</a></li>    
                    <li><a href="projects.php">Project management</a></li>
                </ul>
            </div>
		        	<div id="middle"> <!-- list of projects -->
               <div> <!-- list of projects -->
                <table id="projects">
                 <th>Project name</th><th>Project description</th><th># of tasks</th><th>Established</th><th>Status</th>
                 
                    <?php
                    $sql="SELECT DISTINCT * FROM projects ORDER BY id DESC";
                    $result = mysql_query($sql);
                    
                    $alternate = "2"; 
                    
                    while ($row = mysql_fetch_array($result)) {
                    		$id=$row['id'];
                            $project_name=$row['project_name'];
                            $project_code = $row['project_code'];
                            $project_descr=$row['project_descr'];
                            $established_date=$row['established_date'];
                            $project_status=$row['project_status'];
                    		
                            if ($alternate == "1") { 
                    			$color = "even"; 
                    			$alternate = "2"; 
                    		} 
                    		else { 
                    			$color = "odd"; 
                    			$alternate = "1";
                    		}
                             
                          $NrofTask =  NrofTasks($project_code);

                            echo "<tr class='$color' id='".$id."'>";	
        	              	   echo "<td>$project_name</td>";
                                echo "<td>$project_descr</td>";
						echo "<td><a href='index.php?project=$project_name'><span class='grey-badge'>$NrofTask</span></a></td>";
                                echo "<td>$established_date</td>";
                                echo "<td>$project_status</td>";
                                
        	               echo "</tr>";
                        }   
                        ?>
                   </table> 
                </div> <!-- list of projects -->  
                <div style="clear:both;"></div> 
                             
            </div> <!-- middle -->
            
            <div style="clear:both;"></div>
			<div id="footer"></div>
		</div>
</body>
</html>
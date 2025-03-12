<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="css/project.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic'
        rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="js/clock.js" defer></script>    
    <script type="text/javascript" src="js/project.js?v<?php echo time(); ?>" defer></script>    
    <link rel='shortcut icon' href='project.ico'>
    <title>Minirike</title>
</head>
<body>

		<?php

			$project_id = $_SESSION['project_id'];
			//echo $_SESSION['project_id'];
		
		?>


    <div id="main">
        <!-- main wrapper -->
        <!-- header -->

        <?php include "include/header.php";
			include "include/menu.php";
         ?>
        <!-- header -->
        <!--- middle section -->

        <div id="middle">
            <div class="project_details">
		        <h3>Project details</h3>
                  
              <?php
				$get_project_details = "SELECT *,ABS(DATEDIFF(established_date, now())) AS duration from projects WHERE id=$project_id";
				
				$result = mysqli_query($db, $get_project_details) or die("MySQL ERROR: " . mysqli_error());
				while ($row = mysqli_fetch_array($result)) {
					$id = $row['id'];
					$project_code = $row['project_code'];
					$project_name = $row['project_name'];
					$project_description = $row['project_descr'];
					$project_status = $row['project_status'];
					$project_created = $row['established_date'];
					$customer_id = $row['project_customer'];
					$customer_name = GetCustomerName($customer_id);
					$duration = $row['duration'];

					//echo "<input type='hidden' name='project_id' value='$project_id'>";

					echo GetCustomers($customer_id);

					echo "<input type='text' name='project_name' value='$project_name' title='project name' placeholder='Project name ...'>";
					echo "<input type='text' name='project_code' value='$project_code'  title='project code' placeholder='project code ...'>";
					echo "<textarea name='project_description'  title='project description'  placeholder='Project description...' onload='textAreaAdjust(this)'>$project_description</textarea>";
					//echo "<input type='text' name='project_customer' value='$customer_name' placeholder='customer ...'>";


					echo "<div class='project_managers_wrap'>";
					echo "<div class='pm_wrap_header'><h3>Project managers: </h3><button type='button' class='button' title='Add new project manager if requited'><i class='fa fa-plus'></i></button></div>";			
					echo "<div class='project_managers'>";
						$get_project_managers = "SELECT * from project_managers WHERE project_id=$project_id";
						$result_managers = mysqli_query($db, $get_project_managers) or die(mysqli_error($db));
						while($row_mmanagers = mysqli_fetch_array($result_managers)){
							$manager_id = $row_mmanagers['user_id'];

						echo "<div class='assigned_person_badge' user-id=$manager_id>" .GetUserNameById($manager_id)."<button type='button' class='button'><i class='fa fa-times'></i></button></div>";
					}	
					echo "</div>"; //project_managers	
					echo "</div>"; //project managers wrap

					echo "<select name='project_status'>";

					if ($project_status == 'new') {
						$status_name = "New";
					}
					if ($project_status == 'ongoing') {
						$status_name = "In progress";
					}
					if ($project_status == 'pending') {
						$status_name = "Pending";
					}
					if ($project_status == 'cancelled') {
						$status_name = "Cancelled";
					}
					if ($project_status == 'finished') {
						$status_name = "Finished";
					}

					//echo $status_name;
					echo "<option value='$project_status' selected='selected'>$project_status</option>
				          <option value='new'>New</option>
				          <option value='ongoing'>In progress</option>
				          <option value='pending'>Pending</option>
				          <option value='cancelled'>Cancelled</option>
				          <option value='finished'>Finished</option>
				    </select>";

				     echo "<span class='project_created'>Project created:$project_created</span>";
					//echo "<button type='submit' name='update_basic_info' class='blue-badge-large'>Update</button>";
					
				}
				?>

       			</div><!-- project details -->

            <div id="project_details_dashboard">
                <!--project_details_dashboard -->

                	<h3>Dashboard</h3>
                	<div class="dashboard">
		                <div class="info_box">
		                    <span class="info_box_title">Status:</span>
		                    <span class="info_box_value"><?php echo $project_status; ?></span>
		                </div>
		                <div class="info_box">
		                    <span class="info_box_title">Total tasks</span>
		                    <span class="info_box_value"><?php echo NrofTasks($project_id); ?></span>
		                </div>
		                <div class="info_box">
		                    <span class="info_box_title">Total subtasks</span>
		                    <span class="info_box_value"><?php echo NrofSubTasks($project_id); ?></span>
		                </div>
		                <div class="info_box">
		                    <span class="info_box_title">Total comments</span>
		                    <span class="info_box_value"><?php echo NrofComments($project_id); ?></span>
		                </div>
		                <div class="info_box">
		                    <span class="info_box_title">Total people: </span>
		                    <span class="info_box_value"><?php echo NrofAssignedppl($project_id); ?></span>
		                </div>
		                <div class="info_box">
		                    <span class="info_box_title">Total meetings:</span>
		                    <span class="info_box_value"><?php echo NrofProjMeetings($project_id); ?></span>
		                </div>
		                <div class="info_box">
		                    <span class="info_box_title">Number of docs</span>
		                    <span class="info_box_value"><?php echo NumberofDocs($project_id); ?></span>
		                </div>
		                 <div class="info_box">
		                    <span class="info_box_title">Total meetings</span>
		                    <span class="info_box_value"><?php echo NumberofMeetings($project_id) ?></span>
		                </div>	

		                <div class="info_box">
		                    <span class="info_box_title">Total duration</span>
		                    <span class="info_box_value"><?php echo $duration; ?></span>
		                </div>
	                </div>


            </div>
          
            <div class="project_assigned_people_badges">
            	<?php
            			$sql = "SELECT *,ABS(DATEDIFF(assigned_date, now())) as duration from project_assigned_people WHERE project_id=$project_id"; //get list of ppl assigned to project including his duration
							$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
							$numrows = mysqli_num_rows($result);
							if ($numrows == 0) {
								echo "<span>No ppl assigned to this project</span>";} else {
								while ($row = mysqli_fetch_array($result)) {
								    $id = htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8');
								    $user_id = htmlspecialchars($row['user_id'], ENT_QUOTES, 'UTF-8');
								    $user_name = htmlspecialchars(GetUserNameById($user_id), ENT_QUOTES, 'UTF-8');

								    $assigned_date = htmlspecialchars($row['assigned_date'], ENT_QUOTES, 'UTF-8');
								    $image = "img/non-avatar_32.jpg"; // This should ideally be dynamic
								    $duration = htmlspecialchars($row['duration'], ENT_QUOTES, 'UTF-8');

								    echo "<div class='assigned_person_badge' user-id=$id>" .GetUserNameById($id)."<button type='button' class='button'><i class='fa fa-times'></i></button></div>";
								}
							}
					?>
            </div>


            <div class="assigned_people_list">
                <!-- list of assigned ppl to project, add ppl, created new ppl -->
                <header><h3> Assigned people to the project </h3><input type="text" placeholder="search people here..." autocomplete="off"><button type='button' id='reload_people' class='button'><i class='fa fa-refresh'></i></button><button type='button' id='add_new_person' class='button'><i class='fa fa-plus'></i></button></header>
                
                <div class="project_assigned_people_wrap">
	                <?php
	                		$itemsPerPage = 10;

             				$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
             				$offset = ($current_page - 1) * $itemsPerPage;

						$get_assigned_people_list = "SELECT *,ABS(DATEDIFF(assigned_date, now())) as duration from project_assigned_people WHERE project_id=$project_id ORDER BY duration DESC  LIMIT $itemsPerPage OFFSET $offset"; //get list of ppl assigned to project including his duration
						$result = mysqli_query($db, $get_assigned_people_list) or die(mysqli_error($db));
						$numrows = mysqli_num_rows($result);
						if ($numrows == 0) {
							echo "<span>No ppl assigned to this project</span>";} else {
							//echo "<ul>";
							while ($row = mysqli_fetch_array($result)) {
								$id = $row['id'];
								$user_id = $row['user_id'];
								$user_name = GetUserNameById($user_id);
								$assigned_date = $row['assigned_date'];
								$image = "img/non-avatar_32.jpg";
								$duration = $row['duration'];

								    $project_role = $row['project_role'];
								    if ($project_role != 0) {
								        $project_role = htmlspecialchars(GetRoleName($project_role), ENT_QUOTES, 'UTF-8');
								    } else {
								        $project_role = "<button class='button' name='add_role'><i class='fa fa-plus'></i> Add role</button>";
								    }

								    $project_technology = $row['project_technology'];
								    if ($project_technology != 0) {
								        $project_technology = htmlspecialchars(GetTechName($project_technology), ENT_QUOTES, 'UTF-8');
								    } else {
								        $project_technology = "<button class='button' name='add_technology'><i class='fa fa-plus'></i> Add technology</button>";
								    }

								//echo "<li>";
									echo "<div class='assigned_person' user-id=$user_id>";
										echo "<div class='person_image'><img src='" . $image . "' alt='" . $user_id . "'></div>";
										echo "<div class='assigned_person_details'>
											<div class='person_name'>$user_name</div>
											<div class='project_role'>$project_role</div>
											<div class='project_technology'>$project_technology</div>
											<span class='assigned_date'>$assigned_date</span>
										    <span class='assigned_duration'>$duration days</span>";
											
											echo "<button type='button' class='button' name='remove_from_project' alt='Remove user from the project'><i class='fa fa-times'></i></button>";
										echo "</div>"; //assigned person details
									echo "</div>"; //assigned person
								//echo "</li>";

							}
						}
						//echo "</ul>";
					?>
					</div>
					<div class="project_assigned_people_status_bar">
						<?php
			                // Calculate the total number of pages
			                $sql = "SELECT COUNT(*) as total FROM project_assigned_people where project_id=$project_id";
			                $result=mysqli_query($db, $sql);
			                $row = mysqli_fetch_array($result);
			                $totalItems = $row['total'];
			                $totalPages = ceil($totalItems / $itemsPerPage);

			                // Display pagination links
			                echo '<div class="pagination">';
			                for ($i = 1; $i <= $totalPages; $i++) {
			                    //echo '<a href="?page=' . $i . '"">' . $i . '</a>';
			                    //echo '<a href="?project_id='.$project_id.'&page=' . $i . '"">' . $i . '</a>';
			                    echo "<button class='button'>" . $i . "</button>";
			                    //echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
			                }
			                echo '</div>';
			             ?>
					</div><!-- status bar -->
				
				</div><!-- list of assigned ppl to project, add ppl, created new ppl -->

				
				<div class="project_roles">
					<h3>Desired project roles</h3>
					<div class="assigned_roles">
						<?php
							$get_project_roles = "SELECT par.role_id, pr.role_name from project_roles pr, project_assigned_roles par WHERE project_id=$project_id and pr.role_id = par.role_id";
							 $result = mysqli_query($db, $get_project_roles) or die("MySQL ERROR: " . mysqli_error($db));
							 	while ($row = mysqli_fetch_array($result)){
							 			$role_name = $row['role_name'];

							 			echo "<button class='button'>$role_name</button>";
							 	}

						?>	
						<button class='button' id='add_new_role'><i class="fa fa-plus"></i></button>	
					</div>
				</div>

			    
                 <div class="project_technologies">
                 	<h3>Desired project technologies</h3>
                 	<div class="assigned_techs">
                 	<?php
                 			$get_assigned_tech = "SELECT pt.tech_id, pt.technology_name, pat.tech_id from project_assigned_technologies pat, project_technologies pt WHERE project_id=$project_id and pt.tech_id = pat.tech_id";
                 			$result = mysqli_query($db, $get_assigned_tech) or die("MySQL ERROR: " . mysqli_error($db));
                 			while ($row = mysqli_fetch_array($result)) {

                 				$tech_name = $row['technology_name'];

                 				echo "<button class='button'>$tech_name</button>";

                 			}

                 	?>
                 		<button class='button' id="add_new_technology"><i class="fa fa-plus"></i></button>
                 	</div>
                 </div>
                 
				</div><!-- middle section -->

				        <?php include "include/footer.php";?>

				</div>

				    <dialog id="assign_person">
				             <div class="dialog_header"><span>Assign person:</span><button type='button' name="close" class='button'><i class='fa fa-times'></i></button></div>
				           <div class="dialog_wrap">  
				            <input type="hidden" name="project_id" value="<?php echo $project_id; ?> ">
						        <select name="user_id">
						            <option value="0">----------assign person to project ---------</option>
						            <?php
										$sql = "SELECT * from project_users WHERE user_id NOT IN (SELECT user_id from project_assigned_people WHERE project_id=$project_id)";
										//echo $sql;
										$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
										while ($row = mysqli_fetch_array($result)) {
											$full_name = $row['full_name'];
											$user_id = $row['user_id'];
											echo "<option value=$user_id>$full_name</option>";
										}
										?>
						        </select>
						        <button type="submit" title="New user" name="create_person" alt="Create new project user" class="button"><i class="fa fa-plus"></i></button>
						    </div><!-- dialog wrap-->
					        <div class="dialog_footer">
						        	
						         </div>  
				    </dialog>
				    
				    <dialog id="assign_role">
				    		 <div class="dialog_header"><span>Assign role:</span><button type='button' name="close" class='button'><i class='fa fa-times'></i></button></div>
                           <div class="dialog_wrap">
                            <select name="project_role"> 
                            <option value="0">----------assign role(s) to project ---------</option>  
                            <?php
                                $get_roles = "SELECT * from project_roles";
                                $result = mysqli_query($db, $get_roles) or die("MySQL ERROR: " . mysqli_error($db));
                                            while ($row = mysqli_fetch_array($result)) {
                                                $role_id = $row['role_id'];
                                                $role_name= $row['role_name'];
                               echo "<option value='$role_id'>$role_name</option>";           
                               }             
                            ?>
                            </select>
                            <button type="button" class="button" name='add_role' title="add new role"><i class='fa fa-plus'></i></button> 
                          </div>  
                          <div class="dialog_footer"></div>
                    </dialog>

				    <dialog id="assign_technology">
				    	 <div class="dialog_header"><span>Assign technology:</span><button type='button' name="close" class='button'><i class='fa fa-times'></i></button></div>
				    	 <div class="dialog_wrap">
                            <select name="project_technologies"> 
                        
                            <?php
                                $get_tech = "SELECT * from project_technologies";
                                $result = mysqli_query($db, $get_tech) or die("MySQL ERROR: " . mysqli_error($db));
                                            while ($row = mysqli_fetch_array($result)) {
                                                $tech_id = $row['tech_id'];
                                                $tech_name= $row['technology_name'];
                               echo "<option value='$tech_id'>$tech_name</option>";           
                               }             
                            ?>
                             </select>
                             <button type="button" class="button" name='add_tech' title="add new technology"><i class='fa fa-plus'></i></button>
                             
                        </div><!-- project_roles --> 
                        <div class="dialog_footer"></div>
				    </dialog>
				    
				    <dialog id="project_managers_popup">
				    	<div class="dialog_header"><button type='button' name="close" class='button'><i class='fa fa-times'></i></button></div>
				    	<div class="assigned_people_pm_popup"></div>
				    	<div class="assign_new_pm_wrap">
				    		<div class="alpha_list">
				    			<?php
				    			 foreach (range('A', 'Z') as $char) {
                          		 echo "<button type='button' class='button'>$char</button>";
		                		  }
        				        ?>
				    		</div>
				    		<div class="find_user_wrap">
				    			<div class="find_use_search_bar"><input type="text" value="" placeholder="Search people here..."></div>
				    			<div class="found_people_list"></div>
				    		</div>
				    	</div>
				    	
				    </dialog>

				    <dialog id="add_change_meeting_location"></dialog>

				    <dialog id="add_person_project_role"></dialog>

				    <dialog id="add_person_project_technology"></dialog>
</body>
						
</html>
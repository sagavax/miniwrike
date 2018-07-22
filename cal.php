<?php

include("include/dbconnect.php");

function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);

    while( $current <= $last ) {

        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }

    return $dates;
}


function createDateRangeArray($strDateFrom,$strDateTo) {
  // takes two dates formatted as YYYY-MM-DD and creates an
  // inclusive array of the dates between the from and to dates.

  // could test validity of dates here but I'm already doing
  // that in the main script

  $aryRange=array();

  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

  if ($iDateTo>=$iDateFrom) {
    array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

    while ($iDateFrom<$iDateTo) {
      $iDateFrom+=86400; // add 24 hours
      array_push($aryRange,date('Y-m-d',$iDateFrom));
    }
  }
  return $aryRange;
}

/*DROP TABLE IF EXISTS `project_team_av_calendar`;
CREATE TABLE `project_team_av_calendar` (
  `id` int(11) NOT NULL,
  `project_id` int(3) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `avail_flag` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'V=Vacation, A=Available,T=Training, S=Sick, BT=Business Trip etc',
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `project_team_av_calendar_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `project_team_av_calendar_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `project_assigned_people` (`id`) */
//$start_date='2013-11-01';


//$strDateFrom='2007-02-15';
$strDateFrom='2013-11-01';
$strDateTo='2015-06-30';
$aryDates=createDateRangeArray($strDateFrom,$strDateTo);
//print_r($aryDates);

foreach($aryDates as $date){
	//echo "$date<br>";2,7,3
	//$sql="INSERT INTO project_team_av_calendar (project_id,date,user_id,avail_flag) VALUES (12,'$date',1,'A')";
	//$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
	//$sql="INSERT INTO project_team_av_calendar (project_id,date,user_id,avail_flag) VALUES (12,'$date',7,'A')";
	//$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
	/*$sql="INSERT INTO project_team_av_calendar (project_id,date,user_id,avail_flag) VALUES (12,'$date',7,'A')";
	$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error()); */
	$sql="INSERT INTO project_team_av_calendar (project_id,date,user_id,avail_flag) VALUES (12,'$date',2,'A')";
	$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
	$sql="INSERT INTO project_team_av_calendar (project_id,date,user_id,avail_flag) VALUES (12,'$date',3,'A')";
	$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
}

echo "done!";



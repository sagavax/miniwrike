<script type="text/javascript">
        function startTime()
        {
        var today=new Date();
        var h=today.getHours();
        var m=today.getMinutes();
        var s=today.getSeconds();

        // add a zero in front of numbers<10
        m=checkTime(m);
        s=checkTime(s);
        if(h<12)
        document.getElementById('clock').innerHTML=h+":"+m+":"+s + " AM";
        else
        document.getElementById('clock').innerHTML=h+":"+m+":"+s + " PM";

        t=setTimeout('startTime()',500);
        }

        function checkTime(i)
        {
        if (i<10)
          {
          i="0" + i;
          }
        return i;
        }
    </script>
<div id="header">
	<div class="header_title">miniwrike</div>
	<div class="logged_user">

		<ul class="header_nav_bar">
			<li>
				<div class="user_picture">
				<?php
$image = "img/users_pics/" . $_SESSION['user_id'] . "/user_" . $_SESSION['user_id'] . "_32x32.jpg";
echo "<img src='" . $image . "' alt='" . $_SESSION['user_id'] . "' class='circle'>";
?>
				</div>
			</li>

			<li><a href="project_user_profile.php?user_id=<?php echo $_SESSION['user_id'] ?>"><?php echo GetUserNameByid($_SESSION['user_id']) ?></a></li>
			<li class="">
				<?php
$msg_count = NrofMessages($_SESSION['user_id']);
echo "<a href='project_inbox.php?user_id=1' class='small-blue-badge'>$msg_count</a>";
?>
			</li>
			<li>
				<div id="clock"><script type="text/javascript">startTime();</script></div>
			</li>
		</ul>
		 <!-- envelope -->
	</div><!--logger_user -->
</div><!-- header -->
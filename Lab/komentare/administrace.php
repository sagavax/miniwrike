<html>
<head>
<meta charset="utf-8">
</head>

<body>
<?php
$show = $_POST['show'];
$pass = $_POST['pass'];

$password = "neco"; //tajné heslo


if ($show != "1"): ?>
	<form action="" method="post">
  
  <input type="hidden" value="1" name="show">
	<label>Heslo: <label><input type="password" name="pass" />
	<input type="submit" value="OK" />

	</form>
<?php endif; ?>

<?php if ($show == "1"): ?>

	<?php if ($pass == $password): ?>
		
     <a href="asdfsfgdghefhjgdhewgfcdhgewrhgfchjfvgfdgvfhjgfjkdshfrjgfzewghewgefhj.php">Klikni sem pro upravování souboru</a>.
	<?php endif; ?>
<?php if ($pass != $password) echo "<p>Špatné heslo. Zkuste ho zadat znovu, nebo mě kontaktujte.</p>"; ?>
<?php endif; ?>
</body>
</html>
<html>
<head>
<title>Ahoj!</title>
<meta charset="utf-8">
</head>
<body>
<?php 
if($_POST['Submit']){ 
$open = fopen("data.txt","w+"); 
$text = $_POST['update']; 
fwrite($open, $text); 
fclose($open); 
echo "Soubor aktualizován!<br />";  
echo "Soubor:<br />"; 
$file = file("data.txt"); 
foreach($file as $text) { 
echo $text."<br />"; 
} 
}else{ 
$file = file("data.txt"); 
echo "<form action=\"".$PHP_SELF."\" method=\"post\">"; 
echo "<textarea Name=\"update\" cols=\"50\" rows=\"10\">"; 
foreach($file as $text) { 
echo $text; 
}  
echo "</textarea>"; 
echo "<input name=\"Submit\" type=\"submit\" value=\"Aktualizovat\" />\n 
</form>"; 
} 
?>
<a href="index.php">Aktualizovat stránku</a>
</body>
<html>
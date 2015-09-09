<html>
<head>
<meta charset="utf-8">
</head>
<body>
  <form action="odesli-komentar.php">
Vaše jméno: <br><input name="vase_jmeno"><br>     
Váš mail (veřejně): <br><input name="mail_odesilatele"><br>
Předmět: <br><input name="predmet" value=""><br>
Zpráva: <br><textarea name="zprava" cols="30" rows="10"></textarea><br>
<input type=submit value="Odeslat">
<a href="administrace.php">Administrace</a>
<br><br>
</body>
</html>
<h5>Tento komentářový systém vytvořil: Tomáš Jareš :)</h5>
<?php
include ('data.txt');
?>  
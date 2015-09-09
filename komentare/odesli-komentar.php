<?php
$a = htmlspecialchars($_GET['vase_jmeno']);
$b = htmlspecialchars($_GET['mail_odesilatele']);
$c = htmlspecialchars($_GET['predmet']);
$d = htmlspecialchars($_GET['zprava']);
 
$data = file_get_contents('data.txt');
file_put_contents('data.txt', 'Jméno: '.$a.'<br>Mail:'.$b.'<br>Předmět:'.$c.'<br>Zpráva:'.$d.'<hr>'.$data);
?>
Vas komentar byl uspesne odeslan na server!
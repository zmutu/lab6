<?php
if(isset($_GET['mail'])){
		$mail = $_GET['mail'];
		$m = '?mail='.$mail;
}
else{$m='';}

echo("<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<style>
p {text-align:center;}
#msg {position:fixed;top:40;left:700;color:#dd5500;font-size:1.4em;font-weight:bold;}
</style>
</head>
<body>
<p style='font-size:1.5em;'>Cesar Mutuberria</p>
<p>Software Ingeniaritza</p>
<p><img src='../images/cest_moi.png'/><p>
<p>Bilbo</p>
<a href='layout.php".$m."'>
<img src='../images/gezia.png'/></a>
</body>
</html>");
?>
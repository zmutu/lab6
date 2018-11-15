<?php
if(isset($_GET['mail'])){$mail = $_GET['mail'];}
else{echo('');}

include('dbConfig.php');
//kode hau 20 segunduoro exekutatzen da alako
//batean konexioa edo kontsulta egitean errorerik 
//gertatzen bada, auntzaren gauerdiko eztula

$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db);
//erabiltzailearen erregistroak
$sql = 'Select count(id) as id from questions where mail = "'.$mail.'"';
$nereak = $konexioa -> query($sql);
$n = $nereak -> fetch_array(MYSQLI_ASSOC);

//erregistro guztiak
$sql = 'Select count(id) as id from questions';
$guztiak = $konexioa -> query($sql);
$g = $guztiak -> fetch_array(MYSQLI_ASSOC);
$erabiltzailearenak = $n['id'];
$denak = $g['id'];

$nereak -> free_result();
$konexioa -> close();
echo($erabiltzailearenak.'/'.$denak);
?>
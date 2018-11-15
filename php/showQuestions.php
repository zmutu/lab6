<?php
if(isset($_GET['mail'])){$mail = $_GET['mail'];}
else{header("location:layout.php");}
//datu-basearekin konexioa egin
include('dbConfig.php');

//DBKS-rekin konexioa egin eta Quiz datu-basea ireki
if(!$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db)){
	$msg = 'Errorea datu-basearekin konexioa egiterakoan';
	$em = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?> <mezua>'.$msg.'</mezua>');
	echo($em -> asXML());
	exit();
}

$sql = "Select mail, galdera, erantzun_zuzena from questions where mail = '".$mail."'";

//sql kontsulta exekutatu
if(!($emaitza = $konexioa -> query($sql))){
	$msg = 'Kontsulta ez da behar den bezala exekutau';
	$em = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?> <mezua>'.$msg.'</mezua>');
	echo($em -> asXML());
	exit();
}

$zutabe = $emaitza -> field_count;

if($emaitza -> num_rows == 0){
	//erabiltzaileak ez du galderarik sortu
	echo($mail.' erabiltzaileak ez du galderarik gorde');
	exit();
}
echo('<table style = "border:solid 1px #5555AA;"><tr>');

//taularen goiburuak (marrazkia eta marrazki mota zutabeak ezik)
$htm = "<style>table{border:3px solid #000055;margin:2px auto;}th,td{border:1px dotted #0000AA;}</style><table><tr><th scope = 'row'>Erabiltzailea</th><th scope = 'row'>Galdera</th><th scope = 'row'>Erantzun Zuzena</th></tr>";

//taularen erregistroak (marrazkirik gabe)
for($k = 0; $k < $emaitza -> num_rows; $k++){
	$lerro = $emaitza -> fetch_array(MYSQLI_NUM);
	$htm = $htm."<tr>";
	for($j = 0; $j < $emaitza -> field_count; $j++){
	    $htm = $htm."<td>".$lerro[$j]."</td>";
	}
	$htm = $htm."</tr>";
}
$htm = $htm."</table>";

$emaitza -> free_result();
$konexioa -> close();
echo($htm);
?>
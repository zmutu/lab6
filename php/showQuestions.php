<?php
//datu-basearekin konexioa egin
include('dbConfig.php');

//DBKS-rekin konexioa egin eta Quiz datu-basea ireki
if(!$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db)){
	header("location:mezua.php?goiburu=Errorea!!&gorputza=ez da konexioa lortu<br/>".$konexioa -> error."&auk=<a href = 'addQuestion.html'>Idatzi beste galdera bat</a>");
}

$sql = "Select id, mail, galdera, erantzun_zuzena, erantzun_okerra_1, erantzun_okerra_2, erantzun_okerra_3, zailtasuna, gaia from questions";

//sql kontsulta exekutatu
if(!($emaitza = $konexioa -> query($sql))){
	header("location:mezua.php?goiburu=Errorea!!&gorputza=".$konexioa->error."&auk=-");
}
echo('<style>td{border:dotted 1px #5555AA;}th{border:solid 1px #5555AA;}</style>');

$zutabe = $emaitza -> field_count;

echo('<table style = "border:solid 1px #5555AA;"><tr>');

//taularen goiburuak (marrazkia eta marrazki mota zutabeak ezik)
for($i = 0;$i < $zutabe; $i++){
    $emaitza -> field_seek($i);
    $attr = $emaitza -> fetch_field();
    echo("<th scope = 'row'>".$attr -> name."</th>");
}
echo('</tr>');

//taularen erregistroak (marrazkirik gabe)
for($k = 0; $k < $emaitza -> num_rows; $k++){
	$lerro = $emaitza -> fetch_array(MYSQLI_NUM);
	echo('<tr>');
	for($j = 0;$j<$zutabe;$j++){
	    echo('<td>'.$lerro[$j].'</td>');
	}
	echo('</tr>');
}
echo('</table>');

$emaitza -> free_result();
$konexioa -> close();

echo('<a href = "../layout.html">Orri nagusia</a>');
?>
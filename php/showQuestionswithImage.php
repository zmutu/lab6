<?php
if(isset($_GET['mail'])){$mail = $_GET['mail'];}
else{header("location:layout.php");}

include('dbConfig.php');

//datu-basearekin konexioa egin
$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db);

if($konexioa -> connect_error){
	$msg = 'errorea konexioa ezartzean';
	header("location:addQuestion_HTML5.php?mail=".$mail);
}
else{$mezu='konexioa gauzatu da';}

//argazkia jaso
$em = $konexioa -> query("Select argazkia, mota from users where eposta = '".$mail."'")or trigger_error(mysql_error());;
$argazkia = $em -> fetch_array(MYSQLI_ASSOC);

if($argazkia["mota"]!='-'){
		$img = "data:".$argazkia["mota"].";base64,".base64_encode($argazkia["argazkia"]);
}
else{$img = '';}

echo("<img src='".$img."' width='50'/>");

$emaitza = $konexioa -> query("Select * From questions")or trigger_error(mysql_error());

echo('<style>td{border-bottom:dotted 1px #5555AA;border-top:dotted 1px #5555AA;}th{border:solid 1px #5555AA;}</style>');
$zutabe = $emaitza -> field_count;
$zutabe -= 1;	//azkeneko zutabea marrazkiaren mota da, datua erabili behar da baina ez da erakutsi behar

$goiburuak = array();

echo('<table style="border:solid 1px #5555AA;"><tr>');

//taularen goiburuak
for($i=0;$i<$zutabe;$i++){
    $emaitza -> field_seek($i);
    $attr = $emaitza -> fetch_field();
    echo("<th scope='row'>".$attr -> name."</th>");
}
echo('</tr>');

//taularen erregistroak
while($lerro = $emaitza -> fetch_array(MYSQLI_ASSOC)){
	//marrazkia baldin badago tratatu
	if($lerro["mota"]!='-'){
		$img = '<img src = "data:'.$lerro["mota"].';base64,'.base64_encode($lerro["marrazkia"]).'" alt = "marrazkia" width="100"/>';
	}
	else{$img = '-';}
	echo('<tr>');
	echo('<td>'.$lerro["id"].'</td><td>'.$lerro["mail"].'</td><td>'.$lerro["galdera"].'</td><td>'.$lerro["erantzun_zuzena"].'</td><td>'.$lerro["erantzun_okerra_1"].'</td><td>'.$lerro["erantzun_okerra_2"].'</td><td>'.$lerro["erantzun_okerra_3"].'</td><td>'.$lerro["zailtasuna"].'</td><td>'.$lerro["gaia"].'</td><td>'.$img.'</td>');

	echo('</tr>');
}
echo('</table>');

$emaitza -> free_result();
$konexioa -> close();
echo("<a href = 'layout.php?mail=".$mail."'>Orri nagusia</a>");
?>
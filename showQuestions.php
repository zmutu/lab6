<?php
//datu-basearekin konexioa egin
//if(!$konexioa=new mysqli("127.0.0.1","root","5artu")){
if(!$konexioa=new mysqli("localhost","id7270487_zmutu","60ra3u5kalH3rr1a")){
	header("location:mezua.php?goiburu=Errorea!!&gorputza=".$konexioa->error."&auk=<a href='addQuestion.html'>Idatzi beste galdera bat</a>");
}
//datu-basea aukeratu
//if(!($konexioa->select_db('quiz'))){
if(!($konexioa->select_db('id7270487_quiz'))){
	header("location:mezua.php?goiburu=Errorea!!&gorputza=".$konexioa->error."&auk=+");
}

$sql="Select * from questions";

//sql kontsulta exekutatu
if(!($emaitza=$konexioa->query($sql))){
	header("location:mezua.php?goiburu=Errorea!!&gorputza=".$konexioa->error."&auk=-");
}
echo('<style>td{border:dotted 1px #5555AA;}</style>');
$zutabe = $emaitza->field_count;
echo('<table style="border:solid 1px #5555AA;"><tr>');
//taularen goiburuak
for($i=0;$i<$zutabe;$i++){
    $emaitza->field_seek($i);
    $attr=$emaitza->fetch_field();
    echo("<th scope='row'>".$attr->name."</th>");
}
echo('</tr>');
//taularen erregistroak
for($k=0;$k<$emaitza->num_rows;$k++){
	$lerro = $emaitza->fetch_array(MYSQLI_NUM);
	echo('<tr>');
	for($j=0;$j<$zutabe;$j++){
	    echo('<td>'.$lerro[$j].'</td>');
	}
	echo('</tr>');
}
echo('</table>');

$emaitza->free_result();
$konexioa->close();
echo('<a href="layout.html">Galdera berri bat idatzi</a>');
?>
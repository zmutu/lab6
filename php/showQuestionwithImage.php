<?php
$img_nm = '';	//marrazki izena gordetzeko
$img_tp = '';	//marrazki mota gordetzeko

//datu guztiak jaso
if(isset($_POST['mail'])){$mail = $_POST['mail'];}
if(isset($_POST['galdera'])){$galdera = $_POST['galdera'];}
if(isset($_POST['zuzena'])){$zuzena = $_POST['zuzena'];}
if(isset($_POST['erantzunokerra1'])){$erantzunokerra1 = $_POST['erantzunokerra1'];}
if(isset($_POST['erantzunokerra2'])){$erantzunokerra2 = $_POST['erantzunokerra2'];}
if(isset($_POST['erantzunokerra3'])){$erantzunokerra3 = $_POST['erantzunokerra3'];}
if(isset($_POST['zailtasuna'])){$zailtasuna = $_POST['zailtasuna'];}
if(isset($_POST['gaia'])){$gaia = $_POST['gaia'];}

//fitxategia jaso den aztertu
if (!isset($_FILES["html_file"]) || $_FILES["html_file"]["error"] > 0){
	header("location:mezua.php?goiburu=Errorea!!&gorputza=Ez dira datu guztiak jaso&auk=<a href = 'addQuestion.html'>Idatzi beste galdera bat</a>");
}
else{
	$img = $_FILES['html_file']["tmp_name"];	//fitxategiaren edukia
	$img_nm = $_FILES["html_file"]["name"];		//fitxategiaren izena
	$img_tp = $_FILES["html_file"]["type"];		//fitxategi mota
	$neurri = $_FILES['html_file']['size'];		//fitxategiaren neurriak
}

//daturen bat falta den aztertu
if($mail == ''||$galdera == ''||$zuzena == ''||$erantzunokerra1 == ''||$erantzunokerra2 == ''||$erantzunokerra3 == ''||$zailtasuna == ''||$gaia == ''){
	header("location:mezua.php?goiburu=Errorea!!&gorputza=Ez dira datu guztiak jaso&auk=<a href = 'addQuestion.html'>Idatzi beste galdera bat</a>"); 
}

$imgs = array("image/jpg", "image/jpeg", "image/gif", "image/png", "image/bmp");
$max_kb = 1048576; /*1Mb-eko fitxategia gehienez*/

include('dbConfig.php');

//mysql-rekin konexioa egin eta datu-basea ireki
if(!$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db)){
	header("location:mezua.php?goiburu=Errorea!!&gorputza=ez da konexioa lortu<br/>".$konexioa -> error."&auk=<a href = 'addQuestion.html'>Idatzi beste galdera bat</a>");
}
//jasotako fitxategiaren edukia behar den moduan formateatu
if(is_uploaded_file($img)){
	$mezu = $mezu.'<br/>fitxategia jaso du';
	if(in_array($img_tp,$imgs) && $neurri < $max_kb){
		$mezu = $mezu.'<br/>fitxategia marrazkia da';
		$img = $konexioa -> real_escape_string(file_get_contents($img));
	}
}
else{
	$mezu = $mezu.'<br/>fitxategia ez da jaso';
  header("location:mezua:php?goiburu=Errorea!!!&gorputza=Marrazkia ez da zerbitzarira iritsi&auk=<a href = 'layuot.html'>Itzuli hasierara</a>");
}
//sql kontsulta sortu
$sql = "insert into questions(mail,galdera,erantzun_zuzena,erantzun_okerra_1,erantzun_okerra_2,erantzun_okerra_3,zailtasuna,gaia,marrazkia,mota) values('".$mail."','".$galdera."','".$zuzena."','".$erantzunokerra1."','".$erantzunokerra2."','".$erantzunokerra3."',".$zailtasuna.",'".$gaia."','".$img."','".$img_tp."')";

//sql kontsulta exekutatu
if(!($emaitza = $konexioa -> query($sql))){
	header("location:mezua.php?goiburu=Errorea!!&gorputza=SQL kontsulta ez da exekutatu<br/>".$konexioa -> error."&auk=<a href = 'addQuestion.html'>Idatzi beste galdera bat</a>");
}
//konexioa itxi
$konexioa -> close();

header("location:mezua.php?goiburu=Eskaera gauzatu da&gorputza=Bidalitako datuak batu-basean ongi gorde dira&auk=<a href = 'showQuestionswithImage.php'>Ikusi galdera guztiak</a><br/><a href='../layout.html'>Itzuli orri nagusira</a>");
?>

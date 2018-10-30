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

if(!isset($mail)){header('location:layout.php');}

$msg = aldagaiak_aztertu($mail,$galdera,$zuzena,$erantzunokerra1,$erantzunokerra2,$erantzunokerra3,$zailtasuna,$gaia);
if($msg != ''){header("location:addQuestion_HTML5.php?mail=".$mail."&msg=".$msg);}

include('dbConfig.php');

//mysql-rekin konexioa egin eta datu-basea ireki
if(!$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db)){
	$msg = 'Errorea datu-basearekin konexioa egiterakoan';
	header("location:addQuestion_HTML5.php?mail=".$mail."&msg=".$msg);
}

$img = array();
if (isset($_FILES["html_file"]) || $_FILES["html_file"]["error"] = 0){
	$img = fitxategia_aztertu($konexioa,$_FILES["html_file"]);
}
else{
	$img[0] = null;
	$img[1] = '-';
}

//sql kontsulta sortu
$sql = "insert into questions(mail,galdera,erantzun_zuzena,erantzun_okerra_1,erantzun_okerra_2,erantzun_okerra_3,zailtasuna,gaia,marrazkia,mota) values('".$mail."','".$galdera."','".$zuzena."','".$erantzunokerra1."','".$erantzunokerra2."','".$erantzunokerra3."',".$zailtasuna.",'".$gaia."','".$img[0]."','".$img[1]."')";

//sql kontsulta exekutatu
if(!($emaitza = $konexioa -> query($sql))){
	$msg = 'Kontsulta ez da behar den bezala exekutau';
	header("location:addQuestion_HTML5.php?mail=".$mail."&msg=".$msg);
}
//konexioa itxi
$konexioa -> close();

//dena ongi egin da eta formularioa erakutsi
$msg = 'Datoak datu-basean gorde dire';
header("location:addQuestion_HTML5.php?mail=".$mail."&msg=".$msg);

function aldagaiak_aztertu($m,$gl,$ez,$e1,$e2,$e3,$z,$ga){
	//mail aztertu
	$exp_reg = '/\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus$/';
	if(!preg_match ($exp_reg, $m)){return 'eposta ez dago ongi eraikita';}

	//galdera aztertu
	$gl = preg_replace('/\s\s+/', ' ', $gl);

	if(strlen($gl) < 10){return 'galdera motzegia da';}

	//zailtasuna aztertu
	$zk = filter_var ($z, FILTER_VALIDATE_INT);
	if($zk > 5 || $zk < 1){return 'zailtasuna ez da mugen artean';}

	if($ez == '' || $e1 == '' || $e2 == '' || $e3 == '' || $ga == ''){return 'daturen bat falta da';}
	return '';
}
function fitxategia_aztertu($k,$f){

	$img = $f["tmp_name"];	//fitxategiaren edukia
	$img_nm = $f["name"];		//fitxategiaren izena
	$img_tp = $f["type"];		//fitxategi mota
	$neurri = $f['size'];		//fitxategiaren neurriak

	$imgs = array("image/jpg", "image/jpeg", "image/gif", "image/png", "image/bmp");
	$max_kb = 1048576; /*1Mb-eko fitxategia gehienez*/

	//jasotako fitxategiaren edukia behar den moduan formateatu
	if(is_uploaded_file($img)){
		if(in_array($img_tp,$imgs) && $neurri < $max_kb){
			$img = $k -> real_escape_string(file_get_contents($img));
		}
	}
	return array($img,$img_tp);
}
?>
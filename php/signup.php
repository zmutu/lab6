<?php
$izena = '';
$pasahitza1 = '';
$pasahitza2 = '';
$img = '';
$img_tp = '-';

if(isset($_POST['mail'])){$mail = $_POST['mail'];}
if(isset($_POST['izena'])){$izena = $_POST['izena'];}

if(isset($_POST['pasahitza1'])){$pasahitza1 = $_POST['pasahitza1'];}
if(isset($_POST['pasahitza2'])){$pasahitza2 = $_POST['pasahitza2'];}
if(isset($_FILES["html_file"]) && $_FILES["html_file"]["error"] == 0){
	$img = $_FILES['html_file']["tmp_name"];	//fitxategiaren edukia
	$img_nm = $_FILES["html_file"]["name"];		//fitxategiaren izena
	$img_tp = $_FILES["html_file"]["type"];		//fitxategi mota
	$neurri = $_FILES['html_file']['size'];		//fitxategiaren neurriak
}

if(isset($mail)){
	//mail jaso bada, datuak aztertu
	$msg = datoak_aztertu($mail,$izena,$pasahitza1,$pasahitza2);
	if($msg != ''){
		//datoak jaso dira eta erroreen bat dago
		formularioa($mail,$izena,$msg);
		exit();
	}
}
else{
	//ez da datorik jaso
	formularioa('','','');
	exit();
}
//inforamazioa jaso da
include('dbConfig.php');

$max_kb = 1048576; //1Mb-eko argazkia gehienez
$imgs = array("image/jpg", "image/jpeg", "image/gif", "image/png", "image/bmp");

if(!$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db)){
	formularioa($mail,$izena,'Datu-basearekin konexioa ez da lortu');
	exit();
}

if(is_uploaded_file($img)){
	if(in_array($img_tp,$imgs) && $neurri < $max_kb){
		$img = $konexioa -> real_escape_string(file_get_contents($img));
	}
	else{
		$img = '';
		$img_tp = '-';
	}
}

$sql = "Insert into users(eposta,izena,pasahitza,argazkia,mota) values('".$mail."','".$izena."','".$pasahitza1."','".$img."','".$img_tp."')";

if(!$konexioa -> query($sql)){
	$msg = 'Errorea datu-basean datuak sartzean';
	formularioa($mail,$izena,$msg);
}
else{
	$msg = 'Erabiltzailea sortu da';
	formularioa($mail,$izena,$msg);
}

function formularioa($m,$i,$msg){
echo("<html>
<head>
<meta charset='UTF-8'>
<title>Lab 4, SignUp</title>
<link rel='icon' type='image/png' href='images/fabikon.png' />
<style>
input:invalid{border:1px solid red;}
#msg{border:solid 2px #0055AA;background-color:#0055FF;font-size:2em;display:none;padding:5px;position:absolute;}
div{width:350px;margin:5px auto;border:5px outset #555555;}
</style>
<!--
<script src='https://code.jquery.com/jquery-3.3.1.min.js' type='text/javascript'></script>
-->
<script src='../js/jquery.js' type='text/javascript'></script>
<script>
function fitxategi(){
	var img = \$('#img')[0].files[0];
	\$('#neurri').text('fitxategiaren neurria: '+img.size+' byte');
	if(img){
		var FR = new FileReader();
		FR.readAsDataURL(img);
		FR.onload = function(e){
			\$m = \$('#marrazkia');
			\$m.attr('src',e.target.result);
			var zabal = \$m.width();
			if(zabal>350){\$m.css('width',300);}
		}
	}
}
function garbitu(){
	$('#marrazkia').attr('src','');
	$('#neurri').html('');
}");
if($msg != ''){
	echo(
"\$(document).ready(function(){
	var \$msg = \$('#msg');
	\$msg.text( '".$msg."' );
	var \$arakatzaile = \$(window);
	var l = (\$arakatzaile.width()-\$msg.width())/2;
	var t = (\$arakatzaile.height()-\$msg.height())/2;
	\$msg.css({left:l,top:t});
	\$msg.show().fadeOut( 10000 );
});"
	);
}
//$.post( "test.php", { name: "John", time: "2pm" } );
//login.php fitxategiak datuak goiburuan enkriptatua espero ditu ($_POST)
if(isset($mail)){echo("function LogIn(){\$post({'login.php',name:$mail})}");}
echo("</script>
</head>
<body>
<div>
	<span id='msg'></span><br/>
	<form id='galderenF' name='galderenF' enctype='multipart/form-data' onreset='garbitu()' method='post' action='".$_SERVER['PHP_SELF']."'>
		<fieldset style='text-align:center;'>
			<h3 style='text-align:center;'>SIGN UP</h3>
			<p><label>Mail*: <INPUT TYPE='text' NAME='mail' id='mail' pattern='\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus$' value='".$m."' required></label></p>
			<p>
				<label>Izena*: <INPUT TYPE='text' NAME='izena' id='izena' value='".$i."' required></label><br/>
				<label>Pasahitza*: <INPUT TYPE='password' NAME='pasahitza1' id='pasahitza1' minlength='8' size='20' value='' required></label><br/>
				<label>Pasahitza*: <INPUT TYPE='password' NAME='pasahitza2' id='pasahitza2' minlength='8' size='20' value='' required></label><br/>
			</p>
			<p>
				<label>Argazkia: <INPUT TYPE='file' NAME='html_file' ACCEPT='text/html' id='img' onchange='fitxategi()'></label><br/>
				<img src='' id='marrazkia'/>
			</p>
			<span>
				<button type='reset' value='garbitu'>Garbitu</button>
				<button type='submit' value='bidali'>Bidali</button>
			</span><br/>
			<p>");
			if(isset($mail)){
				echo("<a href='layout.php?mail=".$mail."'>nagusia</a> || <span onclick='LogIn()'>Log In</span>");
			}
			else{
				echo("<a href='layout.php'>nagusia</a> || <a href='login.php'>Log In</a>");
			}
			echo("</p>
		</fieldset>
	</form>
</div>
</body>
</html>
");
}
function datoak_aztertu($m,$i,$p1,$p2){
	//mail aztertu
	$exp_reg = '/\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus$/';
	if(!preg_match ($exp_reg, $m)){return 'mail ez da zuzena';}
	
	//izena (bi hitz eta hizki larriz hasten direnak)
	$exp_reg = '/[A-Z]\w+\s[A-Z]\w+/';
	if(!preg_match ($exp_reg, $i)){return 'izena ez dago ongi eraikia';}
	
	//pasahitza gutxienez 8ko luzera
	if($p1 != $p2 || strlen($p1) < 8){return 'pasahitzak desberdinak dira';}

	return '';
}
?>

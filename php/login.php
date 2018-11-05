<?php
$msg = '';
$mail = '';
$pasahitza = '';

if(isset($_POST['mail'])){$mail = $_POST['mail'];}
if(isset($_POST['pasahitza'])){$pasahitza = $_POST['pasahitza'];}

if($mail == ''){
	formularioa('','');
	exit();
}

$msg = datoak_aztertu($mail,$pasahitza);

if($msg != ''){
	//datuetan erroreren bat dago
	formularioa($mail,$msg);
	exit();
}
include('dbConfig.php');

$sql = "Select id from users where eposta = '".$mail."' and pasahitza = '".$pasahitza."'";

//konexioa egin
if(!$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db)){
	$msg = 'Errorea datu-basearekin konexua ezartzerakoan';
	formularioa($mail,$msg);
	exit();
}
else{
	//kontsulta exekutatu
	if(!($id = $konexioa -> query($sql))){
		$msg = 'Errorea datu-baseari kontsulta egiterakoan';
		formularioa($mail,$msg);
		exit();
	}
	else{
		if($usr_id = $id -> fetch_array(MYSQLI_ASSOC)){
			//erabiltzailea eta pasahitza ongi daude
			header('location:layout.php?mail='.$mail);
		}
		else{
			$msg = 'Erabiltzailea edo pasahitza ez dira zuzenak';
			formularioa($mail,$msg);
			exit();
		}
	}
}
formularioa($mail,'');

function datoak_aztertu($m,$p){
//expresio regularra mail eta pasahitza aztertzeko
	//mail aztertu
	$exp_reg = '/\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus$/';
	if(!preg_match ($exp_reg, $m)){return 'mail ez da zuzena';}
	
	//pasahitza gitxienen 8ko luzera
	if(strlen($p) < 8){return 'pasahitzaren luzera ez da egokia';}

	return '';
}
function formularioa($m,$msg){
	echo("
<html>
<head>
<meta charset='UTF-8'>
<title>Lab 4, Log In</title>
<link rel='icon' type='image/png' href='images/fabikon.png' />
<style>
input:invalid{border:1px solid red;}
#msg{border:solid 2px #0055AA;background-color:#55AAFF;font-size:2em;display:none;padding:5px;position:absolute;top:250;}
div{width:300px;border:5px outset #555555;margin:0px auto;}</style>
<!--
<script src='https://code.jquery.com/jquery-3.3.1.min.js' type='text/javascript'></script>
-->
<script src='../js/jquery.js' type='text/javascript'></script>
<script>\n");
if($msg != ''){
	echo("\n$(document).ready(function(){
	var \$msg = \$('#msg');
	\$msg.text( '".$msg."' );
	var \$arakatzaile = $(window);
	var l = (\$arakatzaile.width()-\$msg.width())/2;
	var t = (\$arakatzaile.height()-\$msg.height())/2;
	\$msg.css('left',l);
	\$msg.show().fadeOut(10000);
});\n");
}
echo("
</script>
</head>
<body>
<div>
	<span id='msg'></span>
	<form id='galderenF' name='galderenF' enctype='multipart/form-data' onreset='garbitu()' method='post' action='".$_SERVER['PHP_SELF']."'>
		<fieldset style='text-align:center;'>
			<h3>LOG IN</h3>
			<span><label>Mail*: <INPUT TYPE='mail' NAME='mail' id='mail' pattern='\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus$' value='".$m."' required></label><span><br/><br/>
			<span><label>Pasahitza*: <INPUT TYPE='password' NAME='pasahitza' id='pasahitza1' size='20' value='' required></label></span><br/>
			<p>	<button type='submit' value='bidali'>Bidali</button></p>
			<p><a href='layout.php");
			if(isset($mail)){echo('?mail='.$mail);}
			echo("'>nagusia</a> ||
			<a href='signup.php");
			if(isset($mail)){echo('?mail='.$mail);}
			echo("'>Sign Up</a></p>
		</fieldset>
	</form>
</div>
</body>
</html>");
}

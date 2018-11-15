<?php
$msg = '';
$mail = '';
$pasahitza = '';

if(isset($_POST['mail'])){$mail = $_POST['mail'];}
if(isset($_POST['pasahitza'])){$pasahitza = $_POST['pasahitza'];}

//echo('mail: ->'.$mail.'<-<br/>pasahitza: ->'.$pasahitza.'<-');exit();
if($mail=='' && $pasahitza==''){
	formularioa();
	exit();
}

$msg = datoak_aztertu($mail,$pasahitza);

if($msg != ''){
	echo($msg);
	exit();
}
include('dbConfig.php');

$sql = "Select id from users where eposta = '".$mail."' and pasahitza = '".$pasahitza."'";

//konexioa egin
if(!$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db)){
	echo('Errorea datu-basearekin konexua ezartzerakoan');
	exit();
}
else{
	//kontsulta exekutatu
	if(!($id = $konexioa -> query($sql))){
		echo('Errorea datu-baseari kontsulta egiterakoan');
		exit();
	}
	else{
		if($usr_id = $id -> fetch_array(MYSQLI_ASSOC)){
			//erabiltzailea eta pasahitza ongi daude
			//erabiltzaile kautotu kopurua aldatu...
			$egitura = new DOMDocument();
			$egitura -> preserveWhiteSpace = true;
			$egitura -> load('../xml/counter.xml');
			//lehenik kautotuta dagoen begiratu
			$users = $egitura -> getElementsByTagName('erabiltzaile');
			foreach($users as $user){
				if($user  -> nodeValue == $mail){
					echo('Erabiltzaile hori sisteman sartuta dago');
					exit();
				}
			}
			$erabiltzaile_kopurua = (int)$egitura -> getElementsByTagName('kopuru') -> item(0) -> nodeValue;
			$erabiltzaile_kopurua++;
			$egitura -> getElementsByTagName('kopuru') -> item(0) -> nodeValue = $erabiltzaile_kopurua;
			$users = $egitura -> getElementsByTagName('erabiltzaileak') -> item(0);
			$erabiltzaile = $egitura -> createElement('erabiltzaile');
			$posta = $egitura -> createTextNode($mail);
			$erabiltzaile -> appendChild($posta);
			$users -> appendChild($erabiltzaile);
			$egitura -> save('../xml/counter.xml');
			//kautotu bada, layout.php orria birkargatu
			echo('ongi kautotu da');
		}
		else{
			echo('Erabiltzailea edo pasahitza ez dira zuzenak');
			exit();
		}
	}
}

function datoak_aztertu($m,$p){
	//mail aztertu
	$exp_reg = '/\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus$/';
	if(!preg_match ($exp_reg, $m)){return 'mail ez da zuzena';}
	
	//pasahitza gitxienen 8ko luzera
	if(strlen($p) < 8){return 'pasahitzaren luzera ez da egokia';}

	return '';
}
function formularioa(){
	echo("
<style>
#logF input:invalid{border:1px solid red;}
#msg{border:solid 2px #0055AA;background-color:#55AAFF;font-size:2em;display:none;padding:5px;position:absolute;}
#form{width:300px;border:5px outset #555555;margin:0px auto;}
</style>
<script src='../js/jquery.js' type='text/javascript'></script>
<script>
function kautotu(){
	$.ajax({
		type: 'POST',
		url: 'login.php',
		data: {mail: $('#mail').val(),pasahitza: $('#pasahitza').val()},
		success: function(em){
			var msg = $('#msg');
			msg.html(em);
			w = $(window);
			msg.css({top:(w.height()-msg.height())/2,left:(w.width()-msg.width())/2});
			msg.show();
			setTimeout(function(){
				msg.fadeOut();
				if(em == 'ongi kautotu da'){
					window.location.href='layout.php?mail='+$('#mail').val();
				}
			},3000);
		},
		dataType: 'text'
	});
}
</script>
<div id='form'>
	<span id='msg'></span>
	<form id='logF' name='logF' onreset='garbitu()'>
		<fieldset style='text-align:center;'>
			<h3>LOG IN</h3>
			<span><label>Mail*: <INPUT TYPE='mail' NAME='mail' id='mail' pattern='\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus$' value='' required></label><span><br/><br/>
			<span><label>Pasahitza*: <INPUT TYPE='password' NAME='pasahitza' id='pasahitza' size='20' minlength='8' value='' required></label></span><br/>
			<p>	<button type='button' onclick='kautotu()' value='bidali'>Bidali</button></p>
		</fieldset>
	</form>
</div>");
}
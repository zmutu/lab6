<?php
$izena = '';
$pasahitza1 = '';
$pasahitza2 = '';
$img = '';
$img_tp = '-';

isset($_POST['fase'])?$fase = $_POST['fase']:$fase=0;

if(isset($_POST['mail'])){$mail = $_POST['mail'];}
if(isset($_POST['izena'])){$izena = $_POST['izena'];}
if(isset($_POST['fase'])){$fase = $_POST['fase'];}
if(isset($_POST['ticket'])){$ticket = $_POST['ticket'];}

if(isset($_POST['pasahitza1'])){$pasahitza1 = $_POST['pasahitza1'];}
if(isset($_POST['pasahitza2'])){$pasahitza2 = $_POST['pasahitza2'];}
if(isset($_FILES["html_file"]) && $_FILES["html_file"]["error"] == 0){
	$img = $_FILES['html_file']["tmp_name"];	//fitxategiaren edukia
	$img_nm = $_FILES["html_file"]["name"];		//fitxategiaren izena
	$img_tp = $_FILES["html_file"]["type"];		//fitxategi mota
	$neurri = $_FILES['html_file']['size'];		//fitxategiaren neurriak
}

switch($fase){
	case 0:
		formularioa();
		break;
	case 1: //ikaslea matrikulatuta dagoen aztertu behar da
		require_once("../nuSOAP/nusoap.php");
		$param = array('x' => $mail);
		$mailMatrikulatutaDago = new nusoap_client('http://ehusw.es/rosa/webZerbitzuak/egiaztatuMatrikula.php?wsdl', true);
		$matrikulatutaDago = $mailMatrikulatutaDago -> call('egiaztatuE',$param);
		//$dago = $matrikulatutaDago -> getElementsByTagName('z')[0] -> nodeValue;
		echo($matrikulatutaDago);
		break;
	case 2: //pasahitza egokia den aztertu
		require_once("../nuSOAP/nusoap.php");
		$param = array('pasahitza' => $pasahitza1,'ticket' => 1010);
		$pswdSeguruaDa = new nusoap_client('egiaztatuPasahitza.php?wsdl',true);
		$seguruaDa = $pswdSeguruaDa -> call('egokiaDa', $param);
		if($pswdSeguruaDa->fault){
			echo "Errorea: <p>Codea: (".$pswdSeguruaDa->faultcode.")</p>";
			echo "Mezua: ".$pswdSeguruaDa->faultstring;
		}
		else{echo $seguruaDa;}
		break;
	default: //datuak aztertu eta gorde
		$msg = datoak_aztertu($mail,$izena,$pasahitza1,$pasahitza2);
		if($msg != ''){echo($msg);}
		else{
			//datoak jaso dira eta egokiak dire
			include('dbConfig.php');

			$max_kb = 1048576; //1Mb-eko argazkia gehienez
			$imgs = array("image/jpg", "image/jpeg", "image/gif", "image/png", "image/bmp");

			if(!$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db)){
				echo('Datu-basearekin konexioa ez da lortu');
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
				echo('Errorea datu-basean datuak sartzean');
			}
			else{
				echo('Erabiltzailea sortu da');
			}
		}
}
function formularioa(){
?>
<!-- =========================== -->
<html>
<head>
<style>
	input{margin:2px;}
	#galderenF input:invalid{border:1px solid red;}
	#msg{border:solid 2px #0055AA;background-color:#0055FF;font-size:2em;display:none;padding:5px;position:absolute;align:center;}
	#signup{width:350px;margin:5px auto;border:5px outset #555555;}
</style>
<script src='../js/jquery.js' type='text/javascript'></script>
<script>
var egoera=0; // 1 => baldintza bat betetzen du; 2 => bi baldintzak betetzen ditu
function fitxategi(){
	var img = $('#img')[0].files[0];
	$('#neurri').text('fitxategiaren neurria: '+img.size+' byte');
	if(img){
		var FR = new FileReader();
		FR.readAsDataURL(img);
		FR.onload = function(e){
			$m = $('#marrazkia');
			$m.attr('src',e.target.result);
			$m.css('width',75);
		}
	}
}
function garbitu(){
	$('#marrazkia').attr('src','');
	$('#neurri').html('');
}
$(document).ready(function(e){
	$('#galderenF').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			type:'POST',
			url:'signup.php',
			data: new FormData($(this)),
			dataType:'text',
			success: function(em){mezua(em);},
			error: function(er){mezua('errorea: '+er);}
		});
	});
	$('#mail').focusout(function(){
		$.ajax({
			url: 'signup.php',
			type: 'post',
			data: {'mail':$(this).val(),'fase':'1'},
			dataType: 'text',
			success: function(em){
				mezua(em);
				if(em == 'BAI'){
					egoera ++;
					if(egoera == 2)$('#bidali').prop("disabled",true);
					mezua('mail hori matrikulatuta dago');
				}
				else{
					mezua('mail hori ez dago matrikulatuta');
				}
			},
			error: function(er){
				mezua('mail hori matrikulatuta dagoen aztertzean<br/>errore bat gertatu da<br/>ezingo duzu alta eman');
			}
		});
	});
	$('#pasahitza1').focusout(function(){
		$.ajax({
			url: 'signup.php',
			type: 'post',
			data: {'pasahitza1':$(this).val(),'fase':'2'},
			dataType: 'xml',
			success: function(em){
				if(em == 'BALIOZKOA'){
					egoera ++;
					if(egoera == 2)$('#bidali').prop("disabled",true);
					mezua('Pasahitza segurua da');
				}
				else if(em = 'BALIOGABEA'){
					mezua('Pasahitza ez da segurua<br/>aldatu beharko duzu');
				}
			},
			error: function(er){
				mezua('Pasahitzaren segurtasuna aztertzean<br/>errore bat gertatu da<br/>ezingo duzu alta eman');
			}
		});
	});
	$('#pasahitza2').focusout(function(){
		if($(this).val() != $('#pasahitza1').val()){
			mezua('Bi pasahitzak desberdinak dira');
		}
	});
});
function mezua(msg){
	$m = $('#msg');
	$m.html(msg);
	$w = $(window);
	$m.css({top:($w.height()-$m.height())/2,lef:($w.width()-$m.width())/2,align:'center'}).show();
	setTimeout(function(){$m.fadeOut();},5000);
}
</script>
</head>
<body>
<div id='signup'>
	<span id='msg'></span><br/>
	<form id='galderenF' name='galderenF' enctype='multipart/form-data' onreset='garbitu()' method='post'>
		<fieldset style='text-align:center;'>
			<h3 style='text-align:center;'>SIGN UP</h3>
			<p><label>Mail*: <INPUT TYPE='mail' NAME='mail' id='mail' pattern='\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus' value='' required></label></p>
			<p>
				<label>Izena*: <INPUT TYPE='text' NAME='izena' id='izena' value='' required></label><br/>
				<label>Pasahitza*: <INPUT TYPE='password' NAME='pasahitza1' id='pasahitza1' minlength='8' size='20' value='' required></label><br/>
				<label>Pasahitza*: <INPUT TYPE='password' NAME='pasahitza2' id='pasahitza2' minlength='8' size='20' value='' required></label><br/>
			</p>
			<p>
				<label>Argazkia: <INPUT TYPE='file' NAME='html_file' ACCEPT='text/html' id='img' onchange='fitxategi()'></label><br/>
				<img src='' id='marrazkia'/>
			</p>
			<span>
				<button type='reset' value='garbitu'>Garbitu</button>
				<button type='submit' value='bidali' id='bidali' disabled>Bidali</button>
			</span><br/>
		</fieldset>
	</form>
</div>
</body>
</html>
<!-- =========================== -->
<?php
}
function datoak_aztertu($m,$i,$p1,$p2){
	//mail aztertu
	$exp_reg = '/\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus$/';
	if(!preg_match ($exp_reg, $m)){return 'mail ez da zuzena';}
	
	//izena (bi hitz eta hizki larriz hasten direnak)
	$exp_reg = '/[A-Z]\w+\s[A-Z]\w+/';
	if(!preg_match ($exp_reg, $i)){return 'izena ez dago ongi eraikia';}
	
	if($p1 != $p2){return 'pasahitzak desberdinak dira';}
	
	//pasahitza gutxienez 8ko luzera
	if(strlen($p1) < 8){return 'pasahitza motzegia da';}

	return '';
}
?>

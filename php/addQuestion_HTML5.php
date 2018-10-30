<?php
if(isset($_GET['mail'])){$mail = $_GET['mail'];}
else{header('location:layout.php');}
if(isset($_GET['msg'])){$msg = $_GET['msg'];}

//argazkia jaso
include('dbConfig.php');
$sql = "Select argazkia, mota from users where eposta = '".$mail."'";

$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db);

$em = $konexioa -> query($sql)or trigger_error(mysql_error());;
$argazkia = $em -> fetch_array(MYSQLI_ASSOC);

if($argazkia["mota"]!='-'){
		$img = "data:".$argazkia["mota"].";base64,".base64_encode($argazkia["argazkia"]);
}
else{$img = '';}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Lab 3, HTML5 Formularioa</title>
<style>
	input:invalid{border:1px solid red;}
	form{width:350px;margin:0px auto;text-align:center;}
	#msg{border:solid 2px #0055AA;background-color:#0055FF;font-size:2em;display:none;padding:5px;position:absolute;}
</style>
<!--
<script src='https://code.jquery.com/jquery-3.3.1.min.js' type='text/javascript'></script>
-->
<script src='../js/jquery.js' type='text/javascript'></script>
<script>
function fitxategi(){
	var $img = $('#img')[0].files[0];
	$('#neurri').text('fitxategiaren neurria: '+$img.size+' byte');
	if($img){
		var FR = new FileReader();/*fitxategi bat irakurtzeko objetua  sortu*/
		FR.readAsDataURL($img);/*fitxategiaren edukia irakurri*/
		FR.onload=function(e){/*fitxategi guztia irakurtu ondoren...*/
			$('#marrazkia').attr('src',e.target.result);/*'img' objetuaren 'src' propietateari esleitu*/
		}
	}
}
<?php
if(isset($msg)){
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
?>
</script>
</head>
<body>
	
	<form id="galderenF" name="galderenF" enctype="multipart/form-data" onreset="garbitu()" method="post" action="addQuestionwithImage.php">
		<fieldset>
			<img id='erabiltzaile' src='<?php echo($img);?>' width='100'/>
			<p><label>Mail(*): <INPUT TYPE='mail' NAME='mail' id='mail' pattern='\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus$' value='<?php echo($mail);?>' required></label></p>
			<p>
				<label>Galdera (*): <INPUT TYPE='text' NAME='galdera' id='galdera' minlength='10' required></label><br/>
				<label>Erantzun zuzena (*): <INPUT TYPE='text' NAME='zuzena' id='eZuzen' size='20' required></label><br/>
				<label>Erantzun okerra 1 (*): <INPUT TYPE='text' NAME='erantzunokerra1' id='eOker1' required></label><br/>
				<label>Erantzun okerra 2 (*): <INPUT TYPE='text' NAME='erantzunokerra2' id='eOker2' required></label><br/>
				<label>Erantzun okerra 3 (*): <INPUT TYPE='text' NAME='erantzunokerra3' id='eOker3' required></label><br/>
			</P>
			<p>
				<label>Zailtasuna(*): <INPUT TYPE='number' NAME='zailtasuna' id='zailtasuna' min='0' max='5' required></label><br/>
				<label>Gaia(*): <INPUT TYPE='text' NAME='gaia' id='gaia' required></label><br/>
				<label>Argazkia: <INPUT TYPE='file' NAME='html_file' ACCEPT='text/html' id='img' onchange='fitxategi()'></label><br/>
				<span id='neurri' style='color:darkblue;font-weight:bold;'></span><br/>
				<img src='' id='marrazkia'/>
			</p>
			<p>
				<button type='reset' value='garbitu'>Garbitu</button>
				<button type='submit' value='bidali'>Bidali</button>
			</p>
			<p>
				<a href='layout.php?mail=<?php echo($mail);?>'>Nagusia</a> || <a href='showQuestionswithImage.php?mail=<?php echo($mail);?>'>Galdera zerrenda</a>
			</p>
		</fieldset>
		<a href='layout.php?mail=<?php echo($mail);?>'><img src='../images/gezia.png'/></a>
	</form>
	<span id='msg'></span>
</body>
</html>
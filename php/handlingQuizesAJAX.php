<?php
if(isset($_GET['mail'])){$mail = $_GET['mail'];}
else{header('location:layout.php');}

/* ARGAZKIA JASO */
include('dbConfig.php');
$sql = "Select argazkia, mota from users where eposta = '".$mail."'";
$konexioa = new mysqli($zerbitzaria,$erabiltzaile,$gakoa,$db);
$em = $konexioa -> query($sql);
$argazkia = $em -> fetch_array(MYSQLI_ASSOC);
if($argazkia["mota"]!='-'){
	$img = "data:".$argazkia["mota"].";base64,".base64_encode($argazkia["argazkia"]);
}
else{$img = '';}
/* /ARGAZKIA */

?>
<style>
	input{margin:1px;}
	input:invalid{border:1px solid red;}
	form{width:400px;margin:0px auto;text-align:center;}
	#msg{border:solid 2px #0055AA;background-color:#0055FF;font-size:2em;display:none;padding:5px;position:absolute;}
	#erregistroak, #login{color:blue;}
</style>
<!--
<script src='https://code.jquery.com/jquery-3.3.1.min.js' type='text/javascript'></script>
-->
<script src='../js/jquery.js' type='text/javascript'></script>
<script>
function bidali(){
	var datuak = new FormData($('#galderenF'));
	$.ajax({
		url:'addQuestionwithImage.php',
		type: 'POST',
		data: datuak,
		processData: false,
		contentType: false,
		dataType: 'text',
		success: function(em){
			$m = $('#msg');
			$m.html(em);
			$w = $(window);
			$m.css({top:($w.height()-$m.height())/2,lef:($w.width()-$m.width())/2}).show();
			setTimeout(function(){$m.fadeOut();},5000);
		},
		error: function(er){
			$m = $('#msg');
			$m.html(er);
			$w = $(window);
			$m.css({top:($w.height()-$m.height())/2,lef:($w.width()-$m.width())/2,'background-color':'orange'}).show();
			setTimeout(function(){$m.fadeOut();},10000);
		},
		complete: function(msg){
			$m = $('#msg');
			$m.html(msg);
			$w = $(window);
			$m.css({top:($w.height()-$m.height())/2,lef:($w.width()-$m.width())/2,'background-color':'yellow'}).show();
			setTimeout(function(){$m.fadeOut();},10000);
		}
	});
}
function garbitu(){
	$('#marrazkia').attr('src','');
	$('#neurri').text('');
}
function fitxategi(){
	var $img = $('#img')[0].files[0];
	$('#neurri').text('fitxategiaren neurria: '+$img.size+' byte');
	if($img){
		var FR = new FileReader();/*fitxategi bat irakurtzeko objetua  sortu*/
		FR.readAsDataURL($img);/*fitxategiaren edukia irakurri*/
		FR.onload=function(e){/*fitxategi guztia irakurtu ondoren...*/
			$('#marrazkia').attr({'src':e.target.result,'width':100});/*'img' objetuaren 'src' propietateari esleitu*/
		}
	}
}
function jaso(){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange= function (){
		if (xhr.readyState == 4){
			$('#galdera_zerrenda').html(xhr.responseText);
		}
	}
	xhr.open('GET','showQuestions.php?mail='+$('#mail').val());
	xhr.send();
}
$(document).ready(function(){
	$mail = $('#mail').val();
	maiz1 = setInterval(
		function(){
			$.get(
				'emanErregistroakOraintxeBertan.php',
				{'mail':$mail},
				function(em){
					var e = em.split('/');
					$('#erregistroak').html('['+$mail+' galderak: '+e[0]+']/[galdera guztiak: '+e[1]+']');
				},
				'text'
			);
		},
		20000
	);
	maiz2 = setInterval(
		function(){
			$.get(
				'../xml/counter.xml',
				function(e){
					var u = $(e).find('kopuru')[0];
					$('#login').html('Konektatutako erabiltzaile kopurua: ' + $(e).find('kopuru')[0].childNodes[0].nodeValue);
				},
				'XML'
			);
		},
		20000
	);
	$('#galderenF').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'addQuestionwithImage.php',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			dataType: 'text',
			success: function(em){
				console.log('ongi: '+em);
				$m = $('#msg');
				$m.html(em);
				$w = $(window);
				$m.css({top:($w.height()-$m.height())/2,lef:($w.width()-$m.width())/2}).show();
				setTimeout(function(){$m.fadeOut();},5000);
			},
			error: function(er){
				console.log('errorea: '+er);
				$m = $('#msg');
				$m.html(er);
				$w = $(window);
				$m.css({top:($w.height()-$m.height())/2,lef:($w.width()-$m.width())/2}).show();
				setTimeout(function(){$m.fadeOut();},5000);
			}
		});
	});
});
</script>
</head>
<body>
	<form id="galderenF" name="galderenF" enctype="multipart/form-data" onreset="garbitu()" method="post">
		<span id='msg'></span>
		<fieldset>
			<img id='erabiltzaile' src='<?php echo($img);?>' width='50'/>
			<button type='submit' name='bidal' id='bidal'>Galdera Bidali</button>
			<button type='button' name='zerrenda' id='zerrenda' onclick='jaso()'>Galdera Zerrenda</button>
			<INPUT TYPE='hidden' NAME='mail' id='mail' pattern='\w\w[a-z]*\d\d\d@ikasle\.ehu\.eus$' value='<?php echo($mail);?>' />
			<p>
				<label>Galdera (*): <INPUT TYPE='text' NAME='galdera' id='galdera' minlength='10' required></label><br/>
				<label>Erantzun zuzena (*): <INPUT TYPE='text' NAME='zuzena' id='eZuzen' size='20' required></label><br/>
				<label>Erantzun okerra 1 (*): <INPUT TYPE='text' NAME='erantzunokerra1' id='erantzunokerra1' required></label><br/>
				<label>Erantzun okerra 2 (*): <INPUT TYPE='text' NAME='erantzunokerra2' id='erantzunokerra2' required></label><br/>
				<label>Erantzun okerra 3 (*): <INPUT TYPE='text' NAME='erantzunokerra3' id='erantzunokerra3' required></label><br/>
			</P>
			<p>
				<label>Zailtasuna(*): <INPUT TYPE='number' NAME='zailtasuna' id='zailtasuna' min='0' max='5' required></label><br/>
				<label>Gaia(*): <INPUT TYPE='text' NAME='gaia' id='gaia' required></label><br/>
				<label>Argazkia: <INPUT TYPE='file' NAME='html_file' ACCEPT='text/html' id='img' onchange='fitxategi()'></label><br/>
				<span id='neurri' style='color:darkblue;font-weight:bold;'></span><br/>
				<img src='' id='marrazkia'/>
			</p>
		</fieldset>
	</form>
	<p id='login'></p>
	<p id='erregistroak'></p>
	<p id='galdera_zerrenda'></p>
	<span id='msg'></span>
</body>
</html>
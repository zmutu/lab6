<?php
if(isset($_GET['mail'])){$mail = $_GET['mail'];}
else{header('location:layout.php');}
if(isset($_GET['irten'])){
	$egitura = new DOMDocument();
	$egitura->load('../xml/counter.xml');
	$erabiltzaile_kopurua = (int)$egitura -> getElementsByTagName('kopuru')[0] -> nodeValue;
	$erabiltzaile_kopurua--;
	$egitura -> getElementsByTagName('kopuru')[0] -> nodeValue = $erabiltzaile_kopurua;
	$users = $egitura -> getElementsByTagName('erabiltzaile');
	foreach($users as $u){
		if($u -> nodeValue == $mail){
			$ezabatzeko = $u;
			$egitura -> getElementsByTagName('erabiltzaileak')[0] -> removeChild($u);
		}
	}
	$egitura -> save('../xml/counter.xml');
	header('location:layout.php');
}
?>
<style>
#msg{border:solid 2px #0055AA;background-color:#55AAFF;font-size:2em;display:none;padding:5px;position:absolute;top:250;}
#logout{width:300px;border:5px outset #555555;margin:0px auto;text-align:center;}
</style>
<div id='logout'>
<span><a href = 'logout.php?mail=<?php echo($mail);?>&irten=1'>Log Out</a></span><br/>
<hr/>
<span><a href = 'layout.php?mail=<?php echo($mail);?>'>nagusia</a><span><br/><br>
</div>
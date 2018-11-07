<?php
if(isset($_GET['mail'])){$mail = $_GET['mail'];}
else{header("location:layout.php");}
?>
<html>
<body>
<head>
<meta charset="UTF-8">
</head>
<body>
<h1>'questions.xml' fitxategiaren galderak PHPrekin</h1>
<?php
//if_exist('../xml/questions.xml'){
	$egitura = new DOMDocument();
	$egitura->load('../xml/questions.xml');
	$galderak = $egitura -> getElementsByTagName('assessmentItem');
//}
?>
<table id='galderak'>
<th scope='row'>Egilea</th><th scope='row'>Galdera<th scope='row'>Erantzuna</th></tr>
<?php
foreach($galderak as $ga){
	$a = $ga -> getAttribute('author');
	$g = $ga -> getElementsByTagName('p')[0] -> nodeValue;
	$e = $ga -> getElementsByTagName('correctResponse')[0] -> nodeValue;
	echo('<tr><td>'.$a.'</td><td>'.$g.'</td><td>'.$e.'</td></tr>');
}
?>
</table>
<a href = 'layout.php?mail=<?php echo($mail)?>'>Orri nagusia</a>
</body>
</html>

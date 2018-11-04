<?php
if(isset($_GET['mail'])){$mail = $_GET['mail'];}
else{header("location:layout.php");}
?>
<html>
<body>
<head>
<meta charset="UTF-8">
<script src="../js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	//XMl dokumentuak tabulazioak eta lerro berria ikurrak baditu...
	//galdera[i].attributes[0].nodeValue+'</td><td>'+
	//galdera[i].childNodes[1].childNodes[1].childNodes[0].nodeValue+'</td><td>'+
	//galdera[i].childNodes[3].childNodes[1].childNodes[0].nodeValue+'</td></tr>'
	var htm = '<tr><th>Egilea</th><th>Galdera</th><th>Erantzun zuzena</th></tr>';
	$.get('../xml/questionsTransAuto.xml',function(d){
		var galdera = $(d).find('assessmentItem');
		for(var i=0; i<galdera.length; i++){
			htm += '<tr><td>'+
				galdera[i].attributes[0].nodeValue+'</td><td>'+
				galdera[i].childNodes[0].childNodes[0].childNodes[0].nodeValue+'</td><td>'+
				galdera[i].childNodes[1].childNodes[0].childNodes[0].nodeValue+'</td></tr>'
		}
		htm += '</table>';
		$('#galderak').html(htm);
	});
});
</script>
</head>
<body>
<h1>'questionsTransAuto.xml' fitxategiaren galderak</h1>
<table id='galderak'></table>
<a href = 'layout.php?mail=<?php echo($mail)?>'>Orri nagusia</a>
</body>
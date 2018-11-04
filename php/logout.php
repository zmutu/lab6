<?php
if(isset($_GET['mail'])){$mail = $_GET['mail'];}
?>

<html>
<head>
<meta charset='UTF-8'>
<title>Lab 4, Log In</title>
<link rel='icon' type='image/png' href='images/fabikon.png' />
<style>
#msg{border:solid 2px #0055AA;background-color:#55AAFF;font-size:2em;display:none;padding:5px;position:absolute;top:250;}
div{width:300px;border:5px outset #555555;margin:0px auto;text-align:center;}
</style>
</head>
<body>
<div>
<p><a href = 'layout.php'>Log Out</a></span>
<hr width = '100px'/>
<span><a href = 'layout.php?mail=<?php echo($mail);?>'>nagusia</a><span><br/><br>
</div>
</body>
</html>
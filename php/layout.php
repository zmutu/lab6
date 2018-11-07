<?php
if(isset($_GET['mail'])){$mail = $_GET['mail'];}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name='tipo_contenido' content='text/html;' http-equiv='content-type' charset='utf-8'>
	<title>Quizzes</title>
    <link rel='stylesheet' type='text/css' href='../styles/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='../styles/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='../styles/smartphone.css' />
	<title>Lab 4, Formularioa</title>
	<!--
	<script src='https://code.jquery.com/jquery-3.3.1.min.js' type='text/javascript'></script>
	-->
	<script src='../js/jquery.js' type='text/javascript'></script>
  </head>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
		<?php
			if(isset($mail)){echo("<span class='right'>".$mail." ||  <a href='logout.php?mail=".$mail."'>LogOut</a> </span>");}
			else{echo("<span class='right'>anonimous || <a href='login.php'>Log In</a> || <a href='signup.php'>Sign Up</a> </span>");}
		?>
		<h2>Quiz: crazy questions</h2>
	</header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='layout.php<?php if(isset($mail)){echo("mail=".$mail);}?>'>Home</a></span>
		<span><a href='#'>Quizz</a></span>
		<?php if(isset($mail)){?>
		<span><a href='addQuestion_HTML5.php<?php if(isset($mail)){echo("?mail=".$mail);}?>'>Add question (html5)</a></span>
		<span><a href='showQuestionswithImage.php<?php if(isset($mail)){echo("?mail=".$mail);}?>'>galdera zerrenda</a></span>
		<span><a href='showXMLQuestions1.php<?php if(isset($mail)){echo("?mail=".$mail);}?>'>galdera XML (*)</a></span>
		<span><a href='showXMLQuestions2.php<?php if(isset($mail)){echo("?mail=".$mail);}?>'>galdera XML (**)</a></span>
		<span><a href='../xml/questionsTransAuto.xml'>Galderak XSL</a>
		<span><a href='../getUserInform.html'>User Info</a></span>
		<?php }?>
		<span><a href='credits.php<?php if(isset($mail)){echo("?mail=".$mail);}?>'>Credits</a></span><br/>
	</nav>
    <section class='main' id='s1'>
	<div>
	Quizzes and credits will be displayed in this spot in future laboratories ...
	</div>
    </section>
	<footer class='main' id='f1'>
		 <a href='https://github.com'>Link GITHUB</a>
	</footer>(*) -> jQueryrekin<br/>(**) -> PHPrekin<br/>
</div>
</body>
</html>

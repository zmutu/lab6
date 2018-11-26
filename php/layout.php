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
	<style>header span{color:blue;cursor:pointer;cursor:hand;}</style>
	<!--
	<script src='https://code.jquery.com/jquery-3.3.1.min.js' type='text/javascript'></script>
	-->
	<style>nav span{color:blue;cursor:hand;cursor:pointer;}</style>
	<script src='../js/jquery.js' type='text/javascript'></script>
	<script>
		var maiz1=0, maiz2=0; //setInterval funtzioa kontrolatzeko
		function berritu(n){
			clearInterval(maiz1);
			clearInterval(maiz2);
			var URL = '';
			switch(n){
				case 0: URL = 'login.php'; break;
				case 1: URL = 'signup.php'; break;
				case 2: URL = '<?php if(isset($mail)){echo('logout.php?mail=');echo($mail);}?>'; break;
				case 3: URL = '<?php if(isset($mail)){echo('handlingQuizesAJAX.php?mail='.$mail);}?>'; break;
			}
			$.ajax({
				url:URL,
				dataType:'text',
				success:function(em){$('#gorputza').html(em);}
			});
		}
	</script>
  </head>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
		<?php
			if(isset($mail)){echo("<span class='right'>".$mail." || <span onclick='berritu(2)'> LogOut </span>");}
			else{echo("<span class='right'>anonimous </span> || <span onclick='berritu(0)'>Log In</span> || <span onclick='berritu(1)'> Sign Up </span>");}
		?>
		<h2>Quiz: crazy questions</h2>
	</header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='layout.php<?php if(isset($mail)){echo("?mail=".$mail);}?>'>Home</a></span>
		<span><a href='#'>Quizz</a></span>
		<?php if(isset($mail)){?>
		<span onclick='berritu(3)'>Derrigorrezkoa</span>
		<?php }?>
		<span><a href='credits.php<?php if(isset($mail)){echo("?mail=".$mail);}?>'>Credits</a></span><br/>
	</nav>
    <section class='main' id='s1'>
	<div id='gorputza'>
	Quizzes and credits will be displayed in this spot in future laboratories ...
	</div>
    </section>
	<footer class='main' id='f1'>
		 <a href='https://github.com'>Link GITHUB</a>
	</footer>
</div>
</body>
</html>
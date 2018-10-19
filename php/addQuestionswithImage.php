<?php
//datu guztiak jaso
if(isset($_GET['mail'])){$mail=$_GET['mail'];}
if(isset($_GET['galdera'])){$galdera=$_GET['galdera'];}
if(isset($_GET['zuzena'])){$zuzena=$_GET['zuzena'];}
if(isset($_GET['erantzunokerra1'])){$erantzunokerra1=$_GET['erantzunokerra1'];}
if(isset($_GET['erantzunokerra2'])){$erantzunokerra2=$_GET['erantzunokerra2'];}
if(isset($_GET['erantzunokerra3'])){$erantzunokerra3=$_GET['erantzunokerra3'];}
if(isset($_GET['zailtasuna'])){$zailtasuna=$_GET['zailtasuna'];}
if(isset($_GET['gaia'])){$gaia=$_GET['gaia'];}
//if(isset($_GET[''])){$=$_GET[''];}
echo($mail.'<br/>'.$galdera.'<br/>'.$zuzena.'<br/>'.$erantzunokerra1.'<br/>'.$erantzunokerra2.'<br/>'.$erantzunokerra3.'<br/>'.$zailtasuna.'<br/>'.$gaia.'<hr>');
//daturen bat falta den aztertu
if($mail==''||$galdera==''||$zuzena==''||$erantzunokerra1==''||$erantzunokerra2==''||$erantzunokerra3==''||$zailtasuna==''||$gaia==''){
	header("location:mezua.php=goiburu=Errorea!!&gorputza=Ez dira datu guztiak jaso&auk=<a href='addQuestion.html'>Idatzi beste galdera bat</a>"); 
}
//mysql-rekin konexioa egin
if(!$konexioa=new mysqli("127.0.0.1","root","5artu")){
//if(!$konexioa=new mysqli("zerbitzaria","erabiltzailea","pasahitza")){
	header("location:mezua.php=goiburu=Errorea!!&gorputza=ez da konexioa lortu<br/>".$konexioa->error."&auk=<a href='addQuestion.html'>Idatzi beste galdera bat</a>");
}
else{echo("konexioa ezarri da<br/>");}
//datu-basea aukeratu
//if(!($konexioa->select_db('Quiz'))){
if(!($konexioa->select_db('datu-basea'))){
	header("location:mezua.php=goiburu=Errorea!!&gorputza=ezin da taula lortu<br/>".$konexioa->error."&auk=<a href='addQuestion.html'>Idatzi beste galdera bat</a>");
}
//sql kontsulta sortu
$sql="insert into Questions(mail,galdera,erantzun_zuzena,erantzun_okerra_1,erantzun_okerra_2,erantzun_okerra_3,zailtasuna,gaia) values('".$mail."','".$galdera."','".$zuzena."','".$erantzunokerra1."','".$erantzunokerra2."','".$erantzunokerra3."',".$zailtasuna.",'".$gaia."')";
echo("<br/>".$sql."<br/>");
//sql kontsulta exekutatu
if(!($emaitza=$konexioa->query($sql))){
	header("location:mezua.php=goiburu=Errorea!!&gorputza=SQL kontsulta ez da exekutatu<br/>".$konexioa->error."&auk=<a href='addQuestion.html'>Idatzi beste galdera bat</a>");
}
//konexioa itxi
$konexioa->close();
header("location:mezua.php?goiburu=Eskaera gauzatu da&gorputza=Bidalitako datuak batu-basean ongi gorde dira&auk=<a href='showQuestions.php'>Ikusi galdera guztiak</a>");
exit();
/**
 * subir_fichero()
 *
 * Sube una imagen al servidor  al directorio especificado teniendo el Atributo 'Name' del campo archivo.
 *
 * @param string $directorio_destino Directorio de destino dónde queremos dejar el archivo
 * @param string $nombre_fichero Atributo 'Name' del campo archivo
 * @return boolean
 */
function subir_fichero($directorio_destino, $nombre_fichero){
	$tmp_name = $_FILES[$nombre_fichero]['tmp_name'];
	//si hemos enviado un directorio que existe realmente y hemos subido el archivo    
	if (is_dir($directorio_destino) && is_uploaded_file($tmp_name))    {
		$img_file = $_FILES[$nombre_fichero]['name'];
		$img_type = $_FILES[$nombre_fichero]['type'];
		echo 1;
		// Si se trata de una imagen   
		if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") ||
		strpos($img_type, "jpg")) || strpos($img_type, "png"))){
			//¿Tenemos permisos para subir la imágen?
			echo 2;
			if (move_uploaded_file($tmp_name, $directorio_destino . '/' . $img_file)){
				return true;
			}
		}
	}
	//Si llegamos hasta aquí es que algo ha fallado
	return false;
}
?>

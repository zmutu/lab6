<?php
if(isset($_GET['goiburu'])){$goiburu=$_GET['goiburu'];}
if(isset($_GET['gorputza'])){$gorputza=$_GET['gorputza'];}
if(isset($_GET['auk'])){$auk=$_GET['auk'];}
echo('<html><style>h1,p{align:center;padding:25px;text-align:center;}</style><body><h1>'.$goiburu.'</h1><p>'.$gorputza.'</p><p>'.$auk.'</p></body></html>');
?>
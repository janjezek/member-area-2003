<?php
$dbhost = 'mysql.webzdarma.cz';
$dbusername = 'post2';
$dbpasswd = '198666';
$database_name = 'post2';

$connection = mysql_pconnect("$dbhost","$dbusername","$dbpasswd")
  or die ("Nen� mo�n� p�ipojit datab�zov� server.");

$db = mysql_select_db("$database_name", $connection)
  or die("Nen� mo�n� vybrat datab�zi.");
?>

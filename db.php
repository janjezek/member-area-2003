<?php
$dbhost = 'mysql.webzdarma.cz';
$dbusername = 'post2';
$dbpasswd = '198666';
$database_name = 'post2';

$connection = mysql_pconnect("$dbhost","$dbusername","$dbpasswd")
  or die ("Není možné pøipojit databázový server.");

$db = mysql_select_db("$database_name", $connection)
  or die("Není možné vybrat databázi.");
?>

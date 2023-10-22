<?php
include 'db.php';

$userid = $_REQUEST['id'];
$code = $_REQUEST['code'];

$sql = mysql_query("UPDATE users SET activated='1' WHERE userid='$userid' AND password='$code'");

$sql_doublecheck = mysql_query("SELECT * FROM users WHERE userid='$userid' AND password='$code' AND activated='1'");
$doublecheck = mysql_num_rows($sql_doublecheck);

include 'funkce.php';

if($doublecheck == 0){
  zacatek("Chyba!");
  echo "<p><b>Váš úèet nebyl aktivován!</b></p>";
  konec();
} elseif ($doublecheck > 0) {
  zacatek("Pøihlášení");
  echo "<p><b>Váš úèet byl aktivován!</b> Pøihlašte se prosím!</p>";
  form();
  konec();
}

?>
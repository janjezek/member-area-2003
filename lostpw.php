<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Ztr�ta hesla</title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>

<body>

<?php
include 'db.php';

function formular()
{
?>
<form method="post" action="lostpw.php">
  <table width="50%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td>Va�e emailov� adresa:</td>
      <td><input name="email_address" type="text"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
        <input type="hidden" name="recover" value="recover">
        <input type="submit" name="Submit" value="Odeslat heslo!">
      </td>
    </tr>
  </table>
</form>

</body>
</html>
<?php
}

switch($_POST['recover']){
  default:
  formular();
  break;

  case "recover":
  recover_pw($_POST['email_address']);
  break;
}

function recover_pw($email_address){
  if(!$email_address){
    echo "<p>Chyb� emailov� adresa!</p>";
    formular();
    exit();
  }

  $sql_check = mysql_query("SELECT * FROM users WHERE email_address='$email_address'");
  $sql_check_num = mysql_num_rows($sql_check);
  if($sql_check_num == 0){
    echo "<p>Emailov� adresa nen� v datab�zi!</p>";
    formular();
    exit();
  }

  function makeRandomPassword() {
      $salt = "abchefghjkmnpqrstuvwxyz0123456789";
      srand((double)microtime()*1000000);
      $i = 0;
      while ($i <= 7) {
          $num = rand() % 33;
          $tmp = substr($salt, $num, 1);
          $pass = $pass . $tmp;
          $i++;
      }
      return $pass;
  }

  $random_password = makeRandomPassword();

  $db_password = md5($random_password);

  $sql = mysql_query("UPDATE users SET password='$db_password' WHERE email_address='$email_address'");

  $subject = "Nov� heslo!";
  $message = "Dobr� den,

  va�e nov� heslo je: $random_password

  http://www.domena.cz/login.php

  S pozdravem
  Webmaster

  Toto je automaticky sestaven� email. Pros�m neodpov�dejte na n�j!";

  mail($email_address, $subject, $message, "From: Webmaster<admin@domena.cz>\nX-Mailer: PHP/" . phpversion());
  echo "<p>Byl odesl�n email s nov�m heslem!</p>";
  formular();
}
?>

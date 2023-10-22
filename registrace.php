<?php
function formular() {
?>
<form method="post" action="registrace.php">
  <table width="100%" border="0" cellpadding="4" cellspacing="0">
    <tr>
      <td width="24%" align="left" valign="top">Køestní jméno</td>
      <td width="76%"><input name="first_name" type="text"></td>
    </tr>
    <tr>
      <td align="left" valign="top">Pøíjmení</td>
      <td><input name="last_name" type="text"></td>
    </tr>
    <tr>
      <td align="left" valign="top">Email</td>
      <td><input name="email_address" type="text"></td>
    </tr>
    <tr>
      <td align="left" valign="top">Pøihlašovací jméno</td>
      <td><input name="username" type="text"></td>
    </tr>
    <tr>
      <td align="left" valign="top">Informace o vás</td>
      <td><textarea name="info"></textarea></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td><input type="submit" name="submit" value="Registrovat"></td>
    </tr>
  </table>
</form>
<?php
}

function konec() {
?>
</body>
</html>
<?php 
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
  <title>Registraèní formuláø</title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>

<body>

<?php
if (isset($submit)) {
include 'db.php';

// definice promìnných

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email_address = $_POST['email_address'];
$username = $_POST['username'];
$info = $_POST['info'];

$first_name = stripslashes($first_name);
$last_name = stripslashes($last_name);
$email_address = stripslashes($email_address);
$username = stripslashes($username);
$info = stripslashes($info);

// kontrola vyplnìní údajù

if((!$first_name) || (!$last_name) || (!$email_address) || (!$username)){
  echo '<b>Bìhem registrace nastaly tyto chyby:</b><br>';
  echo '<ul>';
  if(!$first_name){
    echo "<li>Chybí køestní jméno!</li>";
  }
  if(!$last_name){
    echo "<li>Chybí pøíjmení!</li>";
  }
  if(!$email_address){
    echo "<li>Chybí emailová adresa!</li>";
  }
  if(!$username){
    echo "<li>Chybí pøihlašovací jméno!</li>";
  }
  echo '</ul>';
  formular();
  konec();
  exit();
}

// kontrola emailu a jména v DB

 $sql_email_check = mysql_query("SELECT email_address FROM users WHERE email_address='$email_address'");
 $sql_username_check = mysql_query("SELECT username FROM users WHERE username='$username'");

 $email_check = mysql_num_rows($sql_email_check);
 $username_check = mysql_num_rows($sql_username_check);

 if(($email_check > 0) || ($username_check > 0)){
   echo "<b>Omlouváme se ale:</b><br>";
   echo "<ul>";
   if($email_check > 0){
     echo "<li>Uvedená emailová adresa se již v databázi vyskytuje!</li>";
     unset($email_address);
   }
   if($username_check > 0){
     echo "<li>Uvedené pøihlašovací jméno je již používáno!</li>";
     unset($username);
   }
   echo "</ul>";
   formular();
   konec();
   exit();
 }

// všechny údaje jsou zkontrolovány

// vygenerujeme heslo

function password() {
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

$random_password = password();

$db_password = md5($random_password);

// vložní údajù do DB

$info2 = htmlspecialchars($info);
$sql = mysql_query("INSERT INTO users (first_name, last_name, email_address, username, password, info, signup_date)
    VALUES('$first_name', '$last_name', '$email_address', '$username', '$db_password', '$info2', now())") or die (mysql_error());

if(!$sql){
  echo '<p>Pøi vytváøení vyšeho úètu nastala neoèekávaná chyba.</p>';
} else {
  $userid = mysql_insert_id();
  $subject = "Registrace";
  $message = "Dobrý den,

  dìkuji za registraci na stránkách http://www.domena.cz!

  Pro aktivaci vašeho úètu musíte navštívit tuto adresu:

  http://www.domena.cz/aktivace.php?id=$userid&code=$db_password

  Po aktivaci se budete moci pøihlašovat pomocí následujících údajù:

  Jméno: $username
  Heslo: $random_password

  Dìkuji!
  Webmaster

  Toto je automoaticky sestavený email, prosím neodpovídejte na nìj!";

  mail($email_address, $subject, $message, "From: Webmaster<admin@domena.cz>\nX-Mailer: PHP/" . phpversion());
  echo '<p>Informace byly zaslány na vaší emailovou adresu. Po pøeètení emailu prosím dokonèete registraci.</p>';
  konec();
}
} else {
formular();
konec();
}
?>
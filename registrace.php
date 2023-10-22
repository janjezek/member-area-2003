<?php
function formular() {
?>
<form method="post" action="registrace.php">
  <table width="100%" border="0" cellpadding="4" cellspacing="0">
    <tr>
      <td width="24%" align="left" valign="top">K�estn� jm�no</td>
      <td width="76%"><input name="first_name" type="text"></td>
    </tr>
    <tr>
      <td align="left" valign="top">P��jmen�</td>
      <td><input name="last_name" type="text"></td>
    </tr>
    <tr>
      <td align="left" valign="top">Email</td>
      <td><input name="email_address" type="text"></td>
    </tr>
    <tr>
      <td align="left" valign="top">P�ihla�ovac� jm�no</td>
      <td><input name="username" type="text"></td>
    </tr>
    <tr>
      <td align="left" valign="top">Informace o v�s</td>
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
  <title>Registra�n� formul��</title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>

<body>

<?php
if (isset($submit)) {
include 'db.php';

// definice prom�nn�ch

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

// kontrola vypln�n� �daj�

if((!$first_name) || (!$last_name) || (!$email_address) || (!$username)){
  echo '<b>B�hem registrace nastaly tyto chyby:</b><br>';
  echo '<ul>';
  if(!$first_name){
    echo "<li>Chyb� k�estn� jm�no!</li>";
  }
  if(!$last_name){
    echo "<li>Chyb� p��jmen�!</li>";
  }
  if(!$email_address){
    echo "<li>Chyb� emailov� adresa!</li>";
  }
  if(!$username){
    echo "<li>Chyb� p�ihla�ovac� jm�no!</li>";
  }
  echo '</ul>';
  formular();
  konec();
  exit();
}

// kontrola emailu a jm�na v DB

 $sql_email_check = mysql_query("SELECT email_address FROM users WHERE email_address='$email_address'");
 $sql_username_check = mysql_query("SELECT username FROM users WHERE username='$username'");

 $email_check = mysql_num_rows($sql_email_check);
 $username_check = mysql_num_rows($sql_username_check);

 if(($email_check > 0) || ($username_check > 0)){
   echo "<b>Omlouv�me se ale:</b><br>";
   echo "<ul>";
   if($email_check > 0){
     echo "<li>Uveden� emailov� adresa se ji� v datab�zi vyskytuje!</li>";
     unset($email_address);
   }
   if($username_check > 0){
     echo "<li>Uveden� p�ihla�ovac� jm�no je ji� pou��v�no!</li>";
     unset($username);
   }
   echo "</ul>";
   formular();
   konec();
   exit();
 }

// v�echny �daje jsou zkontrolov�ny

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

// vlo�n� �daj� do DB

$info2 = htmlspecialchars($info);
$sql = mysql_query("INSERT INTO users (first_name, last_name, email_address, username, password, info, signup_date)
    VALUES('$first_name', '$last_name', '$email_address', '$username', '$db_password', '$info2', now())") or die (mysql_error());

if(!$sql){
  echo '<p>P�i vytv��en� vy�eho ��tu nastala neo�ek�van� chyba.</p>';
} else {
  $userid = mysql_insert_id();
  $subject = "Registrace";
  $message = "Dobr� den,

  d�kuji za registraci na str�nk�ch http://www.domena.cz!

  Pro aktivaci va�eho ��tu mus�te nav�t�vit tuto adresu:

  http://www.domena.cz/aktivace.php?id=$userid&code=$db_password

  Po aktivaci se budete moci p�ihla�ovat pomoc� n�sleduj�c�ch �daj�:

  Jm�no: $username
  Heslo: $random_password

  D�kuji!
  Webmaster

  Toto je automoaticky sestaven� email, pros�m neodpov�dejte na n�j!";

  mail($email_address, $subject, $message, "From: Webmaster<admin@domena.cz>\nX-Mailer: PHP/" . phpversion());
  echo '<p>Informace byly zasl�ny na va�� emailovou adresu. Po p�e�ten� emailu pros�m dokon�ete registraci.</p>';
  konec();
}
} else {
formular();
konec();
}
?>
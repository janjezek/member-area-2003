<?php
session_start();

include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

include 'funkce.php';

if((!$username) || (!$password)){
  zacatek("Pøihlášení");
  echo "<p>Prosím vložte všechny povinné údaje!</p>";
  form();
  konec();
  exit();
}

$password = md5($password);

$sql = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$password' AND activated='1'");
$login_check = mysql_num_rows($sql);

if($login_check > 0){
  while($row = mysql_fetch_array($sql)){
  foreach( $row AS $key => $val ){
    $$key = stripslashes( $val );
  }

    session_register('first_name');
    $_SESSION['first_name'] = $first_name;
    session_register('last_name');
    $_SESSION['last_name'] = $last_name;
    session_register('email_address');
    $_SESSION['email_address'] = $email_address;
    session_register('special_user');
    $_SESSION['user_level'] = $user_level;

    mysql_query("UPDATE users SET last_login=now() WHERE userid='$userid'");

    header("Location: main.php");
  }
} else {
  zacatek("Pøihlášení");
  echo "<p>Nemùžete se pøihlásit! Nesouhlasí jméno a heslo nebo váš úèet není aktivován! Zkuste to prosím znovu!";
  form();
  konec();
}
?>
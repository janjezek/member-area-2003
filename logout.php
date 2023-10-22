<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Členská oblast</title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>

<body>

<?php
session_start();

session_destroy();
if(!session_is_registered('first_name')){
  echo "<p><b>Jste odhlášeni!</b></p>";
  echo "<p>Znovu se můžete přihlásit <a href=\"login.php\">zde</a>.</p>";
}
?>

</body>
</html>
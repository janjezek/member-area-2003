<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Členská oblast</title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>

<body>

<?php
session_start();

echo "<p>Vítejte! Přihlásili jste se do členské oblasti pod jménem ". $_SESSION['first_name'] ." ". $_SESSION['last_name'] .".</p>";

echo "<p>Váš uživatelský level je ". $_SESSION['user_level'].". To vás opravňuje k přístupu do následujích oblastí:</p>";

if($_SESSION['user_level'] == 0){
  echo "- Forum<br>- Chat<br>";
}
if($_SESSION['user_level'] == 1){
  echo "- Forum<br>- Chat<br>- Administrace<br>";
}

echo "<br><a href=\"logout.php\">Odhlásit</a>";
?>

</body>
</html>
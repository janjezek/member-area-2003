<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>�lensk� oblast</title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>

<body>

<?php
session_start();

echo "<p>V�tejte! P�ihl�sili jste se do �lensk� oblasti pod jm�nem ". $_SESSION['first_name'] ." ". $_SESSION['last_name'] .".</p>";

echo "<p>V� u�ivatelsk� level je ". $_SESSION['user_level'].". To v�s oprav�uje k p��stupu do n�sleduj�ch oblast�:</p>";

if($_SESSION['user_level'] == 0){
  echo "- Forum<br>- Chat<br>";
}
if($_SESSION['user_level'] == 1){
  echo "- Forum<br>- Chat<br>- Administrace<br>";
}

echo "<br><a href=\"logout.php\">Odhl�sit</a>";
?>

</body>
</html>
<?php
function zacatek($hlaska)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title><?php echo $hlaska;?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>

<body>
<?php
}

function form()
{
?>
<form action="kontrola.php" method="post">
  <table width="50%" border="0" align="center" cellpadding="4" cellspacing="0">
    <tr>
      <td width="22%">Přihlašovací jméno</td>
      <td width="78%"><input name="username" type="text"></td>
    </tr>
    <tr>
      <td>Heslo</td>
      <td><input name="password" type="password"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Přihlásit"></td>
    </tr>
  </table>
</form>
<?php
}

function konec()
{
?>
</body>
</html>
<?php
}
?>
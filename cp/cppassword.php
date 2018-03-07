<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: cppassword.php
-----------------------------------------------------
 Назначение: Изменить логин/пароль
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$password_ch_help;

$title_cp = 'Изменить логин/пароль - ';
$speedbar = ' | <a href="cppassword.php">Изменить логин/пароль</a>';

check_login_cp('4_3','cppassword.php');

require_once 'template/header.php';

table_item_top ('Изменить логин/пароль контрагента','rootpassword.png');

if (!$_GET[REQ])
{

table_fdata_top ('Укажите новые данные');

?>

<form name=upview action="?REQ=uppassword" method=post>
<table width="500" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="155" height="22" align="right">ID компании</td>
    <td width="345" height="22" align="left"><input name="ID_firm" type="text" size="10" /></td>
  </tr>
  <tr>
    <td height="22" align="right">Новый логин</td>
    <td height="22" align="left"><input type="text" name="New_login" /></td>
  </tr>
  <tr>
    <td height="22" align="right">Новый пароль</td>
    <td height="22" align="left"><input type="text" name="New_password" /></td>
  </tr>
  <tr>
    <td height="22">&nbsp;</td>
    <td height="22" align="left"><input type="submit" name="button" id="button" value="Изменить данные" /></td>
  </tr>
</table>
</form>
<br />

<?

table_fdata_bottom();

}

else

{

$new_login=trim($_POST[New_login]);
$new_password=trim($_POST[New_password]);
$new_password1=md5($new_password);
$id_firm=intval($_POST[ID_firm]);

if (($id_firm==0) or ($new_login=="") or ($new_password=="")) $error_data = "Не верно указанны введенные данные.";

$lr = $db->query  ( "SELECT selector FROM $db_users WHERE login='$new_login'" );

	$lf=$db->fetcharray($lr);

	$logins = mysql_num_rows ( $lr );

	$db->freeresult  ( $lr );

if (($logins > 0) and ($lf[selector]!=$id_firm) ) $error_data = "Пользователь с таким логином уже существует.";


if (!isset($error_data)) {

$r=$db->query ("SELECT login, pass, firmname, selector FROM $db_users WHERE selector=$id_firm") or die (mysql_error());

$f=$db->fetcharray($r);

if ($f[selector]==$id_firm) {

if ($_GET[REQ]=="uppassword")

{

$db->query ("UPDATE $db_users SET login='$new_login', pass='$new_password1' WHERE selector=$id_firm") or die (mysql_error());

logsto("Изменение логина/пароля фирмы - $f[firmname] [id=$_POST[ID_firm]]");

table_fdata_top ($def_item_new_data);

echo "<br />Компания - <b>$f[firmname]</b><br /><br />";
echo "ID - <b>$_POST[ID_firm]</b><br /><br />";
echo "Новый логин: <b>$new_login</b><br /><br />";
echo "Новый пароль: <b>$new_password</b><br /><br />";

table_fdata_bottom();

}

} else  msg_text('80%',$def_admin_message_error,'Указанный ID в базе не найден.');

} else  msg_text('80%',$def_admin_message_error,$error_data);

}

require_once 'template/footer.php';

?>


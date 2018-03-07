<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: auth.php
-----------------------------------------------------
 Назначение: Форма авторизации
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

session_start();

$_SESSION = array();

$_SESSION['random'] = mt_rand(1000000,9999999);

$rand = mt_rand(1, 999);


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Авторизация в личном кабинете клиента каталога</title>
<link rel="icon" href="<? echo $def_mainlocation; ?>/users/template/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<? echo $def_mainlocation; ?>/users/template/images/favicon.ico" type="image/x-icon" />
<link href="<? echo "$def_mainlocation"; ?>/users/template/css/style.css" rel="stylesheet" type="text/css">
<link href="<? echo $def_mainlocation; ?>/users/template/css/bootstrap.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="2" bgcolor="#E95D0F"></td>
  </tr>
    <tr>
    <td height="25" align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/bg_top.gif" bgcolor="#0363AD" class="copy" style="padding-right:10px;"><? echo "$def_title"; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/up_logo.gif" alt="Личный кабинет" width="270" height="88"></td>
        <td width="50%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td align="center">

<?php

if (isset($error_auth)) {

if ($error_auth==1) {

$error_msg= "
        <td style=\"padding-left:10px;\" align=\"left\"><strong>Ошибка</strong><br>
          Неверное имя пользователя или пароль <br>
          Проверьте правильность написания имени пользователя. <br>
          Убедитесь, что пароль вводится на том же языке, что и при регистрации. <br>
          Посмотрите, не нажат ли [Caps Lock].</td>
";

}

if ($error_auth==2) {

$error_msg= "
        <td style=\"padding-left:10px;\" align=\"left\"><strong>Извините!</strong><br>
          Ваши регистрационные данные еще <br>
          не проверены администратором каталога. <br>
          Попробуйте зайти позже. <br>
	</td>
";

}

if ($error_auth==3) {

$error_msg= "
        <td style=\"padding-left:10px;\" align=\"left\"><strong>Ошибка!</strong><br>
          Код безопасности <br>
          не соответствует отображённому! <br>
	</td>
";

}

if ($error_auth==4) {

$error_msg= "
        <td style=\"padding-left:10px;\" align=\"left\">$def_mail_ok<br>
	</td>
";
}

if ($error_auth==5) {

$error_msg= "
        <td style=\"padding-left:10px;\" align=\"left\">$def_mail_ok_not<br>
	</td>
";

}

?>

<table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3" bgcolor="#E95D0F">&nbsp;</td>
	<?php echo "$error_msg"; ?>
      </tr>
      <tr>
        <td width="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>

<?php
}
?>
    </td>
  </tr>
  <tr>
    <td align="center">
<form name=login action="?REQ=authorize" method=post>
    <table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="27" colspan="2" align="left" class="id_url">Авторизация</td>
        </tr>
      <tr>
        <td width="150" height="25" align="right">Логин:&nbsp;</td>
        <td align="left"><input type="text" name="login" style="width:350px;" maxlength=120></td>
      </tr>
      <tr>
        <td width="150" height="25" align="right">Пароль:&nbsp;</td>
        <td align="left"><input type="password" name="pass" style="width:350px;" maxlength=120></td>
      </tr>
      <tr>
        <td width="150" height="25" align="right"><img src="../security.php?<? echo $rand;?>">&nbsp;</td>
        <td align="left"><input type="text" name="security" style="width:350px;" maxlength=120></td>
      </tr>
<script type="text/javascript"><!--
document.login.login.focus();
//--></script>
      <tr>
        <td width="150">&nbsp;</td>
        <td align="left"><input type=submit value="<?php echo "$def_enter";?>" name="inbut"></td>
      </tr>
      <tr>
        <td colspan="2"><a href="<? echo"$def_mainlocation"; ?>/remind.php">Напомнить пароль</a></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="txt">Для входа в систему введите, пожалуйста, логин и пароль. Если у Вас еще нет логина, Вам необходимо <a href="<? echo"$def_mainlocation"; ?>/reg.php">зарегистрироваться</a>.</td>
        </tr>
    </table>
</form>
</td>
  </tr>
  <tr>
    <td height="100">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" align="center" background="<? echo "$def_mainlocation"; ?>/users/template/images/bg_top.gif" bgcolor="#0A4E9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="200" align="center"><a href="http://vkaragande.info/" target="_blank" class="copy">&copy; I-Soft Bizness 2016</a></td>
        <td align="center" class="copy"><a href="<? echo"$def_mainlocation"; ?>/index.php" class="copy">Главная</a> | <a href="<? echo"$def_mainlocation"; ?>/reg.php" class="copy">Регистрация</a> | <a href="<? echo"$def_mainlocation"; ?>/contact.php" class="copy">Администрация</a></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

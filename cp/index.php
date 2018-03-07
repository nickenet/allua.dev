<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: index.php
-----------------------------------------------------
 Назначение: Главная страница
=====================================================
*/

session_start();

require_once './defaults.php';

if ($_GET["REQ"] == "auth")

{
	if (!isset($_SESSION["adm_ident"]))

	{
		session_start();

		$vid_login = trim(htmlspecialchars(strip_tags($_POST["login"])));
		$vid_password = trim(htmlspecialchars(strip_tags($_POST["pass"])));

		if ($vid_login!='' and $vid_password!='') {

			$_SESSION["admin_login"] = $vid_login;
			$_SESSION["admin_pass"] = md5($vid_password);
			$_SESSION["adm_ident"] = time();
		}
	}
      
check_login_cp('0_1','main.php');

    if ($_POST['url_go']!='') { $url_go=$_POST['url_go']; header('Location: '.$url_go); }

    if ($_POST["first"] == "yes") logsto($def_admin_log_enter);

$help_section = (string)$index_help;

require_once 'inc/cron.php';

require_once 'template/header.php';

require_once 'template/top_wt.php';

require_once 'template/part.php';

require_once 'template/footer.php';

}

else {

// Авторизация

 if (isset($_SESSION['url'])) $url_go=$_SESSION['url']; else $url_go='';
 $_SESSION = array();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>CP - авторизация</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

<style type="text/css">
<!--
body,td,th {
	font-family: tahoma;
	font-size: 11px;
}
#example {
	  position:absolute;
	  top:40%;
	  left:50%;
	  width:400px;
	  height:300px;
	  margin-left:-125px;
	  margin-top:-100px;
	}
#textfield {
	border: 1px solid #A69BA0;
	font-family: tahoma;
	font-size: 11px;
	background-color: #FAFAFA;
	width: 150px;
	padding: 1px;
}
#but_to {
	background-color: #EFEDEE;
	padding: 1px;
	border: 1px solid #A69BA0;
	font-family: tahoma;
	font-size: 11px;
	height: 22px;
	width: 70px;
}
a:link {
	color: #999999;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #999999;
}
a:hover {
	text-decoration: underline;
	color: #333333;
}
a:active {
	text-decoration: none;
	color: #999999;
}
-->
</style>
</head>

<body>
<form name="login" action="index.php?REQ=auth" method="post">
<div id="example">
<table width="400" height="300" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>&nbsp;</td>
		<td><a href="http://vkaragande.info/" target="_blank"><img src="images/autoriz_02.jpg" alt="I-Soft Bizness" width="147" height="30" border="0"></a></td>
	</tr>
	<tr>
		<td><img src="images/autoriz_03.jpg" width="253" height="63" alt="cp"></td>
		<td><img src="images/autoriz_04.jpg" width="147" height="63"></td>
	</tr>
	<tr>
		<td><img src="images/autoriz_05.jpg" width="253" height="37" alt="Авторизация"></td>
		<td><img src="images/autoriz_06.jpg" width="147" height="37"></td>
	</tr>
	<tr>
		<td height="124" align="right" background="images/autoriz_07.jpg"><table width="220" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="15" align="left"><? echo $def_admin_login; ?>:</td>
          </tr>
          <tr>
            <td align="left"><input type="text" name="login" id="textfield" maxlength="20"></td>
<script type="text/javascript"><!--
document.login.login.focus();
//--></script>
          </tr>
          <tr>
            <td height="15" align="left"><? echo $def_admin_password; ?>:</td>
          </tr>
          <tr>
            <td align="left"><input type="password" name="pass" id="textfield" maxlength="20"></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
          </tr>
          <tr>
            <td align="left"><input type="hidden" name="first" value="yes"><input type="hidden" name="url_go" value="<? echo $url_go; ?>"><input type="submit" value="<? echo"$def_admin_enter";?>" name="inbut" id="but_to"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>          
        </table></td>
		<td rowspan="2"><img src="images/autoriz_08.jpg" width="147" height="170"></td>
	</tr>
	<tr>
		<td><img src="images/autoriz_09.jpg" width="253" height="46"></td>
	</tr>
</table>
</div>
</form>
</body>
</html>

<?

}

?>
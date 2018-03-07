<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: header.php
-----------------------------------------------------
 Назначение: Шапка CP
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">
<head>
	<title><? echo $title_cp; ?>CP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <link media="screen" href="template/style.css" type="text/css" rel="stylesheet" />
        <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	<script type="text/javascript" src="../includes/js/jquery.js"></script>	
	<script type="text/javascript" src="inc/lib_help.js"></script>
</head>
<body>
<form action="offers.php?REQ=auth" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="457" rowspan="4"><img src="images/header_01.jpg" alt="CP" width="457" height="150" /></td>
    <td rowspan="4" background="images/header_02.jpg">&nbsp;</td>
    <td width="550" height="42" background="images/header_03.jpg" align="right"><table width="133" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%" align="left" class="vlink"><a href="../index.php" target="_blank">каталог</a></td>
        <td align="left"  class="vlink"><a href="../index.php?OUT=logout">выход</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="39" background="images/header_04.jpg"><div style="text-align:right; padding-right:40px;"><?php echo $_SESSION['admin_login']; ?></div></td>
  </tr>
  <tr>
    <td height="31" background="images/header_05.jpg">
	<div style="text-align:right; padding-right:10px;">
	      	      <input type="text" name="idident" style="border-color: #0072c0; background-color:#95c4ef; width:50px;"/>
	      <input type="submit" name="button" value="id" style="border-color: #0072c0; background-color:#95c4ef; padding: 3px;"/>
	</div>
    </td>
  </tr>
  <tr>
    <td width="550" height="38" background="images/header_06.jpg" align="left">
	<ul class="topnav">
            <li><a href="./index.php?REQ=auth">Главная</a></li>
            <li><a href="./main.php">Разделы</a>
                <ul class="subnav"><? echo $_SESSION['menu']; ?></ul>
            </li>
            <li><a href="upgrade.php">Обновление</a><img src="images/update.png" align="absmiddle" alt="Обновление" /></li>
            <li><a href="http://vkaragande.info/index.php?do=feedback">Контакты</a></li>
	    <li><a id="help_link" href="javascript:;">Помощь</a><img src="images/help.png" align="absmiddle" alt="Помощь" /></li>
        </ul>
    </td>
  </tr>
</table>
	<div>
		<div id="help_content" class="hh" style="background-color:#fefdea; border: 1px solid #d7d6ba; padding:10px; text-align:left;">
			<a id="help_close" href="javascript:;" style="float: right" class="closed">Всё понятно. Закрыть[X]</a>
			<? echo $help_section; ?>
		</div>
	</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="1" bgcolor="#000000"></td>
  </tr>
  <tr>
    <td height="29" background="images/bg_top_line.gif" class="speedbar"><? require_once 'inc/speedbar.php'; ?></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
</form>

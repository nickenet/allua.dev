<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: cpcache.php
-----------------------------------------------------
 Назначение: Очистка кэша
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$cache_help;

$title_cp = 'Очистка кэша - ';
$speedbar = ' | <a href="cpcache.php">Очистка кэша</a>';

check_login_cp('4_1','cpcache.php');

require_once 'template/header.php';

?>

<table width="100%" border="0">
  <tr>
    <td><img src="images/cache.png" width="32" height="32" align="absmiddle" /><span class="maincat"><? echo $def_admin_cache; ?></span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3"><img src="images/button-l.gif" width="3" height="34" /></td>
        <td background="images/button-b.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" /></td>
            <td width="240" class="vclass"><img src="images/delactiv.gif" width="31" height="31" align="absmiddle" /><a href="?REQ=all"><? echo $def_admin_cache_empty_all; ?></a></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>

<?

$files_cache=array("../system/cache.dat", "../system/irss.dat", "../system/kurs.dat","../system/horo.dat");

if ($_GET['REQ']=='empty') 

{

$ar_cache=$_POST['name_cache'];

$file_empty_cache=$files_cache[$ar_cache];

if (file_exists($file_empty_cache)) {

	empty_cache($file_empty_cache);

	$yes_empty=$file_empty_cache;
	$yes_empty.= $def_admin_cache_ok;

	msg_text('80%',$def_admin_message_ok,$yes_empty);

}

else {

	$no_empty=$file_empty_cache;
	$no_empty.= $def_admin_cache_no;

	msg_text('80%',$def_admin_message_error,$no_empty);

}

}


if ($_GET['REQ']=='all') 

{

foreach ($files_cache as $fvalue) {

	if (file_exists($fvalue)) {

		empty_cache($fvalue);
	}
}

	msg_text('80%',$def_admin_message_ok,$def_admin_cache_yes_all);

}


?>

<br />
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files"><? echo $def_admin_cache_1; ?></td>
        <td width="150" id="table_files_c"><? echo $def_admin_cache_2; ?></td>
        <td id="table_files"><? echo $def_admin_cache_3; ?></td>
      </tr>
        <tr>
          <td width="250" id="table_files_i">Информационные блоки</td>
          <td width="150" class="blue_txt" id="table_files_i_c"><? echo $files_cache[0]; ?></td>
          <td id="table_files_i"><form action="?REQ=empty" method="post"><input type="submit" name="button" value="<? echo $def_admin_emty_button; ?>" /><input type="hidden" name="name_cache" value="0" /></form></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">RSS информер</td>
          <td width="150" class="blue_txt" id="table_files_i_c"><? echo $files_cache[1]; ?></td>
          <td id="table_files_i"><form action="?REQ=empty" method="post"><input type="submit" name="button" value="<? echo $def_admin_emty_button; ?>" /><input type="hidden" name="name_cache" value="1" /></form></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Курсы валют</td>
          <td width="150" class="blue_txt" id="table_files_i_c"><? echo $files_cache[2]; ?></td>
          <td id="table_files_i"><form action="?REQ=empty" method="post"><input type="submit" name="button" value="<? echo $def_admin_emty_button; ?>" /><input type="hidden" name="name_cache" value="2" /></form></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Гороскоп</td>
          <td width="150" class="blue_txt" id="table_files_i_c"><? echo $files_cache[3]; ?></td>
          <td id="table_files_i"><form action="?REQ=empty" method="post"><input type="submit" name="button" value="<? echo $def_admin_emty_button; ?>" /><input type="hidden" name="name_cache" value="3" /></form></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<?

require_once 'template/footer.php';

?>
<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: infofields.php
-----------------------------------------------------
 Назначение: Управление дополнительными полями
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$fields_help;

$title_cp = 'Управление дополнительными полями - ';
$speedbar = ' | <a href="infofields.php">Управление дополнительными полями</a>';

check_login_cp('4_2','infofields.php');

$fields_on=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);

	$data_feilds="<option value=\"0\" selected>Выберите раздел</option>";

	for ($zzz = 1; $zzz < 6; $zzz++) {

		$data_feilds.="<option value=\"$zzz\">$fields_on[$zzz]</option>";
	}

require_once 'template/header.php';

?>
<form name="form_field" method="post" action="?REQ=edit">
<table width="100%" border="0">
  <tr>
    <td><img src="images/snews_pole.png" width="32" height="32" align="absmiddle" /><span class="maincat"><? echo $def_info_info_r; ?></span></td>
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
            <td width="370"><img src="images/allactiv.gif" width="31" height="31" align="absmiddle" />
<select name="edit_fil">
<? echo $data_feilds; ?>
</select>
<input type="submit" name="button" id="button" value="<? echo $def_images_edit_but; ?>" />
	    </td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<?

if (isset($_GET['save']))

{

$num=(int)$_GET['save'];

 $db->query ("UPDATE $db_infofields SET f_name1='$_POST[field_1]', f_type1='$_POST[select_1]', f_on1='$_POST[checkbox_1]', f_name2='$_POST[field_2]', f_type2='$_POST[select_2]', f_on2='$_POST[checkbox_2]', f_name3='$_POST[field_3]', f_type3='$_POST[select_3]', f_on3='$_POST[checkbox_3]', f_name4='$_POST[field_4]', f_type4='$_POST[select_4]', f_on4='$_POST[checkbox_4]', f_name5='$_POST[field_5]', f_type5='$_POST[select_5]', f_on5='$_POST[checkbox_5]',
              f_name6='$_POST[field_6]', f_type6='$_POST[select_6]', f_on6='$_POST[checkbox_6]', f_name7='$_POST[field_7]', f_type7='$_POST[select_7]', f_on7='$_POST[checkbox_7]', f_name8='$_POST[field_8]', f_type8='$_POST[select_8]', f_on8='$_POST[checkbox_8]', f_name9='$_POST[field_9]', f_type9='$_POST[select_9]', f_on9='$_POST[checkbox_9]', f_name10='$_POST[field_10]', f_type10='$_POST[select_10]', f_on10='$_POST[checkbox_10]' where num='$num'") or die (mysql_error());

$_POST['edit_fil']=$num;

}

if ($_GET['REQ']=='edit') {

if ($_POST['edit_fil']==0) {

msg_text('80%',$def_admin_message_error,$def_info_error);

} else

{

$val = $_POST['edit_fil'];

echo <<<HTML

<div align="left">&nbsp;&nbsp;$def_admin_razdel : <b>$fields_on[$val]</b><br /><br /></div>
<form name="form_update" method="post" action="?REQ=edit&amp;save=$_POST[edit_fil]">
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files">Название поля</td>
        <td width="150" id="table_files_c">$def_info_type_filed</td>
        <td id="table_files">$def_info_on_field</td>
      </tr>
HTML;

	$r_b=$db->query ("select * from $db_infofields where num='$_POST[edit_fil]'") or die ("mySQL error!");

	$b_f=$db->fetcharray ($r_b);

	$row_name=array(1=>$b_f[f_name1], 2=>$b_f[f_name2], 3=>$b_f[f_name3], 4=>$b_f[f_name4], 5=>$b_f[f_name5], 6=>$b_f[f_name6], 7=>$b_f[f_name7], 8=>$b_f[f_name8], 9=>$b_f[f_name9], 10=>$b_f[f_name10]);
	$row_type=array(1=>$b_f[f_type1], 2=>$b_f[f_type2], 3=>$b_f[f_type3], 4=>$b_f[f_type4], 5=>$b_f[f_type5], 6=>$b_f[f_type6], 7=>$b_f[f_type7], 8=>$b_f[f_type8], 9=>$b_f[f_type9], 10=>$b_f[f_type10]);
	$row_on=array(1=>$b_f[f_on1], 2=>$b_f[f_on2], 3=>$b_f[f_on3], 4=>$b_f[f_on4], 5=>$b_f[f_on5], 6=>$b_f[f_on6], 7=>$b_f[f_on7], 8=>$b_f[f_on8], 9=>$b_f[f_on9], 10=>$b_f[f_on10]);

for ($zzz = 1; $zzz < 11; $zzz++) {

echo "
        <tr>
          <td width=\"250\" id=\"table_files_i\"><input name=\"field_$zzz\" type=\"text\" value=\"$row_name[$zzz]\"></td>
          <td width=\"150\" class=\"blue_txt\" id=\"table_files_i_c\">";
if ($row_type[$zzz]==2) echo "<select name=\"select_$zzz\"><option value=\"1\">$def_info_type_1</option><option value=\"2\" selected>$def_info_type_2</option></select>";
else echo "<select name=\"select_$zzz\"><option value=\"1\" selected>$def_info_type_1</option><option value=\"2\">$def_info_type_2</option></select>";

echo "  </td>
          <td id=\"table_files_i\">";
if ($row_on[$zzz]==1) echo "<select name=\"checkbox_$zzz\"><option value=\"1\" selected>$def_admin_yes</option><option value=\"2\">$def_admin_no</option></select>";
else echo "<select name=\"checkbox_$zzz\"><option value=\"1\">$def_admin_yes</option><option value=\"2\" selected>$def_admin_no</option></select>";
echo"
	</td>
        </tr>
";

}

echo <<<HTML

      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type="submit" name="inbut" value="$def_admin_save" border="0" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>

HTML;

}
}

else { 

msg_text("80%",$def_admin_message_mess,$def_info_error);

}

require_once 'template/footer.php';

?>
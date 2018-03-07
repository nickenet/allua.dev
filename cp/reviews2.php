<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: reviews2.php
-----------------------------------------------------
 Назначение: Работа с комментариями
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$reviews2_help;

$title_cp = 'Работа с комментариями - ';
$speedbar = ' | <a href="reviews2.php?REQ=auth">Работа с комментариями</a>';

check_login_cp('1_5','reviews2.php?REQ=auth');

$can='';

if ($_GET['REQ'] == 'complete'){

		if ($_POST['inbut'] == (string)$def_images_change) {

			$date = date('Y-m-d');

			$user = safeHTML($_POST['user']);
			$message = safeHTML($_POST['review']);
			$mail = safeHTML($_POST['mail']);

			if ( $_POST['www'] <> '' )

			{

				if ( preg_match('#http://#', $_POST['www']) )

				{ $www = $_POST['www']; }

				else

				{

					$www = 'http://' . $_POST[www];

				}

			}

			$www = safeHTML ($www);

			$db->query ("UPDATE $db_reviews SET user='$user', review='$message', status='on', mail='$mail', www='$www' where id='$_POST[idin]'") or die (mysql_error());

                        if (isset ($_POST['otvet'])) {

                            $otvet = safeHTML($_POST['otvet']);
                            $db->query  ( "UPDATE $db_reply SET reply='$otvet' WHERE id_com='$_POST[idin]'" );

                        }
			
			logsto("$def_admin_review_approved $_POST[idin]");

			$can="yes"; $rew_ok=1;
		}

		else {
			$db->query ("DELETE FROM $db_reviews where id='$_POST[idin]'") or die ("mySQL error!");
                        $db->query ("DELETE FROM $db_reply where id_com='$_POST[idin]'");

                        if ($_POST['rtype']==2) $db->query("UPDATE $db_users SET rev_good=rev_good-1 WHERE selector='$_POST[selector]'");
                        if ($_POST['rtype']==3) $db->query("UPDATE $db_users SET rev_bad=rev_bad-1 WHERE selector='$_POST[selector]'");

                        logsto($def_admin_review_removed . ' ' . $_POST['idin']);

			$can='yes'; $rew_ok=2;
		} 
}

require_once 'template/header.php';

if (($_GET['REQ'] == 'auth') or ($can=='yes'))
{



?>

  <script type="text/javascript">

  function textCounter (field, countfield, maxlimit)

  {
  	if (field.value.length > maxlimit)
  	field.value = field.value.substring(0, maxlimit);
  	else
 	countfield.value = maxlimit - field.value.length;
  }

  function trans_find()
  {
      var elm = document.getElementById('rew_find_link');
      var show = (elm.style.display == 'none' ? 'none' : '');
      elm.style.display = (show ? '' : 'none');
      document.getElementById('rew_find_link_hide').style.display = show;
      document.getElementById('rew_find_mod').style.display = show;
  }

  function trans_stat()
  {
      var elm = document.getElementById('stat_link');
      var show = (elm.style.display == 'none' ? 'none' : '');
      elm.style.display = (show ? '' : 'none');
      document.getElementById('stat_link_hide').style.display = show;
      document.getElementById('stat_mod').style.display = show;
  }

  </script>

<table width="100%" border="0">
  <tr>
    <td><img src="images/fset.png" width="32" height="32" align="absmiddle" /><span class="maincat">Найти/Удалить/Редактировать комментарии</span></td>
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
            <td width="200" class="vclass"><img src="images/find.gif" width="31" height="31" align="absmiddle" />
		<a href="javascript:;" onclick="trans_find()" id="rew_find_link">Искать комментарии компании</a>
		<a href="javascript:;" onclick="trans_find()" id="rew_find_link_hide" style="display: none">Искать комментарии компании</a></td>
            <td width="180" class="vclass"><img src="images/find.gif" width="31" height="31" align="absmiddle" />
		<a href="javascript:;" onclick="trans_stat()" id="stat_link">Поиск по условию</a>
		<a href="javascript:;" onclick="trans_stat()" id="stat_link_hide" style="display: none">Поиск по условию</a></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34"></td>
      </tr>
    </table></td>
  </tr>
</table>


<br />

<?

if ($rew_ok==1) msg_text('80%',$def_admin_message_ok,'Комментарий <b>' . $_POST['idin'] . '</b> изменен.');

if ($rew_ok==2) msg_text('80%',$def_admin_message_ok,'Комментарий <b>' . $_POST['idin'] . '</b> удален.');

if (!isset($_POST['id'])) {

table_fdata_top ('Искать комментарий');

?>


<form action="reviews2.php?REQ=auth" method="post">
<table width="400" cellpadding="2" cellspacing="1" border="0">
<tr><td align="right" width="150">ID комментария: &nbsp;&nbsp;</td><td align="left" width="250"><input type="text" name="id" value="<? if ($_POST['id']!=0) echo (int)$_POST['id']; ?>" maxlength="100" size="40" /></td></tr>
<tr><td align="right" colspan="2"><input type="submit" name="inbut" value="Искать" /></td></tr></table></form><br />

<?

table_fdata_bottom();

echo '<br />';

 } if (!isset($_POST['rew_com'])) echo "<div id=\"rew_find_mod\" style=\"display: none\">";  else echo "<div id=\"rew_find_mod\">";

table_fdata_top ('Искать комментарии компании');

?>

<form action="reviews2.php?REQ=auth" method="post">
<table width="400" cellpadding="2" cellspacing="1" border="0">
<tr><td align="right" width="150">ID компании: &nbsp;&nbsp;</td><td align="left" width="250"><input type="text" name="id" value="<? if ($_POST['id']!=0) echo (int)$_POST['id']; ?>" maxlength="100" size="40" /></td></tr>
<tr><td align="right" width="150"> <? echo $def_admin_review_type; ?>:&nbsp;<td align="left" width="250">
   <select name="type_connents">
<option value="0"<? if ($_POST['type_connents']=='0') echo " selected=\"selected\""; ?>>Показать все</option>
<option value="1"<? if ($_POST['type_connents']=='1') echo " selected=\"selected\""; ?>>Нейтральные</option>
<option value="2"<? if ($_POST['type_connents']=='2') echo " selected=\"selected\""; ?>>Положительные</option>
<option value="3"<? if ($_POST['type_connents']=='3') echo " selected=\"selected\""; ?>>Отрицательные</option>
</select>
</td></tr>
<tr><td align="right" colspan="2"><input type="hidden" name="rew_com" value="yes" /><input type="submit" name="inbut" value="Искать" /></td></tr></table></form><br />

<?

table_fdata_bottom();

echo '</div><br />';

if (!isset($_POST[rew_com2])) echo "<div id=\"stat_mod\" style=\"display: none\">";  else echo "<div id=\"stat_mod\">";

table_fdata_top ('Показать комментарии по условию');

?>

<form action="reviews2.php?REQ=auth" method="post">
<table width="600" cellpadding="2" cellspacing="1" border="0">
<tr><td align="right" width="600">ID от:&nbsp;<input type="text" name="id" value="<? if ($_POST['id']!=0) echo (int)$_POST['id']; ?>" maxlength="20" size="10" />&nbsp;ID до:&nbsp;<input type="text" name="id2" value="<? if ($_POST['id2']!=0) echo (int)$_POST['id2']; ?>" maxlength="20" size="10" />&nbsp;
Выводить первыми&nbsp;<select name="sort_sel"><option value="1"<? if ($_POST['sort_sel']=='1') echo " selected=\"selected\""; ?>>Новые</option><option value="2"<? if ($_POST['sort_sel']=='2') echo " selected=\"selected\""; ?>>Старые</option></select>
<? echo $def_admin_review_type; ?>&nbsp;<select name="type_connents">
<option value="0"<? if ($_POST['type_connents']=='0') echo " selected=\"selected\""; ?>>Показать все</option>
<option value="1"<? if ($_POST['type_connents']=='1') echo " selected=\"selected\""; ?>>Нейтральные</option>
<option value="2"<? if ($_POST['type_connents']=='2') echo " selected=\"selected\""; ?>>Положительные</option>
<option value="3"<? if ($_POST['type_connents']=='3') echo " selected=\"selected\""; ?>>Отрицательные</option>
</select>
</td></tr>
<tr><td align="right"><input type="hidden" name="rew_com2" value="yes" /><input type="submit" name="inbut" value="Искать" /></td></tr></table></form><br />
 
<?

table_fdata_bottom();

echo '</div><br />';

if (isset($_POST['id'])) {

		$id_com=intval($_POST['id']);

                $type_connents=intval($_POST[type_connents]);

                $type_connents_where_id='';

		if (isset($_POST['rew_com'])) { if ($type_connents>0) $type_connents_where_id=" and rtype='$type_connents' "; $ra=$db->query ("select * from $db_reviews where company = '$id_com' $type_connents_where_id") or die ("mySQL error!"); }

		elseif (isset($_POST['rew_com2'])) { $id_com2=intval($_POST['id2']);
							
							if ($id_com==0) $where_sel = "where id < '$id_com2'";
							elseif ($id_com2==0) $where_sel = "where id > '$id_com'";
							else $where_sel = "where id > '$id_com' and id < '$id_com2'";
							if (($id_com==0) and ($id_com2==0)) { $where_sel=""; $limit_sel = "LIMIT 10"; }

                                                   if ($_POST[sort_sel]=='1') $sql_sort="ORDER BY id DESC"; else $sql_sort="ORDER BY id";
                                                        
                                                   if ($type_connents>0) { if ($where_sel=="") $type_connents_where="where rtype='$type_connents'"; else $type_connents_where="and rtype='$type_connents'"; } else $type_connents_where='';

						   $ra=$db->query ("select * from $db_reviews $where_sel $type_connents_where $sql_sort $limit_sel") or die ("mySQL error!"); }

		else { $ra=$db->query ("select * from $db_reviews where id = '$id_com'") or die ("mySQL error!"); }

		if (mysql_num_rows($ra) > 0)
		{
			$rowsc=mysql_num_rows($ra);	
			for ($a=0;$a<$rowsc;$a++)
			{
				$newfirms=mysql_num_rows($ra);
				$fa=$db->fetcharray ($ra);

				$nn_com = $a+1;

				$r=$db->query ("select * from $db_users where selector = '$fa[company]'") or die ("mySQL error!");
				$rar=$db->fetcharray ($r);

				$fa[review] = str_replace("<br>", "\n", $fa[review]);

                if (($fa['rtype']==1) or empty($fa['rtype'])) $rtype_com=$def_admin_review_type_com;
		if ($fa['rtype']==2) { $color_review_type='#006600'; $rtype_com=$def_admin_review_type_good; }
		if ($fa['rtype']==3) { $color_review_type='#FF0000'; $rtype_com=$def_admin_review_type_bad; }

?>

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="4"><img src="images/table_sys_01.gif" width="4" height="26" /></td>
    <td background="images/table_sys_02.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="16" align="center"><img src="images/table_sys_vdv.gif" width="8" height="20" /></td>
        <td>Комментарий <? echo "$nn_com"; ?> из <? echo "$newfirms [ID=$fa[id]]"; ?></td>
        <td width="16" align="right"><img src="images/table_sys_zn.gif" width="16" height="16" border="0" /></a></td>
      </tr>
    </table></td>
    <td width="5"><img src="images/table_sys_03.gif" width="5" height="26" /></td>
  </tr>
  <tr>
    <td width="4" background="images/table_sys_04.gif">&nbsp;</td>
    <td bgcolor="#FFFFFF" align="center"><br />
<form action="reviews2.php?REQ=complete" method="post">
<table width="800" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td width="180" align="right">Компания:</td>
    <td align="left"><? echo "<b>$rar[firmname]</b> [id=$rar[selector]]"; ?></td>
  </tr>
  <tr>
    <td width="180" align="right"><? echo $def_admin_review_type; ?>:</td>
    <td align="left"><? echo '<b style="color:'.$color_review_type.';">'.$rtype_com.'</b>'; ?></td>
  </tr>
  <tr>
    <td width="180" align="right">Посетитель:</td>
    <td align="left"><input type="text" name="user" size="40" value="<? echo "$fa[user]"; ?>" maxlength="100" /></td>
  </tr>
  <tr>
    <td width="180" align="right">Email:</td>
    <td align="left"><input type="text" name="mail" size="40" value="<? echo "$fa[mail]"; ?>" maxlength="100" /></td>
  </tr>
  <tr>
    <td width="180" align="right">Web сайт:</td>
    <td align="left"><input type="text" name="www" size="40" value="<? echo "$fa[www]"; ?>" maxlength="100" /></td>
  </tr>
  <tr>
    <td width="180" align="right">Комментарий: <span style="color:#FF0000;">*</span></td>
    <td align="left"><textarea name="review" cols="20" rows="5" onKeyDown="textCounter(this.form.review,this.form.remLen,<? echo "$def_review_size"; ?>);" onKeyUp="textCounter(this.form.review,this.form.remLen,<? echo $def_review_size; ?>);" style="width:516px;"><? echo $fa[review]; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left"><? echo "<input readonly type=\"text\" name=\"remLen\" size=\"4\" maxlength=\"4\" value=\"$def_review_size\"> $def_characters_left"; ?></td>
  </tr>
<?
if ($fa['otvet']==1) {

   $res_otvet = $db->query  ( "SELECT reply FROM $db_reply WHERE id_com='$fa[id]'");
   $fe_otvet = $db->fetcharray  ( $res_otvet );
?>
  <tr>
    <td width="180" align="right">Ответ компании: <span style="color:#FF0000;">*</span></td>
    <td align="left"><textarea name="otvet" cols="20" rows="5" style="width:516px;"><? echo $fe_otvet['reply']; ?></textarea></td>
  </tr>
<?
}
?>
  <tr>
    <td width="180" align="right">&nbsp;</td>
    <td align="left"><input type="hidden" name="idin" value=<? echo "$fa[id]"; ?>>
        <input type="hidden" name="rtype" value="<? echo $fa['rtype']; ?>">
        <input type="hidden" name="selector" value="<? echo $rar['selector']; ?>">
        <input type="submit" name="inbut" value="<? echo "$def_images_change"; ?>" border="0" />&nbsp;<input type="submit" name="inbut" value="<? echo "$def_images_delete"; ?>" style="color: #FFFFFF; background: #D55454;" /></td>
  </tr>
</table>
</form><br />
</td>
    <td width="5" background="images/table_sys_06.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="4"><img src="images/table_sys_07.gif" width="4" height="5" /></td>
    <td background="images/table_sys_08.gif"><img src="images/table_sys_08.gif" width="4" height="5" /></td>
    <td width="5"><img src="images/table_sys_09.gif" width="4" height="5" /></td>
  </tr>
</table><br />

<?
			}
		}

		else msg_text('80%',$def_admin_message_error,'По Вашему запросу ничего не найдено.');

}

}

require_once 'template/footer.php';

?>

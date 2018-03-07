<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: top_wt.php
-----------------------------------------------------
 Назначение: Контекстная панель РС и ГС CP
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<script type="text/javascript">
function trans_find()
{
    var elm = document.getElementById('find_link');
    var show = (elm.style.display == 'none' ? 'none' : '');
    elm.style.display = (show ? '' : 'none');
    document.getElementById('find_link_hide').style.display = show;
    document.getElementById('find_mod').style.display = show;
}
function trans_stat()
{
    var elm = document.getElementById('stat_link');
    var show = (elm.style.display == 'none' ? 'none' : '');
    elm.style.display = (show ? '' : 'none');
    document.getElementById('stat_link_hide').style.display = show;
    document.getElementById('stat_mod').style.display = show;
}
function trans_instrum()
{
    var elm = document.getElementById('instrum_link');
    var show = (elm.style.display == 'none' ? 'none' : '');
    elm.style.display = (show ? '' : 'none');
    document.getElementById('instrum_link_hide').style.display = show;
    document.getElementById('instrum_mod').style.display = show;
}
	function startSearch()
	{
		var sForm = document.getElementById('search_form');
		if (!sForm)
		{
			return;
		}

		sForm.setAttribute('action', this.getAttribute('value'));
	}


	function initSearch()
	{
		var sForm = document.getElementById('search_form');
		if (!sForm)
		{
			return;
		}

		var chList = sForm.getElementsByTagName('input');
		var elm;
		for (var i = 0; i < chList.length; ++i)
		{
			elm = chList[i];
			if (elm.getAttribute('type') == 'radio')
			{
				elm.onclick = startSearch;
			}

			if (elm.getAttribute('checked'))
			{
				sForm.setAttribute('action', elm.getAttribute('value'));
			}
		}
	}
</script>

<? if ($top_wt=='main') $def_index_main_title = "Рабочий стол"; else $def_index_main_title = "Главная страница"; ?>

<table width="100%" border="0">
  <tr>
      <td><img src="images/edit_firm.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;<? echo $def_index_main_title; ?></span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3"><img src="images/button-l.gif" width="3" height="34"></td>
        <td background="images/button-b.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" /></td>
            <td width="135" class="vclass"><img src="images/safe.gif" width="31" height="31" align="absmiddle" /><a href="./log.php?REQ=auth">Просмотр истории</a></td>
            <? if (empty ($top_wt)) { ?>
            <td width="160" class="vclass"><img src="images/stat.gif" width="31" height="31" align="absmiddle" /><a href="javascript:;" onclick="trans_stat()" id="stat_link"><? echo "$def_statistics_com"; ?></a>
		<a href="javascript:;" onclick="trans_stat()" id="stat_link_hide" style="display: none"><? echo "$def_statistics_hide"; ?></a></td>
            <? } ?>
            <td width="210" class="vclass"><img src="images/idedit.gif" width="31" height="31" align="absmiddle" /><a href="javascript:;" onclick="trans_instrum()" id="instrum_link">Редактировать контент компании</a>
		<a href="javascript:;" onclick="trans_instrum()" id="instrum_link_hide" style="display: none">Редактировать контент компании</a></td>
            <td width="160" class="vclass"><img src="images/find.gif" width="31" height="31" align="absmiddle" />
		<a href="javascript:;" onclick="trans_find()" id="find_link"><? echo "$def_admin_find"; ?></a>
		<a href="javascript:;" onclick="trans_find()" id="find_link_hide" style="display: none"><? echo "$def_admin_hide_find"; ?></a></td>
            <? if($_SESSION['warning_pay']=='YES') { ?>
            <td width="260" class="vclass"><img src="images/stop.gif" width="16" height="16" align="absmiddle" />&nbsp;<a href="stat.php">Завершение срока в тарифных планах</a></td>
            <? } ?>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>

 <? if (empty ($top_wt)) { ?>
<div id="stat_mod" style="display: none; text-laign: center">

<? require_once 'inc/stat.php'; ?>

</div>
<? } ?>

<div id="find_mod" style="display: none"><br />
<form action="offers.php?REQ=auth" method="post">
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="220" id="table_files"><? echo "$def_admin_uslovie"; ?></td>
        <td id="table_files_r"><? echo "$def_admin_forma_find"; ?></td>
        </tr>
        <tr>
          <td width="220" id="table_files_i"><? echo "$def_admin_title:"; ?></td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idname" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="220" id="table_files_i"><? echo "$def_admin_login_find:"; ?></td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idlogin" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="220" id="table_files_i"><? echo "$def_admin_id_find:"; ?></td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idident" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="220" id="table_files_i"><? echo "$def_admin_comments:"; ?></td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idcomment" maxlength="100" size="40" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type="submit" name="inbut" value="<? echo "$def_admin_search_button"; ?>" border="0"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</div><br />

<div id="instrum_mod" style="display: none; text-laign: center">
<form action="" method="post" id="search_form">
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files"><? echo "$def_admin_uslovie"; ?></td>
        <td id="table_files_r"><? echo "$def_admin_forma_find"; ?></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">id компании</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="id" maxlength="60" style="width:50px;" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i" class="searchik">
              <label><input type="radio" style="background:none; border: 0px;" name="search_type" value="edoffers.php" checked="checked"><? echo $def_admin_offers; ?></label><br />
              <label><input type="radio" style="background:none; border: 0px;" name="search_type" value="edgallery.php"><? echo $def_admin_images; ?></label><br />
	      <label><input type="radio" style="background:none; border: 0px;" name="search_type" value="edexel.php"><? echo $def_admin_exel; ?></label><br />
	      <label><input type="radio" style="background:none; border: 0px;" name="search_type" value="edvideo.php"><? echo $def_admin_video; ?></label><br />
	      <label><input type="radio" style="background:none; border: 0px;" name="search_type" value="edinfo.php"><? echo $def_info_infos; ?></label><br />
              <label><input type="radio" style="background:none; border: 0px;" name="search_type" value="edfilial.php"><? echo $def_info_filial; ?></label><br /><br />
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type="submit" value="перейти к редактированию" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>

<script type="text/javascript">
initSearch();
</script>

</div>
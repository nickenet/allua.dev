<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & Ilya K.
=====================================================
 Файл: edseo.php
-----------------------------------------------------
 Назначение: Имя страницы и seo
=====================================================
*/

@ $randomized = rand ( 0, 9999 );

session_start();

require_once './defaults.php';

$idident=intval($_REQUEST['id']);
if (isset($_POST['idident'])) $idident=intval($_REQUEST['idident']);

$r=$db->query ("select * from $db_users where selector='$idident'") or die ("mySQL error!");
$f=$db->fetcharray ($r);

if (!empty($_POST['do_check']) && $_POST['do_check'] == 'domen')
{
	ob_clean();
	$check = safeHTML($_POST['check']);
	$check = trim($check);
	$check = iconv('CP1251', 'UTF-8', $check);

	$res = $db->query("SELECT domen FROM " . $db_users . " 
	WHERE domen = '" . $check . "' and selector!='" . $f['selector']. "' LIMIT 1");
	$row = $db->fetcharray($res);

	if (empty($row))
	{
		$msg = '<span style="font-size:10px; color:#009900;">Имя свободно.</span>';
	}
	else
	{
		$msg = '<span style="font-size:10px; color:#FF0000;">Имя существует.</span>';
	}

	$msg = iconv('CP1251', 'UTF-8', $msg);
	header("Content-type: text/html; charset=UTF-8");
	echo $msg;

	exit;
}

$help_section = (string)$seo_help;

$title_cp = $def_admin_seo.' - ';
$speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | <a href="edseo.php?id='.$idident.'">'.$def_admin_seo.'</a>';

check_login_cp('1_0','edseo.php?id='.$idident);

require_once 'template/header.php';

table_item_top ($def_admin_seo,'seo.png');

// Генератор метатегов
// мета-тег title

$meta_title_ex = chek_meta($f['firmname']);

// мета-тег description
$meta_descr_ex = chek_meta($f['business']);
$meta_descr_ex = substr($meta_descr_ex, 0, 200);
$meta_descr_ex = substr($meta_descr_ex, 0, strrpos($meta_descr_ex, ' '));
$meta_descr_ex = trim($meta_descr_ex);
// мета-тег keywords
$meta_keyw_ex = check_keywords($f['business']);

	$title_asd = $f['metatitle'];
	$descr_asd = $f['metadescr'];
	$keywords_asd = $f['metakeywords'];
	$domen = $f['domen'];

// Изменение мета-тегов
if ($_POST["changed"] == "true")
{

	$title_asd = safeHTML($_POST['title']);
	$descr_asd = safeHTML($_POST['descr']);
	$keywords_asd = safeHTML($_POST['keywords']);

	$domen = safeHTML($_POST['domen']);

	$submit_error = '';

        if ($domen!='') {
	$domen=strtr($domen,'_','*');
	$domen = rewrite($domen);
        $domen=strtr($domen,'*','_');
	$r_d = $db->query("SELECT selector FROM $db_users WHERE domen='$domen' and selector!='$f[selector]' ");
	$domens = mysql_num_rows($r_d);

	if ($domens > 0)
	{
		$submit_error = 'Указанный адрес странички использует другая компания.';
		$domen = '';
	}
        }

	$db->query("UPDATE $db_users SET metatitle='$title_asd', metadescr='$descr_asd', metakeywords='$keywords_asd', domen='$domen' WHERE selector='$f[selector]'");

	if ($submit_error == '') msg_text('80%',$def_admin_message_ok,'Ваши данные успешно обновлены!');
	else msg_text('80%',$def_admin_message_error,$submit_error);

}

table_fdata_top ($def_item_form_data);

?>

<div id="TabbedPanels1">
<form action="" method="post" id='regform'>

<table border="0" cellspacing="2" cellpadding="2">
    <tr>
        <td align="right">Мета-тег &lt;title&gt;:&nbsp;</td>
	<td align="left">
		<input type="text" name="title" maxlength="100" style="width:300px;" value="<? echo $title_asd; ?>" id="meta_title_content" />
	</td>
    </tr>
    <tr>
	<td align="right">Мета-тег description:&nbsp;</td>
	<td align="left">
		<input type="text" name="descr" maxlength="250" style="width:300px;" value="<? echo $descr_asd; ?>" id="meta_desc_content" />
	</td>
    </tr>
    <tr>
    <td align="right" valign="top">Мета-тег keywords:&nbsp;<br /><br />
	<input type="button" id="fill_meta" value="Сгенерировать" class="btn" /><br />
	<input type="button" id="clean_meta" value="Очистить" class="btn" />
    </td>
    <td align="left">
	<textarea name="keywords" cols="20" rows="4" style="width:400px;" id="meta_keys_content"><? echo $keywords_asd; ?></textarea>
    </td>
    </tr>
    <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    </tr>
    <tr>
	<td align="right">Имя Вашей странички:&nbsp;<? echo $def_mainlocation . '/'; ?></td>
	<td align="left">
	<input type="text" name="domen" id="domen" maxlength="55" style="width:300px;" value="<? echo $domen; ?>" />
	<input type="button" onclick="checkDomen()" value="Проверить" class="btn" />&nbsp;<img id="domen_loader" src="../images/go.gif" alt="loading" style="visibility:hidden" />
		<div id="domen_list"></div>
	</td>
    </tr>
    <tr>
        <td align="right"><input type="submit" name="button" value="Сохранить" /><input type="hidden" name="changed" value="true" /><input type="hidden" name="id" value="<? echo $f[selector]; ?>" /></td>
	<td>&nbsp;</td>
	</tr>
</table>

</form>
</div>

<div class="hh">
	<p id="meta_title"><? echo $meta_title_ex; ?></p>
	<p id="meta_desc"><? echo $meta_descr_ex; ?></p>
	<p id="meta_keys"><? echo $meta_keyw_ex; ?></p>
</div>

	<script type="text/javascript">
		function checkDomen()
		{
			if (!$('#domen').length)
			{
				return false;
			}

			var check_value = $('#domen').val();
			if (check_value == '')
			{
				return false;
			}

			$('#domen_list').hide();
			$('#domen_loader').css('visibility', 'visible');
			$.post(
			'edseo.php',
			{
				id: '<?=$idident?>',
				do_check: 'domen',
				check: check_value
			},
			function(data){
				$('#domen_loader').css('visibility', 'hidden');
				$('#domen_list').html(data).slideDown();
			}
			);

			return true;
		}

		$(function(){
			$('#fill_meta').click(fillMeta);
			$('#clean_meta').hide().click(cleanMeta);
		});

		var metaList = ['title', 'desc', 'keys'];
		function fillMeta()
		{
			$(metaList).each(function(k, id){
				$('#meta_' + id + '_content').val($('#meta_' + id).text());
			});
			$('#clean_meta').show();
		}

		function cleanMeta()
		{
			$(metaList).each(function(k, id){
				$('#meta_' + id + '_content').val('');
			});
			$('#clean_meta').hide();
		}
	</script>

<?

table_fdata_bottom();

require_once 'template/footer.php';

?>
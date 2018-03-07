<?php

/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi & Ilya.K
  =====================================================
  Файл: ajax.php
  -----------------------------------------------------
  Назначение: Ajax действия
  =====================================================
 */

if (!defined('ISB'))
{
	die("Hacking attempt!");
}

if (!empty($_POST['do_check']) && $_POST['do_check'] == 'domen')
{
	ob_clean();
	$check = safeHTML($_POST['check']);
	$check = trim($check);
	$check = iconv('CP1251', 'UTF-8', $check);

	$res = $db->query("SELECT domen FROM $db_users WHERE domen = '$check' and selector!='$f[selector]' LIMIT 1");
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

if ($_GET['mod'] == 'theme')
{
	if ($f['design'] != '')
	{
		$img_h = explode(':', $f['design']);

		$header = "../design/header/$f[selector].$img_h[0]";
		$background = "../design/background/$f[selector].$img_h[1]";
	}

	if (!empty($_REQUEST['del_image']))
	{
		if ($_REQUEST['del_image'] == 'header')
		{
			if (file_exists($header))
			{
				@ unlink($header);
			}
			echo '';
		}

		if ($_REQUEST['del_image'] == 'background')
		{
			if (file_exists($background))
			{
				@ unlink($background);
			}
			echo '';
		}

		exit;
	}

	# Настройки социальной страницы
	if (!empty($_POST['setting']))
	{
		$form_set = array();

		$form_set[0] = isset($_POST['translate']) ? intval($_POST['translate']) : 0;

		for ($i = 1; $i <= 13; $i++)
		{
			$_POST['set' . $i] = iconv('utf-8', 'cp1251', $_POST['set' . $i]);
		}

                for ($i = 18; $i <= 19; $i++)
		{
			$_POST['set' . $i] = iconv('utf-8', 'cp1251', $_POST['set' . $i]);
		}

		$form_set[1] = safeHTML($_POST['set1']);
		if (($form_set[1] == '') or ($form_set[1] == $def_sociall_link_to_main))
			$form_set[1] = '';

		$form_set[2] = safeHTML($_POST['set2']);
		if (($form_set[2] == '') or ($form_set[2] == $def_offers))
			$form_set[2] = '';

		$form_set[3] = safeHTML($_POST['set3']);
		if (($form_set[3] == '') or ($form_set[3] == $def_images))
			$form_set[3] = '';

		$form_set[4] = safeHTML($_POST['set4']);
		if (($form_set[4] == '') or ($form_set[4] == $def_exelp))
			$form_set[4] = '';

		$form_set[5] = safeHTML($_POST['set5']);
		if (($form_set[5] == '') or ($form_set[5] == $def_video))
			$form_set[5] = '';

		$form_set[6] = safeHTML($_POST['set6']);
		if (($form_set[6] == '') or ($form_set[6] == $def_info_news))
			$form_set[6] = '';

		$form_set[7] = safeHTML($_POST['set7']);
		if (($form_set[7] == '') or ($form_set[7] == $def_info_tender))
			$form_set[7] = '';

		$form_set[8] = safeHTML($_POST['set8']);
		if (($form_set[8] == '') or ($form_set[8] == $def_info_board))
			$form_set[8] = '';

		$form_set[9] = safeHTML($_POST['set9']);
		if (($form_set[9] == '') or ($form_set[9] == $def_info_job))
			$form_set[9] = '';

		$form_set[10] = safeHTML($_POST['set10']);
		if (($form_set[10] == '') or ($form_set[10] == $def_info_pressrel))
			$form_set[10] = '';

		$form_set[11] = safeHTML($_POST['set11']);
		if (($form_set[11] == '') or ($form_set[11] == $def_friend))
			$form_set[11] = '';

		$form_set[12] = safeHTML($_POST['set12']);
		if (($form_set[12] == '') or ($form_set[12] == $def_add_a_review))
			$form_set[12] = '';

		$form_set[13] = safeHTML($_POST['set13']);
		if (($form_set[13] == '') or ($form_set[13] == $def_sendmessage))
			$form_set[13] = '';

		$form_set[14] = intval($_POST['set14']);
		if ($form_set[14] == $def_social_publication)
			$form_set[14] = '';

		$form_set[15] = intval($_POST['set15']);
		if ($form_set[15] == $def_social_offers)
			$form_set[15] = '';

		$form_set[16] = intval($_POST['set16']);
		if ($form_set[16] == $def_social_images)
			$form_set[16] = '';

		$form_set[17] = isset($_POST['qr']) ? intval($_POST['qr']) : 0;

                $form_set[18] = safeHTML($_POST['set18']);
		if (($form_set[18] == '') or ($form_set[18] == $def_filial))
			$form_set[18] = '';

                $form_set[19] = safeHTML($_POST['set19']);
		if ($form_set[19] == '') $form_set[19] = 'notext';

                $form_set[20] = safeHTML($_POST['set20']);
		if ($form_set[20] == '') $form_set[20] = '';

                $form_set[21] = intval($_POST['set21']);
		if ($form_set[21] == 0) $form_set[21] = '';

                $form_set[22] = intval($_POST['set22']);
		if ($form_set[22] == 0) $form_set[22] = '';  

		$from_set = join(':', $form_set);

		$db->query("UPDATE $db_users SET setting_s='$from_set' WHERE login='$_SESSION[login]' and selector='$f[selector]'");

		echo 'page_settings_updateok';
		exit;
	}
}

if ($_GET['mod'] == 'map')
{
	if (!empty($_POST['position']))
	{
		$dolgota = safeHTML($_POST['dolgota']);
		$dolgota = str_replace(',', '.', $dolgota);

		$shirota = safeHTML($_POST['shirota']);
		$shirota = str_replace(',', '.', $shirota);

		$maps_pos = '';
		if ($dolgota != '' and $shirota != '')
		{
			$maps_pos = $shirota . ', ' . $dolgota;
		}
		
		$typeMaps = safeHTML($_POST['typemaps']);
		$selector = safeHTML($_POST['selector']);
		$sql = 'UPDATE ' . $db_users . ' SET map="' . $maps_pos . '", mapstype="' . $typeMaps . '" 
			WHERE login="' . $_SESSION['login'] . '" AND selector="' . $selector . '"';
		
		$db->query($sql);

		header("Content-type: text/html; charset=UTF-8");
		$msg = '<div class="alert alert-success">Данные о координатах успешно обновлены!</div>';
		$msg = iconv('CP1251', 'UTF-8', $msg);
		echo $msg;
		exit;
	}
}
?>

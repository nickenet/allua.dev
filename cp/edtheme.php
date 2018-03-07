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
			unlink($header);
		}
	}

    if ($_REQUEST['del_image'] == 'background')
	{
		if (file_exists($background))
		{
			unlink($background);
		}
	}
	
	exit;
}

$help_section = (string)$theme_help;

$title_cp = $def_admin_theme.' - ';
$speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | <a href="edtheme.php?id='.$idident.'">'.$def_admin_theme.'</a>';

check_login_cp('1_0','edtheme.php?id='.$idident);

require_once 'template/header.php';

table_item_top ($def_admin_theme,'theme.png');

if ($f['domen'] == '') msg_text('80%',$def_admin_message_error,'У Вас не задано имя странички. Укажите имя в разделе "Имя страницы и SEO".');
else
{
    $rstat1 = $db->query("select COUNT(*) from $db_offers where firmselector='$f[selector]'");
    $rstat2 = $db->query("select COUNT(*) from $db_images where firmselector='$f[selector]'");
    $rstat = mysql_result($rstat1, 0, 0) + mysql_result($rstat2, 0, 0);
    $procent_g = round(($rstat / $def_min_pos_social) * 100);
    if ($procent_g > 100) $procent_g = 100;
    echo '&nbsp;&nbsp;Социальная страничка: <u><a href="'.$def_mainlocation.'/'.$f['domen'].'" target="_blank" class="vclass">'.$def_mainlocation.'/'.$f['domen'].'</a></u><br />';
    echo '&nbsp;&nbsp;Процент готовности подключения к каталогу: <b>'.$procent_g.'%</b>';
}

$themeList = glob('../theme/*', GLOB_ONLYDIR);
foreach ($themeList as &$item)
{
	$item = basename($item);
}
unset($item);

// Отключаем страницу

if ($_POST['disabl']==$def_admin_sociall_turn_of) {
    $db->query("UPDATE $db_users SET theme='' WHERE selector='$f[selector]'");
    $f['theme'] = '';
    $error_submit='Cтраница успешно отключена из каталога.<br>';
    $def_admin_message_error='Успешно!';
}

// Изменение темы оформления

if (($_POST['theme'] == "true") and ($_POST['disabl']!=$def_admin_sociall_turn_of))
{
	// Картинки загружаем
	$img_v = explode(':', $f['design']);
	$imgExt = array('gif', 'png', 'bmp', 'jpg', 'jpeg', 'tif', 'tiff');
	$images_h = $img_v[0];
	$images_b = $img_v[1];
	$error_submit = '';
	if (isset($_FILES[key]) && is_uploaded_file($_FILES[key]['tmp_name']))
	{
		$fSize = filesize($_FILES[key]['tmp_name']);
		if ($fSize < $def_social_img_header)
		{

			$name = strtolower($_FILES[key]['name']);
			$ext = pathinfo($name, PATHINFO_EXTENSION);

			if (!in_array($ext, $imgExt))
				$error_submit.='<b>Ошибка! Файл для шапки не был загружен!</b><br>К загрузке допускаются изображения с расширениями: gif, png, bmp, jpg, jpeg, tif, tiff.<br>';
			else
			{

				$name = '../design/header/' . $f['selector'] . '.' . $ext;
				$name_old = '../design/header/' . $f['selector'] . '.' . $images_h;

				@unlink($name_old);

				if (move_uploaded_file($_FILES[key]['tmp_name'], $name))
					$images_h = $ext;
				else
					$error_submit.='<b>Ошибка! Файл для шапки не был загружен!</b><br>Сервер не смог принять данный файл.<br>';
			}
		} else
			$error_submit.='<b>Ошибка! Файл для шапки не был загружен!</b><br>Превышение допустимого размера файла.<br>';
	}
	if (isset($_FILES[keyb]) && is_uploaded_file($_FILES[keyb]['tmp_name']))
	{
		$fSize = filesize($_FILES[keyb]['tmp_name']);
		if ($fSize < $def_social_img_header)
		{

			$name1 = strtolower($_FILES[keyb]['name']);
			$ext1 = pathinfo($name1, PATHINFO_EXTENSION);

			if (!in_array($ext1, $imgExt))
				$error_submit.='<b>Ошибка! Файл фона не был загружен!</b><br>К загрузке допускаются изображения с расширениями: gif, png, bmp, jpg, jpeg, tif, tiff.<br>';
			else
			{

				$name1 = '../design/background/' . $f['selector'] . '.' . $ext1;
				$name_old1 = '../design/background/' . $f['selector'] . '.' . $images_b;

				@unlink($name_old1);

				if (move_uploaded_file($_FILES[keyb]['tmp_name'], $name1))
					$images_b = $ext1;
				else
					$error_submit.='<b>Ошибка! Файл фона не был загружен!</b><br>Сервер не смог принять данный файл.<br>';
			}
		} else
			$error_submit.='<b>Ошибка! Файл фона не был загружен!</b><br>Превышение допустимого размера файла.<br>';
	}

	$images = $images_h . ':' . $images_b;
	$themeN = safeHTML($_POST['design']);
	$db->query("UPDATE $db_users SET theme='$themeN', design='$images' WHERE selector='$f[selector]'");
	$f['theme'] = $themeN;
	$images_h = '';
	$images_b = '';
	$f['design'] = $images;
}

if ($error_submit != '')
{
        msg_text('80%',$def_admin_message_error,$error_submit);
}

?>

<form action="edtheme.php" method="post" enctype="multipart/form-data">

<? table_fdata_top ('Темы оформления'); ?>

    <? foreach ($themeList as $theme) :?>
        <label>
            <input type="radio" name="design" value="<?=$theme?>"
                <? if ($f['theme'] == $theme) echo 'checked' ?> />
            <img alt="" src="<? echo $def_mainlocation; ?>/theme/<?=$theme?>/images/face_theme.jpg"/>
        </label>
    <? endforeach; ?>

<? table_fdata_bottom(); ?>

    <br />
                                                                                    
<? table_fdata_top ('Загрузите свои файлы'); ?>

Шапка: <input type="file" name="key" /> <input type="button" value="Удалить" onclick="delImage('header')"><br />
    <span id="image_header">
        <? if (file_exists($header)) echo '<img style="width:50%; height:50%;" alt="" src="' . $header . '" />'; ?>
    </span>
<br />
Фон страницы: <input type="file" name="keyb" /> <input type="button" value="Удалить" onclick="delImage('background')" /><br />
    <span id="image_background">
        <? if (file_exists($background)) echo '<img style="width:50%; height:50%;" alt="" src="' . $background . '" />'; ?>
    </span>
                                                                                    
<? table_fdata_bottom(); ?>

    <br />

    <div align="center">
        <input type="submit" name="button" value="Сохранить" />
        <input type="hidden" name="theme" value="true" />
        <input type="hidden" name="idident" value="<? echo $f[selector]; ?>" />
        <input type="submit" name="disabl" value="<? echo $def_admin_sociall_turn_of; ?>">
    </div>
    
</form>

<script type="text/javascript">

	function delImage(name)
	{
		$('#image_' + name).load('edtheme.php?id=' + <?=$idident?> + '&del_image=' + name);
	}
        
</script>


<?

require_once 'template/footer.php';

?>
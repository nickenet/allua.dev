<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: cpfoto_edit.php
-----------------------------------------------------
 Назначение: Добавить описание и карту к фотоальбому
=====================================================
*/

session_start();

require_once './defaults.php';

$rewrite_foto = safeHTML($_REQUEST['addedit']);

$r=$db->query ("select * from $db_foto_meta where rewrite='".mysql_real_escape_string($rewrite_foto)."'") or die ("mySQL error!");

$f=$db->fetcharray ($r);

$help_section = (string)$foto_edit_help;

$title_cp = 'Работа с описанием категории фотоальбома - ';
$speedbar = ' | <a href="cpffoto.php">Фотогалерея</a> | <a href="cpfoto_edit.php?addedit='.$rewrite_foto.'">Изменить описание категории фотоальбома</a>';

check_login_cp('3_2','cpfoto_edit.php');

require_once 'template/header.php';

table_item_top('Работа с описанием категории фотоальбома и карта местоположения изображений', 'map.png');

// Редактировать параметры
if ($_POST['add_or_old']=='edit') {

        $form_full_news=addslashes($_POST['full_news']);
        $form_object = safeHTML($_POST['name_object']);
        
        $f['full'] = $form_full_news;
        $f['object'] = $form_object;
        
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
 
        $db->query  ( " UPDATE $db_foto_meta SET full='$form_full_news', object='$form_object', map='$maps_pos', mapstype='$typeMaps' where rewrite='".mysql_real_escape_string($rewrite_foto)."'" ) or die ( mysql_error() );

        logsto("Описание к категории фотоальбома <b>$f[item]</b> изменено.");

        $ok_news_add=true;

        $ok_news_add_message='Описание к категории фотоальбома <b>'.$f[item].'</b> изменено.';

}


// Вывод формы страницы
if ($ok_news_add) msg_text('80%',$def_admin_message_ok, $ok_news_add_message);

table_fdata_top ($def_item_form_data);

?>

<style type="text/css">
<!--
hr {
	border: 1px dotted #CCCCCC;
}
label.error {
	color: red;
        padding-left: 5px;
}
-->
</style>

<?php

include ('../includes/editor/tiny.php');
   
require_once '../includes/classes/ymaps.php';

$ym = new YMaps();

$ym->map_center = $def_map_center;
$ym->map_type = $def_map_type;

if ($f['map'] != '' and empty($maps_pos))
{
	$ym->map_center = $f['map'];
	$ym->map_type = $f['mapstype'];
	$map_center = explode(', ', $f['map']);
	$dolgota = $map_center[1];
	$shirota = $map_center[0];
}

if (!empty($maps_pos))
{
	$ym->map_center = $maps_pos;
	$ym->map_type = $typeMaps;
}

echo $ym->showMarker();

?>

<form action="cpfoto_edit.php<? echo $form_action; ?>" method="post" enctype="multipart/form-data" id="save_geo">
 <table width="980" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="right">Категория:</td>
    <td align="left"><strong><?php echo str_replace('#',' / ',$f['item']); ?></strong></td>
  </tr>
  <tr>
    <td align="right">Название объекта:</td>
    <td align="left"><input type="text" name="name_object" value="<?php echo $f['object']; ?>" maxlength="50" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Текст страницы:</td>
    <td align="left"><textarea name="full_news" cols="45" rows="5" id="area_full" style="width: 500px; height: 300px;"><?php echo stripcslashes($f['full']); ?></textarea></td>
  </tr>  
  <tr>
    <td colspan="2"><hr /></td>
  </tr>
  <tr>
    <td align="right">Карта:</td>
    <td align="left">
        <div id="map" style="border: 1px solid #999999;width:600px;height:300px"></div>
	<br>
	<input type="hidden" name="position" value="save">
	<input type="hidden" name="typemaps" value="map">
	&nbsp;Широта: <input type="text" name="shirota" id="shirota" value="<? echo $shirota; ?>" />
	&nbsp;Долгота: <input type="text" name="dolgota" id="dolgota" value="<? echo $dolgota; ?>" />
	<input type="checkbox" name="" value="" id="coord_toggler" /> Ручной ввод координат
    </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left"><input type="submit" name="save" value="Изменить" />
    <input type="hidden" name="add_or_old" value="edit" />
    <input type="hidden" name="addedit" value="<?php echo $f['rewrite']; ?>" />
    </td>
  </tr>
</table>
</form>

<?php

table_fdata_bottom();

require_once 'template/footer.php';

?>
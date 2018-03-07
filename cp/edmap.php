<?php
/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by Ilya K. & D.Madi
  =====================================================
  Файл: edmap.php
  -----------------------------------------------------
  Назначение: Положение фирмы на карте
  =====================================================
 */

session_start();

require_once './defaults.php';

$idident = intval($_REQUEST['id']);

$r = $db->query("select * from $db_users where selector='$idident'") or die("mySQL error!");
$f = $db->fetcharray($r);

$help_section = (string)$map_help;

$title_cp = $def_admin_map . ' - ';
$speedbar = ' | <a href="offers.php?REQ=auth&id=' . $idident . '">' . $def_admin_offers_k . ' id=' . $idident . '</a> | <a href="edmap.php?id=' . $idident . '">' . $def_admin_map . '</a>';

check_login_cp('1_0', 'edmap.php?id=' . $idident);

require_once 'template/header.php';

table_item_top($def_admin_map, 'map.png');

// Работа с картой

require_once '../includes/classes/ymaps.php';

$ym = new YMaps();

// Определяем адрес компании

$re1 = $db->query("SELECT * FROM $db_location WHERE locationselector='$f[location]'");
$fe1 = $db->fetcharray($re1);

if ($def_country_allow == "YES")
	$country = $fe1['location'] . ', '; 
else
	$city = $fe1['location'] . ', ';

if ($def_states_allow == "YES")
{
	$ree = $db->query("SELECT * FROM $db_states WHERE stateselector='$f[state]'");
	$fee = $db->fetcharray($ree);
	$state = $fee['state'] . ', ';
}

if ($def_country_allow == "YES")
	$city = $f['city'] . ', ';
$adress = $f['address'];

$find_maps = $country . $state . $city . $adress;

// Сохраняем координаты в базу данных

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

	$sql = 'UPDATE ' . $db_users . ' SET map="' . $maps_pos . '", mapstype="' . $typeMaps . '" 
			WHERE selector="' . $idident . '"';
	$db->query($sql);

	msg_text('80%', $def_admin_message_ok, 'Данные о координатах успешно обновлены!');

        logsto("Добавлены или изменены координаты у фирмы <b>$f[firmname]</b> (id=$idident)");
}

table_fdata_top('Работа с картой');
?>

<form id="search_form">
	<input type="text" id="search_geo" value="<? echo $find_maps; ?>" style="width: 520px;"/>
	<input type="submit" value="Найти по адресу" class="btn btn-success"/>
</form><br />

<?

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

<form action="edmap.php?id=<?= $idident ?>" method="post" id="save_geo">

	<div id="map" style="border: 1px solid #999999;width:600px;height:300px"></div>
	<br>
	<input type="submit" name="button" value="Сохранить" class="btn btn-warning" />
	<input type="hidden" name="position" value="save">
	<input type="hidden" name="typemaps" value="map">
	<input type="hidden" name="id" value="<?= $idident ?>">
	&nbsp;Широта: <input type="text" name="shirota" id="shirota" value="<? echo $shirota; ?>" />
	&nbsp;Долгота: <input type="text" name="dolgota" id="dolgota" value="<? echo $dolgota; ?>" />
	<input type="checkbox" name="" value="" id="coord_toggler" /> Ручной ввод координат
</form>
<br /><br />

<?
table_fdata_bottom();

require_once 'template/footer.php';
?>
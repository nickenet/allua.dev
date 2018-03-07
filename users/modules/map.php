<?php
/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi & Ilya K.
  =====================================================
  Файл: map.php
  -----------------------------------------------------
  Назначение: Положение фирмы на карте
  =====================================================
 */

if (!defined('ISB'))
{
	die("Hacking attempt!");
}

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
{
	$city = $f['city'] . ', ';
}

$adress = $f['address'];

$find_maps = $country . $state . $city . $adress;
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
        <td>
			<div id="TabbedPanels1" class="TabbedPanels">
				<ul class="TabbedPanelsTabGroup">
					<li class="TabbedPanelsTab" tabindex="0">Указать местоположение на карте</li>
				</ul>
				<div class="TabbedPanelsContentGroup">
					<div class="TabbedPanelsContent">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
								<td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;">Работа с картой</span></td>
											<td width="50">&nbsp;</td>
										</tr>
									</table>
									
								</td>
								<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
							</tr>
							<tr>
								<td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
								<td class="tb_cont">

									<form id="search_form">
										<input type="text" id="search_geo" value="<? echo $find_maps; ?>" style="width: 520px;"/>
										<input type="submit" value="Найти по адресу" class="btn btn-success"/>
									</form><br>

									<?

                                                                        $ym->map_center = $def_map_center;
                                                                        $ym->map_type = $def_map_type;

									if ($f['map'] != '')
									{
										$ym->map_center = $f['map'];
										$ym->map_type = $f['mapstype'];
										$map_center = explode(', ', $f['map']);
										$dolgota = $map_center[1];
										$shirota = $map_center[0];
									}

									echo $ym->showMarker();
									?>

									<form action="?REQ=authorize&mod=map" id="save_geo" method="post">
										<div id="map" style="width:600px;height:300px" class="thumbnail"></div>
										<br>
										<input type="submit" name="button" value="Сохранить" class="btn btn-warning">
										<input type="hidden" name="position" value="save">
										<input type="hidden" name="typemaps" value="map">
										<input type="hidden" name="selector" value="<?=$f['selector']?>">
										&nbsp;Широта: <input type="text" name="shirota" id="shirota" value="<? echo $shirota; ?>">
										&nbsp;Долгота: <input type="text" name="dolgota" id="dolgota" value="<? echo $dolgota; ?>">
										<input type="checkbox" name="" value="" id="coord_toggler" /> Ручной ввод координат<br/>
										<img id="loader_geo" src="<? echo "$def_mainlocation"; ?>/images/go.gif" alt="loading..." />
									</form>
									<div id="save_geo_result"></div>
                                                                        <? if (ifEnabled_user($f[flag], "maps")) echo ''; else echo '<div class="alert alert-error">Ваш <b>тарифный план</b> не позволяет использовать карту на Вашей странице в каталоге.</div>'; ?>
								</td>
								<td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
							</tr>
							<tr>
								<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_left_r.gif" width="3" height="1"></td>
								<td background="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif" width="3" height="1"></td>
								<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_right_r.gif" width="3" height="1"></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</td>
	</tr>
	<tr>
        <td>&nbsp;</td>
	</tr>
	<tr>
        <td>
			<div id="CollapsiblePanel1" class="CollapsiblePanel">
				<div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
				<div class="CollapsiblePanelContent">
<? echo $help_map; ?>
				</div>
			</div>
		</td>
	</tr>
	<tr>
        <td>&nbsp;</td>
	</tr>
	<tr>
        <td>&nbsp;</td>
	</tr>
</table>
<script type="text/javascript">
	<!--
	var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
	var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
	//-->
</script>
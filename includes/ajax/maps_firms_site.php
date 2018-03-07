<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Lomakin M. (http://astbiznes.isbmod.ru/) & D.Madi
=====================================================
 Файл: maps_firms_site.php
-----------------------------------------------------
 Назначение: Вывод всех фирм на карте сайтов
=====================================================
*/
session_start();

header("Content-type: text/html; charset=windows-1251");

include ("../../conf/config.php");
include ("../../conf/memberships.php");
include ("../../includes/functions.php");
include ("../../includes/$def_dbtype.php");
include ("../../connect.php");
include ("../../includes/sqlfunctions.php");
$lang = $def_language;
include ("../../lang/language.$lang.php");

if ($_POST['cat']!=0) $cat=intval($_POST['cat']);
if ($_POST['fetchcounter']!=0) $fetchcounter=intval($_POST['fetchcounter']);
$page1=intval($_POST['page1']);
$def_count_dir=intval($_POST['def_count_dir']);

$zapros_tarif="";
if ( $def_D_www != "YES") $zapros_tarif=" and flag <> 'D' ";
if ( $def_C_www != "YES") $zapros_tarif=" and flag <> 'C' ";
if ( $def_B_www != "YES") $zapros_tarif=" and flag <> 'B' ";
if ( $def_A_www != "YES") $zapros_tarif=" and flag <> 'A' ";

$LIMIT="LIMIT $page1, $def_count_dir";

$o_sort=" ORDER BY webcounter DESC";

if (isset($_SESSION['sort_web_site'])) {

		switch ($_SESSION['sort_web_site']) {
			  case 2:
			    $o_sort=" ORDER BY firmname";
			    break;
			  case 1:
			    $o_sort=" ORDER BY date";
			    break;
			  break;
			   default:
			   $o_sort=" ORDER BY webcounter DESC";
		}

}

if (empty($_SESSION['go_subcat_web']) or ($_SESSION['go_subcat_web']=="ALL")) {
    $like_sql1="$cat#%#%:%";
    $like_sql2="%:$cat#%#%:%";
    $like_sql3="%:$cat#%#%";
    $like_sql4="$cat#%#%";
} else {
    $like_sql1=$_SESSION['go_subcat_web'].':%';
    $like_sql2='%:'.$_SESSION['go_subcat_web'].':%';
    $like_sql3='%:'.$_SESSION['go_subcat_web'];
    $like_sql4=$_SESSION['go_subcat_web'];
}

$rmaps = $db->query ( "SELECT flag, firmname, map, selector, www FROM $db_users WHERE (category LIKE '$like_sql1' or category LIKE '$like_sql2' or category LIKE '$like_sql3' or category LIKE '$like_sql4') and firmstate = 'on' and www != '' $zapros_tarif $o_sort $LIMIT" );

$results_maps = mysql_num_rows ( $rmaps );

$coords="";
$fmaps['flag']='D';
$styleKeys="";
$Header="";
$Footer="";

if ($results_maps>0) {
for ( $maps=0; $maps<$results_maps; $maps++ )
{
$fmaps = $db->fetcharray  ( $rmaps );

	if ($fmaps['map'] != '') {
	$coords.="[$fmaps[map]],";

	switch($fmaps['flag']){
		case 'A': $iconFlag=$def_map_iconA;	break;
                case 'B': $iconFlag=$def_map_iconB;	break;
		case 'C': $iconFlag=$def_map_iconC;	break;
                default: $iconFlag=$def_map_iconD;
	}

$styleKeys.="$iconFlag,";
							 
	$Header.="'$fmaps[firmname]',";
	$link='<a href="'.$def_mainlocation.'/out.php?ID='.$fmaps['selector'].'">'.$fmaps['www'].'</a>';
	$Footer.="'$link',";
	
	}
}

if (isset ($coords)) {
$coords= rtrim($coords, ',');

?>

<script type="text/javascript">
        ymaps.ready(init);
        function init () {
		    var myMap = new ymaps.Map('map', {
                    center: [0, 0], 
                    zoom: 0,
                    type: 'yandex#<? echo $def_map_type; ?>'
                });
	clusterer = new ymaps.Clusterer();
	coords = [<? echo $coords; ?>]
	Header = [<? echo $Header; ?>]
	Footer = [<? echo $Footer; ?>]
	styleKeys = [<? echo $styleKeys; ?>];

if (coords.length > 1) {	
	myCollection = new ymaps.GeoObjectCollection();

for (var i = 0; i < coords.length; i++) {
myCollection.add(new ymaps.Placemark(coords[i]));}

myMap.geoObjects.add(myCollection);

myMap.setBounds(myMap.geoObjects.getBounds());

myCollection.removeAll();
}
else
{
myMap.zoomRange.get(<? echo $coords; ?>).then(function (range) {
myMap.setCenter(<? echo $coords; ?>, range[1]);
    });
}
	
for (var i = 0; i < coords.length; i++) {
        clusterer.add(new ymaps.Placemark(coords[i], {
	balloonContentHeader: Header[i],
        balloonContentFooter: Footer[i],
	iconImageColor: styleKeys[i]
        }, { preset: styleKeys[i] } ));
}

myMap.geoObjects.add(clusterer);
	myMap.controls
            .add('typeSelector')
	    .add('smallZoomControl', { right: 5, top: 75 })
            .add('mapTools');
       }
    </script>
	<div align="center" id="map" style="width:<? echo $def_map_width_my; ?>; height:<? echo $def_map_height_my; ?>;"></div>
<?php } } ?>
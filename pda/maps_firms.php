<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Lomakin M. (http://astbiznes.isbmod.ru/) & D.Madi
=====================================================
 Файл: maps_firms.php
-----------------------------------------------------
 Назначение: Вывод всех фирм на карте
=====================================================
*/
session_start();

header("Content-type: text/html; charset=windows-1251");

include ("../conf/config.php");
include ("../conf/memberships.php");
include ("../includes/functions.php");
include ("../includes/$def_dbtype.php");
include ("../connect.php");
include ("../includes/sqlfunctions.php");
$lang = $def_language;
include ("../lang/language.$lang.php");
include ("conf/config.php");

if ($_POST['cat']!=0) $cat=intval($_POST['cat']);
if ($_POST['subcat']!=0) $subcat=intval($_POST['subcat']);
if ($_POST['subsubcat']!=0) $subsubcat=intval($_POST['subsubcat']);
if ($_POST['fetchcounter']!=0) $fetchcounter=intval($_POST['fetchcounter']);
$page1=intval($_POST['page1']);
if ($_POST['def_count_dir']!=0) $def_count_dir=intval($_POST['def_count_dir']);
if ($_POST['string']!='') { $sstring=safeHTML($_POST['string']); $sstring=iconv('CP1251', 'UTF-8', $sstring); $WHERE = " ((firmname LIKE '%$sstring%') or (business LIKE '%$sstring%' ) or ( keywords LIKE '%$sstring%' ) ) "; }

$hide="";

if ($def_D_maps != "YES") $hide.=" AND flag <> 'D' ";
if ($def_C_maps != "YES") $hide.=" AND flag <> 'C' ";
if ($def_B_maps != "YES") $hide.=" AND flag <> 'B' ";
if ($def_A_maps != "YES") $hide.=" AND flag <> 'A' ";

if ($def_map_page=='YES')
{
$results_maps=$fetchcounter;
$LIMIT="LIMIT $page1, $def_count_dir";
}
else $LIMIT="";

If (isset($cat) and isset($subcat) and isset($subsubcat))
$WHERE="category LIKE '$cat#$subcat#$subsubcat%' or category LIKE '%:$cat#$subcat#$subsubcat:%' or category LIKE '%:$cat#$subcat#$subsubcat' or category LIKE '$cat#$subcat#$subsubcat'";
If (isset($cat) and isset($subcat) and empty($subsubcat))
$WHERE="category LIKE '%:$cat#$subcat#0:%' or category LIKE '$cat#$subcat#0:%' or category LIKE '%:$cat#$subcat#0' or category LIKE '$cat#$subcat#0'";
If (isset($cat) and empty($subcat) and empty($subsubcat))
$WHERE="category LIKE '$cat#0#0:%' or category LIKE '%:$cat#0#0:%' or category LIKE '%:$cat#0#0' or category LIKE '$cat#0#0'";

$rmaps = $db->query ( "SELECT flag, firmname, map, selector FROM $db_users WHERE ($WHERE) and firmstate = 'on' $hide $_SESSION[where_city] ORDER BY flag, firmname $LIMIT" );

$results_maps = $db->numrows ( $rmaps);

if ($results_maps>0) {
for ( $maps=0; $maps<$results_maps; $maps++ )
{
$fmaps = $db->fetcharray  ( $rmaps );

	if ($fmaps['map'] != '') {
	$coords.="[$fmaps[map]],";

	switch($fmaps[flag]){
		case 'A': $iconFlag=$def_map_iconA;	break;
                case 'B': $iconFlag=$def_map_iconB;	break;
		case 'C': $iconFlag=$def_map_iconC;	break;
                default: $iconFlag=$def_map_iconD;
	}

$styleKeys.="$iconFlag,";
							 
	$Header.="'$fmaps[firmname]',";
	$link='<a href="'.$def_mainlocation_pda.'/view.php?id='.$fmaps[selector].'">'.$def_page_mobile.'</a>';
	$Footer.="'$link',";
	
	}
}
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
	<div align="center" id="map" style="width:<? echo $def_map_width_my; ?>; height:<? echo $def_map_height_my;?>;"></div>
<?php } ?>
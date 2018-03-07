<?php /*

Шаблон вывода подкатегорий

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
    <td width="100%" valign="top" align="center">
        <table cellspacing="0" cellpadding="0" border="0" width="90%">
            <tr>
            <td width="50%" valign="top">

<?php

$res = round ( $results/2 );

for ( $i=0;$i<$res;$i++ )

{
	$f = $db->fetcharray ( $r );
        
        echo '<table border="0" cellspacing="0" cellpadding="0"><tr>';
        echo '<td align="right" valign="top" class="hidden-xs">'.imgM_Cat($f['img'],$f['catsubsubsel'],'subsubcat').'</td>';
        echo '<td align="left" valign="top">';

	if ( $f[fcounter] > 0 )

	{

		if ($def_rewrite == "YES") echo '<a href="'.$def_mainlocation.'/'.rewrite($fa['category']).'/'.rewrite($fa2['subcategory']).'/'.str_replace(' ', '_', rewrite($f['subsubcategory'])).'/'.$cat.'-'.$subcat.'-'.$f[catsubsubsel].'-0.html">';
		else echo '<a href="index.php?cat='.$cat.'&amp;subcat='.$f['catsubsel'].'&amp;subsubcat='.$f['catsubsubsel'].'">';

		echo '<span class="maincat">'.$f['subsubcategory'].'</a> &#187 </span>';

		if ($def_show_indexes == "YES") echo '<span class="count">['.$f['fcounter'].']</span>';
	}

	else { echo '<span class="emptycat">'.$f['subsubcategory'].'</span>'; }
        
        echo '</td></tr></table><br>';  
}

echo '</td>
        <td width="50%" valign="top">';

for ( $i=$res;$i<$results;$i++ )

{
	$f = $db->fetcharray ( $r );

	if ( $f[fcounter] > "0" )

	{

        echo '<table border="0" cellspacing="0" cellpadding="0"><tr>';
        echo '<td align="right" valign="top" class="hidden-xs">'.imgM_Cat($f['img'],$f['catsubsubsel'],'subsubcat').'</td>';
        echo '<td align="left" valign="top">';            

		if ($def_rewrite == "YES") echo '<a href="'.$def_mainlocation.'/'.rewrite($fa['category']).'/'.rewrite($fa2['subcategory']).'/'.str_replace(' ', '_', $f['subsubcategory']).'/'.$cat.'-'.$subcat.'-'.$f[catsubsubsel].'-0.html">';
		else echo '<a href="index.php?cat='.$cat.'&amp;subcat='.$f['catsubsel'].'&amp;subsubcat='.$f['catsubsubsel'].'">';

		echo '<span class="maincat">'.$f['subsubcategory'].'</a> &#187 </span>';

		if ($def_show_indexes == "YES") echo '<span class="count">['.$f['fcounter'].']</span>';
	}

	else { echo '<span class="emptycat">'.$f['subsubcategory'].'</span>';	}
        
        echo '</td></tr></table><br>'; 

}

?>

            </td>
            </tr>
        </table>
    </td>
    </tr>
</table>

<?php

echo $description_cat.'<br>';

if ($maps_view == 'YES') { ?>
 <script src="https://api-maps.yandex.ru/2.0.20/?load=package.full&lang=ru-RU" type="text/javascript"></script>
 <script type="text/javascript">
        ymaps.ready(init);
        function init () {
		    var myMap = new ymaps.Map('map', {
                    center: [0, 0], 
                    zoom: 0,
                    type: 'yandex#<?php echo $def_map_type; ?>'
                });
	clusterer = new ymaps.Clusterer();
	coords = [<?php echo $coords; ?>]
	Header = [<?php echo $Header; ?>]
	Footer = [<?php echo $Footer; ?>]
	styleKeys = [<?php echo $styleKeys; ?>];

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
myMap.zoomRange.get(<?php echo $coords; ?>).then(function (range) {
myMap.setCenter(<?php echo $coords; ?>, range[1]);
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
	<div align="center" id="map" style="width:<?php echo $def_map_width_my; ?>; height:<?php echo $def_map_height_my;?>;"></div>
 
<?php } ?>
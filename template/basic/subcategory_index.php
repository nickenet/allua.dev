<? /*

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

<?

$res = round ( $results/2 );

for ( $i=0;$i<$res;$i++ )

{
	$f = $db->fetcharray ( $r );
        
        echo '<table border="0" cellspacing="0" cellpadding="0"><tr>';
        echo '<td align="right" valign="top">'.imgM_Cat($f['img'],$f['catsubsel'],'subcat').'</td>';
        echo '<td align="left" valign="top">';        

	if ( $f['fcounter'] > 0 )

	{
		if ($def_rewrite == "YES") echo '<a href="'.$def_mainlocation.'/'.rewrite($fa['category']).'/'.rewrite($f['subcategory']).'/'.$categorymains.'-'.$f['catsubsel'].'-0.html">';
		else echo '<a href="'.$def_mainlocation.'/index.php?cat='.$categorymains.'&subcat='.$f['catsubsel'].'">';

		echo '<span class="maincat">'.$f['subcategory'].'</a> &#187 </span>';
		
		if ($def_show_indexes == "YES")
		{
                    echo '<span class="count">';
			if (($f['sccounter'] == 0) and ($f['ssccounter'] != 0)) echo "[$f[ssccounter]/$f[fcounter]]";
			if (($f['sccounter'] == 0) and ($f['ssccounter'] == 0)) echo "[$f[fcounter]]";
                    echo "</span>";
		}
		
		// Показать разделы подкатегорий
		if ($def_show_subsubcategories == "YES")

		{

		if ($def_empty_hidden == "YES") $sql = " AND fcounter > 0 "; else $sql = "";

			$r_subs = $db->query ( "SELECT fcounter, subsubcategory, catsubsubsel  FROM $db_subsubcategory WHERE catsubsel='$f[catsubsel]' AND catsel='$categorymains' $sql ORDER BY subsubcategory LIMIT $def_show_subs_number" );
			$results2 = $db->numrows ( $r_subs );

			if ($results2 > 0) echo '<br><br>';

			for ( $i2=0;$i2<$results2;$i2++ )

			{
				$f_subs = $db->fetcharray ( $r_subs );

				if ( $f_subs['fcounter'] > 0 )

				{
					if ($def_rewrite == "YES") echo '<a href="'.$def_mainlocation.'/'.rewrite($fa['category']).'/'.rewrite($f['subcategory']).'/'.rewrite($f_subs['subsubcategory']).'/'.$categorymains.'-'.$f['catsubsel'].'-'.$f_subs['catsubsubsel'].'-0.html">';
					else echo '<a href="'.$def_mainlocation.'/index.php?cat='.$categorymains.'&subcat='.$f['catsubsel'].'&subsubcat='.$f_subs['catsubsubsel'].'">';

					echo '<span class="subcat">'.$f_subs['subsubcategory'].'</span></a>';

					if ($def_show_indexes == "YES") echo '<span class="count">['.$f_subs['fcounter'].']</span>';

					if ($results2 > $i2+1) echo ', ';

				}

				else

				{ echo '<span class="emptycat2">'.$f_subs['subsubcategory'].'</span>'; if ($results2 > $i2+1) echo ', '; }

			}

			if ($results2 > 0) echo '<br><br>';
		}
                
	}

	else { echo '<span class="emptycat">'.$f['subcategory'].'</span>'; }
        
        echo '</td></tr></table><br>';        
}

echo '</td>
        <td width="50%" valign="top">';

for ( $i=$res;$i<$results;$i++ )

{
	$f = $db->fetcharray ( $r );
        
        echo '<table border="0" cellspacing="0" cellpadding="0"><tr>';
        echo '<td align="right" valign="top">'.imgM_Cat($f['img'],$f['catsubsel'],'subcat').'</td>';
        echo '<td align="left" valign="top">';         

	if ( $f['fcounter'] > 0)

	{
		if ($def_rewrite == "YES") echo '<a href="'.$def_mainlocation.'/'.rewrite($fa['category']).'/'.rewrite($f['subcategory']).'/'.$categorymains.'-'.$f['catsubsel'].'-0.html">';
		else echo '<a href="'.$def_mainlocation.'/index.php?cat='.$categorymains.'&subcat='.$f['catsubsel'].'">';

		echo '<span class="maincat">'.$f['subcategory'].'</a> &#187 </span>';
		
		if ($def_show_indexes == "YES")
		{
                    echo '<span class="count">';
			if (($f['sccounter'] == 0) and ($f['ssccounter'] != 0)) echo "[$f[ssccounter]/$f[fcounter]]";
			if (($f['sccounter'] == 0) and ($f['ssccounter'] == 0)) echo "[$f[fcounter]]";
                    echo '</span>';
		}
		
		// Показать разделы подкатегорий

		if ($def_show_subsubcategories == "YES")

		{

		if ($def_empty_hidden == "YES") $sql = " AND fcounter > 0 "; else $sql = "";

			$r_subs = $db->query ( "SELECT fcounter, subsubcategory, catsubsubsel FROM $db_subsubcategory WHERE catsubsel='$f[catsubsel]' AND catsel='$categorymains' $sql ORDER BY subsubcategory LIMIT $def_show_subs_number" );
			$results2 = $db->numrows ( $r_subs );

			if ($results2 > 0) echo '<br><br>';

			for ( $i2=0;$i2<$results2;$i2++ )

			{
				$f_subs = $db->fetcharray ( $r_subs );

				if ( $f_subs[fcounter] > 0 )

				{
					if ($def_rewrite == "YES") echo '<a href="'.$def_mainlocation.'/'.rewrite($fa['category']).'/'.rewrite($f['subcategory']).'/'.rewrite($f_subs['subsubcategory']).'/'.$categorymains.'-'.$f['catsubsel'].'-'.$f_subs['catsubsubsel'].'-0.html">';
					else echo '<a href="'.$def_mainlocation.'/index.php?cat='.$categorymains.'&subcat='.$f['catsubsel'].'&subsubcat='.$f_subs['catsubsubsel'].'">';

					echo '<span class="subcat">'.$f_subs['subsubcategory'].'</span></a>';

					if ($def_show_indexes == "YES") echo '<span class="count">['.$f_subs['fcounter'].']</span>';

					if ($results2 > $i2+1) echo ', ';
				}

				else { echo '<span class="emptycat2">'.$f_subs['subsubcategory'].'</span>'; if ($results2 > $i2+1) echo ', '; }
			}

			if ($results2 > 0) echo '<br><br>';
		}
	}

	else { echo '<span class="emptycat">'.$f['subcategory'].'</span>'; }
        
        echo '</td></tr></table><br>';         
}

?>
            </td>
            </tr>
        </table>
    </td>
    </tr>
</table><br><br>

<?

echo $description_cat.'<br><br>';

if ($maps_view == 'YES') { ?>
 <script src="http://api-maps.yandex.ru/2.0.20/?load=package.full&lang=ru-RU" type="text/javascript"></script>
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
 
<? } ?>
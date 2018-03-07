<?php /*

Шаблон вывода верхней части быстрого поиска

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}
?>

  <div align="left">
    &nbsp;&nbsp;&nbsp;<?php echo "$def_company_search <b>( $words )</b>
     &nbsp;&nbsp;[$def_results: <b>$results_amount</b> // [ $sdate1, $sdate3 ]"; ?><br>
  </div>
 <br>
 
<?php if ($maps_view == 'YES') { ?>
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


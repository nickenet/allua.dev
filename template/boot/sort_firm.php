<?php /*

Шаблон сортировки новостей и карта

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

        $implode_sort= implode( " | ", $sort ).' | <a href="#" id="maps_view">'.$def_show_hide_map.'</a>';

?>

<div style="text-align:right; padding: 7px;"><form name="news_set_sort" id="news_set_sort" method="post" action=""><?php echo $implode_sort; ?>

<input type="hidden" name="dlenewssortby" id="dlenewssortby" value="firmname" />
<input type="hidden" name="dledirection" id="dledirection" value="asc" />
<input type="hidden" name="set_new_sort" id="set_new_sort" value="<?php echo $find_sort; ?>" />
<input type="hidden" name="set_direction_sort" id="set_direction_sort" value="<?php echo $direction_sort; ?>" />
<script type="text/javascript" language="javascript">
$(document).ready(function(){
  $("#maps_view").click(function(){
    $("#map").toggle();
  });
}); 

function change_sort(sort, direction){

  var frm = document.getElementById('news_set_sort');

  frm.dlenewssortby.value=sort;
  frm.dledirection.value=direction;

  frm.submit();
  return false;
};
</script></form>
<div class="form-inline" style="padding:3px;" role="form">
<div class="form-group has-warning">
<form name="city_set_filtr" method="post" action="">Город: <input class="form-control" type="text" name="Smycity" value="<?php echo $_SESSION['smycity']; ?>" /> <input class="btn btn-primary" type="submit" name="Bmycity" value="&raquo;" /></form></div>
</div>
</div>
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
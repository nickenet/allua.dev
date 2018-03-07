<? /*

Шаблон вывода верхей части категорий

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<div align="right">
<div id="flavor-nav" class="wrapper-dropdown"><span><? echo $def_mob_filter; ?></span>
    <ul class="dropdown">
        <li><a rel="all"><? echo $def_mob_all; ?></a></li>
<?

if ($map_filter_ok==1) echo '<li><a rel="map" id="maps">'.$def_mob_maps.'</a></li>';
if ($mobile_filter_ok==1) { echo '<li><a rel="mob">'.$def_mob_mob.'</a></li>';
    foreach ($operator_mob as $value) {
        echo '<li><a rel="'.$value.'">'.$value.'</a></li>';
    }
}

?>
    </ul>
</div>
</div>

<? if ($map_filter_ok==1) { ?>

<script src="https://api-maps.yandex.ru/2.0.20/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
    $('#maps').click( function() {

        $.ajax({
          type: 'POST',
          url: 'maps_firms.php',
          data: '<? echo $string_where; ?>',
          success: function(data){
            $('#results').html(data);
          }
        });

    });
</script>

<? } ?>

<div id="all-flavors">


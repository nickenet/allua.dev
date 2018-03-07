<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: maps_firm.php
-----------------------------------------------------
 Назначение: Подключение карт и отображение на карте
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

           // Карты
	   if ( $def_country_allow == "YES" )
        	{ $map_country = $country; $map_city = $city; }
	   else
	        { $map_country = $def_map_country; $map_city = $city; }

	   if ($def_states_allow == "YES")  $map_state = $state;

		$adress_google=iconv("windows-1251", "UTF-8", "$f[address], $map_city, $map_country");

	   $map = "$def_map_link: <a rel=\"nofollow\" href=\"https://maps.google.ru/maps?q=$adress_google\" target=\"blank\">Google Maps</a> | <a rel=\"nofollow\" href=\"https://maps.yandex.ru/?text=$adress_google\" target=\"blank\">Яндекс.Карты</a>";
           $template->replace("map", $map);

           $parts_wh = array();
           preg_match('#wym(\d+)_hym(\d+)#', $template_sub, $parts_wh);
           $widht_map = $parts_wh[1];
           $height_map = $parts_wh[2];
           $replace_maps_tags='Yandex_map_wym'.$widht_map.'_hym'.$height_map;

           // Положение на карте

           if (($f['map']!='') and (ifEnabled($f['flag'], "maps"))) {

                require_once 'includes/classes/ymaps.php';

                $ym = new YMaps();
                $ym->map_center=$f['map'];
                $ym->map_type=$f['mapstype'];
                $ym->map_zoom=$def_map_zoom;
                $ym->firmname=$f['firmname'];
                $ym->adress=$f['address'];
                $ym->phone=$f['phone'];
		$maps_view_all=explode(',',$f['map']);
		$shirota=round($maps_view_all[0],3);
		$dolgota=round($maps_view_all[1],3);

		$template->replace("shirota", $shirota); $template->replace("dolgota", $dolgota);
                $template->replace("koordinata", $def_koord);
                $template->replace("shirota_text", $def_shirota); $template->replace("dolgota_text", $def_dolgota);

                if ($_GET['type'] == "print") {

			$type_static_map="map";
			if ($f['mapstype']=="map") $type_static_map="map";
			if ($f['mapstype']=="satellite") $type_static_map="sat";
			if ($f['mapstype']=="hybrid") $type_static_map="sat,skl";
			if ($f['mapstype']=="publicMap") $type_static_map="pmap";
			if ($f['mapstype']=="publicMapHybrid") $type_static_map="pmap,sat,skl";

                    $ymap="<img src=\"https://static-maps.yandex.ru/1.x/?ll=$dolgota,$shirota&size=$widht_map,$height_map&z=$def_map_zoom&l=$type_static_map&pt=$dolgota,$shirota\" />";
                    $template->replace("$replace_maps_tags",$ymap);

                }
		
                if ($_GET['map']=='big') {

                        $template->replace("Yandex_map_big",$ym->showMap().'<br /><div id="ymap" class="border_maps" style="width:'.$def_map_width_big.'px;height:'.$def_map_height_big.'px;"></div><br />' );

                        $template->replace("$replace_maps_tags", "");

                } else {

                        $ym->link_to_big_map='<a rel="nofollow" href="'.$def_mainlocation.'/view.php?id='.$f['selector'].'&cat='.$cat.'&subcat='.$subcat.'&subsubcat='.$subsubcat.'&map=big">'.$def_big_maps.'</a>';
                
                        $maps_small = $ym->showMap().'<br /><div id="ymap" class="border_maps" style="width:'.$widht_map.'px;height:'.$height_map.'px;"></div><br />';
                        $template->replace("$replace_maps_tags",$maps_small );

                        $template->replace("Yandex_map_big", "");
                }

            } else { 
                $template->replace("$replace_maps_tags", ""); $template->replace("Yandex_map_big", "");
                $template->replace("shirota", ""); $template->replace("dolgota", "");
                $template->replace("koordinata", "");
                $template->replace("shirota_text", ""); $template->replace("dolgota_text", "");
                }


?>

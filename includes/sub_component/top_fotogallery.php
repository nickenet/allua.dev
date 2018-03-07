<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: top_fotogallery.php
-----------------------------------------------------
 Назначение: Вывод описания фотогалереи и карты
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

        $template_tplf=set_tFile('top_fotogallery.tpl');

        $template = new Template;

        $template->load($template_tplf);

        $template->replace("fulltext", $full_text_foto);
        
        
           $parts_wh = array();
           preg_match('#wym(\d+)_hym(\d+)#', $template_tplf, $parts_wh);
           $widht_map = $parts_wh[1];
           $height_map = $parts_wh[2];
           $replace_maps_tags='Yandex_map_wym'.$widht_map.'_hym'.$height_map;
           
        if ($map_foto!='') {   
            
                require_once 'includes/classes/ymaps.php';

                $ym = new YMaps();
                $ym->map_center=$map_foto;
                $ym->map_type=$mapstype_foto;
                $ym->map_zoom=$def_map_zoom;
                $ym->firmname=$name_object;
                
                $maps_small = $ym->showMap().'<br /><div id="ymap" class="border_maps" style="width:'.$widht_map.'px;height:'.$height_map.'px;"></div><br />';
                $template->replace("$replace_maps_tags",$maps_small );
                
        } else $template->replace("$replace_maps_tags", "");


        $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");
        
        $template->publish();

?>

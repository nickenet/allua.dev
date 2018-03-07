<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: searchform.php
-----------------------------------------------------
 Назначение: Форма быстрого поиска
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

echo qautocomplete_echo(); 

if ($def_serch_form_view_type==1) {

        if (($def_index_state == "YES") and ( $def_states_allow == "YES")) {

        	$r_index = $db->query ( "SELECT * FROM $db_states ORDER BY state" );
                $results_amount_index = $db->numrows ( $r_index );
                $select_location = "<option value=\"ANY\">$def_search_state</option>";

                for($i_index=0;$i_index<$results_amount_index;$i_index++){
                        $f_index=$db->fetcharray($r_index);
                        $select_location .= "<option value=\"$f_index[stateselector]\"> &#187 $f_index[state]</option>\n";
                }
        } else {

        	$r_index = $db->query ( "SELECT * FROM $db_location ORDER BY location" );
                $results_amount_index = $db->numrows ( $r_index );

                if ($def_country_allow == "YES") $select_location .= "<option value=\"ANY\">$def_search_country</option>";
                else $select_location .= "<option value=\"ANY\">$def_search_city</option>";

                for($i=0;$i<$results_amount_index;$i++){
                        $f_index=$db->fetcharray($r_index);
                        $select_location .= "<option value=\"$f_index[locationselector]\"> &#187 $f_index[location]</option>\n";
                }
        }

	$offers_type = "<option value=\"ANY\">$def_search_offers</option>\n";
	$offers_type .= "<option value=\"1\"> &#187 $def_offer_1</option>\n";
	$offers_type .= "<option value=\"2\"> &#187 $def_offer_2</option>\n";
	$offers_type .= "<option value=\"3\"> &#187 $def_offer_3</option>\n";

        $template_sf = new Template;

        $template_sf->set_file('searchform_type1.tpl');

        $template_sf->replace("bgcolor", $def_form_back_color_search);
        $template_sf->replace("file_find_company", "$def_mainlocation/search-1.php");
        $template_sf->replace("file_find_product", "$def_mainlocation/search-2.php");
        $template_sf->replace("file_find_images", "$def_mainlocation/search-4.php");
        $template_sf->replace("text_find_company", $def_search_company);
        $template_sf->replace("text_find_product", $def_search_product);
        $template_sf->replace("text_find_images", $def_search_images);
        $template_sf->replace("select_location", $select_location);
        $template_sf->replace("offers_type", $offers_type);

        $template_sf->replace("button_search", $def_search);

        $template_sf->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_sf->publish();

} else {

        $template_sf = new Template;

        $template_sf->set_file('searchform_type2.tpl');

        $template_sf->replace("bgcolor", $def_form_back_color_search);
        $template_sf->replace("dir_to_main", $def_mainlocation);
        $template_sf->replace("text_find_company", $def_search_firms);
        $template_sf->replace("text_find_product", $def_search_offerss);
        $template_sf->replace("text_find_pub", $def_search_pub);
        $template_sf->replace("text_find_price", $def_search_xls);
        $template_sf->replace("text_find_images", $def_search_img);

        $template_sf->replace("button_search", $def_search);

        $template_sf->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_sf->publish();
}

?>




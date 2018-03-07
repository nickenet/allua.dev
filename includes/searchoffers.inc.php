<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: searchoffers.php
-----------------------------------------------------
 Назначение: Форма поиска по продукции
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

echo qautocomplete_echo();

        $template_offers = new Template;

        $template_offers->set_file('searchform_offers.tpl');

        $template_offers->replace("bgcolor", $def_form_back_color_search);
        $template_offers->replace("file_find", "$def_mainlocation/search-2.php");
        $template_offers->replace("text_find", $def_search_product);
        $template_offers->replace("rezult", htmlspecialchars($words,ENT_QUOTES,$def_charset));

        if (($_POST['type']=='ANY') or ($_GET['type']=='ANY')) $offers_type_f = '<option value="ANY" selected>'.$def_search_offers.'</option>'; else $offers_type_f = '<option value="ANY">'.$def_search_offers.'</option>';
        if (($_POST['type']==1) or ($_GET['type']==1)) $offers_type_f .= '<option value="1" selected> &#187 '.$def_offer_1.'</option>'; else $offers_type_f .= '<option value="1"> &#187 '.$def_offer_1.'</option>';
        if (($_POST['type']==2) or ($_GET['type']==2)) $offers_type_f .= '<option value="2" selected> &#187 '.$def_offer_2.'</option>'; else $offers_type_f .= '<option value="2"> &#187 '.$def_offer_2.'</option>';
        if (($_POST['type']==3) or ($_GET['type']==3)) $offers_type_f .= '<option value="3" selected> &#187 '.$def_offer_3.'</option>'; else $offers_type_f .= '<option value="3"> &#187 '.$def_offer_3.'</option>';

        $template_offers->replace("offers_type", $offers_type_f);

        $template_offers->replace("button_search", $def_search);
        $template_offers->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_offers->publish();

?>
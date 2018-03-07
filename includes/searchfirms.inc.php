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
 Назначение: Форма быстрого поиска по организациям
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

echo qautocomplete_echo();

if (($def_index_state == "YES") and ( $def_states_allow == "YES"))
{
	$r_index = $db->query ( "SELECT * FROM $db_states ORDER BY state" );
	$results_amount_index = $db->numrows ( $r_index );
	if ($_POST['location']=='ANY') $select_location = '<option value="ANY" selected>'.$def_search_state.'</option>'; else $select_location = '<option value="ANY">'.$def_search_state.'</option>';

	for($i_index=0;$i_index<$results_amount_index;$i_index++){
		$f_index=$db->fetcharray($r_index);

                if ($_POST['location']==$f_index[stateselector]) $select_location .= '<option value="'.$f_index[stateselector].'" selected> &#187 '.$f_index[state].'</option>';
                else $select_location .= '<option value="'.$f_index[stateselector].'"> &#187 '.$f_index[state].'</option>';
	}
}

else

{
	$r_index = $db->query ( "SELECT * FROM $db_location ORDER BY location" );

	$results_amount_index = $db->numrows ( $r_index );

	if ($def_country_allow == "YES") $to_any_s=$def_search_country; else $to_any_s=$def_search_city;

        if ($_POST['location']=='ANY') $select_location .= '<option value="ANY" selected>'.$to_any_s.'</option>'; else $select_location .= '<option value="ANY">'.$to_any_s.'</option>';

	for($i=0;$i<$results_amount_index;$i++){
		$f_index=$db->fetcharray($r_index);

		if ($_POST['location']==$f_index[locationselector]) $select_location .= '<option value="'.$f_index[locationselector].'" selected> &#187 '.$f_index[location].'</option>';
                else $select_location .= '<option value="'.$f_index[locationselector].'"> &#187 '.$f_index[location].'</option>';
	}
}

        $template_firma = new Template;

        $template_firma->set_file('searchform_firma.tpl');

        $template_firma->replace("bgcolor", $def_form_back_color_search);
        $template_firma->replace("file_find", "$def_mainlocation/search-1.php");
        $template_firma->replace("text_find", $def_search_company);
        $template_firma->replace("rezult", htmlspecialchars($words,ENT_QUOTES,$def_charset));
        $template_firma->replace("select_location", $select_location);


        $template_firma->replace("button_search", $def_search);

        $template_firma->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_firma->publish();
?>



<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: search.php
-----------------------------------------------------
 Назначение: Расширенный поиск
=====================================================
*/

include ( "./defaults.php" );

$incomingline = $def_search_adv;
$help_section = $adv_search_help;

include ( "./template/$def_template/header.php" );

main_table_top($def_search_adv);

$template = new Template;

$template->set_file('search.tpl');

$template->replace("bgcolor", $def_form_back_color);

$template->replace("category", $def_category);

 $r = $db->query  ( "SELECT selector, category FROM $db_category ORDER BY category" );
 $results_amount = mysql_num_rows ( $r );

 $cat_view_find = '<option value="ANY">'.$def_search_category.'</option>';

    for ( $i=0;$i<$results_amount;$i++ )

        {
            $f = $db->fetcharray  ( $r );
            $cat_view_find .= '<option value="'.$f['selector'].'">'.$f['category'].'</option>';
        }

 $db->freeresult  ( $r );

$template->replace("cat_view", $cat_view_find);

$template->replace("company", $def_company);
$template->replace("description", $def_description);
$template->replace("keywords", $def_keywords);

if ($def_country_allow == "YES") $location_def=$def_country; else $location_def=$def_city;
$template->replace("location", $location_def);

if ($def_country_allow == "YES") $location_view = '<option value="ANY">'.$def_search_country.'</option>';
else $location_view = '<option value="ANY">'.$def_search_city.'</option>';

$r = $db->query  ( "SELECT locationselector, location FROM $db_location ORDER BY location" );
$results_amount = mysql_num_rows ( $r );

    for ( $i=0; $i < $results_amount; $i++ )

        {
            $f = $db->fetcharray  ( $r );
            $location_view .= '<option value="'.$f['locationselector'].'">'.$f['location'].'</option>';
        }

$db->freeresult  ( $r );

$template->replace("location_view", $location_view);

if ( $def_states_allow == "YES" )

{
    $template->replace("state", $def_state);

	$state_view = '<option value="ANY">'.$def_search_state.'</option>';

	$r = $db->query  ( "SELECT stateselector, state FROM $db_states ORDER BY state" );
	$results_amount = mysql_num_rows ( $r );

	for ( $i=0; $i < $results_amount; $i++)

	{

		$f = $db->fetcharray  ( $r );
		$state_view .= '<option value="'.$f['stateselector'].'">'.$f['state'].'</option>';

	}

	$db->freeresult  ( $r );
        
        $template->replace("state_view", $state_view);
        
}else {
    $template->replace("state", "");
    $template->replace("state_view", "");
}

if ( $def_country_allow == "YES" ) {
    $template->replace("city", $def_city);
} else {
    $template->replace("city", "");
}

$template->replace("address", $def_address);
$template->replace("zip", $def_zip);
$template->replace("phone", $def_phone);
$template->replace("fax", $def_fax);
$template->replace("mobile", $def_mobile);
$template->replace("icq", $def_icq);
$template->replace("manager", $def_manager);
$template->replace("mail", $def_email);
$template->replace("www", $def_webpage);

if ($def_reserved_1_enabled == "YES") $template->replace("reserved_1", $def_reserved_1_name);
if ($def_reserved_2_enabled == "YES") $template->replace("reserved_2", $def_reserved_2_name);
if ($def_reserved_3_enabled == "YES") $template->replace("reserved_3", $def_reserved_3_name);

$template->replace("num_company_page", $def_search_company_num);

$template->replace("search", $def_search);

$template->replace("dir_to_main", $def_mainlocation);
$template->replace("catalog", str_replace('http://', '', $def_mainlocation));
$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

$template->publish();

main_table_bottom();

include ( "./template/$def_template/footer.php" );

?>
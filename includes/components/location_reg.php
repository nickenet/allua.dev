<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.MAdi
=====================================================
 Файл: location_reg.php
-----------------------------------------------------
 Назначение: Выводит список размещения компании (страна, область, город)
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if ( $def_country_allow == "YES") $location_def=$def_country; else $location_def=$def_city;
$template->replace("location", $location_def);

$r = $db->query  ( "SELECT * FROM $db_location ORDER BY location" );
$results_amount = mysql_num_rows ( $r );

    for ( $i=0; $i < $results_amount; $i++ ){

	$f =  $db->fetcharray( $r );
        if ($_POST['location'] == $f['locationselector']) $location_view .= '<option value="'.$f['locationselector'].'" selected>'.$f['location'].'</option>';
	else $location_view .= '<option value="'.$f['locationselector'].'">'.$f['location'].'</option>';
    }

$db->freeresult  ( $r );
$template->replace("location_view", $location_view);

if ( $def_states_allow == "YES" ) {

    $template->replace("state", $def_state);

    $r = $db->query  ( "SELECT * FROM $db_states ORDER BY state" );
    $results_amount = mysql_num_rows ( $r );

    for ( $i=0; $i < $results_amount; $i++ ) {

	$f = $db->fetcharray ( $r );
        if ($_POST[state] == $f[stateselector]) $state_view .= '<option value="'.$f['stateselector'].'" selected>'.$f['state'].'</option>';
	else $state_view .= '<option value="'.$f['stateselector'].'">'.$f['state'].'</option>';
    }

    $db->freeresult  ( $r );

    $template->replace("state_view", $state_view);

} else {
    $template->replace("state", "");
    $template->replace("state_view", "");
}

if ( $def_country_allow == "YES" ) {
    $template->replace("city", $def_city);
    $template->replace("rezult_city", $city);
} else {
    $template->replace("city", "");
    $template->replace("rezult_city", "");
}

?>

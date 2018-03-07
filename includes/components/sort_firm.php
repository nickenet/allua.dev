<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: sort_firm.php
-----------------------------------------------------
 Назначение: Сортировка фирм
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

	if( ! $do ) $do = "main";

	$find_sort = "sort_" . $do;
	$direction_sort = "direction_" . $do;

	$find_sort = str_replace( ".", "", $find_sort );
	$direction_sort = str_replace( ".", "", $direction_sort );

	$sort = array ();
	$allowed_sort = array ('firmname', 'counter', 'selector', 'date_mod' );

	$soft_by_array = array (

	'firmname' => array (

	'name' => $def_sort_cat_name, 'value' => "firmname", 'direction' => "asc", 'image' => "" ),

	'counter' => array (

	'name' => $def_sort_cat_rating, 'value' => "counter", 'direction' => "desc", 'image' => "" ),

	'selector' => array (

	'name' => $def_sort_cat_reg, 'value' => "selector", 'direction' => "desc", 'image' => "" ),

       	'date_mod' => array (

	'name' => $def_sort_cat_mod, 'value' => "date_mod", 'direction' => "desc", 'image' => "" )

	 )

	;

	if( isset( $_SESSION[$direction_sort] ) AND ($_SESSION[$direction_sort] == "desc" OR $_SESSION[$direction_sort] == "asc") ) $direction = $_SESSION[$direction_sort];
	else $direction = "asc";

	if( isset( $_SESSION[$find_sort] ) AND $_SESSION[$find_sort] AND in_array( $_SESSION[$find_sort], $allowed_sort ) ) $soft_by = $_SESSION[$find_sort];
	else $soft_by = "firmname";

        if( strtolower( $direction ) == "asc" ) {

		$soft_by_array[$soft_by]['image'] = "<img src=\"$def_mainlocation/images/sortA.gif\" alt=\"\" />&nbsp;";
		$soft_by_array[$soft_by]['direction'] = "desc";

	} else {

		$soft_by_array[$soft_by]['image'] = "<img src=\"$def_mainlocation/images/sortZ.gif\" alt=\"\" />&nbsp;";
		$soft_by_array[$soft_by]['direction'] = "asc";
	}

	foreach ( $soft_by_array as $value ) {

		$sort[] = $value['image'] . "<a href=\"#\" onclick=\"change_sort('{$value['value']}','{$value['direction']}'); return false;\">" . $value['name'] . "</a>";
	}

?>

<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya
=====================================================
 Файл: topcats.php
-----------------------------------------------------
 Назначение: Популярные категории
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

table_top  ($def_top_categories);

$cache->setModule('cattop');

if ( !$cache->isActive() ) 
{ 
	$top_cat_q = $db->query("SELECT selector, category, top FROM $db_category
		WHERE top > 0 AND fcounter > 0
		ORDER BY top DESC
		LIMIT $def_show_topcat_number");
	$top_cat_list = array();
	while ( $row = mysql_fetch_assoc($top_cat_q) )
	{
		$top_cat_list[] = $row;
	}
	
	$cache->save($top_cat_list);
}
else
{
	$top_cat_list = $cache->get();
}
 
$cache->unsetModule();
 
foreach ($top_cat_list as $top_cat_res)
{
	echo '&nbsp;<img src="' . $def_mainlocation . '/template/' 
		. $def_template . '/images/topcat.gif" border="0" alt="">&nbsp;';

 	echo '<a href="' . $def_mainlocation . '/index.php?category=' . $top_cat_res['selector'] . '">
		<b><u>' . $top_cat_res['category'] . '</u></b></a>
		&nbsp;&nbsp;<span class=sideboxtext>(<b>' . $top_cat_res['top'] . '</b> ' 
			. $def_visitors . ')</span><br><br>';
}

table_bottom();

?>

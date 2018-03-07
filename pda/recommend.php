<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Maid
=====================================================
 Файл: recomend.php
-----------------------------------------------------
 Назначение: Рекомендуемые фирмы
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if ($def_onlypaid == 'YES') 
{
	$hide_d = ' AND flag <> "D" ';
}

	$top_q = "SELECT selector, business, firmname FROM $db_users WHERE firmstate='on' $hide_d $_SESSION[where_city] ORDER BY hits_m DESC, countrating DESC LIMIT $def_show_number_box";
	$top_q = $db->query($top_q);
	$top_r = $db->numrows($top_q);
	
	$top_res_list = array();
	for ($top_f = 0; $top_f < $top_r; $top_f++)
	{
		$top_res = $db->fetcharray($top_q);
		$top_res['business'] = parseDescription("Z", $top_res['business']);
		$top_res['date'] 	 = undate($top_res['date'], $def_datetype);
                echo '&nbsp;&raquo; <a href="'.$def_mainlocation_pda.'/view.php?id='.$top_res['selector'].'">'.$top_res['firmname'].'</a><br />';
	}

?>
<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya
=====================================================
 Файл: top.php
-----------------------------------------------------
 Назначение: Популярные фирмы
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

table_top  ($def_top10);

if ($def_onlypaid == 'YES') 
{
	$hide_d = ' AND flag <> "D" ';
}

$cache->setModule('top');

if ( !$cache->isActive() ) 
{ 
	$top_q = "SELECT category, selector, flag, business, city, domen, firmname, theme, counter, date, location, state FROM $db_users WHERE firmstate='on' $hide_d ORDER BY hits_m DESC, countrating DESC LIMIT $def_show_number_box";
	$top_q = $db->query($top_q);
	$top_r = $db->numrows($top_q);
	
	$top_res_list = array();
	for ($top_f = 0; $top_f < $top_r; $top_f++)
	{
		$top_res = $db->fetcharray($top_q);
		$top_res['business'] = parseDescription("Z", $top_res['business']);
		$top_res['date'] 	 = undate($top_res['date'], $def_datetype);

		$reet = $db->query ( "SELECT location FROM $db_location WHERE locationselector = '$top_res[location]'" );
 		$feet = $db->fetcharray ( $reet );
 		$top_res['location_name'] = $feet[location];

 	if ( $def_states_allow == 'YES' ) 
 	{
 		$riit = $db->query ( "SELECT state FROM $db_states WHERE stateselector = '$top_res[state]'" );
		$fiit = $db->fetcharray ( $riit );
		$top_res['state_name'] = $fiit[state];
 	}
		$top_res_list[] = $top_res;
	}
	
	$cache->save($top_res_list);
}
else
{
	$top_res_list = $cache->get();
}

$cache->unsetModule();

foreach ($top_res_list as $top_res)
{
 	$category_list = explode(':', $top_res['category']);
 	$category_list = explode('#', $category_list[0]);

	if ($def_logo_block=="YES") 
	{
		$ikonka = "nologo.gif";
	
		for ($xxl = 0; $xxl < count($logo_block); $xxl++)
		{
			$rlogo_block = explode(".", $logo_block[$xxl]);
			if ($rlogo_block[0] == $top_res['selector']) 
			{
				$ikonka = $logo_block[$xxl];
			}
		}
	
		echo '&nbsp;<img src="' . $def_mainlocation . '/logo/' . $ikonka . '" width="' . $def_logo_block_width . '" height="' . $def_logo_block_height . '" border="0" alt="" align="middle">&nbsp;';
	}

	else
	{
	 	echo '&nbsp;<img src="' . $def_mainlocation . '/template/' . $def_template 
	 		. '/images/topcat.gif" border="0" alt="">&nbsp;';
	}
	
 	$descr = '';
 	if ($def_descriptions_show == 'YES')
 	{
 		if (   (($top_res['flag'] == 'D') and ($def_D_description == 'YES')) 
 			or (($top_res['flag'] == 'C') and ($def_C_description == 'YES')) 
 			or (($top_res['flag'] == 'B') and ($def_B_description == 'YES')) 
 			or (($top_res['flag'] == 'A') and ($def_A_description == 'YES'))   )

 		{
 			if ($top_res['business'] != '')
 			{
 				$descr = '<br><br>&nbsp;&nbsp;<span class="boxdescr">' . $top_res['business'] . '</span>';
 			}
 		}
 	}

 	$location = $top_res['location_name'];
 	if ( $def_states_allow == 'YES' ) 
 	{
 		$location .= ', ' . $top_res['state_name'];
 	}
 	
 	if ( $def_country_allow == 'YES' ) 
 	{
 		$location .= ', ' . $top_res['city'] . '.';
 	}

        if (($top_res['theme']!='') and ($top_res['domen']!='') and (ifEnabled($top_res['flag'], "social"))) $link_tot = $def_mainlocation.'/'.$top_res['domen'];
        else $link_tot = $def_mainlocation.'/view.php?id='.$top_res['selector'].'&amp;cat='.$category_list[0].'&amp;subcat='.$category_list[1].'&amp;subsubcat='.$category_list[2];

 	echo '<a href="'.$link_tot.'"><b><u>'.$top_res['firmname'].'</u></b></a> - '.$location.' '.$descr.'<br><br>&nbsp;&nbsp;<span class="sideboxtext">(<b>'.$top_res['counter'].'</b> '.$def_visitors.' '.$def_since.$top_res['date'].')</span><br><br>';
}

table_bottom();

?>
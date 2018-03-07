<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya
=====================================================
 Файл: last.php
-----------------------------------------------------
 Назначение: Новые фирмы
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

table_top  ($def_last10);

if ($def_onlypaid == 'YES') 
{
	$hide_d = ' AND flag <> "D" ';
}

$cache->setModule('last');

if ( !$cache->isActive() ) 
{ 
	$recent_q = "SELECT category, selector, business, city, flag, domen, firmname, theme, date, location, state FROM $db_users WHERE firmstate='on' $hide_d ORDER BY selector DESC LIMIT $def_show_number_box";
	$recent_q = $db->query($recent_q);
	$recent_r = $db->numrows($recent_q);
	
	$recent_res_list = array();
	for ($recent_f = 0; $recent_f < $recent_r; $recent_f++)
	{
		$recent_res = $db->fetcharray($recent_q);
		$recent_res['business'] = parseDescription("Z", $recent_res['business']);
		$recent_res['date'] 	= undate($recent_res['date'], $def_datetype);


 		$ree = $db->query ( "SELECT location FROM $db_location WHERE locationselector = '$recent_res[location]'" );
 		$fee = $db->fetcharray ( $ree );
 		$recent_res['location_name'] = $fee[location];

 	if ( $def_states_allow == 'YES' ) 
 	{
 		$rii = $db->query ( "SELECT state FROM $db_states WHERE stateselector = '$recent_res[state]'" );
		$fii = $db->fetcharray ( $rii );
		$recent_res['state_name'] = $fii[state];
 	}
		$recent_res_list[] = $recent_res;
	}
	
	$cache->save($recent_res_list);
}
else
{
	$recent_res_list = $cache->get();
}

$cache->unsetModule();

foreach ($recent_res_list as $recent_res)
{
 	$category_list = explode(':', $recent_res['category']);
 	$category_list = explode('#', $category_list[0]);

	if ($def_logo_block == "YES") 
	{
		$ikonka = "nologo.gif";
	
		for ($xxl = 0; $xxl < count($logo_block); $xxl++)
		{
			$rlogo_block = explode(".", $logo_block[$xxl]);
			if ($rlogo_block[0] == $recent_res['selector']) 
			{
				$ikonka = $logo_block[$xxl];
			}
		}
	
		echo '&nbsp;<img src="' . $def_mainlocation . '/logo/' . $ikonka . '" width="' . $def_logo_block_width . '" height="' . $def_logo_block_height . '" border="0" alt="" align="middle">&nbsp;';
	}

	else
	{
	 	echo '&nbsp;<img src="' . $def_mainlocation . '/template/' . $def_template 
	 		. '/images/newfirm.gif" border="0" alt="">&nbsp;';
	}
	
 	$descr = '';
 	if ($def_descriptions_show == 'YES')
 	{
 		if (   (($recent_res['flag'] == 'D') and ($def_D_description == 'YES')) 
 			or (($recent_res['flag'] == 'C') and ($def_C_description == 'YES')) 
 			or (($recent_res['flag'] == 'B') and ($def_B_description == 'YES')) 
 			or (($recent_res['flag'] == 'A') and ($def_A_description == 'YES'))  )
 		{
 			if ($recent_res['business'] != '')
 			{
 				$descr = '<br><br>&nbsp;&nbsp;<span class="boxdescr">' . $recent_res['business'] . '</span>';
 			}
 		}
 	}

 	$location = $recent_res['location_name'];
 	if ( $def_states_allow == 'YES' ) 
 	{
 		$location .= ', ' . $recent_res['state_name'];
 	}
 	
 	if ( $def_country_allow == 'YES' ) 
 	{
 		$location .= ', ' . $recent_res['city'] . '.';
 	}

        if (($recent_res['theme']!='') and ($recent_res['domen']!='') and (ifEnabled($recent_res['flag'], "social"))) $link_to = $def_mainlocation.'/'.$recent_res['domen'];
        else $link_to = $def_mainlocation . '/view.php?id=' . $recent_res['selector'] . '&amp;cat=' . $category_list[0] . '&amp;subcat=' . $category_list[1] . '&amp;subsubcat=' . $category_list[2];
            
        echo '<a href="'.$link_to.'"><b><u>'.$recent_res['firmname'].'</u></b></a> - '.$location.' '.$descr.'<br><br>&nbsp;&nbsp;<span class="sideboxtext">('.$recent_res['date'].')</span><br><br>';
}

table_bottom();

?>
<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya
=====================================================
 Файл: lastmod.php
-----------------------------------------------------
 Назначение: Обновленные фирмы
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if ($def_onlypaid == 'YES') 
{
	$hide_d = ' AND flag <> "D" ';
}

$cache->setModule('lastmod');

if ( !$cache->isActive() ) 
{ 
	$lastmod_q = "SELECT category, selector, flag, business, city, domen, firmname, theme, location, state FROM $db_users WHERE firmstate='on' and date_mod<>'' $hide_d ORDER BY date_mod DESC LIMIT $def_show_number_box";
	$lastmod_q = $db->query($lastmod_q);
	$lastmod_r = $db->numrows($lastmod_q);
	
	$lastmod_res_list = array();
	for ($lastmod_f = 0; $lastmod_f < $lastmod_r; $lastmod_f++)
	{
		$lastmod_res = $db->fetcharray($lastmod_q);
		$lastmod_res['business'] = parseDescription("Z", $lastmod_res['business']);

		$reel = $db->query ( "SELECT location FROM $db_location WHERE locationselector = '$lastmod_res[location]'" );
 		$feel = $db->fetcharray ( $reel );
 		$lastmod_res['location_name'] = $feel[location];

 	if ( $def_states_allow == 'YES' ) 
 	{
 		$riil = $db->query ( "SELECT state FROM $db_states WHERE stateselector = '$lastmod_res[state]'" );
		$fiil = $db->fetcharray ( $riil );
		$lastmod_res['state_name'] = $fiil[state];
 	}

		$lastmod_res_list[] = $lastmod_res;
	}
	
	$cache->save($lastmod_res_list);
}
else
{
	$lastmod_res_list = $cache->get();
}

$cache->unsetModule();

if (count($lastmod_res_list) != 0) {

table_top  ($def_lastmod);

foreach ($lastmod_res_list as $lastmod_res)
{
 	$category_list = explode(':', $lastmod_res['category']);
 	$category_list = explode('#', $category_list[0]);

	if ($def_logo_block=="YES") 
	{
		$ikonka = "nologo.gif";
	
		for ($xxl = 0; $xxl < count($logo_block); $xxl++)
		{
			$rlogo_block = explode(".", $logo_block[$xxl]);
			if ($rlogo_block[0] == $lastmod_res['selector']) 
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
 		if (   (($lastmod_res['flag'] == 'D') and ($def_D_description == 'YES')) 
 			or (($lastmod_res['flag'] == 'C') and ($def_C_description == 'YES')) 
 			or (($lastmod_res['flag'] == 'B') and ($def_B_description == 'YES')) 
 			or (($lastmod_res['flag'] == 'A') and ($def_A_description == 'YES'))  )
 		{
 			if ($lastmod_res['business'] != '')
 			{
 				$descr = '<br><br>&nbsp;&nbsp;<span class=boxdescr>' . $lastmod_res['business'] . '</span>';
 			}
 		}
 	}

 	$location = $lastmod_res['location_name'];
 	if ( $def_states_allow == 'YES' ) 
 	{
 		$location .= ', ' . $lastmod_res['state_name'];
 	}
 	
 	if ( $def_country_allow == 'YES' ) 
 	{
 		$location .= ', ' . $lastmod_res['city'] . '.';
 	}

        if (($lastmod_res['theme']!='') and ($lastmod_res['domen']!='') and (ifEnabled($lastmod_res['flag'], "social"))) $link_tol = $def_mainlocation.'/'.$lastmod_res['domen'];
        else $link_tol = $def_mainlocation.'/view.php?id='.$lastmod_res['selector'].'&amp;cat='.$category_list[0].'&amp;subcat='.$category_list[1].'&amp;subsubcat='.$category_list[2];

 	echo '<a href="'.$link_tol.'"><b><u>'.$lastmod_res['firmname'].'</u></b></a> - '.$location.' '.$descr.'<br><br>';
}

table_bottom();

}

?>
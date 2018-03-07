<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya
=====================================================
 Файл: featured.php
-----------------------------------------------------
 Назначение: Особенные компании
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

table_top  ($def_featured);

if ($def_onlypaid == 'YES') 
{
	$hide_d = ' AND flag <> "D" ';
}

	$featured_q = "SELECT category, selector, flag, business, city, domen, firmname, theme, counter, date, location, state FROM $db_users WHERE firmstate='on' $hide_d AND flag <> 'D' ORDER BY RAND(), flag LIMIT $def_show_number_box";
	$featured_q = $db->query($featured_q);
	$featured_r = $db->numrows($featured_q);
	
	$featured_res_list = array();
	for ($featured_f = 0; $featured_f < $featured_r; $featured_f++)
	{
	 	$featured_res = $db->fetcharray($featured_q);
		$featured_res['business'] = parseDescription("Z", $featured_res['business']);

		$reef = $db->query ( "SELECT location FROM $db_location WHERE locationselector = '$featured_res[location]'" );
 		$feef = $db->fetcharray ( $reef );
 		$featured_res['location_name'] = $feef[location];

 	if ( $def_states_allow == 'YES' ) 
 	{
 		$riif = $db->query ( "SELECT state FROM $db_states WHERE stateselector = '$featured_res[state]'" );
		$fiif = $db->fetcharray ( $riif );
		$featured_res['state_name'] = $fiif[state];
 	}


 		$featured_res_list[] = $featured_res;
	}
	

if (count($featured_res_list) == 0) 
{
	echo '<center>В списке нет</center><br>';
} else

{	

foreach ($featured_res_list as $featured_res)
{ 	
 	$category_list = explode(':', $featured_res['category']);
 	$category_list = explode('#', $category_list[0]);

	if ($def_logo_block=="YES") {

	$ikonka = "nologo.gif";

	for ($xxl=0;$xxl<count($logo_block);$xxl++)
	{
		$rlogo_block = explode(".", $logo_block[$xxl]);
		if ($rlogo_block[0] == $featured_res['selector']) $ikonka ="$logo_block[$xxl]";
	}


	echo '&nbsp;<img src="' . $def_mainlocation . '/logo/' . $ikonka . '" width="' . $def_logo_block_width . '" height="' . $def_logo_block_height . '" border="0" alt="" align="middle">&nbsp;';

	}

	else

 	echo '&nbsp;<img src="' . $def_mainlocation . '/template/' . $def_template 
 		. '/images/v.gif" border="0" alt="">&nbsp;';

 	$descr = '';
 	if ($def_descriptions_show == 'YES')
 	{
 		if (   (($featured_res['flag'] == 'D') and ($def_D_description == 'YES')) 
 			or (($featured_res['flag'] == 'C') and ($def_C_description == 'YES')) 
 			or (($featured_res['flag'] == 'B') and ($def_B_description == 'YES')) 
 			or (($featured_res['flag'] == 'A') and ($def_A_description == 'YES'))   )
 		{
 			if ($featured_res['business'] != '')
 			{
 				$descr = '<br><br>&nbsp;&nbsp;<span class=boxdescr>'
 					   . substr ( $featured_res['business'], 0, $def_box_descr_size )
 					   . '</span>';
 			}
 		}
 	}

 	$location = $featured_res['location_name'];
 	
 	if ( $def_states_allow == 'YES' ) 
 	{
		$location .= ', ' . $featured_res['state_name'];		
 	}
 	
 	if ( $def_country_allow == 'YES' ) 
 	{
 		$location .= ', ' . $featured_res['city'] . '.';
 	}	

        if (($featured_res['theme']!='') and ($featured_res['domen']!='') and (ifEnabled($featured_res['flag'], "social"))) $link_tof = $def_mainlocation.'/'.$featured_res['domen'];
        else $link_tof = $def_mainlocation . '/view.php?id=' . $featured_res['selector'] . '&amp;cat=' . $category_list[0] . '&amp;subcat=' . $category_list[1] . '&amp;subsubcat=' . $category_list[2];

 	echo '<a href="'.$link_tof.'"><b><u>'.$featured_res['firmname'].'</u></b></a> - '.$location.' '.$descr.'<br><br>';
}

}

table_bottom();

?>
<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya, D.Madi
=====================================================
 Файл: lastinfo.php
-----------------------------------------------------
 Назначение: Последние публикации
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$lInfo=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);
 

main_table_top  ($lInfo[$last_type]);

echo "<div align=\"left\">";

if ($def_onlypaid == 'YES') 
{
	$hide_d = ' AND flag <> "D" ';
}

if ($last_type==1) $cache->setModule('lastnews');
if ($last_type==2) $cache->setModule('lasttender');
if ($last_type==3) $cache->setModule('lastboard');
if ($last_type==4) $cache->setModule('lastjob');
if ($last_type==5) $cache->setModule('lastpressrel');

if ( !$cache->isActive() ) 
{ 
	$recent_li = "SELECT category, num, date, datetime, item, shortstory, video, img_on FROM $db_info WHERE type='$last_type' $hide_d ORDER BY date DESC, datetime DESC LIMIT $def_show_number_info";
	$recent_li = $db->query($recent_li);
	$recent_rli = $db->numrows($recent_li);
	
	$recent_resli_list = array();
	for ($recent_fi = 0; $recent_fi < $recent_rli; $recent_fi++)
	{
		$recent_res_info = $db->fetcharray($recent_li);

		if (strlen($recent_res_info[item]) > $def_info_item_size)

		{
			$recent_res_info[item] = substr($recent_res_info[item], 0, $def_info_item_size);
			$recent_res_info[item] = substr($recent_res_info[item], 0, strrpos($recent_res_info[item], ' '));
			$recent_res_info[item] = trim($recent_res_info[item]) . ' ...';
		}

		$recent_res_info['shortstory'] = parseDescription("X", $recent_res_info['shortstory']);
		$recent_res_info['date'] 	= undate($recent_res_info['date'], "DD.MM.YYYY");

		$recent_resli_list[] = $recent_res_info;
	}
	
	$cache->save($recent_resli_list);
}
else
{
	$recent_resli_list = $cache->get();
}

$cache->unsetModule();

foreach ($recent_resli_list as $recent_res_info)
{
 	$category_list = explode(':', $recent_res_info['category']);
 	$category_list = explode('#', $category_list[0]);
	
 	$descr = '';
 	if ($def_shortstory_show == 'YES')
 	{
 			if ($recent_res_info['shortstory'] != '')
 			{
 				$descr = '<br><br>&nbsp;<span class=boxdescr>' . $recent_res_info['shortstory'] . '</span>';
 			}
 	}

	$video_on='';
	$img_on='';
	
	if ($recent_res_info['video']!="") $video_on="<img src=\"$def_mainlocation/template/$def_template/images/video_on_main.gif\" align=\"absmiddle\">";
	if ($recent_res_info['img_on']==1) $img_on="<img src=\"$def_mainlocation/template/$def_template/images/img_on_main.gif\" align=\"absmiddle\">";

 	echo '<br>&nbsp;' . $recent_res_info['date'] . '&nbsp;<a href="' . $def_mainlocation . '/viewinfo.php?vi=' . $recent_res_info['num'] 
		. '&amp;cat=' . $category_list[0] 
 		. '&amp;subcat=' . $category_list[1] 
 		. '&amp;subsubcat=' . $category_list[2] . '">

  	<b><u>' . $recent_res_info['item'] . '</u></b></a>&nbsp;' . $video_on . $img_on . $descr . '<br>';
}

echo "</div>";

unset ($last_type);

main_table_bottom();

?>
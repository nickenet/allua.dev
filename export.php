<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: export.php
-----------------------------------------------------
 Назначение: Экспорт данных
=====================================================
*/

include ( "./conf/config.php" );
include ( "./conf/memberships.php" );
include ( "./includes/functions.php" );
include ( "./includes/$def_dbtype.php" );
include ( "./connect.php" );
include ( "./includes/sqlfunctions.php" );
$lang = $def_language;
include ( "./lang/language.$lang.php" );

$type=intval($_GET['type']);
$number=intval($_GET['number']);
$logo=intval($_GET['logo']);
$desc=intval($_GET['desc']);
$states=intval($_GET['states']);
$country=intval($_GET['country']);
$price=intval($_GET['price']);

if (($type==1) or ($type==2) or ($type==3) or ($type==4))  {

    if ($type==1) { $order='selector DESC';$hide=''; $title=$def_last10; }
    if ($type==2) { $order='counter DESC, countrating DESC';$hide=''; $title=$def_top10; }
    if ($type==3) { $order='date_mod DESC'; $hide=''; $title=$def_lastmod; }
    if ($type==4) { $order='RAND(), flag'; $hide='AND flag <> \'D\''; $title=$def_featured; }

    	$recent_q = "SELECT category, selector, flag, business, city, firmname, counter, date, location, state, date_mod FROM $db_users WHERE firmstate='on' $hide ORDER BY $order LIMIT $number";
	$recent_q = $db->query($recent_q);
	$recent_r = $db->numrows($recent_q);
	
	$recent_res_list = array();
	for ($recent_f = 0; $recent_f < $recent_r; $recent_f++)
	{
		$recent_res = $db->fetcharray($recent_q);
		$recent_res['business'] = isb_sub(strip_tags($recent_res['business']),$def_box_descr_size);
		$recent_res['date'] 	= undate($recent_res['date'], $def_datetype);


 		$ree = $db->query ( "SELECT location FROM $db_location WHERE locationselector = '$recent_res[location]'" );
 		$fee = $db->fetcharray ( $ree );
 		$recent_res['location_name'] = $fee[location];

 	if ( $states == 1 )
 	{
 		$rii = $db->query ( "SELECT state FROM $db_states WHERE stateselector = '$recent_res[state]'" );
		$fii = $db->fetcharray ( $rii );
		$recent_res['state_name'] = $fii[state];
 	}
		$recent_res_list[] = $recent_res;
	}

header('Content-Type: text/html; charset=windows-1251');

echo "document.write('<div class=\"isb_header\">".$title."</div>');";

echo "document.write('<div class=\"isb_content\">');";

foreach ($recent_res_list as $recent_res)
{
 	$category_list = explode(':', $recent_res['category']);
 	$category_list = explode('#', $category_list[0]);

	if ($logo == 1)
	{

            $handle_logo = opendir('./logo');

            $count_logo=0;
            while (false != ($file_logo = readdir($handle_logo))) {
                    if ($file_logo != "." && $file_logo != "..") {
                        $logo_block[$count_logo]="$file_logo";
                        $count_logo++; }
            }

            closedir($handle_logo);

		$ikonka = "nologo.gif";
	
		for ($xxl = 0; $xxl < count($logo_block); $xxl++)
		{
			$rlogo_block = explode(".", $logo_block[$xxl]);
			if ($rlogo_block[0] == $recent_res['selector']) 
			{
				$ikonka = $logo_block[$xxl];
			}
		}
	
		echo "document.write('&nbsp;<img src=\"".$def_mainlocation."/logo/".$ikonka."\" width=\"".$def_logo_block_width."\" height=\"".$def_logo_block_height."\" border=\"0\" align=\"middle\">&nbsp;');";
	}

	else
	{
	 	echo "document.write('&nbsp;');";
	}
	
 	$descr = '';
 	if ($desc == 1)
 	{
 			if ($recent_res['business'] != '')
 			{
 				$descr = '<br>&nbsp;&nbsp;<span class="isb_boxdescr">'.$recent_res['business'].'</span>';
 			}
 	}

        $location='';
 	if ( $states == 1 )
 	{              
 		$location .= ' - ' . $recent_res['state_name'];
                $prefix = ',';
 	} else $prefix = ' -';

        if ( $country == 1 )
        {
               if ( $def_country_allow == 'YES' ) {
 		$location.= $prefix. ' ' . $recent_res['city'] . '.';
                    } else $location.= $recent_res['location_name'];
 	}
 	
        if ($type==1) $trans = '&nbsp;&nbsp;<span class="isb_sideboxtext">('.$recent_res['date'].')</span><br><br>';
        if ($type==2) $trans = '&nbsp;&nbsp;<span class="isb_sideboxtext">(<b>' . $recent_res['counter'] . '</b> ' . $def_visitors . ' ' . $def_since . $recent_res['date'] . ')</span><br><br>';
        if ($type>2) $trans = '<br>';

 	echo "document.write('<a href=\"". $def_mainlocation ."/view.php?id=".$recent_res['selector']."&amp;cat=".$category_list[0]."&amp;subcat=".$category_list[1]."&amp;subsubcat=".$category_list[2]."\"><b><u>".$recent_res['firmname']."</u></b></a>".$location." ".$descr."<br>".$trans." ');";
        
}

echo "document.write('</div>');";

}

if (($type==5) or ($type==6) or ($type==7) or ($type==8) or ($type==9))  {
    
    if ($type==5) {$last_type=1; $title=$def_info_news; }
    if ($type==6) {$last_type=2; $title=$def_info_tender; }
    if ($type==7) {$last_type=3; $title=$def_info_board; }
    if ($type==8) {$last_type=4; $title=$def_info_job; }
    if ($type==9) {$last_type=5; $title=$def_info_pressrel; }

    	$recent_li = "SELECT category, num, date, datetime, item, shortstory, video, img_on FROM $db_info WHERE type='$last_type' $hide_d ORDER BY date DESC, datetime DESC LIMIT $number";
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

        header('Content-Type: text/html; charset=windows-1251');

        echo "document.write('<div class=\"isb_header\">".$title."</div>');";

        echo "document.write('<div class=\"isb_content\">');";

        foreach ($recent_resli_list as $recent_res_info)
        {

 	$category_list = explode(':', $recent_res_info['category']);
 	$category_list = explode('#', $category_list[0]);

 	$descr = '';
 	if ($desc == 1)
 	{
 			if ($recent_res_info['shortstory'] != '')
 			{
 				$descr = '<br>&nbsp;<span class="isb_boxdescr">' . $recent_res_info['shortstory'] . '</span>';
 			}
 	}

	$video_on='';
	$img_on='';

	if ($recent_res_info['video']!="") $video_on="<img src=\"$def_mainlocation/template/$def_template/images/video_on_main.gif\" align=\"absmiddle\">";
	if ($recent_res_info['img_on']==1) $img_on="<img src=\"$def_mainlocation/template/$def_template/images/img_on_main.gif\" align=\"absmiddle\">";

 	echo "document.write('&nbsp;".$recent_res_info['date']."&nbsp;<a href=\"".$def_mainlocation."/viewinfo.php?vi=".$recent_res_info['num']."&amp;cat=".$category_list[0]."&amp;subcat=".$category_list[1]."&amp;subsubcat=".$category_list[2]."\"><b><u>".$recent_res_info['item']."</u></b></a>&nbsp;". $video_on . $img_on . $descr ."<br><br>');";
        }

        echo "document.write('</div>');";
}

if ($type==10) {

$title = $def_offers;

$handle = opendir ("./offer");
$count = 0;

while ( false != ( $file = readdir ( $handle ) ) )
{
	if ( $file != "." && $file != ".." && $file != "_vti_cnf" && $file != "index.html" && $file != ".htaccess")

	{
		$banners[$count] = "$file";
		$count++;
	}
}
closedir ( $handle );

if ( count ( $banners ) > 0 ) {

	$rban = array_rand ( $banners );
	$rbannum = explode ( ".", $banners[$rban] );
	$id_banner = $rbannum[0];
	$pos_small = strpos($id_banner,"small");

	if ($pos_small !== false) $viewbanner=$banners[$rban];
	else $viewbanner = $rbannum[0]."-small." . $rbannum[1];

	$fn = $db->query  ( "SELECT * FROM $db_offers WHERE num = '$id_banner'");
	$fn=$db->fetcharray ($fn);
	$fnres=$fn["firmselector"];
	$fniten=$fn["item"];
	$fnmes=substr ( $fn["message"], 0, $def_rnd_descr_size);
	IF ($fnmes!=""){$fnmes.=" ...";}
	$fnprice=$fn["price"];

	$r_banner = $db->query ( "SELECT flag, selector, category, firmname FROM $db_users WHERE selector='$fnres'" );
	$f_banner = $db->fetcharray ($r_banner);
	$idof=$f_banner["selector"];

	$cat_temp = explode (":", $f_banner[category]);
	$category = explode ("#", $cat_temp[0]);

        $allof="all";

	$link = '<a href="'.$def_mainlocation.'/offers.php?id='.$idof.'&amp;cat='.$category[0].'&amp;subcat='.$category[1].'&amp;subsubcat='.$category[2].'&amp;type='.$allof.'" target="_blank">';

        if (($fnmes!='') and ($desc==1)) $fnmes='<div class="isb_boxdescr" style="text-align: center;">'.$fnmes.'</div>'; else $fnmes='';

        if (($fnprice!='') and ($price==1)) $fnprice='<div class="isb_sideboxtext" style="text-align: right;"><b>'.$fnprice.'</b></div>'; else $fnprice='';

header('Content-Type: text/html; charset=windows-1251');

echo "document.write('<div class=\"isb_header\">".$title."</div>');";

echo "document.write('<div class=\"isb_content\">');";

echo "document.write('<div style=\"text-align: center;\">".$link." <img src=\"".$def_mainlocation."/offer/".$viewbanner."\" width=\"150\" border=\"0\" alt=\"". $f_banner[firmname] ."\" hspace=\"2\" vspace=\"2\"></a><br><strong>".$fniten."</strong></div>".$fnmes.$fnprice."');";

echo "document.write('</div>');";


}
}

if (($type==11) or ($type==12)) {
    
    if ( $type == 11 ) $ifolder = "banner"; else $ifolder = "banner2";

    $ihandle = opendir ("./" . $ifolder);
    $count = 0;

while ( false != ( $file = readdir ( $ihandle ) ) )

{
	if ( $file != "." && $file != ".." && $file != "_vti_cnf" && $file != "index.html" && $file != ".htaccess")

	{
		$ibanners[$count] = "$file";
		$count++;
	}
}
closedir ( $ihandle );

if ( count ( $ibanners ) > 0 )

{
	$rban = array_rand ( $ibanners );
	$rbannum = explode ( ".", $ibanners[$rban] );
	$id_banner = $rbannum[0];

		$link = '<a href="'.$def_mainlocation.'/view.php?id='.$id_banner.'" target="_blank">';

                header('Content-Type: text/html; charset=windows-1251');

		echo "document.write('".$link."<img src=\"".$def_mainlocation."/".$ifolder."/".$ibanners[$rban]."\" border=\"0\" alt=\"".$f_banner[firmname]."\"></a><br>');";
}	
}

	unset ( $type );
	unset ( $ibanners );
	unset ($category);
	unset ($link);



?>
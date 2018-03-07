<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: rss.php
-----------------------------------------------------
 Назначение: RSS экспорт
=====================================================
*/



header('Content-type: application/xml');

include ( "./defaults.php" );

$limitr="50";

	switch ($_GET['type']) {
			  case 1:
			    $title_rss="Новые поступления продукции и услуг";
			    $r = $db->query ( "SELECT $db_offers.num, $db_offers.type, $db_offers.firmselector, $db_offers.item, $db_offers.date, $db_offers.message, $db_offers.quantity, $db_offers.packaging, $db_offers.price, $db_offers.period, $db_users.firmstate, $db_users.firmname, $db_users.manager, $db_users.category  FROM $db_offers  INNER JOIN $db_users ON $db_offers.firmselector = $db_users.selector WHERE ($db_users.category LIKE '$categorymains#%#%:%' or $db_users.category LIKE '%:$categorymains#%#%:%' or $db_users.category LIKE '%:$categorymains#%#%' or $db_users.category LIKE '$categorymains#%#%') and firmstate = 'on' ORDER BY $db_offers.date DESC LIMIT $limitr");
			    break;
			  case 2:
			    $title_rss="Новые поступления сайтов организаций каталога";
			    $r = $db->query ( "SELECT selector, firmname, business, www, category FROM $db_users WHERE (category LIKE '$categorymains#%#%:%' or category LIKE '%:$categorymains#%#%:%' or category LIKE '%:$categorymains#%#%' or category LIKE '$categorymains#%#%') and firmstate = 'on' and www!='' ORDER BY date DESC LIMIT $limitr");
			    break;
			  case 3:
			    $type_on=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);
			    $kType=intval($_GET[ktype]);
			    $id=intval($_GET[id]);
			    $r = $db->query  ( "SELECT * FROM $db_info WHERE firmselector = '$id' and type='$kType' ORDER BY date DESC, datetime DESC LIMIT $limitr" );			    
			    $title_rss="$type_on[$kType] компании";
			    break;
			  case 4:
			    $type_on=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);
			    $kType=intval($_GET[ktype]);
			    $r = $db->query  ( "SELECT * FROM $db_info WHERE (category LIKE '$categorymains#%#%:%' or category LIKE '%:$categorymains#%#%:%' or category LIKE '%:$categorymains#%#%' or category LIKE '$categorymains#%#%') and type='$kType' ORDER BY date DESC, datetime DESC LIMIT $limitr" );			    
			    $title_rss="$type_on[$kType] компаний";
			    break;
			  case 5:
			    $title_rss="Новые поступления прайс-листов";
			    $r = $db->query ( "SELECT $db_exelp.num, $db_exelp.firmselector, $db_exelp.item, $db_exelp.date, $db_exelp.message, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category FROM $db_exelp  INNER JOIN $db_users ON $db_exelp.firmselector = $db_users.selector WHERE ($db_users.category LIKE '$categorymains#%#%:%' or $db_users.category LIKE '%:$categorymains#%#%:%' or $db_users.category LIKE '%:$categorymains#%#%' or $db_users.category LIKE '$categorymains#%#%') and firmstate = 'on' ORDER BY $db_exelp.date DESC LIMIT $limitr");
			    break;
			  case 6:
			    $title_rss="Новые поступления изображений";
			    $r = $db->query ( "SELECT $db_images.num, $db_images.firmselector, $db_images.item, $db_images.date, $db_images.message, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category FROM $db_images  INNER JOIN $db_users ON $db_images.firmselector = $db_users.selector WHERE ($db_users.category LIKE '$categorymains#%#%:%' or $db_users.category LIKE '%:$categorymains#%#%:%' or $db_users.category LIKE '%:$categorymains#%#%' or $db_users.category LIKE '$categorymains#%#%') and firmstate = 'on' ORDER BY $db_images.date DESC LIMIT $limitr");
			    break;
                          case 7:
			    $title_rss="Новые поступления новостей";
                            if (isset($categorymains)) $sort_cat = "and category='$categorymains'"; else $sort_cat="";
			    $r = $db->query ( "SELECT selector, title, date, short, category FROM $db_news WHERE status_off=0 $sort_cat ORDER BY date DESC LIMIT $limitr");
			    break;
			  break;
			   default:
			   $title_rss="Новые поступления организаций и фирм";
			   $r = $db->query ( "SELECT * FROM $db_users WHERE firmstate = 'on' ORDER BY date DESC LIMIT $limitr" );
		}

$rss_content = <<<XML
<?xml version="1.0" encoding="windows-1251"?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
<title>$def_title</title>
<link>$def_mainlocation</link>
<language>ru</language>
<description>$title_rss</description>
<generator>I-Soft Bizness</generator>
XML;



$cat_group = array ();
$cat_group[0]="";
$re = $db->query  ( "select * from $db_category order by selector" );
while($rowcat = $db->fetcharray ($re)){ $cat_group[]=$rowcat[category]; }

while ($row = $db->fetcharray( $r ))
{

	switch ($_GET['type']) {
			  case 1:
				if ( $row[type] == "1" ) $type = $def_offer_1_s;
			        if ( $row[type] == "2" ) $type = $def_offer_2_s;
		 		if ( $row[type] == "3" ) $type = $def_offer_3_s;

				$bizness="$row[item] ($type)";
				$bizness.= "<br> $row[message]";
				$bizness.= "<br> Количество - $row[quantity]";
				$bizness.= "<br> Пакет - $row[packaging]";
				$bizness.= "<br> Цена - $row[price]";
				$bizness= htmlspecialchars($bizness);

				$maincatx = explode (":", $row[category]);
				$maincat = explode ("#", $maincatx[0]);
				$getcat = $maincat[0];
				$rsscat = $cat_group[$getcat];

				$links="$def_mainlocation/alloffers.php?idfull=$row[firmselector]&amp;full=$row[num]&amp;catfirm=$categorymains";
			  break;

			  case 2:
				$bizness="$row[business]<br>$row[www]";
				$bizness= htmlspecialchars($bizness, ENT_QUOTES, $def_charset);
				$links="$def_mainlocation/view.php?id=$row[selector]";

				$maincatx = explode (":", $row[category]);
				$maincat = explode ("#", $maincatx[0]);
				$getcat = $maincat[0];
				$rsscat = $cat_group[$getcat];	
			  break;

			  case 3:
				$bizness = "$row[item]<br>";
				$bizness.= "$row[shortstory]";
				$bizness= htmlspecialchars($bizness, ENT_QUOTES, $def_charset);
				$links="$def_mainlocation/viewinfo.php?vi=$row[num]";

				$maincatx = explode (":", $row[category]);
				$maincat = explode ("#", $maincatx[0]);
				$getcat = $maincat[0];
				$rsscat = $cat_group[$getcat];	
			  break;

			  case 4:
				$bizness = "$row[item]<br>";
				$bizness.= "$row[shortstory]";
				$bizness= htmlspecialchars($bizness, ENT_QUOTES, $def_charset);
				$links="$def_mainlocation/viewinfo.php?vi=$row[num]";

				$maincatx = explode (":", $row[category]);
				$maincat = explode ("#", $maincatx[0]);
				$getcat = $maincat[0];
				$rsscat = $cat_group[$getcat];	
			  break;

			  case 5:

				$bizness="$row[item]";
				$bizness.= "<br> $row[message]";
				$bizness= htmlspecialchars($bizness, ENT_QUOTES, $def_charset);

				$maincatx = explode (":", $row[category]);
				$maincat = explode ("#", $maincatx[0]);
				$getcat = $maincat[0];
				$rsscat = $cat_group[$getcat];

				$links="$def_mainlocation/exel/$row[num].xls";
			  break;

			  case 6:

				$bizness="$row[item]";
				$bizness.= "<br> $row[message]";
				$bizness= htmlspecialchars($bizness, ENT_QUOTES, $def_charset);

				$maincatx = explode (":", $row[category]);
				$maincat = explode ("#", $maincatx[0]);
				$getcat = $maincat[0];
				$rsscat = $cat_group[$getcat];

				$links="$def_mainlocation/gallery.php?id=$row[firmselector]";
			  break;

                      	  case 7:

                                $row[firmname]=$row[title];
				$bizness="$row[short]";
				$bizness= htmlspecialchars(strip_tags($bizness), ENT_QUOTES, $def_charset);
				$rsscat = $categorymains;
				$links="$def_mainlocation/news.php?id=$row[selector]";

			  break;

			  default:
		   		$bizness=htmlspecialchars($row[business], ENT_QUOTES, $def_charset);
				$links="$def_mainlocation/view.php?id=$row[selector]";
	
				$maincatx = explode (":", $row[category]);
				$maincat = explode ("#", $maincatx[0]);
				$getcat = $maincat[0];
				$rsscat = $cat_group[$getcat];
		}
	
$row[firmname]=htmlspecialchars($row[firmname],ENT_QUOTES,$def_charset);

$rss_content .= <<<XML
<item>
<title>$row[firmname]</title>
<link>$links</link>
<description>$bizness</description>
<category>$rsscat</category>
<dc:creator>$row[manager]</dc:creator>
<pubDate>$row[date]</pubDate>
</item>
XML;

}

$rss_content .= '</channel></rss>';


echo $rss_content;

?>
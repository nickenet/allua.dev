<?php

/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D.Madi & Ilya K.
  =====================================================
  Файл: randomservice.php
  -----------------------------------------------------
  Назначение: Вывод случайным образом продукции или услуги
  =====================================================
 */

if (!defined('ISB'))
{
	die("Hacking attempt!");
}

$folder = 'offer';

$banners = glob('./' . $folder . '/*-small.*');


if (empty($banners))
{
	return;
}

if ($def_offer_showNum > count($banners))
{
	$def_offer_showNum = count($banners);
}

# Подгрузка всех предложений сразу
$idBanners = array();
for ($num = 0; $num < $def_offer_showNum; $num++)
{
	$bannerKey = array_rand($banners);
	$banner = basename($banners[$bannerKey]);
	unset($banners[$bannerKey]);

	$nameParts = explode('-', $banner);
	$idBanners[ (int)$nameParts[0] ] = $banner;
}

$sql = 'SELECT o.*, u.flag, u.selector, u.category, u.firmname FROM ' . $db_offers . ' AS o 
		LEFT JOIN ' . $db_users	. ' AS u ON u.selector = o.firmselector
		WHERE o.num IN (' . join(', ', array_keys($idBanners)) . ')
		ORDER BY RAND()';

$offerDb = $db->query($sql);

$rndserviceTitle = $def_offers;
table_top($rndserviceTitle);

while($offer = $db->fetcharray($offerDb))
        
{
	$offerMessage = isb_sub(strip_tags(stripcslashes($offer['message'])),$def_rnd_descr_size);
	$category = explode(':', $offer['category']);
	$category = explode('#', $category[0]);
if ($def_link_offer=="ALL") {

if ($def_rewrite == "YES") $link = $def_mainlocation.'/offers-'.$offer['selector'].'-0-'.$category[0].'-'.$category[1].'-'.$category[2].'-'.$offer['type'].'.html';
else $link = $def_mainlocation.'/offers.php?id='.$offer['selector'].'&cat='.$category[0].'&subcat='.$category[1].'&subsubcat='.$category[2].'&type='.$offer['type'];

} else

    $link = $def_mainlocation.'/alloffers.php?idfull='.$offer['selector'].'&full='.$offer['num'].'&catfirm='.$category[0];

    $img = $def_mainlocation . '/' . $folder . '/' . $idBanners[ $offer['num'] ];

    include ( "./template/$def_template/randomservice.php" );

}

table_bottom();

unset($banners);
unset($category);
?>
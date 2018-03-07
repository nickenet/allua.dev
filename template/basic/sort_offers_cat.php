<? /*

Шаблон вывода сортировки в каталоге изображений

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<noindex>

<div align="right" style="padding: 3px;"><? echo $v_sort1; ?> Название | <? echo $v_sort2; ?> Цена | <? echo $v_sort3; ?> Дата</div>

<div align="right" style="padding: 3px;"><a rel="nofollow" href="<? echo $def_mainlocation; ?>/alloffers.php?category=<? echo $category_offers; ?>&type=1"><? echo $def_offer_1_s; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/alloffers.php?category=<? echo $category_offers; ?>&type=2"><? echo $def_offer_2_s; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/alloffers.php?category=<? echo $category_offers; ?>&type=3"><? echo $def_offer_3_s; ?></a> | <a rel="nofollow" href="<? $def_mainlocation; ?>/alloffers.php?category=<? echo $category_offers; ?>&type=ALL">Показать все</a> | </noindex><a href="<? echo $def_mainlocation; ?>/rss.php?category=<? echo $category_offers; ?>&type=1">Rss</a> <img src="<? echo $def_mainlocation; ?>/images/rss.gif" border="0" align="absmiddle" alt="rss"></div>

<? if ($razdel!='') { ?>
<div align="right" style="padding: 5px;">
<form action="" method="post">
<select style="width: 250px;" name="go_subcat_offer" onchange="this.form.submit();"><option value="ALL">Все подразделы</option><? echo $razdel; ?></select>
</form>
</div>
<? } ?>

</noindex>

<? /*

Шаблон вывода сортировки в каталоге изображений

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<noindex>

<div style="padding: 5px; text-align: right;"><b><? echo $def_sort; ?>&nbsp;</b><a rel="nofollow" href="<? echo $def_mainlocation; ?>/allxls.php?category=<? echo $category_xls.$pages_offers; ?>&sort=3"><? echo $def_sort_name; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/allxls.php?category=<? echo $category_xls.$pages_offers; ?>&sort=2"><? echo $def_sort_firm; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/allxls.php?category=<? echo $category_xls.$pages_offers; ?>&sort=1"><? echo $def_sort_data; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/rss.php?category=<? echo $category_xls; ?>&type=5">Rss</a> <img alt="rss прайс-листов" src="<? echo $def_mainlocation; ?>/images/rss.gif" border="0" align="absmiddle" />

<? if ($razdel!='') { ?>

<form action="" method="post">
<br /><br /><select style="width: 250px;" name="go_subcat_xls" onchange="this.form.submit();"><option value="ALL">Все подразделы</option><? echo $razdel; ?></select>
</form>

<? } ?>

</div>
</noindex>

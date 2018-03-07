<? /*

Шаблон вывода сортировки в каталоге изображений

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<noindex>
<div style="text-align: right;"><b><? echo $def_sort; ?>&nbsp;</b><a rel="nofollow" href="<? echo $def_mainlocation; ?>/allimg.php?category=<? echo $category_img.$pages_offers; ?>&sort=3"><? echo $def_sort_name; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/allimg.php?category=<? echo $category_img.$pages_offers; ?>&sort=2"><? echo $def_sort_firm; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/allimg.php?category=<? echo $category_img.$pages_offers; ?>&sort=1"><? echo $def_sort_data; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/allimg.php?category=<? echo $category_img.$pages_offers; ?>&amp;sort=4"><? echo $def_sort_rating; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/rss.php?category=<? echo $category_img; ?>&type=6">Rss</a> <img alt="rss изображений" src="<? echo $def_mainlocation; ?>/images/rss.gif" border="0" align="absmiddle" />

<? if ($razdel!='') { ?>

<form action="" method="post">
<br /><br /><select style="width: 250px;" name="go_subcat_img" onchange="this.form.submit();"><option value="ALL">Все подразделы</option><? echo $razdel; ?></select>
</form>

<? } ?>

</div>
</noindex>

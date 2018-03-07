<? /*

Шаблон вывода сортировки в каталоге публикаций

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<noindex>
<div style="text-align: right;"><b><? echo $def_sort; ?>&nbsp;</b><a rel="nofollow" href="<? echo $def_mainlocation; ?>/allinfo.php?category=<? echo $category_info.'&type='.$kType.$pages_info; ?>&sort=4"><? echo $def_sort_name; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/allinfo.php?category=<? echo $category_info.'&type='.$kType.$pages_info; ?>&sort=2"><? echo $def_sort_firm; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/allinfo.php?category=<? echo $category_info.'&type='.$kType.$pages_info; ?>&sort=3"><? echo $def_sort_data; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/allinfo.php?category=<? echo $category_info.'&type='.$kType.$pages_info; ?>&amp;sort=1"><? echo $def_sort_rating; ?></a> | <a rel="nofollow" href="<? echo $def_mainlocation; ?>/rss.php?category=<? echo $category_info; ?>&ktype=<? echo $kType; ?>&type=4">Rss</a> <img alt="rss публикаций" src="<? echo $def_mainlocation; ?>/images/rss.gif" border="0" align="absmiddle" />

<? if ($razdel!='') { ?>

<form action="" method="post">
<br /><br /><select style="width: 250px;" name="go_subcat_info" onchange="this.form.submit();"><option value="ALL">Все подразделы</option><? echo $razdel; ?></select>
<input type="hidden" name="type" value="<? echo $kType; ?>" />
<input type="hidden" name="page" value="0" />
</form>

<? } ?>

</div>
</noindex>

<?php /*

Шаблон вывода сортировки в каталоге публикаций

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<noindex>
<div style="text-align: right;"><b><?php echo $def_sort; ?>&nbsp;</b><a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allinfo.php?category=<?php echo $category_info.'&type='.$kType.$pages_info; ?>&sort=4"><?php echo $def_sort_name; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allinfo.php?category=<?php echo $category_info.'&type='.$kType.$pages_info; ?>&sort=2"><?php echo $def_sort_firm; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allinfo.php?category=<?php echo $category_info.'&type='.$kType.$pages_info; ?>&sort=3"><?php echo $def_sort_data; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allinfo.php?category=<?php echo $category_info.'&type='.$kType.$pages_info; ?>&amp;sort=1"><?php echo $def_sort_rating; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/rss.php?category=<?php echo $category_info; ?>&ktype=<?php echo $kType; ?>&type=4">Rss</a> <img alt="rss публикаций" src="<?php echo $def_mainlocation; ?>/images/rss.gif" border="0" align="absmiddle" />

<?php if ($razdel!='') { ?>
<div style="padding: 10px;">
<form action="" method="post" class="form-control">
<select style="width: 250px;" name="go_subcat_info" onchange="this.form.submit();"><option value="ALL">Все подразделы</option><?php echo $razdel; ?></select>
<input type="hidden" name="type" value="<?php echo $kType; ?>" />
<input type="hidden" name="page" value="0" />
</form>
</div>
<?php } ?>
</div>
</noindex>

<?php /*

Шаблон вывода сортировки в каталоге изображений

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<noindex>
<div style="text-align: right;"><b><?php echo $def_sort; ?>&nbsp;</b><a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allimg.php?category=<?php echo $category_img.$pages_offers; ?>&sort=3"><?php echo $def_sort_name; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allimg.php?category=<?php echo $category_img.$pages_offers; ?>&sort=2"><?php echo $def_sort_firm; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allimg.php?category=<?php echo $category_img.$pages_offers; ?>&sort=1"><?php echo $def_sort_data; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allimg.php?category=<?php echo $category_img.$pages_offers; ?>&amp;sort=4"><?php echo $def_sort_rating; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/rss.php?category=<?php echo $category_img; ?>&type=6">Rss</a> <img alt="rss изображений" src="<?php echo $def_mainlocation; ?>/images/rss.gif" border="0" align="absmiddle" />

<?php if ($razdel!='') { ?>
    <div style="padding-top: 10px;">
<form action="" method="post" class="form-control">
<select style="width: 250px;" name="go_subcat_img" onchange="this.form.submit();"><option value="ALL">Все подразделы</option><?php echo $razdel; ?></select>
</form>
    </div>
<?php } ?>

</div>
    <hr>
</noindex>

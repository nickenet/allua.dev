	</div>

	<aside id="sidebar">
		<section class="widget">
			<h4 class="widgettitle">Разделы</h4>
			<ul>
                            	<li><a href="<? echo "$def_mainlocation_pda"; ?>/index.php?showallcat=1">Все категории</a></li>
				<li><a href="<? echo $def_mainlocation_pda; ?>/search.php">Расширенный поиск</a></li>
				<li><a href="<? echo $def_mainlocation_pda; ?>/index.php?letterss=1">По первой букве</a></li>
			</ul>
		</section>
		<section class="widget clearfix">
			<h4 class="widgettitle">Рекомендуем</h4>
                        <p><? require 'recommend.php'; ?></p>
		</section>
            	<section class="widget clearfix">
			<h4 class="widgettitle">Город</h4>
                        <p><? include ("./template/$def_template/city.php"); ?></p>
		</section>
	</aside>

	<footer id="footer">

		<p><a href="<? echo $def_mainlocation_pda; ?>" target="_blank">mobile &copy; I-Soft Bizness</a><br /><noindex><a rel="nofollow" href="<? echo $def_mainlocation.'/'.$url_full_version; ?>">Полная версия</a></noindex></p>
                
	</footer>

</div>

</body>
</html>
<?php include ("./includes/common_footer.php"); ?>

       <!-- FOOTER -->

       <?php if (($help_section == $cat_help_2) and ($results_amount==0)) include ( "./template/$def_template/main_pub.php" ); ?>

       <div style="text-align: center;"><?php $reklama="bottom_banner"; include ( "./reklama.php" ); ?></div>
               </div>
               
        <div class="col-md-3">

<noindex>
<div class="well">
    <span class="glyphicon glyphicon-ok"></span> <a data-container="body" data-toggle="popover" data-placement="right" data-content="<?php echo str_replace('<br>','',strip_tags($help_section)); ?>" href="#">Помощь</a><br>
    <span class="glyphicon glyphicon-floppy-disk"></span> <span id="notepad_empty">Мой блокнот (0)</span>
    <a id="notepad_full" class="maincat" style="display: none" href="<?php echo "$def_mainlocation"; ?>/notepad.php">Мой блокнот (<span id="notepad_num">0</span>)</a><br>
    <span class="glyphicon glyphicon-phone"></span> <a href="<?php echo "$def_mainlocation"; ?>/pda/">Мобильная версия</a>
    <?php if (isset($_COOKIE['history'])) echo '<br><span class="glyphicon glyphicon-screenshot"></span> <a href="'.$def_mainlocation.'/notepad.php?history=all">Вами просмотрено</a>'; ?>
</div>
</noindex>

<div style="text-align: center; padding-bottom: 3px;"><?php if ( $def_banner2_allowed == "YES" ) include ("./banner.php"); ?></div>

<div class="panel-group" id="accordion">
  <div class="panel panel-danger">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <b>VIP компании</b>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
         <div class="block_firm"><?php include("./featured.php"); ?></div>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
            <b>Популярные категории</b>
        </a>
      </h4>
    </div>
    <div id="collapseSeven" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="block_firm"><?php include ("./topcats.php"); ?></div>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
            <b>Курсы валют</b>
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="block_kurs"><?php include ("./kurs.php"); ?></div>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
            <b>Ближайшие праздники</b>
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="block_kurs"><?php include("./holidays.php"); ?></div>
      </div>
    </div>
  </div>
  <div class="panel panel-info">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
            <b>Опрос</b>
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="block_vote"><?php include("./mainvote.php"); ?></div>
      </div>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
            <b>Товары и услуги</b>
        </a>
      </h4>
    </div>
    <div id="collapseSix" class="panel-collapse collapse in">
      <div class="panel-body">
        <?php include ("./randomservice.php"); ?>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTen">
            <b>Новости партнеров</b>
        </a>
      </h4>
    </div>
    <div id="collapseTen" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="block_firm"><?php include ("./rssinfo.php"); ?></div>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseEl">
            <b>Облако тегов</b>
        </a>
      </h4>
    </div>
    <div id="collapseEl" class="panel-collapse collapse in">
      <div class="panel-body">
        <?php include("./tags.php"); ?>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
            <b>Фотогалерея</b>
        </a>
      </h4>
    </div>
    <div id="collapseFive" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="block_vote"><?php include("./viewfoto.php"); ?></div>
      </div>
    </div>
  </div>

</div>

<noindex>
<div class="dropdown" style="text-align:center;">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Разделы портала <b class="caret"></b></button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="text-align:left;">
    <?php include ( "./menu.php" ); ?>
  </ul>
</div>
</noindex>

<noindex><div align="center" style="padding: 3px;"><?php if ($def_counter_images == "YES") { echo '<a href="'.$def_mainlocation.'/info.php" target="_blank"><img src="'.$def_mainlocation.'/counter.php" width="88" height="31" border="0"></a>';} ?></div></noindex>

<?php include ("./options.php"); ?>

        </div>
      </div>
       </div><!-- /.container -->

    <div id="footer">
      <div class="container">
        <div class="row">
        <div class="col-md-4">

        <div class="title_m">Клиентам</div>
        <div class="menulinks">
	<ul class="reset_menu">
		<li><a rel="nofollow" href="<?php echo "$def_mainlocation"; ?>/reg.php">Бесплатная регистрация</a></li>
		<li><a rel="nofollow" href="<?php echo "$def_mainlocation"; ?>/user.php">Вход в личный кабинет</a></li>
		<li><a rel="nofollow" href="<?php echo "$def_mainlocation"; ?>/compare.php">Тарифные планы</a></li>
		<li><a rel="nofollow" href="<?php echo "$def_mainlocation"; ?>/viewstatic.php?vs=info">Правила размещения</a></li>
	</ul>
	</div>

        </div>
        <div class="col-md-4">

        <div class="title_m">Посетителю</div>
        <div class="menulinks">
	<ul class="reset_menu">
		<li><a rel="nofollow" href="<?php echo "$def_mainlocation"; ?>/ratingtop.php">Рейтинг фирм</a></li>
		<li><a rel="nofollow" href="<?php echo "$def_mainlocation"; ?>/search.php">Расширенный поиск</a></li>
		<li><a rel="nofollow" href="<?php echo "$def_mainlocation"; ?>/allweb.php">Рейтинг сайтов</a></li>
		<li><a rel="nofollow" href="<?php echo "$def_mainlocation"; ?>/alloffers.php">Товары и услуги</a></li>
	</ul>
	</div>

       </div>
        <div class="col-md-4">

	<div class="title_m">Наши контакты</div>

        <div class="menulinks">
	<ul class="reset_menu">
		<li><a rel="nofollow" href="<?php echo "$def_mainlocation"; ?>/contact.php">Обратная связь</a></li>
		<li>8-800-123-45-67</li>
		<li>Skype: isoft</li>
	</ul>
	</div>

<a href="https://twitter.com/isoftdm" class="icon-twitter"></a><a href="https://www.facebook.com/i.soft.wt" class="icon-facebook"></a><a href="http://vkaragande.info/engine/rss.php" class="icon-rss"></a>


        </div>
      </div>

<a href="http://vkaragande.info">I-Soft WT &copy; 2007-2018</a>

      </div>
    </div>

 </body>
</html>

<?php include ("./includes/common_footer.php"); ?>
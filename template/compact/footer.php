       <!-- FOOTER -->
</td>
        <td valign="top" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_right.gif" style="width:242px;"><table width="242" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding: 3px;">
<noindex>
<div align="center">
<span id="notepad_empty">Мой блокнот (0)</span>
<a id="notepad_full" class="maincat" style="display: none" href="<? echo "$def_mainlocation"; ?>/notepad.php">Мой блокнот (<span id="notepad_num">0</span>)</a>
<br><br>
<? if (isset($_COOKIE['history'])) echo '<a href="'.$def_mainlocation.'/notepad.php?history=all">Вами просмотрено</a><br><br>'; ?>
</div>
</noindex>
	    </td>
          </tr>
          <tr>
            <td style="padding: 2px;">
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Разделы</a></li>
		<li><a href="#tabs-2">Категории TOP</a></li>
	</ul>
		<div id="tabs-1">
			<? include ( "./menu.php" ); ?>
		</div>
		<div id="tabs-2">
			<? if ($def_top_categories_show == "YES") include ("./topcats.php"); ?>
		</div>
</div>
	    </td>
          </tr>
          <tr>
            <td><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_line_right.png" width="242" height="12"></td>
          </tr>
          <tr>
            <td style="padding: 2px;">
<div id="tabs1">
	<ul>
		<li><a href="#tabs1-1">TOP5</a></li>
		<li><a href="#tabs1-2">Новые</a></li>
		<li><a href="#tabs1-3">Обновленные</a></li>
	</ul>
		<div id="tabs1-1">
			<? if ($def_top10show == "YES") include("./top.php"); ?>
		</div>
		<div id="tabs1-2">
			<? if ($def_last10show == "YES") include ("./last.php"); ?>
		</div>
		<div id="tabs1-3">
			<? if ($def_lastmod_show == "YES") include("./lastmod.php"); ?>
		</div>
</div>
	    </td>
          </tr>
          <tr>
            <td><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_line_right.png" width="242" height="12"></td>
          </tr>
          <tr>
            <td style="padding: 2px;">
<div id="tabs2">
	<ul>
		<li><a href="#tabs2-1">Курсы</a></li>
		<li><a href="#tabs2-2">Rss канал</a></li>
		<li><a href="#tabs2-3">Опрос</a></li>
	</ul>
		<div id="tabs2-1">
			<? include ("./kurs.php"); ?>
		</div>
		<div id="tabs2-2">
			<? include ("./rssinfo.php"); ?>
		</div>
		<div id="tabs2-3">
			<? include("./mainvote.php"); ?>
		</div>
</div>
	   </td>
          </tr>
          <tr>
            <td><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_line_right.png" width="242" height="12"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#C1C1C1"></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="400" valign="top">
	<table width="400" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td style="padding: 3px;"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>vip.png" width="189" height="36" alt="VIP компании" border="0"></td>
            </tr>
            <tr>
              <td style="padding:3px;"><div class="note blue"><? include("./featured.php"); ?></div>
	    </td>
            </tr>
        </table>
	</td>
        <td valign="top" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_center_bottom.gif">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding: 3px;"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>vitrina.png" width="189" height="36" alt="Витрина" border="0"></td>
          </tr>
          <tr>
            <td style="padding: 3px;"><div class="note red rounded"><? include ("./randomservice.php"); ?></div><br>
		<div align="center"><? if ( $def_banner2_allowed == "YES" ) include ("./banner.php"); ?></div><br><br>
	     </td>
          </tr>
        </table>
	</td>
        <td width="237" valign="top" style="padding: 2px;" class="td_left">
<div id="tabs3">
	<ul>
		<li><a href="#tabs3-1">Фотогалерея</a></li>
		<li><a href="#tabs3-2">Праздники</a></li>
	</ul>
		<div id="tabs3-1">
			<? include("./viewfoto.php"); ?>
		</div>
		<div id="tabs3-2">
			<? include("./holidays.php"); ?>
		</div>
</div><br>
<div align="center"><? if ( $def_banner2_allowed == "YES" ) include ("./banner.php"); ?></div><br><br>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>top_line_03.png" width="1024" height="12"></td>
  </tr>
  <tr>
    <td><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>tags_01.png" width="1024" height="13"></td>
  </tr>
  <tr>
    <td background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>tags_02.png" style="padding: 3px;"><div class="cpojer-links"><? include("./tags.php"); ?></div></td>
  </tr>
  <tr>
    <td><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>tags_03.png" width="1024" height="11"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="340" style="padding: 5px;" bgcolor="#FFFFFF">

<div id="slides">
	<div class="slides_container">
		<div><a href="<? echo $def_mainlocation; ?>/reg.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>slide100.jpg" alt="Тариф Бесплатный" border="0"></a></div>
		<div><a href="<? echo $def_mainlocation; ?>/compare.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>slide200.jpg" alt="Тариф Старт" border="0"></a></div>
		<div><a href="<? echo $def_mainlocation; ?>/compare.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>slide300.jpg" alt="Тариф Бизнес" border="0"></a></div>
		<div><a href="<? echo $def_mainlocation; ?>/compare.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>slide400.jpg" alt="Тариф Премиум" border="0"></a></div>
	</div>
	<a href="" class="thide prev"></a>
	<a href="" class="thide next"></a>
</div>

	</td>
        <td width="350" valign="top" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_footer.jpg" style="padding-left: 30px; padding-top: 30px;"><span class="tt11w">Служба поддержки каталога работает с 09.00-:-18.00<br>
        <br>
        <img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>icq_main.png" width="23" height="23" hspace="2" vspace="2" align="absmiddle">11122233&nbsp;<img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>skype_main.png" width="23" height="23" hspace="2" vspace="2" align="absmiddle">Skype&nbsp;<img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>phone_main.png" width="23" height="23" hspace="2" vspace="2" align="absmiddle">(495) 111-22-33&nbsp;<a href="./contact.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>email_main.png" width="23" height="23" hspace="2" vspace="2" border="0" align="absmiddle"></a><br>
        <br>
        Офис: ул. Молодежная, д.999, офис 123</span></td>
        <td align="center">
        	<div class="counts">
			<ul class="reset">
				<li><? if ($def_counter_images == "YES") { echo "<a href=$def_mainlocation/info.php target=_blank><img src=$def_mainlocation/counter.php width=88 height=31 border=0></a>";} ?></li>
				<li><img src="<? echo "$def_mainlocation/images/"; ?>ratingtop.gif" alt="Участник каталога" border=0></a></li>
				<li><img src="<? echo "$def_mainlocation/images/"; ?>ratingtop.gif" alt="Участник каталога" border=0></a></li>
			</ul>
		</div>
	<span class="tt11w"><? include ("./options.php"); ?></span>
	</td>
        <td>&nbsp;</td>
      </tr>
</table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</div>
<div id="dialog" title="Вход в личный кабинет">
<?

if (empty($_SESSION['login'])) {
if (!isset($_SESSION['random'])) { $_SESSION['random'] = mt_rand(1000000,9999999); $rand = mt_rand(1, 999); }

?>
     <form name="login" action="<? echo $def_mainlocation; ?>/users/user.php?REQ=authorize" method=post>
     <table cellpadding="5" cellspacing="1" border="0" width="100%">
     <tr><td align="right">Логин: <input type="text" name="login" maxlength="100"></td></tr>
     <tr><td align="right">Пароль: <input type="password" name="pass" maxlength="100"></td></tr>
     <tr><td align="right"><img src="<? echo $def_mainlocation; ?>/security.php?<? echo $rand; ?>"> <input type="text" name="security" maxlength="100"></td></tr>
     <tr><td align="right"><input type=submit value="<?php echo "$def_enter"; ?>" name="inbut"></td></tr>
     </table>
     </form>
<? } ?>
</div>
</body>
</html>

<?php include ("./includes/common_footer.php"); ?>

<!-- I-Soft Bizness www.vkaragande.info -->
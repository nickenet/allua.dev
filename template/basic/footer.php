       <!-- FOOTER -->

<br><div align="center"><? $reklama="bottom_banner"; include ( "./reklama.php" ); ?></div><br>

</td>
    <td width="230" valign="top">

<noindex>
<div align="center">
<span id="notepad_empty">Мой блокнот (0)</span>
<a id="notepad_full" class="maincat" style="display: none" href="<? echo "$def_mainlocation"; ?>/notepad.php">Мой блокнот (<span id="notepad_num">0</span>)</a>
<br><br>
<? if (isset($_COOKIE['history'])) echo '<a href="'.$def_mainlocation.'/notepad.php?history=all">Вами просмотрено</a><br><br>'; ?>
</div>
</noindex>

	<? include ("./help.php"); ?>

	<div align=center><? if ( $def_banner2_allowed == "YES" ) include ("./banner.php"); ?></div><br><br>

	<? if ($def_featured_show == "YES") include("./featured.php"); ?>

	<? if ($def_lastmod_show == "YES") include("./lastmod.php"); ?>

        <? if ($def_top10show == "YES") include("./top.php"); ?>

	<? if ($def_offer_rnd == "YES") include ("./randomservice.php"); ?>

	<? if ($def_tags == "YES") include("./tags.php"); ?>

	<? if ($def_vote == "YES") include("./mainvote.php"); ?>

	<? if ($def_fotogal == "YES") include("./viewfoto.php"); ?>

	<? if ($def_holidays == "YES") include("./holidays.php"); ?>

        <? include ("./options.php"); ?>

    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3" bgcolor="#223388"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td bgcolor="#223388"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%" height="40" class="top_menu" style="padding-left:10px;"><a href="http://vkaragande.info/" target="_blank" title="Скрипт каталога организаций I-Soft Bizness">Каталог организаций &copy; 2018</a> </td>
        <td align="right" style="padding-right:10px;"><? if ($def_counter_images == "YES") { echo "<a href=$def_mainlocation/info.php target=_blank><img src=$def_mainlocation/counter.php width=88 height=31 border=0></a>";} ?></td>
      </tr>
    </table></td>
  </tr>
</table>

 </body>
</html>

<?php include ("./includes/common_footer.php"); ?>
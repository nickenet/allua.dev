       <!-- FOOTER -->

<br><div align="center"><? $reklama="bottom_banner"; include ( "./reklama.php" ); ?></div><br>

</td>
            <td width="220" align="left" valign="top"><table width="220" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><br><br>
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

		<? if ($def_vote == "YES") include("./mainvote.php"); ?>

		<? if ($def_fotogal == "YES") include("./viewfoto.php"); ?>

		<? if ($def_holidays == "YES") include("./holidays.php"); ?>

		<? if ($def_tags == "YES") include("./tags.php"); ?>
		
		</td>
              </tr>
              <tr>
                <td align="center"><? include ("./options.php"); ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="1" bgcolor="#1F50A8"></td>
      </tr>
      <tr>
        <td height="50" align="left" bgcolor="#D8F6D1"><table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="270" style="padding-left:5px"><a href="http://vkaragande.info" target="_blank">Каталог организаций нашего региона &copy; 2018</a><br>
              <a href="http://vkaragande.info" target="_blank">I-Soft Bizness</a></td>
            <td align="center"><a href="<? echo "$def_mainlocation"; ?>/user.php">Вход для клиентов</a> | <a href="<? echo "$def_mainlocation"; ?>/reg.php">Регистрация</a></td>
            <td width="300" align="center"><? if ($def_counter_images == "YES") { echo "<a href=$def_mainlocation/info.php target=_blank><img src=$def_mainlocation/counter.php width=88 height=31 border=0></a>";} ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

 </body>
</html>

<?php include ("./includes/common_footer.php"); ?>
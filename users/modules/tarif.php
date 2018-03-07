<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: tarif.php
-----------------------------------------------------
 Назначение: Смена тарифного плана
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}


$firmselector=$f[selector];
$firmname=$f[firmname];
$fmail=$f[mail];
$fphone=$f[phone];

$date_day = date ( "d" );
$date_month = date ( "m" );
$date_year = date ( "Y" );


list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $f["date_upgrade"] );

IF ($f["date_upgrade"]<>"") {

$first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
$second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

if ( $second_date > $first_date )

{ $days = $second_date - $first_date; }

else

{ $days = $first_date - $second_date; }

if (($f[flag] == "A") and ($def_A_expiration != "0"))
$current_result =  $def_A_expiration - ( ( $days ) / ( 60 * 60 * 24 ) );

if (($f[flag] == "B") and ($def_B_expiration != "0"))
$current_result =  $def_B_expiration - ( ( $days ) / ( 60 * 60 * 24 ) );

if (($f[flag] == "C") and ($def_C_expiration != "0"))
$current_result =  $def_C_expiration - ( ( $days ) / ( 60 * 60 * 24 ) );
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Тарифные планы</li>
            <li class="TabbedPanelsTab" tabindex="0">Информация по тарифным планам</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE">&nbsp;Выберите тарифный план:&nbsp;</td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td bgcolor="#EEEEEE" class="tb_cont">
<?php
if (($f["flag"] == "D") or ($current_result <= $def_paypal_expiration_warning))

	{
?>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
if ($def_C_enable == "YES") {
?>

                    <tr>
                      <td width="280"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/t_start.jpg" alt="Тарифный план <? mytarif("C"); ?>" width="280" height="210"></td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                        <tr>
                          <td colspan="2" align="center"><h3><font color="#009900"><? mytarif("C"); ?></font></h3></td>
                        </tr>
                        <tr>
                          <td width="180" align="right">Период пребывания:</td>
                          <td><strong><? echo "$def_C_expiration"; ?></strong> (дней)</td>
                        </tr>
                        <tr>
                          <td width="180" align="right">Стоимость пребывания:</td>
                          <td class="id_url"><? echo "$def_C_price $def_valuta"; ?></td>
                        </tr>

                        <tr>
                          <td width="180">&nbsp;</td>
                          <td>

<?php
echo "
<form action=\"?REQ=authorize&mod=topay\" method=\"post\">
<input type=\"hidden\" name=\"item_names\" value=\"$def_C\">
<input type=\"hidden\" name=\"prices\" value=\"$def_C_price\">
<input type=\"hidden\" name=\"prices_day\" value=\"$def_C_expiration\">
<input type=\"hidden\" name=\"ids\" value=\"$firmselector\">
<input type=\"hidden\" name=\"firms\" value=\"$firmname\">
<input type=\"hidden\" name=\"mails\" value=\"$fmail\">
<input type=\"hidden\" name=\"phones\" value=\"$fphone\">
<input type=\"hidden\" name=\"no_shipping\" value=\"0\">
<input type=submit value=\"$def_C\">
</form>";
?>

			  </td>
                        </tr>
                      </table></td>
                    </tr>
<?php
}
?>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>

<?php
if ($def_B_enable == "YES") {
?>

                    <tr>
                      <td><img src="<? echo "$def_mainlocation"; ?>/users/template/images/t_bizness.jpg" alt="Тарифный план <? mytarif("B"); ?>" width="280" height="210"></td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                        <tr>
                          <td colspan="2" align="center"><h2><font color="#0000FF"><? mytarif("B"); ?></font></h2></td>
                        </tr>
                        <tr>
                          <td width="180" align="right">Период пребывания:</td>
                          <td><strong><? echo "$def_B_expiration"; ?></strong> (дней)</td>
                        </tr>
                        <tr>
                          <td width="180" align="right">Стоимость пребывания:</td>
                          <td class="id_url"><? echo "$def_B_price $def_valuta"; ?></td>
                        </tr>
                        <tr>
                          <td width="180">&nbsp;</td>
                          <td>

<?php
echo "
<form action=\"?REQ=authorize&mod=topay\" method=\"post\">
<input type=\"hidden\" name=\"item_names\" value=\"$def_B\">
<input type=\"hidden\" name=\"prices\" value=\"$def_B_price\">
<input type=\"hidden\" name=\"prices_day\" value=\"$def_B_expiration\">
<input type=\"hidden\" name=\"ids\" value=\"$firmselector\">
<input type=\"hidden\" name=\"firms\" value=\"$firmname\">
<input type=\"hidden\" name=\"mails\" value=\"$fmail\">
<input type=\"hidden\" name=\"phones\" value=\"$fphone\">
<input type=\"hidden\" name=\"no_shipping\" value=\"0\">
<input type=submit value=\"$def_B\">
</form>";
?>

			  </td>
                        </tr>
                      </table></td>
                    </tr>
<?php
}
?>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>

<?php
if ($def_A_enable == "YES") {
?>

                    <tr>
                      <td><img src="<? echo "$def_mainlocation"; ?>/users/template/images/t_premium.jpg" alt="Тарифный план <? mytarif("A"); ?>" width="280" height="210"></td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                        <tr>
                          <td colspan="2" align="center"><h1><font color="#FF0000"><? mytarif("A"); ?></font></h1></td>
                        </tr>
                        <tr>
                          <td width="180" align="right">Период пребывания:</td>
                          <td><strong><? echo "$def_A_expiration"; ?></strong>  (дней)</td>
                        </tr>
                        <tr>
                          <td width="180" align="right">Стоимость пребывания:</td>
                          <td class="id_url"><? echo "$def_A_price $def_valuta"; ?></td>
                        </tr>
                        <tr>
                          <td width="180">&nbsp;</td>
                          <td>
<?php
echo "
<form action=\"?REQ=authorize&mod=topay\" method=\"post\">
<input type=\"hidden\" name=\"item_names\" value=\"$def_A\">
<input type=\"hidden\" name=\"prices\" value=\"$def_A_price\">
<input type=\"hidden\" name=\"prices_day\" value=\"$def_A_expiration\">
<input type=\"hidden\" name=\"ids\" value=\"$firmselector\">
<input type=\"hidden\" name=\"firms\" value=\"$firmname\">
<input type=\"hidden\" name=\"mails\" value=\"$fmail\">
<input type=\"hidden\" name=\"phones\" value=\"$fphone\">
<input type=\"hidden\" name=\"no_shipping\" value=\"0\">
<input type=submit value=\"$def_A\">
</form>";
?>


			  </td>
                        </tr>
                      </table></td>
                    </tr>

<?php
}
?>
                  </table>
<?php
}
else
{
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="280">
<?php
if ($f["flag"]=="C") echo"<img src=\"$def_mainlocation/users/template/images/t_start.jpg\" alt=\"Тарифный план\" width=\"280\" height=\"210\">";
if ($f["flag"]=="B") echo"<img src=\"$def_mainlocation/users/template/images/t_bizness.jpg\" alt=\"Тарифный план\" width=\"280\" height=\"210\">";
if ($f["flag"]=="A") echo"<img src=\"$def_mainlocation/users/template/images/t_premium.jpg\" alt=\"Тарифный план\" width=\"280\" height=\"210\">";
?>
		      </td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                        <tr>
                          <td align="left">Вы пребываете в тарифном плане &laquo;<strong><? mytarif($f["flag"]); ?></strong>&raquo;</td>
			</tr>
			<tr>
                          <td align="left">До завершения осталось: <strong><? echo "$current_result"; ?> дней.</strong></td>
			</tr>
                      </table></td>
                    </tr>
</table>

<?php
}
?>
                    <br>                  </td>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                </tr>
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_left_r.gif" width="3" height="1"></td>
                  <td background="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif" width="3" height="1"></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_right_r.gif" width="3" height="1"></td>
                </tr>
              </table>
              </div>
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td><span class="tb_cont">
<p>Платные тарифные группы имеют ряд преимуществ перед  бесплатной группой:</p>
<ul>
  <li>при просмотре категории, компании находящиеся в  платной тарифной группе показываются всегда первыми, при этом выделяются  цветом, соответствующим данному тарифному плану</li>
  <li>показываются в ротации на всех страницах  каталога в блоке “Особенные компании”</li>
  <li>могут публиковать в каталоге большее количество  продукции и услуг, изображений, excel-прайсов  и т.д.</li>
</ul>
<p>Учитывая данные приоритеты, гарантия того, что компания  попадет в рейтинг ТОП20 компаний каталога, становится значительно выше. Пять  самых популярных компаний в каталоге, также публикуются на всех страницах  каталога.<br>
  <br>
  <strong>Не стоит забывать</strong>:
<ol>
</p>
<ul>
  <li>пребывание в платной группе, ограничивается  сроком</li>
  <li>после истечения срока пребывания в платной  группе, если тариф не был продлен, то все пункты, которые превышают лимиты  бесплатной группы, будут удалены или отключены</li>
  <li>продлевать пребывание аккаунта в платной группе следует  за пять дней до окончания срока</li>
</ul>
<br>
Сравнительную таблицу тарифных планов можно посмотреть по этой <a href="/compare.php" target="_blank">ссылке</a>.</span></td>
                </tr>
              </table>
            </div>
            </div>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
          <div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
          <div class="CollapsiblePanelContent">
                 <? echo "$help_tarif"; ?>
          </div>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
//-->
</script>

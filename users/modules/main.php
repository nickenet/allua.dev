<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: main.php
-----------------------------------------------------
 Назначение: Главная страница
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Общая информация компании</li>
            <li class="TabbedPanelsTab" tabindex="0">Статистика</li>
            <li class="TabbedPanelsTab" tabindex="0">Новости для клиентов</li>
          </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;">Название компании и описание</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont"><span class="btn btn-danger"><? echo $f['firmname']; ?></span><br /><br />
                    <? echo $f['business'];
                    $fx_proc=strlen(strip_tags($f['business'])); $procent=round(($fx_proc*100)/1000); if ($procent>100) $procent=100;
                    ?>
                      <div style="width: 250px; padding-top: 20px; float: right;"><div style="padding-bottom: 5px;"  class="txt tooltip-main well">Ваш показатель <a title="Чем больше описание деятельности компании, тем качественнее индексация в поисковых системах, следовательно Вашу компанию найдут быстрее." rel="tooltip" href="#">описания компании</a> <b><? echo $procent; ?>%</b></div>
                        <div class="progress progress-info progress-striped">
                            <div class="bar" style="width: <? echo $procent; ?>%;"></div>
                        </div>
                      </div>
                  </td>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                </tr>
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_left_r.gif" width="3" height="1"></td>
                  <td background="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif" width="3" height="1"></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_right_r.gif" width="3" height="1"></td>
                </tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                          <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;">Контактные данные</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td align="right">Контактное лицо:</td>
                        <td><b><? echo $f['manager']; if ($f['manager']!='') $procent_c=10; ?></b></td>
                      </tr>
		      <tr>
                        <td align="right">Индекс:</td>
                        <td><b><? echo $f['zip']; ?></b></td>
                      </tr>
<?php

$re1=$db->query ("SELECT * FROM $db_location WHERE locationselector='$f[location]'");
$fe1=$db->fetcharray ($re1);

if ($def_country_allow == "YES")
{
?>
                      <tr>
                        <td width="150" align="right"><? echo "$def_country"; ?>:</td>
                        <td><b><? echo $fe1['location']; ?></b></td>
                      </tr>
<?php
}

else

{
?>
                      <tr>
                        <td width="150" align="right"><? echo "$def_city"; ?>:</td>
                        <td><b><? echo $fe1['location'];  $procent_c=$procent_c+5;  ?></b></td>
                      </tr>
<?php
}
if ($def_states_allow == "YES")
{
	$ree=$db->query ("SELECT * FROM $db_states WHERE stateselector='$f[state]'");
	$fee=$db->fetcharray ($ree);
?>
                      <tr>
                        <td width="150" align="right"><? echo "$def_state"; ?>:</td>
                        <td><b><? echo $fee['state']; ?></b></td>
                      </tr>
<?php
}

if ($def_country_allow == "YES") {
?>
                      <tr>
                        <td width="150" align="right">Город:</td>
                        <td><b><? echo $f['city']; if ($f['city']!='') $procent_c=$procent_c+5; ?></b></td>
                      </tr>
<?php
}
?>
                      <tr>
                        <td width="150" align="right">Почтовый адрес:</td>
                        <td><b><? echo $f['address']; if ($f['address']!='') $procent_c=$procent_c+25; ?></b></td>
                      </tr>
                      <tr>
                        <td width="150" align="right">Телефон:</td>
                        <td><b><? echo $f['phone']; if ($f['phone']!='') $procent_c=$procent_c+20; ?></b></td>
                      </tr>
                      <tr>
                        <td width="150" align="right">Факс:</td>
                        <td><b><? echo $f['fax']; if ($f['fax']!='') $procent_c=$procent_c+10; ?></b></td>
                      </tr>
                      <tr>
                        <td align="right">Мобильный:</td>
                        <td><b><? echo $f['mobile']; if ($f['mobile']!='') $procent_c=$procent_c+10; ?></b></td>
                      </tr>
                      <tr>
                        <td align="right">E-mail:</td>
                        <td><b><a href="mailto:<? echo $f['mail']; ?>"><? echo $f['mail']; if ($f['mail']!='') $procent_c=$procent_c+10;  ?></a></b></td>
                      </tr>
                      <tr>
                        <td align="right">URL / Адрес сайта:</td>
                        <td><b><a href="<? echo $f['www']; ?>" target="_blank"><? echo $f['www']; if ($f['www']!='') $procent_c=$procent_c+10; ?></a></b></td>
                      </tr>
<?php
if (!empty($f[icq]))
{
?>
		      <tr>

                        <td align="right">UIN ICQ:</td>
                        <td><b><a href="http://web.icq.com/whitepages/add_me?uin=<? echo $f['icq']; ?>&amp;action=add"><? echo $f['icq']; ?></a></b> <img src="http://web.icq.com/whitepages/online?icq=<? echo $f['icq']; ?>&amp;img=5" alt="режим icq"></td>
                      </tr>
<?php
}

if ($def_reserved_1_enabled == "YES")
{
?>
                      <tr>
                        <td align="right"><? echo $def_reserved_1_name; ?>:</td>
                        <td><b><? echo $f['reserved_1']; ?></b></td>
                      </tr>
<?php
}

if ($def_reserved_2_enabled == "YES")
{
?>
                      <tr>
                        <td align="right"><? echo $def_reserved_2_name; ?>:</td>
                        <td><b><? echo $f['reserved_2']; ?></b></td>
                      </tr>
<?php
}

if ($def_reserved_3_enabled == "YES")
{
?>
                      <tr>
                        <td align="right"><? echo $def_reserved_3_name; ?>:</td>
                        <td><b><? echo $f['reserved_3']; ?></b></td>
                      </tr>
<?php
}
?>


                  </table>
                      <div style="width: 250px; padding-top: 20px; float: right;"><div style="padding-bottom: 5px;"  class="txt tooltip-main well">Ваш показатель <a title="Чем больше Вы укажете контактных данных компании, тем больше вероятность, что с Вами быстрее свяжутся." rel="tooltip" href="#">контактных данных</a> <b><? echo $procent_c; ?>%</b></div>
                        <div class="progress progress-info progress-striped">
                            <div class="bar" style="width: <? echo $procent_c; ?>%;"></div>
                        </div>
                      </div>
                  </td>
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
                  <td width="280" align="right">Просмотров:</td>
                  <td><b><? echo $f['counter']; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">Посетителей сайта:</td>
                  <td><b><? echo $f['webcounter']; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">Полученные сообщения:</td>
                  <td><b><? echo $f['mailcounter']; ?></b></td>
                </tr>
<?php
if ($def_allow_info == "YES")
{
?>
                <tr>
                  <td width="280" align="right"><?php echo "$def_info_dop" ?>:</td>
                  <td><b><? echo $f['info']; ?></b></td>
                </tr>
<?php
}
if ($def_allow_products == "YES")
{
?>
                <tr>
                  <td width="280" align="right">Просмотров продукции и услуг:</td>
                  <td><b><? echo $f['price_show']; ?></b></td>
                </tr>
<?php
}
if ($def_banner_allowed == "YES") {

	if ( (($f[flag] == "D") and ($def_D_banner == "YES")) or (($f[flag] == "C") and ($def_C_banner == "YES")) or (($f[flag] == "B") and ($def_B_banner == "YES")) or (($f[flag] == "A") and ($def_A_banner == "YES")) )

	{

		@ $bannerctr=$f["banner_click"]*100/$f["banner_show"];
		@ $bannerctr=round($bannerctr,2);
?>

                <tr>
                  <td width="280" align="right">Показы баннеров:</td>
                  <td><b><? echo $f['banner_show']; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">Кликов по баннеру:</td>
                  <td><b><? echo $f['banner_click']; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">CTR (%) баннера:</td>
                  <td><b><? echo "$bannerctr%"; ?></b></td>
                </tr>
<?php
}
}

if ($def_reviews_enable == "YES")

{
		$rev=$db->query ("SELECT * from $db_reviews where company = '$f[selector]'") or die (mysql_error());
		$reviews=mysql_num_rows($rev);

?>
                <tr>
                  <td width="280" align="right">Комментарии:</td>
                  <td><b><? echo "$reviews"; ?></b></td>
                </tr>
<?php
}

if ($def_rating_allowed == "YES") {

	unset($rating_listing);

	if (($def_rating_allowed == "YES") and ($f[countrating] > 0) and ($f[votes] > 0)) {
		$rating_listing="";
		for ($rate=0;$rate<$f[countrating];$rate++) {
			$rating_listing.="<img src=\"$def_mainlocation/template/$def_template/images/star.gif\" border=0 alt=\"\">";
		}

		$rating_listing.=" ($f[votes] $def_votes)";
?>

                <tr>
                  <td width="280" align="right">Оценка посетителей:</td>
                  <td><? echo "$rating_listing"; ?></td>
                </tr>

<?php
	}
}
?> 
            </table>
            </div>
            <div class="TabbedPanelsContent">
 		<? include ('doc/news.php'); ?>
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
            <? echo "$help_main"; ?>
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
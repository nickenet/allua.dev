<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: footer.php
-----------------------------------------------------
 Назначение: Footer шаблона
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

</td>
    <td width="250" valign="top"><table width="250" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="4"></td>
      </tr>
      <tr>
        <td align="center"><table width="240" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" align="center" class="my_calendar">
<script language="javascript" type="text/javascript">
<!--
print_date();
//-->
</script>            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table width="244" border="0" cellspacing="0" cellpadding="0" id="tarif">
          <tr>
            <td><table width="238" border="0" cellspacing="0" cellpadding="1">
              <tr>
                <td width="32"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/config.png" width="30" height="30"></td>
                <td width="206" align="left" class="mainmenu"><a href="user.php?REQ=authorize&mod=config">Настройки в каталоге</a></td>
              </tr>
              <tr>
                <td width="32"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/seo.png" width="30" height="30"></td>
                <td width="206" align="left" class="mainmenu">
                    <?
                    $style_asd='';
                    $img_asd='';
                    if (($f['metatitle']=='') or ($f['metadescr']=='') or ($f['metakeywords']=='') or ($f['domen']==''))
                    {
                        $style_asd='style="color:#FF0000;"';
                        $img_asd='<img src="'.$def_mainlocation.'/users/template/images/stop.gif" border="0" align="absmiddle"';
                    }
                    echo '<a '.$style_asd.' href="user.php?REQ=authorize&mod=seo">Имя страницы и SEO</a> '.$img_asd;
                    ?>
                </td>
              </tr>
              <tr>
              <tr>
                <td width="32"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/case.png" width="30" height="30"></td>
                <td width="206" align="left" class="mainmenu">
                    <?
                    $style_asd='';
                    $img_asd='';
                    if (($f['tcase']==0) or ($f['tmail']!=1))
                    {
                        $style_asd='style="color:#FF0000;"';
                        $img_asd='<img src="'.$def_mainlocation.'/users/template/images/stop.gif" border="0" align="absmiddle"';
                    }
                    echo '<a '.$style_asd.' href="user.php?REQ=authorize&mod=case">Документы компании</a> '.$img_asd;
                    ?>
                </td>
              </tr>
              <tr>
                <td width="32"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/seo_design.png" width="30" height="30"></td>
                <td width="206" align="left" class="mainmenu"><a href="user.php?REQ=authorize&mod=theme">Темы оформления</a></td>
              </tr>
              <tr>
                <td width="32"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/kodrating.png" width="30" height="30"></td>
                <td width="206" align="left" class="mainmenu"><a href="user.php?REQ=authorize&mod=kodrating">Код для рейтинга</a></td>
              </tr>
              <tr>
                <td width="32"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/smena_tarifa.png" width="30" height="30"></td>
                <td width="206" align="left" class="mainmenu"><a href="user.php?REQ=authorize&mod=tarif">Обновить тарифный план</a></td>
              </tr>
              <tr>
                <td width="32"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/shopping.png" width="30" height="30"></td>
                <td width="206" align="left" class="mainmenu"><a href="user.php?REQ=authorize&mod=uslugi">Заказать другие услуги каталога</a></td>
              </tr>
              <tr>
                <td width="32"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/Stats.png" width="30" height="30"></td>
                <td width="206" align="left"class="mainmenu"><a href="user.php?REQ=authorize&mod=stat">Работа со статистикой</a></td>
              </tr>
              <tr>
                <td width="32"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/Print.png" width="30" height="30"></td>
                <td width="206" align="left" class="mainmenu"><a href="user.php?REQ=authorize&mod=card">Печать визитной карточки</a></td>
              </tr>

<?php

// подключаем разделы для сторонних модулей

require ('template/apx_right.php');

?>

              <tr>
                <td width="32">&nbsp;</td>
                <td width="208">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center">
        <table width="244" border="0" cellspacing="0" cellpadding="0" id="uprava">
          <tr>
            <td><table width="238" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="32"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/operativnaya.png" width="32" height="32"></td>
                <td width="206" align="left" class="zag">&nbsp;Контакты с администрацией</td>
              </tr>
              <tr>
                <td colspan="2" align="left" class="txt"><? require ('doc/contact.php'); ?></td>
              </tr>
              <tr>
                <td><img src="<? echo "$def_mainlocation"; ?>/users/template/images/mail.png" width="32" height="32"></td>
                <td width="206" align="left" class="zag">&nbsp;Сообщение администрации</td>
              </tr>
              <tr>
                <td colspan="2">
<FORM ACTION="?REQ=authorize&mod=support" METHOD="POST">
<textarea name="tosupport" id="textarea_main" cols="20" rows="5" onfocus="document.getElementById('s_but').style.visibility='visible'"></textarea><br />
<input type="submit" id="s_but" value="Отправить" style="visibility: hidden" class="btn" />
</FORM>
		</td>
                </tr>
            </table></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="1" bgcolor="#000"></td>
  </tr>
  <tr>
    <td height="35" align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%" align="left"><a href="http://vkaragande.info/"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/up_logo.gif" alt="Личный кабинет" width="270" height="88" border="0"></a></td>
        <td align="right" valign="top" style="padding-right:10px; padding-top:5px;"><? require ('doc/copyright.php'); ?></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
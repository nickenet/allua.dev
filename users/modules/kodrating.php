<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: config.php
-----------------------------------------------------
 Назначение: Настройки в каталоге
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$kod_top="<a href=\"$def_mainlocation/view.php?id=$f[selector]\" title=\"$f[firmname]\"><img src=\"$def_mainlocation/images/ratingtop.gif\" alt=\"Участник каталога\" border=0></a>";

$kod_rating="
<form action=\"$def_mainlocation/view.php?REQ=view&amp;id=$f[selector]&amp;type=rate\" method=POST>
<select name=\"rate\">
           <option value='6'>Оцените нашу компанию</option>
           <option value='5'>5 Отлично</option>
           <option value='4'>4 Хорошо</option>
           <option value='3'>3 Удовлетворительно</option>
           <option value='2'>2 Плохо</option>
           <option value='1'>1 Ужасно</option>
</select>
<input type=\"submit\" name=\"button\" value=\"Оценить\">
</form>
";

?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Улучшения рейтинга компании в каталоге</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE">&nbsp;Варианты кодов:&nbsp;</td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>В <a href="<?php echo $def_mainlocation; ?>/ratingtop.php">рейтинге</a> принимают участие все зарегистрированные организации в каталоге.<BR>
      Основным показателем рейтинга является количество   просмотров аккаунта организации. Чем больше просмотров, тем соответственно и   выше рейтинг организации в каталоге.<BR>
    Вторым показателем является оценка компании. Оценить компанию может любой посетитель   каталога, при просмотре аккаунта организации. Чем Выше оценка, тем Выше будет   рейтинг при одинаковых показателях просмотра организации.<BR></td>
  </tr>
  <tr>
    <td>Для увеличения посещаемости Вашего аккаунта в нашем каталоге, рекомендуется установить код для   рейтинга на других сайтах (например, на официальном сайте компании). </td>
  </tr>
  <tr>
    <td align="center" style="padding-top:3px; padding-bottom:3px;"><?php echo $kod_top; ?></td>
  </tr>
  <tr>
    <td>Скопируйте предложенный HTML код и установите его на любом сайте. Чем больше   переходов будет по Вашей ссылке, тем Выше рейтинг Вашей организации.</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><textarea name="textarea" cols="60" rows="6"><?php echo $kod_top; ?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
Для оценки Вашей компании в нашем каталоге, Вы можете установить форму рейтинга на других сайтах. Посетитель, поставивший Вам оценку, посетит Вашу страницу в нашем каталоге. Больше оценок, Выше рейтинг при одинаковых условиях с другими компаниями в каталоге.    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><?php echo $kod_rating; ?></td>
  </tr>
  <tr>
    <td>Скопируйте предложенный HTML код и установите его на любом сайте.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><textarea name="textarea2" cols="60" rows="15"><?php echo $kod_rating; ?></textarea></td>
  </tr>
</table>

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
            <? echo "$help_kodrating"; ?>
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
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

if ( $_POST["changed"] == "true" )

	{

$db->query  ( "UPDATE $db_users SET off_mailer='$_POST[off_mailer]', off_mail='$_POST[off_mail]', off_rev='$_POST[off_rev]', on_newrev='$_POST[on_newrev]', off_friends='$_POST[off_friends]', on_rating='$_POST[on_rating]' WHERE login='$_SESSION[login]'" );

echo "<center><div align=\"center\" id=\"messages\">Ваши данные успешно обновлены! <img src=\"$def_mainlocation/users/template/images/ok.gif\" width=\"64\" height=\"64\" hspace=\"2\" vspace=\"2\" align=\"middle\"></div></center><br><br>";



	}

else

	{

?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Настройки в каталоге</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE">&nbsp;Параметры:&nbsp;</td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont">

<FORM ACTION="?REQ=authorize&mod=config" METHOD="POST">

<table border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="right">Получать рассылку от администрации&nbsp;</td>
    <td><select name="off_mailer">
<?php
if ($f[off_mailer]==0) {
?>
      <option value="0" selected>Да</option>
      <option value="1">Нет</option>
<?php }
else {
?>
      <option value="0">Да</option>
      <option value="1" selected>Нет</option>
<?php } ?>
    </select>
    </td>
  </tr>
  <tr>
    <td align="right">Разрешить отправку сообщений на Ваш электронный адрес&nbsp;</td>
    <td><select name="off_mail">
<?php
if ($f[off_mail]==0) {
?>
      <option value="0" selected>Да</option>
      <option value="1">Нет</option>
<?php }
else {
?>
      <option value="0">Да</option>
      <option value="1" selected>Нет</option>
<?php } ?>
    </select></td>
  </tr>
  <tr>
    <td align="right">Разрешить добавление комментариев&nbsp;</td>
    <td><select name="off_rev">
<?php
if ($f[off_rev]==0) {
?>
      <option value="0" selected>Да</option>
      <option value="1">Нет</option>
<?php }
else {
?>
      <option value="0">Да</option>
      <option value="1" selected>Нет</option>
<?php } ?>
    </select></td>
  </tr>
  <tr>
    <td align="right">Разрешить отправку сообщения друзьям с Вашего аккаунта&nbsp;</td>
    <td><select name="off_friends">
<?php
if ($f[off_friends]==0) {
?>
      <option value="0" selected>Да</option>
      <option value="1">Нет</option>
<?php }
else {
?>
      <option value="0">Да</option>
      <option value="1" selected>Нет</option>
<?php } ?>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Сообщать на e-mail о поступивших комментариях&nbsp;</td>
    <td><select name="on_newrev">
<?php
if ($f[on_newrev]==1) {
?>
      <option value="1" selected>Да</option>
      <option value="0">Нет</option>
<?php }
else {
?>
      <option value="1">Да</option>
      <option value="0" selected>Нет</option>
<?php } ?>
    </select></td>
  </tr>
  <tr>
    <td align="right">Сообщать на e-mail о поступивших оценках к компании&nbsp;</td>
    <td><select name="on_rating">
<?php
if ($f[on_rating]==1) {
?>
      <option value="1" selected>Да</option>
      <option value="0">Нет</option>
<?php }
else {
?>
      <option value="1">Да</option>
      <option value="0" selected>Нет</option>
<?php } ?>
    </select></td>
  </tr>
  <tr>
    <td align="right"><input type="submit" name="button" value="Сохранить"><input type="hidden" name="changed" value="true"></td>
    <td>&nbsp;</td>
  </tr>
</table>
</FORM>
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
            <? echo "$help_config"; ?>
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

<?php
}
?>
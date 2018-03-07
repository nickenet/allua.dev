<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: card.php
-----------------------------------------------------
 Назначение: Выбор для печати визитной карточки
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
            <li class="TabbedPanelsTab" tabindex="0">Печать визитной карточки</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;">Типы визитных карточек</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo $def_mainlocation; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300" align="center"><table width="255" border="0" cellspacing="0" cellpadding="0" id="uprava">
      <tr>
        <td width="218" height="142" valign="top" bgcolor="#FFFFFF"><table width="218" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="left" style="padding-left:3px; padding-right:3px;"><div align="center"><strong><? echo $f['firmname']; ?></strong></div>
                  <br>
<?php
 if ($f[phone]!="") { $cPhone = "<b>Тел.:</b> $f[phone] <br>"; echo $cPhone; }
 if ($f[fax]!="") { $cFax = "<b>Факс:</b> $f[fax] <br>"; echo $cFax; }
 if ($f[mail]!="") { $cMail = "<b>E-mail:</b> $f[mail] <br>"; echo $cMail; }
 if ($f[address]!="") { $cAddress = "<b>Адрес:</b> $f[address]"; echo $cAddress; }
 $cFirmname = $f['firmname'];
 $cId = $f['selector'];
 if ($f['domen']!='') $name_url=$def_mainlocation.'/'.$f['domen']; else $name_url=$def_mainlocation.'/view.php?id='.$f['selector'];

?>	      </td>
            </tr>
            <tr>
              <td height="22" align="center" class="txt"><? echo $name_url; ?></td>
            </tr>
            <tr>
              <td height="10"></td>
            </tr>
        </table></td>
        <td width="37"><img src="<? echo $def_mainlocation; ?>/users/template/card/1.gif" width="37" height="142"></td>
      </tr>
    </table></td>
    <td>
    <FORM ACTION="template/card_print.php" METHOD="POST" TARGET="_blank">
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>Количество карточек на печать&nbsp;</td>
        <td><select name="select" id="select">
          <option selected>2</option>
          <option>4</option>
          <option>6</option>
          <option>8</option>
          <option>10</option>
            </select>
          &nbsp;</td>
        <td><input type="submit" name="button" id="button" value="На печать">
	  <input type="hidden" name="type_card" value="1">
	  <input type="hidden" name="phone" value="<? echo $cPhone; ?>">
	  <input type="hidden" name="fax" value="<? echo $cFax; ?>">
	  <input type="hidden" name="mail" value="<? echo $cMail; ?>">
	  <input type="hidden" name="address" value="<? echo $cAddress; ?>">
	  <input type="hidden" name="firmname" value="<? echo $cFirmname; ?>">
	  <input type="hidden" name="cid" value="<? echo $cId; ?>">
	  <input type="hidden" name="cdef_mainlocation" value="<? echo $name_url; ?>">
        </td>
      </tr>
    </table>
    </FORM>
    </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="255" border="0" cellspacing="0" cellpadding="0" id="uprava">
      <tr>
        <td width="218" height="142" valign="top" bgcolor="#FFFFFF"><table width="218" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="left" style="padding-left:3px; padding-right:3px;"><div align="center"><strong><? echo $f['firmname']; ?></strong></div>
                  <br>
<?php
 if ($f[phone]!="") { $cPhone = "<b>Тел.:</b> $f[phone] <br>"; echo $cPhone; }
 if ($f[fax]!="") { $cFax = "<b>Факс:</b> $f[fax] <br>"; echo $cFax; }
 if ($f[mail]!="") { $cMail = "<b>E-mail:</b> $f[mail] <br>"; echo $cMail; }
 if ($f[address]!="") { $cAddress = "<b>Адрес:</b> $f[address]"; echo $cAddress; }
 $cFirmname = $f['firmname'];
 $cId = $f['selector'];
 if ($f['domen']!='') $name_url=$def_mainlocation.'/'.$f['domen']; else $name_url=$def_mainlocation.'/view.php?id='.$f['selector'];

?>	      </td>
            </tr>
            <tr>
              <td height="22" align="center" class="txt"><? echo $name_url; ?></td>
            </tr>
            <tr>
              <td height="10"></td>
            </tr>
        </table></td>
        <td width="37"><img src="<? echo $def_mainlocation; ?>/users/template/card/2.gif" width="37" height="142"></td>
      </tr>
    </table></td>
    <td>
    <FORM ACTION="template/card_print.php" METHOD="POST" TARGET="_blank">
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>Количество карточек на печать&nbsp;</td>
        <td><select name="select" id="select">
          <option selected>2</option>
          <option>4</option>
          <option>6</option>
          <option>8</option>
          <option>10</option>
            </select>
          &nbsp;</td>
        <td><input type="submit" name="button" id="button" value="На печать">
	  <input type="hidden" name="type_card" value="2">
	  <input type="hidden" name="phone" value="<? echo $cPhone; ?>">
	  <input type="hidden" name="fax" value="<? echo $cFax; ?>">
	  <input type="hidden" name="mail" value="<? echo $cMail; ?>">
	  <input type="hidden" name="address" value="<? echo $cAddress; ?>">
	  <input type="hidden" name="firmname" value="<? echo $cFirmname; ?>">
	  <input type="hidden" name="cid" value="<? echo $cId; ?>">
	  <input type="hidden" name="cdef_mainlocation" value="<? echo $name_url; ?>">
        </td>
      </tr>
    </table>
    </FORM>
    </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
			</td>
                        </tr>
                  </table></td>
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
          <div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo $def_mainlocation; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
          <div class="CollapsiblePanelContent">
            <? echo $help_card; ?>
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
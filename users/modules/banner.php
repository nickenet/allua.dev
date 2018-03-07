<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: banner.php
-----------------------------------------------------
 Назначение: Загрузка баннеров
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if ( $_POST["do"] == "uploaded" ) require_once ('modules/uploaded.php');


$banhandle = opendir('.././banner');

$bancount=0;

while (false != ($banfile = readdir($banhandle))) {
	if ($banfile != "." && $banfile != "..") {
		$banbanner[$bancount]="$banfile";
		$bancount++;
	}
}

closedir($banhandle);

for ($aaa=0;$aaa<count($banbanner);$aaa++)
{
	$banrbanner = explode(".", $banbanner[$aaa]);
	if ($banrbanner[0] == $f[selector]) $filename="$banbanner[$aaa]";
}

$handle = opendir('.././banner2');

$count=0;
while (false != ($file = readdir($handle))) {
	if ($file != "." && $file != "..") {
		$banner2[$count]="$file";
		$count++;
	}
}

closedir($handle);

for ($xx=0;$xx<count($banner2);$xx++)
{
	$rbanner2 = explode(".", $banner2[$xx]);
	if ($rbanner2[0] == $f[selector]) $filename2 ="$banner2[$xx]";
}

?>
	
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Рекламные баннеры</li>
            <li class="TabbedPanelsTab" tabindex="0">Допустимые параметры баннеров</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE">&nbsp;Баннеры:&nbsp;</td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont">
		   <div align="center">
		   Большой баннер <br /><br />	
		   <?php if ( isset ( $filename ) ) { echo " <img src=\"$def_mainlocation/banner/$filename?$randomized\" alt=\"Большой баннер\"><br> ";}
		         else
			 { echo " <img src=\"$def_mainlocation/users/template/images/nobanner.gif\" alt=\"Ваш большой баннер не загружен\"><br> ";}  	
		    ?><br><br>
		   Боковой баннер <br /><br />	
		   <?php if ( isset ( $filename2 ) ) { echo " <img src=\"$def_mainlocation/banner2/$filename2?$randomized\" alt=\"Боковой баннер\"><br> ";}
		         else
			 { echo " <img src=\"$def_mainlocation/users/template/images/nobanner2.gif\" alt=\"Ваш боковой баннер не загружен\"><br> ";}  	
		    ?><br>
                  </div></td>
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
                        <td bgcolor="#EEEEEE">&nbsp;Загрузить / Обновить / Удалить :&nbsp;</td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont" align="center">
 <b>Большой баннер</b> <br /><br />
<?php
if ( ifEnabled_user ($f[flag] , "banner") ) {
?>

<FORM ACTION="?REQ=authorize&mod=banner" METHOD="POST" ENCTYPE="multipart/form-data">
<?php if ( ( isset ( $uploaded ) and ( $_POST["mode"] == "banner" ) ) ) { echo "<b>$uploaded</b><br><br>";}?>
<INPUT TYPE="file" NAME="img1" SIZE="25">&nbsp;<input type=hidden name=step value="back"><input type=hidden name=mode value="banner"><input type=hidden name=do value="uploaded"><INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo "$def_upload";?>">&nbsp;<INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo "$def_remove";?>" style="color: #FFFFFF; background: #D55454;">
</FORM>	

<?php
}
else
{ ?>

<strong class="id_url">Обратите внимание!</strong><br>
Данный раздел личного кабинета работает в демонстрационном режиме.<br> Для того, чтобы полноценно воспользоваться возможностями этого сервиса вам необходимо активировать другой тарифный план.<br> 
Сравнительную таблицу тарифных планов можно посмотреть по этой <a href="<? echo "$def_mainlocation"; ?>/compare.php">ссылке</a>.<br><br>

<?php
}
?>
 <b>Боковой баннер</b> <br /><br />
<?php
if ( ifEnabled_user ($f[flag] , "banner2") ) {
?>

<FORM ACTION="?REQ=authorize&mod=banner2" METHOD="POST" ENCTYPE="multipart/form-data">
<?php if ( ( isset ( $uploaded ) and ( $_POST["mode"] == "banner2" ) ) ) { echo "<b>$uploaded</b><br><br>";}?>
<INPUT TYPE="file" NAME="img1" SIZE="25">&nbsp;<input type=hidden name=step value="back"><input type=hidden name=mode value="banner2"><input type=hidden name=do value="uploaded"><INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo "$def_upload";?>">&nbsp;<INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo "$def_remove";?>" style="color: #FFFFFF; background: #D55454;">
</FORM>	

<?php
}
else
{ ?>

<strong class="id_url">Обратите внимание!</strong><br>
Данный раздел личного кабинета работает в демонстрационном режиме.<br> Для того, чтобы полноценно воспользоваться возможностями этого сервиса вам необходимо активировать другой тарифный план.<br> 
Сравнительную таблицу тарифных планов можно посмотреть по этой <a href="<? echo "$def_mainlocation"; ?>/compare.php">ссылке</a>.<br><br>

<?php
}
?>
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
                  <td align="right">&nbsp;</td>
                  <td><strong>Большой баннер</strong></td>
                </tr>		
		<tr>
                  <td width="180" align="right">Ширина (пикселей):</td>
                  <td><? echo "$def_banner_width"; ?></td>
                </tr>
                <tr>
                  <td width="180" align="right">Высота (пикселей):</td>
                  <td><? echo "$def_banner_height"; ?></td>
                </tr>
                <tr>
                  <td width="180" align="right">Размер файла (байты):</td>
                  <td><? echo "$def_banner_size"; ?></td>
                </tr>
                <tr>
                  <td width="180" align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
		<tr>
                  <td align="right">&nbsp;</td>
                  <td><strong>Боковой баннер</strong></td>
                </tr>		
		<tr>
                  <td width="180" align="right">Ширина (пикселей):</td>
                  <td><? echo "$def_banner2_width"; ?></td>
                </tr>
                <tr>
                  <td width="180" align="right">Высота (пикселей):</td>
                  <td><? echo "$def_banner2_height"; ?></td>
                </tr>
                <tr>
                  <td width="180" align="right">Размер файла (байты):</td>
                  <td><? echo "$def_banner2_size"; ?></td>
                </tr>
                <tr>
                  <td width="180" align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="180" align="right">Типы файлов:</td>
                  <td><strong>JPG, BMP, GIF, PNG</strong></td>
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
            <? echo "$help_banner"; ?>
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
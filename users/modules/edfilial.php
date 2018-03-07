<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: filial.php
-----------------------------------------------------
 Назначение: Филиалы компании
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}


$flag = $f['flag'];
if (isset($_POST['seek'])) $_POST['seek']=intval($_POST['seek']);
if (isset($_POST['seek'])) $_POST['seek']=intval($_POST['seek']);

	if ($f[filial]=="") $all_filial=0; else $all_filial=$f[filial];
	
// Блок изменения информации

	if ( $_POST["changed"] == "true" ) {

		$namef = safeHTML ($_POST["namef"]);
		$businessf = safeHTML ($_POST["businessf"]);
		$countryf = safeHTML ($_POST["countryf"]);
		$statef = safeHTML ($_POST["statef"]);
		$cityf = safeHTML ($_POST["cityf"]);
		$zipf = safeHTML ($_POST["zipf"]);
		$addressf = safeHTML ($_POST["addressf"]);
		$phonef = safeHTML ($_POST["phonef"]);
		$faxf = safeHTML ($_POST["faxf"]);
		$mobilef = safeHTML ($_POST["mobilef"]);
		$managerf = safeHTML ($_POST["managerf"]);
		$koordinatif = safeHTML ($_POST["koordinatif"]);
		
		if ( $_POST["wwwf"] <> "" ) { if ( preg_match("#http://#", $_POST["wwwf"])) $wwwf = $_POST[wwwf]; else $wwwf = "http://$_POST[wwwf]"; }
		$wwwf = safeHTML ( $wwwf );

                $businessf=isb_sub($businessf, $def_filial_descr_size);
                $koordinatif=isb_sub($koordinatif, $def_filial_koord_size);

	// Проверяем заполнение полей

	if ( ( empty ( $namef ) or empty ( $businessf ) or empty ( $cityf ) or empty ( $addressf ) ) and ( $_POST["but"] != "$def_offers_delete" ) and ( $_POST["but"] != "$def_offers_edit_but" ) and ( $_POST["do"] != "Upload" ) )

	{
			$empty = "$def_offers_empty - $namef, $businessf, $cityf, $addressf";
	}

		// Заносим данные в базу

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_add" ) )

		{

				$db->query  ( "INSERT INTO $db_filial (firmselector, firmname, category, flag, namef, businessf, countryf, statef, cityf, zipf, addressf, phonef, faxf, mobilef, managerf, koordinatif, www) 
							     VALUES ('$f[selector]', '$f[firmname]', '$f[category]', '$f[flag]', '$namef', '$businessf', '$countryf', '$statef', '$cityf', '$zipf', '$addressf', '$phonef', '$faxf', '$mobilef', '$managerf', '$koordinatif', '$wwwf')" )
				or die ( "ERROR010: mySQL error, cant insert into INFO. (filial.php)" );

				$img_uploaded=mysql_insert_id();

				$all_filial++;	
				
				$db->query  ( "UPDATE $db_users SET filial='$all_filial' $sql_up WHERE selector='$f[selector]'" )
				or die ( "ERROR012: mySQL error, can't update USERS. (filial.php)" );

		}

		// Удаление филиала

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_delete" ) and (isset($_POST['seek'])) )

		{

			@unlink ( "../filial/$_POST[seek].gif" );
			@unlink ( "../filial/$_POST[seek].bmp" );
			@unlink ( "../filial/$_POST[seek].jpg" );
			@unlink ( "../filial/$_POST[seek].png" );

			@unlink ( "../filial/$_POST[seek]-small.gif" );
			@unlink ( "../filial/$_POST[seek]-small.bmp" );
			@unlink ( "../filial/$_POST[seek]-small.jpg" );
			@unlink ( "../filial/$_POST[seek]-small.png" );

                        $post_seek=intval($_POST['seek']);

			$db->query  ( "DELETE FROM $db_filial WHERE num='$post_seek' and firmselector='$f[selector]'" )
			or die ( "ERROR011: mySQL error, can't delete from INFO. (filial.php)" );

			$all_filial=$all_filial-1;	
				
			$db->query  ( "UPDATE $db_users SET filial='$all_filial' WHERE selector='$f[selector]'" )
			or die ( "ERROR012: mySQL error, can't update USERS. (filial.php)" );

			unset ($_POST["notdop"]);
			unset ($_POST["seek"]);

		}

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_change" ) )

		{
                        $post_seek=intval($_POST['seek']);
			$db->query  ( "UPDATE $db_filial SET firmselector='$f[selector]', firmname='$f[firmname]', category='$f[category]', flag='$f[flag]', namef='$namef', businessf='$businessf', countryf='$countryf', statef='$statef', cityf='$cityf', zipf='$zipf',
		         	 			addressf='$addressf', phonef='$phonef', faxf='$faxf', mobilef='$mobilef', managerf='$managerf', koordinatif='$koordinatif', www='$wwwf'
						        WHERE num='$post_seek' and firmselector='$f[selector]'" )
							or die ( "ERROR012: mySQL error, can't update INFO. (cominfo.php)" );
		}

		// Изменение информации

		if (($_POST["but"] == "$def_offers_edit_but") and (isset($_POST[seek])))

		{
                $post_seek=intval($_POST['seek']);
		$res_change = $db->query  ( "SELECT * FROM $db_filial WHERE num='$post_seek' and firmselector='$f[selector]'");
		$fe_change = $db->fetcharray  ( $res_change );
		
		$form_namef = $fe_change['namef'];
		$form_businessf = $fe_change['businessf'];
		$form_businessf = str_replace("<br>", "\n", $form_businessf);
		$form_countryf = $fe_change['countryf'];
		$form_statef = $fe_change['statef'];
		$form_cityf = $fe_change['cityf'];
		$form_zipf = $fe_change['zipf'];
		$form_addressf = $fe_change['addressf'];
		$form_phonef=$fe_change['phonef'];
		$form_faxf=$fe_change['faxf'];
		$form_mobilef=$fe_change['mobilef'];
		$form_managerf=$fe_change['managerf'];
		$form_koordinatif=$fe_change['koordinatif'];
		$form_koordinatif = str_replace("<br>", "\n", $form_koordinatif);
		$form_wwwf = $fe_change['www'];
		
		} else unset ($_POST["notdop"]);

	}

	// Обработка изображения

	if ( isset($_POST["upload"]) )

	{
			if ( $_FILES['img1']['tmp_name'] )

			{
				if ( filesize ( $_FILES['img1']['tmp_name'] )>$def_filial_pic_size ) $upload = "Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.";

				else

				{
					if (isset($_POST["seek"])) $img_uploaded=$_POST["seek"];
					
					chmod ( $_FILES['img1']['tmp_name'], 0755 ) or $uploaded = "Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.";
					$size = Getimagesize ( $_FILES['img1']['tmp_name'] );
					$filesize = filesize ( $_FILES['img1']['tmp_name'] );

				if ( ( $size[2] <> 4 ) and ( ( $size[2] == 1 ) or ( $size[2] == 2 ) or ( $size[2] == 3 ) or ( $size[2] == 6 ) ) ) {

					if ( $size[2]==1 ) $type = "gif";
					if ( $size[2]==2 ) $type = "jpg";
					if ( $size[2]==3 ) $type = "png";
					if ( $size[2]==6 ) $type = "bmp";				
					
					@unlink ( "../filial/$img_uploaded.gif" );
					@unlink ( "../filial/$img_uploaded.jpg" );
					@unlink ( "../filial/$img_uploaded.png" );
					@unlink ( "../filial/$img_uploaded.bmp" );

					@unlink ( "../filial/$img_uploaded-small.gif" );
					@unlink ( "../filial/$img_uploaded-small.jpg" );
					@unlink ( "../filial/$img_uploaded-small.png" );
					@unlink ( "../filial/$img_uploaded-small.bmp" );

					copy ( $_FILES['img1']['tmp_name'], "../filial/$img_uploaded.$type" )
					or $uploaded = "Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.<br>";

					chmod ( "../filial/$img_uploaded.$type", 0777 )
					or die ( "ERROR008: Can't change file permission. (edoffer.php) ");
					
						switch ($type) 
								{
									case 'jpg':
									$out = 'imagejpeg';
									$q = 100;
									break;
					
									case 'png':
									$out = 'imagepng';
									$q = 0;
									break;
					
									case 'gif':
									$out = 'imagegif';
									break;

									case 'bmp':
									$out = 'imagebmp';
									break;
								}

					$img = imagecreatefromstring( file_get_contents('../filial/'.$img_uploaded.'.'.$type) );
					$w = imagesx($img);
					$h = imagesy($img);

					if ($w > $def_filial_thumb_width)

					{

					$k = $def_filial_thumb_width / $w;
					$img2 = imagecreatetruecolor($w * $k, $h * $k);
					imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
					$out($img2, '../filial/'.$img_uploaded.'-small.'.$type, $q);

					}

					else 

					{
					
					copy ( $_FILES['img1']['tmp_name'], "../filial/$img_uploaded-small.$type" )
					or $uploaded = "Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.";

					chmod ( "../filial/$img_uploaded-small.$type", 0777 )
					or die ( "ERROR008: Can't change file permission. (edoffer.php) ");

					}
					
				
					if ($w > $def_filial_pic_width)
					{
						$k = $def_filial_pic_width / $w;
						$img2 = imagecreatetruecolor($w * $k, $h * $k);
						imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
						$out($img2, '../filial/'.$img_uploaded.'.'.$type, $q);
						$w *= $k;
						$h *= $k;
						$img = $img2;
					}

					if ($def_filial_wattermark == 'YES')
					{
						$img2 = imagecreatefrompng('../foto/_watermark.png');
						$w_ = imagesx($img2);
						$h_ = imagesy($img2);
						imagecopyresampled($img, $img2, $w - $w_, $h - $h_, 0, 0, $w_, $h_, $w_, $h_);
						$out($img, '../filial/'.$img_uploaded.'.'.$type, $q);
					}

					$db->query  ( "UPDATE $db_filial SET img_on='1', img_type='$type' WHERE num='$img_uploaded'" )
					or die ( "ERROR012: mySQL error, can't update INFO. (cominfo.php)" );					

					$upload = $def_images_pic_ok;

					unset ($_POST["notdop"]);
					unset ($_POST["seek"]);
				}

				else $uploaded = "Ошибка загрузки изображения! Ошибочное расширение файла.";
				
				}

			}
		}

                if ( isset ( $over ) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$over.'</div>';

                if ( isset ( $empty ) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$empty.'</div>';

                if ( isset ( $upload ) ) echo '<div class="alert alert-success">'.$upload.'</div>';

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Филиалы</li>
            <li class="TabbedPanelsTab" tabindex="0">Допустимые параметры</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Список филиалов</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont">
		   <div align="center">
<?php


echo '
<form action="?REQ=authorize&mod=filial" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="5">
';

$firmsel = intval($f['selector']);

$res_filial = $db->query  ( "SELECT * FROM $db_filial WHERE firmselector='$f[selector]' ORDER BY cityf" );
@$results_amount = mysql_num_rows ( $res_filial );

	if ($results_amount > 0) {

	for ( $i=0; $i<$results_amount; $i++ ) {

 	$f_filial = $db->fetcharray  ( $res_filial );

?>
  <tr class="thumbnail">
    <td align="center">
   	<input type="radio" name="seek" value="<? echo $f_filial['num']; ?>" style="border:0px;" <? if ( $f_filial['num'] == $_POST['seek'] ) echo "CHECKED"; ?>>
    </td>

<?php
if ($f_filial[img_on]==1) {

echo "<td width=\"$def_filial_thumb_width\"><a href=\"$def_mainlocation/filial/$f_filial[num].$f_filial[img_type]\" target=\"_blank\"><img src=\"$def_mainlocation/filial/$f_filial[num]-small.$f_filial[img_type]\" border=\"0\"></a></td>"; 

$cols="";

} else $cols = "colspan=\"2\"";

echo "<td $cols align=\"left\" bgColor=\"$color\"><b><font color=\"#990000\">$f_filial[namef]</font></b>";
if ($f_filial[businessf]!="") echo "<div class=\"txt\" style=\"padding:5px;\">$f_filial[businessf]</div>";
if ($f_filial[countryf]!="") echo "<br><font color=\"#0066FF\">Страна:</font> $f_filial[countryf]";
if ($f_filial[statef]!="") echo "<br><font color=\"#0066FF\">Область:</font> $f_filial[statef]";
echo "<br><font color=\"#0066FF\">Город:</font> $f_filial[cityf]";
if ($f_filial[zipf]!="") echo "<br><font color=\"#0066FF\">Индекс:</font> $f_filial[zipf]";
echo "<br><font color=\"#0066FF\">Адрес:</font> $f_filial[addressf]";
if ($f_filial[phonef]!="") echo "<br><font color=\"#0066FF\">Телефон:</font> $f_filial[phonef]";
if ($f_filial[faxf]!="") echo "<br><font color=\"#0066FF\">Факс:</font> $f_filial[faxf]";
if ($f_filial[mobilef]!="") echo "<br><font color=\"#0066FF\">Мобильный:</font> $f_filial[mobilef]";
if ($f_filial[www]!="") echo "<br><font color=\"#0066FF\">Web сайт:</font> $f_filial[www]";
if ($f_filial[managerf]!="") echo "<br><font color=\"#0066FF\">Представитель:</font> $f_filial[managerf]";
if ($f_filial[koordinatif]!="") echo "<br><font color=\"#0066FF\">Дополнительные координаты:</font> $f_filial[koordinatif]";
echo "</td></tr>";

	}}

echo "</table><br>
&nbsp;<input type=\"submit\" name=\"but\" value=\"$def_offers_delete\" class=\"btn btn-danger\">
&nbsp;<input type=\"submit\" name=\"but\" value=\"$def_offers_edit_but\" class=\"btn btn-warning\">
<input type=\"hidden\" name=\"changed\" value=\"true\">
<input type=\"hidden\" name=\"notdop\" value=\"true\">
</form>
";

?>
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
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Добавить / Изменить</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont" align="center">
<?php

if ( ifEnabled_user ($f[flag] , "filial") )

{

echo "
<form action=\"?REQ=authorize&mod=filial\" method=\"post\" enctype=\"multipart/form-data\">
<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\">
  <tr>
    <td align=\"right\"><div class=\"alert alert-info\" style=\"width:120px;\">Филиалов: <b>$all_filial</b></div></td>
  </tr>
  <tr>
    <td align=\"left\">Название филиала: <font color=red>*</font> <input type=\"text\" name=\"namef\" value=\"$form_namef\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Описание филиала (максимум  $def_filial_descr_size символов): <font color=red>*</font> <br><textarea name=\"businessf\" cols=\"45\" rows=\"5\" style=\"width:450px; height:100px;\">$form_businessf</textarea></td>
  </tr>
  <tr>
    <td align=\"left\">Страна: <input type=\"text\" name=\"countryf\" value=\"$form_countryf\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Область: <input type=\"text\" name=\"statef\" value=\"$form_statef\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Город: <font color=red>*</font> <input type=\"text\" name=\"cityf\" value=\"$form_cityf\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Индекс: <input type=\"text\" name=\"zipf\" value=\"$form_zipf\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Адрес: <font color=red>*</font> <input type=\"text\" name=\"addressf\" value=\"$form_addressf\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Телефон: <input type=\"text\" name=\"phonef\" value=\"$form_phonef\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Факс: <input type=\"text\" name=\"faxf\" value=\"$form_faxf\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Мобильный: <input type=\"text\" name=\"mobilef\" value=\"$form_mobilef\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Web сайт: <input type=\"text\" name=\"wwwf\" value=\"$form_wwwf\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Представитель: <input type=\"text\" name=\"managerf\" value=\"$form_managerf\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Дополнительные координаты (максимум  $def_filial_koord_size символов): <br><textarea name=\"koordinatif\" cols=\"45\" rows=\"5\" style=\"width:450px; height:100px;\">$form_koordinatif</textarea></td>
  </tr>
  <tr>
    <td align=\"left\">";

	if (isset($_POST["notdop"]) and ($form_img_on==1) ) echo "Обновить изображение: <input type=\"file\" name=\"img1\" size=\"35\"></td>";
	else echo "Изображение: <input type=\"file\" name=\"img1\" size=\"35\"></td>";

echo "
  </tr>
  <tr>
    <td align=\"center\">
<input type=\"hidden\" name=\"changed\" value=\"true\">
<input type=\"hidden\" name=\"upload\" value=\"true\">
";
	if (isset($_POST["notdop"])) echo "<input type=\"submit\" name=\"but\" value=\"$def_offers_change\" class=\"btn btn-warning\">"; else echo "<input id=\"button_send\" type=\"submit\" name=\"but\" value=\"$def_offers_add\" class=\"btn btn-warning\">";
	if (isset($_POST['seek'])) echo "<input type=\"hidden\" name=\"seek\" value=\"$_POST[seek]\">";
echo "
</td>
  </tr>
</table>
</form>
";

}

else

{

?>

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
                  <td width="180" align="right">Размер файла изображения:</td>
                  <td><? $size_img=$def_filial_pic_size/1000000; echo "$size_img Мб"; ?></td>
                </tr>
                <tr>
                  <td width="180" align="right">Типы файлов:</td>
                  <td><strong>jpg, gif, png, bmp</strong></td>
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
            <? echo "$help_filial"; ?>
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
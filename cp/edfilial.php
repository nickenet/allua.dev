<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: edfilial.php
-----------------------------------------------------
 Назначение: Редактирование филиалов
=====================================================
*/

@ $randomized = rand ( 0, 9999 );

session_start();

require_once './defaults.php';

$idident=intval($_REQUEST['id']);
if (isset($_POST['idident'])) $idident=intval($_REQUEST['idident']);

$help_section = (string)$edfilial_help;

$title_cp = $def_info_filial.' - ';
$speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | <a href="edfilial.php?id='.$idident.'">'.$def_info_filial.'</a>';

check_login_cp('1_0','edfilial.php?id='.$idident);

require_once 'template/header.php';

$r=$db->query ("select * from $db_users where selector='$idident'") or die ("mySQL error!");

$f=$db->fetcharray ($r);

	// *********************************************************

        $flag = $f[flag];

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
		
		if ( $_POST["wwwf"] <> "" )

				{
					if ( preg_match("#http://#", $_POST["wwwf"]) )

					{ $wwwf = $_POST[wwwf]; }

					else

					{
						$wwwf = "http://$_POST[wwwf]";
					}
				}

				$wwwf = safeHTML ( $wwwf );

		if (strlen($businessf) > $def_filial_descr_size)
			{
				$businessf = substr($businessf, 0, $def_filial_descr_size);
				$businessf = substr($businessf, 0, strrpos($businessf, ' '));
				$businessf = trim($businessf) . ' ...';
			}

		if (strlen($koordinatif) > $def_filial_koord_size)
			{
				$koordinatif = substr($koordinatif, 0, $def_filial_koord_size);
				$koordinatif = substr($koordinatif, 0, strrpos($koordinatif, ' '));
				$koordinatif = trim($koordinatif);
			}

	// Проверяем заполнение полей

	if ( ( empty ( $namef ) or empty ( $businessf ) or empty ( $cityf ) or empty ( $addressf ) ) and ( $_POST["but"] != "$def_offers_delete" ) and ( $_POST["but"] != "$def_offers_edit_but" ) and ( $_POST["do"] != "Upload" ) )

	{
			$empty = "$def_offers_empty.";
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

                                logsto("Добавлен филиал для компании <b>$f[firmname]</b> (id=$f[selector])");
		}

		// Удаление филиала

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_delete" ) and (isset($_POST[seek])) )

		{
			@unlink ( "../filial/$_POST[seek].gif" );
			@unlink ( "../filial/$_POST[seek].bmp" );
			@unlink ( "../filial/$_POST[seek].jpg" );
			@unlink ( "../filial/$_POST[seek].png" );

			@unlink ( "../filial/$_POST[seek]-small.gif" );
			@unlink ( "../filial/$_POST[seek]-small.bmp" );
			@unlink ( "../filial/$_POST[seek]-small.jpg" );
			@unlink ( "../filial/$_POST[seek]-small.png" );

			$db->query  ( "DELETE FROM $db_filial WHERE num='$_POST[seek]' and firmselector='$f[selector]'" )
			or die ( "ERROR011: mySQL error, can't delete from INFO. (filial.php)" );

                        logsto("Удален филиал ($_POST[seek]) компании <b>$f[firmname]</b> (id=$f[selector])");

			$all_filial=$all_filial-1;	
				
			$db->query  ( "UPDATE $db_users SET filial='$all_filial' WHERE selector='$f[selector]'" )
			or die ( "ERROR012: mySQL error, can't update USERS. (filial.php)" );

			unset ($_POST["notdop"]);
			unset ($_POST["seek"]);
		}

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_change" ) )

		{
			$db->query  ( "UPDATE $db_filial SET firmselector='$f[selector]', firmname='$f[firmname]', category='$f[category]', flag='$f[flag]', namef='$namef', businessf='$businessf', countryf='$countryf', statef='$statef', cityf='$cityf', zipf='$zipf',
		         	 			addressf='$addressf', phonef='$phonef', faxf='$faxf', mobilef='$mobilef', managerf='$managerf', koordinatif='$koordinatif', www='$wwwf'
						        WHERE num='$_POST[seek]' and firmselector='$f[selector]'" )
							or die ( "ERROR012: mySQL error, can't update INFO. (cominfo.php)" );

                        logsto("Изменена информация по филиалу ($_POST[seek]) компании <b>$f[firmname]</b> (id=$f[selector])");
		}

		// Изменение информации

		if (($_POST["but"] == "$def_offers_edit_but") and (isset($_POST[seek])))

		{

		$res_change = $db->query  ( "SELECT * FROM $db_filial WHERE num='$_POST[seek]' and firmselector='$f[selector]'");
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
				if ( filesize ( $_FILES['img1']['tmp_name'] )>$def_filial_pic_size ) $upload = (string)$def_admin_error_file;

				else

				{
					if (isset($_POST["seek"])) $img_uploaded=$_POST["seek"];
					
					chmod ( $_FILES['img1']['tmp_name'], 0755 ) or $uploaded = (string)$def_admin_error_file;
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
					or $uploaded = (string)$def_admin_error_file;

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
					or $uploaded = (string)$def_admin_error_file;

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

					$upload = (string)$def_images_pic_ok;

					unset ($_POST["notdop"]);
					unset ($_POST["seek"]);
				}

				else $uploaded = "Ошибка загрузки изображения! Ошибочное расширение файла.";
				
				}
			}
		}

	// *********************************************************

table_item_top ($def_info_filial,'globe.png');

echo '&nbsp;Филиалов: <b>'.$all_filial.'</b><br /><br />';
 
if (!empty ($empty)) msg_text("80%",$def_admin_message_mess,$empty);

if (isset ($over)) msg_text("80%",$def_admin_message_mess,$over);

if (isset($upload))  msg_text("80%",$def_admin_message_mess,$upload);

echo '
<form action="edfilial.php" method="post">
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="5%" align="middle" valign="middle" id="table_files">'.$def_images_choice.'</td>
    <td colspan=2 align="left" id="table_files_r">Филиалы</td>
  </tr>
';

$res_filial = $db->query  ( "SELECT * FROM $db_filial WHERE firmselector='$f[selector]' ORDER BY cityf" );
@$results_amount = mysql_num_rows ( $res_filial );

	if ($results_amount > 0) {

	for ( $i=0; $i<$results_amount; $i++ ) {

 	$f_filial = $db->fetcharray  ( $res_filial );

echo '
  <tr>
    <td align="center" id="table_files_i">';
?>
   	<input type="radio" name="seek" value="<?php echo $f_filial[num]; ?>" style="border:0px;" <?php if ( $f_filial[num] == $_POST['seek'] ) echo "CHECKED"; ?>>
<?php
echo '</td>';

if ($f_filial[img_on]==1) {

echo '<td width="'.$def_filial_thumb_width.'" id="table_files_i_c"><a href="'.$def_mainlocation.'/filial/'.$f_filial[num].'.'.$f_filial[img_type].'" target="_blank"><img src="'.$def_mainlocation.'/filial/'.$f_filial[num].'-small.'.$f_filial[img_type].'" border="0"></a></td>';

$cols="";

} else $cols = 'colspan="2"';

echo '<td '.$cols.' align="left" id="table_files_i_r"><br /><b><font color="#990000">'.$f_filial[namef].'</font></b>';
if ($f_filial[businessf]!="") echo '<br /><font size="1" color="#333333">'.$f_filial[businessf].'</font>';
if ($f_filial[countryf]!="") echo '<br /><font color="#0066FF">Страна:</font> '.$f_filial[countryf];
if ($f_filial[statef]!="") echo '<br /><font color="#0066FF">Область:</font> '.$f_filial[statef];
echo '<br /><font color="#0066FF">Город:</font> '.$f_filial[cityf];
if ($f_filial[zipf]!="") echo '<br /><font color="#0066FF">Индекс:</font> '.$f_filial[zipf];
echo '<br /><font color="#0066FF">Адрес:</font> '.$f_filial[addressf];
if ($f_filial[phonef]!="") echo '<br /><font color="#0066FF">Телефон:</font> '.$f_filial[phonef];
if ($f_filial[faxf]!="") echo '<br /><font color="#0066FF">Факс:</font> '.$f_filial[faxf];
if ($f_filial[mobilef]!="") echo '<br /><font color="#0066FF">Мобильный:</font> '.$f_filial[mobilef];
if ($f_filial[www]!="") echo '<br /><font color="#0066FF">Web сайт:</font> '.$f_filial[www];
if ($f_filial[managerf]!="") echo '<br /><font color="#0066FF">Представитель:</font> '.$f_filial[managerf];
if ($f_filial[koordinatif]!="") echo '<br /><font color="#0066FF">Дополнительные координаты:</font> '.$f_filial[koordinatif].'<br /><br />';
echo '</td></tr>';

	}}

echo '</table><br /><div align="center">
&nbsp;<input type="submit" name="but" value="'.$def_offers_delete.'" style="color: #FFFFFF; background: #D55454;" />
&nbsp;<input type="submit" name="but" value="'.$def_offers_edit_but.'" />
<input type="hidden" name="changed" value="true" />
<input type="hidden" name="notdop" value="true" />
<input type="hidden" name="id" value="'.$f[selector].'" /></div>
<br /><br />
</form>
';

table_fdata_top ($def_admin_sys_filial);

echo '
<form action="edfilial.php" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td align="left">Название филиала: <span style="color:#FF0000;">*</span> <input type="text" name="namef" value="'.$form_namef.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Описание филиала (максимум  '.$def_filial_descr_size.' символов): <span style="color:#FF0000;">*</span> <br /><textarea name="businessf" cols="45" rows="5" style="width:450px; height:100px;">'.$form_businessf.'</textarea></td>
  </tr>
  <tr>
    <td align="left">Страна: <input type="text" name="countryf" value="'.$form_countryf.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Область: <input type="text" name="statef" value="'.$form_statef.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Город: <span style="color:#FF0000;">*</span> <input type="text" name="cityf" value="'.$form_cityf.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Индекс: <input type="text" name="zipf" value="'.$form_zipf.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Адрес: <span style="color:#FF0000;">*</span> <input type="text" name="addressf" value="'.$form_addressf.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Телефон: <input type="text" name="phonef" value="'.$form_phonef.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Факс: <input type="text" name="faxf" value="'.$form_faxf.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Мобильный: <input type="text" name="mobilef" value="'.$form_mobilef.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Web сайт: <input type="text" name="wwwf" value="'.$form_wwwf.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Представитель: <input type="text" name="managerf" value="'.$form_managerf.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Дополнительные координаты (максимум  '.$def_filial_koord_size.' символов): <br /><textarea name="koordinatif" cols="45" rows="5" style="width:450px; height:100px;">'.$form_koordinatif.'</textarea></td>
  </tr>
  <tr>
    <td align="left">';

	if (isset($_POST["notdop"]) and ($form_img_on==1) ) echo 'Обновить изображение: <input type="file" name="img1" size="35" /></td>';
	else echo 'Изображение: <input type="file" name="img1" size="35" /></td>';

echo '
  </tr>
  <tr>
    <td align="center">
<input type="hidden" name="changed" value="true" />
<input type="hidden" name="upload" value="true" />
<input type="hidden" name="id" value="'.$f[selector].'">
';
	if (isset($_POST["notdop"])) echo '<input type="submit" name="but" value="'.$def_offers_change.'" />'; else echo '<input id="button_send" type="submit" name="but" value="'.$def_offers_add.'" />';
	if (isset($_POST[seek])) echo '<input type="hidden" name="seek" value="'.$_POST[seek].'" />';
echo '
</td>
  </tr>
</table>
</form>
';

table_fdata_bottom();

require_once 'template/footer.php';

?>
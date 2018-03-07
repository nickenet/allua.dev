<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: edinfo.php
-----------------------------------------------------
 Назначение: Редактирование публикаций
=====================================================
*/

session_start();

require_once './defaults.php';

$idident=intval($_REQUEST['id']);
if (isset($_POST['idident'])) $idident=intval($_REQUEST['idident']);

$help_section = (string)$edinfo_help;

$title_cp = $def_info_info.' - ';
$speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | <a href="edinfo.php?id='.$idident.'">'.$def_info_info.'</a>';

check_login_cp('1_0','edinfo.php?id='.$idident);

require_once 'template/header.php';

?>

<script src="../includes/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr']}).panelInstance('area_full');
});
</script>

<?

$r=$db->query ("select * from $db_users where selector='$idident'") or die ("mySQL error!");

$f=$db->fetcharray ($r);

	// *********************************************************

if (!isset($_SESSION["vType"])) $_SESSION["vType"]=0;
if (isset($_POST[edit_fil])) $_SESSION["vType"]=intval($_POST[edit_fil]); 

$flag = $f[flag];
$dop_info=ifType_info($f[flag], "setinfo");
$ost_info=$dop_info-$f[info];
if ($f[info]=="") $all_info=0; else $all_info=$f[info];

	if ( $_POST["changed"] == "true" )  {

		$type = (int)$_POST["var"];
		$period = $_POST["period"];
		$item = safeHTML ($_POST["item"]);
		$shortstory = safeHTML ($_POST["shortstory"]);

		if (strlen($shortstory) > $def_info_descr_size) $shortstory = isb_sub ($shortstory, $def_info_descr_size);

		$fullstory = safe_business($f['flag'], $_POST['fullstory']);

                // обрабатываем URL video
                if (( stripos(strtolower($_POST['video']),'iframe')===false) and ( stripos($_POST['video'],'object')===false)) {
                    $video = safeHTML($_POST['video']);
                }
                else {
                    $video = str_replace("<", "&lt;", $_POST['video']);
                    $video = str_replace(">", "&gt;", $video);
                    $video = addslashes($video);
                }

                if ( stripos($_POST['video'],'object')===true) {
                    $video=strtolower($_POST['video']);
                    $video = strip_tags($video, '<object><embed><param>');
                    $tag = '<object';
                    $video = substr($video, strpos($video, $tag));
                    $tag = '</object>';
                    $video = substr($video, 0, strpos($video, $tag) + strlen($tag));
                    $video=str_replace('http','video_yandex',$video);
                    $video = safeInfo($video);
                    $video= addslashes($video);
                } 
                
		if ((isset ($_POST["form_n1"])) and ($_POST["form_n1"]!="")) $form_n1= safeHTML ($_POST["form_n1"]); else $form_n1="";
		if ((isset ($_POST["form_n2"])) and ($_POST["form_n2"]!="")) $form_n2= safeHTML ($_POST["form_n2"]); else $form_n2="";
		if ((isset ($_POST["form_n3"])) and ($_POST["form_n3"]!="")) $form_n3= safeHTML ($_POST["form_n3"]); else $form_n3="";
		if ((isset ($_POST["form_n4"])) and ($_POST["form_n4"]!="")) $form_n4= safeHTML ($_POST["form_n4"]); else $form_n4="";
		if ((isset ($_POST["form_n5"])) and ($_POST["form_n5"]!="")) $form_n5= safeHTML ($_POST["form_n5"]); else $form_n5="";
		if ((isset ($_POST["form_n6"])) and ($_POST["form_n6"]!="")) $form_n6= safeHTML ($_POST["form_n6"]); else $form_n6="";
		if ((isset ($_POST["form_n7"])) and ($_POST["form_n7"]!="")) $form_n7= safeHTML ($_POST["form_n7"]); else $form_n7="";
		if ((isset ($_POST["form_n8"])) and ($_POST["form_n8"]!="")) $form_n8= safeHTML ($_POST["form_n8"]); else $form_n8="";
		if ((isset ($_POST["form_n9"])) and ($_POST["form_n9"]!="")) $form_n9= safeHTML ($_POST["form_n9"]); else $form_n9="";
		if ((isset ($_POST["form_n10"])) and ($_POST["form_n10"]!="")) $form_n10= safeHTML ($_POST["form_n10"]); else $form_n10="";	

	// Проверяем заполнение полей

	if ( ( empty ( $item ) or empty ( $shortstory ) ) and ( $_POST["but"] != "$def_offers_delete" ) and ( $_POST["but"] != "$def_offers_edit_but" ) and ( $_POST["do"] != "Upload" ) )

	{
			$empty = (string)$def_offers_empty;
	}

		// Заносим данные в базу

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_add" ) )

		{
			if ( $ost_info > 0 )

			{
				$date = date ( "Y-m-d" );
				$datetime = date ("H:i:s");

				$db->query  ( "INSERT INTO $db_info (firmselector, firmname, category, date, datetime, type, period, item, shortstory, fullstory, video, f_name1, f_name2, f_name3, f_name4, f_name5, f_name6, f_name7, f_name8, f_name9, f_name10) 
							     VALUES ('$f[selector]', '$f[firmname]', '$f[category]', '$date', '$datetime', '$type', '$period', '$item', '$shortstory', '$fullstory', '$video', '$form_n1', '$form_n2', '$form_n3', '$form_n4', '$form_n5', '$form_n6', '$form_n7', '$form_n8', '$form_n9', '$form_n10')" )
				or die ( "ERROR010: mySQL error, cant insert into INFO. (cominfo.php)" );

				$img_uploaded=mysql_insert_id();

				$all_info++;
				$ost_info=$dop_info-$all_info;

				if ($type==1) { $up_type=$f[news]+1; $sql_up=" , news='$up_type' "; }
				if ($type==2) { $up_type=$f[tender]+1; $sql_up=" , tender='$up_type'"; }
				if ($type==3) { $up_type=$f[board]+1; $sql_up=" , board='$up_type'"; }
				if ($type==4) { $up_type=$f[job]+1; $sql_up=" , job='$up_type'"; }
				if ($type==5) { $up_type=$f[pressrel]+1; $sql_up=" , pressrel='$up_type'"; }	
				
				$db->query  ( "UPDATE $db_users SET info='$all_info' $sql_up WHERE selector='$f[selector]'" )
				or die ( "ERROR012: mySQL error, can't update USERS. (cominfo.php)" );

                                logsto("Добавлена публикация для компании <b>$f[firmname]</b> (id=$f[selector])");
			}

			else

			{
				$over = 'Добавить публикацию нельзя! Ваш лимит закончен!<br /> К загрузке допускается - '.$dop_info.' публикаций!';
			}
		}

		// Удаление публикации

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_delete" ) and (isset($_POST[seek])) )

		{
			@unlink ( "../info/$_POST[seek].gif" );
			@unlink ( "../info/$_POST[seek].bmp" );
			@unlink ( "../info/$_POST[seek].jpg" );
			@unlink ( "../info/$_POST[seek].png" );

			@unlink ( "../info/$_POST[seek]-small.gif" );
			@unlink ( "../info/$_POST[seek]-small.bmp" );
			@unlink ( "../info/$_POST[seek]-small.jpg" );
			@unlink ( "../info/$_POST[seek]-small.png" );

			$res_del = $db->query  ( "SELECT type FROM $db_info WHERE num='$_POST[seek]' and firmselector='$f[selector]'" )
			or die ( "ERROR011: mySQL error, can't select from INFO. (cominfo.php)" );

			$type_del = $db->fetcharray($res_del);

			$db->query  ( "DELETE FROM $db_info WHERE num='$_POST[seek]' and firmselector='$f[selector]'" )
			or die ( "ERROR011: mySQL error, can't delete from INFO. (cominfo.php)" );

                        logsto("Удалена публикация($_POST[seek]) компании <b>$f[firmname]</b> (id=$f[selector])");

			$all_info=$all_info-1;
			$ost_info=$dop_info-$all_info;

			if ($type_del[type]==1) { $up_type=$f[news]-1; $sql_up=" , news='$up_type' "; }
			if ($type_del[type]==2) { $up_type=$f[tender]-1; $sql_up=" , tender='$up_type'"; }
			if ($type_del[type]==3) { $up_type=$f[board]-1; $sql_up=" , board='$up_type'"; }
			if ($type_del[type]==4) { $up_type=$f[job]-1; $sql_up=" , job='$up_type'"; }
			if ($type_del[type]==5) { $up_type=$f[pressrel]-1; $sql_up=" , pressrel='$up_type'"; }	
				
			$db->query  ( "UPDATE $db_users SET info='$all_info' $sql_up WHERE selector='$f[selector]'" )
			or die ( "ERROR012: mySQL error, can't update USERS. (cominfo.php)" );

			unset ($_POST["notdop"]);
			unset ($_POST["seek"]);
		}

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_change" ) )

		{
			$date = date ( "Y-m-d" );
			$datetime = date ("H:i:s");

			$db->query  ( "UPDATE $db_info SET firmselector='$f[selector]', firmname='$f[firmname]', category='$f[category]', date='$date', datetime='$datetime', period='$period', item='$item', shortstory='$shortstory',
		         	 			fullstory='$fullstory', video='$video', f_name1='$form_n1', f_name2='$form_n2', f_name3='$form_n3', f_name4='$form_n4', f_name5='$form_n5', f_name6='$form_n6', f_name7='$form_n7', f_name8='$form_n8', f_name9='$form_n9', f_name10='$form_n10'
						        WHERE num='$_POST[seek]' and firmselector='$f[selector]'" )
							or die ( "ERROR012: mySQL error, can't update INFO. (cominfo.php)" );

                        logsto("Изменена публикация($_POST[seek]) компании <b>$f[firmname]</b> (id=$f[selector])");
		}

		// Изменение публикации

		if (($_POST["but"] == "$def_offers_edit_but") and (isset($_POST[seek])))

		{

		$res_change = $db->query  ( "SELECT * FROM $db_info WHERE num='$_POST[seek]' and firmselector='$f[selector]'");
		$fe_change = $db->fetcharray  ( $res_change );
		
		$form_type = $fe_change[type];
		$form_period = $fe_change[period];
		$form_item = $fe_change[item];	
		$form_shortstory = $fe_change[shortstory];
		$form_fullstory = $fe_change[fullstory];
		$form_shortstory = str_replace("<br>", "\n", $form_shortstory);
		$form_video = $fe_change[video];
		$form_img_on = $fe_change[img_on];
		$form_name1=$fe_change[f_name1];
		$form_name2=$fe_change[f_name2];
		$form_name3=$fe_change[f_name3];
		$form_name4=$fe_change[f_name4];
		$form_name5=$fe_change[f_name5];
		$form_name6=$fe_change[f_name6];
		$form_name7=$fe_change[f_name7];
		$form_name8=$fe_change[f_name8];
		$form_name9=$fe_change[f_name9];
		$form_name10=$fe_change[f_name10];
		
		} else unset ($_POST["notdop"]);

	}

	// Обработка изображения

	if ( isset($_POST["upload"]) )

	{
			if ( $_FILES['img1']['tmp_name'] )

			{
				if ( filesize ( $_FILES['img1']['tmp_name'] )>$def_info_pic_size ) $upload = (string)$def_admin_error_file;

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
					
					@unlink ( "../info/$img_uploaded.gif" );
					@unlink ( "../info/$img_uploaded.jpg" );
					@unlink ( "../info/$img_uploaded.png" );
					@unlink ( "../info/$img_uploaded.bmp" );

					@unlink ( "../info/$img_uploaded-small.gif" );
					@unlink ( "../info/$img_uploaded-small.jpg" );
					@unlink ( "../info/$img_uploaded-small.png" );
					@unlink ( "../info/$img_uploaded-small.bmp" );

					copy ( $_FILES['img1']['tmp_name'], "../info/$img_uploaded.$type" )
					or $uploaded = (string)$def_admin_error_file;

					chmod ( "../info/$img_uploaded.$type", 0777 )
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

					$img = imagecreatefromstring( file_get_contents('../info/'.$img_uploaded.'.'.$type) );
					$w = imagesx($img);
					$h = imagesy($img);

					if ($w > $def_info_thumb_width)

					{

					$k = $def_info_thumb_width / $w;
					$img2 = imagecreatetruecolor($w * $k, $h * $k);
					imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
					$out($img2, '../info/'.$img_uploaded.'-small.'.$type, $q);

					}

					else 

					{
					
					copy ( $_FILES['img1']['tmp_name'], "../info/$img_uploaded-small.$type" )
					or $uploaded = (string)$def_admin_error_file;

					chmod ( "../info/$img_uploaded-small.$type", 0777 )
					or die ( "ERROR008: Can't change file permission. (edoffer.php) ");

					}
				
					if ($w > $def_info_pic_width)
					{
						$k = $def_info_pic_width / $w;
						$img2 = imagecreatetruecolor($w * $k, $h * $k);
						imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
						$out($img2, '../info/'.$img_uploaded.'.'.$type, $q);
						$w *= $k;
						$h *= $k;
						$img = $img2;
					}

					if ($def_info_wattermark == 'YES')
					{
						$img2 = imagecreatefrompng('../foto/_watermark.png');
						$w_ = imagesx($img2);
						$h_ = imagesy($img2);
						imagecopyresampled($img, $img2, $w - $w_, $h - $h_, 0, 0, $w_, $h_, $w_, $h_);
						$out($img, '../info/'.$img_uploaded.'.'.$type, $q);
					}

					$db->query  ( "UPDATE $db_info SET img_on='1' WHERE num='$img_uploaded'" )
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

 table_item_top ($def_info_info,'snews_pole.png');
 
 echo '&nbsp;Допустимо всего: <b>'.$dop_info.'</b> (Осталось: '.$ost_info.' - использовано: '.$all_info.')<br /><br />';

 $type_on=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);
 $font_type=array(1 => "#990000", 2 => "#0066FF", 3 => "#006600", 4 => "#FF6600", 5 => "#990066");

	$data_razdel='<option value="0" selected>Все разделы</option>';
	for ($zz = 1; $zz < 6; $zz++) {
		if ($_SESSION["vType"]==$zz) $data_razdel.='<option value="'.$zz.'" selected>'.$type_on[$zz].'</option>';
		else $data_razdel.='<option value="'.$zz.'">'.$type_on[$zz].'</option>';
	}

 echo '
 <form action="#" method="POST" style="text-align:left">
 &nbsp;Фильтр: <select name="edit_fil" onchange="this.form.submit();">
 '.$data_razdel.'
 </select>
 <input type="hidden" name="id" value="'.$f[selector].'" />
 </form>
 <br /><br />';

 if (!empty ($empty)) msg_text("80%",$def_admin_message_mess,$empty);

 if (isset ($over)) msg_text("80%",$def_admin_message_mess,$over);

 if (isset($upload))  msg_text("80%",$def_admin_message_mess,$upload);

echo '
<form action="edinfo.php" method="post">
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="5%" align="middle" valign="middle" id="table_files">'.$def_images_choice.'</td>
    <td align="left" id="table_files_r">Публикация</td>
  </tr>
';

if (isset($_SESSION["vType"]) and ($_SESSION["vType"]>0)) $sql_type=" and type='$_SESSION[vType]'";

$res_info = $db->query  ( "SELECT * FROM $db_info WHERE firmselector='$f[selector]' $sql_type ORDER BY date, datetime" );
@$results_amount = mysql_num_rows ( $res_info );

	if ($results_amount > 0) {

	for ( $i=0; $i<$results_amount; $i++ ) {

 	$f_info = $db->fetcharray  ( $res_info );

 		$date_day = date ( "d" );
 		$date_month = date ( "m" );
 		$date_year = date ( "Y" );

 		list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $f_info["date"] );

 		$first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
 		$second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

 		if ( $second_date > $first_date )

 		{
 			$days = $second_date-$first_date;
 		}

 		else
		
 		{
 			$days = $first_date-$second_date;
 		}

		$days_result = round( $f_info[period] - ( ( $days ) / ( 60 * 60 * 24 ) ) );

		$f_type=$f_info[type];

		if ($f_info[video]!="") $f_video='[<a href="'.$def_mainlocation.'/users/inc/viewinfo.php?video='.$f_info[num].'" target="_blank" class="spubl">видеоролик</a>]'; else $f_video ="";
		if ($f_info[img_on]==1) $f_img='[<a href="'.$def_mainlocation.'/users/inc/viewinfo.php?img='.$f_info[num].'" target="_blank" class="spubl">изображение</a>]'; else $f_img ="";
                if ($f_info['period']==0) { $f_info['period']=$def_period_offers; $days_result=''; }

echo '
  <tr>
    <td align="center" id="table_files_i">';
?>
   	<input type="radio" name="seek" value="<?php echo $f_info[num]; ?>" style="border:0px;" <?php if ( $f_info[num] == $_POST['seek'] ) echo "CHECKED"; ?>>
<?php
echo '
    </td>
    <td align="left" id="table_files_i_r"><br /><font color="'.$font_type[$f_type].'">[ '.$type_on[$f_type].' ]</font><font size="1" color="#666666"> Дата: '.undate($f_info[date], $def_datetype).' | Период - '.$f_info[period].' | Осталось - '.$days_result.'</font><br />
    <a href="'.$def_mainlocation.'/viewinfo.php?vi='.$f_info[num].'" target="_blank" class="slink"><b><u>'.$f_info[item].'</u></b></a>&nbsp;'.$f_img.'&nbsp;'.$f_video.'<br />
    <font size="1" color="#333333">'.$f_info[shortstory].'</font><br /><br /></td>
  </tr>
';
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

table_fdata_top ($def_item_form_data);

require ('../includes/editor/tiny_A.php'); // Подключаем редактор

echo '
<form action="edinfo.php" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><span style="color:#FF0000;">*</span>
<select id="var_list" name="var">
	<option value="">Выберите раздел публикации</option>
';

if (isset($_POST["notdop"])) echo '<option value="'.$form_type.'" selected>'.$type_on[$form_type].'</option>'; else

{
	echo '<option value="1"'; if ( $form_type == "1" ) echo "selected"; echo '>'.$def_info_news.'</option>';
	echo '<option value="2"'; if ( $form_type == "2" ) echo "selected"; echo '>'.$def_info_tender.'</option>';
	echo '<option value="3"'; if ( $form_type == "3" ) echo "selected"; echo '>'.$def_info_board.'</option>';
	echo '<option value="4"'; if ( $form_type == "4" ) echo "selected"; echo '>'.$def_info_job.'</option>';
	echo '<option value="5"'; if ( $form_type == "5" ) echo "selected"; echo '>'.$def_info_pressrel.'</option>';
}

echo '
</select>
    </td>
  </tr>
  <tr>
    <td align="left"> Период публикации <select name="period">';

 $periods = explode("#",  $def_info_expiration);

 for ($a=0;$a<count($periods);$a++)

 {
        if ($periods[$a]==0) $vivod_period=$def_period_offers; else $vivod_period=$periods[$a];
 	if ($form_period == $periods[$a]) echo '<option value="'.$periods[$a].'" SELECTED>'.$vivod_period.'</option>';
 	else echo '<option value="'.$periods[$a].'">'.$vivod_period.'</option>';
 }

echo '
</select> дней
  </td>
  </tr>
  <tr>
    <td align="left">Название публикации: <span style="color:#FF0000;">*</span> <input type="text" name="item" value="'.$form_item.'" size="45" maxlength="100" /></td>
  </tr>
  <tr>
    <td align="left">Краткое описание (максимум  '.$def_info_descr_size.' символов): <span style="color:#FF0000;">*</span> <br /><textarea name="shortstory" cols="45" rows="5" style="width:450px; height:100px;">'.$form_shortstory.'</textarea></td>
  </tr>
  <tr>
    <td align="left">Полное описание:<br /><textarea name="fullstory" cols="45" rows="5" id="business" class="business" style="width:450px; height:100px;">'.$form_fullstory.'</textarea></td>
  </tr>
  <tr>
    <td align="left">URL видеоролика: <input type="text" name="video" value="'.$form_video.'" size="45" maxlength="300" /></td>
  </tr>
  <tr>
    <td align="left">';

	if (isset($_POST["notdop"]) and ($form_img_on==1) ) echo 'Обновить изображение: <input type="file" name="img1" size="35" /></td>';
	else echo 'Изображение: <input type="file" name="img1" size="35" /></td>';

echo '
  </tr>
  <tr>
    <td align="left">';

if (isset($_POST["notdop"])) {

	$res_infofieldst = $db->query("SELECT * FROM $db_infofields WHERE num = '$form_type'");
	$b_ff = $db->fetcharray($res_infofieldst);

	if ($b_ff[f_on1]==1) { if ($b_ff[f_type1]==1) echo $b_ff[f_name1].': <input type="text" name="form_n1" value="'.$form_name1.'" size="45" maxlength="100" /><br />'; else echo $b_ff[f_name1].':<br /><textarea name="form_n1" cols="45" rows="5" style="width:400px; height:100px;">'.$form_name1.'</textarea><br />'; }
	if ($b_ff[f_on2]==1) { if ($b_ff[f_type2]==1) echo $b_ff[f_name2].': <input type="text" name="form_n2" value="'.$form_name2.'" size="45" maxlength="100" /><br />'; else echo $b_ff[f_name2].':<br /><textarea name="form_n2" cols="45" rows="5" style="width:400px; height:100px;">'.$form_name2.'</textarea><br />'; }
	if ($b_ff[f_on3]==1) { if ($b_ff[f_type3]==1) echo $b_ff[f_name3].': <input type="text" name="form_n3" value="'.$form_name3.'" size="45" maxlength="100" /><br />'; else echo $b_ff[f_name3].':<br /><textarea name="form_n3" cols="45" rows="5" style="width:400px; height:100px;">'.$form_name3.'</textarea><br />'; }
	if ($b_ff[f_on4]==1) { if ($b_ff[f_type4]==1) echo $b_ff[f_name4].': <input type="text" name="form_n4" value="'.$form_name4.'" size="45" maxlength="100" /><br />'; else echo $b_ff[f_name4].':<br /><textarea name="form_n4" cols="45" rows="5" style="width:400px; height:100px;">'.$form_name4.'</textarea><br />'; }
	if ($b_ff[f_on5]==1) { if ($b_ff[f_type5]==1) echo $b_ff[f_name5].': <input type="text" name="form_n5" value="'.$form_name5.'" size="45" maxlength="100" /><br />'; else echo $b_ff[f_name5].':<br /><textarea name="form_n5" cols="45" rows="5" style="width:400px; height:100px;">'.$form_name5.'</textarea><br />'; }
	if ($b_ff[f_on6]==1) { if ($b_ff[f_type6]==1) echo $b_ff[f_name6].': <input type="text" name="form_n6" value="'.$form_name6.'" size="45" maxlength="100" /><br />'; else echo $b_ff[f_name6].':<br /><textarea name="form_n6" cols="45" rows="5" style="width:400px; height:100px;">'.$form_name6.'</textarea><br />'; }
	if ($b_ff[f_on7]==1) { if ($b_ff[f_type7]==1) echo $b_ff[f_name7].': <input type="text" name="form_n7" value="'.$form_name7.'" size="45" maxlength="100" /><br />'; else echo $b_ff[f_name7].':<br /><textarea name="form_n7" cols="45" rows="5" style="width:400px; height:100px;">'.$form_name7.'</textarea><br />'; }
	if ($b_ff[f_on8]==1) { if ($b_ff[f_type8]==1) echo $b_ff[f_name8].': <input type="text" name="form_n8" value="'.$form_name8.'" size="45" maxlength="100" /><br />'; else echo $b_ff[f_name8].':<br /><textarea name="form_n8" cols="45" rows="5" style="width:400px; height:100px;">'.$form_name8.'</textarea><br />'; }
	if ($b_ff[f_on9]==1) { if ($b_ff[f_type9]==1) echo $b_ff[f_name9].': <input type="text" name="form_n9" value="'.$form_name9.'" size="45" maxlength="100" /><br />'; else echo $b_ff[f_name9].':<br /><textarea name="form_n9" cols="45" rows="5" style="width:400px; height:100px;">'.$form_name9.'</textarea><br />'; }
	if ($b_ff[f_on10]==1) { if ($b_ff[f_type10]==1) echo $b_ff[f_name10].': <input type="text" name="form_n10" value="'.$form_name10.'" size="45" maxlength="100" /><br />'; else echo $b_ff[f_name10].':<br /><textarea name="form_n10" cols="45" rows="5" style="width:400px; height:100px;">'.$form_name10.'</textarea><br />'; }

}

else echo '<div id="info_div"></div>';

echo '
  </td>
  </tr>
  <tr>
    <td align="center"><br />
<input type="hidden" name="upload" value="true" />
<input type="hidden" name="changed" value="true" />
<input type="hidden" name="id" value="'.$f[selector].'" />
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

?>

<script type="text/javascript">
function checkForm()
{
	var req = jQuery('#var_list').val();

	if (req == '')
	{
		alert('Выберите, пожалуйста, вариант!');
		jQuery('#var_list').focus();
		return false;
	}

	return true;
}

function initChoice()
{
	jQuery('#var_list').change(loadChoise);
}

function loadChoise()
{
	var req = jQuery('#var_list').val();

	if (req == '')
	{
		jQuery('#button_send').attr('disabled', true);
		jQuery('#info_div').html('');
		return;
	}

	jQuery('#button_send').attr('disabled', false);
	jQuery.get('inc/ajaxfield.php', {ajax: "on", param: req, r: Math.random()}, updateChoice);
}

function updateChoice(data)
{
	if (!data)
	{
		alert('Error loading data');
		return;
	}

	/* Устанавливаем полученные значения на страницу */
	jQuery('#info_div').html(data);
}

initChoice();
loadChoise();

</script>
<?

require_once 'template/footer.php';

?>
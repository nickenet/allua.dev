<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: cominfo.php
-----------------------------------------------------
 Назначение: Информационный блок компании
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

/*
echo "
<script src=\"../includes/nicEdit.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\">
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr']}).panelInstance('area_full');
});
</script>
";
 */

if (!isset($_SESSION["vType"])) $_SESSION["vType"]=0;
if (isset($_POST[edit_fil])) $_SESSION["vType"]=intval($_POST[edit_fil]);
if (isset($_POST['seek'])) $_POST['seek']=intval($_POST['seek']);
if (isset($_GET['seek'])) $_POST['seek']=intval($_GET['seek']);
if (isset($_GET['notdop'])) $_POST['notdop']='true';

$flag = $f[flag];
$dop_info=ifType_info($f[flag], "setinfo");
$ost_info=$dop_info-$f[info];
if ($f[info]=="") $all_info=0; else $all_info=$f[info];
	
// Блок изменения информации

	if ( $_REQUEST["changed"] == "true" ) {

		$type = (int)$_POST["var"];
		$period = safeHTML($_POST["period"]);
		$item = safeHTML ($_POST["item"]);
		$shortstory = safeHTML ($_POST["shortstory"]);

		if (strlen($shortstory) > $def_info_descr_size) $shortstory = isb_sub ($shortstory, $def_info_descr_size);

		$fullstory = safe_business($flag, $_POST['fullstory']);

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
                
                
                $video_no_tag = ('select, script, delete, iframe, union');
                $video=str_replace($video_no_tag,'',$video);
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

	if ( ( empty ( $item ) or empty ( $shortstory ) ) and ( $_POST["but"] != "$def_offers_delete" ) and ( $_POST["but"] != "$def_offers_edit_but" ) and ( $_POST["do"] != "Upload" ) and ($_GET['set']!='edit') and ($_GET['set']!='delete') )

	{
			$empty = $def_offers_empty;
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

			}

			else

			{

				$over = "Добавить публикацию нельзя! Ваш лимит закончен!<br> К загрузке допускается - $dop_info публикаций!";

			}

		}

		// Удаление публикации

		if ( ( empty ( $empty ) ) and (( $_POST["but"] == "$def_offers_delete" ) or ($_GET['set']=='delete')) and (isset($_POST['seek'])) )

		{

			@unlink ( "../info/$_POST[seek].gif" );
			@unlink ( "../info/$_POST[seek].bmp" );
			@unlink ( "../info/$_POST[seek].jpg" );
			@unlink ( "../info/$_POST[seek].png" );

			@unlink ( "../info/$_POST[seek]-small.gif" );
			@unlink ( "../info/$_POST[seek]-small.bmp" );
			@unlink ( "../info/$_POST[seek]-small.jpg" );
			@unlink ( "../info/$_POST[seek]-small.png" );
                        
                        $post_seek=intval($_POST['seek']);

			$res_del = $db->query  ( "SELECT type FROM $db_info WHERE num='$post_seek' and firmselector='$f[selector]'" )
			or die ( "ERROR011: mySQL error, can't select from INFO. (cominfo.php)" );

			$type_del = $db->fetcharray($res_del);

			$db->query  ( "DELETE FROM $db_info WHERE num='$post_seek' and firmselector='$f[selector]'" )
			or die ( "ERROR011: mySQL error, can't delete from INFO. (cominfo.php)" );

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
                        $post_seek=intval($_POST['seek']);
			$db->query  ( "UPDATE $db_info SET firmselector='$f[selector]', firmname='$f[firmname]', category='$f[category]', date='$date', datetime='$datetime', period='$period', item='$item', shortstory='$shortstory',
		         	 			fullstory='$fullstory', video='$video', f_name1='$form_n1', f_name2='$form_n2', f_name3='$form_n3', f_name4='$form_n4', f_name5='$form_n5', f_name6='$form_n6', f_name7='$form_n7', f_name8='$form_n8', f_name9='$form_n9', f_name10='$form_n10'
						        WHERE num='$post_seek' and firmselector='$f[selector]'" )
							or die ( "ERROR012: mySQL error, can't update INFO. (cominfo.php)" );
		
		}

		// Изменение публикации

		if ((($_POST["but"] == "$def_offers_edit_but") or ($_GET['set']=='edit')) and (isset($_POST[seek])))

		{
                $post_seek=intval($_POST['seek']);
		$res_change = $db->query  ( "SELECT * FROM $db_info WHERE num='$post_seek' and firmselector='$f[selector]'");
		$fe_change = $db->fetcharray  ( $res_change );
		
		$form_type = $fe_change[type];
		$form_period = $fe_change[period];
		$form_item = $fe_change[item];	
		$form_shortstory = $fe_change[shortstory];
		$form_shortstory = str_replace("<br>", "\n", $form_shortstory);
		$form_fullstory = $fe_change[fullstory];
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

				if ( filesize ( $_FILES['img1']['tmp_name'] )>$def_info_pic_size ) $upload = "Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.";

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
					
					@unlink ( "../info/$img_uploaded.gif" );
					@unlink ( "../info/$img_uploaded.jpg" );
					@unlink ( "../info/$img_uploaded.png" );
					@unlink ( "../info/$img_uploaded.bmp" );

					@unlink ( "../info/$img_uploaded-small.gif" );
					@unlink ( "../info/$img_uploaded-small.jpg" );
					@unlink ( "../info/$img_uploaded-small.png" );
					@unlink ( "../info/$img_uploaded-small.bmp" );

					copy ( $_FILES['img1']['tmp_name'], "../info/$img_uploaded.$type" )
					or $uploaded = "Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.";

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
					or $uploaded = "Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.";

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
            <li class="TabbedPanelsTab" tabindex="0">Информационный блок компании</li>
            <li class="TabbedPanelsTab" tabindex="0">Допустимые параметры</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Публикации</span></td>
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

 $type_on=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);
 $font_type=array(1 => "label", 2 => "label label-success", 3 => "label label-warning", 4 => "label label-important", 5 => "label label-info");

	$data_razdel="<option value=\"0\" selected>Все разделы</option>";

	for ($zz = 1; $zz < 6; $zz++) {

		if ($_SESSION["vType"]==$zz) $data_razdel.="<option value=\"$zz\" selected>$type_on[$zz]</option>";
		else $data_razdel.="<option value=\"$zz\">$type_on[$zz]</option>";
	}

 echo "
 <div align=\"right\"> 
 <form action=# method=POST>
 Фильтр: <select name=\"edit_fil\" onchange=\"this.form.submit();\">
 $data_razdel
 </select>
 </form>
 </div>";

echo '
<form action="?REQ=authorize&mod=info" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="5">
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

		if ($f_info[video]!="") $f_video="<a href=\"$def_mainlocation/users/inc/viewinfo.php?video=$f_info[num]\" target=\"_blank\"><font size=\"1\" color=\"#0000FF\">[видеоролик]</font></a>"; else $f_video ="";
		if ($f_info[img_on]==1) $f_img="<a href=\"$def_mainlocation/users/inc/viewinfo.php?img=$f_info[num]\" target=\"_blank\"><font size=\"1\" color=\"#0000FF\">[изображение]</font></a>"; else $f_img ="";
                if ($f_info['period']==0) { $f_info['period']=$def_period_offers; $days_result=''; }
                
                 // Показатель
                if ((strlen(strip_tags($f_info['shortstory'])))>(strlen(strip_tags($f_info['fullstory'])))) $message_p=strip_tags($f_info['shortstory']); else $message_p=strip_tags($f_info['fullstory']);
                $fx_proc=strlen(strip_tags($message_p)); $procent_txt=round(($fx_proc*80)/300); if ($procent_txt>80) $procent_txt=80;
                if ($f_info[img_on]==1) $procent_img=20; else $procent_img=0;
                $procent = round(($procent_txt+$procent_img),0);
?>

  <tr class="thumbnail">
    <td align="center">
        <div style="padding:3px;"><a href="?REQ=authorize&mod=info&changed=true&set=delete&seek=<?=$f_info['num'];?>" title="Удалить" class="icon-remove"></a></div>
   	<input type="radio" name="seek" value="<?php echo $f_info['num'];?>" style="border:0px;" <?php if ( $f_info['num'] == $_POST['seek'] ) echo "CHECKED"; ?>>
        <div style="padding:3px;"><a href="?REQ=authorize&mod=info&changed=true&set=edit&seek=<?=$f_info['num'];?>&notdop=true#form" title="Редактировать" class="icon-pencil"></a></div>
    </td>
<?php
echo '
    <td align="left">
        <div style="padding: 3px;"><span class="'.$font_type[$f_type].'">'.$type_on[$f_type].'</span><font size="1" color="#666666"> Дата: '.undate($f_info[date], $def_datetype).' | Период - '.$f_info['period'].' | Осталось - '.$days_result.'</font></div>
        <div style="padding: 3px;"><a href="'.$def_mainlocation.'/viewinfo.php?vi='.$f_info['num'].'" target="_blank"><b>'.$f_info['item'].'</b></a>&nbsp;'.$f_img.'&nbsp;'.$f_video.'</div>
        <div class="txt" style="padding:5px;">'.$f_info['shortstory'].'<div>
        <div style="width: 150px; padding:3px;">
                <div class="progress_mini progress-info progress-striped">
                <span class="txt tooltip-main well"><a title="<b>Показатель качества = '.$procent.'%</b><br>Знаков в описании - '.$fx_proc.' ('.$procent_txt.'%) и + '.$procent_img.'% за изображение."  rel="tooltip" href="#">
                    <div class="bar" style="width:'.$procent.'%;"></div>
                </a></span>
                </div>
        </div>
    </td>
  </tr>
';

 echo '<tr><td colspan="2" align="center"></td></tr>';
 
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

if ( ifEnabled_user ($f[flag] , "infoblock") )

{
    
     require ('../includes/editor/tiny_'.$f['flag'].'.php');

echo "
<a name=\"form\"></a>
<form action=\"?REQ=authorize&mod=info\" method=\"post\" enctype=\"multipart/form-data\">
<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\">
  <tr>
    <td align=\"center\">
    <div class=\"alert alert-info\" style=\"width:220px;\">Допустимо всего: <b>$dop_info</b><br>( Осталось: $ost_info, использовано: $all_info)</div>
    </td>	
  </tr>
  <tr>
    <td align=\"left\"><font color=red>*</font> 
<select id=\"var_list\" name=\"var\">
	<option value=\"\">Выберите раздел публикации</option>
";

if (isset($_POST["notdop"])) echo "<option value=\"$form_type\" selected>$type_on[$form_type]</option>"; else

{
	echo "<option value=\"1\""; if ( $form_type == "1" ) echo "selected"; echo ">$def_info_news</option>";
	echo "<option value=\"2\""; if ( $form_type == "2" ) echo "selected"; echo ">$def_info_tender</option>";
	echo "<option value=\"3\""; if ( $form_type == "3" ) echo "selected"; echo ">$def_info_board</option>";
	echo "<option value=\"4\""; if ( $form_type == "4" ) echo "selected"; echo ">$def_info_job</option>";	
	echo "<option value=\"5\""; if ( $form_type == "5" ) echo "selected"; echo ">$def_info_pressrel</option>";
}

echo "
</select>
    </td>
  </tr>
  <tr>
    <td align=\"left\"> Период публикации <select name=\"period\">";

 $periods = explode("#",  $def_info_expiration);

 for ($a=0;$a<count($periods);$a++)

 {
        if ($periods[$a]==0) $vivod_period=$def_period_offers; else $vivod_period=$periods[$a];
 	if ($form_period == $periods[$a]) echo "<option value=\"$periods[$a]\" SELECTED>$vivod_period</option>";
 	else echo "<option value=\"$periods[$a]\">$vivod_period</option>";

 }

echo "
</select> дней
  </td>
  </tr>
  <tr>
    <td align=\"left\">Название публикации: <font color=red>*</font> <input type=\"text\" name=\"item\" value=\"$form_item\" size=\"45\" maxlength=\"100\"></td>
  </tr>
  <tr>
    <td align=\"left\">Краткое описание (максимум  $def_info_descr_size символов): <font color=red>*</font> <br><textarea name=\"shortstory\" cols=\"45\" rows=\"5\" style=\"width:450px; height:100px;\">$form_shortstory</textarea></td>
  </tr>
  <tr>
    <td align=\"left\">Полное описание:<br><textarea name=\"fullstory\" cols=\"45\" rows=\"5\" id=\"business\" class=\"business\" style=\"width:450px; height:100px;\">$form_fullstory</textarea></td>
  </tr>
  <tr>
    <td align=\"left\">URL видеоролика: <input type=\"text\" name=\"video\" value=\"$form_video\" size=\"45\" maxlength=\"300\"></td>
  </tr>
  <tr>
    <td align=\"left\">";

	if (isset($_POST["notdop"]) and ($form_img_on==1) ) echo "Обновить изображение: <input type=\"file\" name=\"img1\" size=\"35\"></td>";
	else echo "Изображение: <input type=\"file\" name=\"img1\" size=\"35\"></td>";

echo "
  </tr>
  <tr>
    <td align=\"left\">";

if (isset($_POST["notdop"])) {

	$res_infofieldst = $db->query("SELECT * FROM $db_infofields WHERE num = '$form_type'");
	$b_ff = $db->fetcharray($res_infofieldst);

	if ($b_ff[f_on1]==1) { if ($b_ff[f_type1]==1) echo "$b_ff[f_name1]: <input type=\"text\" name=\"form_n1\" value=\"$form_name1\" size=\"45\" maxlength=\"100\"><br>"; else echo "$b_ff[f_name1]:<br><textarea name=\"form_n1\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\">$form_name1</textarea><br>"; }
	if ($b_ff[f_on2]==1) { if ($b_ff[f_type2]==1) echo "$b_ff[f_name2]: <input type=\"text\" name=\"form_n2\" value=\"$form_name2\" size=\"45\" maxlength=\"100\"><br>"; else echo "$b_ff[f_name2]:<br><textarea name=\"form_n2\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\">$form_name2</textarea><br>"; }
	if ($b_ff[f_on3]==1) { if ($b_ff[f_type3]==1) echo "$b_ff[f_name3]: <input type=\"text\" name=\"form_n3\" value=\"$form_name3\" size=\"45\" maxlength=\"100\"><br>"; else echo "$b_ff[f_name3]:<br><textarea name=\"form_n3\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\">$form_name3</textarea><br>"; }
	if ($b_ff[f_on4]==1) { if ($b_ff[f_type4]==1) echo "$b_ff[f_name4]: <input type=\"text\" name=\"form_n4\" value=\"$form_name4\" size=\"45\" maxlength=\"100\"><br>"; else echo "$b_ff[f_name4]:<br><textarea name=\"form_n4\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\">$form_name4</textarea><br>"; }
	if ($b_ff[f_on5]==1) { if ($b_ff[f_type5]==1) echo "$b_ff[f_name5]: <input type=\"text\" name=\"form_n5\" value=\"$form_name5\" size=\"45\" maxlength=\"100\"><br>"; else echo "$b_ff[f_name5]:<br><textarea name=\"form_n5\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\">$form_name5</textarea><br>"; }
	if ($b_ff[f_on6]==1) { if ($b_ff[f_type6]==1) echo "$b_ff[f_name6]: <input type=\"text\" name=\"form_n6\" value=\"$form_name6\" size=\"45\" maxlength=\"100\"><br>"; else echo "$b_ff[f_name6]:<br><textarea name=\"form_n6\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\">$form_name6</textarea><br>"; }
	if ($b_ff[f_on7]==1) { if ($b_ff[f_type7]==1) echo "$b_ff[f_name7]: <input type=\"text\" name=\"form_n7\" value=\"$form_name7\" size=\"45\" maxlength=\"100\"><br>"; else echo "$b_ff[f_name7]:<br><textarea name=\"form_n7\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\">$form_name7</textarea><br>"; }
	if ($b_ff[f_on8]==1) { if ($b_ff[f_type8]==1) echo "$b_ff[f_name8]: <input type=\"text\" name=\"form_n8\" value=\"$form_name8\" size=\"45\" maxlength=\"100\"><br>"; else echo "$b_ff[f_name8]:<br><textarea name=\"form_n8\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\">$form_name8</textarea><br>"; }
	if ($b_ff[f_on9]==1) { if ($b_ff[f_type9]==1) echo "$b_ff[f_name9]: <input type=\"text\" name=\"form_n9\" value=\"$form_name9\" size=\"45\" maxlength=\"100\"><br>"; else echo "$b_ff[f_name9]:<br><textarea name=\"form_n9\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\">$form_name9</textarea><br>"; }
	if ($b_ff[f_on10]==1) { if ($b_ff[f_type10]==1) echo "$b_ff[f_name10]: <input type=\"text\" name=\"form_n10\" value=\"$form_name10\" size=\"45\" maxlength=\"100\"><br>"; else echo "$b_ff[f_name10]:<br><textarea name=\"form_n10\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\">$form_name10</textarea><br>"; }

}

else echo "<div id=\"info_div\"></div>";

echo "
  </td>
  </tr>
  <tr>
    <td align=\"center\">
<input type=\"hidden\" name=\"changed\" value=\"true\">
<input type=\"hidden\" name=\"upload\" value=\"true\">
";
	if (isset($_POST["notdop"])) echo "<input type=\"submit\" name=\"but\" class=\"btn btn-warning\" value=\"$def_offers_change\">"; else echo "<input id=\"button_send\" type=\"submit\" name=\"but\" class=\"btn btn-warning\" value=\"$def_offers_add\">";
	if (isset($_POST[seek])) echo "<input type=\"hidden\" name=\"seek\" value=\"$_POST[seek]\">";
echo "
</td>
  </tr>
</table>
</form>
";

?>

<script type="text/javascript" src="../includes/jquery.js"></script>
<script type="text/javascript">
jQuery.noConflict();

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
	jQuery.get('modules/ajaxfield.php', {ajax: "on", param: req, r: Math.random()}, updateChoice);
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
                  <td><? $size_img=$def_info_pic_size/1000000; echo "$size_img Мб"; ?></td>
                </tr>
                <tr>
                  <td width="180" align="right">Типы файлов:</td>
                  <td><strong>jpg, gif, png, bmp</strong></td>
                </tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td width="180" align="right">Видеообменники:</td>
                  <td><a href="http://youtube.com" target="_blank"><strong>YouTube.com</strong></a> Добавить видео <a href="http://www.youtube.com/my_videos_upload" target="_blank">&raquo;</a><br>
		      <a href="http://rutube.ru/" target="_blank"><strong>RuTube.ru</strong></a> Добавить видео <a href="http://uploader.rutube.ru/upload.html" target="_blank">&raquo;</a>	
		  </td>
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
            <? echo "$help_infoblock"; ?>
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
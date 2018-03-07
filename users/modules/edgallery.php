<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: edgallery.php
-----------------------------------------------------
 Назначение: Галерея изображений
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if ($_REQUEST["changed"]== "true") {

if (isset($_GET['seek'])) $_POST['seek']=intval($_GET['seek']);
if (isset($_POST['seek'])) $_POST['seek']=intval($_POST['seek']);


    		if (( $_POST["but"] == $def_images_delete ) or ($_GET['set']=='delete'))
		{
                        $firmselec = $f['selector'];

			@unlink ( ".././gallery/$_POST[seek].gif" );
			@unlink ( ".././gallery/$_POST[seek].bmp" );
			@unlink ( ".././gallery/$_POST[seek].jpg" );
			@unlink ( ".././gallery/$_POST[seek].png" );

			@unlink ( ".././gallery/$_POST[seek]-small.gif" );
			@unlink ( ".././gallery/$_POST[seek]-small.bmp" );
			@unlink ( ".././gallery/$_POST[seek]-small.jpg" );
			@unlink ( ".././gallery/$_POST[seek]-small.png" );

			$db->query  ( "DELETE FROM $db_images WHERE num='$_POST[seek]' and firmselector='$firmselec'" )
			or die ( "ERROR011: mySQL error, can't delete from IMAGES. (edgallery.php)" );
		}

                if ((($_POST['but'] == $def_offers_edit_but) or ($_GET['set']=='edit')) and (isset($_POST['seek'])))

		{
                        $post_seek=intval($_POST['seek']);
                        $res_images = $db->query  ( "SELECT * FROM $db_images WHERE num='$post_seek' and firmselector='$f[selector]'");
                        $fe_images = $db->fetcharray  ( $res_images );

                        $form_item = $fe_images['item'];
                        $form_message = $fe_images['message'];
                	$form_message = str_replace("<br>", "\n", $form_message);
        		$form_sort = $fe_images['sort'];
                        $form_change = 'true';

		} else $form_change = 'false';
}

	if ( $_POST["add"] == "true" )

	{
		$item = safeHTML ($_POST['item']);
		$message = safeHTML ($_POST['message']);
		$images = intval($f['images']);
                $sort = safeHTML ($_POST['sort']);

		$firmselec = intval($f['selector']);

		if (strlen($message) > $def_image_descr_size) $message=isb_sub($message, $def_image_descr_size);

		if ( ( empty ( $item ) ) and ( $_POST[but] != "$def_images_delete" ) ) $empty = "Вы не заполнили обязательное поле - изображение!";

		if ( ( empty ( $_FILES['img1']['tmp_name'] ) ) and ( $_POST["edit"] != 'true' ) ) $empty = "Вы не выбрали файл изображения!";

		if ( filesize ( $_FILES['img1']['tmp_name'] )>$def_images_pic_size ) $empty = "Файл нельзя загрузить на сервер!<br>Он превышает лимит по размеру файла принимаемым нашим сервером!<br>Оптимизируйте его.";

		// *********************************************************

                if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_change" ) )

		{
                        $post_seek=intval($_POST['seek']);
                        $db->query  ( "UPDATE $db_images SET item='$item', message='$message', sort='$sort' WHERE num='$post_seek' and firmselector='$f[selector]'" )
							or die ( "ERROR012: mySQL error, can't update INFO. (cominfo.php)" );
                }


		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_images_add" ) )

		{

			$r = $db->query  ( "SELECT * FROM $db_images WHERE firmselector = '$firmselec'" );
			@$results_amount=mysql_num_rows($r);
			@$db->freeresult ($r);

			if ( $results_amount <> $images )

			{		
				$f_FOTO = substr($_FILES['img1']['name'], -4);

				if ( !in_array($f_FOTO, array('.jpg', '.JPG', 'jpeg', 'JPEG'))) $empty = "Ошибочное расширение.<br> Используйте файлы только .jpg расширением!";				
				
				if (!isset($empty)) {
				
				$date = date ( "Y-m-d" );

				$db->query  ( "INSERT INTO $db_images (firmselector, item, date, message, sort) VALUES ('$firmselec', '$item', '$date', '$message', '$sort')" )
				or die ( "ERROR010: mySQL error, cant insert into IMAGES. (edgallery.php)" );
				
				}
			}

			else $over = "Добавлять изображения нельзя! Ваш лимит закончен!<br> К загрузке допускается - $images изображений!";

		}
                
       			// Оптимизация рисунка
			
			if ((!isset($empty)) and (!isset($over)))

			{
				if ($_POST['edit']!='true') $_POST[seek] = mysql_insert_id();

				if ( $_FILES['img1']['tmp_name'] )

				{
					$type = "jpg";					
					
					@unlink ( ".././gallery/$_POST[seek].gif" );
					@unlink ( ".././gallery/$_POST[seek].jpg" );
					@unlink ( ".././gallery/$_POST[seek].png" );

					@unlink ( ".././gallery/$_POST[seek]-small.gif" );
					@unlink ( ".././gallery/$_POST[seek]-small.jpg" );
					@unlink ( ".././gallery/$_POST[seek]-small.png" );

					copy ( $_FILES['img1']['tmp_name'], ".././gallery/$_POST[seek].$type" )
						or $upload = "<font color=red>$def_imagespic_error</font><br>";

					$type = ".jpg";

					$out = 'imagejpeg';
						$q = 100;

					$img = imagecreatefromstring( file_get_contents('../gallery/'.$_POST[seek].$type) );
					$w = imagesx($img);
					$h = imagesy($img);
					$k = $def_images_thumb_width / $w;
					$img2 = imagecreatetruecolor($w * $k, $h * $k);
					imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
					$out($img2, '../gallery/'.$_POST[seek].'-small'.$type, $q);
				
					if ($w > $def_images_pic_width)
					{
						$k = $def_images_pic_width / $w;
						$img2 = imagecreatetruecolor($w * $k, $h * $k);
						imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
						$out($img2, '../gallery/'.$_POST[seek].$type, $q);
						$w *= $k;
						$h *= $k;
						$img = $img2;
					}

					if ($def_gallery_wattermark == 'YES')
					{
						$img2 = imagecreatefrompng('../foto/_watermark.png');
						$w_ = imagesx($img2);
						$h_ = imagesy($img2);
						imagecopyresampled($img, $img2, $w - $w_, $h - $h_, 0, 0, $w_, $h_, $w_, $h_);
						$out($img, '../gallery/'.$_POST[seek].$type, $q);
					}


					$upload = $def_images_pic_ok;
				}
			}
                }

                 if ( isset ( $over ) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$over.'</div>';

                 if ( isset ( $empty ) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$empty.'</div>';

                 if ( isset ( $upload ) ) echo '<div class="alert alert-success">'.$upload.'</div>';

    $firmsel = intval($f['selector']);
    $pages=7;
                 
    $r = $db->query  ( "SELECT * FROM $db_images WHERE firmselector='$firmsel' ORDER BY sort, num DESC" ) or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $r );
    @$results_amount_all = mysql_num_rows ( $r );

    if ($results_amount>$pages) {

    		$page1=intval($_POST['page'])*$pages;

    $r=$db->query ("SELECT * FROM $db_images WHERE firmselector='$firmsel' ORDER BY sort, num DESC LIMIT $page1, $pages") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $r );
    }

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Галерея изображений</li>
            <li class="TabbedPanelsTab" tabindex="0">Допустимые параметры изображений</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Галерея изображений</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont">
		   <div align="center">

<? if ($results_amount_all > $pages){ ?>
<div style="text-align:right;">
<form action="?REQ=authorize&mod=edgallery" method="post">
  Страница : <select name="page" onchange="this.form.submit();">
<?
                $z=0;
                $xp1=0;
			for($x=0; $x<$results_amount_all; $x=$x+$pages)
			{
                            $xp1=$z+1;
				if ($z == $_POST['page']) {echo '<option value="'.$_POST['page'].'" selected>'.$xp1.'</option>'; } else {echo '<option value="'.$z.'">'.$xp1.'</option>';}
                                $z++;
			}
?>
    </select>
</form>
</div><br>
<?
}

$pricelines = $f['images'];
$free = $pricelines - $results_amount_all;

echo '<form action="?REQ=authorize&mod=edgallery" method="post" enctype="multipart/form-data">
             <table cellpadding="5" cellspacing="1" border="0" width="100%">';

 $banhandle = opendir ( ".././gallery" );

 $bancount=0;

 while ( false !== ( $banfile = readdir ( $banhandle ) ) )
 {
 	if ( $banfile != "." && $banfile != ".." )
 	{
 		$banbanner[$bancount] = $banfile;
 		$bancount++;
 	}
 }

 closedir ( $banhandle );

 for ( $i=0; $i<$results_amount; $i++ )
 {
 	$f_i = $db->fetcharray  ( $r );

 	$pictext="";

 	for ( $aaa=0;$aaa<count ( $banbanner );$aaa++ )

 	{
 		$banrbanner = explode( ".", $banbanner[$aaa] );

 		if ( $banrbanner[0] == $f_i['num'] )

 		$pictext = "<a href=\".././gallery/$f_i[num].jpg\" target=\"_blank\"><img src=\".././gallery/$f_i[num]-small.jpg\" alt=\"$f_i[item]\" border=\"0\"></a>";
 	}

 ?>

     <tr class="thumbnail">
      <td valign="middle" align="center">
       <div style="padding:3px;"><a href="?REQ=authorize&mod=edgallery&changed=true&set=delete&seek=<?=$f_i['num'];?>" title="Удалить" class="icon-remove"></a></div>
       <input type="radio" title="Выбрать" name="seek" value="<?php echo $f_i['num'];?>" style="border:0;" <?php if ( $f_i['num'] == $_POST['seek'] ) echo "CHECKED"; ?>>
       <div style="padding:3px;"><a href="?REQ=authorize&mod=edgallery&changed=true&set=edit&seek=<?=$f_i['num'];?>#form" title="Редактировать" class="icon-pencil"></a></div>
      </td>

 <?php

 $cols="";

 $widht_table_img=$def_images_thumb_width+20;
 if ($f_i['rateNum']>0) $rating='<div style="padding:5px; text-align:right;"><span class="label label-info">Рейтинг ('.$f_i['rateNum'].'/'.$f_i['rateVal'].')</span> [<span class="txt tooltip-main well"><a title="Показывает общее число голосов и оценку." rel="tooltip" href="#">?</a></span>]</div>'; else $rating='';

 if ($pictext != "") echo '<td align="left" valign="middle" width="'.$widht_table_img.'" class="imgalert">'.$pictext.'<br></td>';
 else $cols = 'colspan="2"';

 // Показатель
$fx_proc=strlen(strip_tags($f_i['message'])); $procent=round(($fx_proc*100)/300); if ($procent>100) $procent=100;

 echo '<td '.$cols.' align="left" valign="middle"><span class="label label-info">'.undate($f_i['date'], $def_datetype).'</span> <b>'.$f_i['item'].'</b>
             <div class="txt" style="padding:5px;">'.$f_i['message'].'</div>'.$rating.'
             <div style="width: 150px; padding:3px;">
                <div class="progress_mini progress-info progress-striped">
                <span class="txt tooltip-main well"><a title="<b>Показатель качества = '.$procent.'%</b><br>Знаков в описании - '.$fx_proc.'. " rel="tooltip" href="#">
                    <div class="bar" style="width:'.$procent.'%;"></div>
                </a></span>
                </div>
             </div>
       </td></tr>';
 
 echo '<tr><td colspan="3" align="center"></td></tr>';
 
 }

 echo "</table><br>
&nbsp;<input type=\"submit\" name=\"but\" value=\"$def_images_delete\" class=\"btn btn-danger\">
&nbsp;<input type=\"submit\" name=\"but\" value=\"$def_offers_edit_but\" class=\"btn btn-warning\">
<input type=\"hidden\" name=\"changed\" value=\"true\">
<input type=\"hidden\" name=\"notdop\" value=\"true\">
</form>";

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
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Добавить / Обновить </span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo $def_mainlocation; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont" align="center">
<?php

if (  $f_i['images'] != '0' )

{

 echo '<div class="alert alert-info" style="width:220px;">Допустимо всего: <b>'.$pricelines.'</b><br>(Осталось: '.$free.', использовано: '.$results_amount_all.')</div>';
 echo "<a name=\"form\"></a><form action=\"?REQ=authorize&mod=edgallery\" method=\"post\" enctype=\"multipart/form-data\">";
 echo "<table cellpadding=\"5\" cellspacing=\"1\" border=\"0\" width=\"100%\">
           <tr>
            <td bgColor=\"$def_form_back_color\" align=\"right\" width=\"80%\">
          $def_images_item: <font color=red>*</font><input type=\"text\" name=\"item\" value=\"$form_item\" size=\"45\" maxlength=\"100\"><br><br>
          $def_images_description: &nbsp;&nbsp;<textarea name=\"message\" cols=\"45\" rows=\"5\" style=\"width:400px; height:200px;\">$form_message</textarea><br><br>
          $def_images_sort: <input type=\"text\" name=\"sort\" size=\"45\" value=\"$form_sort\" maxlength=\"10\" style=\"width: 40px;\"><br>
  <br><b>Добавить / Обновить изображение</b><br><br>
  <input type=\"file\" NAME=\"img1\" SIZE=\"34\"><br><br>";

 echo"</td></tr>";

 echo "<tr><td align=\"center\" bgColor=\"$def_form_header_color\" colspan=\"3\">";
 
 if ($form_change == 'true') echo "<input type=\"submit\" name=\"but\" value=\"$def_offers_change\" class=\"btn btn-warning\"><input type=\"hidden\" name=\"edit\" value=\"true\"><input type=\"hidden\" name=\"add\" value=\"true\"><br>";
 else echo "<input type=\"submit\" name=\"but\" value=\"$def_images_add\" class=\"btn btn-warning\"><input type=\"hidden\" name=\"add\" value=\"true\"><br>";
 if (isset($_POST['seek'])) echo "<input type=\"hidden\" name=\"seek\" value=\"$_POST[seek]\">";
 echo "</td>
       </tr>
      </table>
 </form>";

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
                  <td width="180" align="right">Размер файла:</td>
                  <td><? $size_img=$def_images_pic_size/1000000; echo "$size_img Мб"; ?></td>
                </tr>
                <tr>
                  <td width="180" align="right">Типы файлов:</td>
                  <td><strong>jpg</strong></td>
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
            <? echo $help_edgallery; ?>
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
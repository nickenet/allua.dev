<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: edgallery.php
-----------------------------------------------------
 Назначение: Редактирование галереи
=====================================================
*/

@ $randomized = rand ( 0, 9999 );

session_start();

require_once './defaults.php';

$idident=intval($_REQUEST['id']);
if (isset($_POST['idident'])) $idident=intval($_REQUEST['idident']);

$help_section = (string)$gallery_help;

$title_cp = $def_images_edit.' - ';
$speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | <a href="edgallery.php?id='.$idident.'">'.$def_images_edit.'</a>';

check_login_cp('1_0','edgallery.php?id='.$idident);

require_once 'template/header.php';

$r=$db->query ("select * from $db_users where selector='$idident'") or die ("mySQL error!");

$f=$db->fetcharray ($r);

        // *********************************************************

if ($_POST["changed"]== "true") {

    		if ( $_POST["but"] == "$def_images_delete" )

		{
                        $firmselec = $f["selector"];

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

                if (($_POST["but"] == "$def_offers_edit_but") and (isset($_POST[seek])))

		{

                        $res_images = $db->query  ( "SELECT * FROM $db_images WHERE num='$_POST[seek]' and firmselector='$f[selector]'");
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
		$item = safeHTML ($_POST["item"]);
		$message = safeHTML ($_POST["message"]);
		$images = $f["images"];
                $sort = safeHTML ($_POST["sort"]);

		$firmselec = $f["selector"];

		if (strlen($message) > $def_image_descr_size)
			{
				$message = substr($message, 0, $def_image_descr_size);
				$message = substr($message, 0, strrpos($message, ' '));
				$message = trim($message) . ' ...';
			}

		if ( $f["images"] == '0' )

		{
			echo "ERROR009: No images available for this listing. (edgallery.php)";
			$db->close();
			exit();
		}

		if ( ( empty ( $item ) ) and ( $_POST[but] != "$def_images_delete" ) ) $empty = "Вы не заполнили обязательное поле - изображение.";

		if ( ( empty ( $_FILES['img1']['tmp_name'] ) ) and ( $_POST["edit"] != 'true' ) ) $empty = 'Вы не выбрали файл изображения!';

		if ( filesize ( $_FILES['img1']['tmp_name'] )>$def_images_pic_size ) $empty = (string)$def_admin_error_file;

		// *********************************************************

                if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_change" ) )

                {
                       $db->query  ( "UPDATE $db_images SET item='$item', message='$message', sort='$sort' WHERE num='$_POST[seek]' and firmselector='$f[selector]'" )
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

				if ( !in_array($f_FOTO, array('.jpg', '.JPG', 'jpeg', 'JPEG'))) $empty = (string)$def_admin_error_jpg_file;
				
				if (!isset($empty)) {
				
				$date = date ( "Y-m-d" );

				$db->query  ( "INSERT INTO $db_images (firmselector, item, date, message, sort) VALUES ('$firmselec', '$item', '$date', '$message', '$sort')" )
				or die ( "ERROR010: mySQL error, cant insert into IMAGES. (edgallery.php)" );
                                			
				}
			}

			else

			{
				$over = "Добавлять изображения нельзя! Ваш лимит закончен!<br /> К загрузке допускается - $images изображений.";
			}

		}

                	if ( (!isset($empty) ) and (!isset($over) ) )

			{
				if ($_POST['edit']!='true') $_POST[seek] = mysql_insert_id();

				if ( $_FILES['img1']['tmp_name'] )

				{
					chmod ( $_FILES['img1']['tmp_name'], 0777 )
					or die ( "ERROR007: Can't change file permission. (edgallery.php) ");

					$type = "jpg";

					@unlink ( ".././gallery/$_POST[seek].gif" );
					@unlink ( ".././gallery/$_POST[seek].jpg" );
					@unlink ( ".././gallery/$_POST[seek].png" );

					@unlink ( ".././gallery/$_POST[seek]-small.gif" );
					@unlink ( ".././gallery/$_POST[seek]-small.jpg" );
					@unlink ( ".././gallery/$_POST[seek]-small.png" );

					copy ( $_FILES['img1']['tmp_name'], ".././gallery/$_POST[seek].$type" )
						or $upload = (string)$def_imagespic_error;

					chmod ( ".././gallery/$_POST[seek].$type", 0777 )
					or die ( "ERROR008: Can't change file permission. (edgallery.php) ");

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

					$upload = (string)$def_images_pic_ok;

					logsto("Добавлено изображение для компании <b>$f[firmname]</b> (id=$f[selector])");

				}
			}

                }

// *********************************************************

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

 table_item_top ($def_images_edit,'pictures.png');

 $pricelines = $f['images'];

 $free = $pricelines - $results_amount_all;

 echo '&nbsp;'.$def_images.': <b>'.$pricelines.'</b> ('.$def_free.': '.$free.' - '.$def_used.': '.$results_amount_all.')<br /><br />';

if ($results_amount_all > $pages){ ?>
<div style="text-align:right; padding-right:20px;">
<form action="edgallery.php?id=<?=$idident; ?>" method="post">
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

 if ( isset ( $over ) )
 {
     msg_text("80%",$def_admin_message_mess,$over);
 }

 if (!empty ($empty)) msg_text("80%",$def_admin_message_mess,$empty);

 if (isset($upload))  msg_text("80%",$def_admin_message_mess,$upload);

 echo '<form action="edgallery.php" method="post" enctype="multipart/form-data">
             <table cellpadding="0" cellspacing="0" border="0" width="97%" align="center">
              <tr>
               <td align="middle" valign="middle" width="5%" id="table_files">'.$def_images_choice.'</td>
               <td colspan="2" align="middle" valign="middle" width="50%" id="table_files_r">'.$def_images_item.'</td>
              </tr>';

 $banhandle = opendir ( ".././gallery" );

 $bancount=0;

 while ( false !== ( $banfile = readdir ( $banhandle ) ) )

 {
 	if ( $banfile != "." && $banfile != ".." )

 	{
 		$banbanner[$bancount] = "$banfile";
 		$bancount++;
 	}
 }

 closedir ( $banhandle );

 for ( $i=0; $i<$results_amount; $i++ )

 {
 	$f = $db->fetcharray  ( $r );

 	$pictext="";

 	for ( $aaa=0;$aaa<count ( $banbanner );$aaa++ )

 	{
 		$banrbanner = explode( ".", $banbanner[$aaa] );

 		if ( $banrbanner[0] == $f[num] )

 		$pictext = "<img src=\".././gallery/$f[num]-small.jpg\" alt=\"$f[item]\" />";
 	}

 ?>

     <tr>
      <td valign="middle" align="center" id="table_files_i">
       <input type="radio" name="seek" value="<?php echo $f[num]; ?>" style="border:0;" <?php if ( $f[num] == $_POST['seek'] ) echo "CHECKED"; ?>>
      </td>

 <?php

 $cols="";

 $widht_table_img=$def_images_pic_width+20;

 if ($pictext != "")

 echo '<td align="left" valign="middle" width="'.$widht_table_img.'" id="table_files_i_c">'.$pictext.'<br /></td>';

 else

 $cols = "colspan=2";

 echo '<td  width="90%" '.$cols.' align="left" valign="middle" id="table_files_i_r">
            <b>'.$f[item].'</b> ('. undate($f[date], $def_datetype).')
             <br /><br />'.$def_images_description.': '.$f[message].'
       </td>
       </tr>';
 }

 echo '</table><br /><div align="center">
&nbsp;<input type="submit" name="but" value="'.$def_images_delete.'" style="color: #FFFFFF; background: #D55454;">
&nbsp;<input type="submit" name="but" value="'.$def_offers_edit_but.'">
<input type="hidden" name="changed" value="true">
<input type="hidden" name="notdop" value="true">
<input type="hidden" name="id" value="'.$idident.'" />
<br /><br /></div>
</form>';

table_fdata_top ($def_item_form_data);

 echo '<br /><form action="edgallery.php" method="post" enctype="multipart/form-data">
          <table cellpadding="3" cellspacing="3" border="0" width="97%" align="center">
           <tr>
            <td align="right" width="80%">
          '.$def_images_item.': <span style="color:#FF0000;">*</span> <input type="text" name="item" value="'.$form_item.'" size="45" maxlength="100" /><br /><br />
          '.$def_images_description.': &nbsp;&nbsp;<textarea name="message" cols="45" rows="5" style="width:400px; height:200px;">'.$form_message.'</textarea><br /><br />
          '.$def_images_sort.': <input type="text" name="sort" value="'.$form_sort.'" size="45" maxlength="10" style="width: 40px;" /><br /><br />
          '.$def_offers_imageupload.' (jpg, Допустимый размер: '.$def_images_pic_size.' байты): &nbsp;&nbsp;<input type="file" NAME="img1" SIZE="34" /><br /><br />';
 echo '     </td>
           </tr>';
 echo '<tr><td align="center" colspan="3">';

 if ($form_change == 'true') echo '<input type="submit" name="but" value="'.$def_offers_change.'" /><input type="hidden" name="edit" value="true" /><input type="hidden" name="add" value="true" /><br />';
 else echo '<input type="submit" name="but" value="'.$def_images_add.'"><input type="hidden" name="add" value="true" /><br />';
 if (isset($_POST[seek])) echo '<input type="hidden" name="seek" value="'.$_POST[seek].'" />';
 echo '<input type="hidden" name="id" value="'.$idident.'" /><br />';
 
 echo '  </td>
       </tr>';
 echo '</table></form>';

table_fdata_bottom();

require_once 'template/footer.php';

?>
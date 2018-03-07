<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: edexel.php
-----------------------------------------------------
 Назначение: Редактирование excel прайсов
=====================================================
*/

@ $randomized = rand ( 0, 9999 );

session_start();

require_once './defaults.php';

$idident=intval($_REQUEST['id']);
if (isset($_POST['idident'])) $idident=intval($_REQUEST['idident']);

$help_section = (string)$exel_help;

$title_cp = $def_exel_edit.' - ';
$speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | <a href="edexel.php?id='.$idident.'">'.$def_exel_edit.'</a>';

check_login_cp('1_0','edexel.php?id='.$idident);

require_once 'template/header.php';

$r=$db->query ("select * from $db_users where selector='$idident'") or die ("mySQL error!");

$f=$db->fetcharray ($r);

$firmselec = intval($f['selector']);

$firmsel = intval($f['selector']);

$fileExt = explode("#", $def_excel_ext);

$type_ext =  str_replace("#", ", ", $def_excel_ext);
$type_ext = '<strong>'.$type_ext.'</strong>';

        // *********************************************************

        if ( $_POST["changed"] == "true" )

	{
		$item = safeHTML ($_POST['item']);
		$message = safeHTML ($_POST['message']);
                $message = isb_sub($message,$def_image_descr_size);
		$images = intval($f['exel']);

		if ( ($item=='')  and ( $_POST['but'] != $def_images_delete ) ) $empty = 'Вы не заполнили обязательное поле: Краткое название файла.<br>';

		if ( ( empty ( $_FILES['img1']['tmp_name'] ) ) and ( $_POST['but'] != $def_images_delete ) and ($_POST['edit']!='true') ) $empty .= 'Вы не выбрали файл для загрузки.<br>';

                if ($_FILES['img1']['tmp_name']!='') {

                    $name_xls=$_FILES[img1]['name'];
                    $type = strtolower(pathinfo($name_xls, PATHINFO_EXTENSION));

                    $filesize = filesize ( $_FILES['img1']['tmp_name'] );
                    $max_size = $def_exel_pic_size;

                    if ( $filesize > $max_size ) $empty .= "$def_exel_pic_error @ $def_exel_pic_size Bytes";
                    if (!in_array($type, $fileExt)) $empty .= 'К загрузке допускаются файлы с расширениями: '.$type_ext.'.';

                }

		// *********************************************************

		if ( ( empty ( $empty ) ) and (( $_POST['but'] == $def_images_add ) or ( $_POST['but'] == $def_images_change ))  )

		{
                    if ($_POST['edit']!='true') {
			$r = $db->query  ( "SELECT * FROM $db_exelp WHERE firmselector = '$firmselec'" );
			@$results_amount=mysql_num_rows($r);
			@$db->freeresult ($r);

			if ( $results_amount <> $images )

			{
				$date = date ( "Y-m-d" );

				$db->query  ( "INSERT INTO $db_exelp (firmselector, item, date, message) VALUES ('$firmselec', '$item', '$date', '$message')" )
				or die ( "ERROR010: mySQL error, cant insert into EXEL. (edexel.php)" );
                                $_POST[seek] = mysql_insert_id();
			} else $over = "Добавлять прайс-лист нельзя! Лимит закончен!<br> К загрузке допускается - $images прайсов!";
                        } else
                        {
                            $date = date ( "Y-m-d" );
                            $db->query  ( "UPDATE $db_exelp SET item='$item', date='$date', message='$message' WHERE num='$_POST[seek]' and firmselector='$firmselec'" );
                            if ( $_FILES['img1']['tmp_name']!='') $_POST["but"] = $def_images_add;
                        }

			// *********************************************************

			if ( ( $_POST["but"] == $def_images_add ) and (!isset($empty) ) and (!isset($over) ) )

			{
				if ( isset($_FILES['img1']['tmp_name']) && is_uploaded_file($_FILES[img1]['tmp_name']) )

				{

                                    foreach ($fileExt as $value_ext) {

                                        @unlink ( ".././exel/$_POST[seek].$value_ext" );

                                    }
						copy ( $_FILES['img1']['tmp_name'], ".././exel/$_POST[seek].$type" )
						or $upload = $def_exel_pic_error;

						$upload = $def_exel_pic_ok;

                                                logsto("Добавлен прайс-лист для компании <b>$f[firmname]</b> (id=$f[selector])");
				}

				else

				{
					$upload = $def_specify_file_exel;
					@$db->query  ("DELETE FROM $db_exelp where num = '$_POST[seek]'");
				}
			}
		}
                        $item='';
                        $message='';
                }

		// *********************************************************

		if (( $_POST['delete'] == 'true' ) and ($_POST['edit_b']!=$def_offers_change))
		{

                       foreach ($fileExt as $value_ext) {

                          @unlink ( ".././exel/$_POST[seek].$value_ext" );

                       }

			$db->query  ( "DELETE FROM $db_exelp WHERE num='$_POST[seek]' and firmselector='$f[selector]'" )
			or die ( "ERROR011: mySQL error, can't delete from EXCEL. (edexel.php)" );

                        logsto("Удален прайс-лист ($_POST[seek]) компании <b>$f[firmname]</b> (id=$f[selector])");
		}

                if (( $_POST['delete'] == 'true' ) and ($_POST['edit_b']==$def_offers_change))
		{
                        $edit_price=intval($_POST['seek']);
			$r_ed = $db->query  ( "SELECT * FROM $db_exelp WHERE firmselector='$f[selector]' and num='$edit_price' LIMIT 1" );
                        $f_ed = $db->fetcharray  ( $r_ed );
                        $item=$f_ed['item'];
                        $message=$f_ed['message'];
                        $message = str_replace("<br>", "\n", $message);
                        if ($item!='') $edit_price=true;
                        $seek=$f_ed['num'];
		}

                // *********************************************************             

		$r = $db->query  ( "SELECT * FROM $db_exelp WHERE firmselector='$firmsel' ORDER BY num" );

 table_item_top ($def_exel_edit,'xlss.png');

 @$results_amount = mysql_num_rows ( $r );

 $pricelines = $f[exel];
 
 $free = $pricelines - $results_amount;

 echo '&nbsp;'.$def_exelp.': <b>'.$pricelines.'</b> ('.$def_free.': '.$free.' - '.$def_used.': '.$results_amount.')<br /><br />';

 if (isset($over)) msg_text("80%",$def_admin_message_mess,$over);

 if (isset($empty)) msg_text("80%",$def_admin_message_mess,$empty);

 if (isset($upload))  msg_text("80%",$def_admin_message_mess,$upload);

?>

<style type="text/css">
    .main_list {
	border: 1px solid #A6B2D5;
	border-collapse: collapse;
	}
    .main_list td {
        padding: 5px;
        text-align: left;
	border: 1px solid #A6B2D5;
	}
    .main_list th {
        background-image: url(images/table_files_bg.gif);
	height: 25px;
	padding-top: 2px;
	padding-left: 5px;
	text-align: center;
	border: 1px solid #A6B2D5;
        }
    hr {
	border: 1px dotted #CCCCCC;
        }
</style>

<?

 echo '<form action="edexel.php" method="post">
             <table cellpadding="0" cellspacing="0" border="0" width="98%" align="center" class="main_list">
              <tr>
               <th align="center" valign="middle">&nbsp;'.$def_images_choice.'&nbsp;</th>
               <th colspan="2" align="center" valign="middle" width="99%">Название и описание файла</th>
              </tr>';

  for ( $i=0; $i<$results_amount; $i++ )

 {

       	$f_e = $db->fetcharray  ( $r_e );

        $files_e = glob('../exel/'.$f_e['num'].'.*');

        if ($files_e[0]!='') $link_e = '<a href="../exel/'.$files_e[0].'">'; else $link_e='<a href="#">';

        $fSize	= filesize($files_e[0]);
	$fSize	= round(($fSize / 1024),2) . ' KB';
        $ext = pathinfo('../exel/'.$files_e[0], PATHINFO_EXTENSION);

        $class_badre='badge-success';
        if ($ext=='zip') $class_badre='badge-warning';
        if ($ext=='rar') $class_badre='badge-info';

 ?>

     <tr>
      <td valign="middle" align="center">
       <input type="radio" name="seek" value="<? echo $f_e['num']; ?>" style="border:0px;" <? if ( $f_e['num'] == $_POST['seek'] ) echo "CHECKED"; ?>><br />
       <div style="padding:2px;"><span class="badge <? echo $class_badre; ?>"><? echo $ext; ?></span></div>
      </td>

 <?

  echo '<td  width="99%" align="left" valign="middle" class="slink"><span class="label label-info">'.undate($f_e['date'], $def_datetype).'</span> <b>'.$link_e.$f_e['item'].'</a></b> ('.$fSize.')
             <div style="padding:3px;">'.$f_e['message'].'</div>
       </td>
     </tr>';
 }

 ?>
 </table><br />

     <div style="text-align:center;"><input type="submit" name="edit_b" class="btn btn-warning" value="<? echo $def_offers_change; ?>"> <input type="submit" name="but" value="<? echo $def_images_delete; ?>" style="color: #FFFFFF; background: #D55454;"></div>
     <input type="hidden" name="delete" value="true"><br />
     <input type="hidden" name="id" value="<? echo $idident; ?>" />
 </form>

 <?
 table_fdata_top ($def_item_form_data);

 echo '<form action="edexel.php" method="post" enctype="multipart/form-data">
     <table cellpadding="3" cellspacing="3" border="0" width="100%" align="center">
           <tr>
            <td align="right" width="80%">
          '.$def_exel_item.': <span style="color:#FF0000;">*</span> <input type="text" name="item" size="45" maxlength="100" value="'.$item.'" /><br /><br />
          '.$def_exel_description.': &nbsp;&nbsp;<textarea name="message" cols="45" rows="5" style="width:300px; height:100px;">'.$message.'</textarea><br /><br />
          '.$def_exel_fileupload.' ('.$type_ext.' max '.$def_exel_pic_size.' Байт):
  <br /> <br />
 	  <input type="file" name="img1" />
  <br />';
 echo '</td></tr>';
 echo '<tr>
        <td align="center" colspan="3">';
 
if ($edit_price) {
  echo '<input type="submit" name="but"  class="btn btn-warning" value="'.$def_images_change.'"><input type="hidden" name="id" value="'.$idident.'" />
        <input type="hidden" name="edit" value="true"><input type="hidden" name="changed" value="true"><input type="hidden" name="seek" value="'.$seek.'">';
} else {
  echo '<input type="submit" name="but"  class="btn btn-danger" value="'.$def_images_add.'">
        <input type="hidden" name="changed" value="true"><input type="hidden" name="id" value="'.$idident.'" />';
} 
 
 echo '
          <br />';
 echo ' </td>
       </tr>';
 echo '</table>
       </form>
       <br />';

 table_fdata_bottom();

 require_once 'template/footer.php';

?>
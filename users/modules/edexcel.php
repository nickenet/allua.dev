<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: edexcel.php
-----------------------------------------------------
 Назначение: Excel прайсы
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$fileExt = explode("#", $def_excel_ext);
$type_ext =  str_replace("#", ", ", $def_excel_ext);
$type_ext = '<strong>'.$type_ext.'</strong>';
if (isset($_POST['seek'])) $_POST['seek']=intval($_POST['seek']);
if (isset($_POST['seek'])) $_POST['seek']=intval($_POST['seek']);

	if ( $_POST['changed'] == "true" )
	{
		$item = safeHTML ($_POST['item']);
		$message = safeHTML ($_POST['message']);
                $message = isb_sub($message,$def_image_descr_size);
		$images = intval($f['exel']);

		$firmselec = intval($f['selector']);

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

                                $_POST['seek'] = mysql_insert_id();
                            } else $over = "Добавить прайс нельзя! Ваш лимит закончен!<br> К загрузке допускается - $images прайсов!";
                        } else
                        {
                            $date = date ( "Y-m-d" );
                            $post_seek=intval($_POST['seek']);
                            $db->query  ( "UPDATE $db_exelp SET item='$item', date='$date', message='$message' WHERE num='$post_seek' and firmselector='$firmselec'" );
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
				}

				else

				{
					$upload = $def_specify_file_exel;
                                        $post_seek=intval($_POST['seek']);
					@$db->query  ("DELETE FROM $db_exelp where num = '$post_seek'");
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

                        @unlink ( "../exel/$_POST[seek].$value_ext" );

                    }
			$post_seek=intval($_POST['seek']);
			$db->query  ( "DELETE FROM $db_exelp WHERE num='$post_seek' and firmselector='$f[selector]'" )
			or die ( "ERROR011: mySQL error, can't delete from EXCEL. (edexel.php)" );
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

                 if ( isset ( $over ) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$over.'</div>';

                 if ( isset ( $empty ) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$empty.'</div>';

                 if ( isset ( $upload ) ) echo '<div class="alert alert-success">'.$upload.'</div>';
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Прайс-листы</li>
            <li class="TabbedPanelsTab" tabindex="0">Допустимые параметры файла</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Прайс-листы</span></td>
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

$firmsel = intval($f['selector']);
		
		$r_e = $db->query  ( "SELECT * FROM $db_exelp WHERE firmselector='$firmsel' ORDER BY num" );
		@$results_amount = mysql_num_rows ( $r_e );
		$pricelines = $f['exel'];
                $free = $pricelines - $results_amount;

 ?>
                       
 <form action="?REQ=authorize&mod=edexcel" method="post">
             <table cellpadding="2" cellspacing="1" border="0" width="100%">
<?

for ( $i=0; $i<$results_amount; $i++ ) {

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

     <tr class="thumbnail">
      <td valign="middle" align="center" width="60">
       <input type="radio" name="seek" value="<? echo $f_e['num'];?>" style="border:0px;" <? if ( $f_e['num'] == $_POST['seek'] ) echo "CHECKED"; ?>><br>
       <span class="badge <? echo $class_badre; ?>"><? echo $ext; ?></span>
      </td>

 <?
 echo '<td align="left" valign="middle"><span class="label label-info">'.undate($f_e['date'], $def_datetype).'</span> <b>'.$link_e.$f_e['item'].'</a></b> ('.$fSize.')
             <div class="txt" style="padding:3px;">'.$f_e['message'].'</div>
       </td>
     </tr>
   <tr>
    <td colspan="2" align="center"></td>
  </tr>';
}

?>

 </table>
     <br><div style="text-align:center;"><input type="submit" name="edit_b" class="btn btn-warning" value="<? echo $def_offers_change; ?>"> <input type="submit" name="but" class="btn btn-danger" value="<? echo $def_images_delete; ?>"></div>
     <input type="hidden" name="delete" value="true">
 </form>
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
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Загрузить / Обновить файл</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont" align="center">
<?

if (  $f['exel'] != '0' ) {

echo '<div class="alert alert-info" style="width:220px;">Допустимо всего: <b>'.$pricelines.'</b><br>( Осталось: '.$free.', использовано: '.$results_amount.')</div>';

echo '<form action="?REQ=authorize&mod=edexcel" method="post" enctype="multipart/form-data">';
 
echo '
<table border="0" cellspacing="1" cellpadding="1" align="right">
  <tr>
    <td align="right">'.$def_exel_item.': <font color="red">*</font></td>
    <td align="left" width="310"><input type="text" name="item" value="'.$item.'" size="45" maxlength="100"></td>
  </tr>
  <tr>
    <td align="right">'.$def_exel_description.':</td>
    <td align="left" width="310"><textarea name="message" cols="45" rows="5" style="width:300px; height:100px;">'.$message.'</textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center">Добавить файл<br>
        <input type="file" name="img1"><br><br>';

if ($edit_price) {
  echo '<input type="submit" name="but"  class="btn btn-warning" value="'.$def_images_change.'">
        <input type="hidden" name="edit" value="true"><input type="hidden" name="changed" value="true"><input type="hidden" name="seek" value="'.$seek.'">';
} else {
  echo '<input type="submit" name="but"  class="btn btn-warning" value="'.$def_images_add.'">
        <input type="hidden" name="changed" value="true">';
}
echo '
    </td>
  </tr>
</table>';

 echo '</form>';

}

else

{

?>

<strong class="id_url">Обратите внимание!</strong><br>
Данный раздел личного кабинета работает в демонстрационном режиме.<br> Для того, чтобы полноценно воспользоваться возможностями этого сервиса вам необходимо активировать другой тарифный план.<br> 
Сравнительную таблицу тарифных планов можно посмотреть по этой <a href="<? echo "$def_mainlocation"; ?>/compare.php">ссылке</a>.<br><br>

<?			
			
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
                  <td width="180" align="right">Размер файла (байты):</td>
                  <td><? echo "$def_exel_pic_size"; ?></td>
                </tr>
                <tr>
                  <td width="180" align="right">Типы файлов:</td>
                  <td><? echo '<strong>'.$type_ext.'</strong>'; ?>
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
            <? echo $help_edexcel; ?>
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
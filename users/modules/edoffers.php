<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: edoffers.php
-----------------------------------------------------
 Назначение: Продукция и услуги
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$flag = $f['flag'];
if (isset($_POST['seek'])) $_POST['seek']=intval($_POST['seek']);
if (isset($_GET['seek'])) $_POST['seek']=intval($_GET['seek']);

	if ( ( $_POST["do"] == "Загрузить" ) and ( isset ( $_POST["seek"] ) ) )

	{


		if ( empty ( $_FILES['img1']['tmp_name'] ))

		{
			$upload = "Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.";
		}

		if ( filesize ( $_FILES['img1']['tmp_name'] )>$def_offer_pic_size )

		{
			$upload = "Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.";
		}

		$f_FOTO = substr($_FILES['img1']['name'], -4);

		if ( !in_array($f_FOTO, array('.jpg', '.JPG', 'jpeg', 'JPEG'))) $upload = "Ошибочное расширение.<br> Используйте файлы только .jpg расширением!";				
				

			// Оптимизация рисунка

			
			if (!isset($upload) )

			{

				if ( $_FILES['img1']['tmp_name'] )

				{
					chmod ( $_FILES['img1']['tmp_name'], 0777 )
					or die ( "ERROR007: Can't change file permission. (edoffer.php) ");

					$type = "jpg";					
					
					@unlink ( ".././offer/$_POST[seek].gif" );
					@unlink ( ".././offer/$_POST[seek].jpg" );
					@unlink ( ".././offer/$_POST[seek].png" );

					@unlink ( ".././offer/$_POST[seek]-small.gif" );
					@unlink ( ".././offer/$_POST[seek]-small.jpg" );
					@unlink ( ".././offer/$_POST[seek]-small.png" );

					copy ( $_FILES['img1']['tmp_name'], ".././offer/$_POST[seek].$type" )
						or $upload = $def_imagespic_error;

					chmod ( ".././offer/$_POST[seek].$type", 0777 )
					or die ( "ERROR008: Can't change file permission. (edoffer.php) ");

					$type = ".jpg";

					$out = 'imagejpeg';
						$q = 100;

					$img = imagecreatefromstring( file_get_contents('../offer/'.$_POST[seek].$type) );
					$w = imagesx($img);
					$h = imagesy($img);
					$k = $def_offer_thumb_width / $w;
					$img2 = imagecreatetruecolor($w * $k, $h * $k);
					imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
					$out($img2, '../offer/'.$_POST[seek].'-small'.$type, $q);
				
					if ($w > $def_offer_pic_width)
					{
						$k = $def_offer_pic_width / $w;
						$img2 = imagecreatetruecolor($w * $k, $h * $k);
						imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
						$out($img2, '../offer/'.$_POST[seek].$type, $q);
						$w *= $k;
						$h *= $k;
						$img = $img2;
					}

					if ($def_offer_wattermark == 'YES')
					{
						$img2 = imagecreatefrompng('../foto/_watermark.png');
						$w_ = imagesx($img2);
						$h_ = imagesy($img2);
						imagecopyresampled($img, $img2, $w - $w_, $h - $h_, 0, 0, $w_, $h_, $w_, $h_);
						$out($img, '../offer/'.$_POST[seek].$type, $q);
					}

					$upload = $def_images_pic_ok;
				}
			}
		}
	
	if (( $_REQUEST["changed"] == "true" ) and (!isset ( $upload )))

	{
		$item = safeHTML ($_POST["item"]);
                $message = safe_business($flag, $_POST['message']);
		$quantity = safeHTML ($_POST["quantity"]);
		$packaging = safeHTML ($_POST["packaging"]);
		$price = safeHTML ($_POST["price"]);

		$offers = $f["prices"];
		$firmselec = $f["selector"];
		$type = safeHTML($_POST["type"]);
		$period = safeHTML($_POST["period"]);
                $post_seek=intval($_POST['seek']);

		if ( $f["prices"] == '0' )

		{
			echo "ERROR009: No products and services available for this listing. (edoffers.php)";
			$db->close();
			exit();
		}

		if ( ( empty ( $item ) ) and ( $_POST["but"] != "$def_offers_delete" ) and ( $_POST["but"] != "$def_offers_edit_but" ) and ( $_POST["do"] != "Upload" ) and (empty($_GET['set'])) )

		{
			$empty = $def_offers_empty;
		}

		// *********************************************************

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_add" ) )

		{

			$r = $db->query  ( "SELECT * FROM $db_offers WHERE firmselector = '$firmselec'" );
			@$results_amount=mysql_num_rows($r);
			@$db->freeresult ($r);

			if ( $results_amount <> $offers )

			{
				$date = date ( "Y-m-d" );

				$db->query  ( "INSERT INTO $db_offers (firmselector, item, date, type, message, quantity, packaging, price, period) VALUES ('$firmselec', '$item', '$date', '$type', '$message', '$quantity', '$packaging', '$price', '$period')" )
				or die ( "ERROR010: mySQL error, cant insert into OFFERS. (edoffers.php)" );
                                unset($post_seek, $_POST['seek']);
			}

			else

			{
				$over = "Добавить продукцию или услугу нельзя! Ваш лимит закончен!<br> К загрузке допускается - $offers продукций или услуг!";
			}

		}

		// *********************************************************

		if ( ( empty ( $empty ) ) and (( $_POST["but"] == "$def_offers_delete" ) or ($_GET['set']=='delete')) )

		{
			@unlink ( ".././offer/$_POST[seek].gif" );
			@unlink ( ".././offer/$_POST[seek].bmp" );
			@unlink ( ".././offer/$_POST[seek].jpg" );
			@unlink ( ".././offer/$_POST[seek].png" );

			@unlink ( ".././offer/$_POST[seek]-small.gif" );
			@unlink ( ".././offer/$_POST[seek]-small.bmp" );
			@unlink ( ".././offer/$_POST[seek]-small.jpg" );
			@unlink ( ".././offer/$_POST[seek]-small.png" );
                        
                        $post_seek=intval($_POST['seek']);

			$db->query  ( "DELETE FROM $db_offers WHERE num='$post_seek' and firmselector='$firmselec'" )
			or die ( "ERROR011: mySQL error, can't delete from OFFERS. (edoffers.php)" );

                        unset($post_seek, $_POST['seek']);
		}

		// *********************************************************

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_change" ))

		{
			$date = date ( "Y-m-d" );
                        
                        $post_seek=intval($_POST['seek']);
			$db->query  ( "UPDATE $db_offers SET item='$item', date='$date', type=$type, message='$message', quantity='$quantity', packaging='$packaging', price='$price', period='$period' WHERE num='$post_seek' and firmselector='$firmselec'" )
			or die ( "ERROR012: mySQL error, can't update OFFERS. (edoffers.php)" );
                        
                         unset($post_seek, $_POST['seek']);
		}
	}

                 if ( isset ( $over ) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$over.'</div>';

                 if ( isset ( $empty ) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$empty.'</div>';

                 if ( isset ( $upload ) ) echo '<div class="alert alert-success">'.$upload.'</div>';
                 
    $firmsel = intval($f["selector"]);
    $pages=7;

    $r=$db->query ("SELECT * FROM $db_offers WHERE firmselector='$firmsel' ORDER BY num") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $r );
    @$results_amount_all = mysql_num_rows ( $r );

    if ($results_amount>$pages) {

    		$page1=intval($_POST['page'])*$pages;

    $r=$db->query ("SELECT * FROM $db_offers WHERE firmselector='$firmsel' ORDER BY num LIMIT $page1, $pages") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $r );
    }

?>

<script src="<? echo $def_mainlocation; ?>/includes/js/jquery.jeditable.mini.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/includes/js/jquery.ajaxfileupload.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/includes/js/jquery.jeditable.ajaxupload.js" type="text/javascript"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Продукция и услуги</li>
            <li class="TabbedPanelsTab" tabindex="0">Допустимые параметры изображений</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Продукция и услуги</span></td>
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
<form action="?REQ=authorize&mod=edoffers" method="post">
  Страница : <select name="page" onchange="this.form.submit();">
<?
                $z=0;
                $xp1=0;
			for($x=0; $x<$results_amount_all; $x=$x+$pages)
			{
                            $xp1=$z+1;
				if ($z == $_POST['page']) {echo '<option value="'.intval($_POST['page']).'" selected>'.$xp1.'</option>'; } else {echo '<option value="'.$z.'">'.$xp1.'</option>';}
                                $z++;
			}
?>
    </select>
</form>
</div><br>
<?
}

if (($_POST["but"] == "$def_offers_edit_but") or ($_GET['set']=='edit'))

	{
          
                $post_seek=intval($_POST['seek']);
		$re = $db->query  ( "SELECT * FROM $db_offers WHERE num='$post_seek' and firmselector='$firmsel'");
		$fe = $db->fetcharray  ( $re );

		$form_item = $fe[item];
		$form_type = $fe[type];
		$form_message = $fe[message];
		$form_quantity = $fe[quantity];
		$form_packaging = $fe[packaging];
		$form_price = $fe[price];
		$form_period = $fe[period];
	}


 $pricelines = $f[prices];

 $free = $pricelines - $results_amount_all;

 echo '<form action="?REQ=authorize&mod=edoffers" method="post" enctype="multipart/form-data">
             <table cellpadding="5" cellspacing="1" border="0" width="100%">';

 $banhandle = opendir ( ".././offer" );

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

 	$f_offer = $db->fetcharray  ( $r );

 	$pictext="";

 	for ( $aaa=0;$aaa<count ( $banbanner );$aaa++ )

 	{
 		$banrbanner = explode( ".", $banbanner[$aaa] );

 		if ( $banrbanner[0] == $f_offer[num] )

 		$pictext = '<img src=".././offer/'.$f_offer['num'].'-small.jpg" alt="">';
 	}

 	$type_offer = "";

 	if ( $f_offer["type"] == 1 ) $type_offer = '<span class="label label-success">'.$def_offer_1.'</span>';
 	if ( $f_offer["type"] == 2 ) $type_offer = '<span class="label label-important">'.$def_offer_2.'</span>';
 	if ( $f_offer["type"] == 3 ) $type_offer = '<span class="label label-warning">'.$def_offer_3.'</span>';

 ?>

     <tr class="thumbnail">
      <td  align="center" >
       <div style="padding:3px;"><a href="?REQ=authorize&&mod=edoffers&changed=true&set=delete&seek=<?=$f_offer['num'];?>" title="Удалить" class="icon-remove"></a></div>
       <input type="radio" name="seek" value="<? echo $f_offer['num']; ?>" style="border:0px;" <? if ( $f_offer['num'] == $_POST['seek'] ) echo "CHECKED"; ?>>
       <div style="padding:3px;"><a href="?REQ=authorize&&mod=edoffers&changed=true&set=edit&seek=<?=$f_offer['num'];?>#form" title="Редактировать" class="icon-pencil"></a></div>
      </td>

 <?


 if ($pictext=="") { $procent_img=0; $pictext='<img src="'.$def_mainlocation.'/users/template/images/nofoto.png" alt="Нет изображения" title="Нет изображения">'; } else $procent_img=20;

 $widht_table_img=$def_offer_thumb_width+20;

 echo '<td align="left" valign="middle" width="'.$widht_table_img.'" class="imgalert">'.$pictext.'</td>';

 $date_day = date ( "d" );
 $date_month = date ( "m" );
 $date_year = date ( "Y" );

 list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $f_offer["date"] );

 $first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
 $second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

 if ( $second_date > $first_date ) $days = $second_date-$first_date;
 else $days = $first_date-$second_date;

 $days_result = round( $f_offer[period] - ( ( $days ) / ( 60 * 60 * 24 ) ) );

 if ($f_offer['price']=='') { $procent_cena=0; $f_offer['price']='Не указана'; } else $procent_cena=20;

                  // Показатель
                $fx_proc=strlen(strip_tags($f_offer['message'])); $procent_txt=round(($fx_proc*60)/300); if ($procent_txt>60) $procent_txt=60;
                $procent = round(($procent_txt+$procent_img+$procent_cena),0);

                if ($f_offer['period']==0) { $f_offer['period']=$def_period_offers; $days_result=''; }

 echo '<td  align="left" valign="middle">
             <div style="padding: 3px;">'.$type_offer.' <font size="1" color="#666666">Дата: '.undate($f_offer[date], $def_datetype).' | Период - '.$f_offer['period'].' | Осталось - '.$days_result.'</font></div>
             <div style="padding: 3px;"><b><a href="'.$def_mainlocation.'/alloffers.php?idfull='.$f_offer['firmselector'].'&full='.$f_offer['num'].'" target="_blank">'.$f_offer['item'].'</a></b></div>
             <div class="txt" style="padding:5px;">'.isb_sub(strip_tags(stripcslashes($f_offer[message]),'<li><br><br />'),$def_short_message_offers).'</div>
             <div style="text-align: right; padding: 3px;">Цена: <span id="'.$f_offer['num'].'" class="edit_p">'.$f_offer['price'].'</span><span class="icon-pencil"></span></div>
             <div style="width: 150px; padding:3px;">
                <div class="progress_mini progress-info progress-striped">
                <span class="txt tooltip-main well"><a title="<b>Показатель качества = '.$procent.'%</b><br>Знаков в описании - '.$fx_proc.' ('.$procent_txt.'%) + '.$procent_img.'% за изображение и + '.$procent_cena.'% за цену."  rel="tooltip" href="#">
                    <div class="bar" style="width:'.$procent.'%;"></div>
                </a></span>
                </div>
             </div>
       </td>
      </tr>
<tr><td colspan="3" align="center"></td></tr>
';

}

echo "</table><br>
    <input type=\"submit\" name=\"but\" value=\"$def_offers_delete\" class=\"btn btn-danger\">
    &nbsp;<input type=\"submit\" name=\"but\" value=\"$def_offers_edit_but\" class=\"btn btn-warning\">
    <input type=\"hidden\" name=\"changed\" value=\"true\">
";
echo '<input type="hidden" name="page" value="'.intval($_POST['page']).'">';
if ( ( ( $flag == "D" ) and ( $def_D_offerIM == "YES" ) ) or ( ( $flag == "C" ) and ( $def_C_offerIM == "YES" ) ) or ( ( $flag == "B" ) and ( $def_B_offerIM == "YES" ) ) or ( ( $flag == "A" ) and ( $def_A_offerIM == "YES" ) ) )
{
 echo '<div style="padding: 10px; margin: 10px; width: 390px;" class="imgalert">[<span class="txt tooltip-main well"><a title="Выберите позицию из списка и добавьте, либо обновите изображение." rel="tooltip" href="#">?</a></span>]
       Добавить / Обновить  изображение<br />
       <input type="file" NAME="img1" SIZE="25">
       <input type="submit" NAME="do" value="Загрузить" class="btn btn-success"></div>';
 }
echo '</form>';

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

if (  $f_offer["prices"] != '0' )

{

 echo '<div class="alert alert-info" style="width:220px;">Допустимо всего: <b>'.$pricelines.'</b><br>(Осталось: '.$free.', использовано: '.$results_amount_all.')</div>';
 echo '<a name="form"></a><form action="?REQ=authorize&mod=edoffers" method="post" enctype="multipart/form-data">';
 echo "<table cellpadding=\"5\" cellspacing=\"1\" border=\"0\" width=\"100%\">
           <tr>
            <td align=\"right\" width=\"80%\">$def_offers_type:<font color=red>*</font>
            <SELECT NAME=\"type\" style=\"width:286px;\">";
 ?>

  <OPTION VALUE="1" <?php if ( $form_type == "1" ) echo "SELECTED"; ?>><?php echo "$def_offer_1"; ?>
  <OPTION VALUE="2" <?php if ( $form_type == "2" ) echo "SELECTED"; ?>><?php echo "$def_offer_2"; ?>
  <OPTION VALUE="3" <?php if ( $form_type == "3" ) echo "SELECTED"; ?>><?php echo "$def_offer_3"; ?>

 <?

 $db->freeresult ( $r );

 // $form_message = str_replace("<br>", "\n", $form_message);

 require ('../includes/editor/tiny_'.$f['flag'].'.php');

 echo " </SELECT><br>

          $def_offers_item: <font color=red>*</font><input type=\"text\" name=\"item\" value=\"$form_item\" size=\"45\" maxlength=\"100\"><br>
          $def_offers_description: &nbsp;&nbsp;<textarea id=\"business\" class=\"business\" name=\"message\" cols=\"45\" rows=\"5\" style=\"width:400px; height:200px;\">$form_message</textarea><br>
          $def_offers_quantity: &nbsp;&nbsp;<input type=\"text\" name=\"quantity\" value=\"$form_quantity\" size=\"45\" maxlength=\"100\"><br>
          $def_offers_packaging: &nbsp;&nbsp;<input type=\"text\" name=\"packaging\" value=\"$form_packaging\" size=\"45\" maxlength=\"100\"><br>
          $def_validity_period: &nbsp;&nbsp;<select name=\"period\">

       ";

 $periods = explode("#", $def_offer_expiration);

 for ($a=0;$a<count($periods);$a++)
 {
     if ($periods[$a]==0) $vivod_period=$def_period_offers; else $vivod_period=$periods[$a];
 	if ($form_period == $periods[$a]) echo '<option value="'.$periods[$a].'" SELECTED>'.$vivod_period.'</option>';
 	else echo '<option value="'.$periods[$a].'">'.$vivod_period.'</option>';
 }

 echo "</select> $def_days";


 echo"</td>";

 echo "<td bgColor=\"$def_form_back_color\" align=\"center\" width=\"20%\">
         $def_offers_price:<br>
         <input type=\"text\" maxlength=\"20\" name=\"price\" value=\"$form_price\" size=\"7\" value=\"0\">
        </td></tr>";

 echo "<tr>
         <td align=\"center\" colspan=\"3\">
          <input type=\"hidden\" name=\"changed\" value=\"true\">
          <input type=\"hidden\" name=\"seek\" value=\"$post_seek\">";
 echo '<input type="hidden" name="page" value="'.intval($_POST['page']).'">';
 if (!isset($post_seek)) echo "<input type=\"submit\" name=\"but\" value=\"$def_offers_add\" class=\"btn btn-warning\">";
 else echo "<input type=\"submit\" name=\"but\" value=\"$def_offers_change\" class=\"btn btn-warning\">";

 echo "</td>
       </tr>
      </table>";
 echo "</form>";
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
                  <td><? $size_img=$def_offer_pic_size/1000000; echo "$size_img Мб"; ?></td>
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
            <? echo $help_edoffers; ?>
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
$(function() {
     $('.edit_p').editable('inc/ajaxjt.php', {
         type      : 'text',
         cancel    : 'Отменить',
         submit    : 'OK',
         indicator : '<img src="../images/go.gif">',
         tooltip   : 'Нажмите для изменения...'
     });
 });
</script>
<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: edoffers.php
-----------------------------------------------------
 Назначение: Редактирование продукции и услуг
=====================================================
*/

@ $randomized = rand ( 0, 9999 );

session_start();

require_once './defaults.php';

$idident=intval($_REQUEST['id']);
if (isset($_POST['idident'])) $idident=intval($_REQUEST['idident']);

$help_section = (string)$edoffers_help;

$title_cp = $def_offers_edit.' - ';
$speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | <a href="edoffers.php?id='.$idident.'">'.$def_offers_edit.'</a>';

check_login_cp('1_0','edoffers.php?id='.$idident);

require_once 'template/header.php';

$r=$db->query ("select * from $db_users where selector='$idident'") or die ("mySQL error!");

$f=$db->fetcharray ($r);

	// *********************************************************

	if ( ( $_POST["do"] == "$def_upload" ) and ( isset ( $_POST["seek"] ) ) )

	{

		if ( empty ( $_FILES['img1']['tmp_name'] ))

		{
			$upload = (string)$def_admin_error_file;
		}

		if ( filesize ( $_FILES['img1']['tmp_name'] )>$def_offer_pic_size )

		{
			$upload = (string)$def_admin_error_file;
		}

		$f_FOTO = substr($_FILES['img1']['name'], -4);

		if ( !in_array($f_FOTO, array('.jpg', '.JPG', 'jpeg', 'JPEG'))) $upload = (string)$def_admin_error_jpg_file;
	
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
						or $upload = (string)$def_imagespic_error;

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

					$upload = (string)$def_images_pic_ok;
				}
			}
		}

	if (( $_POST["changed"] == "true" ) and (!isset ( $upload )))

	{
		$item = safeHTML ($_POST["item"]);
		$message = safe_business($f['flag'], $_POST['message']);
		$quantity = safeHTML ($_POST["quantity"]);
		$packaging = safeHTML ($_POST["packaging"]);
		$price = safeHTML ($_POST["price"]);

		$offers = $f["prices"];
		$firmselec = $f["selector"];
		$type = $_POST["type"];
		$period = $_POST["period"];

		if ( $f["prices"] == '0' )

		{
			echo "ERROR009: No products and services available for this listing. (edoffers.php)";
			mysql_close();
			exit();
		}

		if ( ( empty ( $item ) ) and ( $_POST["but"] != "$def_offers_delete" ) and ( $_POST["but"] != "$def_offers_edit_but" ) and ( $_POST["do"] != "Upload" ) )

		{
			$empty = $def_offers_empty;
		}

		// *********************************************************

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_add" ) )

		{

			$r = $db->query  ( "SELECT * FROM $db_offers WHERE firmselector = '$idident'" );
			@$results_amount=mysql_num_rows($r);
			@mysql_free_result($r);

			if ( $results_amount <> $offers )

			{
				$date = date ( "Y-m-d" );

				$db->query  ( "INSERT INTO $db_offers (firmselector, item, date, type, message, quantity, packaging, price, period) VALUES ('$idident', '$item', '$date', '$type', '$message', '$quantity', '$packaging', '$price', '$period')" )
				or die ( "ERROR010: mySQL error, cant insert into OFFERS. (edoffers.php)" );

                                logsto("Добавлена продукция или услуга компании <b>$f[firmname]</b> (id=$f[selector])");
			}

			else
			{
				$over = $def_offers_limit.' '.$offers;
			}
		}

		// *********************************************************

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_delete" ) )

		{
			@unlink ( "../offer/$_POST[seek].gif" );
			@unlink ( "../offer/$_POST[seek].bmp" );
			@unlink ( "../offer/$_POST[seek].jpg" );
			@unlink ( "../offer/$_POST[seek].png" );

			@unlink ( "../offer/$_POST[seek]-small.gif" );
			@unlink ( "../offer/$_POST[seek]-small.bmp" );
			@unlink ( "../offer/$_POST[seek]-small.jpg" );
			@unlink ( "../offer/$_POST[seek]-small.png" );

			$db->query  ( "DELETE FROM $db_offers WHERE num='$_POST[seek]' and firmselector='$firmselec'" )
			or die ( "ERROR011: mySQL error, can't delete from OFFERS. (edoffers.php)" );

                        logsto("Удалена продукция или услуга ($_POST[seek]) компании <b>$f[firmname]</b> (id=$f[selector])");
		}

		// *********************************************************

		if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_change" ) )

		{
			$date = date ( "Y-m-d" );

			if (!$_POST['seek']) $_POST['seek']=$_POST['seek_page'];

			$db->query  ( "UPDATE $db_offers SET item='$item', date='$date', type=$type, message='$message', quantity='$quantity', packaging='$packaging', price='$price', period='$period' WHERE num='$_POST[seek]' and firmselector='$idident'" )
			or die ( "ERROR012: mySQL error, can't update OFFERS. (edoffers.php)" );

                        logsto("Изменена продукция или услуга ($_POST[seek]) компании <b>$f[firmname]</b> (id=$f[selector])");
		}
	}

// *********************************************************

    $pages=7;

    $r=$db->query ("SELECT * FROM $db_offers WHERE firmselector='$idident' ORDER BY num") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $r );
    @$results_amount_all = mysql_num_rows ( $r );

    if ($results_amount>$pages) {

    		$page1=intval($_POST['page'])*$pages;

    $r=$db->query ("SELECT * FROM $db_offers WHERE firmselector='$idident' ORDER BY num LIMIT $page1, $pages") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $r );
    }

	if ($_POST["but"] == "$def_offers_edit_but")

	{

		$re = $db->query  ( "SELECT * FROM $db_offers WHERE num='$_POST[seek]' and firmselector='$idident'");
		$fe = $db->fetcharray  ( $re );

		$form_item = $fe[item];
		$form_type = $fe[type];
		$form_message = $fe[message];
		$form_quantity = $fe[quantity];
		$form_packaging = $fe[packaging];
		$form_price = $fe[price];
		$form_period = $fe[period];

	}

 table_item_top ($def_offers_edit,'offers.png');

 @$results_amount = mysql_num_rows ( $r );

 $pricelines = $f[prices];

 $free = $pricelines - $results_amount_all;

 echo '&nbsp;'.$def_offers.': <b>'.$pricelines.'</b> ('.$def_free.': '.$free.' - '.$def_used.': '.$results_amount_all.')<br /><br />';

if ($results_amount_all > $pages){ ?>
<div style="text-align:right; padding-right:20px;">
<form action="edoffers.php?id=<?=$idident; ?>" method="post">
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

 if (!empty ($empty)) msg_text("80%",$def_admin_message_mess,$def_offers_empty);

 if (isset($upload))  msg_text("80%",$def_admin_message_mess,$upload);

 echo '<form action="edoffers.php" method="post" enctype="multipart/form-data">
             <table cellpadding="0" cellspacing="0" border="0" width="98%" align="center">
              <tr>
               <td align="middle" valign="middle" width="5%" id="table_files">
                '.$def_offers_choice.'
               </td>
               <td colspan="2" align="middle" valign="middle" width="83%" id="table_files_c">
                '.$def_offers_item.'
               </td>
               <td align="middle" valign="middle" width="10%" id="table_files">
                '.$def_offers_price.'
               </td>
              </tr>';

 $banhandle = opendir ( "../offer" );

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
 		$pictext = "<img src=\"../offer/$f[num]-small.jpg?$randomized\"  alt=\"$f[item]\" />";
 	}

 	$type_offer = "";

 	if ( $f["type"] == 1 ) $type_offer = "$def_offer_1";
 	if ( $f["type"] == 2 ) $type_offer = "$def_offer_2";
 	if ( $f["type"] == 3 ) $type_offer = "$def_offer_3";

 ?>

     <tr>
      <td valign="middle" align="center" id="table_files_i">
       <input type="radio" name="seek" value="<?php echo $f[num];?>" style="border:0;" <?php if ( $f[num] == $_POST['seek'] ) echo "CHECKED"; ?>>
      </td>

 <?php

 $cols="";

 $widht_table_img=$def_offer_pic_width+20;

 if ($pictext != "")

 echo '<td align="left" valign="middle" width="'.$widht_table_img.'" id="table_files_i_c">'.$pictext.'<br />
      </td>';
 else

 $cols = "colspan=2";

 $date_day = date ( "d" );
 $date_month = date ( "m" );
 $date_year = date ( "Y" );

 list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $f["date"] );

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

 $days_result = round ( $f[period] - ( ( $days ) / ( 60 * 60 * 24 ) ) );

 if ($f['period']==0) { $f['period']=$def_period_offers; $days_result=''; }

 echo '<td  width="80%" '.$cols.' align="left" valign="middle" id="table_files_i_c">
            <b><a href="'.$def_mainlocation.'/alloffers.php?idfull='.$f['firmselector'].'&full='.$f['num'].'" target="_blank">'.$f[item].'</a></b> ('.$type_offer.')<br />'.$def_validity_period.': '.$f[period].' '.$def_days.' / '.$days_result.' '.$def_days_left.' '.$def_since.' '.undate($f[date], $def_datetype).'
             <br /><br />'.$def_offers_description.': '.isb_sub(strip_tags(stripcslashes($f[message]),'<li><br><br />'),$def_short_message_offers).'
             <br /><br />'.$def_offers_quantity.': '.$f[quantity].'
             <br />'.$def_offers_packaging.': '.$f[packaging].'<br /><br />
           </td>';

 echo '<td align="left" valign="middle" id="table_files_i">'.$f[price].'<br /></td>
       </tr>';
 }
 echo '</table><br />';

table_fdata_top ($def_item_form_data);

require ('../includes/editor/tiny_A.php'); // Подключаем редактор

 echo '<br />
          <table cellpadding="3" cellspacing="3" border="0" width="97%" align="center">
           <tr>
            <td align="right" width="80%">'.$def_offers_type.':
            <span style="color:#FF0000;">*</span>
            <SELECT NAME="type" style="width:300px;">
       ';
 ?>

  <OPTION VALUE="1" <?php if ( $form_type == "1" ) echo "SELECTED"; ?>><?php echo $def_offer_1; ?>
  <OPTION VALUE="2" <?php if ( $form_type == "2" ) echo "SELECTED"; ?>><?php echo $def_offer_2; ?>
  <OPTION VALUE="3" <?php if ( $form_type == "3" ) echo "SELECTED"; ?>><?php echo $def_offer_3; ?>

 <?php

 mysql_free_result ( $r );

 // $form_message = str_replace("<br>", "\n", $form_message);

 echo ' </SELECT><br /><br />
          '.$def_offers_item.': <span style="color:#FF0000;">*</span> <input type="text" name="item" value="'.$form_item.'" size="45" maxlength="100" /><br /><br />
          '.$def_offers_description.': &nbsp;&nbsp;<textarea id="business" class="business" name="message" cols="45" rows="5" style="width:300px; height:100px;">'.$form_message.'</textarea><br /><br />
          '.$def_offers_quantity.': &nbsp;&nbsp;<input type="text" name="quantity" value="'.$form_quantity.'" size="45" maxlength="100" /><br /><br />
          '.$def_offers_packaging.': &nbsp;&nbsp;<input type="text" name="packaging" value="'.$form_packaging.'" size="45" maxlength="100" /><br /><br />
          '.$def_validity_period.': &nbsp;&nbsp;<select name="period">
       ';

 $periods = explode("#", $def_offer_expiration);

 for ($a=0;$a<count($periods);$a++)
 {
     if ($periods[$a]==0) $vivod_period=$def_period_offers; else $vivod_period=$periods[$a];
 	if ($form_period == $periods[$a]) echo '<option value="'.$periods[$a].'" SELECTED>'.$vivod_period.'</option>';
 	else echo '<option value="'.$periods[$a].'">'.$vivod_period.'</option>';
 }

 echo '</select> '.$def_days;
 echo '</td>';
 echo '<td align="center" width="20%">
         '.$def_offers_price.':<br />
         <input type="text" maxlength="10" name="price" value="'.$form_price.'" size="7" value="0" />
        </td></tr>';
 echo '<tr>
         <td align="center"  colspan="3">
          <input type="submit" name="but" value="'.$def_offers_add.'" />
    &nbsp;<input type="submit" name="but" value="'.$def_offers_delete.'" style="color: #FFFFFF; background: #D55454;" />
    &nbsp;<input type="submit" name="but" value="'.$def_offers_edit_but.'" />
    &nbsp;<input type="submit" name="but" value="'.$def_offers_change.'" />
          <input type="hidden" name="changed" value="true" /><input type="hidden" name="id" value="'.$idident.'" />
          <br />';
 echo '<br />
       '.$def_offers_imageupload.' (jpg, Допустимый размер: '.$def_offer_pic_size.' байты):<br /><br />
       <input type="file" NAME="img1" SIZE="25" />
       <input type="hidden" name="id" value="'.$idident.'" />
       <input type="submit" NAME="do" value="'.$def_upload.'" />
       ';
if ($form_item!='') echo '<input type="hidden" name="seek_page" value="'.$_POST[seek].'" />';
echo '<input type="hidden" name="page" value="'.$_POST[page].'" />';
 echo '</td>
      </tr>';
 echo '</table>
       </form>
      <br />';

table_fdata_bottom();

require_once 'template/footer.php';

?>
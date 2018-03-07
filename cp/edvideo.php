<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: edvideo.php
-----------------------------------------------------
 Назначение: Видеоролики
=====================================================
*/

@ $randomized = rand ( 0, 9999 );

session_start();

require_once './defaults.php';

$idident=intval($_REQUEST['id']);

if (isset($_POST['idident'])) $idident=intval($_REQUEST['idident']);

$help_section = (string)$video_help;

$title_cp = $def_admin_edit_video.' - ';

if (($_REQUEST['edit_full']=="true") and ($_POST["but"] != $def_images_delete)) {
    
    if ($_REQUEST['add']=='newvideo') { 
        $speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | <a href="edvideo.php?id='.$idident.'">'.$def_admin_edit_video.'</a> | <a href="edvideo.php?id='.$idident.'&add=newvideo&edit_full=true">'.$def_add_video_title.'</a>';
    } else {
        
    $post_seek = intval($_REQUEST['seek']);
    $seek_url='&seek='.$post_seek.'&edit_full=true';
    $speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | <a href="edvideo.php?id='.$idident.'">'.$def_admin_edit_video.'</a> | <a href="edvideo.php?id='.$idident.$seek_url.'">'.$def_add_video_full.'</a>';
    }
    
    
}  else {

$speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | <a href="edvideo.php?id='.$idident.$seek_url.'">'.$def_admin_edit_video.'</a>';

}

check_login_cp('1_0','edvideo.php?id='.$idident);

require_once 'template/header.php';

?>

<table width="100%" border="0">
  <tr>
      <td><img src="images/edvideo.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;<? echo $def_admin_edit_video; ?></span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3"><img src="images/button-l.gif" width="3" height="34"></td>
        <td background="images/button-b.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" /></td>
            <td width="150" class="vclass"><img src="images/news_plus.gif" width="31" height="31" align="absmiddle" /><a href="edvideo.php?id=<?=$idident; ?>&add=newvideo&edit_full=true">Добавить видеоролик</a></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>

<?

$r=$db->query ("select * from $db_users where selector='$idident'") or die ("mySQL error!");
$f=$db->fetcharray ($r);

                // Удаляем видеоролик
		if ( ( $_POST["but"] == "$def_images_delete" ) )

		{
                    
                    $post_seek = intval($_POST['seek']);
                    $db->query  ( "DELETE FROM $db_video WHERE num='$post_seek' and firmselector='$idident'" );
                    logsto("Удален видеоролик ($_POST[seek]) компании <b>$f[firmname]</b> (id=$idident)");
                        
		}

    // *********************************************************
    // редактируем видеоролик
    if (($_REQUEST['edit_full']=="true") and ($_POST["but"] != $def_images_delete)) {

                if ($_REQUEST['add']=='newvideo') {
                    
                $firmsel = intval($f['selector']);
                $r_v = $db->query  ( "SELECT * FROM $db_video WHERE firmselector='$firmsel'" );
                @$results_amount_all = mysql_num_rows ( $r_v ); 
                    
                    $pricelines = $f['video'];
                    $free = $pricelines - $results_amount_all;
                    if (($free==0) and ($free<0)) $error_add = 'Внимание! Превышен лимит добавления видеороликов!';
                    $full_edit='new';
                    $but_edit=$def_images_add;
                    $def_add_video_full = $def_add_video_title;
                    
                } else { 
                                    
                // Считываем ролик
                $post_seek = intval($_REQUEST['seek']);
                $r_e = $db->query  ( "SELECT * FROM $db_video WHERE num='$post_seek' and firmselector='$f[selector]' LIMIT 1" );
                $f_e = $db->fetcharray  ( $r_e );

                $form_num = $f_e['num'];
                $form_item = $f_e['item'];
                $form_urlv = stripcslashes($f_e['urlv']);
                $form_urlv = str_replace("&lt;", "<", $form_urlv);
                $form_urlv = str_replace("&gt;", ">", $form_urlv);
                $form_message = str_replace("<br>", "\n", $form_message);
                $form_full = stripcslashes($f_e['full']);
                $form_sort = $f_e['sort'];
                $form_name = $f_e['name'];
                $form_metakeywords = $f_e['metakeywords'];
                $form_metadescr = $f_e['metadescr'];
                $form_metatitle = $f_e['metatitle'];
                $full_edit='true';
                $but_edit=$def_images_edit_but;
                
                }
                
require ('../includes/editor/tiny_A.php'); // Подключаем редактор 

if (isset($error_add))  msg_text("80%",$def_admin_message_error,$error_add);
                
table_fdata_top ($def_add_video_full);
 
?>

<style type="text/css">
<!--
hr {
	border: 1px dotted #CCCCCC;
}
label.error {
	color: red;
        padding-left: 5px;
}
-->
</style>

<form action="edvideo.php" method="post">
<table width="978" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="253" align="right"><?=$def_video_item; ?>: <font color=red>*</font></td>
    <td width="725"><input type="text" name="item" size="45" value="<?=$form_item; ?>"></td>
  </tr>
  <tr>
    <td align="right"><?=$def_video_url; ?>: <font color=red>*</font></td>
    <td><textarea name="url" cols="45" rows="5" style="width:500px; height:100px;"><?=$form_urlv; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Краткое описание видеоролика:</td>
    <td><textarea name="message" cols="45" rows="5" style="width:500px; height:100px;"><?=$form_message; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Подробное описание видеоролика:</td>
    <td><textarea id="business" name="business" class="business" cols="20" rows="20" style="width:600px;"><?=$form_full; ?></textarea></td>
  </tr>
    <tr>
    <td align="right">Порядок сортировки:</td>
    <td><input type="text" name="sort" size="10" value="<?=$form_sort; ?>"></td>
  </tr>
  <td colspan="2"><hr /></td>
  <tr>
    <td align="right">Мета-тег &lt;title&gt;:</td>
    <td><input type="text" name="title" style="width:300px;" value="<? echo $form_metatitle; ?>"></td>
  </tr>
    <tr>
    <td align="right">Мета-тег description:</td>
    <td><input type="text" name="descr" maxlength="250" style="width:300px;" value="<? echo $form_metadescr; ?>"></td>
  </tr>
    <tr>
    <td align="right">Мета-тег keywords:</td>
    <td><textarea name="keywords" cols="20" rows="4" style="width:400px;"><? echo $form_metakeywords; ?></textarea></td>
  </tr>
    <tr>
    <td align="right">ЧПУ URL страницы:</td>
    <td><input type="text" name="url_seo" value="<? echo $form_name; ?>" style="width:300px;"></td>
  </tr>
</table>
    <div style="text-align: center; padding: 10px;">
        <input type="submit" name="but" style="color: #FFFFFF; background: #D55454;" value="<? echo $but_edit; ?>" />
<input type="hidden" name="changed" value="true" />
<input type="hidden" name="id" value="<? echo $idident; ?>" />
<input type="hidden" name="seek" value="<? echo $post_seek; ?>" />
<input type="hidden" name="full_edit" value="<? echo $full_edit; ?>" />
    </div>
</form>    

<?
 
table_fdata_bottom();

    } else {

    if ( $_POST["changed"] == "true" )

	{
		$item = safeHTML ($_POST['item']);

                // обрабатываем URL video
                if (( stripos(strtolower($_POST['url']),'iframe')===false) and ( stripos($_POST['url'],'object')===false)) {
                    $urlv = safeHTML($_POST['url']);
                }
                else {
                    $urlv = str_replace("<", "&lt;", $_POST['url']);
                    $urlv = str_replace(">", "&gt;", $urlv);
                    $urlv = addslashes($urlv);
                }

                if ( stripos($_POST['url'],'object')===true) {
                    $urlv=strtolower($_POST['url']);
                    $urlv = strip_tags($urlv, '<object><embed><param>');
                    $tag = '<object';
                    $urlv = substr($urlv, strpos($urlv, $tag));
                    $tag = '</object>';
                    $urlv = substr($urlv, 0, strpos($urlv, $tag) + strlen($tag));
                    $urlv=str_replace('http','video_yandex',$urlv);
                    $urlv = safeInfo($urlv);
                    $urlv = addslashes($urlv);
                }

                require_once '../includes/classes/video_firm.php';

                 $vl = new Fvideo();
                 $vl->link_video=stripcslashes($urlv);

                if (($vl->showVideo('video')==$def_error_video) and ($_POST["but"] != $def_images_delete)) $empty='Внимание! Код видеоролика или URL не верный!';

		$message = safeHTML (strip_tags($_POST["message"]));
		$video = $f["video"];

		$firmselec = $f["selector"];
                $business=safe_business('A', $_POST['business']);

		if ( $f["video"] == '0' )

		{
			echo "ERROR009: No video available for this listing. (edvideo.php)";
			$db->close();
			exit();
		}

                if (strlen($message)>strlen($business)) $full_meta = $message; else $full_meta = $business;

                if ($_POST['title']!='') $title_video = safeHTML($_POST['title']); else $title_video = $item;
                if ($_POST['descr']!='') $descr_video = safeHTML($_POST['descr']);
                else {
                    $descr_video = chek_meta($full_meta);
                    $descr_video = isb_sub($descr_video,200);
                }
                if ($_POST['keywords']!='') $keywords_video = safeHTML($_POST['keywords']);
                else $keywords_video=check_keywords($full_meta);

                if ($_POST['url_seo']!='') $name_video = safeHTML($_POST['url_seo']); else $name_video = $item;

                        $name_video=strtr($name_video,'_','*');
                        $name_video = rewrite($name_video);
                        $name_video=strtr($name_video,'*','_');  

		if ( ( empty ( $item ) ) and ( $_POST[but] != "$def_images_delete" ) )

		{
			$empty = (string)$def_video_empty;
		}

		if ( ( empty ( $urlv ) ) and ( $_POST[but] != "$def_images_delete" ) )

		{
			$empty2 = (string)$def_url_video_empty;
		}

		// *********************************************************

		if ( ( empty ( $empty ) ) and ( empty ( $empty2 ) ) and ( $_POST["but"] == "$def_images_add" ) and ($_POST['full_edit']!='true') )

		{
			$r = $db->query  ( "SELECT * FROM $db_video WHERE firmselector = '$firmselec'" );
			@$results_amount=mysql_num_rows($r);
			@$db->freeresult ($r);
                        
                        $sort_video=intval($_POST['sort']);
                        
                        if ($sort_video==0) $sort_video=$results_amount;

			if ( $results_amount <> $video )

			{
				$date = date ( "Y-m-d" );

				$db->query  ( "INSERT INTO $db_video (firmselector, item, urlv, date, message, full, sort, name, metatitle, metadescr, metakeywords) VALUES ('$firmselec', '$item', '$urlv', '$date', '$message','$business', '$sort_video','$name_video', '$title_video', '$descr_video', '$keywords_video')" )
				or die ( "ERROR010: mySQL error, cant insert into VIDEO. (edvideo.php)" );

                                logsto("Добавлен видеоролик для компании <b>$f[firmname]</b> (id=$f[selector])");
                                $upload = 'Успешно добавлен видеоролик <b>"'.$item.'"</b>';
			}

			else

			{
				$over = 'Добавлять видеоролики нельзя! Ваш лимит закончен!<br> К загрузке допускается - '.$video.' видеороликов';
			}
		}}
                
                // Редактируем видеоролик
                
                if ($_POST['full_edit']=='true') {
                    
                    
                        $date = date ( "Y-m-d" );

                        $post_seek=intval($_POST['seek']);
                        $sort_video = intval($_POST['sort']);
                        
			$db->query  ( "UPDATE $db_video SET item='$item', urlv='$urlv', date='$date', message='$message', full='$business', name='$name_video', metatitle='$title_video', metadescr='$descr_video', metakeywords='$keywords_video', recommend = '$recommend', sort='$sort_video' WHERE num='$post_seek' and firmselector='$firmselec'" );

                        unset($_POST['seek']);
                        logsto("Отредактирован видеоролик ($post_seek) компании <b>$f[firmname]</b> (id=$f[selector])");
                        
                        $upload = 'Успешно отредактирован видеоролик <b>"<a href="edvideo.php?id='.$f['selector'].'&seek='.$post_seek.'&edit_full=true">'.$item.'</a>"</b>';
                    
                }

		// *********************************************************

    $firmsel = intval($f['selector']);
    $pages=10;

    $r = $db->query  ( "SELECT * FROM $db_video WHERE firmselector='$firmsel' ORDER BY sort DESC" );
    @$results_amount = mysql_num_rows ( $r );
    @$results_amount_all = mysql_num_rows ( $r ); 
    
   if ($results_amount>$pages) {

    		$page1=intval($_POST['page'])*$pages;

    $r=$db->query ("SELECT * FROM $db_video WHERE firmselector='$firmsel' ORDER BY sort DESC LIMIT $page1, $pages") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $r );
    }    

 $pricelines = $f['video'];

 $free = $pricelines - $results_amount_all;

 echo '&nbsp;'.$def_admin_video.': <b>'.$pricelines.'</b> ('.$def_free.': '.$free.' - '.$def_used.': '.$results_amount_all.')<br /><br />';
 
 if ($results_amount_all > $pages){ ?>
<div style="text-align:left; padding-left:20px;">
<form action="edvideo.php?id=<?=$idident; ?>" method="post">
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

 if (!empty ($empty)) msg_text("80%",$def_admin_message_mess,$empty);

 if (!empty ($empty2)) msg_text("80%",$def_admin_message_mess,$empty2);

 if (isset($upload))  msg_text("80%",$def_admin_message_mess,$upload);

 echo '<form action="edvideo.php" method="post" enctype="multipart/form-data">
             <table cellpadding="0" cellspacing="0" border="0" width="98%" align="center">
              <tr>
               <td align="middle" valign="middle" width="50px" id="table_files">'.$def_images_choice.'</td>
               <td colspan="2" align="middle" valign="middle" id="table_files_r">URL, название и описание видеоролика</td>
              </tr>';

 for ( $i=0; $i<$results_amount; $i++ )

 {
 	$f = $db->fetcharray  ( $r );
 ?>
     <tr>
      <td valign="middle" align="center" id="table_files_i">
       <input type="radio" name="seek" value="<?php echo $f['num']; ?>" style="border:0;" <?php if ( $f['num'] == $_POST['seek'] ) echo "CHECKED"; ?>>
      </td>
 <?php

 $cols = "colspan=2";
 
      $f['urlv'] = stripcslashes($f['urlv']);

 echo '<td  width="100%" $cols align="left" valign="middle" id="table_files_i_r">
	     <b>'.$f['item'].'</b> [ <span style="color:#0000FF;">'.$f['urlv'].'</span> ] ('.undate($f['date'], $def_datetype).')<br>
             '.$f['message'].'<br /><br />
           </td></tr>';
 }
 echo '</table><br />';
 echo '<div style="text-align: center; padding: 10px;">';
 echo '<input type="submit" name="but" value="'.$def_images_delete.'" style="color: #FFFFFF; background: #D55454;" />';
 echo '&nbsp;<input type="submit" name="but" value="'.$def_offers_edit_but.'">';
 echo '&nbsp;<input type="hidden" name="id" value="'.$idident.'">';
 echo '&nbsp;<input type="hidden" name="edit_full" value="true">';
 echo '</div>';
 echo '</form>';

 table_fdata_top ($def_add_video_run);

echo '<form action="edvideo.php" method="post">';
 echo '<table cellpadding="3" cellspacing="3" border="0" width="100%" align="center">
           <tr>
            <td align="right" width="80%">
          '.$def_video_item.': <span style="color:#FF0000;">*</span> <input type="text" name="item" size="45" maxlength="100" /><br><br />
	  '.$def_video_url.': <span style="color:#FF0000;">*</span> <textarea name="url" cols="45" rows="5" style="width:300px; height:100px;"></textarea><br><br />
          '.$def_video_description.': &nbsp;&nbsp;<textarea name="message" cols="45" rows="5" style="width:300px; height:100px;"></textarea><br /><br />
        <br /> <br />';
 echo '</td></tr>';
 echo '<tr>
     <td align="center" colspan="3">
          <input type="submit" name="but" value="'.$def_images_add.'" />
          <input type="hidden" name="changed" value="true" /><input type="hidden" name="id" value="'.$idident.'" />
          <br>';
 echo '</td>
      </tr>';
 echo '</table><br />';
echo '</form>';

 table_fdata_bottom();

    } // редактирование полное

 require_once 'template/footer.php';

?>
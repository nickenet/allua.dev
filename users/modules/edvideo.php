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

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$_POST['seek']=intval($_REQUEST['seek']);

if (isset($_SESSION['num_page_video'])) $pages=$_SESSION['num_page_video']; else $pages = 5;

if (isset($_POST['num_page_video'])) { $_SESSION['num_page_video']=intval($_POST['num_page_video']); $pages=$_SESSION['num_page_video']; }

if (($_REQUEST['edit']=='edit') or ($_POST['but']==$def_offers_edit_but)) {

    // Считываем ролик
    $post_seek = intval($_REQUEST['seek']);
    $r_e = $db->query  ( "SELECT * FROM $db_video WHERE num='$post_seek' and firmselector='$f[selector]' LIMIT 1" );
    $f_e = $db->fetcharray  ( $r_e );

    $form_num = $f_e['num'];
    $form_item = $f_e['item'];
    $form_urlv = stripcslashes($f_e['urlv']);
    $form_urlv = str_replace("&lt;", "<", $form_urlv);
    $form_urlv = str_replace("&gt;", ">", $form_urlv);
    $form_message = $f_e['message'];
    $form_full = stripcslashes($f_e['full']);
    $form_sort = $f_e['sort'];
    $form_name = $f_e['name'];
    $form_metakeywords = $f_e['metakeywords'];
    $form_metadescr = $f_e['metadescr'];
    $form_metatitle = $f_e['metatitle'];
    if ($f_e['recommend']!='') {

        @$r_r = $db->query ( " SELECT item, num FROM $db_video WHERE num IN ($f_e[recommend])");
        @$results_amount_r = mysql_num_rows ( $r_r );

        for ( $i=0; $i<$results_amount_r; $i++ ) {

            $f_r = $db->fetcharray  ( $r_r );
            $video_rec .='<li><select style="width:400px;" name="rec[]"><option value="'.$f_r['num'].'" selected>'.$f_r['item'].'</option></select><div id="del_rol" class="icon-remove"></div></li>';

        }

    }
    $_GET['edit']='edit';
}


	if (($_POST['changed'] == "true") and ($_POST['but']!=$def_offers_edit_but))

	{
		$item = safeHTML($_POST['item']);

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


          if (isset($_POST['rec'])) { $recommend=array_unique($_POST['rec']);

            $toRecomend = array();
            foreach ($recommend as $value) {
                        if ($value!=0) $toRecomend[]=intval($value);
            } unset ($value);
            $recommend=implode (",",$toRecomend); }
          
		$message = safeHTML (strip_tags($_POST["message"]));
		$video = $f["video"];

		$firmselec = intval($f["selector"]);
                $business=safe_business($f['flag'], $_POST['business']);

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

		if ( ( empty ( $item ) ) and ( $_POST['but'] != $def_images_delete ) ) $empty = $def_video_empty;

		if ( ( empty ( $urlv ) ) and ( $_POST['but'] != $def_images_delete ) and ( $_POST['but'] != $def_images_change ) ) $empty2 = $def_url_video_empty;

		// *********************************************************

		if ( ( empty ( $empty ) ) and ( empty ( $empty2 ) ) and ( $_POST["but"] == $def_images_add ) )

		{
			$r = $db->query  ( "SELECT * FROM $db_video WHERE firmselector = '$firmselec'" );
			@$results_amount=mysql_num_rows($r);
			@$db->freeresult ($r);

			if ( $results_amount <> $video )

			{
				$date = date ( "Y-m-d" );
				$db->query  ( "INSERT INTO $db_video (firmselector, item, urlv, date, message, full, sort, name, metatitle, metadescr, metakeywords, recommend) VALUES ('$firmselec', '$item', '$urlv', '$date', '$message','$business', '$results_amount','$name_video', '$title_video', '$descr_video', '$keywords_video', '$recommend')" )
				or die ( "ERROR010: mySQL error, cant insert into VIDEO. (edvideo.php)" );
			}
			else $over = "Добавлять видеоролики нельзя! Ваш лимит закончен!<br> К загрузке допускается - $video видеороликов";
                }

                if ( ( empty ( $empty ) ) and ( empty ( $empty2 ) ) and ( $_POST["but"] == $def_images_change ) )

		{

                    	$date = date ( "Y-m-d" );

                        $post_seek=intval($_POST['edit_seek']);

			$db->query  ( "UPDATE $db_video SET item='$item', urlv='$urlv', date='$date', message='$message', full='$business', name='$name_video', metatitle='$title_video', metadescr='$descr_video', metakeywords='$keywords_video', recommend = '$recommend' WHERE num='$post_seek' and firmselector='$firmselec'" );

                        unset($edit_seek, $_POST['seek']);

                        $over = 'Видеоролик "'.$item.'" успешно обновлен!';
                    
                }
        }

		// *********************************************************

		if ( ( empty ( $empty ) ) and ( empty ( $empty2 ) ) and ( $_POST["but"] == "$def_images_delete" ) )

		{
                        $post_seek=intval($_POST['seek']);
			$db->query  ( "DELETE FROM $db_video WHERE num='$post_seek' and firmselector='$firmselec'" )
			or die ( "ERROR011: mySQL error, can't delete from VIDEO. (edvideo.php)" );
		}


		// *********************************************************

                 if ( isset ( $over ) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$over.'</div>';

                 if ( isset ( $empty ) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$empty.'</div>';
                 
                 if ( isset ( $empty2) ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$empty2.'</div>';

                 if (isset($_GET['edit'])) $video_title="Основные параметры"; else $video_title="Видеоролики";
                             
?>
<script src="<? echo $def_mainlocation; ?>/includes/js/jquery.jeditable.mini.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/includes/js/jquery.ajaxfileupload.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/includes/js/jquery.jeditable.ajaxupload.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/includes/jquery.validate.min.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/includes/messages_ru.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/includes/jqueryui.js" type="text/javascript"></script>
<style type="text/css">
	#sortable, #roliki {
		list-style-type: none;
		margin: 0;
		padding: 0;
	}
	#sortable, #roliki li {
		clear: left;
	}

</style>
<script type="text/javascript">
         $('document').ready(function() {
            var order = 0;
            var pages = <?=$pages; ?>;
            $('#sortable').sortable(
               {
               axis: "y",
               cursor: "n-resize",
               opacity: 0.6,
               update: function() {
                  order = $('#sortable').sortable('toArray');
                  $('button').show();
                  $('div#info').show();
                  $('div#info').text('Не забудьте сохранить изменения!');
               }
               });
            $('button').click(function() {
               $('div#info').load('inc/ajaxjsortvideo.php?pages='+pages+'&items=' + order.join(','));
               $('div#info').hide(5000);
               $('button').hide(500);
            });
$('#add_forma').click(function() {
$.ajax({
  url: 'inc/ajaxaddvideo.php',
  cache: false,
  beforeSend: function() { $('#forma_add').html('<img src="../images/go.gif">'); },
  success: function(html) { $('#forma_add').html(html); $('#add_forma').hide(); }
});
});
         });
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Видеоролики</li>
            <li class="TabbedPanelsTab" tabindex="0">Поддерживаемые видеообменники</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;"><?=$video_title; ?></span></td>
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

if (isset($form_num)) $sql_not=" and num!='$form_num' "; else $sql_not="";

		$r = $db->query  ( "SELECT * FROM $db_video WHERE firmselector='$firmsel' $sql_not ORDER BY sort DESC" );
		@$results_amount = mysql_num_rows ( $r );
                $results_amount_all=$results_amount;
		$pricelines = $f[video];

if (isset($_GET['edit'])) { require ('../includes/editor/tiny_'.$f['flag'].'.php'); require 'inc/addvideofullform.php'; } else {

if ($results_amount>$pages) {

    		$page1=intval($_POST['page'])*$pages;

    $r=$db->query ("SELECT * FROM $db_video WHERE firmselector='$firmsel' ORDER BY sort DESC LIMIT $page1, $pages") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $r );
}

?>

<div style="text-align:right;">

<? if ($results_amount_all > $pages) { ?>
<div style="float: right;">
<form action="?REQ=authorize&mod=edvideo" method="post">
&nbsp;Страница: <select name="page" onchange="this.form.submit();">
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
</div>

<? } ?>
    
<form action="?REQ=authorize&mod=edvideo" method="post">
<select name="num_page_video" onchange="this.form.submit();">
<?
			for($x=5; $x<35; $x=$x+5)
			{
				if ($x == $pages) {echo '<option value="'.intval($pages).'" selected>По '.intval($pages).' позиций</option>'; } else {echo '<option value="'.$x.'">По '.$x.' позиций</option>';}
			}
?>
    </select>
</form>
</div><br>

<form action="?REQ=authorize&mod=edvideo" method="post" enctype="multipart/form-data">
    <ul id="sortable">
<?

for ( $i=0; $i<$results_amount; $i++ ) {

    $f_v = $db->fetcharray  ( $r );

?>
<li id="<? echo $f_v['num']; ?>">
    <table style="padding: 2px;" border="0" width="100%">
     <tr class="thumbnail">
      <td valign="middle" align="center">
       <div style="padding:3px;"><a href="#" title="Нажмите и удерживайте для перемещения" class="icon-move"></a></div>
       <input type="radio" name="seek" value="<?php echo $f_v['num']; ?>" style="border:0px;" <?php if ( $f['num'] == $_POST['seek'] ) echo "CHECKED"; ?>>
       <div style="padding:3px;"><a href="?REQ=authorize&mod=edvideo&changed=true&edit=edit&seek=<?=$f_v['num'];?>" title="Редактировать" class="icon-pencil"></a></div>
      </td>

<?

$f_v['urlv'] = stripcslashes($f_v['urlv']);

if (strlen(strip_tags($f_v['message']))>strlen(strip_tags($f_v['full']))) $fx_proc = strlen(strip_tags($f_v['message'])); else $fx_proc = strlen(strip_tags($f_v['full']));

$fx_proc=strlen(strip_tags($f_v['message'])); $procent=round(($fx_proc*100)/300); if ($procent>100) $procent=100;

if ($f_v['message']=='') $f_v['message']=$def_video_not_message;

$f_v['message'] = safeHTML($f_v['message']);

if ($f_v['rateNum']>0) $rating='<div style="padding:5px; text-align:right;"><span class="label label-info">Рейтинг ('.$f_v['rateNum'].'/'.$f_v['rateVal'].')</span> [<span class="tooltip-main well"><a title="Показывает общее число голосов и оценку." rel="tooltip" href="#">?</a></span>]</div>'; else $rating='';

echo '<td  width="100%" align="left" valign="middle"><span class="label label-info">'.undate($f_v['date'], $def_datetype).'</span> <b><span id="'.$f_v['num'].'" class="edit_p">'.$f_v['item'].'</span></b>
    <div style="color:#0033FF; padding: 3px; margin: 3px; font-size:9px;">'.$f_v['urlv'].'</div>
             <div id="'.$f_v['num'].'" class="txt" style="padding:2px;">'.$f_v['message'].'</div>'.$rating.'
             <div style="width: 150px; padding:3px;">
                <div class="progress_mini progress-info progress-striped">
                <span class="txt tooltip-main well"><a title="<b>Показатель качества = '.$procent.'%</b><br>Знаков в описании - '.$fx_proc.'. " rel="tooltip" href="#">
                    <div class="bar" style="width:'.$procent.'%;"></div>
                </a></span>
                </div>
             </div>
        </td>';
?>
       </tr>
    </table>
</li>

<?
}
?>
</ul>
        <input type="submit" name="but" value="<?=$def_images_delete; ?>" class="btn btn-danger">
        &nbsp;<input type="submit" name="but" value="<?=$def_offers_edit_but; ?>" class="btn btn-warning">
        <input type="hidden" name="changed" value="true">
</form>
<button style="display: none;" class="btn btn-success">Сохранить сортировку</button>
<div class="alert" id='info' style="display: none; width: 300px; padding: 5px; margin: 5px;">&nbsp;</div>
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
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Добавить</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont" align="center">
<?php

if (  $f["video"] != '0' ) 

{

 $free = $pricelines - $results_amount_all;
echo '<div class="alert alert-info" style="width:220px;">Допустимо всего: <b>'.$pricelines.'</b><br>(Осталось: '.$free.', использовано: '.$results_amount_all.')</div>';
echo '<input id="add_forma" type="submit" name="but" value="Быстрое добавление видеоролика" class="btn btn-info">';
echo '<form action="?REQ=authorize&mod=edvideo&edit=add" method="post"><input type="submit" id="get_full" name="but" value="Добавить видеоролик (подробный вариант)" class="btn btn-warning"></form>';
echo '<div id="forma_add"></div>';
}

else

{

?>

<strong class="id_url">Обратите внимание!</strong><br>
Данный раздел личного кабинета работает в демонстрационном режиме.<br> Для того, чтобы полноценно воспользоваться возможностями этого сервиса вам необходимо активировать другой тарифный план.<br> 
Сравнительную таблицу тарифных планов можно посмотреть по этой <a href="<? echo "$def_mainlocation"; ?>/compare.php">ссылке</a>.<br><br>


<?php			
			
}
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
                  <td width="180" align="right">Видеообменники:</td>
                  <td><a href="http://youtube.com" target="_blank"><strong>YouTube.com</strong></a> Добавить видео <a href="http://www.youtube.com/my_videos_upload" target="_blank">&raquo;</a><br>
		      <a href="http://rutube.ru/" target="_blank"><strong>RuTube.ru</strong></a> Добавить видео <a href="http://uploader.rutube.ru/upload.html" target="_blank">&raquo;</a><br>
		      <a href="http://video.yandex.ru/" target="_blank"><strong>Яндекс.Видео</strong></a><br>
		      <a href="http://kiwi.kz/" target="_blank"><strong>kiwi.kz</strong></a><br>	
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
          <div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo $def_mainlocation; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
          <div class="CollapsiblePanelContent">
            <? echo $help_video; ?>
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
     $('.edit_p').editable('inc/ajaxjtv.php', {
         type      : 'text',
         cancel    : 'Отменить',
         submit    : 'OK',
         style     : 'padding:10px;',
         indicator : '<img src="../images/go.gif">',
         tooltip   : 'Нажмите для изменения...'
     });
     $('.txt').editable('inc/ajaxjtvm.php', {
         type      : 'textarea',
         cancel    : 'Отменить',
         submit    : 'OK',
         style     : 'padding:10px;',
         rows      : '5',
         indicator : '<img src="../images/go.gif">',
         tooltip   : 'Нажмите для изменения...',
                      data: function(value, settings) {
      /* Convert <br> to newline. */
      var retval = value.replace(/<br[\s\/]?>/gi, '\n');
      return retval;
             }
     });
 });
</script>
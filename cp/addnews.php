<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: addnews.php
-----------------------------------------------------
 Назначение: Управление новостями
=====================================================
*/

session_start();

if (isset($_POST['editor_uses']))
{
        setcookie('editor_uses', '',time()+(60*60*24*30),'/');
        setcookie('editor_uses', $_POST['editor_uses'],time()+(60*60*24*30),'/');
        $_COOKIE['editor_uses'] = $_POST['editor_uses'];
	  
}

if (empty($_COOKIE['editor_uses']))
{
        setcookie('editor_uses', '',time()+(60*60*24*30),'/');
	setcookie('editor_uses', 'nicEdit',time()+(60*60*24*30),'/');
        $_COOKIE['editor_uses'] = 'nicEdit';
        
}

require_once './defaults.php';

$help_section = (string)$news_add_help;

if (isset($_REQUEST['editnews'])) { $form_selector=intval($_REQUEST['editnews']); $editURL='?editnews='.$form_selector; $title_edit_or_add='Редактировать новость'; $save_edit='Изменить'; } else { $editURL=''; $title_edit_or_add='Добавить новость'; $save_edit='Добавить'; }

$title_cp = $title_edit_or_add.' - ';
$speedbar = ' | <a href="editallnews.php">Управление новостями</a> | <a href="addnews.php'.$editURL.'">'.$title_edit_or_add.'</a>';

check_login_cp('3_9','addnews.php');

require_once 'template/header.php';

?>

<table width="100%" border="0">
  <tr>
      <td><img src="images/news.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;<? echo $title_edit_or_add; ?></span></td>
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
            <td width="170" class="vclass"><img src="images/news_edit.gif" width="31" height="31" align="absmiddle" /><a href="editallnews.php">Редактировать новости</a></td>
            <td width="140" class="vclass"><img src="images/news_plus.gif" width="31" height="31" align="absmiddle" /><a href="addnews.php">Добавить новость</a></td>
	    <td width="150" class="vclass"><img src="images/news_edit_cat.gif" width="31" height="31" align="absmiddle" /><a href="editcatnews.php">Редактор категорий</a></td>
            <td width="180" class="vclass"><img src="images/balloon.png" width="31" height="31" align="absmiddle" /><a href="editcommentnews.php?REQ=auth">Комментарии к новостям</a> <? if($_SESSION['comnews']) echo '('.$_SESSION['comnews'].')'; ?></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>

<form action="" method="post">
 &nbsp;&nbsp;Использовать WYSIWYG редактор:
  <select name="editor_uses" onchange="this.form.submit();">
    <option value="nicEdit" <? if ($_COOKIE['editor_uses']=='nicEdit') echo 'selected="selected"'; ?>>nicEdit</option>
    <option value="TinyMCE" <? if ($_COOKIE['editor_uses']=='TinyMCE') echo 'selected="selected"'; ?>>TinyMCE</option>
    <option value="noedit" <? if ($_COOKIE['editor_uses']=='noedit') echo 'selected="selected"'; ?>>Без редактора</option>
  </select>
<br /><br />
</form>

<?

// Обрабатываем форму
if (isset ($_POST['add_or_old'])) {

    // Обрабатываем поля
    $status_off = isset( $_POST['approve'] ) ? intval( $_POST['approve'] ) : 1;
    $fixed = isset( $_POST['news_fixed'] ) ? intval( $_POST['news_fixed'] ) : 0;
    $comment_off = isset( $_POST['allow_comm'] ) ? intval( $_POST['allow_comm'] ) : 1;
    $main_off = isset( $_POST['allow_main'] ) ? intval( $_POST['allow_main'] ) : 1;
    $form_title=htmlspecialchars ( $_POST['title'],ENT_NOQUOTES,$def_charset );
    $form_altname=rewrite(safeHTML($_POST['altname']));
    $form_category=intval($_POST['category']);
    $form_short_news=post_to_shortfull($_POST['short_news']);
    $form_full_news=post_to_shortfull($_POST['full_news']);
    $form_keywords=safeHTML(strip_tags($_POST['keywords']));
    $form_metatitle=safeHTML(strip_tags($_POST['metatitle']));
    $form_metadescr=safeHTML(strip_tags($_POST['metadescr']));
    $form_metakeywords=safeHTML(strip_tags($_POST['metakeywords']));
    if ($_POST['short_tpl']!='') $form_short_tpl = rewrite(safeHTML(strip_tags($_POST['short_tpl'])));
    if ($_POST['full_tpl']!='') $form_full_tpl = rewrite(safeHTML(strip_tags($_POST['full_tpl'])));

    if (($form_title=='') or ($form_altname=='') or ($form_short_news=='') or (strlen($form_short_news)<5) ) $error_add_news='Вы не заполнили обязательные поля!';

}

if ( $_POST['delete'] == "$def_images_delete" )

		{

                $form_selector=intval($_POST['selector']);

			$db->query  ( "DELETE FROM $db_news WHERE selector='$form_selector'" ) or die ( "mySQL error, can't delete from NEWS." );
                        @ $db->query  ( "DELETE FROM $db_newsrev WHERE news='$form_selector'" );
                        if ($status_off!=1) $db->query ( "UPDATE $db_categorynews SET ncount = ncount-1 WHERE selector='$form_category'" );

                        logsto("Новость удалена из базы данных <b>$form_title</b> ID=<b>$form_selector</b>");

                        $ok_news_add=true;

                        $ok_news_add_message='Новость <b>"'.$form_title.'"</b> успешно удалена из базы данных.';

                        $error_add_news='delete';

		}

// Добавить новость
if (($_POST['add_or_old']=='add') and (empty($error_add_news))) {

        $form_data_news=date( "Y-m-d H:i:s" );

        $r=$db->query ("insert into $db_news (status_off, date, category, title, name, short, full, keywords, metatitle, metadescr, metakeywords, short_tpl, full_tpl, comment_off, fixed, main  )
                                      values ('$status_off', '$form_data_news', '$form_category', '$form_title', '$form_altname', '$form_short_news', '$form_full_news', '$form_keywords', '$form_metatitle', '$form_metadescr', '$form_metakeywords', '$form_short_tpl', '$form_full_tpl', '$comment_off', '$fixed', '$main_off' )") or die ("mySQL error!");

        if ($status_off!=1) $db->query ( "UPDATE $db_categorynews SET ncount = ncount+1 WHERE selector='$form_category'" );

        logsto("Добавлена новая новость в базу данных <b>$form_title</b>");

        $ok_news_add=true;

        $ok_news_add_message='Новость <b>"'.$form_title.'"</b> успешно добавлена в базу данных.';

}

// Редактировать новость
if (($_POST['add_or_old']=='edit') and (empty($error_add_news))) {

        if (isset($_POST['allow_date'])) $form_data_news=date( "Y-m-d H:i:s" ); else $form_data_news=date( "Y-m-d H:i:s", strtotime($_POST['data_news']) );

        $form_selector=intval($_POST['selector']);
        $form_status_old=intval($_POST['status_old']);
        $form_category_old=intval($_POST['category_old']);

        $db->query  ( " UPDATE $db_news SET status_off='$status_off', date='$form_data_news', category='$form_category', title='$form_title', name='$form_altname', short='$form_short_news', full='$form_full_news',
                                            keywords='$form_keywords', metatitle='$form_metatitle', metadescr='$form_metadescr', metakeywords='$form_metakeywords', short_tpl='$form_short_tpl', full_tpl='$form_full_tpl', comment_off='$comment_off', fixed='$fixed', main='$main_off' where selector='$form_selector' " ) or die ( mysql_error() );

        if (($status_off==1) and ($form_status_old==0))  $db->query ( "UPDATE $db_categorynews SET ncount = ncount-1 WHERE selector='$form_category'" );
        if (($status_off!=1) and ($form_status_old==1))  $db->query ( "UPDATE $db_categorynews SET ncount = ncount+1 WHERE selector='$form_category'" );
        if ($status_off!=1) {

            if ($form_category_old!=$form_category) { $db->query ( "UPDATE $db_categorynews SET ncount = ncount-1 WHERE selector='$form_category_old'" );
            $db->query ( "UPDATE $db_categorynews SET ncount = ncount+1 WHERE selector='$form_category'" ); }

        }

        logsto("Новость <b>$form_title</b> изменена. ID=<b>$form_selector</b>");

        $ok_news_add=true;

        $ok_news_add_message='Новость <b>"'.$form_title.'"</b> успешно изменена.';

}

// Читаем новость для редактирования

$form_action='';
if (isset($_REQUEST['editnews'])) {

    $r=$db->query ("SELECT * FROM $db_news WHERE selector='$form_selector' LIMIT 1") or die ("mySQL error!");
    $results_news = mysql_num_rows ( $r );

    if ($results_news>0) {

    // Обрабатываем поля
    $f_news=$db->fetcharray ($r);
    $form_status_off = intval($f_news['status_off']);
    $form_title=safeHTML($f_news['title']);
    $form_data_news=$f_news['date'];
    $form_altname=safeHTML($f_news['name']);
    $form_category=intval($f_news['category']);
    $form_short_news=stripcslashes($f_news['short']);
    $form_full_news=stripcslashes($f_news['full']);
    $form_keywords=safeHTML($f_news['keywords']);
    $form_metatitle=safeHTML($f_news['metatitle']);
    $form_metadescr=safeHTML($f_news['metadescr']);
    $form_metakeywords=safeHTML($f_news['metakeywords']);
    $form_short_tpl = safeHTML($f_news['short_tpl']);
    $form_full_tpl = safeHTML($f_news['full_tpl']);
    if ($f_news['status_off']==0) $ifstatus = "checked"; else $ifstatus = "";
    if ($f_news['fixed']) $iffixed = "checked"; else $iffixed = "";
    if ($f_news['comment_off']==0) $ifcomment = "checked"; else $ifcomment = "";
    if ($f_news['main']==0) $ifmain = "checked"; else $ifmain = "";
    $form_action="?editnews=$form_selector";
    $r_edit=true;
    }
    else $error_add_news='Новость с указанным ID не найдена!';

}

// Вывод формы новости
if ($ok_news_add) msg_text('80%',$def_admin_message_ok, $ok_news_add_message);

else {

if (isset($error_add_news)) msg_text('80%',$def_admin_message_error, $error_add_news);

table_fdata_top ($def_item_form_data);

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


<? if ($_COOKIE['editor_uses'] == 'nicEdit') { ?>
<script src="../includes/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor().panelInstance('area_short');
        new nicEditor().panelInstance('area_full');
});
</script>
<? } ?>

<? if ($_COOKIE['editor_uses'] == 'TinyMCE') {

    include ('../includes/editor/tiny.php');

} ?>

 <form action="addnews.php<? echo $form_action; ?>" method="post" enctype="multipart/form-data" id='news_form'>
 <table width="980" border="0" cellspacing="2" cellpadding="2">
<? if ($r_edit) { ?>
  <tr>
    <td align="right">ID новости:</td>
    <td align="left"><strong><? echo $form_selector; ?></strong></td>
  </tr>
<? } ?>
  <tr>
    <td align="right">Заголовок статьи: <span style="color:#FF0000;">*</span></td>
    <td align="left"><input type="text" name="title" value="<? echo $form_title; ?>" maxlength="255" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Алтернативное имя: <span style="color:#FF0000;">*</span></td>
    <td align="left"><input type="text" name="altname" value="<? echo $form_altname; ?>" maxlength="50" style="width: 350px;" /></td>
  </tr>
<? if ($r_edit) { ?>
  <tr>
    <td align="right">Дата:</td>
    <td align="left"><input type="text" name="data_news" value="<? echo $form_data_news; ?>" maxlength="50" style="width: 150px;" /><input type="checkbox" name="allow_date" value="1">&nbsp;текущая дата и время</td>
  </tr>
<? } ?>
  <tr>
    <td align="right">Категория: <span style="color:#FF0000;">*</span></td>
    <td align="left">

<select name="category" style="width: 350px;">';

<?
$re=$db->query ("select category, selector from $db_categorynews order by category");
$results_amount=mysql_num_rows($re);

for($i=0;$i<$results_amount;$i++) {
	$fa=$db->fetcharray ($re);

	if ($form_category == $fa["selector"]) echo '<option value="'.$fa['selector'].'" selected>'.$fa['category'].'</option>';
	else echo '<OPTION VALUE="'.$fa['selector'].'">'.$fa['category'].'</option>';
}

mysql_free_result($re);
?>

</select>

    </td>
  </tr>
  <tr>
    <td colspan="2"><hr /></td>
  </tr>
  <tr>
    <td align="right">Краткое описание: <span style="color:#FF0000;">*</span></td>
    <td align="left"><textarea name="short_news" cols="45" rows="5" id="area_short" style="width: 500px; height: 300px;"><? echo $form_short_news; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Полное описание:</td>
    <td align="left"><textarea name="full_news" cols="45" rows="5" id="area_full" style="width: 500px; height: 300px;"><? echo $form_full_news; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Ключевые слова (метки):</td>
    <td align="left"><input type="text" name="keywords" value="<? echo $form_keywords; ?>" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td colspan="2"><hr /></td>
  </tr>
  <tr>
    <td align="right">Мета-тег title:</td>
    <td align="left"><input type="text" name="metatitle" value="<? echo $form_metatitle; ?>" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Описание категории (мета-тег Description):</td>
    <td align="left"><input type="text" name="metadescr" value="<? echo $form_metadescr; ?>" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Ключевые слова (мета-тег Keywords):</td>
    <td align="left"><textarea name="metakeywords" cols="45" rows="5"><? echo $form_metakeywords; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="2"><hr /></td>
  </tr>
  <tr>
    <td align="right">Шаблон краткой версии:</td>
    <td align="left"><input type="text" name="short_tpl" value="<? echo $form_short_tpl; ?>" maxlength="50" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Шаблон полной версии:</td>
    <td align="left"><input type="text" name="full_tpl" value="<? echo $form_full_tpl; ?>" maxlength="50" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td colspan="2"><hr /></td>
  </tr>
  <tr>
    <td align="right">Опции новости:</td>
    <td align="left">
        <input type="checkbox" name="approve" value="0" <? if ($r_edit) echo $ifstatus; else echo "checked"; ?>> Опубликовать новость на сайте<br /><br />
	<input type="checkbox" name="news_fixed" value="1" <? if ($r_edit) echo $iffixed; ?>> Зафиксировать новость&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="allow_comm" value="0" <? if ($r_edit) echo $ifcomment; else echo "checked"; ?>> Разрешить комментарии&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="allow_main" value="0" <? if ($r_edit) echo $ifmain; else echo "checked"; ?>> Публиковать на главной каталога<br /><br />
    </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left"><input type="submit" name="save" value="<? echo $save_edit; ?>" />
        <? if ($r_edit) { echo '<input type="hidden" name="add_or_old" value="edit" />'; echo '<input type="submit" name="delete" value="'.$def_images_delete.'" />'; echo '<input type="hidden" name="selector" value="'.$form_selector.'" />';  echo '<input type="hidden" name="category_old" value="'.$form_category.'" />'; echo '<input type="hidden" name="status_old" value="'.$form_status_off.'" />'; }
            else echo '<input type="hidden" name="add_or_old" value="add" />'; ?>
    </td>
  </tr>
</table>
</form>

<?

table_fdata_bottom();

}

require_once 'template/footer.php';

?>
<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: editcatnews.php
-----------------------------------------------------
 Назначение: Редактор категорий новостей
=====================================================
*/

session_start();

require_once './defaults.php';

check_login_cp('3_9','editcatnews.php');

if (isset($_POST['sort_catnews']))
{
	$_SESSION['sort_catnews'] = (string)$_POST['sort_catnews'];
}

if (empty($_SESSION['sort_catnews']))
{
	$_SESSION['sort_catnews'] = 'selector';
}

if (empty ($_GET['edcat'])) {

$help_section = (string)$news_editcat_help;

$title_cp = 'Редактор категорий новостей - ';
$speedbar = ' | <a href="editallnews.php">Управление новостями</a> | <a href="editcatnews.php">Редактор категорий новостей</a>';

require_once 'template/header.php';

?>

<table width="100%" border="0">
  <tr>
      <td><img src="images/news.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;Редактор категорий новостей</span></td>
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

<form action="editcatnews.php" method="post">
 &nbsp;&nbsp;Сортировать категории по:
  <select name="sort_catnews" onchange="this.form.submit();">
    <option value="selector" <? if ($_SESSION['sort_catnews']=='selector') echo 'selected="selected"'; ?>>по id</option>
    <option value="category" <? if ($_SESSION['sort_catnews']=='category') echo 'selected="selected"'; ?>>по алфавиту</option>
  </select>
<br /><br />
</form>

<?

$allowcats="YES";

$cat_disp = safehtml ($_POST[disp]);
$alt_name = rewrite ($cat_disp);
$alt_name = str_replace( "-", "_", $alt_name );

	if (($_POST["submit"] != "$def_admin_delcat") and (!empty($_POST["submit"])) and (empty($cat_disp))) { msg_text('80%',$def_admin_message_error,$def_empty); }

	else

	{
		if ($_POST["submit"] =="$def_admin_addcat")
		{
			$r=$db->query ("insert into $db_categorynews (category, name) values ('$cat_disp', '$alt_name')") or die ("mySQL error!");

                        logsto("$def_admin_log_newcatadded $cat_disp");

                        empty_cache('../system/news.dat');

                        unset($_SESSION['razdel_news']);
		}

		elseif ($_POST["submit"] == "$def_admin_catren")

		{
			if ($cat_disp != "")

			{        
                            $cat = intval($_POST['chosen']);

                            $db->query ("UPDATE $db_categorynews SET category='$cat_disp' where selector='$cat'") or die ("mySQL error!");

                            logsto("$def_admin_log_catrenamed  $f[category] -> $cat_disp");

                            unset($_SESSION['razdel_news']);

                            empty_cache('../system/news.dat');
			}
		}

		elseif ($_POST["submit"] == "$def_admin_delcat")

		{
                        $cat = intval($_POST['chosen']);

				$r=$db->query ("SELECT * from $db_categorynews where selector='$cat'") or die ("mySQL error!");
				$f=$db->fetcharray ($r);

				$exists=mysql_num_rows($r);
				mysql_free_result($r);

				if ($f[ncount] == 0)
				{

					$r=$db->query ("SELECT category from $db_categorynews where selector='$cat'") or die ("mySQL error!");
					$f=$db->fetcharray ($r);

					$db->query ("delete from $db_categorynews where selector='$cat'") or die ("mySQL error!");

                                        @unlink ( "../images/newsicon/$cat.gif" );
                                        @unlink ( "../images/newsicon/$cat.png" );
                                        @unlink ( "../images/newsicon/$cat.bmp" );
                                        @unlink ( "../images/newsicon/$cat.jpg" );
                                        @unlink ( "../images/newsicon/$cat.jpeg" );
                                        @unlink ( "../images/newsicon/$cat.tif" );
                                        @unlink ( "../images/newsicon/$cat.tiff" );

                                        logsto("$def_admin_log_catdeleted  $f[category]");

                                        unset($_SESSION['razdel_news']);

                                        empty_cache('../system/news.dat');

				}

				else msg_text('80%',$def_admin_message_error, 'Удалить категорию нельзя, она содержит публикации.');
		}
	}

	table_fdata_top ($def_item_form_data);

	$r=$db->query ("select * from $db_categorynews  ORDER BY $_SESSION[sort_catnews]") or die ("mySQL error!");
	$results_amount=mysql_num_rows($r);

	echo '<table width="70%" border="0" cellpadding="0" cellspacing="0">';
	echo '<form method="post" action="editcatnews.php">';

	for ($x=0;$x<$results_amount;$x++) {

                $f=$db->fetcharray ($r);

                if ($f[img]!='') $img_ok='<img src="images/img_cat.png" width="24" height="24" align="absmiddle" border="0" alt="Иконка" title="Иконка" hspace="2" vspace="2" />'; else $img_ok='';
                if ($f['metadescr']=='') $style_color='666'; else $style_color='0000FF';
                if ($f['status_off']) $style_color='FF0000';

		echo '<tr><td width="100%" align="left" valign="top"><input type="radio" name="chosen" value="'.$f[selector].'" style="border:0;" />'.$dangers.' <b style="color: #'.$style_color.'">'.$f[category].'</b> <a href="?edcat='.$f[selector].'" title="Редактировать"><img src="images/edit_cat.png" width="24" height="24" align="absmiddle" border="0" alt="Редактировать" title="Редактировать" hspace="2" vspace="2" /></a>'.$img_ok.' <span style="color: #999999; font-size:9px;">(id '.$f[selector].', Новостей: <b>'.$f[ncount].'</b>)</span><br /></td></tr>';
                echo "\n";
	}

	echo '<tr><td width="100%" align="left" valign="top">';
	echo '<br /><br /><input type="text" size="50" name="disp" /><br /><br /><input type="submit" name="submit" value="'.$def_admin_addcat.'" />&nbsp;<input type="submit" name="submit" value="'.$def_admin_catren.'" />&nbsp;&nbsp;<input type="submit" name="submit" value="'.$def_admin_delcat.'" style="color: #FFFFFF; background: #D55454;" /></td></tr>';
        echo "\n";
	echo '</table></form><br /><br />';

	table_fdata_bottom();
}

 else {

if (isset ($_POST['id_cat'])) {

    $status_off = isset( $_POST['status_off'] ) ? intval( $_POST['status_off'] ) : 0;
    $altname = str_replace( "-", "_", $altname );
    if ($_POST['altname']=='') $altname=rewrite (str_replace( "_", "-", $_POST['category'])); else $altname=rewrite(safeHTML(str_replace( "_", "-",$_POST['altname'])));
    $altname=str_replace( "-", "_", $altname);
    $metatitle=strip_tags(safeHTML($_POST['metatitle']));
    $metadescr=strip_tags(safeHTML($_POST['metadescr']));
    $metakeywords=strip_tags(safeHTML($_POST['metakeywords']));
    $id_cat_post=intval($_POST['id_cat']);
    $description_full=post_to_shortfull($_POST['description']);
    if ($_POST['short_tpl']!='') $short_tpl = rewrite(safeHTML($_POST['short_tpl']));
    if ($_POST['full_tpl']!='') $full_tpl = rewrite(safeHTML($_POST['full_tpl']));
    $imgExt = array('gif', 'png', 'bmp', 'jpg', 'jpeg', 'tif', 'tiff');
    $images_r='';

    if ( isset($_FILES[key]) && is_uploaded_file($_FILES[key]['tmp_name']) )
		{
			$name	= strtolower($_FILES[key]['name']);
			$ext	= pathinfo($name, PATHINFO_EXTENSION);
			if (!in_array($ext, $imgExt))
			{
				msg_text('80%',$def_admin_message_error,'Загружайте разрешённые картинки.');
			}

                        else {

			$name	= '../images/newsicon/'.$id_cat_post.'.' . $ext;

                        @unlink($name);

			if ( move_uploaded_file($_FILES[key]['tmp_name'], $name) )
			{
				$images_r = $ext;
			}
			else
                            {
                                	msg_text('80%',$def_admin_message_error,'Ошибка загрузки файла.');
                            }
                        }
		}

    if ($images_r!='') $db->query  ( " UPDATE $db_categorynews SET status_off='$status_off', name = '$altname', metatitle = '$metatitle', metadescr = '$metadescr', metakeywords='$metakeywords', description='$description_full', short_tpl='$short_tpl', full_tpl='$full_tpl', img='$images_r' where selector='$id_cat_post' " ) or die ( mysql_error() );
    else $db->query  ( " UPDATE $db_categorynews SET status_off='$status_off', name = '$altname', metatitle = '$metatitle', metadescr = '$metadescr', metakeywords='$metakeywords', description='$description_full', short_tpl='$short_tpl', full_tpl='$full_tpl' where selector='$id_cat_post' " ) or die ( mysql_error() );

    logsto("Выполнено редактирование категории новостей <b>id=$id_cat_post</b>");

    empty_cache('../system/news.dat');
}

if ($_POST['do_delete'] == "Удалить иконку") {

    $id_cat_post=intval($_POST['id_cat']);
    $name="../images/newsicon/$id_cat_post.$_POST[type_img]";
    @unlink($name);
    $db->query  ( " UPDATE $db_categorynews SET img='' where selector='$id_cat_post' " ) or die ( mysql_error() );
    logsto("Удалена иконка к категории <b>id=$id_cat_post</b>");

}
    $id_category=intval($_GET['edcat']);

    $r_cat=$db->query ("select * from $db_categorynews where selector='$id_category' LIMIT 1") or die ("mySQL error!");
    $results_amount=mysql_num_rows($r_cat);
    $f_cat=$db->fetcharray ($r_cat);

    $help_section = (string)$news_editcat2_help;

    $title_cp = 'Редактировать категорию - ';
    $speedbar = ' | <a href="editallnews.php">Управление новостями</a> | <a href="editcatnews.php">Редактор категорий новостей</a> | <a href="editcatnews.php?edcat='.$id_category.'">Редактировать категорию - '.$f_cat['category'].'</a>';

    require_once 'template/header.php';

    table_item_top ('Редактировать категорию - '.$f_cat['category'],'news.png');

    table_fdata_top ($def_item_form_data);

    if ($results_amount==0) msg_text('80%',$def_admin_message_error,'Категория с данным id не найдена.');

    else {
        
    if ($f_cat['name']=='') {
        $f_cat['name']=rewrite ($f_cat['category']);
        $auto_gen_name_img = '&nbsp;<img src="images/msg_ico.png" width="16" height="16" align="absmiddle" title="Имя сгенерировано автоматически системой" />';
    } else $auto_gen_name_img = '';

    if ($f_cat['status_off']) $ifch = "checked"; else $ifch = "";
    
?>

<script src="../includes/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor().panelInstance('area_full');
});
</script>

 <form action="" method="post" enctype="multipart/form-data">
 <table width="900" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="right">Название категории:</td>
    <td align="left"><b><? echo $f_cat['category']; ?></b></td>
  </tr>
  <tr>
    <td align="right">Алтернативное имя:</td>
    <td align="left"><input type="text" name="altname" value="<? echo $f_cat['name']; ?>" maxlength="50" style="width: 350px;" /><? echo $auto_gen_name_img; ?></td>
  </tr>
  <tr>
    <td align="right">Мета-тег title:</td>
    <td align="left"><input type="text" name="metatitle" value="<? echo $f_cat['metatitle']; ?>" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Описание категории (мета-тег Description):</td>
    <td align="left"><input type="text" name="metadescr" value="<? echo $f_cat['metadescr']; ?>" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Ключевые слова (мета-тег Keywords):</td>
    <td align="left"><textarea name="metakeywords" cols="45" rows="5"><? echo $f_cat['metakeywords']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Описание категории:</td>
    <td align="left"><textarea name="description" cols="45" rows="5" id="area_full" style="width: 500px; height: 300px;"><? echo stripcslashes($f_cat['description']); ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Шаблон краткой версии:</td>
    <td align="left"><input type="text" name="short_tpl" value="<? echo $f_cat['short_tpl']; ?>" maxlength="50" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Шаблон полной версии:</td>
    <td align="left"><input type="text" name="full_tpl" value="<? echo $f_cat['full_tpl']; ?>" maxlength="50" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Иконка:</td>
    <td align="left"><input type="file" name="key" />
<?
    if ($f_cat['img']!='') $name_img="../images/newsicon/$f_cat[selector].$f_cat[img]";
    if (file_exists($name_img)) {

        echo '<br /><img src="'.$name_img.'" border="0" /><br />';

        $size	= getimagesize($name_img);
	$size	= $size[0] . ' x ' . $size[1] . ' px';
	$fSize	= filesize($name_img);
	$fSize	= round(($fSize / 1024),2) . ' KB';

        echo 'Формат: '.$f_cat[img].'<br />';
        echo 'Размер: '.$size.'<br />';
	echo 'Вес: '.$fSize;

    }
?>
    </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left">
    <input type="checkbox" name="status_off" value="1" <? echo $ifch; ?>> Не транслировать в списке категорий в разделе<br /><br />
    <input type="submit" name="save" value="Сохранить" />
    <input type="submit" name="do_delete" value="Удалить иконку" />
    <input type="hidden" name="id_cat" value="<? echo $f_cat['selector']; ?>" />
    <input type="hidden" name="category" value="<? echo $f_cat['category']; ?>" />
    <input type="hidden" name="type_img" value="<? echo $f_cat['img']; ?>" />
    </td>
  </tr>
</table>
</form>

<?

    }

    table_fdata_bottom();

}

require_once 'template/footer.php';

?>
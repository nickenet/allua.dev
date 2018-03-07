<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: editallnews.php
-----------------------------------------------------
 Назначение: Управление новостями
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$edit_allnews_help;

$title_cp = 'Управление новостями - ';
$speedbar = ' | <a href="editallnews.php">Управление новостями</a>';

check_login_cp('3_9','editallnews.php');

        if (empty($_SESSION['comnews'])) {
            $rstat_comnews = $db->query('SELECT * FROM ' . $db_newsrev . ' WHERE status="off"');
            $_SESSION['comnews']=mysql_num_rows($rstat_comnews);
            mysql_free_result($rstat_comnews);
        }

require_once 'template/header.php';

// Определяем вывод и сортировку

if (isset($_POST['view_catnews']))
{
	$_SESSION['view_catnews'] = intval($_POST['view_catnews']);
        if ($_POST['view_catnews']==0) unset($_SESSION['view_catnews']);
}

if (isset($_POST['view_status'])) $_SESSION['view_status'] = intval($_POST['view_status']);
if (isset($_POST['view_sort'])) $_SESSION['view_sort'] = strip_tags(htmlspecialchars($_POST['view_sort']));
if (isset($_POST['view_pages'])) $_SESSION['view_pages'] = intval($_POST['view_pages']);

?>

<style type="text/css">
    .main_list {
	border: 1px solid #A6B2D5;
	border-collapse: collapse;
	margin-top: 20px;
	}
    .main_list td {
        padding: 5px;
        text-align: center;
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

<table width="100%" border="0">
  <tr>
      <td><img src="images/news.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;Управление новостями</span></td>
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

<?
// Массовые операции

$for_mass = array();
if ( isset($_POST['selected_news']) )
{
	$for_mass = $_POST['selected_news'];
        $zapros_mass = strip_tags(implode(", ", $for_mass));

        switch ($_POST['action']) {

            case 'mass_delete': // Удаляем новость
            $r_mass_cat = $db->query  ( " SELECT category, selector, status_off FROM $db_news where selector IN ($zapros_mass) " ) or die ( mysql_error() );
                $arr_mass_cat = array();
                while($cat_array_m = mysql_fetch_array ($r_mass_cat)) {
                    if ($cat_array_m['status_off']!=1) $db->query ( "UPDATE $db_categorynews SET ncount = ncount-1 WHERE selector='$cat_array_m[category]'" );
                }
            $db->query  ( " DELETE FROM $db_news where selector IN ($zapros_mass) " ) or die ( mysql_error() );
            @ $db->query  ( " DELETE FROM $db_newsrev where news IN ($zapros_mass) " ) or die ( mysql_error() );

            $mass_message = $def_admin_mass_message_ok;
            break;
            
            case 'mass_arhiv': // Размещаем в архив
            $r_mass_cat = $db->query  ( " SELECT category, selector, status_off FROM $db_news where selector IN ($zapros_mass) " ) or die ( mysql_error() );
                $arr_mass_cat = array();
                while($cat_array_m = mysql_fetch_array ($r_mass_cat)) {
                    if ($cat_array_m['status_off']!=1) $db->query ( "UPDATE $db_categorynews SET ncount = ncount-1 WHERE selector='$cat_array_m[category]'" );
                }
            $db->query  ( " UPDATE $db_news SET status_off='1' where selector IN ($zapros_mass) " ) or die ( mysql_error() );

            $mass_message = $def_admin_mass_message_ok;
            break;

            case 'mass_view_news': // Удаляем из архива
            $r_mass_cat = $db->query  ( " SELECT category, selector, status_off FROM $db_news where selector IN ($zapros_mass) " ) or die ( mysql_error() );
                $arr_mass_cat = array();
                while($cat_array_m = mysql_fetch_array ($r_mass_cat)) {
                    if ($cat_array_m['status_off']==1) $db->query ( "UPDATE $db_categorynews SET ncount = ncount+1 WHERE selector='$cat_array_m[category]'" );
                }
            $db->query  ( " UPDATE $db_news SET status_off='0' where selector IN ($zapros_mass) " ) or die ( mysql_error() );

            $mass_message = $def_admin_mass_message_ok;
            break;        
            
            case 'mass_empry_hits': // Очищаем количество просмотров
            $db->query  ( " UPDATE $db_news SET hit='0' where selector IN ($zapros_mass) " ) or die ( mysql_error() );
            $mass_message = $def_admin_mass_message_ok;
            break;

            case 'mass_empty_rating': // Очищаем рейтинг новостей
            $db->query  ( " UPDATE $db_news SET rateNum='0', rateVal='0' where selector IN ($zapros_mass) " ) or die ( mysql_error() );
            $mass_message = $def_admin_mass_message_ok;
            break;

            case 'mass_no_comments': // Запретить комментарии
            $db->query  ( " UPDATE $db_news SET comment_off='1' where selector IN ($zapros_mass) " ) or die ( mysql_error() );
            $mass_message = $def_admin_mass_message_ok;
            break;

            case 'mass_yes_comments': // Разрешить комментарии
            $db->query  ( " UPDATE $db_news SET comment_off='0' where selector IN ($zapros_mass) " ) or die ( mysql_error() );
            $mass_message = $def_admin_mass_message_ok;
            break;

        }
}

?>

<form action="editallnews.php" method="post">
 &nbsp;&nbsp;Категория:
  <select name="view_catnews" onchange="this.form.submit();">
<?

$r_cat=$db->query ("SELECT * FROM $db_categorynews ORDER BY selector") or die ("mySQL error!");
$array_cat=array();
$res_rcat = mysql_num_rows ( $r_cat );
        for ( $jj=0; $jj<$res_rcat; $jj++ ) {
            $f_catf=$db->fetcharray ($r_cat);
            $sel_viewcat='';
            if ($_SESSION['view_catnews']==$f_catf['selector']) $sel_viewcat=' selected';
            echo '<option value="'.$f_catf['selector'].'" '.$sel_viewcat.'>'.$f_catf['category'].'</option>';
            $array_cat[$f_catf['selector']] = $f_catf['category'];
        }
?>
      <option value="0" <? if(!$_SESSION['view_catnews']) echo " selected"; ?>>Все категории</option>
  </select>
  &nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle" />&nbsp;Статус новостей:
  <select name="view_status" onchange="this.form.submit();">
    <option value="2" <? if ($_SESSION['view_status']=='2') echo ' selected'; ?>>Все новости</option>
    <option value="0" <? if ($_SESSION['view_status']=='0') echo ' selected'; ?>>Опубликованные</option>
    <option value="1" <? if ($_SESSION['view_status']=='1') echo ' selected'; ?>>Архивные</option>
  </select>
  &nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle" />&nbsp;Сортировать:
  <select name="view_sort" onchange="this.form.submit();">
    <option value="date DESC" <? if ($_SESSION['view_sort']=='date DESC') echo ' selected'; ?>>Дате</option>
    <option value="title" <? if ($_SESSION['view_sort']=='title') echo ' selected'; ?>>Заголовку</option>
  </select>

<?

    $zapros=array();
    if (isset($_SESSION['view_catnews'])) $zapros[]="category='$_SESSION[view_catnews]'";
    if (isset($_SESSION['view_status']) and ($_SESSION['view_status']<2)) $zapros[]="status_off='$_SESSION[view_status]'";
    $zapros = implode(" and ", $zapros);
    if (strlen($zapros)>0) $zapros="WHERE $zapros"; else $zapros="";
    if (isset($_SESSION['view_sort'])) $sort_news=$_SESSION['view_sort']; else $sort_news='date DESC';
 
    if (isset($_SESSION['view_pages'])) $pages=intval($_SESSION['view_pages']); else  $pages=30; // Сколько выводить новостей на странице

    $stranica="30#5#10#15#20#50#100";
    $stranica = explode("#", $stranica);
    echo '&nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle" />&nbsp;Новостей на странице:';
    echo '<select name="view_pages" onchange="this.form.submit();">';
    for ($a=0;$a<count($stranica);$a++)
    {
 	if ($pages == $stranica[$a]) echo '<option value="'.$stranica[$a].'" selected>'.$stranica[$a].'</option>';
 	else echo '<option value="'.$stranica[$a].'">'.$stranica[$a].'</option>';
    }
    echo '</select>';
    
    $r=$db->query ("SELECT title, name, selector, category, date, hit, comments, status_off FROM $db_news $zapros ORDER BY status_off DESC, $sort_news") or die ("mySQL error!");
    @$results_news = mysql_num_rows ( $r );
    @$results_news_all = mysql_num_rows ( $r );

        if ($results_news>$pages) {

    		$page1=intval($_POST['page'])*$pages;
                $r=$db->query ("SELECT title, name, selector, category, date, hit, comments, status_off FROM $db_news $zapros ORDER BY status_off DESC, $sort_news LIMIT $page1, $pages") or die ("mySQL error!");
                @$results_news = mysql_num_rows ( $r );
        }

        if ($results_news_all > $pages) {

   echo '&nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle" />&nbsp;Страница : <select name="page" onchange="this.form.submit();">';

                $z=0;
                $xp1=0;
			for($x=0; $x<$results_news_all; $x=$x+$pages)
			{
                            $xp1=$z+1;
				if ($z == $_POST['page']) {echo '<option value="'.$_POST['page'].'" selected>'.$xp1.'</option>'; } else {echo '<option value="'.$z.'">'.$xp1.'</option>';}
                                $z++;
			}
   echo '</select>'; }
       
?>
</form>
<form action="addnews.php" method="post">
    &nbsp;&nbsp;ID новости: <input type="text" name="editnews" maxlength="6" style="width: 30px;" />&nbsp;<input name="idnews" type="submit" value="Поиск" />
</form>

<script language='JavaScript' type="text/javascript">
<!--
function ckeck_uncheck_all() {
    var frm = document.editnews;
    for (var i=0;i<frm.elements.length;i++) {
        var elmnt = frm.elements[i];
        if (elmnt.type=='checkbox') {
            if(frm.master_box.checked == true){ elmnt.checked=false; }
            else{ elmnt.checked=true; }
        }
    }
    if(frm.master_box.checked == true){ frm.master_box.checked = false; }
    else{ frm.master_box.checked = true; }
}
-->
</script>

<?
// Выводим сообщения
if ($mass_message) msg_text('80%',$def_admin_message_ok, $mass_message);

?>

<form action="" method="post" name="editnews">
<table width="1000" class="main_list" align="center">
  <tr>
    <th width="200">Категория</th>
    <th width="100">Дата</th>
    <th>Заголовок</th>
    <th width="60">Просмотров</th>
    <th width="60">Комментарии</th>
    <th width="60">Трансляция</th>
    <th width="20"><input type="checkbox" name="master_box" title="Выбрать все" onclick="javascript:ckeck_uncheck_all()"></th>
  </tr>

<?

// Выводим новости

    if ($results_news>0) {

        for ( $inh=0; $inh<$results_news; $inh++ ) {
            // Обрабатываем поля
                $f_news=$db->fetcharray ($r);
                $class_yt='';
                if (!$f_news['status_off']) $yes_trans='Да'; else { $yes_trans='<span style="color:#FF0000;">Нет</span>'; $class_yt=' class="status_off"'; }
                $form_selector=intval($f_news['selector']);
                $form_title=safeHTML($f_news['title']);

                	if (strlen($form_title) > 70)
			{
				$form_title = substr($form_title, 0, 70);
				$form_title = substr($form_title, 0, strrpos($form_title, ' '));
				$form_title = trim($form_title) . ' ...';
			}

                $form_data_news=date("d.m.Y", strtotime( $f_news['date'] ));
                $form_category=intval($f_news['category']);
                $form_hit=intval($f_news['hit']);
                $form_comments=intval($f_news['comments']);

?>
  <tr class="selecttr">
    <td<? echo $class_yt; ?>><? echo $array_cat[$form_category]; ?></td>
    <td<? echo $class_yt; ?>><? echo $form_data_news; ?></td>
    <td<? echo $class_yt; ?>><div align="left" class="slink"><a title="ID новости=<? echo $form_selector; ?>" href="addnews.php?editnews=<? echo $form_selector; ?>"><? echo $form_title; ?></a></div></td>
    <td<? echo $class_yt; ?>><? echo $form_hit; ?></td>
    <td<? echo $class_yt; ?>><div class="slink"><a title="Редактировать комментарии" href="editcommentnews2.php?REQ=auth&rew_com=true&id=<? echo $form_selector; ?>"><? echo $form_comments; ?></a></div></td>
    <td<? echo $class_yt; ?>><? echo $yes_trans; ?></td>
    <td<? echo $class_yt; ?>><input name="selected_news[]" value="<? echo $form_selector; ?>" type='checkbox'></td>
  </tr>

<?

        }
    }

?>
  <tr>
    <td colspan="7">
        <div style="margin-bottom:5px; margin-top:5px; text-align: right;">
<select name="action">
<option value="">-Действие-</option>
<option value="mass_view_news">Опубликовать новости</option>
<option value="mass_arhiv">Отправить в архив</option>
<option value="mass_empry_hits">Очистить количество просмотров</option>
<option value="mass_empty_rating">Очистить рейтинг новостей</option>
<option value="mass_no_comments">Запретить комментарии</option>
<option value="mass_yes_comments">Разрешить комментарии</option>
<option value="mass_delete">Удалить новости</option>
</select>
<input name="mass" type="submit" value="Выполнить" />
</div>
    </td>
  </tr>
</table>
</form>
<br />&nbsp;&nbsp;Всего новостей - <b><? echo $results_news_all; ?></b>
<?

require_once 'template/footer.php';

?>
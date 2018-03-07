<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: static.php
-----------------------------------------------------
 Назначение: Управление статическими страницами
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$static_help;

$title_cp = 'Управление статическими страницами - ';
$speedbar = ' | <a href="static.php">Управление статическими страницами</a>';

check_login_cp('3_1','static.php');

require_once 'template/header.php';

// Определяем вывод и сортировку

if (isset($_POST['view_sort'])) $_SESSION['view_sort_static'] = strip_tags(htmlspecialchars($_POST['view_sort']));
if (isset($_POST['view_pages'])) $_SESSION['view_pages_static'] = intval($_POST['view_pages']);

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
      <td><img src="images/fset.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;Статические страницы</span></td>
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
            <td width="170" class="vclass"><img src="images/news_edit.gif" width="31" height="31" align="absmiddle" /><a href="static.php">Редактировать страницы</a></td>
            <td width="140" class="vclass"><img src="images/news_plus.gif" width="31" height="31" align="absmiddle" /><a href="addstatic.php">Добавить страницу</a></td>
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

            $db->query  ( " DELETE FROM $db_static where selector IN ($zapros_mass) " ) or die ( mysql_error() );

            $mass_message = $def_admin_mass_message_ok;
            break;
                           
            case 'mass_empry_hits': // Очищаем количество просмотров
            $db->query  ( " UPDATE $db_static SET hit='0' where selector IN ($zapros_mass) " ) or die ( mysql_error() );
            $mass_message = $def_admin_mass_message_ok;
            break;

        }
}

?>

<form action="static.php" method="post">

&nbsp;&nbsp;Сортировать:
  <select name="view_sort" onchange="this.form.submit();">
    <option value="date DESC" <? if ($_SESSION['view_sort_static']=='date DESC') echo ' selected'; ?>>Дате</option>
    <option value="title" <? if ($_SESSION['view_sort_static']=='title') echo ' selected'; ?>>Заголовку</option>
  </select>

<?


    if (isset($_SESSION['view_sort_static'])) $sort_news=$_SESSION['view_sort_static']; else $sort_news='date DESC';
 
    if (isset($_SESSION['view_pages_static'])) $pages=intval($_SESSION['view_pages_static']); else  $pages=30; // Сколько выводить новостей на странице

    $stranica="30#5#10#15#20#50#100";
    $stranica = explode("#", $stranica);
    echo '&nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle" />&nbsp;Страниц на странице:';
    echo '<select name="view_pages" onchange="this.form.submit();">';
    for ($a=0;$a<count($stranica);$a++)
    {
 	if ($pages == $stranica[$a]) echo '<option value="'.$stranica[$a].'" selected>'.$stranica[$a].'</option>';
 	else echo '<option value="'.$stranica[$a].'">'.$stranica[$a].'</option>';
    }
    echo '</select>';
    
    $r=$db->query ("SELECT title, name, selector, date, hit FROM $db_static ORDER BY $sort_news") or die ("mySQL error!");
    @$results_news = mysql_num_rows ( $r );
    @$results_news_all = mysql_num_rows ( $r );

        if ($results_news>$pages) {

    		$page1=intval($_POST['page'])*$pages;
                $r=$db->query ("SELECT title, name, selector, date, hit FROM $db_static ORDER BY $sort_news LIMIT $page1, $pages") or die ("mySQL error!");
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
<form action="addstatic.php" method="post">
    &nbsp;&nbsp;ID страницы: <input type="text" name="editnews" maxlength="6" style="width: 30px;" />&nbsp;<input name="idnews" type="submit" value="Поиск" />
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
    <th width="80">ID</th>
    <th width="120">Дата</th>
    <th>Заголовок</th>
    <th width="100">Просмотров</th>
    <th width="30"><input type="checkbox" name="master_box" title="Выбрать все" onclick="javascript:ckeck_uncheck_all()"></th>
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

                	if (strlen($form_title) > 70) $form_title = isb_sub ($form_title, 100);

                $form_data_news=date("d.m.Y", strtotime( $f_news['date'] ));
                $form_hit=intval($f_news['hit']);

        if ($def_rewrite_news == "YES") $link_static= $def_mainlocation.'/'.$f_news['name'].'.html';
	else $link_static = $def_mainlocation.'/viewstatic.php?vs='.$f_news['name'];

?>
  <tr class="selecttr">
    <td<? echo $class_yt; ?>><div class="slink"><a title="Просмотреть страницу на сайте" href="<? echo $link_static; ?>" target="_blank"><? echo $form_selector; ?></a></div></td>
    <td<? echo $class_yt; ?>><? echo $form_data_news; ?></td>
    <td<? echo $class_yt; ?>><div align="left" class="slink"><a title="ID страницы=<? echo $form_selector; ?>" href="addstatic.php?editnews=<? echo $form_selector; ?>"><? echo $form_title; ?></a></div></td>
    <td<? echo $class_yt; ?>><? echo $form_hit; ?></td>
    <td<? echo $class_yt; ?>><input name="selected_news[]" value="<? echo $form_selector; ?>" type='checkbox'></td>
  </tr>

<?

        }
    }

?>
  <tr>
    <td colspan="5">
        <div style="margin-bottom:5px; margin-top:5px; text-align: right;">
<select name="action">
<option value="">-Действие-</option>
<option value="mass_empry_hits">Очистить количество просмотров</option>
<option value="mass_delete">Удалить страницу</option>
</select>
<input name="mass" type="submit" value="Выполнить" />
</div>
    </td>
  </tr>
</table>
</form>
<br />&nbsp;&nbsp;Всего страниц - <b><? echo $results_news_all; ?></b>
<?

require_once 'template/footer.php';

?>
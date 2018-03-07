<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: case.php
-----------------------------------------------------
 Назначение: Управление документами компании
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$case_help;

$title_cp = 'Проверка документов компании - ';
$speedbar = ' | <a href="case.php">Проверка документов компании</a>';

check_login_cp('3_10','case.php');

require_once 'template/header.php';

// Определяем вывод и сортировку

if (isset($_POST['view_status_case'])) $_SESSION['view_status_case'] = intval($_POST['view_status_case']);
if (isset($_POST['view_sort_case'])) $_SESSION['view_sort_case'] = strip_tags(htmlspecialchars($_POST['view_sort_case']));
if (isset($_POST['view_pages_case'])) $_SESSION['view_pages_case'] = intval($_POST['view_pages_case']);

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
      <td><img src="images/case.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;Проверка документов компании</span></td>
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
            <td width="190" class="vclass"><img src="images/news_plus.gif" width="31" height="31" align="absmiddle" /><a href="addcase.php">Добавить документы</a></td>
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
       
            case 'mass_ok_status': // Проверенная компания

                $db->query  ( " UPDATE $db_users SET tcase='1' where selector IN ($zapros_mass) " ) or die ( mysql_error() );
                $db->query  ( " UPDATE $db_case SET status='0' where firmselector IN ($zapros_mass) " ) or die ( mysql_error() );

            $mass_message = $def_admin_mass_message_ok;
            break; 
            
            case 'mass_not_status': // Вернуть на проверку документы

                $db->query  ( " UPDATE $db_users SET tcase='0' where selector IN ($zapros_mass) " ) or die ( mysql_error() );
                $db->query  ( " UPDATE $db_case SET status='1' where firmselector IN ($zapros_mass) " ) or die ( mysql_error() );

            $mass_message = $def_admin_mass_message_ok;
            break;

            case 'mass_ok_status_mail': // Проверенная компания и e-mail

                $db->query  ( " UPDATE $db_users SET tcase='1', tmail='1' where selector IN ($zapros_mass) " ) or die ( mysql_error() );
                $db->query  ( " UPDATE $db_case SET status='0' where firmselector IN ($zapros_mass) " ) or die ( mysql_error() );

            $mass_message = $def_admin_mass_message_ok;
            break;

            case 'mass_ok_mail': // e-mail подтвержден

                $db->query  ( " UPDATE $db_users SET tmail='1' where selector IN ($zapros_mass) " ) or die ( mysql_error() );

            $mass_message = $def_admin_mass_message_ok;
            break;

            case 'mass_not_mail': // e-mail не подтвержден

                $db->query  ( " UPDATE $db_users SET tmail='0' where selector IN ($zapros_mass) " ) or die ( mysql_error() );

            $mass_message = $def_admin_mass_message_ok;
            break;

        }
}

?>

<form action="case.php" method="post">

  &nbsp;&nbsp;Статус документов:
  <select name="view_status_case" onchange="this.form.submit();">
    <option value="1" <? if ($_SESSION['view_status_case']=='1') echo ' selected'; ?>>На проверку</option>
    <option value="0" <? if ($_SESSION['view_status_case']=='0') echo ' selected'; ?>>Проверенные</option>
    <option value="2" <? if ($_SESSION['view_status_case']=='2') echo ' selected'; ?>>Все</option>
  </select>
  &nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle" />&nbsp;Сортировать:
  <select name="view_sort_case" onchange="this.form.submit();">
    <option value="date DESC" <? if ($_SESSION['view_sort_case']=='date DESC') echo ' selected'; ?>>Дате</option>
    <option value="firmname" <? if ($_SESSION['view_sort_case']=='firmname') echo ' selected'; ?>>Названию компании</option>
  </select>

<?

    $zapros='';
    if (isset($_SESSION['view_status_case'])) $zapros="status='$_SESSION[view_status_case]'"; else $zapros="status='1'";
    if ($_SESSION['view_status_case']==2) $zapros="status<2";
    if (isset($_SESSION['view_sort_case'])) $sort_case=$_SESSION['view_sort_case']; else $sort_case='date DESC';
 
    if (isset($_SESSION['view_pages_case'])) $pages=intval($_SESSION['view_pages_case']); else  $pages=30; // Сколько выводить новостей на странице

    $stranica="30#5#10#15#20#50#100";
    $stranica = explode("#", $stranica);
    echo '&nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle" />&nbsp;Компаний на странице:';
    echo '<select name="view_pages_case" onchange="this.form.submit();">';
    for ($a=0;$a<count($stranica);$a++)
    {
 	if ($pages == $stranica[$a]) echo '<option value="'.$stranica[$a].'" selected>'.$stranica[$a].'</option>';
 	else echo '<option value="'.$stranica[$a].'">'.$stranica[$a].'</option>';
    }
    echo '</select>';

    $r=$db->query ("SELECT $db_case.id, $db_case.firmselector, $db_case.status, $db_case.date, $db_case.bin, $db_case.info, $db_case.codefirm, $db_users.firmname, $db_users.selector, $db_users.tmail, $db_users.tcase, $db_users.date as fdate FROM $db_case INNER JOIN $db_users ON $db_case.firmselector = $db_users.selector WHERE $zapros ORDER BY $sort_case") or die ("mySQL error!");
    @$results_news = mysql_num_rows ( $r );
    @$results_news_all = mysql_num_rows ( $r );

        if ($results_news>$pages) {

    		$page1=intval($_POST['page'])*$pages;
                $r=$db->query ("SELECT $db_case.id, $db_case.firmselector, $db_case.status, $db_case.date, $db_case.bin, $db_case.info, $db_case.codefirm, $db_users.firmname, $db_users.selector, $db_users.tmail, $db_users.tcase, $db_users.date as fdate FROM $db_case INNER JOIN $db_users ON $db_case.firmselector = $db_users.selector WHERE $zapros ORDER BY $sort_case LIMIT $page1, $pages") or die ("mySQL error!");
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
<form action="addcase.php" method="post">
    &nbsp;&nbsp;ID компании: <input type="text" name="detal" maxlength="6" style="width: 30px;" />&nbsp;<input name="idnews" type="submit" value="Поиск" />
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
    <th width="100">Документ</th>
    <th width="70">Дата</th>
    <th>Название компании</th>
    <th width="80">Номер</th>
    <th width="200">Сопроводительная</th>
    <th width="60">e-mail</th>
    <th width="60">Статус</th>
    <th width="60">Проверена</th>
    <th width="20"><input type="checkbox" name="master_box" title="Выбрать все" onclick="javascript:ckeck_uncheck_all()"></th>
  </tr>
<?

// Выводим новости

    if ($results_news>0) {

        for ( $inh=0; $inh<$results_news; $inh++ ) {
            // Обрабатываем поля
                $f_case=$db->fetcharray ($r);
                $class_yt='';
                if ($f_case['status']==0) $yes_case='Да'; else { $yes_case='<span style="color:#FF0000;">Нет</span>'; $class_yt=' class="status_off"'; }
                if ($f_case['tmail']==1) $form_mail='<span style="color:#006600;">Подтвержден</span>'; else $form_mail='<span style="color:#FF0000;">Не подтвержден</span>';
                if ($f_case['tcase']==1) $form_case='Имеются документы'; else $form_case='-';
                $form_selector=intval($f_case['selector']);
                $form_data_case=date("d.m.Y", strtotime( $f_case['date'] ));
                $form_comments=$f_case['info'];

                $img_src=$def_mainlocation.'/includes/classes/resize.php?src='.$def_mainlocation.'/doci/' .my_crypt($f_case['fdate'].$f_case['selector']).'.'.$f_case['codefirm'].'&h=100&w=100&zc=1';
                $link_src = $def_mainlocation.'/doci/' .my_crypt($f_case['fdate'].$f_case['selector']).'.'.$f_case['codefirm'];
                $link_src_file = '../doci/' .my_crypt($f_case['fdate'].$f_case['selector']).'.'.$f_case['codefirm'];
                


?>
  <tr class="selecttr">
    <td<? echo $class_yt; ?>><? if (file_exists($link_src_file)) echo '<a href="'.$link_src.'" target="_blank"><img src="'.$img_src.'" border="0" alt="Документ" title="Документ"></a>'; ?></td>
    <td<? echo $class_yt; ?>><? echo $form_data_case; ?></td>
    <td<? echo $class_yt; ?>><div align="left" class="slink"><a title="ID компании=<? echo $form_selector; ?>" href="addcase.php?detal=<? echo $form_selector; ?>"><? echo $f_case['firmname']; ?></a></div></td>
    <td<? echo $class_yt; ?>><? echo $f_case['bin'];; ?></td>
    <td<? echo $class_yt; ?>><? echo isb_sub($f_case['info'],50); ?></td>
    <td<? echo $class_yt; ?>><? echo $form_mail; ?></td>
    <td<? echo $class_yt; ?>><? echo $form_case; ?></td>
    <td<? echo $class_yt; ?>><? echo $yes_case; ?></td>
    <td<? echo $class_yt; ?>><input name="selected_news[]" value="<? echo $form_selector; ?>" type='checkbox'></td>
  </tr>

<?

        }
    }

?>
  <tr>
    <td colspan="9">
        <div style="margin-bottom:5px; margin-top:5px; text-align: right;">
<select name="action">
<option value="">-Действие-</option>
<option value="mass_ok_status">Проверенная компания</option>
<option value="mass_not_status">Вернуть на проверку</option>
<option value="mass_ok_status_mail">Проверенная компания и e-mail</option>
<option value="mass_ok_mail">E-mail подтвержден</option>
<option value="mass_not_mail">E-mail не подтвержден</option>
</select>
<input name="mass" type="submit" value="Выполнить" />
</div>
    </td>
  </tr>
</table>
</form>
<br />&nbsp;&nbsp;Всего компаний - <b><? echo $results_news_all; ?></b>
<?

require_once 'template/footer.php';

?>
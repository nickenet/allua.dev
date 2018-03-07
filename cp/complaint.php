<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: complaint.php
-----------------------------------------------------
 Назначение: Жалобы и сообщения о нарушениях
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$complaint_help;

$title_cp = 'Жалобы на содержимое - ';
$speedbar = ' | <a href="complaint.php">Жалобы на содержимое</a>';

check_login_cp('4_7','complaint.php');

require_once 'template/header.php';

table_item_top ('Жалобы на содержимое','complaint.png');

// Массовые операции
$for_mass = array();
if ( isset($_POST['selected_news']) )
{
	$for_mass = $_POST['selected_news'];
        $zapros_mass = strip_tags(implode(", ", $for_mass));

        switch ($_POST['action']) {

            case 'mass_delete': // Удаляем жалобу
            $db->query  ( " DELETE FROM $db_complaint where id IN ($zapros_mass) " ) or die ( mysql_error() );
            $mass_message = $def_admin_mass_message_ok;
            logsto("Жалоба(ы) удалены!");
            unset($_SESSION['complaint']);
            break;

        }
}

if ($mass_message) msg_text('80%',$def_admin_message_ok, $mass_message);

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

<form action="" method="post" name="complain">
<table width="1000" class="main_list" align="center">
  <tr>
    <th width="235">Категория</th>
    <th width="60">Дата</th>
    <th width="150">URL страницы</th>
    <th width="20">ID</th>
    <th>Сообщение</th>
    <th width="100">Автор</th>
    <th width="20"><input type="checkbox" name="master_box" title="Выбрать все" onclick="javascript:ckeck_uncheck_all()"></th>
  </tr>

<?
    $r=$db->query ("SELECT * FROM $db_complaint ORDER BY date DESC") or die ("mySQL error!");
    @$results_comp = mysql_num_rows ( $r );

     for ( $inh=0; $inh<$results_comp; $inh++ ) {
            // Обрабатываем поля
                $f_comp=$db->fetcharray ($r);
                $form_id=intval($f_comp['id']);
                $form_data_comp=date("d.m.Y", strtotime( $f_comp['date'] ));
                if ($f_comp['name']!='') $form_name=$f_comp['name'].'<br>'; else $form_name='';
?>

  <tr class="selecttr">
    <td><? echo $f_comp['category']; ?></td>
    <td><? echo $form_data_comp; ?></td>
    <td><div align="left" class="slink"><a target="_blank" title="Перейти" href="<? echo $f_comp['url']; ?>"><? echo $f_comp['url']; ?></a></div></td>
    <td><div class="slink"><a title="Редактировать" href="offers.php?REQ=auth&id=<? echo $f_comp['firmselector']; ?>"><? echo $f_comp['firmselector']; ?></a></div></td>
    <td><? echo $f_comp['comment']; ?></td>
    <td><? echo $form_name.' <a href="mailto:'.$f_comp['email'].'">'.$f_comp['email'].'</a>'; ?></td>
    <td><input name="selected_news[]" value="<? echo $form_id; ?>" type='checkbox'></td>
  </tr>

<?
     }
?>
  
  <tr>
    <td colspan="7">
        <div style="margin-bottom:5px; margin-top:5px; text-align: right;">
<select name="action">
<option value="">-Действие-</option>
<option value="mass_delete">Удалить сообщения</option>
</select>
<input name="mass" type="submit" value="Выполнить" />
</div>
    </td>
  </tr>
</table>
</form>
<br />&nbsp;&nbsp;Всего жалоб - <b><? echo $results_comp; ?></b>

<?

require_once 'template/footer.php';

?>
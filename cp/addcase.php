<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: addcase.php
-----------------------------------------------------
 Назначение: Редактирование документов
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$addcase_help;

if (isset($_REQUEST['detal'])) { $form_selector=intval($_REQUEST['detal']); $editURL='?detal='.$form_selector; $title_edit_or_add='Редактировать документы'; $save_edit='Изменить'; } else { $editURL=''; $title_edit_or_add='Добавить документы'; $save_edit='Добавить'; }

$title_cp = $title_edit_or_add.' - ';
$speedbar = ' | <a href="case.php">Проверка документов компании</a> | <a href="addcase.php'.$editURL.'">'.$title_edit_or_add.'</a>';

check_login_cp('3_10','addcase.php');

require_once 'template/header.php';

$form_data_case=date( "Y-m-d H:i:s" );

?>

<table width="100%" border="0">
  <tr>
      <td><img src="images/case.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;<? echo $title_edit_or_add; ?></span></td>
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
            <td width="150" class="vclass"><img src="images/news_edit_cat.gif" width="31" height="31" align="absmiddle" /><a target="_blank" href="case_report.php?id=<? echo $form_selector; ?>">Сформировать отчет</a></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>

<?

// Обрабатываем форму
if (isset ($_POST['add_or_old'])) {

    $error_add_news='';

    // Обрабатываем поля
    $status = isset( $_POST['status'] ) ? intval( $_POST['status'] ) : 0;
    if ($status==1) $status_yes=0; else $status_yes=1;
    $mail_ok = isset( $_POST['allow_mail'] ) ? intval( $_POST['allow_mail'] ) : 0;

    $form_bin=safeHTML($_POST['bin']);
    $form_info=safeHTML($_POST['info']);
    $form_alpha=safeHTML($_POST['alpha']);
    $form_notes=safeHTML($_POST['notes']);
    $form_firmname=safeHTML($_POST['firmname']);
    $form_contact=safeHTML($_POST['contact']);
    $form_banking=safeHTML($_POST['banking']);
    $form_data_file=safeHTML($_POST['date_file']);
    $form_data_case=safeHTML($_POST['data_case']);
    $form_manager=safeHTML($_POST['manager']);
    $form_selector=intval($_POST['selector']);

    if ($form_bin=='') $error_add_news='Вы не заполнили обязательное поле!';

     // Максимальный размер загружаемого изображения в байтах
 $def_document=1; #мб
 $def_document_pic_size = $def_document * 1024 * 1024; # 1мб

// Картинки загружаем
	$imgExt = array('gif', 'png', 'jpg', 'jpeg');

	if (isset($_FILES[key]) && is_uploaded_file($_FILES[key]['tmp_name']))
	{
		$fSize = filesize($_FILES[key]['tmp_name']);
		if ($fSize < $def_document_pic_size)
		{

			$name = strtolower($_FILES[key]['name']);
			$ext = pathinfo($name, PATHINFO_EXTENSION);

			if (!in_array($ext, $imgExt))
				$error_add_news.='<br>Файл документа не был загружен!<br>К загрузке допускаются изображения с расширениями: gif, png, jpg, jpeg<br>';
			else
			{

				$name = '../doci/' . my_crypt($form_data_file.$form_selector) . '.' . $ext;

                                foreach ($imgExt as $ExtList) {
                                    @unlink('../doci/' . my_crypt($form_data_file.$form_selector) . '.' . $ExtList);
                                }

				if (move_uploaded_file($_FILES[key]['tmp_name'], $name))
					$form_codefirm = $ext;
				else
					$error_add_news.='<br>Файл документа не был загружен!<br>Сервер не смог принять данный файл.<br>';
			}
		} else
			$error_add_news.='<br>Файл документа не был загружен!<br>Превышение допустимого размера файла - '.$def_document.'Мб.<br>';
	} else $form_codefirm=safeHTML ($_POST['ext']);

}

// Добавить документы

if (($_POST['add_or_old']=='add') and ($error_add_news=='')) {

$db->query("INSERT INTO $db_case (firmselector, bin, info, alpha, codefirm, status, date, notes, banking, contact) VALUES ('$form_selector', '$form_bin', '$form_info', '$form_alpha', '$form_codefirm', '0', '$form_data_case', '$form_notes', '$form_banking', '$form_contact' )");

$db->query  ( " UPDATE $db_users SET tcase='$status', tmail='$mail_ok' WHERE selector='$form_selector' LIMIT 1 " );

        logsto("Добавлены новые документы в базу данных ID=<b>$form_selector</b>");

        $ok_news_add_message='Новые документы успешно добавлены ID=<b>'.$form_selector.'</b>';

}

// Редактировать информацию
if (($_POST['add_or_old']=='edit') and ($error_add_news=='')) {

        $db->query  ( " UPDATE $db_users SET tcase='$status', tmail='$mail_ok' WHERE selector='$form_selector' LIMIT 1 " );
        
        $db->query("UPDATE $db_case SET status='$status_yes', date='$form_data_case', bin='$form_bin', info='$form_info', alpha='$form_alpha', codefirm='$form_codefirm', notes='$form_notes', banking='$form_banking', contact='$form_contact'  WHERE firmselector='$form_selector'");

        logsto("Документы по компании <b>$form_firmname</b> изменены. ID=<b>$form_selector</b>");

        $ok_news_add=true;

        $ok_news_add_message='Документы компании <b>"'.$form_firmname.'"</b> успешно изменены.';

}

// Отклонить документы
if ( $_POST['delete'] == $def_case_delete )

		{
                $db->query  ( "DELETE FROM $db_case WHERE firmselector='$form_selector'" ) or die ( "mySQL error, can't delete from CASE." );

                $imgExt = array('gif', 'png', 'jpg', 'jpeg');

                foreach ($imgExt as $ExtList) {
                  @unlink('../doci/' . my_crypt($form_data_file.$form_selector) . '.' . $ExtList);
                }

                logsto("Документы компании ID=<b>$form_selector</b> отклонены.");

                 // Отправляем письмо компании об отклонении документов

                $template_mail_klient= file_get_contents ('../template/' . $def_template . '/mail/dispose_of_case.tpl');

                $logo_img = glob('../logo/'.$form_selector.'.*');
                if ($logo_img[0]!='') $logo_mail='<img src="'.$def_mainlocation.'/logo/'.basename($logo_img[0]).'" hspace="3" vspace="3" />'; else $logo_mail="";
              
                $template_mail_klient = str_replace("*logo*", $logo_mail, $template_mail_klient);

                $template_mail_klient = str_replace("*title*", $def_title, $template_mail_klient);
                $template_mail_klient = str_replace("*dir_to_main*", $def_mainlocation, $template_mail_klient);
                $template_mail_klient = str_replace("*firmname*", $form_firmname, $template_mail_klient);

                if ($form_manager!='') $template_mail_klient = str_replace("*manager*", $form_manager, $template_mail_klient); else $template_mail_klient = str_replace("*manager*", $def_manager_firms, $template_mail_klient);
      
                mailHTML($f_code['mail'],$def_dispose_of_case,$template_mail_klient,$def_adminmail);

                        $ok_news_add=true;

                        $ok_news_add_message='Документы компании id = <b>"'.$form_selector.'"</b> отклонены.<br>На электронный адрес контрагента отправлено сообщение.';

		}

// Читаем информацию для редактирования

$form_action='';
if (isset($_REQUEST['detal'])) {

    $r=$db->query ("SELECT $db_case.id, $db_case.firmselector, $db_case.status, $db_case.date, $db_case.bin, $db_case.info, $db_case.alpha, $db_case.codefirm, $db_case.notes, $db_case.banking, $db_case.contact, $db_users.firmname, $db_users.selector, $db_users.tmail, $db_users.mail, $db_users.tcase, $db_users.manager, $db_users.date as fdate FROM $db_case INNER JOIN $db_users ON $db_case.firmselector = $db_users.selector WHERE $db_case.firmselector='$form_selector' LIMIT 1") or die ("mySQL error!");
    $results_case = mysql_num_rows ( $r );

    if ($results_case>0) {

    // Обрабатываем поля
    $f_case=$db->fetcharray ($r);
    $form_selector=$f_case['firmselector'];
    $form_status = intval($f_case['status']);
    $form_firmname=$f_case['firmname'];
    $form_data_case=$f_case['date'];
    $form_data_file=$f_case['fdate'];
    $form_bin=$f_case['bin'];
    $form_info=$f_case['info'];
    $form_alpha=$f_case['alpha'];
    $form_mail=$f_case['mail'];
    $form_manager=$f_case['manager'];
    $form_notes=$f_case['notes'];
    $form_banking=$f_case['banking'];
    $form_contact=$f_case['contact'];

    if ($f_case['tcase']==1) $ifstatus = "checked"; else $ifstatus = "";
    if ($f_case['tmail']==1) $ifmail = "checked"; else $ifmail = "";
    $form_action="?detal=$form_selector";
    $r_edit=true;
                $img_src=$def_mainlocation.'/includes/classes/resize.php?src='.$def_mainlocation.'/doci/' .my_crypt($f_case['fdate'].$f_case['selector']).'.'.$f_case['codefirm'].'&h=100&w=100&zc=1';
                $link_src = $def_mainlocation.'/doci/' .my_crypt($f_case['fdate'].$f_case['selector']).'.'.$f_case['codefirm'];
                $link_src_file = '../doci/' .my_crypt($f_case['fdate'].$f_case['selector']).'.'.$f_case['codefirm'];
    }
    elseif ($_POST['new_doc']=='new') {

    $r = $db->query("SELECT firmname, selector, tmail, mail, tcase, date FROM $db_users WHERE selector='$form_selector' LIMIT 1");
    $f_case = $db->fetcharray($r);
    $results_case = mysql_num_rows ( $r );

    $form_selector=$f_case['selector'];
    $form_firmname=$f_case['firmname'];
    $form_data_file=$f_case['date'];
    $form_mail=$f_case['mail'];

    if ($f_case['tcase']==1) $ifstatus = "checked"; else $ifstatus = "";
    if ($f_case['tmail']==1) $ifmail = "checked"; else $ifmail = "";
        
    }

    if ($results_case==0) $error_add_news='Компания с указанным ID не найдена!';
        
}

// Вывод формы новости
if ($ok_news_add) msg_text('80%',$def_admin_message_ok, $ok_news_add_message);

else {

if ($error_add_news!='') msg_text('80%',$def_admin_message_error, $error_add_news);

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

<? if (isset ($_REQUEST['detal']) and (empty($error_add_news)) ) { ?>


 <form action="addcase.php<? echo $form_action; ?>" method="post" enctype="multipart/form-data" id='news_form'>
 <table width="980" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="right">ID компании:</td>
    <td align="left"><b><? echo $form_selector; ?></b></td>
  </tr>
  <tr>
    <td align="right">Название компании:</td>
    <td align="left"><b><? echo $form_firmname; ?></b></td>
  </tr>
  <tr>
    <td align="right">Символьный код:</td>
    <td align="left"><input type="text" name="alpha" value="<? echo $form_alpha; ?>" style="width: 50px;" /></td>
  </tr>
  <tr>
    <td align="right">E-mail контрагента:</td>
    <td align="left"><b><? echo $form_mail; ?></b><input type="checkbox" name="allow_mail" value="1" <? echo $ifmail; ?>> Подтвержденный e-mail</td>
  </tr>
  <tr>
    <td align="right">Дата заявки:</td>
    <td align="left"><input type="text" name="data_case" value="<? echo $form_data_case; ?>" maxlength="50" style="width: 150px;" /></td>
  </tr>
  <tr>
    <td colspan="2"><hr /></td>
  </tr>
  <tr>
    <td align="right"><? echo $def_bin_rnn; ?>: <span style="color:#FF0000;">*</span></td>
    <td align="left"><input type="text" name="bin" value="<? echo $form_bin; ?>" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Сопроводительная информация:</td>
    <td align="left"><textarea name="info" cols="45" rows="5" style="width: 500px; height: 100px;"><? echo $form_info; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="2"><hr /></td>
  </tr>
  <tr>
    <td align="right">Документ:</td>
    <td align="left">
    <? if (file_exists($link_src_file)) echo '<a href="'.$link_src.'" target="_blank"><img src="'.$img_src.'" border="0" alt="Документ" title="Документ"></a><br>'; ?><input type="file" name="key" size="54"></td>
  </tr>
  <tr>
    <td colspan="2"><hr /></td>
  </tr>
  <tr>
    <td align="right">Заметки по компании:</td>
    <td align="left"><textarea name="notes" cols="45" rows="5" style="width: 500px; height: 100px;"><? echo $form_notes; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Банковские реквизиты:</td>
    <td align="left"><textarea name="banking" cols="45" rows="5" style="width: 500px; height: 100px;"><? echo $form_banking; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Контактные данные:</td>
    <td align="left"><textarea name="contact" cols="45" rows="5" style="width: 500px; height: 100px;"><? echo $form_contact; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Статус:</td>
    <td align="left">
        <input type="checkbox" name="status" value="1" <? echo $ifstatus; ?>> Проверенная компания
    </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left"><input type="submit" name="save" value="<? echo $save_edit; ?>" />
        <? if ($r_edit) { echo '<input type="hidden" name="add_or_old" value="edit" />'; echo '<input type="submit" name="delete" value="'.$def_case_delete.'" />'; echo '<input type="hidden" name="selector" value="'.$form_selector.'" />';  echo '<input type="hidden" name="category_old" value="'.$form_category.'" />'; echo '<input type="hidden" name="status_old" value="'.$form_status_off.'" />'; }
            else echo '<input type="hidden" name="add_or_old" value="add" />'; ?>
        <input type="hidden" name="date_file" value="<? echo $form_data_file; ?>" />
        <input type="hidden" name="selector" value="<? echo $form_selector; ?>" />
        <input type="hidden" name="firmname" value="<? echo $form_firmname; ?>" />
        <input type="hidden" name="manager" value="<? echo $form_manager; ?>" />
        <input type="hidden" name="ext" value="<? echo $f_case['codefirm']; ?>" />
    </td>
  </tr>
</table>
</form>

<? } else { 

echo <<<HTML

<form action="addcase.php" method="post">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files">$def_admin_uslovie</td>
        <td id="table_files_r">$def_admin_forma_find</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_admin_id_find:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="detal" maxlength="100" size="40" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type=submit name=inbut value="$def_admin_search_button" border="0" /><input type="hidden" name="new_doc" value="new" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>

HTML;

}

table_fdata_bottom();

}

require_once 'template/footer.php';

?>
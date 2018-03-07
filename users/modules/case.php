<?php
/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi & Ilya K.
  =====================================================
  Файл: case.php
  -----------------------------------------------------
  Назначение: Документы компании
  =====================================================
 */

if (!defined('ISB'))
{
	die("Hacking attempt!");
}

    $form_bin='';
    $res_case = $db->query  ( "SELECT bin, info, codefirm FROM $db_case WHERE firmselector='$f[selector]' LIMIT 1");
    $results = $db->numrows ( $res_case );
    if ($results>0) {
        $fe_case = $db->fetcharray  ( $res_case );
        $form_bin=$fe_case['bin'];
        $form_info=$fe_case['info'];
        $form_codefirm=$fe_case['codefirm'];
    }


// Документы

$empty='';

$mail_ok=intval($_REQUEST['mailok']);

if ($mail_ok!=0) {

    if ($f['tmail']==$mail_ok) {

        $db->query("UPDATE $db_users SET tmail='1' WHERE selector='$f[selector]' LIMIT 1");

        $upload = $def_mail_ok;

        $f['tmail']=1;

    } else $empty = $def_mail_ok_not;

}

if ($_POST["savebin"] == "1")
{

	$form_bin = safeHTML($_POST['bin']);
	$form_info = safeHTML($_POST['info']);

        if ($form_bin=='') $empty .= "Вы не заполнили обязательное поле - $def_bin_rnn!";

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
				$empty.='<br>Файл документа не был загружен!<br>К загрузке допускаются изображения с расширениями: gif, png, jpg, jpeg<br>';
			else
			{

				$name = '../doci/' . my_crypt($f['date'].$f['selector']) . '.' . $ext;

                                foreach ($imgExt as $ExtList) {
                                    @unlink('../doci/' . my_crypt($f['date'].$f['selector']) . '.' . $ExtList);
                                }

				if (move_uploaded_file($_FILES[key]['tmp_name'], $name))
					$form_codefirm = $ext;
				else
					$empty.='<br>Файл документа не был загружен!<br>Сервер не смог принять данный файл.<br>';
			}
		} else
			$empty.='<br>Файл документа не был загружен!<br>Превышение допустимого размера файла - '.$def_document.'Мб.<br>';
	} else $empty.='<br>Вы не загрузили файл документа!';

        if ($empty=='') {

            $db->query("UPDATE $db_users SET tcase='0' WHERE selector='$f[selector]' LIMIT 1");

            $form_data_news=date( "Y-m-d H:i:s" );

            if ($results>0) $db->query("UPDATE $db_case SET status='1', date='$form_data_news', bin='$form_bin', info='$form_info', codefirm='$form_codefirm' WHERE firmselector='$f[selector]'");
            else $db->query("INSERT INTO $db_case (firmselector, bin, info, codefirm, status, date) VALUES ('$f[selector]', '$form_bin', '$form_info', '$form_codefirm', '1', '$form_data_news')");

            $f['tcase']=0;
            
                        // Отправляем письмо администратору

                        $template_mail = file_get_contents ('../template/' . $def_template . '/mail/case.tpl');

                        $template_mail = str_replace("*title*", $def_title, $template_mail);
                        $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                        $template_mail = str_replace("*id*", $f['selector'], $template_mail);
                        $template_mail = str_replace("*firmname*", $f['firmname'], $template_mail);
                        $template_mail = str_replace("*bin*", $form_bin, $template_mail);
                        $template_mail = str_replace("*info*", $form_info, $template_mail);

                        $doc_img = $def_mainlocation. '/doci/' . my_crypt($f['mail'].$f['selector']) . '.' . $ext;

                        $template_mail = str_replace("*link*", $doc_img, $template_mail);

                        mailHTML($def_adminmail,$def_case_subject,$template_mail,$def_from_email);
        }
}

                 if ( $empty!='' ) echo '<div class="alert alert-error"><b>Внимание!</b><br>'.$empty.'</div>';

                 if ( isset ( $upload ) ) echo '<div class="alert alert-success">'.$upload.'</div>';

?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
	        <td><div id="TabbedPanels1" class="TabbedPanels">
					<ul class="TabbedPanelsTabGroup">
						<li class="TabbedPanelsTab" tabindex="0">Документы компании</li>
					</ul>
					<div class="TabbedPanelsContentGroup">
						<div class="TabbedPanelsContent">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
									<td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;">Информация по компании</span></td>
												<td width="50">&nbsp;</td>
											</tr>
										</table></td>
									<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
								</tr>
								<tr>
									<td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
									<td class="tb_cont">

										<form action="?REQ=authorize&mod=case" method="post" id='mail'>

											<table border="0" cellspacing="2" cellpadding="2" width="100%">
												<tr class="thumbnail">
													<td align="left"><span class="btn btn-large disabled">Ваш электронный адрес</span><br><br>
                                                                                                            
                                                                                                            Ваш указанный e-mail:&nbsp;<b><? echo $f['mail']; ?></b>&nbsp;<? if ($f['tmail']!=1) echo '<span class="label label-warning">не подтвержден</span>&nbsp;<span class="txt tooltip-main well">[<a title="Ваш электронный адрес еще не прошел проверку в нашей системе. Нажмите кнопку “Подтвердить”  и на Ваш электронный адрес придет сообщение с подтверждающим кодом, который укажите в форме." rel="tooltip" href="#">?</a>]</span>&nbsp;
														<input type="button" value="Подтвердить" id="code" class="btn btn-danger">&nbsp;'; else echo '<span class="label label-success">подтвержден</span>&nbsp;'; ?>
                                                                                                                <input name="js" type="hidden" value="no" id="js" />
                                                                                                                <div id="resp"></div>
                                                                                                                <? if ($f['tmail']!=1) echo 'Укажите код: <input type="text" name="mailok" id="mailok" maxlength="55" style="width:300px;" value=""> 
                                                                                                                <input id="send" type="submit" value="Сохранить" class="btn btn-warning">'; ?>
													</td>
												</tr>
											</table>
                                                                                </form>    
                                                                            <br>
                                                                                    <div class="alert alert-info">Компании в каталоге предоставившие свои документы получают знак <b>"Наличие документов"</b>. Это повысит уровень доверия к Вашей компании среди посетителей каталога. <br>Наличие подтвержденного e-mail адреса может гарантировать Вам доставку писем и заявок отправленных посетителями с нашего каталога.<br>В случае изменений в регистрационных документах, вы можете повторно отправить их на верификацию.</div>
                                                                                    
                                                                                <form action="?REQ=authorize&mod=case" method="post" enctype="multipart/form-data">
											<table border="0" cellspacing="2" cellpadding="2" width="100%">
												<tr class="thumbnail">
													<td align="left"><span class="btn btn-large disabled">Данные о компании</span><br><br>
                                                                                                            <? echo $def_bin_rnn; ?> <font color="red">*</font>: <input type="text" name="bin" maxlength="55" style="width:300px;" value="<? echo $form_bin; ?>"><br><br>
                                                                                                            Сопроводительная информация: <textarea name="info" cols="20" rows="4" style="width:400px;"><? echo $form_info; ?></textarea> <span class="txt tooltip-main well">[<a title="Сопроводительная информация может включать: местоположение юридического лица, ФИО руководителя, контактную информацию, дату регистрации и пр." rel="tooltip" href="#">?</a>]</span><br>
                                                                                                            Отсканированный документ <font color="red">*</font>: <input type="file" name="key" size="54"> <span class="txt tooltip-main well">[<a title="Отсканируйте регистрационные документы и приложите рисунок к форме. Если ваши документы в формате PDF, необходимо предварительно конвертировать их в формат JPG, GIF или PNG." rel="tooltip" href="#">?</a>]</span><br>
                                                                                                            <?
                                                                                                                if ($form_codefirm!='') { $img_src="$def_mainlocation/includes/classes/resize.php?src=$def_mainlocation/doci/" .my_crypt($f['date'].$f['selector']).".$form_codefirm&h=100&w=100&zc=1";
                                                                                                                    echo '<img src="'.$img_src.'" border="0" alt="Документ" title="Документ"><br>';
                                                                                                                }

                                                                                                                if ($results>0) echo '<input type="submit" value="Отправить на новую проверку" class="btn btn-warning">'; else  echo '<input type="submit" value="Отправить на проверку" class="btn btn-warning">';
                                                                                                                if (($f['tcase']!=1) and ($form_bin!='') and ($form_codefirm!='')) echo '<br><br><div class="alert alert-error">'.$def_doci_admin.'</div>';
                                                                                                                if ($f['tcase']==1) echo '<br><br><div class="alert alert-success">'.$def_doci_admin_yes.'</div>';
                                                                                                            ?>
                                                                                                            
                                                                                                            <input type="hidden" name="savebin" value="1">
													</td>
												</tr>
											</table>
                                                                                </form>
										

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
					</div>
				</div></td>
		</tr>
	<tr>
        <td>&nbsp;</td>
	</tr>
		<tr>
	        <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
					<div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
					<div class="CollapsiblePanelContent">
	<? echo $help_case; ?>
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
$('document').ready(function() {
$('#code').click(function() {
$.ajax({
  type: "POST",
  url: 'inc/sendcode.php',
  data: {id: <? echo $f['selector'];?> },
  cache: false,
  beforeSend: function() { $('#resp').html('<img src="../images/go.gif">'); },
  success: function(html) { $('#resp').html(html); }
});
$("#code").hide("slow");
});
});

		var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
		var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
		
	</script>
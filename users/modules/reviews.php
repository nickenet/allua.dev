<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: reviews.php
-----------------------------------------------------
 Назначение: Работа с комментариями
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$def_admin_newreg_approve = "Одобрить";
$def_admin_newreg_remove = "Отклонить";

$comment_edit="no";
$find_comment='no';

// Ответ компании

if (isset($_POST['id_com'])) {

    $id_com=intval($_POST['id_com']);
    $otvet=intval($_POST['otvet']);
    $reply = safeHTML($_POST['reply']);

    if ($reply!='') {
        if ($otvet==1) {
            $db->query  ( "UPDATE $db_reply SET reply='$reply' WHERE id_com='$id_com' and company='$f[selector]'" );
            $over = "Ваш ответ на комментарий &quot;$id_com&quot; успешно изменен.";
        } else {
    	$db->query  ( "INSERT INTO $db_reply (id_com, reply, company) VALUES ('$id_com', '$reply', '$f[selector]')" ) or die ( "ERROR010: mySQL error, cant insert into REPLY. (reviews.php)" );
        $db->query  ( "UPDATE $db_reviews SET otvet='1' WHERE id='$id_com' and company='$f[selector]'" );
        $over = "Ваш ответ на комментарий &quot;$id_com&quot; добавлен.";
        }

    } else $error = "Вы не заполнили поле ответа на комментарий!";
}

// фильтр комментариев
if (isset($_POST['type_connents'])) {

    $type_connents=intval($_POST['type_connents']);

    if ($type_connents!=0) {
    $ra=$db->query ("select * from $db_reviews where company = '$f[selector]' and rtype='$type_connents' ORDER BY id DESC") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $ra );
    if ($results_amount>0) $find_comment='ok'; else {
                if ($type_connents==1) $rtype_com_over=$def_review_type;
		if ($type_connents==2) $rtype_com_over=$def_review_type_good;
		if ($type_connents==3) $rtype_com_over=$def_review_type_bad;
        $over = "Комментарии по типу &quot;$rtype_com_over&quot; не найдены";
        $find_comment='no';

    }
    }
}

// Поиск комментария по id
if (isset($_POST['find_id'])) {

    if ($_POST['find_id']!='') {

    $seek_fid=intval($_POST['find_id']);

    $ra=$db->query ("select * from $db_reviews where company = '$f[selector]' and id='$seek_fid' ORDER BY id DESC") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $ra );
    if ($results_amount>0) $find_comment='ok'; else {

        $over = "Комментарий id=$seek_fid не найден или не относится к Вашей компании!";
        $find_comment='no';

    }
    }
}

if (isset($_POST['seek']))

{
    $seek_id=intval($_POST['seek']);

                $res_review = $db->query  ( "SELECT * FROM $db_reviews WHERE id='$seek_id' and company='$f[selector]'");
                $fe_review = $db->fetcharray  ( $res_review );

		if ($_POST["inbut"] == "$def_admin_newreg_approve") {

                    if ($fe_review['rtype']==2) $db->query("UPDATE $db_users SET rev_good=rev_good+1 WHERE selector='$f[selector]'");
                    if ($fe_review['rtype']==3) $db->query("UPDATE $db_users SET rev_bad=rev_bad+1 WHERE selector='$f[selector]'");
                    
                    $db->query ("UPDATE $db_reviews SET status='on' where id='$seek_id'") or die (mysql_error());

                    $over = "Комментарий успешно одобрен!";                     
		}

                if ($_POST["inbut"] == "$def_admin_newreg_remove") {

                    if ($fe_review['status']=='on') {
                        if ($fe_review['rtype']==2) $db->query("UPDATE $db_users SET rev_good=rev_good-1 WHERE selector='$f[selector]'");
                        if ($fe_review['rtype']==3) $db->query("UPDATE $db_users SET rev_bad=rev_bad-1 WHERE selector='$f[selector]'");
                    }

                    $db->query ("DELETE FROM $db_reviews where id='$seek_id'") or die (mysql_error());
                    $db->query ("DELETE FROM $db_reply where id_com='$seek_id'");

                    $over = "Комментарий успешно удален!";
		}

                if ($_POST["inbut"] == "$def_review_reply") {

                    $comment_edit="ok";

                    if ($fe_review['status']=='off') { $over = "Вы не можете ответить, т.к. комментарий еще не проверен администратором каталога!"; $comment_edit="no"; }
                    else {
                        $comment_edit="ok";
                        $form_id = $fe_review['id'];
                        $form_user = $fe_review['user'];
                        $form_data = undate($fe_review['date'], $def_datetype);
                        $form_message = $fe_review['review'];
                	$form_message = str_replace("<br>", "\n", $form_message);
                        $form_otvet = $fe_review['otvet'];
                        $form_reply='';
                        if ($form_otvet==1) {
                            $res_otvet = $db->query  ( "SELECT * FROM $db_reply WHERE id_com='$form_id' and company='$f[selector]'");
                            $fe_otvet = $db->fetcharray  ( $res_otvet );
                            $form_reply = $fe_otvet['reply'];
                        }
                    }

		}
}

if ($find_comment!='ok') {
if ($comment_edit=='ok') {

    $ra=$db->query ("select * from $db_reviews where company = '$f[selector]' and id='$form_id' ORDER BY id DESC") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $ra );

} else {

    $pages=15;

    $ra=$db->query ("select * from $db_reviews where company = '$f[selector]' ORDER BY id DESC") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $ra );
    @$results_amount_all = mysql_num_rows ( $ra );

    if ($results_amount>$pages) {

    		$page1=intval($_POST['page'])*$pages;

    $ra=$db->query ("select * from $db_reviews where company = '$f[selector]' ORDER BY id DESC LIMIT $page1, $pages") or die ("mySQL error!");
    @$results_amount = mysql_num_rows ( $ra );
    }
}
}

// Зашел, обнулили счетчик
if ($f[new_rev]>0) $db->query  ( "UPDATE $db_users SET new_rev='0' WHERE selector='$f[selector]'" );

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Управление комментариями</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;"><?php if (isset($_POST[find])) echo "Редактирование комментария"; else echo "Комментарии"; ?></span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont">

<?php

if ( isset ( $over ) ) echo '<div style="text-align:center; color: #006633; font-weight: bold;">'.$over.'</div><br>';
if ( isset ( $error ) ) echo '<div style="text-align:center; color: #FF0000; font-weight: bold;">'.$error.'</div><br>';

?>

<div style="text-align:right;">
<form action=?REQ=authorize&mod=reviews method=post>id комментария: <input type="text" name="find_id" style="width:40px;">&nbsp;<input type="submit" value="найти"></form>
<form action=?REQ=authorize&mod=reviews method=post>
  <select name="type_connents">
    <? if ($type_connents==0) echo '<option value="0" selected>Показать все</option>'; else echo '<option value="0">Показать все</option>';
     if ($type_connents==1) echo '<option value="1" selected>Нейтральные</option>'; else echo '<option value="1">Нейтральные</option>';
     if ($type_connents==2) echo '<option value="2" selected>Положительные</option>'; else echo '<option value="2">Положительные</option>';
     if ($type_connents==3) echo '<option value="3" selected>Отрицательные</option>'; else echo '<option value="3">Отрицательные</option>'; ?>
  </select>
  <input type="submit" value="показать">
</form>
</div>
<? if ($results_amount_all > $pages){ ?>
<div style="text-align:right;">
<form action=?REQ=authorize&mod=reviews method=post>
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
       if ($results_amount>0) {
?>
<form action="?REQ=authorize&mod=reviews" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="5">
<?
    for ( $i=0; $i<$results_amount; $i++ ) {

        $fr = $db->fetcharray  ( $ra );
        
         	if (($fr['rtype']==1) or empty($fr['rtype'])) { $color_review_type='#999999'; $class_review_type=''; $rtype_com=''; }
		if ($fr['rtype']==2) { $color_review_type='#006600'; $class_review_type='label label-success'; $rtype_com=$def_review_type_good; }
		if ($fr['rtype']==3) { $color_review_type='#FF0000'; $class_review_type='label label-warning'; $rtype_com=$def_review_type_bad; }
    
        echo '<tr class="thumbnail"><td align="middle" valign="middle" width="5%">';
        ?>
        <input type="radio" name="seek" value="<?php echo "$fr[id]";?>" style="border:0;" <?php if ( $fr[id] == $_POST['seek'] ) echo "CHECKED"; ?>><br>
        <span class="badge badge-info"><? echo 'id='.$fr['id']; ?></span>
        <?
        echo '</td>';

        $date_add = undate($fr['date'], $def_datetype);
        if ($fr['status']=='on') $status_com=''; else $status_com='<span class="label label-important"><b>не активирован</b></span>';
        if ($fr['otvet']!='1') $reply_com=''; else $reply_com='<span class="label"><b>есть ответ</b></span>';

        echo '<td align="left" valign="middle" width="95%">'.$status_com.' <span class="label label-info">'.$date_add.'</span> <span class="'.$class_review_type.'">'.$rtype_com.'</span> '.$reply_com.'<p style="color:'.$color_review_type.'; font-size:12px;">'.$fr['review'].'</p></td></tr>';
        echo '<tr><td colspan="2" align="center"></td></tr>';
    }
echo '</table>';
echo '<br><div style="text-align: center">';
echo '<input type="submit" name="inbut" class="btn btn-success" value="'.$def_review_reply.'">';
if ( ifEnabled_user ($f[flag] , "review") ) { echo '&nbsp;<input type="submit" name="inbut" class="btn btn-primary" value="'.$def_admin_newreg_approve.'">';
echo '&nbsp;<input type="submit" name="inbut" value="'.$def_admin_newreg_remove.'" class="btn btn-danger">'; }
?>
<input type="hidden" name="changed" value="true">
</div><br>
</form>
<?
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
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;">Форма ответа</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont" align="right">

<? if ($comment_edit=="ok") { ?>

<form action=?REQ=authorize&mod=reviews method=post>

<table width="550" border="0" cellspacing="1" cellpadding="5">
  <tr>
    <td width="200" align="right">id комментария:</td>
    <td width="350" align="left"><b><? echo $form_id; ?></b></td>
  </tr>
  <tr>
    <td width="200" align="right">Дата публикации:</td>
    <td width="350" align="left"><b><? echo $form_data; ?></b></td>
  </tr>
  <tr>
    <td width="200" align="right">Автор:</td>
    <td width="350" align="left"><b><? echo $form_user; ?></b></td>
  </tr>
  <tr>
    <td width="200" align="right">Текст комментария:</td>
    <td width="350" align="left"><? echo $form_message; ?></td>
  </tr>
  <tr>
    <td width="200" align="right">Ответ: <span style="color: #FF0000;">*</span></td>
    <td width="350" align="left"><textarea name="reply" cols="45" rows="5" style="width:350px; height:150px;"><? echo $form_reply; ?></textarea></td>
  </tr>
</table>
    <input type="submit" name="inbut" class="btn btn-success" value="<? if ($form_otvet==1) echo $def_change; else echo $def_review_reply; ?>">
    <input type="hidden" name="id_com" value="<? echo $form_id; ?>">
    <input type="hidden" name="otvet" value="<? echo $form_otvet; ?>">
    
</form>
<br><br>

<? } else echo '<br><div style="text-align:center;">Для публикации ответа, выберите комментарий и нажмине кнопку &quot;Ответить&quot;.</div><br>'; ?>
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
            <? echo "$help_reviews"; ?>
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
</script>
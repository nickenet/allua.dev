<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: admin_user.php
-----------------------------------------------------
 Назначение: Управление администраторами
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$admin_user_help;

$title_part = 'Управление администраторами';

if ($_GET['editadmin']=='newadminsystem') {

$title_cp = 'Добавить администратора - ';
$speedbar = ' | <a href="admin_user.php">Управление администраторами</a> | <a href="admin_user.php?editadmin=newadminsystem">Добавить администратора</a>';
$title_part = 'Добавить администратора';

} else {

$title_cp = 'Управление администраторами - ';
$speedbar = ' | <a href="admin_user.php">Управление администраторами</a>';

}

check_login_cp('0_0','admin_user.php');

require_once 'template/header.php';

?>

<style type="text/css">
    .main_list {
	border: 1px solid #A6B2D5;
	border-collapse: collapse;
	}
    .main_list td {
        padding: 5px;
        text-align: left;
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
      <td><img src="images/eduser.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;<? echo $title_part; ?></span></td>
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
                <td width="450" class="vclass"><img src="images/news_plus.gif" width="31" height="31" align="absmiddle" /><a href="admin_user.php?editadmin=newadminsystem">Добавить администратора</a></td>
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

            case 'mass_delete': // Удаляем администраторов
            $db->query  ( " DELETE FROM $db_admin where num IN ($zapros_mass) " ) or die ( mysql_error() );
            $mass_message = 'Администратор(ы) удалены!';
            break;

            case 'mass_off': // Отключаем администратора
            $db->query  ( " UPDATE $db_admin SET password='' where num IN ($zapros_mass) " ) or die ( mysql_error() );
            $mass_message = 'Администратор(ы) отключены!';
            break;

        }
        
        if ($mass_message!='') {
        	msg_text('80%',$def_admin_message_ok,$mass_message);
                logsto("$mass_message");
        }
}


// Добавляем администратора
if ($_POST['new_admin']=='add') {
$login = safeHTML($_POST['idlogin']);

    				$r_l = $db->query ("SELECT login FROM $db_admin WHERE login='$login'");
				$logins = mysql_num_rows ( $r_l );
				$db->freeresult  ( $r_l );

if (($logins>0) or ($login=='')) {

    msg_text('80%',$def_admin_message_error,'Указанный Вами логин администратора '.$login.' уже существует в системе!');

} else {

$name = safeHTML($_POST['idname']);
$icq = safeHTML($_POST['idisq']);
$phone = safeHTML($_POST['idphone']);
$mail = safeHTML($_POST['idmail']);
$adress = safeHTML($_POST['idadress']);
$password = safeHTML($_POST['idpassword']);
if ($password!='') $admin_password=md5($_POST['idpassword']); else $admin_password=md5($password);
$accsess='helper';
$menu_start='0:1:1:0:1:0#<li><a href="firms.php?REQ=auth">Активация контрагентов</a></li><li><a href="register.php">Создать нового контрагента</a></li><li><a href="reviews2.php?REQ=auth">Одобрить комментарии</a></li>';

@mysql_query("insert into $db_admin (login, password, name, mail, icq, phone, adress, menu, access) values ('$login','$admin_password', '$name', '$mail', '$icq', '$phone', '$adress', '$menu_start', '$accsess')");

		msg_text('80%',$def_admin_message_ok,'Администратор '.$name.' успешно добавлен!');
                logsto("Добавлен администратор - $name");
}

}

if ($_POST['new_admin']=='edit') {

        $name = safeHTML($_POST['idname']);
        $login = safeHTML($_POST['idlogin']);
        $login_old = safeHTML($_POST['login_old']);
        if ($login=='') $login = $login_old;
        $icq = safeHTML($_POST['idisq']);
        $phone = safeHTML($_POST['idphone']);
        $mail = safeHTML($_POST['idmail']);
        $adress = safeHTML($_POST['idadress']);
        $password = safeHTML($_POST['idpassword']);

        $r_p = $db->query ("SELECT password FROM $db_admin WHERE login='$login_old' LIMIT 1");
        $fp_admin=$db->fetcharray ($r_p);

        if ($password!=$fp_admin['password']) $password=md5($password);
        
            $db->query  ( "UPDATE $db_admin SET name='$name', login='$login', password='$password', icq='$icq', phone='$phone', adress='$adress' WHERE login='$login_old'");
            msg_text('80%',$def_admin_message_ok,'Данные администратора '.$login.' обновлены!');
            logsto("Обновлены данные в профиле администратора - $login");
       
}

if ($_POST['new_admin']=='menu') {

        $menu_start=$_POST['r1'].':'.$_POST['r2'].':'.$_POST['r3'].':'.$_POST['r4'].':'.$_POST['r5'].':'.$_POST['r6'].':'.$_POST['r7'].'#';
        $login_old = safeHTML($_POST['login_old']);


        if ($_POST['r1']==1) $menu_start.='<li><a href="search.php?REQ=auth">Найти/Редактировать контрагента</a></li>';
        if ($_POST['r2']==1) $menu_start.='<li><a href="firms.php?REQ=auth">Активация контрагентов</a></li>';
        if ($_POST['r3']==1) $menu_start.='<li><a href="register.php">Создать нового контрагента</a></li>';
        if ($_POST['r4']==1) $menu_start.='<li><a href="reviews.php?REQ=auth">Найти/Удалить/Редактировать комментарии</a></li>';
        if ($_POST['r5']==1) $menu_start.='<li><a href="reviews2.php?REQ=auth">Одобрить комментарии</a></li>';
        if ($_POST['r6']==1) $menu_start.='<li><a href="up_rating.php">Изменить рейтинг компании</a></li>';
        if ($_POST['r7']==1) $menu_start.='<li><a href="addnews.php">Добавить новость</a></li>';

        $db->query ("UPDATE $db_admin SET menu = '$menu_start' WHERE login='$login_old'");
	msg_text('80%',$def_admin_message_ok,'Разделы быстрого меню обновлены для администратора - '.$login_old);
        logsto("Обновлены разделы быстрого меню для администратора - $login_old");

    }


if (isset($_GET['editadmin'])) {

if ($_GET['editadmin']!='newadminsystem') $login_edit_admin = safeHTML($_GET['editadmin']);

$r_admin=$db->query ( "select * from $db_admin where login='$login_edit_admin'");
@$results_admin_login = mysql_num_rows ( $r_admin );

    if ($results_admin_login>0) {
        $fl_admin=$db->fetcharray ($r_admin);

        $form_admin_name = $fl_admin['name'];
        $form_admin_login = $fl_admin['login'];
        $form_admin_mail = $fl_admin['mail'];
        $form_icq_admin = $fl_admin['icq'];
        $form_phone_admin = $fl_admin['phone'];
        $form_adress_admin = $fl_admin['adress'];
        $form_admin_password = $fl_admin['password'];
        $form_adress_menu = $fl_admin['menu'];
        $form_edit_admin='yes';
        
    }

?>

<link href="template/tabcss.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
$(function () {
    var tabContainers = $('div.tabs > div');
    tabContainers.hide().filter(':first').show();

    $('div.tabs ul.tabNavigation a').click(function () {
        tabContainers.hide();
        tabContainers.filter(this.hash).show();
        $('div.tabs ul.tabNavigation a').removeClass('selected');
        $(this).addClass('selected');
        return false;
    }).filter(':first').click();
});
</script>
<div class="tabs">
    <ul class="tabNavigation">
        <li><a class="" href="#first"><img src="images/conf_users.png" width="22" height="22" align="absmiddle" />Профиль</a></li>
        <? if ($_GET['editadmin']!='newadminsystem') { ?><li><a class="" href="#third"><img src="images/menu.png" width="22" height="22" align="absmiddle" />Разделы быстрого меню</a></li><? } ?>
    </ul>
    <div id="first">
<form action="admin_user.php" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_list">
      <tr>
        <th width="250">Название</th>
        <th>Текущие данные</th>
        </tr>
        <tr>
          <td width="250">Имя:</td>
          <td class="leftb"><input type="text" name="idname" maxlength="100" size="40" value="<? echo $form_admin_name; ?>" /></td>
        </tr>
        <tr>
          <td width="250">Логин администратора:</td>
          <td><input type="text" name="idlogin" maxlength="100" size="40" value="<? echo $form_admin_login; ?>" /></td>
        </tr>
        <tr>
          <td width="250">Пароль администратора:</td>
          <td><div style="padding-top: 5px; padding-bottom: 5px;"><input type="password" name="idpassword" maxlength="100" size="50" value="<? echo $form_admin_password; ?>" /><br /><span style="color:#666;">Для отключения администратора очистите данное поле</span></div></td>
        </tr>
        <tr>
          <td width="250">E-mail:</td>
          <td><input type="text" name="idmail" maxlength="100" size="40" value="<? echo $form_admin_mail; ?>" /></td>
        </tr>
        <tr>
          <td width="250">Messenger:</td>
          <td><input type="text" name="idisq" maxlength="100" size="40" value="<? echo $form_icq_admin; ?>" /></td>
        </tr>
        <tr>
          <td width="250">Телефон:</td>
          <td><input type="text" name="idphone" maxlength="100" size="40" value="<? echo $form_phone_admin; ?>" /></td>
        </tr>
        <tr>
          <td width="250">Адрес:</td>
          <td><input type="text" name="idadress" maxlength="100" size="40" value="<? echo $form_adress_admin; ?>" /></td>
        </tr>
      </table>
<div style="margin-bottom:5px; margin-top:5px;"><input type="submit" name="inbut" value="Сохранить" /></div>
<? if ($form_edit_admin!='yes') echo '<input type="hidden" name="new_admin" value="add" />'; else { echo '<input type="hidden" name="new_admin" value="edit" /><input type="hidden" name="login_old" value="'.$form_admin_login.'" />'; } ?>
    </td>
  </tr>
</table>
</form>
    </div>

    <? if ($_GET['editadmin']!='newadminsystem') { ?>

    <div id="third">

        <? $punkt_menu=explode(":", $form_adress_menu); ?>
        
<form action="admin_user.php" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_list">
      <tr>
        <th width="250">Название разделов</th>
        <th>Использовать</th>
        </tr>
        <tr>
          <td width="250">Найти/Редактировать контрагента:</td>
          <td><select name="r1"><option value="1" <? if($punkt_menu[0]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[0]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250">Активация контрагентов:</td>
          <td><select name="r2"><option value="1" <? if($punkt_menu[1]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[1]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250">Создать нового контрагента:</td>
          <td><select name="r3"><option value="1" <? if($punkt_menu[2]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[2]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250">Найти/Удалить/Редактировать комментарии:</td>
          <td><select name="r4"><option value="1" <? if($punkt_menu[3]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[3]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250">Одобрить комментарии:</td>
          <td><select name="r5"><option value="1" <? if($punkt_menu[4]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[4]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250">Изменить рейтинг:</td>
          <td><select name="r6"><option value="1" <? if($punkt_menu[5]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[5]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250">Добавить новость:</td>
          <td><select name="r7"><option value="1" <? if($punkt_menu[6]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[6]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
      </table>
<div style="margin-bottom:5px; margin-top:5px;"><input type="submit" name="inbut" value="Сохранить" /></div>
<input type="hidden" name="new_admin" value="menu" /><input type="hidden" name="login_old" value="<? echo $form_admin_login; ?>" />
    </td>
  </tr>
</table>
</form>
    </div>

    <? } ?>

</div>

<? } else { ?>

<form action="" method="post" name="editnews">
<table width="1000" class="main_list" align="center">
  <tr>
    <th width="200">Имя</th>
    <th width="150">Логин</th>
    <th>E-mail</th>
    <th width="80">Messenger</th>
    <th width="100">Телефон</th>
    <th width="200">Адрес</th>
    <th width="70">Статус</th>
    <th width="20"><input type="checkbox" name="master_box" title="Выбрать все" onclick="javascript:ckeck_uncheck_all()"></th>
  </tr>
<?

// Выводим админов

$r=$db->query ( "select * from $db_admin ORDER BY login");
@$results_admin = mysql_num_rows ( $r );

    if ($results_admin>0) {

        for ( $inh=0; $inh<$results_admin; $inh++ ) {
            // Обрабатываем поля
                $f_admin=$db->fetcharray ($r);
                if ($f_admin['password']!='') $yes_trans='Включен'; else { $yes_trans='<span style="color:#FF0000;">Отключен</span>'; $class_yt=' class="status_off"'; }
                if ($f_admin['access']=='helper') $link_edit='admin_user.php?editadmin='.$f_admin['login']; else  $link_edit='profil.php';
                if ($f_admin['access']=='helper') $mass_selected='<input name="selected_news[]" value="'.$f_admin['num'].'" type="checkbox">'; else $mass_selected='';

?>
  <tr class="selecttr">
    <td<? echo $class_yt; ?>><? echo $f_admin['name']; ?></td>
    <td<? echo $class_yt; ?>><div align="left" class="slink"><a title="ID администратора=<? echo $f_admin['num']; ?>" href="<? echo $link_edit; ?>"><? echo $f_admin['login']; ?></a></div></td>
    <td<? echo $class_yt; ?>><? echo $f_admin['mail']; ?></td>
    <td<? echo $class_yt; ?>><? echo $f_admin['icq']; ?></td>
    <td<? echo $class_yt; ?>><? echo $f_admin['phone']; ?></td>
    <td<? echo $class_yt; ?>><? echo $f_admin['adress']; ?></td>
    <td<? echo $class_yt; ?>><div align="center"><? echo $yes_trans; ?></div></td>
    <td<? echo $class_yt; ?>><? echo $mass_selected; ?></td>
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
<option value="mass_delete">Удалить</option>
<option value="mass_off">Отключить</option>
</select>
<input name="mass" type="submit" value="Выполнить" />
</div>
    </td>
  </tr>
</table>
</form>

<?

}

require_once 'template/footer.php';

?>
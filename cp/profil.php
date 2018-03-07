<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: profil.php
-----------------------------------------------------
 Назначение: Администратор
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$profil_help;

$title_cp = 'Администратор - ';
$speedbar = ' | <a href="profil.php">Администратор</a>';

check_login_cp('0_0','profil.php');

require_once 'template/header.php';

table_item_top ("Администратор - управление",'eduser.png');

if (isset($_GET['edit'])) {

    if ($_GET['edit']=='profil') {

        $name = safeHTML($_POST['idname']);
        $login = safeHTML($_POST['idlogin']);
        $icq = safeHTML($_POST['idisq']);
        $phone = safeHTML($_POST['idphone']);
        $adress = safeHTML($_POST['idadress']);

            if (strlen($login)>4) {

            $db->query  ( "UPDATE $db_admin SET name='$name', login='$login', icq='$icq', phone='$phone', adress='$adress' WHERE num='$_SESSION[num_admin]'");
            $_SESSION = array();
            msg_text('80%',$def_admin_message_ok,'Данные администратора обновлены. <a href="profil.php">Авторизируйтесь.</a>');
            logsto("Обновлены данные в профиле администратора.");
        
            } else
        
            {

                msg_text('80%',$def_admin_message_error,$def_login_short);

            }
    }

    if ($_GET['edit']=='password') {

        $oldpass2=md5($_POST['password']);

	$r=$db->query ("SELECT password from $db_admin WHERE num='$_SESSION[num_admin]'");
	$f=$db->fetcharray ($r);

	$oldpass=$f['password'];

	if (($_POST['password1'] == $_POST['password2']) and ($_POST['password1'] != "") and ($oldpass == $oldpass2))

	{
		$newpass=md5($_POST[password1]);
		$db->query ("UPDATE $db_admin SET password = '$newpass' WHERE num='$_SESSION[num_admin]'");
                $_SESSION = array();
		msg_text('80%',$def_admin_message_ok,'Данные администратора обновлены. <a href="profil.php">Авторизируйтесь.</a>');
                logsto("Изменен пароль администратора.");
	}

	else

	msg_text('80%',$def_admin_message_error,$def_passwd_error);
    }

        if ($_GET['edit']=='menu') {

        $menu_start=$_POST['r1'].':'.$_POST['r2'].':'.$_POST['r3'].':'.$_POST['r4'].':'.$_POST['r5'].':'.$_POST['r6'].':'.$_POST['r7'].'#';

        if ($_POST['r1']==1) $menu_start.='<li><a href="search.php?REQ=auth">Найти/Редактировать контрагента</a></li>';
        if ($_POST['r2']==1) $menu_start.='<li><a href="firms.php?REQ=auth">Активация контрагентов</a></li>';
        if ($_POST['r3']==1) $menu_start.='<li><a href="register.php">Создать нового контрагента</a></li>';
        if ($_POST['r4']==1) $menu_start.='<li><a href="reviews.php?REQ=auth">Найти/Удалить/Редактировать комментарии</a></li>';
        if ($_POST['r5']==1) $menu_start.='<li><a href="reviews2.php?REQ=auth">Одобрить комментарии</a></li>';
        if ($_POST['r6']==1) $menu_start.='<li><a href="up_rating.php">Изменить рейтинг компании</a></li>';
        if ($_POST['r7']==1) $menu_start.='<li><a href="addnews.php">Добавить новость</a></li>';

        $db->query ("UPDATE $db_admin SET menu = '$menu_start' WHERE num='$_SESSION[num_admin]'");
        $_SESSION = array();
	msg_text('80%',$def_admin_message_ok,'Разделы быстрого меню обновлены. <a href="profil.php">Авторизируйтесь.</a>');
        logsto("Обновлены разделы быстрого меню.");

    }

}

else {

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
        <li><a class="" href="#second"><img src="images/key_password.png" width="22" height="22" align="absmiddle" />Смена пароля</a></li>
        <li><a class="" href="#third"><img src="images/menu.png" width="22" height="22" align="absmiddle" />Разделы быстрого меню</a></li>
    </ul>
    <div id="first">
<form action="profil.php?edit=profil" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files">Название</td>
        <td id="table_files_r">Текущие данные</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Имя:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idname" maxlength="100" size="40" value="<? echo $_SESSION['name_admin']; ?>" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Логин администратора:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idlogin" maxlength="100" size="40" value="<? echo $_SESSION['admin_login']; ?>" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">E-mail:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idmail" maxlength="100" size="40" value="<? echo  $def_adminmail; ?>" disabled="true" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Номер ICQ:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idisq" maxlength="100" size="40" value="<? echo $_SESSION['icq_admin']; ?>" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Телефон:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idphone" maxlength="100" size="40" value="<? echo $_SESSION['phone_admin']; ?>" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Адрес:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idadress" maxlength="100" size="40" value="<? echo $_SESSION['adress_admin']; ?>" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type="submit" name="inbut" value="Сохранить" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
    </div>
    <div id="second">
<form action="profil.php?edit=password" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files">Название</td>
        <td id="table_files_r">Данные</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i"><? echo "$def_admin_password_old"; ?>:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="password" name="password" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i"><? echo "$def_admin_password_new"; ?>:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="password1" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i"><? echo "$def_admin_repeat $def_admin_password_new";?>:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="password2" maxlength="100" size="40" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type="submit" name="inbut" value="Сохранить" border="0" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
    </div>
    <div id="third">

        <? $punkt_menu=explode(":", $_SESSION['menu_punkt']); ?>
        
<form action="profil.php?edit=menu" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files">Название разделов</td>
        <td id="table_files_r">Использовать</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Найти/Редактировать контрагента:</td>
          <td class="blue_txt" id="table_files_i_r"><select name="r1"><option value="1" <? if($punkt_menu[0]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[0]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Активация контрагентов:</td>
          <td class="blue_txt" id="table_files_i_r"><select name="r2"><option value="1" <? if($punkt_menu[1]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[1]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Создать нового контрагента:</td>
          <td class="blue_txt" id="table_files_i_r"><select name="r3"><option value="1" <? if($punkt_menu[2]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[2]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Найти/Удалить/Редактировать комментарии:</td>
          <td class="blue_txt" id="table_files_i_r"><select name="r4"><option value="1" <? if($punkt_menu[3]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[3]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Одобрить комментарии:</td>
          <td class="blue_txt" id="table_files_i_r"><select name="r5"><option value="1" <? if($punkt_menu[4]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[4]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Изменить рейтинг:</td>
          <td class="blue_txt" id="table_files_i_r"><select name="r6"><option value="1" <? if($punkt_menu[5]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[5]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Добавить новость:</td>
          <td class="blue_txt" id="table_files_i_r"><select name="r7"><option value="1" <? if($punkt_menu[6]==1) echo 'selected="selected"'; ?>>Да</option><option value="0" <? if($punkt_menu[6]==0) echo 'selected="selected"'; ?>>Нет</option></select></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type="submit" name="inbut" value="Сохранить" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
    </div>
</div>

<?

}

require_once 'template/footer.php';

?>
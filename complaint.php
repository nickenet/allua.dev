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
 Назначение: Пожаловаться на содержимое
=====================================================
*/

include( "./defaults.php" );

session_start();

if (!isset($_SESSION['random'])) $_SESSION['random'] = mt_rand(1000000,9999999);

$rand = mt_rand(1, 999);

$incomingline = $def_complaint;

$help_section = $complaint_help;

include ( "./template/$def_template/header.php" );

// Обрабатываем сообщение
if ( isset($_GET['REQ']) and ($_POST['security'] != $_SESSION['random']) and ($def_security_enable == "YES")) {

    $def_message_error=$error_captcha;
    include ( "./includes/error_page.php" );

} else {

    if ( isset($_GET['REQ']) and ($_POST['security'] == $_SESSION['random']) and ($def_security_enable == "YES")) {

        $name_user = safeHTML($_POST['name']);
        $email_user = safeHTML($_POST['mail']);
        $cat_complaint = safeHTML($_POST['category']);
        $text_complaint = safeHTML($_POST['text']);
        $id_firma = intval($_POST['firma_id']);
        $url_complaint = $def_mainlocation.'/view.php?id='.$id_firma;

        if (($email_user!='') or ($cat_complaint!='')) {

            $template_mail = file_get_contents ('template/' . $def_template . '/mail/complaint.tpl');

            $template_mail = str_replace("*title*", $def_title, $template_mail);
            $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
            $template_mail = str_replace("*url*", $url_complaint, $template_mail);
            $template_mail = str_replace("*category*", $cat_complaint, $template_mail);
            $template_mail = str_replace("*mail*", $email_user, $template_mail);
            $template_mail = str_replace("*name*", $name_user, $template_mail);
            $template_mail = str_replace("*text*", $text_complaint, $template_mail);

            mailHTML($def_adminmail,$def_complaint_subject,$template_mail,$def_adminmail);

            $data_complaint=date( "Y-m-d H:i:s" );

            $db->query  ( "INSERT INTO $db_complaint (date, url, category, name, email, comment, firmselector) VALUES ('$data_complaint', '$url_complaint', '$cat_complaint', '$name_user', '$email_user','$text_complaint', '$id_firma')" ) or die (mysql_error());

            unset($_SESSION['complaint']);

        $def_title_error=$def_thanks;
        $def_message_error=$def_complaint_ok_txt;
        include ( "./includes/error_page.php" );
        unset($_SESSION['random']);

        $ok_complaint='ok';

        include ( "./template/$def_template/footer.php" );

        } else {
                    $def_message_error=$def_dogtag;
                    include ( "./includes/error_page.php" );
        }
    }
}

?>

<script type="text/javascript" src="includes/jquery.validate.min.js"></script>
<script type="text/javascript" src="includes/messages_ru.js"></script>

<?

if (!$ok_complaint) {

$titlecompare=$def_complaint;

main_table_top ($titlecompare); // Вверх заголовка

$template = new Template;

$template->set_file('complaint.tpl');

if (isset($_REQUEST['firma_id'])) {

    $id_firma=intval($_REQUEST['firma_id']);
    $template->replace("url", $def_mainlocation.'/view.php?id='.$id_firma);
    $template->replace("id_firma", $id_firma);

} else { $template->replace("url", ''); $template->replace("id_firma", ''); }

if (isset($name_user)) $template->replace("rezult_name", $name_user); else $template->replace("rezult_name", '');
if (isset($email_user)) $template->replace("rezult_mail", $email_user); else $template->replace("rezult_mail", '');
if (isset($text_complaint)) $template->replace("rezult_text", $text_complaint); else $template->replace("rezult_text", '');

$template->replace("dir_to_main", $def_mainlocation);
$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

$template->replace("security", "<img src=\"security.php?$rand\" />");

$template->publish();

main_table_bottom(); // Низ заголовка

include ( "./template/$def_template/footer.php" );

}

?>
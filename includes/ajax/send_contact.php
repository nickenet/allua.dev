<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Maid
=====================================================
 Файл: send_contact.php
-----------------------------------------------------
 Назначение: Отправка сообщения админу
=====================================================
*/

session_start();
     
header("Content-type: text/plain; charset=windows-1251");

// Including configuration file
include ( "../../conf/config.php" );

// Including functions
include ( "../../includes/functions.php" );

// Including language pack
include ( "../../lang/language.$def_language.php" );

if (($_POST['text']=="") or ($_POST['mail']=="")) { echo '$("#ok_send").html("<div class=\"error_captcha\">'.$def_dogtag.'</div>");'; exit; }

if ($_POST['security'] != $_SESSION['random']) {
    
     echo '$("#ok_send").html("<div class=\"error_captcha\">'.$error_captcha.'</div>");';
    
} else {

                @ $ip1=$_SERVER["HTTP_X_FORWARDED_FOR"];
		@ $ip2=$_SERVER["REMOTE_ADDR"];

		$to_admin=intval($_POST['admin']);
                if ($to_admin==1) { $to = $def_adminmail; $subject_mail=$def_subject_mail_admin; }
                if ($to_admin==2) { $to = $def_reklamamail; $subject_mail=$def_subject_mail_reklama; }
                if ($to_admin==3) { $to = $def_financemail; $subject_mail=$def_subject_mail_finance; }
                
                if ($to=="") $to=$def_adminmail;

                    $mail = safeHTML ($_POST['mail']);

                    $date_request = date("d-m-Y");
             
                    $user=@iconv("UTF-8", "windows-1251", $_POST['name']);
                    $user=safeHTML($user);
                    
                    $phone= @iconv("UTF-8", "windows-1251", $_POST['tel']);
                    $phone=safeHTML($phone);
                    
                    $mail=safeHTML($_POST['mail']);                   
                   
                    $text = @iconv("UTF-8", "windows-1251", $_POST['text']);
                    $text=safeHTML(strip_tags($text));

                    $template_mail = file_get_contents ('../../template/' . $def_template . '/mail/contact.tpl');

                    $template_mail = str_replace("*title*", $def_title, $template_mail);
                    $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                    $template_mail = str_replace("*name*", $user, $template_mail);
                    $template_mail = str_replace("*phone*", $phone, $template_mail);
                    $template_mail = str_replace("*mail*", $mail, $template_mail);
                    $template_mail = str_replace("*type*", $subject_mail, $template_mail);
                    $template_mail = str_replace("*message*", $text, $template_mail);
                    $template_mail = str_replace("*message*", $text, $template_mail);

                    $template_mail = str_replace("*Ip1*", $ip1, $template_mail);
                    $template_mail = str_replace("*Ip2*", $ip2, $template_mail);
                     
                    $template_mail = str_replace("*data*", $date_request, $template_mail);

                    mailHTML($to,$subject_mail,$template_mail,$mail);

                    unset($_SESSION['random']);

 echo '$("#ok_send").html("<div class=\"ok_message\">';

    echo $def_complaint_ok_txt;

echo '</div>");';
echo '$("#send_div").hide();';                
}
        exit;
?>      	

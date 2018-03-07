<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Maid
=====================================================
 Файл: sendmessage.php
-----------------------------------------------------
 Назначение: Отправка сообщения
=====================================================
*/

session_start();
header("Content-type: text/html; charset=windows-1251");

if(empty($_POST['js'])){

if ($_POST['security'] != $_SESSION['random']) { echo 3; exit; }

if($_POST['message'] != '' && $_POST['author'] != '' && $_POST['security'] != ''){
            
include ("../conf/config.php");
include ("../includes/functions.php");
include ("../includes/$def_dbtype.php");
include ("../connect.php");
include ("../includes/sqlfunctions.php");
$lang = $def_language;
include ("../lang/language.$lang.php");
include ("conf/config.php");

                $id=intval($_POST['id_firm']);        

                $r = $db->query  ( "SELECT * FROM $db_users WHERE selector='$id' $hide_d" );
		$f = $db->fetcharray  ( $r );

		$to = $f['mail'];

                if ($to!='') {
                    $from = @iconv("UTF-8", "windows-1251", $_POST['author']);
                    $from = safeHTML($from);
                    $texty = @iconv("UTF-8", "windows-1251", $_POST['message']);
                    $texty = safeHTML($texty);
                    $subject = "$def_messagefromavisitor ($from)$def_review_for $f[firmname] (id $f[selector], $f[mail])";

                    $logo_img = glob('../logo/'.$id.'.*');

                    if ($logo_img[0]!='') $logo_mail='<img src="'.$def_mainlocation.'/logo/'.basename($logo_img[0]).'" hspace="3" vspace="3" />'; else $logo_mail="";

                    $template_mail = file_get_contents ('template/' . $def_template . '/mail/mail.tpl');

                    $template_mail = str_replace("*title*", $def_title, $template_mail);
                    $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                    $template_mail = str_replace("*firmname*", $f['firmname'], $template_mail);
                    $template_mail = str_replace("*text*", $texty, $template_mail);
                    $template_mail = str_replace("*mail*", $from, $template_mail);
                    $template_mail = str_replace("*logo*", $logo_mail, $template_mail);
                    if ($f['manager']!='') $template_mail = str_replace("*manager*", $f['manager'], $template_mail); else $template_mail = str_replace("*manager*", $def_manager_firms, $template_mail);

                    @mail($to,stripcslashes($subject),stripcslashes($template_mail),"From: $from\r\nContent-Type: text/html; charset=windows-1251\r\n"."Reply-To: $from\r\n"."MIME-Version: 1.0\n"."X-Sender: $from\n"."X-Mailer: I-Soft Bizness\n"."X-Priority: 3 (Normal)\n");

                    unset($_SESSION['random']);
                    
                echo 0;

                } else echo 1;


        exit;

	} else  echo 2; 
}

?>      	

<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Maid
=====================================================
 Файл: sendcode.php
-----------------------------------------------------
 Назначение: Отправка кода
=====================================================
*/

session_start();
     
header("Content-type: text/plain; charset=windows-1251");

// Including configuration file
include ( "../../conf/config.php" );

// Including mysql class
include ( "../../includes/$def_dbtype.php" );

// Connecting to the database
include ( "../../connect.php" );

// Including functions
include ( "../../includes/sqlfunctions.php" );
include ( "../../includes/functions.php" );

// Including language pack
include ( "../../lang/language.$def_language.php" );


                $id_firm=intval($_POST['id']);

                $casemail = mt_rand(10000,99999);

                $db->query("UPDATE $db_users SET tmail='$casemail' WHERE selector='$id_firm' LIMIT 1");

                $r_code = $db->query  ( "SELECT mail, firmname, manager FROM $db_users WHERE selector='$id_firm' LIMIT 1" );
		$f_code = $db->fetcharray  ( $r_code );

                $logo_img = glob('../../logo/'.$id_firm.'.*');
                if ($logo_img[0]!='') $logo_mail='<img src="'.$def_mainlocation.'/logo/'.basename($logo_img[0]).'" hspace="3" vspace="3" />'; else $logo_mail="";

              
                $template_mail_klient = file_get_contents ('../../template/' . $def_template . '/mail/case_mail.tpl');

                $template_mail_klient = str_replace("*logo*", $logo_mail, $template_mail_klient);

                $template_mail_klient = str_replace("*title*", $def_title, $template_mail_klient);
                $template_mail_klient = str_replace("*dir_to_main*", $def_mainlocation, $template_mail_klient);
                $template_mail_klient = str_replace("*firmname*", $f_code['firmname'], $template_mail_klient);

                if ($f_code['manager']!='') $template_mail_klient = str_replace("*manager*", $f_code['manager'], $template_mail_klient); else $template_mail_klient = str_replace("*manager*", $def_manager_firms, $template_mail_klient);

                $link_case_mail=$def_mainlocation.'/users/user.php?id='.$id_firm.'&code='.$rand = $casemail;

                $template_mail_klient = str_replace("*casemail*", $casemail, $template_mail_klient);
                $template_mail_klient = str_replace("*link_mail*", $link_case_mail, $template_mail_klient);
      
                mailHTML($f_code['mail'],$def_case_mail_subject,$template_mail_klient,$def_adminmail);

                echo '<br><div class="alert alert-success">На Ваш электронный ящик <b>'.$f_code['mail'].'</b> был отправлен код активации!</div>';

        exit;

?>      	

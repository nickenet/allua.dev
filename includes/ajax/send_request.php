<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Maid
=====================================================
 Файл: send_request.php
-----------------------------------------------------
 Назначение: Отправка заявки
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

if ($_POST['security'] != $_SESSION['random']) {

    echo '$("#send_req_info").html("<div class=\"error_captcha\">'.$error_captcha.'</div>");';
    
} else {

                unset($_SESSION['random']);
    
                $id_firm=intval($_POST['id']);
                $id_num=intval($_POST['id_num']);

                $r_mail = $db->query  ( "SELECT selector, mail, tmail, firmname, manager, tmail FROM $db_users WHERE selector='$id_firm' LIMIT 1" );
		$fmail = $db->fetcharray  ( $r_mail );
                
                $r_mail_offer = $db->query  ( "SELECT num, item FROM $db_offers WHERE num='$id_num' LIMIT 1" );
		$fz = $db->fetcharray  ( $r_mail_offer );

                $logo_img = glob('../../offer/'.$fz['num'].'-small.*');
                if ($logo_img[0]!='') $logo_mail='<img src="'.$def_mainlocation.'/offer/'.basename($logo_img[0]).'" hspace="3" vspace="3" />'; else $logo_mail="";

                    $date_request = date("d-m-Y");
                    $num_request = date("Hi").$fz['num'];
                
                    $to = $fmail['mail'];
                
                    $user=@iconv("UTF-8", "windows-1251", $_POST['name']);
                    $user=safeHTML($user);
                    
                    $phone= @iconv("UTF-8", "windows-1251", $_POST['tel']);
                    $phone=safeHTML($phone);
                    
                    $mail=safeHTML($_POST['mail']);
                    
                    $company = @iconv("UTF-8", "windows-1251", $_POST['firm']);
                    $company=safeHTML($company);
                    
                    $text = @iconv("UTF-8", "windows-1251", $_POST['message']);                  
                    $text=safeHTML(strip_tags($text));

                    $template_mail = file_get_contents ('../../template/' . $def_template . '/mail/offer.tpl');

                    $template_mail = str_replace("*title*", $def_title, $template_mail);
                    $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                    $template_mail = str_replace("*firmname*", $fmail['firmname'], $template_mail);
                    $template_mail = str_replace("*id_firm*", $fmail['selector'], $template_mail);
                    $template_mail = str_replace("*data*", $date_request, $template_mail);
                    $template_mail = str_replace("*number*", $num_request, $template_mail);                    
                    $template_mail = str_replace("*title_offer*", $fz['item'], $template_mail);
                    $template_mail = str_replace("*id_offer*", $fz['num'], $template_mail);
                    $template_mail = str_replace("*user*", $user, $template_mail);
                    $template_mail = str_replace("*phone*", $phone, $template_mail);
                    $template_mail = str_replace("*mail*", $mail, $template_mail);
                    $template_mail = str_replace("*company*", $company, $template_mail);
                    $template_mail = str_replace("*text*", $text, $template_mail);
                    $template_mail = str_replace("*offer*", $img_offers, $template_mail);
                    $template_mail = str_replace("*img*", $logo_mail, $template_mail);
                    if ($fmail['manager']!='') $template_mail = str_replace("*manager*", $fmail['manager'], $template_mail); else $template_mail = str_replace("*manager*", $def_manager_firms, $template_mail);

                    mailHTML($to,$def_introductory,$template_mail,$mail);

  echo '$("#send_req_info").html("<div class=\"ok_message\">';

    echo $def_request_ok1.' <b>'.$fmail['firmname'].'</b>';
    echo $def_request_ok2.' <b>'.$num_request.'</b>';
    echo $def_request_ok3.' <b>'.$date_request.'</b>';
    echo '<br><img src=\"'.$def_mainlocation.'/template/'.$def_template.'/images/print.gif\" alt=\"'.addslashes($def_request_ok4).'\" border=\"0\" valign=\"middle\"  /> <a target=\"_blank\" href=\"'.$def_mainlocation.'/alloffers.php?id='.$fmail['selector'].'&full='.$fz['num'].'&data='.$date_request.'&number='.$num_request.'&print=request\">'.addslashes($def_request_ok4).' <a>';

echo '</div>';

if ($fmail['tmail']!=1) echo addslashes($def_warning_mail);
echo '");';
           echo '$("#send_req").css("display","none");';     
}

        exit;

?>      	

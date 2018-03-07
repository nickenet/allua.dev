<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & Ilya.K
=====================================================
 Файл: catreview.php
-----------------------------------------------------
 Назначение: Вывод комментариев
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}


	for ($ir=0; $ir<$results_amount; $ir++ )

	{

		$f_rew = $db->fetcharray  ( $rz );

		
		if ($f_rew['mail'] != "") $user_review = '<a href="mailto:'.$f_rew[mail].'" target="_blank"><b>'.$f_rew[user].'</b></a>';
		else $user_review = '<b>'.$f_rew[user].'</b>';

		$date_add = undate($f_rew['date'], $def_datetype);
		$review=$f_rew['review'];
		$id_review=$f_rew['id'];

		if ($f_rew['www'] != "") $www_com = '<a href="'.$f_rew[www].'" target="_blank" rel="nofollow">'.$f_rew[www].'</a>';
		else $www_com = "";
 

		$avatar = '';
		if ($f_rew['avatar'] != '' && $f_rew['profil'] != '')
		{
			$avatar = '<a href="%s" target="_blank" rel="nofollow"><img src="%s" alt="" border="0"></a>';
			$avatar = sprintf($avatar, $f_rew['profil'], $f_rew['avatar']);
		}

		if ($avatar=='') $avatar = '<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/noavatar.gif" alt="" border="0">';

		if (($f_rew['rtype']==1) or empty($f_rew['rtype'])) { $template_sub_review = implode ('', file('./template/' . $def_template . '/review.tpl')); $rtype_com=$def_review_type_com; }
		if ($f_rew['rtype']==2) { $template_sub_review = implode ('', file('./template/' . $def_template . '/review_good.tpl')); $rtype_com=$def_review_type_good; }
		if ($f_rew['rtype']==3) { $template_sub_review = implode ('', file('./template/' . $def_template . '/review_bad.tpl')); $rtype_com=$def_review_type_bad; }
                
                $reply='';
                                if ($f_rew['otvet']==1) {
                                    $res_otvet = $db->query  ( "SELECT reply FROM $db_reply WHERE id_com='$id_review'");
                                    $fe_otvet = $db->fetcharray  ( $res_otvet );
                                    $reply = '<div class="rev_reply_company"><b>'.$def_reply_review_company;
                                    $reply .= '</b><div class="rev_reply">'.$fe_otvet['reply'].'</div></div>';

                                }

                $template = new Template;

                $template->load($template_sub_review);

		$template->replace("date", "$date_add");
		$template->replace("id", "$id_review");
                $template->replace("user", "$user_review");
                $template->replace("www", "$www_com");
		$template->replace("avatar", "$avatar");           
                $template->replace("review", "$review");
		$template->replace("type", "$rtype_com");
                $template->replace("reply", "$reply");
              
                $template->replace("rating", buildRate($f_rew['id'], $f_rew['rateVal']));
                
                $template->replace("color", "$color");

                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");
		
                $template->publish();

        }

?>

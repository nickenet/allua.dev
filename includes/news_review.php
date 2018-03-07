<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & Ilya.K
=====================================================
 Файл: news_review.php
-----------------------------------------------------
 Назначение: Вывод комментариев к новости
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

	for ($irn=0; $irn<$results_amount; $irn++ )

	{
		$f_rew = $db->fetcharray  ( $rz );

		if ($f_rew['mail'] != "") $user_review = '<a href="mailto:'.$f_rew[mail].'" target="_blank">'.$f_rew['user'].'</a>';
		else $user_review = $f_rew['user'];

		$date_add = undate($f_rew['date'], $def_datetype);
		$review=$f_rew['review'];
		$id_review=$f_rew['id'];

		$avatar = '';
		if ($f_rew['avatar'] != '' && $f_rew['profil'] != '')
		{
			$avatar = '<a href="%s" target="_blank" rel="nofollow"><img src="%s" alt="" border="0"></a>';
			$avatar = sprintf($avatar, $f_rew['profil'], $f_rew['avatar']);
		}

		if ($avatar=='') $avatar = '<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/noavatar.gif" alt="" border="0">';

		$template_sub_review = implode ('', file('./template/' . $def_template . '/news_review.tpl'));

                $template_rn = new Template;

                $template_rn->load($template_sub_review);

		$template_rn->replace("date", $date_add);
		$template_rn->replace("id", $id_review);
                $template_rn->replace("user", $user_review);
		$template_rn->replace("avatar", $avatar);
                $template_rn->replace("review", $review);
                
                $template_rn->replace("color", $color);

                $template_rn->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");
		
                $template_rn->publish();

        }

?>

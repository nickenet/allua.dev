<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & Ilya.K
=====================================================
 Файл: review.php
-----------------------------------------------------
 Назначение: Добавить комментарий для компании
=====================================================
*/


require './defaults.php';

session_start();

header('Cache-control: private');

$kPage = empty($_GET['page']) ? 0 : intval($_GET['page']);

if (!isset($_SESSION['random']))
{
	$_SESSION['random'] = mt_rand(1000000, 9999999);
}

$rand = mt_rand(1, 999);

require 'includes/loginza/init.php';

# Этот указатель будет позже использоваться!
$r = $db->query("SELECT * FROM $db_users WHERE selector = '$id' $hide_d");

$ra = $db->query("SELECT * FROM $db_users WHERE selector = '$id' $hide_d");
$fa = $db->fetcharray($ra);

if ($_POST['hiddenbut'] == 'go' and $_POST['security'] != $_SESSION['random'])
{
	unset($_SESSION['random']);
	$error .= 'Код безопасности не соответствует отображённому!<br>';
}
elseif ($_POST['hiddenbut'] == 'go' and $_POST['security'] == $_SESSION['random'])
{
	unset($_SESSION['random']);

                $texty = safeHTML(strip_tags($_POST['texty']));
                $texty = substr($texty, 0, $def_review_size);
                if (strlen($texty)<1) { $texty=""; $def_specifyyourmessage=str_replace("7","1",$def_min_msg_mail); }

	if ($_POST["user_name"] == "")
	{
		$error.= "$def_specify_your_name !<br>";
	}

	if ($texty == "")
	{
		$error.= "$def_specifyyourmessage!<br>";
	}

	if (!isset($error))
	{
		if ($def_onlypaid == "YES")
		{
			$hide_d = " AND flag <> 'D' ";
		}

		$date = date("Y-m-d");

		$userName = safehtml($_POST['user_name']);
		$email = safehtml($_POST['email']);

		if ($_POST["www"] <> "")
		{
			if (preg_match("#http://#", $_POST["www"]))
			{
				$www = $_POST['www'];
			}
			else
			{
				$www = 'http://' . $_POST['www'];
			}
		}

		$www = safeHTML($www);
		$rtype = (int)$_POST['rtype'];
		
		$avatar = '';
		$status = 'off';
		$profil = '';
		if (!empty($_SESSION['loginza']['is_auth']))
		{
			$status = 'on';
			$profil = $LoginzaProfile->genUserSite();
			if (!empty($_SESSION['loginza']['profile']->photo))
			{
				$avatar = $_SESSION['loginza']['profile']->photo;
			}
		}

		$db->query("INSERT INTO $db_reviews SET 
						company = '$id',
						date = '$date',
						user = '$userName',
						status = '$status',
						review = '$texty',
						mail = '$email',
						www = '$www',
						profil = '$profil',
						avatar = '$avatar',
						rtype = $rtype"
				) or die(mysql_error());

		$new_rev = $fa['new_rev'];
		$new_rev++;

		$new_rev_good = $fa['rev_good'];
		$new_rev_bad = $fa['rev_bad'];

		if (($_POST['rtype']==2) and ($status=='on')) $new_rev_good++;
		if (($_POST['rtype']==3) and ($status=='on')) $new_rev_bad++;

		$db->query("UPDATE $db_users SET new_rev='$new_rev', rev_good='$new_rev_good', rev_bad='$new_rev_bad' WHERE selector='$id'");

		if (($fa['on_newrev'] == '1') and ($fa['mail'] != ""))
		{

// Отправляем письмо контрагенту

$logo_img = glob('./logo/'.$id.'.*');
if ($logo_img[0]!='') $logo_mail='<img src="'.$def_mainlocation.'/logo/'.basename($logo_img[0]).'" hspace="3" vspace="3" />'; else $logo_mail="";

    $template_mail = file_get_contents ('template/' . $def_template . '/mail/review.tpl');

    $template_mail = str_replace("*title*", $def_title, $template_mail);
    $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
    $template_mail = str_replace("*firmname*", $fa['firmname'], $template_mail);
    $template_mail = str_replace("*text*", $texty, $template_mail);
    $template_mail = str_replace("*user*", $userName, $template_mail);
    $template_mail = str_replace("*logo*", $logo_mail, $template_mail);
    $template_mail = str_replace("*id_firm*", $fa['selector'], $template_mail);
    if ($fa['manager']!='') $template_mail = str_replace("*manager*", $fa['manager'], $template_mail); else $template_mail = str_replace("*manager*", $def_manager_firms, $template_mail);

    mailHTML($fa['mail'],$def_new_review,$template_mail,$def_from_email);

		}
			// Отправляем письмо администратору

			$text_rev = <<<MAIL
Здравствуйте.

Уведомляем вас о том, что на сайт  $def_mainlocation ($def_title) был добавлен комментарий 

------------------------------------------------
Текст комментария
------------------------------------------------

MAIL;

			$text_rev .= $texty;
			
			if ($status=='off') $text_comment_add='Комментарий отправлен на проверку'; else $text_comment_add='Комментарий занесен в базу данных';

			$text_rev .= <<<MAIL

К компании $def_mainlocation/view.php?id=$id

$text_comment_add

------------------------------------------------
Помните, что администрация сайта не несет ответственности за содержание данного письма

С уважением,

Администрация $def_mainlocation
MAIL;

			$to =  $def_adminmail;

			mail($to,
				'Новый комментарий в каталоге',
				stripcslashes($text_rev),
				"FROM: " . $def_adminmail . "\r\nContent-Type: text/plain; charset=windows-1251\r\n");


		$db->close();

		$listUrl = "reviews.php?id=$id&cat=$cat&subcat=$subcat&subsubcat=$subsubcat&review_status=$status";

                $substr_count = substr_count($def_mainlocation,"рф");
                if ($substr_count>0)                  
                echo '<div align="center" style="padding-top:30px;">Внимание! Домен не поддерживает автоматического перенаправления, для перехода на сайт нажмите на ссылку - <a href='.$def_mainlocation.'/'.$listUrl.'>'.$def_mainlocation.'/'.$listUrl.'</a></div>';

		header('Location: ' . $def_mainlocation . '/' . $listUrl);

		exit;
	}
}

$category = 0;
$maincategory = "";

$subcategory = 0;
$mainsubcategory = "";

$subsubcategory = 0;
$mainsubsubcategory = "";

$incomingline = "<a href=\"$def_mainlocation\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | ";

if ($cat != 0)
{
	$res = $db->query("SELECT * FROM $db_category WHERE selector = '$cat'");
	$fe = $db->fetcharray($res);
	$db->freeresult($res);
	$showmaincategory = $fe["category"];
	$category = $fe[selector];

	if ($def_rewrite == "YES")
	{
		$incomingline.= "<a href=\"$def_mainlocation/" . str_replace(' ', "_", rewrite($showmaincategory)) . "/$cat-$kPage.html\">";
	}
	else
	{
		$incomingline.= "<a href=\"index.php?category=$cat\">";
	}

	$incomingline.= "<font color=\"$def_status_font_color\"><u>$showmaincategory</u></font></a>";
}

if ($subcat != 0)
{
	$res = $db->query("SELECT * FROM $db_subcategory WHERE catsubsel = '$subcat'");
	$fe = $db->fetcharray($res);
	$db->freeresult($res);
	$showcategory = $fe['subcategory'];
	$subcategory = $fe['catsubsel'];

	if ($def_rewrite == "YES")
	{
		$incomingline	.= " | <a href=\"$def_mainlocation/"
						. str_replace(' ', "_", rewrite($showmaincategory)) . "/"
						. str_replace(' ', "_", rewrite($showcategory)) . "/$cat-$subcat-$kPage.html\">";
	}
	else
	{
		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;page=$kPage\">";
	}

	$incomingline.= " <font color=\"$def_status_font_color\"><u>$showcategory</u></font></a>";
}

if ($subsubcat != 0)
{
	$res = $db->query("SELECT * FROM $db_subsubcategory WHERE catsel = '$cat' and catsubsel = '$subcat' and catsubsubsel = '$subsubcat'");
	$fe = $db->fetcharray($res);
	$db->freeresult($res);
	$showsubcategory = $fe["subsubcategory"];
	$subsubcategory = $fe['catsubsubsel'];

	if ($def_rewrite == "YES")
	{
		$incomingline	.= " | <a href=\"$def_mainlocation/"
						. str_replace(' ', "_", rewrite($showmaincategory)) . "/"
						. str_replace(' ', "_", rewrite($showcategory)) . "/"
						. str_replace(' ', "_", rewrite($showsubcategory))
						. "/$cat-$subcat-$subsubcat-$kPage.html\">";
	}
	else
	{
		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;page=$kPage\">";
	}

	$incomingline.= "  <font color=\"$def_status_font_color\"><u>$showsubcategory</u></font></a>";
}

// Формируем ЧПУ для компании
if ($def_rewrite == "YES")
{
	if (($category == "") and ($subcategory == "") and ($subsubcategory == ""))
	{
		$links_view = "$def_mainlocation/EmptyCategory/0-0-0-$id-$kPage-0.html";
	}
	if (($category != 0) and ($subcategory == 0) and ($subsubcategory == 0))
	{
		$links_view = "$def_mainlocation/" . rewrite($showmaincategory) . "/$category-0-0-$id-$kPage-0.html";
	}
	if (($subcategory != 0) and ($subsubcategory == 0))
	{
		$links_view = "$def_mainlocation/" . rewrite($showmaincategory) . "/" . rewrite($showcategory)
					. "/$category-$subcategory-0-$id-$kPage-0.html";
	}
	if ($subsubcategory != 0)
	{
		$links_view = "$def_mainlocation/" . rewrite($showmaincategory) . "/" . rewrite($showcategory)
					. "/" . rewrite($showsubcategory) . "/$category-$subcategory-$subsubcategory-$id-$kPage-0.html";
	}
}
else
{
	$links_view = "view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat";
}



$incomingline.= " | <a href=\"$links_view\"><font color=\"$def_status_font_color\"><u>$fa[firmname]</u></font></a> | $def_add_a_review";

$help_section = $review_help;

$incomingline_firm = "$def_add_a_review &raquo; $fa[firmname]";

include ( "./template/$def_template/header.php" );

if ($db->numrows($ra) == 0)
{
	$error = $def_mailid_error;
}

if (isset($error))
{
	echo "<br><font color=\"red\">$error</font>";
	echo "<br><br><a href=\"javascript:history.go(-1)\">$def_to_back</a><br><br>";
}
else
{
	main_table_top($def_add_a_review);

	include ("./includes/sub.php");

	if ($fa['off_rev'] == "1")
	{
		echo '<center>'.$def_review_nocomment.'</center>';
	}
	else
	{
		$curUrl = "review.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat";
                
		require './includes/review_form.php'; 
	}

	main_table_bottom();
}

include ( "./template/$def_template/footer.php" );
?>
<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.MAdi
=====================================================
 Файл: mail2.php
-----------------------------------------------------
 Назначение: Отправка сообщений другу
=====================================================
*/


include( "./defaults.php" );

$kPage = intval($_GET['page']);

session_start();

	header("Cache-control: private");

	if (!isset($_SESSION['random']))
	{
		$_SESSION['random'] = mt_rand(1000000,9999999);
	}

	$rand = mt_rand(1, 999);

if (($_POST["hiddenbut"] == "go") and ($_POST[security] != "$_SESSION[random]")) {

$error.= $error_captcha;
unset($_SESSION['random']);
}

else

{

if ( ($_POST["hiddenbut"] == "go") and ($_POST[security] == "$_SESSION[random]") )

{
	unset($_SESSION['random']);

	$texty = htmlspecialchars(strip_tags($_POST['texty']),ENT_QUOTES,$def_charset);
	$texty = substr($texty, 0, $def_message_size);

	if ( $_POST["email"] == "" )

	{

		$error.= "$def_specifyyouremail !<br>";

	}

	if ( $_POST["email2"] == "" )

	{

		$error.= "$def_specifyyouremail2 !<br>";

	}

	if ( $texty == "" )

	{

		$error.= "$def_specifyyourmessage!<br>";

	}

	if ( !isset ( $error ) )

	{
		if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

		$r = $db->query  ( "SELECT * FROM $db_users WHERE selector='$id' $hide_d" );
		$f = $db->fetcharray  ( $r );

		$to = htmlspecialchars($_POST['email2'],ENT_QUOTES,$def_charset);

		$from = htmlspecialchars($_POST['email'],ENT_QUOTES,$def_charset);

                $template_mail = file_get_contents ('template/' . $def_template . '/mail/mail_friend.tpl');

                $template_mail = str_replace("*title*", $def_title, $template_mail);
                $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                $template_mail = str_replace("*firmname*", $f['firmname'], $template_mail);
                $template_mail = str_replace("*text*", $texty, $template_mail);
                $template_mail = str_replace("*mail*", $from, $template_mail);
                $template_mail = str_replace("*id_firm*", $f['selector'], $template_mail);

		mailHTML($to,$def_messagefromavisitor2,$template_mail,$from);

		$db->close();

		header ( "Location:$def_mainlocation/view.php?id=$id&cat=$cat&subcat=$subcat&subsubcat=$subsubcat&page=$kPage&type=mail2" );

		exit();
	}
}
}

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id' $hide_d" );

	$category = 0;
	$maincategory = "";

	$subcategory = 0;
	$mainsubcategory = "";

	$subsubcategory = 0;
	$mainsubsubcategory = "";

$incomingline = "<a href=\"$def_mainlocation\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | ";


if ($cat != 0)

	{
		$res = $db->query  ( "SELECT * FROM $db_category WHERE selector = '$cat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showmaincategory = $fe["category"];
		$category = $fe[selector];

		if ($def_rewrite == "YES")
		$incomingline.= "<a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/$cat-$kPage.html\">";
		else
		$incomingline.= "<a href=\"index.php?category=$cat\">";

		$incomingline.= "<font color=\"$def_status_font_color\"><u>$showmaincategory</u></font></a>";
	}

if ($subcat != 0)

	{
		$res = $db->query  ( "SELECT * FROM $db_subcategory WHERE catsubsel = '$subcat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showcategory = $fe["subcategory"];
		$subcategory = $fe[catsubsel];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/$cat-$subcat-$kPage.html\">";
		else

		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;page=$kPage\">";

		$incomingline.= " <font color=\"$def_status_font_color\"><u>$showcategory</u></font></a>";
	}

if ($subsubcat != 0)

	{
		$res = $db->query  ( "SELECT * FROM $db_subsubcategory WHERE catsel = '$cat' and catsubsel = '$subcat' and catsubsubsel = '$subsubcat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showsubcategory = $fe["subsubcategory"];
		$subsubcategory = $fe[catsubsubsel];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/". str_replace(' ', "_", rewrite($showsubcategory)) ."/$cat-$subcat-$subsubcat-$kPage.html\">";
		else

		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;page=$kPage\">";

		$incomingline.= "  <font color=\"$def_status_font_color\"><u>$showsubcategory</u></font></a>";
	}

// Формируем ЧПУ для компании

if (($category == "") and ($subcategory == "") and ($subsubcategory == "")) $links_view="$def_mainlocation/EmptyCategory/0-0-0-$id-$kPage-0.html";
if (($category != 0) and ($subcategory == 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/" . rewrite($showmaincategory) . "/$category-0-0-$id-$kPage-0.html";
if (($subcategory != 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/$category-$subcategory-0-$id-$kPage-0.html";
if ($subsubcategory != 0) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/".rewrite($showsubcategory)."/$category-$subcategory-$subsubcategory-$id-$kPage-0.html";

$ra = $db->query  ( "SELECT firmname, category FROM $db_users WHERE selector = '$id' $hide_d" );
$fa = $db->fetcharray($ra);

if ($def_rewrite == "YES")
$incomingline.= " | <a href=$links_view><font color=\"$def_status_font_color\"><u>$fa[firmname]</u></font></a> | $def_friend";
else
$incomingline.= " | <a href=\"view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\"><font color=\"$def_status_font_color\"><u>$fa[firmname]</u></font></a> | $def_friend";

$help_section = $mail2_help;

$incomingline_firm = "$def_friend &raquo; $fa[firmname]";

correct_url($fa['category'],'mail2',$id);
$to_canonical=to_canonical($fa['category'],$cat,$subcat,$subsubcat);

include ( "./template/$def_template/header.php" );

?>

<script type="text/javascript" src="includes/jquery.validate.min.js"></script>
<script type="text/javascript" src="includes/messages_ru.js"></script>

<?

if ( $db->numrows  ( $ra ) == 0 ) $error=$def_mailid_error;


if ( isset ( $error ) )

{
	$def_message_error = $error;
        include ( "./includes/error_page.php" );
}

else

{

main_table_top($def_friend);

include ("./includes/sub.php");

if ($fa[off_friends]=="1") {

    $def_title_error=$def_warning_msg;
    $def_message_error=$def_nsg_closed_firm;

    include ( "./includes/error_page.php" );

} else

{


if ($def_rewrite == "YES")
$action_form = "$def_mainlocation/mail2-$id-$cat-$subcat-$subsubcat-$kPage.html";
else
$action_form = "$def_mainlocation/mail2.php?id=$id&cat=$cat&subcat=$subcat&subsubcat=$subsubcat";

$template = new Template;

$template->set_file('mail2.tpl');

$template->replace("bgcolor", $def_form_back_color);
$template->replace("action", $action_form);

$template->replace("yourmail", $def_yourmail);
$template->replace("friendmail", $def_friendmail);
$template->replace("message_to_friend", $def_message_to_friend);
$template->replace("yourmessage", $def_yourmessage2);
$template->replace("message_size", $def_message_size);
$template->replace("characters_left", $def_characters_left);

$template->replace("captcha", $def_captcha);
$template->replace("sendmessage_button", $def_sendmessage_button);

if($f['tmail']!=1) $template->replace("warning_mail", $def_warning_mail); else $template->replace("warning_mail", "");

$template->replace("security", "<img src=\"security.php?$rand\" />");


$template->replace("dir_to_main", $def_mainlocation);
$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

$template->publish();


}

main_table_bottom ();

}

include ( "./template/$def_template/footer.php" ); ?>
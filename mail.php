<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.MAdi
=====================================================
 Файл: mail.php
-----------------------------------------------------
 Назначение: Отправка сообщения контрагенту
=====================================================
*/

include( "./defaults.php" );

$kPage = intval($_GET[page]);

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
                if (strlen($texty)<7) { $texty=""; $def_specifyyourmessage=$def_min_msg_mail; }

	if ( $_POST["email"] == "" )

	{

		$error.= "$def_specifyyouremail !<br>";

	}

	if (($def_attach_file == "YES") and ($_FILES['file']['tmp_name'] != "")) {

		$filesize = filesize ( $_FILES['file']['tmp_name'] );

		if ($filesize > $def_max_attach)

		{

			$error.= "$def_max_attach_exceeded $def_max_attach.<br>";

		}
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

		$to = $f['mail'];
		$from = htmlspecialchars($_POST['email']);
		$subject = "$def_messagefromavisitor ($from)$def_review_for $f[firmname] (id $f[selector], $f[mail])";

                $logo_img = glob('./logo/'.$id.'.*');
                if ($logo_img[0]!='') $logo_mail='<img src="'.$def_mainlocation.'/logo/'.basename($logo_img[0]).'" hspace="3" vspace="3" />'; else $logo_mail="";

                $template_mail = file_get_contents ('template/' . $def_template . '/mail/mail.tpl');

                $template_mail = str_replace("*title*", $def_title, $template_mail);
                $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                $template_mail = str_replace("*firmname*", $f['firmname'], $template_mail);
                $template_mail = str_replace("*text*", $texty, $template_mail);
                $template_mail = str_replace("*mail*", $from, $template_mail);
                $template_mail = str_replace("*logo*", $logo_mail, $template_mail);
                if ($f['manager']!='') $template_mail = str_replace("*manager*", $f['manager'], $template_mail); else $template_mail = str_replace("*manager*", $def_manager_firms, $template_mail);

                if (($def_attach_file == "YES") and ($_FILES['file']['tmp_name'] != ""))
		{
			chmod ( $_FILES['file']['tmp_name'], 0777 );
			$filesize = filesize ( $_FILES['file']['tmp_name'] );

			copy ( $_FILES['file']['tmp_name'], "./upload/".$_FILES['file']['name']);

			chmod ( "./upload/".$_FILES['file']['name'], 0777 );

			$FileName="./upload/".$_FILES['file']['name'];

			$FilePointer=fopen($FileName, "r");

			$File=fread($FilePointer, filesize ($FileName));

			fclose($FilePointer);

			$File=chunk_split(base64_encode($File));

			$Content="--MIME_BOUNDRY\n";
			$Content.="Content-Type: text/html; charset=\"windows-1251\"\n";
			// $Content.="Content-Transfer-Encoding: quoted-printable\n";
			$Content.="\n$template_mail\n\n";
			$Content.="--MIME_BOUNDRY\n";
			$Content.="Content-Type: ".$_FILES['file']['type']."; name=\"".$_FILES['file']['name']."\"\n";
			$Content.="Content-disposition: attachment\n";
			$Content.="Content-Transfer-Encoding: base64\n";
			$Content.="\n";
			$Content.="$File\n";
			$Content.="\n";
			$Content.="--MIME_BOUNDRY--\n";

			mail($to,stripcslashes($subject),stripcslashes($Content),"From: $from\r\nContent-Type: text/plain; charset=windows-1251\r\n"."Reply-To: $from\r\n"."MIME-Version: 1.0\n"."Content-Type: multipart/mixed; boundary=\"MIME_BOUNDRY\"\n"."X-Sender: $from\n"."X-Mailer: I-Soft Biznes\n"."X-Priority: 3 (Normal)\n"."This is a multi-part message in MIME format.\n");

			unlink($FileName);

		}

		else

		{
			mail($to,stripcslashes($subject),stripcslashes($template_mail),"From: $from\r\nContent-Type: text/html; charset=windows-1251\r\n"."Reply-To: $from\r\n"."MIME-Version: 1.0\n"."X-Sender: $from\n"."X-Mailer: I-Soft Bizness\n"."X-Priority: 3 (Normal)\n");
		}

		$mail_count=$f[mailcounter];
		$mail_count++;

		$db->query  ( "UPDATE $db_users SET mailcounter = $mail_count WHERE selector='$f[selector]'" );

		$db->close();

		header ( "Location:$def_mainlocation/view.php?id=$id&cat=$cat&subcat=$subcat&subsubcat=$subsubcat&type=mail" );

		exit;

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

$ra = $db->query  ( "SELECT firmname, category, off_mail, tmail FROM $db_users WHERE selector = '$id' $hide_d" );
$fa = $db->fetcharray($ra);

correct_url($fa['category'],'mail',$id);
$to_canonical=to_canonical($fa['category'],$cat,$subcat,$subsubcat);

if ($def_rewrite == "YES")
$incomingline.= " | <a href=$links_view><font color=\"$def_status_font_color\"><u>$fa[firmname]</u></font></a> | $def_sendmessage";
else
$incomingline.= " | <a href=\"view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\"><font color=\"$def_status_font_color\"><u>$fa[firmname]</u></font></a> | $def_sendmessage";

$help_section = $mail_help;

$incomingline_firm = "$def_sendmessage &raquo; $fa[firmname]";

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

main_table_top ($def_sendmessage);

include ("./includes/sub.php");

if ($fa[off_mail]=="1") {

    $def_title_error=$def_warning_msg;
    $def_message_error=$def_nsg_closed_firm;

    include ( "./includes/error_page.php" );

} else

{

if ($def_rewrite == "YES")
$action_form = "$def_mainlocation/mail-$id-$cat-$subcat-$subsubcat-$kPage.html";
else
$action_form = "$def_mainlocation/mail.php?id=$id&cat=$cat&subcat=$subcat&subsubcat=$subsubcat";

$template = new Template;

$template->set_file('mail.tpl');

$template->replace("bgcolor", $def_form_back_color);
$template->replace("action", $action_form);

$template->replace("yourmail", $def_yourmail);
$template->replace("yourmessage", $def_yourmessage);
$template->replace("message_size", $def_message_size);
$template->replace("characters_left", $def_characters_left);
$template->replace("attach", $def_attach);
$def_max_attach=intval($def_max_attach/1000);
$template->replace("max_attach", $def_max_attach/1000);
$template->replace("captcha", $def_captcha);
$template->replace("sendmessage_button", $def_sendmessage_button);

if($f['tmail']!=1) $template->replace("warning_mail", $def_warning_mail); else $template->replace("warning_mail", "");

$template->replace("security", "<img src=\"security.php?$rand\" />");


$template->replace("dir_to_main", $def_mainlocation);
$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

$template->publish();

}

main_table_bottom();

}

include ( "./template/$def_template/footer.php" );

?>

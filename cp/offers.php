<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: offers.php
-----------------------------------------------------
 Назначение: Редактирование компании
=====================================================
*/

@ $randomized = rand ( 0, 9999 );

session_start();

require_once './defaults.php';

$idident=intval($_REQUEST['id']);
if (isset($_POST['idident'])) $idident=intval($_REQUEST['idident']);

$help_section = (string)$offers_help;

$title_cp = $def_admin_offers_k.' - ';
$speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a>';

check_login_cp('1_0','offers.php?REQ=auth&id='.$idident);

require_once 'template/header.php';

$can="";

if (($_GET["REQ"] == "complete") and ($_POST["inbut"]== "$def_admin_save")){

		$firmname = safeHTML($_POST["firmname"]);
                $business = post_to_shortfull ( $_POST['business'] );

                $keywords = safeHTML ( strip_tags($_POST['keywords']) );
                $keywords = str_replace("  ", " ", $keywords);
                $twitter = safeHTML($_POST['twitter']);
                $facebook = safeHTML($_POST['facebook']);
                $vk = safeHTML($_POST['vk']);
                $odnoklassniki = safeHTML($_POST['odnoklassniki']);
                $social=$twitter.':'.$facebook.':'.$vk.':'.$odnoklassniki;

		$address = safeHTML($_POST["address"]);
		if ($def_country_allow == "YES") $city = safeHTML($_POST["city"]);
		$zip = safeHTML($_POST["zip"]);
		$phone = safeHTML($_POST["phone"]);
		$fax = safeHTML($_POST["fax"]);
		$mobile = safeHTML($_POST["mobile"]);
		$icq = safeHTML($_POST["icq"]);
		$manager = safeHTML($_POST["manager"]);
		$mail = safeHTML($_POST["mail"]);

		if ( $_POST["www"] <> "" )

		{
			if ( preg_match("#http://#", $_POST["www"]) ) { $www = $_POST[www]; }
			elseif ( preg_match("#https://#", $_POST["www"]) ) { $www = $_POST[www]; }
			else { $www = "http://$_POST[www]"; }
		}

		$www = safeHTML ( $www );

		$reserved_1 = safeHTML($_POST["reserved_1"]);
		$reserved_2 = safeHTML($_POST["reserved_2"]);
		$reserved_3 = safeHTML($_POST["reserved_3"]);
		$comment = safeHTML($_POST["comment"]);

		$_POST[idname] = safeHTML($_POST["idname"]);
		$_POST[idcomment] = safeHTML($_POST["idcomment"]);

		if ( $firmname == "" ) { $offers_mess = 1; }

		$raq=$db->query ("SELECT * from $db_users where selector='$_POST[idin]'") or die (mysql_error());
		$f=$db->fetcharray ($raq);

		if ($_POST[off_memberships]!=1) {

                $_SESSION['warning_pay']='NO';
                $_SESSION['end_pay_tariff']='';
                $_SESSION['counter']='NO';
                switchmemberships($_POST[idin], $_POST[listing], "admin", "script");
                
                }

		$category = update_categories($f[flag], $_POST[listing], $f[category], $_POST[category], "admin");

		if ($def_country_allow == "YES") {$location=$_POST["location"]; $postedcity=$city;} else {$location=$_POST["location"]; $postedcity="Город не указан";}
		if ($def_states_allow == "YES") {$state=$_POST["state"];}

		if ($_POST[listing]!=D) $on_locked_m=(int)$_POST[on_memberships]; else $on_locked_m=0;

                $status_case=intval($_POST['on_status']);

		if ($offers_mess!=1 ) {

                    $db->query ("UPDATE $db_users SET category='$category', firmname='$firmname', keywords='$keywords', business='$business', location='$location', state='$state', city='$postedcity', address='$address', zip='$zip', phone='$phone', fax='$fax', mobile='$mobile', icq='$icq', manager='$manager', mail='$mail', tcase='$status_case', www='$www', social='$social', comment='$comment', loch_m='$on_locked_m', reserved_1='$reserved_1', reserved_2='$reserved_2', reserved_3='$reserved_3' where selector='$_POST[idin]'") or die (mysql_error());

                    $re=$db->query ("select * from $db_users where selector='$_POST[idin]'") or die (mysql_error());

                    $fa=$db->fetcharray ($re);

                    logsto("<b>$fa[firmname]</b> - $def_offers_changed (id: $_POST[idin])");

                    $def_admin_refreshed="$fa[firmname] ($_POST[idin]) $def_admin_refreshed!";

                    $offers_mess=2;
                }

		$can="yes";
}

if (($_GET["REQ"] == "complete") and ($_POST["inbut"] == "$def_admin_compremove")){

		$ra=$db->query ("select * from $db_users where selector='$_POST[idin]'") or die (mysql_error());
		$fa=$db->fetcharray ($ra);

		$exist=mysql_num_rows($ra);

		if (( ($exist > 0) and ( $def_onlypaid == "YES" ) and ($fa[flag] != "D")) or ($def_onlypaid != "YES"))
		{
			$category = explode (":", $fa[category]);

			for ($index1 = 0; $index1 < count ( $category ); $index1++)

			{
				$new_cat1 = explode ("#", $category[$index1]);

				if ($new_cat1[0] != $prev_cat1)

				$db->query ("UPDATE $db_category SET fcounter = fcounter-1 where selector=$new_cat1[0]") or die (mysql_error());

				if (($new_cat1[1] != "") and ($new_cat1[1] != "0") and ($new_cat1[1] != $prev_subcat1))

				$db->query ("UPDATE $db_subcategory SET fcounter = fcounter-1 where catsel=$new_cat1[0] and catsubsel=$new_cat1[1]") or die (mysql_error());

				if (($new_cat1[1] != "") and ($new_cat1[1] != "0") and ($new_cat1[2] != "") and ($new_cat1[2] != "0"))

				$db->query ("UPDATE $db_subsubcategory SET fcounter = fcounter-1 where catsel=$new_cat1[0] and catsubsel=$new_cat1[1] and catsubsubsel=$new_cat1[2]") or die ("mySQL error!");

				$prev_cat1=$new_cat1[0];
				$prev_subcat1=$new_cat1[1];
			}
		}

		if ($exist > 0)

		$r=$db->query ("DELETE FROM $db_users where selector='$_POST[idin]'") or die ("mySQL error!");

		else

		echo "This listing is no longer exists<br />";

		$r=$db->query ("SELECT * from $db_offers where firmselector='$_POST[idin]'") or die ("mySQL error!");

		$countbanners=mysql_num_rows($r);

		for ($aaa=0;$aaa<$countbanners;$aaa++)

		{
			$f=$db->fetcharray ($r);

			@unlink(".././offer/$f[num].gif");
			@unlink(".././offer/$f[num].bmp");
			@unlink(".././offer/$f[num].jpg");
			@unlink(".././offer/$f[num].png");

			@unlink(".././offer/$f[num]-small.gif");
			@unlink(".././offer/$f[num]-small.bmp");
			@unlink(".././offer/$f[num]-small.jpg");
			@unlink(".././offer/$f[num]-small.png");
		}

		$r=$db->query ("DELETE FROM $db_offers where firmselector='$_POST[idin]'") or die ("mySQL error!");

		if ($def_allow_video == "YES") $r=$db->query ("DELETE FROM $db_video where firmselector='$_POST[idin]'") or die ("mySQL error!");

		$r_images=$db->query ("SELECT * from $db_images where firmselector='$_POST[idin]'") or die ("mySQL error!");

		$countbanners=mysql_num_rows($r_images);

		for ($aaa=0;$aaa<$countbanners;$aaa++)

		{
			$f_images=$db->fetcharray ($r_images);

			@unlink(".././gallery/$f_images[num].gif");
			@unlink(".././gallery/$f_images[num].bmp");
			@unlink(".././gallery/$f_images[num].jpg");
			@unlink(".././gallery/$f_images[num].png");

			@unlink(".././gallery/$f_images[num]-small.gif");
			@unlink(".././gallery/$f_images[num]-small.bmp");
			@unlink(".././gallery/$f_images[num]-small.jpg");
			@unlink(".././gallery/$f_images[num]-small.png");
		}

		$r_images=$db->query ("DELETE FROM $db_images where firmselector='$_POST[idin]'") or die ("mySQL error!");

		if ($def_allow_info=="YES") { $r_info=$db->query ("SELECT * from $db_info where firmselector='$_POST[idin]'") or die ("mySQL error!");

		$countbanners=mysql_num_rows($r_info);

		for ($aaa=0;$aaa<$countbanners;$aaa++)

		{
			$f_info=$db->fetcharray ($r_info);

			@unlink(".././info/$f_info[num].gif");
			@unlink(".././info/$f_info[num].bmp");
			@unlink(".././info/$f_info[num].jpg");
			@unlink(".././info/$f_info[num].png");

			@unlink(".././info/$f_info[num]-small.gif");
			@unlink(".././info/$f_info[num]-small.bmp");
			@unlink(".././info/$f_info[num]-small.jpg");
			@unlink(".././info/$f_info[num]-small.png");
		}

		$r_info=$db->query ("DELETE FROM $db_info where firmselector='$_POST[idin]'") or die ("mySQL error!");

                }

		$r_exel=$db->query ("SELECT * from $db_exelp where firmselector='$_POST[idin]'") or die ("mySQL error!");

		$countbanners=mysql_num_rows($r_exel);

		for ($aaa=0;$aaa<$countbanners;$aaa++)

		{
			$f_exel=$db->fetcharray ($r_exel);

			@unlink(".././exel/$f_exel[num].xls");
		}

		$r_exel=$db->query ("DELETE FROM $db_exelp where firmselector='$_POST[idin]'") or die ("mySQL error!");

		$r_filial=$db->query ("SELECT * from $db_filial where firmselector='$_POST[idin]'") or die ("mySQL error!");

		$countfilial=mysql_num_rows($r_filial);

		for ($aaa=0;$aaa<$countfilial;$aaa++)

		{
			$f_filial=$db->fetcharray ($r_filial);

			@unlink(".././filial/$f_filial[num].gif");
			@unlink(".././filial/$f_filial[num].bmp");
			@unlink(".././filial/$f_filial[num].jpg");
			@unlink(".././filial/$f_filial[num].png");

			@unlink(".././filial/$f_filial[num]-small.gif");
			@unlink(".././filial/$f_filial[num]-small.bmp");
			@unlink(".././filial/$f_filial[num]-small.jpg");
			@unlink(".././filial/$f_filial[num]-small.png");
		}

		$r_filial=$db->query ("DELETE FROM $db_filial where firmselector='$_POST[idin]'") or die ("mySQL error!");

		@unlink(".././banner/$_POST[idin].gif");
		@unlink(".././banner/$_POST[idin].bmp");
		@unlink(".././banner/$_POST[idin].jpg");
		@unlink(".././banner/$_POST[idin].png");

		@unlink(".././banner2/$_POST[idin].gif");
		@unlink(".././banner2/$_POST[idin].bmp");
		@unlink(".././banner2/$_POST[idin].jpg");
		@unlink(".././banner2/$_POST[idin].png");

		@unlink(".././logo/$_POST[idin].gif");
		@unlink(".././logo/$_POST[idin].bmp");
		@unlink(".././logo/$_POST[idin].jpg");
		@unlink(".././logo/$_POST[idin].png");

		@unlink(".././sxema/$_POST[idin].gif");
		@unlink(".././sxema/$_POST[idin].bmp");
		@unlink(".././sxema/$_POST[idin].jpg");
		@unlink(".././sxema/$_POST[idin].png");

                $r_raiting=$db->query ("DELETE FROM $db_rating where id='$_POST[idin]'");
                $r_engines=$db->query ("DELETE FROM $db_engines where firmselector='$_POST[idin]'");
                $r_stat=$db->query ("DELETE FROM $db_stat where firmselector='$_POST[idin]'");

		if ($exist > 0)

		$def_admin_companydelete="$def_admin_companydelete - Компания: $fa[firmname]";

		msg_text("80%",$def_admin_message_ok,$def_admin_companydelete);

                $_SESSION['warning_pay']='NO';
                $_SESSION['end_pay_tariff']='';
                $_SESSION['counter']='NO';

                logsto("$def_admin_companydelete <b>$fa[firmname]</b> (id: $fa[selector])");

                $can="yes";
}

if (($_GET["REQ"] == "auth") or ($can=="yes"))
    
{
		if ( $_POST["do"] == "uploaded" )
		{
			if ( $_POST["mode"] == "logo" )
			{
				$picdir = "logo";
			}
			if ( $_POST["mode"] == "sxema" )
			{
				$picdir = "sxema";
			}
			if ( $_POST["mode"] == "banner" )
			{
				$picdir = "banner";
			}
			if ( $_POST["mode"] == "banner2" )
			{
				$picdir = "banner2";
			}
				if ( $_POST[Submit] == "$def_upload")
				{
					if ( $_FILES['img1']['tmp_name'] )
					{
						chmod ( $_FILES['img1']['tmp_name'], 0755 ) or $uploaded = "<br /><span style=\"color:#FF0000;\">$def_admin_error_file</span><br /><br />";
						$size = Getimagesize ( $_FILES['img1']['tmp_name'] );
						$filesize = filesize ( $_FILES['img1']['tmp_name'] );
						if ( $_POST["mode"] == "logo" )
						{
							$max_width_ls = $def_logo_width;

							$max_width = 10000;
							$max_height = 10000;
							$max_size = $def_logo_size;
						}

						if ( $_POST["mode"] == "sxema" )
						{
							$max_width_ls = $def_sxema_width;

							$max_width = 10000;
							$max_height = 10000;
							$max_size = $def_sxema_size;
						}

						if ( $_POST["mode"] == "banner" )

						{
							$max_width = $def_banner_width;
							$max_height = $def_banner_height;
							$max_size = $def_banner_size;
						}

						if ( $_POST["mode"] == "banner2" )

						{
							$max_width = $def_banner2_width;
							$max_height = $def_banner2_height;
							$max_size = $def_banner2_size;
						}

						if ( ( ( $size[0] <= $max_width ) and ( $size[1] <= $max_height ) and ( $filesize < $max_size ) and ( $size[2] <> 4 ) ) and ( ( $size[2] == 1 ) or ( $size[2] == 2 ) or ( $size[2] == 3 ) or ( $size[2] == 6 ) ) )

						{
							if ( $size[2]==1 ) $type = "gif";
							if ( $size[2]==2 ) $type = "jpg";
							if ( $size[2]==3 ) $type = "png";
							if ( $size[2]==6 ) $type = "bmp";

							@unlink ( "../$picdir/$_POST[idident].gif" );
							@unlink ( "../$picdir/$_POST[idident].bmp" );
							@unlink ( "../$picdir/$_POST[idident].jpg" );
							@unlink ( "../$picdir/$_POST[idident].png" );

							copy ( $_FILES['img1']['tmp_name'], "../$picdir/$_POST[idident].$type" ) or $uploaded = "<br /><span style=\"color:#FF0000;\">Файл нельзя загрузить на сервер!<br /> Он превышает лимит по размеру файла принимаемым нашим сервером!<br /> Оптимизируйте его.</span><br /><br />";

							chmod ( "../$picdir/$_POST[idident].$type", 0755 ) or $uploaded = "<br /><span style=\"color:#FF0000;\">Файл нельзя загрузить на сервер!<br /> Он превышает лимит по размеру файла принимаемым нашим сервером!<br /> Оптимизируйте его.</span><br /><br />";

							if ((( $_POST["mode"] == "logo" ) or ( $_POST["mode"] == "sxema" )) and ($size[0] > $max_width_ls))

							{			
								switch ($type) 
								{
									case 'jpg':
									$out = 'imagejpeg';
									$q = 100;
									break;
					
									case 'png':
									$out = 'imagepng';
									$q = 0;
									break;
					
									case 'gif':
									$out = 'imagegif';
									break;

									case 'bmp':
									$out = 'imagebmp';
									break;
								}
											
								$img = imagecreatefromstring( file_get_contents('../'.$picdir.'/'.$_POST[idident].'.'.$type) );
								$w = imagesx($img);
								$h = imagesy($img);
								$k = $max_width_ls / $w;
								$img2 = imagecreatetruecolor($w * $k, $h * $k);
								imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
								$out($img2, '../'.$picdir.'/'.$_POST[idident].'.'.$type, $q);					
							}

							$uploaded = "<br /><span style=\"color:#FF0000;\">$def_banner_ok</span><br /> (Размер: $size[0]x$size[1] пикселей, Тип: $type)<br /><br />";
                                                        logsto("Обновлен графический элемент (баннеры, логотип, схема проезда (id: $_POST[idident])");

						}

						else

						{
							if ( $_POST["mode"] == "logo" ) $uploaded = "<br /><span style=\"color:#FF0000;\">$def_banner_error $def_logo_size байт</span><br /><br />";
							if ( $_POST["mode"] == "sxema" ) $uploaded = "<br /><span style=\"color:#FF0000;\">$def_banner_error $def_sxema_size байт</span><br /><br />";
							if ( $_POST["mode"] == "banner" ) $uploaded = "<br /><span style=\"color:#FF0000;\">$def_banner_error ($def_banner_width x $def_banner_height) @ $def_banner_size байт</span><br /><br />";
							if ( $_POST["mode"] == "banner2" ) $uploaded = "<br /><span style=\"color:#FF0000;\">$def_banner_error ($def_banner2_width x $def_banner2_height) @ $def_banner2_size байт</span><br /><br />";
						}
					}
					else
					{
						$uploaded = '<br /><span style="color:#FF0000;">'.$def_admin_error_file.'</span><br /><br />';
					}
				}

			if ($_POST[Submit] == "$def_remove")

			{

				$r=$db->query ("SELECT firmname, selector, mail FROM $db_users where selector='$_POST[idident]'") or die ("mySQL error!");
				$f=$db->fetcharray ($r);

				@unlink ( ".././$picdir/$f[selector].gif" );
				@unlink ( ".././$picdir/$f[selector].bmp" );
				@unlink ( ".././$picdir/$f[selector].jpg" );
				@unlink ( ".././$picdir/$f[selector].png" );

				$to = $f["mail"];

				$banner_message = file_get_contents ('../template/' . $def_template . '/mail/remove.tpl');

                                $banner_message = str_replace("*title*", $def_title, $banner_message);
                                $banner_message = str_replace("*dir_to_main*", $def_mainlocation, $banner_message);
                                $banner_message = str_replace("*firmname*", $f['firmname'], $banner_message);
                                $banner_message = str_replace("*id_firm*", $f['selector'], $banner_message);

                                mailHTML($to,$rejected_banner,$banner_message,$def_from_email);

				$uploaded = "<br /> $def_admin_bannerdeleted \"$f[firmname]\" ($f[selector])<br /><br />";

                                logsto("$def_admin_bannerdeleted <b>$f[firmname]</b> ($f[selector])");
			}
		}

		if (isset($_GET['id'])) $_POST['idident'] = $_GET['id'];

		if ((isset($_POST["idident"])) or (isset($_POST["idname"])) or (isset($_POST["idcomment"])) or (isset($_GET["find"])))

		{
			$query="select * from $db_users where ";
			if ($_POST["idident"] <> "") $query.=" selector = '$_POST[idident]' or ";

			if ($_POST["idlogin"] <> "") $query.=" login = '$_POST[idlogin]' or ";

			if ($_POST["idcomment"] <> "") $query.=" comment LIKE '%$_POST[idcomment]%' or ";

			if ($_POST["idname"] <> "") $query.=" firmname LIKE '%$_POST[idname]%' or ";

			$query.=" selector = '-1'";

			$r=$db->query ($query) or die ("mySQL error!");
			$f=$db->fetcharray ($r);
			$id=($f["selector"]);

			if (mysql_num_rows($r) == 0) {
			
			if ($_POST["inbut"] != "$def_admin_compremove")

			msg_text("80%",$def_admin_message_error,"Компания с заданными параметрами не найдена. Воспользуйтесь расширенным поиском.");
			
			}
			else {
				@ $bannerctr=$f["banner_click"]*100/$f["banner_show"];
				@ $bannerctr=round($bannerctr,2);
				$rev=$db->query ("SELECT * from $db_reviews where company = '$f[selector]'") or die (mysql_error());
				$reviews=mysql_num_rows($rev);
				@$add_host=gethostbyaddr($f[ip]);
				@$update_host=gethostbyaddr($f[ip_update]);
                                $def_admin_date=undate($f[date], $def_datetype);
				if ($f[webcounter]=="") $f_webcounter=0; else $f_webcounter=$f[webcounter];
				if ($f[icq]!="") $def_icq_img="<img src=\"http://web.icq.com/whitepages/online?icq=$f[icq]&img=21\" alt=\"\">";
                                if ($f['domen']=='') $f_domen='<font color="red">имянеуказано</font>'; else $f_domen=$f['domen'];

echo <<<HTML

<script type="text/javascript" src="../includes/js/jquery.tagsinput.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/css/jquery.tagsinput.css" />

<script type="text/javascript">
$(function(){
  $('#tags_to').tagsInput({
   'height':'120px',
   'width':'550px',
   'interactive':true,
   'defaultText':'добавить',
   'removeWithBackspace':true,
   'minChars':2,
   'placeholderColor':'#777'
  });
});
</script>

<script type="text/javascript">
function trans_find()
{
    var elm = document.getElementById('find_link');
    var show = (elm.style.display == 'none' ? 'none' : '');
    elm.style.display = (show ? '' : 'none');
    document.getElementById('find_link_hide').style.display = show;
    document.getElementById('help_mod').style.display = show;
}
function trans_stat()
{
    var elm = document.getElementById('stat_link');
    var show = (elm.style.display == 'none' ? 'none' : '');
    elm.style.display = (show ? '' : 'none');
    document.getElementById('stat_link_hide').style.display = show;
    document.getElementById('stat_mod').style.display = show;
}
function trans_mail()
{
    var elm = document.getElementById('mail_link');
    var show = (elm.style.display == 'none' ? 'none' : '');
    elm.style.display = (show ? '' : 'none');
    document.getElementById('mail_link_hide').style.display = show;
    document.getElementById('mail_mod').style.display = show;
}
</script>
<table width="100%" border="0">
  <tr>
    <td><img src="images/edit_firm.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;$def_admin_offers_k</span><a name="0"></a></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3"><img src="images/button-l.gif" width="3" height="34" /></td>
        <td background="images/button-b.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" /></td>
            <td width="160" class="vclass"><img src="images/find.gif" width="31" height="31" align="absmiddle">
		<a href="javascript:;" onclick="trans_find()" id="find_link">$def_admin_find</a>
		<a href="javascript:;" onclick="trans_find()" id="find_link_hide" style="display: none">$def_admin_hide_find</a></td>
            <td width="180" class="vclass"><img src="images/stat.gif" width="31" height="31" align="absmiddle" /><a href="javascript:;" onclick="trans_stat()" id="stat_link">$def_statistics</a>
		<a href="javascript:;" onclick="trans_stat()" id="stat_link_hide" style="display: none">$def_statistics_hide</a></td>
            <td width="230" class="vclass"><img src="images/mailto.gif" width="31" height="31" align="absmiddle" /><a href="javascript:;" onclick="trans_mail()" id="mail_link">Отправить сообщение контрагенту</a>
		<a href="javascript:;" onclick="trans_mail()" id="mail_link_hide" style="display: none">Скрыть форму сообщения</a></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
    <tr>
    <td height="22" class="info_t">$def_admin_title: <b>$f[firmname]</b>&nbsp;($def_admin_login: <u>$f[login]</u>, $def_admin_posted: $def_admin_date, IP - $f[ip] )&nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle" />&nbsp;ID=<b>$f[selector]</b>
      <br />$def_admin_page_catalog: <u><a href="$def_mainlocation/view.php?id=$f[selector]" target="_blank" class="vclass">$def_mainlocation/view.php?id=$f[selector]</a></u><br />
       Социальная страничка: <u><a href="$def_mainlocation/$f[domen]" target="_blank" class="vclass">$def_mainlocation/$f_domen</a></u> [<a class="slink" href="edseo.php?id=$f[selector]">имя</a>]  [<a class="slink" href="edtheme.php?id=$f[selector]">оформление</a>]
    </td>
    </tr>
    <tr>
      <td height="22" align="right" class="slink"><a href="#1">$def_admin_offers_r1</a> | <a href="#2">$def_admin_offers_r2</a> |<a href="#3"> $def_admin_offers_r3</a> | <a href="#4">$def_admin_offers_r4</a></td>
    </tr>
</table>
<br />
<div id="help_mod" style="display: none">
<form action="offers.php?REQ=auth" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files">$def_admin_uslovie</td>
        <td id="table_files_r">$def_admin_forma_find</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_admin_title:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idname" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_admin_login_find:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idlogin" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_admin_id_find:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idident" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_admin_comments: </td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idcomment" maxlength="100" size="40" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type="submit" name="inbut" value="$def_admin_search_button" border="0" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
<br /><br />
</div>
<div id="stat_mod" style="display: none">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files">$def_admin_razdel</td>
        <td id="table_files_r">$def_admin_info</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_banner_exposures:</td>
          <td class="blue_txt" id="table_files_i_r">$f[banner_show]</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_banner_clicks:</td>
          <td class="blue_txt" id="table_files_i_r">$bannerctr%</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_visitors:</td>
          <td class="blue_txt" id="table_files_i_r">$f[counter]</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_webvisitors:</td>
          <td class="blue_txt" id="table_files_i_r">$f_webcounter</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_reviews:</td>
          <td class="blue_txt" id="table_files_i_r">$reviews</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br /><br />
</div>
<div id="mail_mod" style="display: none">
<form action="mailto.php" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files">Название поля</td>
        <td id="table_files_r">Форма</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">E-mail: <span style="color:#FF0000;">*</span> </td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="email" maxlength="100" size="40" value="$f[mail]" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Тема сообщения: <span style="color:#FF0000;">*</span> </td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="subject" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">Текст сообщения: <span style="color:#FF0000;">*</span> </td>
          <td class="blue_txt" id="table_files_i_r"><br /><textarea name="message" cols="45" rows="5" style="width:300px; height:100px;"></textarea><br /><br /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type="submit" name="inbut" value="Отправить" border="0" /><input type="hidden" name="id" value="$idident" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
<br /><br />
</div>

HTML;

if ($offers_mess==1) msg_text('80%',$def_admin_message_error,"$def_specify $def_admin_title");
if ($offers_mess==2) msg_text("80%",$def_admin_message_ok,$def_admin_refreshed);

   require ('../includes/editor/tiny_A.php'); // Подключаем редактор

echo '<form action="offers.php?REQ=complete" method="post">';
echo '<a name="1"></a>';

table_fdata_top ($def_admin_offers_r1);

echo '<br /><table cellpadding="2" cellspacing="1" border="0" width="90%">';
				
echo '<tr><td  align="right">'.$def_admin_comments.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name="comment" maxlength="100" size="50" value="'.$f[comment].'" /></td></tr>';

echo '<tr><td  align="right">'.$def_admin_title.': &nbsp;&nbsp;</td><td align="left"><input type="text" name="firmname" maxlength="100" size="50" value="'.$f[firmname].'" /></td></tr>';

echo '
  <tr>
   <td align="right" valign="middle">
    '.$def_admin_descr.':
     &nbsp;&nbsp;</td><td  align="left">
      <textarea id="business" name="business" class="business" cols="20" rows="20" style="width:550px;">'.$f['business'].'</textarea>
   </td>
  </tr>
';

echo '<tr><td align="right">'.$def_admin_keywords.': &nbsp;&nbsp;</td><td  align="left"><input id="tags_to" type="text" name="keywords" style="width:300px;"  maxlength="200" value="'.$f['keywords'].'"></td></tr>';

require 'inc/category_offers.php'; // Подключаем файл категорий

if ($def_country_allow == "YES") echo '<tr><td align="right" "valign=middle">'.$def_admin_country.': &nbsp;&nbsp;</td><td  align="left"><SELECT NAME="location" style="width: 550px;">';
else echo '<tr><td align="right" valign="middle">'.$def_admin_city.': &nbsp;&nbsp;</td><td  align="left"><SELECT NAME="location" style="width: 550px;">';

$re=$db->query ("select * from $db_location order by location");
$results_amount=mysql_num_rows($re);

for($i=0;$i<$results_amount;$i++)
{
	$fa=$db->fetcharray ($re);

	if ($f["location"] == $fa["locationselector"])
	{
		echo '<OPTION VALUE="'.$fa[locationselector].'" SELECTED>'.$fa[location];
	}
	else
	{
		echo '<OPTION VALUE="'.$fa[locationselector].'">'.$fa[location];
	}
}

mysql_free_result($re);
echo '</SELECT></td></tr>';

if ($def_states_allow == "YES") {
	echo '<tr><td align="right" valign="middle">'.$def_admin_state.': &nbsp;&nbsp;</td><td  align="left"><SELECT NAME="state" style="width: 550px;">';

	$re=$db->query ("select * from $db_states order by state");
	$results_amount=mysql_num_rows($re);

	for($i=0;$i<$results_amount;$i++)
	{
		$fa=$db->fetcharray ($re);

		if ($f["state"] == $fa["stateselector"])
		{
			echo '<OPTION VALUE="'.$fa[stateselector].'" SELECTED>'.$fa[state];
		}
		else
		{
			echo '<OPTION VALUE="'.$fa[stateselector].'">'.$fa[state];
		}
	}

	mysql_free_result($re);
	echo '</SELECT></td></tr>';
}

if ($def_country_allow == "YES") echo '<tr><td  align="right">'.$def_admin_city.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name="city" maxlength="100" size="50" value="'.$f['city'].'" /></td></tr>';

echo '<tr><td  align="right">'.$def_admin_address.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name="address" maxlength="200" size="50" value="'.$f['address'].'" /></td></tr>';
echo '<tr><td  align="right">'.$def_admin_zip.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name="zip" maxlength="100" size="50" value="'.$f['zip'].'" /></td></tr>';
echo '<tr><td  align="right">'.$def_admin_phone.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name="phone"  maxlength="100" size="50" value="'.$f['phone'].'" /></td></tr>';
echo '<tr><td  align="right">'.$def_admin_fax.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name="fax" maxlength="100" size="50" value="'.$f['fax'].'" /></td></tr>';
echo '<tr><td  align="right">'.$def_admin_mobile.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name="mobile" maxlength="100" size="50" value="'.$f['mobile'].'" /></td></tr>';
echo '<tr><td  align="right">'.$def_admin_icq.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name="icq" maxlength="100" size=25 value="'.$f[icq].'" />'.$def_icq_img.'</td></tr>';
echo '<tr><td  align="right">'.$def_admin_manager.': &nbsp;&nbsp;</td><td  align="left"><input type="text"  maxlength="100" name=manager size="50" value="'.$f['manager'].'" /></td></tr>';
?>

  <tr><td align="right"><? echo $def_admin_mail; ?>: &nbsp;&nbsp;</td><td align="left"><input type="text" name="mail" size="50" maxlength="100" onBlur="checkemail(this.value)" value="<?php echo $f[mail]; ?>" /></td></tr>

<?php

echo '<tr><td  align="right">'.$def_admin_www.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name="www" size="50" value="'.$f['www'].'" maxlength="100" /></td></tr>';

$social=array();

$fastquotes = array ("http://", "https://", "twitter.com", "facebook.com", "vk.com", "odnoklassniki.ru", "//", "www.", "www");
$f['social']=str_replace( $fastquotes, '', $f['social'] );
$social = explode(":", $f['social']);

echo '<tr><td align="right">'.$def_admin_twitter.'</td><td  align="left"><input type="text" name="twitter" maxlength="100" size="50" value="'.$social[0].'" >&nbsp;<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/twitter.png" alt="twitter" align="absmiddle">&nbsp;</td></tr>';
echo '<tr><td align="right">'.$def_admin_facebook.'</td><td  align="left"><input type="text" name="facebook" maxlength="100" size="50" value="'.$social[1].'" >&nbsp;<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/facebook.png" alt="facebook" align="absmiddle">&nbsp;</td></tr>';
echo '<tr><td align="right">'.$def_admin_vk.'</td><td  align="left"><input type="text" name="vk" maxlength="100" size="50" value="'.$social[2].'" >&nbsp;<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/vkontakte.png" alt="vkontakte" align="absmiddle">&nbsp;</td></tr>';
echo '<tr><td align="right">'.$def_admin_odnoklassniki.'</td><td  align="left"><input type="text" name="odnoklassniki" maxlength="100" size="50" value="'.$social[3].'" >&nbsp;<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/odnoklassniki.png" alt="odnoklassniki" align="absmiddle">&nbsp;</td></tr>';


if ($def_reserved_1_enabled == "YES")
 echo '<tr><td  align="right">'.$def_reserved_1_name.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name=reserved_1 size="50" value="'.$f[reserved_1].'" maxlength="100" /></td></tr>';

if ($def_reserved_2_enabled == "YES")
 echo '<tr><td  align="right">'.$def_reserved_2_name.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name=reserved_2 size="50" value="'.$f[reserved_2].'" maxlength="100" /></td></tr>';

if ($def_reserved_3_enabled == "YES")
 echo '<tr><td  align="right">'.$def_reserved_3_name.': &nbsp;&nbsp;</td><td  align="left"><input type="text" name=reserved_3 size="50" value="'.$f[reserved_3].'" maxlength="100" /></td></tr>';

if ($f['tmail']!=1) $status_mail='<img src="images/stop.gif" width="16" height="16" align="absmiddle"> не подтвержден';

echo '<tr><td  align="right">'.$def_admin_mail.': &nbsp;&nbsp;</td><td  align="left"><a class="slink" href="mailto:'.$f[mail].'"><span style="font-size: 10px;"><u>'.$f[mail].'</u></span></a> '.$status_mail.'</td></tr>';

echo '</table>';

table_fdata_bottom();

echo '<a name="2"></a><br />';

table_fdata_top ($def_admin_offers_r2);


				$date_day = date ( "d" );
				$date_month = date ( "m" );
				$date_year = date ( "Y" );
IF ($f["date_upgrade"]<>"") {

				list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $f["date_upgrade"] );

				$first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
				$second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

				if ( $second_date > $first_date )

				{ $days = $second_date - $first_date; }

				else

				{ $days = $first_date - $second_date; }

				if ($f[flag] == "A") $expir = $def_A_expiration;
				if ($f[flag] == "B") $expir = $def_B_expiration;
				if ($f[flag] == "C") $expir = $def_C_expiration;


				$current_result = $expir - ( ( $days ) / ( 60 * 60 * 24 ) );

				if ($f[flag] != "D")
				{

					$exp=getdate (time()+86400*$current_result);
					$exp="$exp[year]-$exp[mon]-$exp[mday]";
				}
}
				echo '<table cellpadding="2" cellspacing="1" border="0" width="90%">';

				if (($f["date_upgrade"] != "0") and ($expir != "0") and (!empty($f["date_upgrade"]))) echo "<tr><td  align=right>$def_admin_upgraded: &nbsp;&nbsp;</td><td  align=left>", undate($f[date_upgrade], $def_datetype)," ($current_result $days_left ", undate($exp, $def_datetype),")</td></tr>";

				echo '<tr><td align="center"  height="21" colspan="2">'.$def_membership.'</td></tr>';
?>

 <? if ($def_A_enable == "YES") { ?> <tr><td align=right><? echo "$def_A:"; ?> &nbsp;&nbsp;</td><td align=left><input type=radio name=listing value='A' <? if ($f[flag] == 'A') echo "CHECKED";?> style="border:0;"></td></tr> <? } ?>
 <? if ($def_B_enable == "YES") { ?> <tr><td align=right><? echo "$def_B:"; ?> &nbsp;&nbsp;</td><td align=left><input type=radio name=listing value='B' <? if ($f[flag] == 'B') echo "CHECKED";?> style="border:0;"></td></tr> <? } ?>
 <? if ($def_C_enable == "YES") { ?> <tr><td align=right><? echo "$def_C:"; ?> &nbsp;&nbsp;</td><td align=left><input type=radio name=listing value='C' <? if ($f[flag] == 'C') echo "CHECKED";?> style="border:0;"></td></tr> <? } ?>
 <tr><td align=right><? echo "$def_D:"; ?> &nbsp;&nbsp;</td><td align=left><input type=radio name=listing value='D' <? if ($f[flag] == 'D') echo "CHECKED";?> style="border:0;"></td></tr>

<?
				if ($f[flag]!='D') echo "<tr><td  align=right>$def_memberships_upgrade: &nbsp;&nbsp;</td><td  align=left><select name=\"off_memberships\"><option value=\"0\" selected>$def_admin_yes</option><option value=\"1\">$def_admin_no</option></select> <img src=\"images/stop.gif\" width=\"16\" height=\"16\" align=\"absmiddle\"></td></tr>";
				
				if ($f[flag]!='D') {
				if ($f[loch_m]==1) echo '<tr><td  align="right">'.$def_memberships_locked.': &nbsp;&nbsp;</td><td  align="left"><select name="on_memberships"><option value="0">'.$def_admin_no.'</option><option value="1"  selected>'.$def_admin_yes.'</option></select> <img src="images/stop.gif" width="16" height="16" align="absmiddle"></td></tr>';
				else echo '<tr><td  align="right">'.$def_memberships_locked.': &nbsp;&nbsp;</td><td  align="left"><select name="on_memberships"><option value="0" selected>'.$def_admin_no.'</option><option value="1">'.$def_admin_yes.'</option></select></td></tr>';
				}
                                if ($f[tcase]==1) echo '<tr><td  align="right">'.$def_status_case.': &nbsp;&nbsp;</td><td  align="left"><select name="on_status"><option value="1" selected>'.$def_status_case_ok.'</option><option value="0">'.$def_status_case_not.'</option></select> <a href="addcase.php?detal='.$f['selector'].'">Документы</a></td></tr>';
                                else echo '<tr><td  align="right">'.$def_status_case.': &nbsp;&nbsp;</td><td  align="left"><select name="on_status"><option value="1">'.$def_status_case_ok.'</option><option value="0"  selected>'.$def_status_case_not.'</option></select></td></tr>';
				echo '</table><br />';
table_fdata_bottom();

echo <<<HTML

<div align="center"><br /><input type="hidden" name="oldprices" value="$f[prices]" /><input type="hidden" name="oldimages" value="$f[images]" /><input type="hidden" name="idin" value="$f[selector]" /><input type="submit" name="inbut" value="$def_admin_save" border="0" />&nbsp;<input type="submit" name="inbut" value="$def_admin_compremove" style="color: #FFFFFF; background: #D55454;" /><input type="hidden" name="oldcats" value="$f[category]" /><input type="hidden" name="idident" value="$f[selector]" /><br /><br /></div>
</form><a name="3"></a>

HTML;

table_fdata_top ($def_admin_offers_r3);

				echo "<br /><table cellpadding=2 cellspacing=1 border=0 width=\"100%\">";

				if (($f["prices"] > "0") and ($def_allow_products == "YES"))
				{
					$res=$db->query ("select num from $db_offers where firmselector='$f[selector]'");
					$price_results_amount=mysql_num_rows($res);
					mysql_free_result($res);
					$free_offers=$f["prices"]-$price_results_amount;

					echo '<tr><td align="right" valign="middle" height="21">'.$def_admin_offers.': &nbsp;&nbsp;</td><form action="edoffers.php" method="post"><td align="left" valign="middle">'.$price_results_amount.' '.$def_admin_used.', '.$free_offers.' '.$def_admin_free.' <input type="hidden" name="id" value="'.$f[selector].'" /><input type="submit" value="'.$def_admin_edit_products.'" /></td></form></tr>';
				}

				if (($f["images"] > "0") and ($def_allow_images == "YES"))
				{
					$res2=$db->query ("select num from $db_images where firmselector='$f[selector]'");
					$images_results_amount=mysql_num_rows($res2);
					mysql_free_result($res2);
					$free_images=$f["images"]-$images_results_amount;
					
					echo '<tr><td align="right" valign="middle" height="21">'.$def_admin_images.': &nbsp;&nbsp;</td><form action="edgallery.php" method="post"><td align="left" valign="middle" >'.$images_results_amount.' '.$def_admin_used.', '.$free_images.' '.$def_admin_free.' <input type="hidden" name="id" value="'.$f[selector].'" /><input type=submit value="'.$def_admin_edit_images.'" /></td></form></tr>';
				}

				if (($f["exel"] > "0") and ($def_allow_exel == "YES"))
				{
					$res3=$db->query ("select num from $db_exelp where firmselector='$f[selector]'");
					$exel_results_amount=mysql_num_rows($res3);
					mysql_free_result($res3);
					$free_exel=$f["exel"]-$exel_results_amount;
				
					echo '<tr><td align="right" valign="middle" height="21">'.$def_admin_exel.': &nbsp;&nbsp;</td><form action="edexel.php" method="post"><td align="left" valign="middle" >'.$exel_results_amount.' '.$def_admin_used.', '.$free_exel.' '.$def_admin_free.' <input type="hidden" name="id" value="'.$f[selector].'" /><input type=submit value="'.$def_admin_edit_exel.'" /></td></form></tr>';
				}

				if (($f["video"] > "0") and ($def_allow_video == "YES"))
				{

					$res4=$db->query ("select num from $db_video where firmselector='$f[selector]'");
					$video_results_amount=mysql_num_rows($res4);
					mysql_free_result($res4);
					$free_video=$f["video"]-$video_results_amount;

					echo '<tr><td align="right" valign="middle" height="21" >'.$def_admin_video.': &nbsp;&nbsp;</td><form action="edvideo.php" method="post"><td align="left" valign="middle">'.$video_results_amount.' '.$def_admin_used.', '.$free_video.' '.$def_admin_free.' <input type="hidden" name="id" value="'.$f[selector].'" /><input type="submit" value="'.$def_admin_edit_video.'" /></td></form></tr>';
				}

				if ($def_allow_info == "YES")
				{

					$flag = $f[flag];
					$dop_info=ifType_info($f[flag], "setinfo");
					$ost_info=$dop_info-$f[info];
					if ($f[info]=="") $all_info=0; else $all_info=$f[info];	
				
					echo '<tr><td align="right" valign="middle" height="21" >'.$def_info_infos.': &nbsp;&nbsp;</td><form action="edinfo.php" method="post"><td align="left" valign="middle" >'.$all_info.' '.$def_admin_used.', '.$dop_info.' '.$def_admin_free.' <input type="hidden" name="id" value="'.$f[selector].'" /><input type="submit" value="'.$def_admin_edit_info.'" /></td></form></tr>';
				}

				if ($f[filial]=="") $filial=0; else $filial=$f[filial];
				
				echo '<tr><td align="right" valign="middle" height="21" >'.$def_info_filial.': &nbsp;&nbsp;</td><form action="edfilial.php" method="post"><td align="left" valign="middle" >'.$filial.' '.$def_admin_filial.' <input type="hidden" name="id" value="'.$f[selector].'" /><input type=submit value="'.$def_admin_edit_filial.'" /></td></form></tr>';
                                echo '<tr><td align="right" valign="middle" height="21" >'.$def_admin_seo.': &nbsp;&nbsp;</td><form action="edseo.php" method="post"><td align="left" valign="middle" > <input type="hidden" name="id" value="'.$f[selector].'" /><input type=submit value="'.$def_images_edit_but.'" /></td></form></tr>';
                                echo '<tr><td align="right" valign="middle" height="21" >'.$def_admin_theme.': &nbsp;&nbsp;</td><form action="edtheme.php" method="post"><td align="left" valign="middle" > <input type="hidden" name="id" value="'.$f[selector].'" /><input type=submit value="'.$def_images_edit_but.'" /></td></form></tr>';
                                echo '<tr><td align="right" valign="middle" height="21" >'.$def_admin_map.': &nbsp;&nbsp;</td><form action="edmap.php" method="post"><td align="left" valign="middle" > <input type="hidden" name="id" value="'.$f[selector].'" /><input type=submit value="'.$def_admin_maps.'" /></td></form></tr>';
				echo '</table><br />';

table_fdata_bottom();

echo '<a name="4"></a><br />';

table_fdata_top ($def_admin_offers_r4);

?>

<FORM ACTION="offers.php?REQ=auth" METHOD="POST" ENCTYPE="multipart/form-data">
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
	<TR>
		<TD HEIGHT="21"  align="center" valign="center">
			<?php echo "<b>$def_banner</b> (TOP, max $def_banner_width x $def_banner_height @ $def_banner_size Байт)"; ?>
		</TD>
	</TR>
	<TR>
		<TD align="center">
<?php

$banhandle = opendir('.././banner');

$bancount=0;

while (false != ($banfile = readdir($banhandle))) {
	if ($banfile != "." && $banfile != "..") {
		$banbanner[$bancount]="$banfile";
		$bancount++;
	}
}
closedir($banhandle);

for ($aaa=0;$aaa<count($banbanner);$aaa++)
{
	$banrbanner = explode(".", $banbanner[$aaa]);

	if ($banrbanner[0] == $f[selector]) $filename="$banbanner[$aaa]";
}

?>
                        <?php if (isset($filename)) {echo "<br /><img src=\".././banner/$filename?$randomized\" alt=\"TOP\"><br /><br />";} ?>
                        <?php if ((isset($uploaded) and ($_POST["mode"] == "banner"))) {echo " <b>$uploaded</b> "; } ?>
			<INPUT TYPE="file" NAME="img1" SIZE="25" />&nbsp;<input type="hidden" name="step" value="back" /><input type="hidden" name="idident" value="<? echo $f[selector]; ?>" /><input type="hidden" name="mode" value="banner" /><input type="hidden" name="do" value="uploaded" /><INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo $def_upload;?>" />&nbsp;<INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo $def_remove; ?>" style="color: #FFFFFF; background: #D55454;" />
		</TD>
	</TR>
</TABLE>
</FORM>

<FORM ACTION="offers.php?REQ=auth" METHOD="POST" ENCTYPE="multipart/form-data">
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
	<TR>
		<TD HEIGHT="21"  align="center" valign="center">
			<?php echo "<br /><b>$def_banner</b> (SIDE, max $def_banner2_width x $def_banner2_height @ $def_banner2_size Байт)<br />"; ?>
		</TD>
	</TR>
	<TR>
		<TD align="center">
<?php

$ban2handle = opendir('.././banner2');

$ban2count=0;

while (false != ($ban2file = readdir($ban2handle))) {
	if ($ban2file != "." && $ban2file != "..") {
		$ban2banner[$ban2count]="$ban2file";
		$ban2count++;
	}
}
closedir($ban2handle);

for ($aaa2=0;$aaa2<count($ban2banner);$aaa2++)
{
	$ban2rbanner = explode(".", $ban2banner[$aaa2]);
	if ($ban2rbanner[0] == $f[selector]) $filename2="$ban2banner[$aaa2]";
}

?>
                        <?php if (isset($filename2)) {echo "<br /><img src=\".././banner2/$filename2?$randomized\" alt=\"SIDE\" /><br /><br />"; } ?>
                        <?php if ((isset($uploaded) and ($_POST["mode"] == "banner2"))) {echo " <b>$uploaded</b> "; } ?>
			<INPUT TYPE="file" NAME="img1" SIZE="25" />&nbsp;<input type="hidden" name="step" value="back" /><input type="hidden" name="idident" value="<? echo $f[selector]; ?>" /><input type="hidden" name="mode" value="banner2" /><input type="hidden" name="do" value="uploaded" /><INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo $def_upload;?>" />&nbsp;<INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo $def_remove; ?>" style="color: #FFFFFF; background: #D55454;" />
		</TD>
	</TR>
</TABLE>
</FORM>

<FORM ACTION="offers.php?REQ=auth" METHOD="POST" ENCTYPE="multipart/form-data">
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
	<TR>
		<TD HEIGHT="21" align="center" valign="center">
			<?php echo "<br /><b>$def_logo</b> ($def_logo_width @ $def_logo_size Байт)<br />"; ?>
		</TD>
	</TR>
	<TR>
		<TD align="center">
<?php

$handle3 = opendir('.././logo');

$count=0;
while (false != ($file = readdir($handle3))) {
	if ($file != "." && $file != "..") {
		$logo[$count]="$file";
		$count++;
	}
}
closedir($handle3);

for ($xx3=0;$xx3<count($logo);$xx3++)
{

	$rlogo = explode(".", $logo[$xx3]);
	if ($rlogo[0] == $f[selector]) $filename3 = "$logo[$xx3]";

}
?>
                        <?php if ( isset ( $filename3 ) ) { echo "<br /><img src=\".././logo/$filename3?$randomized\" alt=\"Логотип\" /><br /><br />"; } ?>
                        <?php if ( ( isset ( $uploaded ) and ( $_POST["mode"] == "logo" ) ) ) { echo "<b>$uploaded</b>"; } ?>
			<INPUT TYPE="file" NAME="img1" SIZE="25" />&nbsp;<input type="hidden" name="idident" value="<? echo $f[selector]; ?>" /><input type="hidden" name="step" value="back" /><input type="hidden" name="mode" value="logo" /><input type="hidden" name="do" value="uploaded"><INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo $def_upload; ?>" />&nbsp;<INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo "$def_remove"; ?>" style="color: #FFFFFF; background: #D55454;" />
		</TD>
	</TR>
</TABLE>
</FORM>

<FORM ACTION="offers.php?REQ=auth" METHOD="POST" ENCTYPE="multipart/form-data">
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
	<TR>
		<TD HEIGHT="21" align="center" valign="center">
			<?php echo "<br /><b>$def_sxema</b> ($def_sxema_width @ $def_sxema_size Байт)<br />"; ?>
		</TD>
	</TR>
	<TR>
		<TD align="center">
<?php

$handle4 = opendir('.././sxema');

$count=0;
while (false != ($file = readdir($handle4))) {
	if ($file != "." && $file != "..") {
		$sxema[$count]="$file";
		$count++;
	}
}
closedir($handle4);

for ($xx4=0;$xx4<count($sxema);$xx4++)
{

	$rsxema = explode(".", $sxema[$xx4]);
	if ($rsxema[0] == $f[selector]) $filename4 = "$sxema[$xx4]";

}
?>
                        <?php if ( isset ( $filename4 ) ) { echo "<br /><img src=\".././sxema/$filename4?$randomized\" alt=\" Схема проезда\" /><br /><br />"; } ?>
                        <?php if ( ( isset ( $uploaded ) and ( $_POST["mode"] == "sxema" ) ) ) { echo "<b>$uploaded</b>"; } ?>
			<INPUT TYPE="file" NAME="img1" SIZE="25" />&nbsp;<input type="hidden" name="idident" value="<? echo "$f[selector]"; ?>" /><input type="hidden" name="step" value="back" /><input type="hidden" name="mode" value="sxema" /><input type="hidden" name="do" value="uploaded" /><INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo $def_upload; ?>" />&nbsp;<INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?php echo $def_remove; ?>" style="color: #FFFFFF; background: #D55454;" />
		</TD>
	</TR>
</TABLE>
</FORM>
 <br />

<?php

table_fdata_bottom();

} }
	}

require_once 'template/footer.php';

?>
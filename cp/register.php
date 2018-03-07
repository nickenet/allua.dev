<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & K.Ilya
=====================================================
 Файл: register.php
-----------------------------------------------------
 Назначение: Создать нового контрагента
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$reg_help;

$title_cp = 'Создать нового контрагента - ';
$speedbar = ' | <a href="register.php">Создать нового контрагента</a>';

check_login_cp('1_4','register.php');

require_once 'template/header.php';

table_item_top ('Создать нового контрагента','pset.png');


	if ( $_POST["regbut"] == "$def_reg" )

	{

		$firmname = safeHTML ( $_POST["firmname"] );

		$business = post_to_shortfull ( $_POST["business"] );

                $keywords = safeHTML ( strip_tags($_POST['keywords']) );
                $keywords = str_replace("  ", " ", $keywords);
                $twitter = safeHTML($_POST['twitter']);
                $facebook = safeHTML($_POST['facebook']);
                $vk = safeHTML($_POST['vk']);
                $odnoklassniki = safeHTML($_POST['odnoklassniki']);
                $social=$twitter.':'.$facebook.':'.$vk.':'.$odnoklassniki;

		$address = safeHTML ( $_POST["address"] );

		if ( $def_country_allow == "YES" )

		{

			$city = safeHTML ( $_POST["city"] );

		}

		$zip = safeHTML ( $_POST["zip"] );

		$flag = $_POST["listing"];

		$phone = safeHTML ( $_POST["phone"] );
		$fax = safeHTML ( $_POST["fax"] );
		$mobile = safeHTML ( $_POST["mobile"] );
		$icq = safeHTML ( $_POST["icq"] );


		$manager = safeHTML ( $_POST["manager"] );
		$mail = safeHTML ( $_POST["mail"] );

		if ( $_POST["www"] <> "" )

		{

			if ( preg_match("#http://#", $_POST["www"]) )

			{ $www = $_POST[www]; }

			else

			{

				$www = "http://$_POST[www]";

			}

		}

		$www = safeHTML ( $www );

		$reserved_1 = safeHTML ( $_POST[reserved_1] );
		$reserved_2 = safeHTML ( $_POST[reserved_2] );
		$reserved_3 = safeHTML ( $_POST[reserved_3] );

		$comment = safeHTML ( $_POST["comment"] );


		$r = $db->query  ( "SELECT selector FROM $db_users WHERE login='$_POST[login]'" );

		$logins = mysql_num_rows ( $r );

		mysql_free_result ( $r );

		if ( count($_POST[category]) == 0 ) { msg_text('80%',$def_admin_message_error,"$def_specify $def_admin_category"); }

		elseif ( $firmname == "" ) { msg_text('80%',$def_admin_message_error,"$def_specify $def_admin_title."); }
		elseif ( strlen ( $_POST["login"] ) < "4" ) { msg_text('80%',$def_admin_message_error,$def_login_short); }
		elseif ( strlen ( $_POST["pass"] ) < "4" ) { msg_text('80%',$def_admin_message_error,$def_pass_short); }
		elseif ( 
		     strpos($_POST['login'], ' ') !== false || strpos($_POST['login'], '"') !== false 
		  || strpos($_POST['pass'],  ' ') !== false || strpos($_POST['pass'],  '"') !== false) 
		{ 
			msg_text('80%',$def_admin_message_error,$def_reg_nospaces_commas);		  
		}

		elseif ( $logins > 0 ) { msg_text('80%',$def_admin_message_error,$def_reg_login_used); }

		else

		{

			$index_category = 1;

			for ($index = 0; $index < count ( $_POST[category] ); $index++)

			{

				if ($_POST[category][$index] != "") {

					$category_index[$index_category] = $_POST[category][$index];$index_category++;

					if ((($def_onlypaid == "YES") and ($_POST[listing] != "D")) or (($def_onlypaid != "YES")))

					{

						$new_cat = explode ("#", $_POST[category][$index]);

						if ($new_cat[0] != $prev_cat)

						$db->query ("UPDATE $db_category SET fcounter = fcounter+1 where selector=$new_cat[0]") or die ("mySQL error!");

						if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[1] != $prev_subcat))

						$db->query ("UPDATE $db_subcategory SET fcounter = fcounter+1 where catsel=$new_cat[0] and catsubsel=$new_cat[1]") or die ("mySQL error!");

						if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[2] != "") and ($new_cat[2] != "0"))

						$db->query ("UPDATE $db_subsubcategory SET fcounter = fcounter+1 where catsel=$new_cat[0] and catsubsel=$new_cat[1] and catsubsubsel=$new_cat[2]") or die ("mySQL error!");

						$prev_cat=$new_cat[0];
						$prev_subcat=$new_cat[1];

					}
				}
			}

			@ $category = join(":", $category_index);

			$ip = $_SERVER["REMOTE_ADDR"];

			if (($flag == "A") or ($flag == "B") or ($flag == "C"))

			$date_upgrade = date ( "Y-m-d" );

			$date = date ( "Y-m-d" );

			if ( $def_country_allow == "YES" )

			{

				$location = $_POST["location"];
				$postedcity = $city;

			}

			else

			{

				$location = $_POST["location"];
				$postedcity = "";

			}

			if ( $def_states_allow == "YES" )

			{

				$state = $_POST["state"];

			}

			$pass = my_crypt ( $_POST[pass] );

			$set_products = "def_" . $flag . "_setproducts";
			$set_images= "def_" . $flag . "_setimages";
			$set_exels= "def_" . $flag . "_setexel";
			$set_video= "def_" . $flag . "_setvideo";
			

			$products = $$set_products;
			$images = $$set_images;
			$exels = $$set_exels;
			$video = $$set_video;

			$db->query  ( "INSERT INTO $db_users (firmstate, flag, comment, category, login, firmname, keywords, business, location, state, city, address, zip, phone, fax, mobile, icq, manager, mail, www, social, pass, prices, images, exel, video, ip, date, date_upgrade, counter, banner_show, banner_click, price_show, reserved_1, reserved_2, reserved_3) VALUES ('on', '$flag', '$comment', '$category', '$_POST[login]', '$firmname', '$keywords', '$business', '$location', '$state', '$postedcity', '$address', '$zip', '$phone', '$fax', '$mobile', '$icq', '$manager', '$mail', '$www', '$social', '$pass', '$products', '$images', '$exels', '$video', '$ip', '$date', '$date_upgrade', 1, 0, 0, 0, '$reserved_1', '$reserved_2', '$reserved_3')" ) or die (mysql_error());

			$id_new_firms=mysql_insert_id();

			logsto("$def_admin_log_newadded <b>$firmname</b>");

			msg_text('80%',$def_admin_message_ok,$def_reg_ok.' Компания: <a href="offers.php?REQ=auth&id='.$id_new_firms.'">'.$firmname.'</a> [id='.$id_new_firms.']');

		}

	}

table_fdata_top ('Заполните форму регистрации');

   require ('../includes/editor/tiny_A.php');

?>

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

 <form name="reg" action="register.php" method="post">

 <table width="800" cellpadding="2" cellspacing="2" border="0" >

 <? if ($def_A_enable == "YES") { ?> <tr><td align="right"><? echo "$def_A:"; ?> &nbsp;&nbsp;<input type=radio name=listing value='A' <? if ($flag == 'A') echo "CHECKED";?> style="border:0;"></td></tr> <? } ?>
 <? if ($def_B_enable == "YES") { ?> <tr><td align="right"><? echo "$def_B:"; ?> &nbsp;&nbsp;<input type=radio name=listing value='B' <? if ($flag == 'B') echo "CHECKED";?> style="border:0;"></td></tr> <? } ?>
 <? if ($def_C_enable == "YES") { ?> <tr><td align="right"><? echo "$def_C:"; ?> &nbsp;&nbsp;<input type=radio name=listing value='C' <? if ($flag == 'C') echo "CHECKED";?> style="border:0;"></td></tr> <? } ?>
 <tr><td align="right"><? echo "$def_D:"; ?> &nbsp;&nbsp;<input type=radio name=listing value='D' <? if (($flag == 'D') or (!isset($flag))) echo "CHECKED";?> style="border:0;"></td></tr>
 
  <tr>
   <td align="right">
    <?php echo $def_admin_comments; ?>: &nbsp;&nbsp;
      <input type="text" name="comment" size="50" maxlength="200">
   </td>
  </tr>
 <tr>
  <td align="right">
<? require 'inc/category_reg.php'; // Подключаем файл категорий ?>
  <tr>
   <td align="right">
    <?php echo $def_admin_title; ?>: 
     <font color="red">*</font>
      <input type="text" name="firmname" size="50" maxlength="100" />
   </td>
  </tr>
  <tr>
   <td align="right" valign="middle">
    <?php echo $def_admin_descr; ?>: &nbsp;&nbsp;<br /><br />
     <textarea name="business" class="business" cols="20" rows="10" style="width:550px;" id="business"></textarea>
   </td>
  </tr>
   <tr>
   <td align="right"><?php echo $def_admin_keywords; ?>:
      <input type="text" id="tags_to" name="keywords" size="50" maxlength="100"><br />
   </td>
  </tr>

<?php

if ($def_country_allow == "YES") echo "<tr><td align=right valign=middle >$def_admin_country: &nbsp;&nbsp;<SELECT NAME=\"location\">";
else echo "<tr><td align=right valign=middle >$def_admin_city: &nbsp;&nbsp;<SELECT NAME=\"location\">";

$re=$db->query ("select * from $db_location order by location");
$results_amount=mysql_num_rows($re);

for($i=0;$i<$results_amount;$i++)
{
	$fa=$db->fetcharray ($re);

	if ($location == $fa["locationselector"])
	{
		echo "<OPTION VALUE=\"$fa[locationselector]\" SELECTED>$fa[location]";
	}
	else
	{
		echo "<OPTION VALUE=\"$fa[locationselector]\">$fa[location]";
	}
}

mysql_free_result($re);
echo "</SELECT></td></tr>";

if ($def_states_allow == "YES") {
	echo "<tr><td align=right valign=middle >$def_admin_state: &nbsp;&nbsp;<SELECT NAME=\"state\">";

	$re=$db->query ("select * from $db_states order by state");
	$results_amount=mysql_num_rows($re);

	for($i=0;$i<$results_amount;$i++)
	{
		$fa=$db->fetcharray ($re);

		if ($state == $fa["stateselector"])
		{
			echo "<OPTION VALUE=\"$fa[stateselector]\" SELECTED>$fa[state]";
		}
		else
		{
			echo "<OPTION VALUE=\"$fa[stateselector]\">$fa[state]";
		}
	}

	mysql_free_result($re);
	echo "</SELECT></td></tr>";
}

if ( $def_country_allow == "YES" )

{

?>

  <tr> 
   <td align="right">
    <?php echo $def_admin_city; ?>: &nbsp;&nbsp;
      <input type="text" name="city" size="50" maxlength="100" />
   </td>
  </tr>

<?php

}

?>

  <tr>
   <td align="right">
    <?php echo $def_admin_address; ?>: &nbsp;&nbsp;
     <input type="text" name="address" maxlength="200" size="50" />
   </td>
  </tr>
  <tr>
   <td align="right">
    <?php echo $def_admin_zip; ?>: &nbsp;&nbsp;
     <input type="text" name="zip" maxlength="100" size="50" />
   </td>
  </tr>
  <tr>
   <td align="right">
    <?php echo $def_admin_phone; ?>: &nbsp;&nbsp;
      <input type="text" name="phone" maxlength="100" size="50" />
   </td>
  </tr>
  <tr>
   <td align="right">
    <?php echo $def_admin_fax; ?>: &nbsp;&nbsp;
      <input type="text" name="fax" maxlength="100" size="50" />
   </td>
  </tr>
  <tr>
   <td align="right">
    <?php echo $def_admin_mobile; ?>: &nbsp;&nbsp;
      <input type="text" name="mobile" maxlength="100" size="50" />
   </td>
  </tr>
  <tr>
   <td align="right">
    <?php echo $def_admin_icq; ?>: &nbsp;&nbsp;
      <input type="text" name="icq" maxlength="100" size="50" />
   </td>
  </tr>
  <tr>
   <td align="right">
    <?php echo $def_admin_manager; ?>: &nbsp;&nbsp;
      <input type="text" maxlength="100"  name="manager" size="50" />
   </td>
  </tr>
  <tr>
   <td align="right">
    <?php echo $def_admin_mail; ?>: &nbsp;&nbsp;
      <input type="text" name="mail" maxlength="100" size="50" onBlur="checkemail(this.value)">
   </td>
  </tr>
   <tr>
   <td align="right">
    <?php echo $def_admin_www; ?>: &nbsp;&nbsp;
     <input type="text" name="www"  size="50" maxlength="100" />
   </td>
  </tr>
    <tr>
   <td align="right"><?php echo $def_admin_twitter; ?> &nbsp;&nbsp;
     <input type="text" name="twitter" size="50" maxlength="100">&nbsp;<img src="<? echo $def_mainlocation; ?>/template/<? echo $def_template; ?>/images/twitter.png" alt="twitter" align="absmiddle">&nbsp;
   </td>
  </tr>
  <tr>
   <td align="right"><?php echo $def_admin_facebook; ?> &nbsp;&nbsp;
     <input type="text" name="facebook" size="50" maxlength="100">&nbsp;<img src="<? echo $def_mainlocation; ?>/template/<? echo $def_template; ?>/images/facebook.png" alt="facebook" align="absmiddle">&nbsp;
   </td>
  </tr>
  <tr>
   <td align="right"><?php echo $def_admin_vk; ?> &nbsp;&nbsp;
     <input type="text" name="vk" size="50" maxlength="100">&nbsp;<img src="<? echo $def_mainlocation; ?>/template/<? echo $def_template; ?>/images/vkontakte.png" alt="vk" align="absmiddle">&nbsp;
   </td>
  </tr>
  <tr>
   <td align="right"><?php echo $def_admin_odnoklassniki; ?> &nbsp;&nbsp;
     <input type="text" name="odnoklassniki" size="50" maxlength="100">&nbsp;<img src="<? echo $def_mainlocation; ?>/template/<? echo $def_template; ?>/images/odnoklassniki.png" alt="odnoklassniki" align="absmiddle">&nbsp;
   </td>
  </tr>

<? if ($def_reserved_1_enabled == "YES") { ?>

  <tr>
   <td align="right">
    <?php echo $def_reserved_1_name; ?>: &nbsp;&nbsp;
     <input type="text" name="reserved_1"  size="50" maxlength="100" />
   </td>
  </tr>

<? } ?>

<? if ($def_reserved_2_enabled == "YES") { ?>

  <tr>
   <td align="right">
    <?php echo $def_reserved_2_name; ?>: &nbsp;&nbsp;
     <input type="text" name="reserved_2"  size="50" maxlength="100" />
   </td>
  </tr>

<? } ?>

<? if ($def_reserved_3_enabled == "YES") { ?>

  <tr>
   <td align="right">
    <?php echo $def_reserved_3_name; ?>: &nbsp;&nbsp;
     <input type="text" name="reserved_3"  size="50" maxlength="100" />
   </td>
  </tr>

<? } ?>

  <tr>
   <td align="right">
    Измените логин и пароль.
   </td>
  </tr>
  <tr>
   <td align="right">
    <?php echo $def_admin_login; ?>: 
     <font color="red">*</font>
      <input type="text" name="login" maxlength="100" value = "<? echo "login" . rand (1, 999999);?>" size="50" />
   </td>
  </tr>
  <tr>
   <td align="right">
    <?php echo $def_admin_password; ?>: 
     <font color="red">*</font>
      <input type="text" maxlength="100" name="pass" value="password" size="50" />
   </td>
  </tr>
  <tr>
   <td align="right">
    <input type="submit" name="regbut" value="<?php echo "$def_reg"; ?>" />
   </td>
  </tr>
 </table>
</form>
<br />

<?php

table_fdata_bottom();

require_once 'template/footer.php';

?>
<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: info.php
-----------------------------------------------------
 Назначение: Редактирование информации о компании
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<style type="text/css">
   OPTGROUP.catXR {
    background: #000000; /* Цвет фона */
    color: #FFFFFF; /* Цвет текста */
   }
   OPTGROUP.subXR {
    background: #CCCCCC; /* Цвет фона */
    color: #000000; /* Цвет текста */
   }
   OPTION {
    color:  #000; /* Цвет текста */
    background: #fff; /* Цвет фона */
   }
   OPTION.mainXR {
    background: #E8E8E8; /* Цвет фона */
    color: #000000; /* Цвет текста */
   }
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Изменить общую информацию</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Изменить данные</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td align="right">

<?php

// Изменить данные

   require ('../includes/editor/tiny_'.$f['flag'].'.php');

?>
  
<form action="user.php?REQ=authorize&mod=changeinfo" method="post">
    <table cellpadding="5" cellspacing="1" border="0" width="100%">
	<tr><td align="center">

                <? require 'inc/category_info.php'; // Подключаем файл категорий ?>

        </td></tr>

<tr><td align="right"><? echo $def_company; ?>: <font color="red">*</font><input type="text" name="firmname" maxlength="100" style="width:300px;" value="<? echo $f[firmname]; ?>"></td></tr>

<?

echo '
  <tr>
   <td align="right" valign="top">
    '.$def_description.':
     <font color="red">*</font><br><br>
      <textarea id="business" name="business" class="business" cols="20" rows="20" style="width:400px;">'.$f[business].'</textarea>
   </td>
  </tr>
';

echo '<tr><td align="right">'.$def_keywords.': &nbsp;&nbsp;<input  id="tags_to" type="text" name="keywords"  value="'.$f['keywords'].'" /></td></tr>';


if ($def_country_allow == "YES") {

	echo '<tr><td align="right" valign="middle">'.$def_country.': <font color=red>*</font><SELECT NAME="country" style="width:300px;">';

	$re=$db->query ("select * from $db_location order by location");
	$results_amount=mysql_num_rows($re);

	for($i=0;$i<$results_amount;$i++)
	{
		$fa=$db->fetcharray ($re);

		if ($f['location'] == $fa['locationselector'])
		{
			echo '<OPTION VALUE="'.$fa['locationselector'].'" SELECTED>'.$fa['location'].'</OPTION>';
		}
		else
		{
			echo '<OPTION VALUE="'.$fa['locationselector'].'">'.$fa['location'].'</OPTION>';
		}
	}

	$db->freeresult ($re);
	echo '</SELECT></td></tr>';
}

else

{
	echo '<tr><td align="right" valign="middle">'.$def_city.': <font color="red">*</font><SELECT NAME="city2"  style="width:300px;">';

	$re=$db->query ("select * from $db_location order by location");
	$results_amount=mysql_num_rows($re);

	for($i=0;$i<$results_amount;$i++)
	{
		$fa=$db->fetcharray ($re);

		if ($f['location'] == $fa['locationselector'])
		{
			echo '<OPTION VALUE="'.$fa['locationselector'].'" SELECTED>'.$fa['location'].'</OPTION>';
		}
		else
		{
			echo '<OPTION VALUE="'.$fa['locationselector'].'">'.$fa['location'].'</OPTION>';
		}
	}

	$db->freeresult ($re);
	echo '</SELECT></td></tr>';
}


if ($def_states_allow == "YES") {

	echo '<tr><td align="right" valign="middle">'.$def_state.': <font color="red">*</font><SELECT NAME="state"  style="width:300px;">';

	$re=$db->query ("select * from $db_states order by state");
	$results_amount=mysql_num_rows($re);

	for($i=0;$i<$results_amount;$i++)
	{
		$fa=$db->fetcharray ($re);

		if ($f["state"] == $fa["stateselector"])
		{
			echo '<OPTION VALUE="'.$fa['stateselector'].'" SELECTED>'.$fa['state'].'</OPTION>';
		}
		else
		{
			echo '<OPTION VALUE="'.$fa['stateselector'].'">'.$fa['state'].'</OPTION>';
		}
	}

	$db->freeresult ($re);
	echo '</SELECT></td></tr>';

}

if ($def_country_allow == "YES") echo '<tr><td align="right">'.$def_city.': <font color="red">*</font><input type="text" name="city" style="width:300px;" maxlength="100" value="'.$f['city'].'"></td></tr>';

echo '<tr><td align="right">'.$def_address.': &nbsp;&nbsp;<input type="text" name="address" style="width:300px;"  maxlength="200" value="'.$f['address'].'"></td></tr>';
echo '<tr><td align="right">'.$def_zip.': &nbsp;&nbsp;<input type="text" name="zip" maxlength="100" style="width:300px;" value="'.$f['zip'].'"></td></tr>';
echo '<tr><td align="right">'.$def_phone.': &nbsp;&nbsp;<input type="text" name="phone"  maxlength="100" style="width:300px;" value="'.$f['phone'].'"></td></tr>';
echo '<tr><td align="right">'.$def_fax.': &nbsp;&nbsp;<input type="text" name="fax" maxlength="100" style="width:300px;" value="'.$f[fax].'"></td></tr>';
echo '<tr><td align="right">'.$def_mobile.': &nbsp;&nbsp;<input type="text" name="mobile"  maxlength="100" style="width:300px;" value="'.$f['mobile'].'"></td></tr>';
echo '<tr><td align="right">'.$def_icq.': &nbsp;&nbsp;<input type="text" name="icq" maxlength="100" style="width:300px;" value="'.$f[icq].'"></td></tr>';
echo '<tr><td align="right">'.$def_manager.': &nbsp;&nbsp;<input type="text" name="manager" maxlength="100"  style="width:300px;" value="'.$f['manager'].'"></td></tr>';
echo '<tr><td align="right">'.$def_email.': <font color="red">*</font><input type="text" name="mail" maxlength="100" style="width:300px;"  value="'.$f['mail'].'"></td></tr>';
echo '<tr><td align="right">'.$def_webpage.': &nbsp;&nbsp;<input type="text" name="www" maxlength="100" style="width:300px;" value="'.$f['www'].'" ></td></tr>';

$social=array();

$fastquotes = array ("http://", "https://", "twitter.com", "facebook.com", "vk.com", "odnoklassniki.ru", "//", "www.", "www");
$f['social']=str_replace( $fastquotes, '', $f['social'] );
$social = explode(":", $f['social']);

echo '<tr><td align="right">'.$def_twitter.' &nbsp;&nbsp;<input type="text" name="twitter" maxlength="100" style="width:300px;" value="'.$social[0].'" >&nbsp;<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/twitter.png" alt="twitter" align="absmiddle">&nbsp;</td></tr>';
echo '<tr><td align="right">'.$def_facebook.' &nbsp;&nbsp;<input type="text" name="facebook" maxlength="100" style="width:300px;" value="'.$social[1].'" >&nbsp;<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/facebook.png" alt="facebook" align="absmiddle">&nbsp;</td></tr>';
echo '<tr><td align="right">'.$def_vk.' &nbsp;&nbsp;<input type="text" name="vk" maxlength="100" style="width:300px;" value="'.$social[2].'" >&nbsp;<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/vkontakte.png" alt="vkontakte" align="absmiddle">&nbsp;</td></tr>';
echo '<tr><td align="right">'.$def_odnoklassniki.' &nbsp;&nbsp;<input type="text" name="odnoklassniki" maxlength="100" style="width:300px;" value="'.$social[3].'" >&nbsp;<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/odnoklassniki.png" alt="odnoklassniki" align="absmiddle">&nbsp;</td></tr>';

// Дополнительные переменные
if ($def_reserved_1_enabled == "YES") echo '<tr><td align="right">'.$def_reserved_1_name.': &nbsp;&nbsp;<input type="text" name="reserved_1" maxlength="100" style="width:300px;" value="'.$f['reserved_1'].'" ></td></tr>';
if ($def_reserved_2_enabled == "YES") echo '<tr><td align="right">'.$def_reserved_2_name.': &nbsp;&nbsp;<input type="text" name="reserved_2" maxlength="100" style="width:300px;" value="'.$f['reserved_2'].'" ></td></tr>';
if ($def_reserved_3_enabled == "YES") echo '<tr><td align="right">'.$def_reserved_3_name.': &nbsp;&nbsp;<input type="text" name="reserved_3" maxlength="100" style="width:300px;" value="'.$f['reserved_3'].'" ></td></tr>';

// Если Вы используете еще дополнительные переменные, уберите ремарки
// if ($def_reserved_4_enabled == "YES") echo '<tr><td align="right">'.$def_reserved_4_name.': &nbsp;&nbsp;<input type="text" name="reserved_4" maxlength="100" style="width:300px;" value="'.$f['reserved_4'].'" ></td></tr>';
// if ($def_reserved_5_enabled == "YES") echo '<tr><td align="right">'.$def_reserved_5_name.': &nbsp;&nbsp;<input type="text" name="reserved_5" maxlength="100" style="width:300px;" value="'.$f['reserved_5'].'" ></td></tr>';
// if ($def_reserved_6_enabled == "YES") echo '<tr><td align="right">'.$def_reserved_6_name.': &nbsp;&nbsp;<input type="text" name="reserved_6" maxlength="100" style="width:300px;" value="'.$f['reserved_6'].'" ></td></tr>';

echo '<tr><td align="right">'.$def_pass.': &nbsp;&nbsp;<input type="password" name="password" maxlength="100" style="width:300px;" value="'.$f['pass'].'"></td></tr>';
echo '<tr><td align="right">'.$def_pass.' '.$def_repeat.': &nbsp;&nbsp;<input type="password" name="password2" maxlength="100"  style="width:300px;" value="'.$f['pass'].'" ></td></tr>';
echo '<input type="hidden" name="changed" value="true">';
echo '<input type="hidden" name="tarif" value="'.$f['flag'].'">';
echo '<tr><td align="right"><input type="hidden" name="step" value="back"><input type="submit" value="'.$def_offers_change.'" class="btn btn-warning"></td></tr>';

// Изменить данные

?>
</table>
</form>
			</td>
                        </tr>
                  </table></td>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                </tr>
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_left_r.gif" width="3" height="1"></td>
                  <td background="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif" width="3" height="1"></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_right_r.gif" width="3" height="1"></td>
                </tr>
              </table>
            </div>
            </div>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
          <div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
          <div class="CollapsiblePanelContent">
            <? echo "$help_info"; ?>
          </div>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
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
    
    
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
//-->
</script>
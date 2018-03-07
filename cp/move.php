<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: move.php
-----------------------------------------------------
 Назначение: Перемещение контрагентов
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$move_help;

$title_cp = $def_admin_move_button.' - ';
$speedbar = ' | <a href="move.php?REQ=auth">'.$def_admin_move_button.'</a>';

check_login_cp('2_4','move.php?REQ=auth');

require_once 'template/header.php';

table_item_top ($def_admin_move_button,'usersgroup.png');

if (

($_POST["GO"] == "$def_admin_move_submit") and

(($_POST[out] != "") and ($_POST[in] != "")) )

{
		$re=$db->query ("SELECT selector, category FROM $db_users where ( (category LIKE '$_POST[out]') or (category LIKE '%:$_POST[out]') or (category LIKE '$_POST[out]:%') or (category LIKE '%:$_POST[out]:%') )") or die (mysql_error());

		for ($a=0;$a<mysql_num_rows($re);$a++)
		{

			$fe=$db->fetcharray ($re);

			$cat=explode(":", $fe[category]);

			for ($i=0;$i<count($cat);$i++)
			{
				if ($cat[$i] == "$_POST[out]") {$cat[$i]="$_POST[in]";}
			}

                        $catarray = array_unique($cat);
			$newcat=implode(":", $catarray);

			$db->query ("UPDATE $db_users SET category = '$newcat' where selector=$fe[selector]");
		}

$db->query ("UPDATE $db_category SET fcounter=0");
$db->query ("UPDATE $db_category SET sccounter=0");
$db->query ("UPDATE $db_category SET ssccounter=0");
$db->query ("UPDATE $db_subcategory SET fcounter=0");
$db->query ("UPDATE $db_subcategory SET ssccounter=0");
$db->query ("UPDATE $db_subsubcategory SET fcounter=0");

$raz1=$db->query ("SELECT * FROM $db_category");

for ($xx=0;$xx<mysql_num_rows($raz1);$xx++)

{
	$faz1=$db->fetcharray ($raz1);

	$raz2=$db->query ("SELECT * FROM $db_subcategory where catsel=$faz1[selector]");

	$db->query ("UPDATE $db_category SET sccounter=".mysql_num_rows($raz2)." where selector=$faz1[selector]");

	$raz5=$db->query ("SELECT * FROM $db_subsubcategory where catsel=$faz1[selector]");
	$db->query ("UPDATE $db_category SET ssccounter=".mysql_num_rows($raz5)." where selector=$faz1[selector]");

	for ($xx1=0;$xx1<mysql_num_rows($raz2);$xx1++)

	{
		$faz2=$db->fetcharray ($raz2);
		$raz3=$db->query ("SELECT * FROM $db_subsubcategory where catsel=$faz1[selector] and catsubsel=$faz2[catsubsel]");

		$db->query ("UPDATE $db_subcategory SET ssccounter=".mysql_num_rows($raz3)." where catsel=$faz1[selector] and catsubsel=$faz2[catsubsel]");
	}
}

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$raz=$db->query ("SELECT * FROM $db_users where firmstate='on' $hide_d");

for($zz=0;$zz<mysql_num_rows($raz);$zz++)

{
	$f=$db->fetcharray ($raz);

	$category = explode (":", $f[category]);

	$prev_cat1="";
	$prev_subcat1="";

	for ($index1 = 0; $index1 < count ( $category ); $index1++)

	{
		$new_cat1 = explode ("#", $category[$index1]);

		if ($new_cat1[0] != $prev_cat1)
		{
			$db->query ("UPDATE $db_category SET fcounter = fcounter+1 where selector=$new_cat1[0]") or die (mysql_error());
		}
		if (($new_cat1[1] != "") and ($new_cat1[1] != "0") and ($new_cat1[1] != $prev_subcat1))
		{
			$db->query ("UPDATE $db_subcategory SET fcounter = fcounter+1 where catsel=$new_cat1[0] and catsubsel=$new_cat1[1]") or die (mysql_error());
		}
		if (($new_cat1[1] != "") and ($new_cat1[1] != "0") and ($new_cat1[2] != "") and ($new_cat1[2] != "0"))
		{
			$db->query ("UPDATE $db_subsubcategory SET fcounter = fcounter+1 where catsel=$new_cat1[0] and catsubsel=$new_cat1[1] and catsubsubsel=$new_cat1[2]") or die (mysql_error());
		}
		$prev_cat1=$new_cat1[0];
		$prev_subcat1=$new_cat1[1];
	}
}
                msg_text('80%',$def_admin_message_ok, 'Все компании были перемещены из '.$_POST[out].' в '.$_POST[in].'.');
}

if (($_GET["REQ"] == "auth") or ($_POST["GO"] == "Move"))

{

table_fdata_top ($def_item_form_data);

?>

 <form action="move.php?REQ=auth" method="POST">

  <table cellpadding="0" cellspacing="0" border="0" width="80%" align="center">
   <tr>
    <td width="100%" valign="top" align="left">
    <br>

     <table cellspacing="0" cellpadding="0" border="0" width="95%">
      <tr>
       <td width="45%" valign="top">

<b><? echo $def_admin_move_from; ?></b><br /><br />
<?
$r = $db->query  ( "SELECT * FROM $db_category ORDER BY category" );
$results_amount = mysql_num_rows ( $r );

for ( $i=0; $i < $results_amount; $i++ )

{
	$f = $db->fetcharray  ( $r );

	$ra = $db->query  ( "SELECT * FROM $db_subcategory WHERE catsel=$f[selector] ORDER BY subcategory" );
	$results_amount2 = mysql_num_rows ( $ra );

	if ( ($results_amount2 == 0) ) $results_amount2 = 1;

	for ( $j=0; $j < $results_amount2; $j++)

	{

		$fa = $db->fetcharray  ( $ra );
		$raa = $db->query  ( "SELECT * FROM $db_subsubcategory WHERE catsel=$f[selector] and catsubsel=$fa[catsubsel] ORDER BY subsubcategory" );
		@      $results_amount3 = mysql_num_rows ( $raa );

		if (($results_amount3 == 0) and ($results_amount2 == 0)) $results_amount3 = 1;
		if (($results_amount3 == 0) and ($results_amount2 != 0)) $results_amount3 = 1;

		for ( $k=0; $k < $results_amount3; $k++ )

		{
			@      $faa = $db->fetcharray  ( $raa );

			if ( ( !isset($fa[catsubsel]) ) and ( !isset($faa[catsubsubsel]) ) )

			echo '<input name="out" type="radio" VALUE="'.$f[selector].'#0#0" />'.$f[category].' <span style="color: #999999; font-size:9px;"> ('.$f[fcounter].')</span><br />';

			if ( ( isset($fa[catsubsel]) ) and ( !isset($faa[catsubsubsel]) ) )

			echo '<input name="out" type="radio" VALUE="'.$f[selector].'#'.$fa[catsubsel].'#0" />'.$f[category].' <span style="color: #999999; font-size:9px;">('.$f[fcounter].')</span> / '.$fa[subcategory].' <span style="color: #999999; font-size:9px;">('.$fa[fcounter].')</span><br />';

			if ( ( isset($fa[catsubsel]) ) and ( isset($faa[catsubsubsel]) ) )

			echo '<input name="out" type="radio" VALUE="'.$f[selector].'#'.$fa[catsubsel].'#'.$faa[catsubsubsel].'" />'.$f[category].' <span style="color: #999999; font-size:9px;">('.$f[fcounter].')</span> / '.$fa[subcategory].' <span style="color: #999999; font-size:9px;">('.$fa[fcounter].')</span> / '.$faa[subsubcategory].' <span style="color: #999999; font-size:9px;">('.$faa[fcounter].')</span><br />';
		}
	}
}

@  mysql_free_result ( $r );
@  mysql_free_result ( $ra );
@  mysql_free_result ( $raa );

?>
         </td>
         <td width="10%" valign="center" align="left">
=&gt;
         </td>
         <td width="45%" valign="top">

<b><? echo "$def_admin_move_to"; ?></b><br /><br />

<?

$r = $db->query  ( "SELECT * FROM $db_category ORDER BY category" );
$results_amount = mysql_num_rows ( $r );

for ( $i=0; $i < $results_amount; $i++ )

{
	$f = $db->fetcharray  ( $r );

	$ra = $db->query  ( "SELECT * FROM $db_subcategory WHERE catsel=$f[selector] ORDER BY subcategory" );
	$results_amount2 = mysql_num_rows ( $ra );

	if ( ($results_amount2 == 0) ) $results_amount2 = 1;

	for ( $j=0; $j < $results_amount2; $j++)

	{
		$fa = $db->fetcharray  ( $ra );
		$raa = $db->query  ( "SELECT * FROM $db_subsubcategory WHERE catsel=$f[selector] and catsubsel=$fa[catsubsel] ORDER BY subsubcategory" );
		@      $results_amount3 = mysql_num_rows ( $raa );

		if (($results_amount3 == 0) and ($results_amount2 == 0)) $results_amount3 = 1;
		if (($results_amount3 == 0) and ($results_amount2 != 0)) $results_amount3 = 1;

		for ( $k=0; $k < $results_amount3; $k++ )

		{
			@      $faa = $db->fetcharray  ( $raa );

			if ( ( !isset($fa[catsubsel]) ) and ( !isset($faa[catsubsubsel]) ) )

			echo '<input name="in" type="radio" VALUE="'.$f[selector].'#0#0" />'.$f[category].' <span style="color: #999999; font-size:9px;">('.$f[fcounter].')</span><br />';

			if ( ( isset($fa[catsubsel]) ) and ( !isset($faa[catsubsubsel]) ) )

			echo '<input name="in" type="radio" VALUE="'.$f[selector].'#'.$fa[catsubsel].'#0" />'.$f[category].' <span style="color: #999999; font-size:9px;">('.$f[fcounter].')</span> / '.$fa[subcategory].' <span style="color: #999999; font-size:9px;">('.$fa[fcounter].')</span><br>';

			if ( ( isset($fa[catsubsel]) ) and ( isset($faa[catsubsubsel]) ) )

			echo '<input name="in" type="radio" VALUE="'.$f[selector].'#'.$fa[catsubsel].'#'.$faa[catsubsubsel].'" />'.$f[category].' <span style="color: #999999; font-size:9px;">('.$f[fcounter].')</span> / '.$fa[subcategory].' <span style="color: #999999; font-size:9px;">('.$fa[fcounter].')</span> / '.$faa[subsubcategory].' <span style="color: #999999; font-size:9px;">('.$faa[fcounter].')</span><br>';
		}
	}
}

@  mysql_free_result ( $r );
@  mysql_free_result ( $ra );
@  mysql_free_result ( $raa );

?>
   </td>
    </tr></table>
   </td>
  </tr>
 </table>

<br /><br /><input type="submit" name="GO" value="<? echo $def_admin_move_submit; ?>" /><br /><br />

</form>

<?

}

table_fdata_bottom();

require_once 'template/footer.php';

?>
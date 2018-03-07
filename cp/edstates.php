<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: edstates.php
-----------------------------------------------------
 Назначение: Редактирование областей
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$states_help;

$title_cp = $def_admin_edlocation.' - ';
$speedbar = ' | <a href="edstates.php">'.$def_admin_edstate.'</a>';

check_login_cp('2_2','edstates.php');

if (isset($_POST['sort_state']))
{
	$_SESSION['sort_state'] = (string)$_POST['sort_state'];
}

if (empty($_SESSION['sort_state']))
{
	$_SESSION['sort_state'] = 'stateselector';
}

require_once 'template/header.php';

table_item_top ($def_admin_edstate,'tmpl.png');

?>

<form action="edstates.php" method="post">
 &nbsp;&nbsp;Сортировать по:
  <select name="sort_state" onchange="this.form.submit();">
    <option value="stateselector" <? if ($_SESSION['sort_state']=='stateselector') echo 'selected="selected"'; ?>>по id</option>
    <option value="state" <? if ($_SESSION['sort_state']=='state') echo 'selected="selected"'; ?>>по алфавиту</option>
  </select>
</form><br /><br />

<?

$cat_disp = safehtml ($_POST['disp']);

	if ((!empty($_POST["submit"])) and (empty($cat_disp))  and ($_POST[submit] != "$def_admin_delstate")) {echo "$def_empty";}

	else

	{
		if ($_POST["submit"] =="$def_admin_addstate"){

			$r=$db->query ("select MAX(stateselector) AS maxselector from $db_states") or die ("mySQL error!");

			$f=$db->fetcharray ($r);
			$newselector=$f["maxselector"]+1;
			mysql_free_result($r);

			$r=$db->query ("insert into $db_states (stateselector, state) values ('$newselector', '$cat_disp')") or die ("mySQL error!");

                        logsto("$def_admin_log_state_added $cat_disp");

		}


		elseif ($_POST["submit"] =="$def_admin_delstate"){

			$r=$db->query ("select * from $db_states where stateselector='$_POST[chosen]'") or die ("mySQL error!");
			$f=$db->fetcharray ($r);

			$db->query ("delete from $db_states where stateselector='$_POST[chosen]'") or die ("mySQL error!");

                        logsto("$def_admin_log_state_deleted  $f[state]");

		}


		elseif ($_POST["submit"] =="$def_admin_renstate"){

			$r=$db->query ("select * from $db_states where stateselector='$_POST[chosen]'") or die ("mySQL error33!");
			$f=$db->fetcharray ($r);

			$db->query ("UPDATE $db_states SET state='$cat_disp' where stateselector='$_POST[chosen]'") or die ("mySQL error334!");

                        logsto("$def_admin_log_state_renamed  $f[state] -> $cat_disp");
		}
	}

	table_fdata_top ($def_item_form_data);

	$r=$db->query ("select * from $db_states ORDER BY $_SESSION[sort_state]") or die ("mySQL error!");
	$results_amount=mysql_num_rows($r);

	echo '<table width="800" border="0" cellpadding="5" cellspacing="0">';
	echo '<form method="post" action="edstates.php">';

	for ($x=0;$x<$results_amount;$x++){
		$f=$db->fetcharray ($r);
		echo '<tr><td width="100%" align="left" valign="top"><input type="radio" name="chosen" value="'.$f[stateselector].' style="border:0;">'.$f[state].' (id '.$f[stateselector].')</td></tr>';
                echo "\n";
	}

	echo '<tr><td width="100%" align="left" valign="top"><br /><br />';
	echo '<input type="text" name="disp" />&nbsp;<input type="submit" name="submit" value="'.$def_admin_addstate.'" />&nbsp;<input type="submit" name="submit" value="'.$def_admin_renstate.'" />&nbsp;<input type="submit" name="submit" value="'.$def_admin_delstate.'" style="color: #FFFFFF; background: #D55454;" /></td></tr>';
	echo '</table></form><br /><br />';

	table_fdata_bottom();

require_once 'template/footer.php';

?>
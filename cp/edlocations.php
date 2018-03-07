<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: edlocations.php
-----------------------------------------------------
 Назначение: Редактирование стран/городов
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$locations_help;

$title_cp = $def_admin_edlocation.' - ';
$speedbar = ' | <a href="edlocations.php">'.$def_admin_edlocation.'</a>';

check_login_cp('2_1','edlocations.php');

if (isset($_POST['sort_loc']))
{
	$_SESSION['sort_loc'] = (string)$_POST['sort_loc'];
}

if (empty($_SESSION['sort_loc']))
{
	$_SESSION['sort_loc'] = 'location';
}

require_once 'template/header.php';

table_item_top ($def_admin_edlocation,'dbset.png');

?>

<form action="edlocations.php" method="post">
 &nbsp;&nbsp;Сортировать по:
  <select name="sort_loc" onchange="this.form.submit();">
    <option value="locationselector" <? if ($_SESSION['sort_loc']=='locationselector') echo 'selected="selected"'; ?>>по id</option>
    <option value="location" <? if ($_SESSION['sort_loc']=='location') echo 'selected="selected"'; ?>>по алфавиту</option>
  </select>
</form><br /><br />

<?

$cat_disp = safehtml ($_POST[disp]);

	if ((!empty($_POST["submit"])) and (empty($cat_disp)) and ($_POST[submit] != "$def_admin_dellocation")) {echo "$def_empty";}

	else

	{
		if ($_POST["submit"] =="$def_admin_addlocation"){

			$r=$db->query ("select MAX(locationselector) AS maxselector from $db_location") or die ("mySQL error!");

			$f=$db->fetcharray ($r);
			$newselector=$f["maxselector"]+1;
			mysql_free_result($r);

			$r=$db->query ("insert into $db_location (locationselector, location) values ('$newselector', '$cat_disp')") or die ("mySQL error!");

                        logsto("$def_admin_log_locationadded $cat_disp");
		}

		elseif ($_POST["submit"] =="$def_admin_dellocation"){

			$r=$db->query ("select * from $db_location where locationselector='$_POST[chosen]'") or die ("mySQL error!");
			$f=$db->fetcharray ($r);

			$db->query ("delete from $db_location where locationselector='$_POST[chosen]'") or die ("mySQL error!");

                        logsto("$def_admin_log_locationdeleted  $f[location]");
		}

		elseif ($_POST["submit"] =="$def_admin_renlocation"){

			$r=$db->query ("select * from $db_location where locationselector='$_POST[chosen]'") or die ("mySQL error324!");
			$f=$db->fetcharray ($r);

			$db->query ("UPDATE $db_location SET location='$cat_disp' where locationselector='$_POST[chosen]'") or die ("mySQL error222!");

                        logsto("$def_admin_log_locationrenamed  $f[location] -> $cat_disp");
		}
	}

	table_fdata_top ($def_item_form_data);

	$r=$db->query ("select * from $db_location ORDER BY $_SESSION[sort_loc]") or die ("mySQL error!");
	$results_amount=mysql_num_rows($r);

	echo '<table width="800" border="0" cellpadding="5" cellspacing="0">';
	echo '<form method="post" action="edlocations.php">';

	for ($x=0;$x<$results_amount;$x++){
		$f=$db->fetcharray ($r);
		echo '<tr><td width="100%" align="left" valign="top"><input type="radio" name="chosen" value="'.$f[locationselector].' style="border:0;" />'.$f[location].' (id '.$f[locationselector].')</td></tr>';
                echo "\n";
	}
        
        echo '<tr><td width="100%" align="left" valign="top"><br /><br />';
	echo '<input type="text" name="disp" />&nbsp;<input type="submit" name="submit" value="'.$def_admin_addlocation.'" />&nbsp;<input type="submit" name="submit" value="'.$def_admin_renlocation.'" />&nbsp;<input type="submit" name="submit" value="'.$def_admin_dellocation.'" style="color: #FFFFFF; background: #D55454;"></td></tr>';
        echo '</table></form><br /><br />';

	table_fdata_bottom();

require_once 'template/footer.php';

?>
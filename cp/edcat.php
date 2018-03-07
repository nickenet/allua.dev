<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: edcat.php
-----------------------------------------------------
 Назначение: Редактирование категорий
=====================================================
*/

session_start();

if (isset($_POST['editor_uses']))
{
        setcookie('editor_uses', '',time()+(60*60*24*30),'/');
        setcookie('editor_uses', $_POST['editor_uses'],time()+(60*60*24*30),'/');
        $_COOKIE['editor_uses'] = $_POST['editor_uses'];
	  
}

if (empty($_COOKIE['editor_uses']))
{
        setcookie('editor_uses', '',time()+(60*60*24*30),'/');
	setcookie('editor_uses', 'nicEdit',time()+(60*60*24*30),'/');
        $_COOKIE['editor_uses'] = 'nicEdit';
        
}

require_once './defaults.php';

check_login_cp('2_3','edcat.php');

if (isset($_POST['sort_cat']))
{
	$_SESSION['sort_cat'] = (string)$_POST['sort_cat'];
}

if (empty($_SESSION['sort_cat']))
{
	$_SESSION['sort_cat'] = 'selector';
}

if (isset($_POST['sort_subcat']))
{
	$_SESSION['sort_subcat'] = (string)$_POST['sort_subcat'];
}

if (empty($_SESSION['sort_subcat']))
{
	$_SESSION['sort_subcat'] = 'catsubsel';
}

if (isset($_POST['sort_subsubcat']))
{
	$_SESSION['sort_subsubcat'] = (string)$_POST['sort_subsubcat'];
}

if (empty($_SESSION['sort_subsubcat']))
{
	$_SESSION['sort_subsubcat'] = 'catsubsubsel';
}

if (empty ($_GET['edcat'])) {

$help_section = (string)$cat_help;

$title_cp = $def_admin_edcat.' - ';
$speedbar = ' | <a href="edcat.php">'.$def_admin_edcat.'</a>';

require_once 'template/header.php';

table_item_top ($def_admin_edcat,'tmpl.png');

?>

<form action="edcat.php" method="post">
 &nbsp;&nbsp;Сортировать<br />&nbsp;&nbsp;Категории по:
  <select name="sort_cat" onchange="this.form.submit();">
    <option value="selector" <? if ($_SESSION['sort_cat']=='selector') echo 'selected="selected"'; ?>>по id</option>
    <option value="category" <? if ($_SESSION['sort_cat']=='category') echo 'selected="selected"'; ?>>по алфавиту</option>
  </select>
&nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle">&nbsp;Подкатегории по:
  <select name="sort_subcat" onchange="this.form.submit();">
    <option value="catsubsel" <? if ($_SESSION['sort_subcat']=='catsubsel') echo 'selected="selected"'; ?>>по id</option>
    <option value="subcategory" <? if ($_SESSION['sort_subcat']=='subcategory') echo 'selected="selected"'; ?>>по алфавиту</option>
  </select>
&nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle">&nbsp;Разделы подкатегорий по:
  <select name="sort_subsubcat" onchange="this.form.submit();">
    <option value="catsubsubsel" <? if ($_SESSION['sort_subsubcat']=='catsubsubsel') echo 'selected="selected"'; ?>>по id</option>
    <option value="subsubcategory" <? if ($_SESSION['sort_subsubcat']=='subsubcategory') echo 'selected="selected"'; ?>>по алфавиту</option>
  </select>
<br /><br />
</form>
     
<?

$allowcats="YES";

$cat_disp = safehtml ($_POST[disp]);

	if (($_POST["submit"] != "$def_admin_delcat") and (!empty($_POST["submit"])) and (empty($cat_disp))) { msg_text('80%',$def_admin_message_error,$def_empty); }

	else

	{
		if ($_POST["submit"] =="$def_admin_addcat")
		{
			$r=$db->query ("select MAX(selector) AS maxselector from $db_category") or die ("mySQL error!");

			$f=$db->fetcharray ($r);
			$newselector=$f["maxselector"]+1;
			mysql_free_result($r);

			$r=$db->query ("insert into $db_category (selector, category) values ('$newselector', '$cat_disp')") or die ("mySQL error!");

                        logsto("$def_admin_log_newcatadded $cat_disp");
		}

		elseif ($_POST["submit"] == "$def_admin_addsubcat")

		{
			$r=$db->query ("select MAX(catsubsel) AS maxsubsel from $db_subcategory") or die ("mySQL error!");

			$oldcat = explode("::", $_POST["chosen"]);
			$f=$db->fetcharray ($r);
			$newsubselector=$f["maxsubsel"]+1;
			mysql_free_result($r);

			if ($oldcat[0]!='') {

			$r=$db->query ("select * from $db_category where selector=$oldcat[0]") or die ("mySQL error!");
			$f=$db->fetcharray ($r);
			mysql_free_result($r);

			}

			if (

			($f[fcounter] == 0) or

			(($f[fcounter] != 0) and ($allowcats == "YES")) or

			(($f[fcounter] != 0) and ($f[sccounter] != 0) and ($f[ssccounter] == 0))

			)

			{
				if (($oldcat[0] != "") and ($oldcat[0] != "0"))

				{
					$r=$db->query ("insert into $db_subcategory (catsel, catsubsel, subcategory) values ('$oldcat[0]', '$newsubselector', '$cat_disp')") or die ("mySQL error!");

					$db->query  ( " UPDATE $db_category SET sccounter = sccounter+1 where selector = '$oldcat[0]' " ) or die ( mysql_error() );

                                        logsto("$def_admin_log_newsubcatadded $cat_disp");
				}

				else msg_text('80%',$def_admin_message_error,$def_error_addcat1);

			}

			else msg_text('80%',$def_admin_message_error,$def_error_addcat4);

		}

		elseif ($_POST["submit"] == "$def_admin_addsubsubcat")

		{
			$oldcat = explode("::", $_POST["chosen"]);

			$r=$db->query ("select * from $db_subcategory where catsel='$oldcat[0]' and catsubsel='$oldcat[1]'") or die ("mySQL error!");
			$f=$db->fetcharray ($r);
			mysql_free_result($r);

			if (

			($f[fcounter] == 0) or

			(($f[fcounter] != 0) and ($allowcats == "YES")) or

			(($f[fcounter] != 0) and ($f[ssccounter] != 0 ))

			)

			{
				if (($oldcat[1] != "") and ($oldcat[1] != "0") and ($oldcat[0] != "") and ($oldcat[0] != "0"))

				{
					$r=$db->query ("select MAX(catsubsubsel) AS maxsubsubsel from $db_subsubcategory") or die ("mySQL error!");
					$f=$db->fetcharray ($r);
					$newsubselector=$f["maxsubsubsel"]+1;

					$r=$db->query ("insert into $db_subsubcategory (catsel, catsubsel, catsubsubsel, subsubcategory) values ('$oldcat[0]', '$oldcat[1]', '$newsubselector', '$cat_disp')") or die ("mySQL error!");

					$db->query  ( " UPDATE $db_category SET ssccounter = ssccounter+1 where selector = '$oldcat[0]' " ) or die ( mysql_error() );
					$db->query  ( " UPDATE $db_subcategory SET ssccounter = ssccounter+1 where catsel = '$oldcat[0]' AND catsubsel = '$oldcat[1]'" ) or die ( mysql_error() );

                                        logsto("$def_admin_log_newsubsubcatadded $cat_disp");
				}
				else msg_text('80%',$def_admin_message_error,$def_error_addcat2);
			}
			else msg_text('80%',$def_admin_message_error,$def_error_addcat5);
		}

		elseif ($_POST["submit"] == "$def_admin_catren")

		{
			$cat = explode("::", $_POST["chosen"]);
			$cat0=$cat[0];
			$cat1=$cat[1];
			$cat2=$cat[2];

			if ($cat1 == "")

			{
				$r=$db->query ("SELECT * from $db_category where selector='$cat0'") or die ("mySQL error!");
				$f=$db->fetcharray ($r);

				$db->query ("UPDATE $db_category SET category='$cat_disp' where selector='$cat0'") or die ("mySQL error!");

                                logsto("$def_admin_log_catrenamed  $f[category] -> $cat_disp");
			}

			if (($cat1 != "") and ($cat2 == ""))

			{
				$r=$db->query ("SELECT * from $db_subcategory where catsel='$cat0' and catsubsel='$cat1'") or die ("mySQL error!");
				$f=$db->fetcharray ($r);

				$db->query ("UPDATE $db_subcategory SET subcategory='$cat_disp' where catsel='$cat0' and catsubsel='$cat1'") or die ("mySQL error!");

                                logsto("$def_admin_log_subcatrenamed  $f[subcategory] -> $cat_disp");

			}

			if (($cat1 != "") and ($cat2 != ""))

			{
				$r=$db->query ("SELECT * from $db_subsubcategory where catsel='$cat0' and catsubsel='$cat1' and catsubsubsel='$cat2'") or die ("mySQL error!");
				$f=$db->fetcharray ($r);

				$db->query ("UPDATE $db_subsubcategory SET subsubcategory='$cat_disp' where catsel='$cat0' and catsubsel='$cat1' and catsubsubsel='$cat2'") or die ("mySQL error!");

                                logsto("$def_admin_log_subsubcatrenamed  $f[subsubcategory] -> $cat_disp");
			}
		}

		elseif (($_POST["submit"] == "$def_admin_delcat") or (isset($_GET['delcat'])))

		{
			
                        if (isset($_POST["chosen"])) {
                            $cat = explode("::", $_POST["chosen"]);
                            $cat0=$cat[0];
                            $cat1=$cat[1];
                            $cat2=$cat[2];
                        }
                        
                        else {
                             
                                $id_delcategory=intval($_GET['delcat']);
                                $id_delsubcat=intval($_GET['delsubcat']);
                                $id_delsubsubcat=intval($_GET['delsubsubcat']);
    
                                if ($id_delsubsubcat!=0) {
                                    $cat0= $id_delcategory;
                                    $cat1=$id_delsubcat;
                                    $cat2=$id_delsubsubcat;
                                        $file_img = glob("../images/subsubcat/$id_delsubsubcat.*");
                                        @unlink($file_img[0]);
                                } elseif ($id_subcat!=0) {
                                    $cat0= $id_delcategory;
                                    $cat1=$id_delsubcat;
                                    $cat2="";
                                        $file_img = glob("../images/subcat/$id_delsubcat.*");
                                        @unlink($file_img[0]);
                                } else { 
                                    $cat0= $id_delcategory;
                                    $cat1="";
                                    $cat2="";
                                        $file_img = glob("../images/category/$id_delcategory.*");
                                        @unlink($file_img[0]);
                                }                            
                        }

			if ($cat1 == "")

			{
				$r=$db->query ("SELECT * from $db_category where selector='$cat0'") or die ("mySQL error!");
				$f=$db->fetcharray ($r);

				$exists=mysql_num_rows($r);
				mysql_free_result($r);

				if (($f[fcounter] == 0) and ( $f[sccounter] == 0) and ($f[ssccounter] == 0) and ($exists != 0))
				{

					$r=$db->query ("SELECT * from $db_category where selector='$cat0'") or die ("mySQL error!");
					$f=$db->fetcharray ($r);

					$db->query ("delete from $db_category where selector='$cat0'") or die ("mySQL error!");

					$db->query ("delete from $db_subcategory where catsel='$cat0'") or die ("mySQL error!");

					$db->query ("delete from $db_subsubcategory where catsel='$cat0'") or die ("mySQL error!");

                                        logsto("$def_admin_log_catdeleted  $f[category]");

				}

				else msg_text('80%',$def_admin_message_error,$def_admin_edcat10);
			}

			if (($cat1 != "") and ($cat2 == ""))
			{
				$r=$db->query ("SELECT * from $db_subcategory where catsel='$cat0' and catsubsel='$cat1'") or die ("mySQL error!");
				$f=$db->fetcharray ($r);

				$exists=mysql_num_rows($r);

				mysql_free_result($r);

				if (($f[fcounter] == 0) and ($f[ssccounter] == 0) and ($exists != 0))
				{
					$r=$db->query ("SELECT * from $db_subcategory where catsel='$cat0' and catsubsel='$cat1'") or die ("mySQL error!");
					$f=$db->fetcharray ($r);

					$db->query ("delete from $db_subcategory where catsel='$cat0' and catsubsel='$cat1'") or die ("mySQL error!");

					$db->query ("delete from $db_subsubcategory where catsel='$cat0' and catsubsel='$cat1'") or die ("mySQL error!");

					$db->query  ( " UPDATE $db_category SET sccounter = sccounter-1 where selector = '$cat[0]' " ) or die ( mysql_error() );

                                        logsto("$def_admin_log_subcatdeleted  $f[subcategory]");
				}
				else msg_text('80%',$def_admin_message_error,$def_admin_edcat11);
			}

			if (($cat1 != "") and ($cat2 != ""))
			{
				$r=$db->query ("SELECT * from $db_subsubcategory where catsel='$cat0' and catsubsel='$cat1' and catsubsubsel='$cat2'") or die ("mySQL error!");
				$f=$db->fetcharray ($r);

				$exists=mysql_num_rows($r);

				mysql_free_result($r);

				if (($f[fcounter] == 0) and ($exists != 0))
				{
					$r=$db->query ("SELECT * from $db_subsubcategory where catsel='$cat0' and catsubsel='$cat1' and catsubsubsel='$cat2'") or die ("mySQL error!");
					$f=$db->fetcharray ($r);

					$db->query ("delete from $db_subsubcategory where catsel='$cat0' and catsubsel='$cat1' and catsubsubsel='$cat2'") or die ("mySQL error!");

					$db->query  ( " UPDATE $db_category SET ssccounter = ssccounter-1 where selector = '$cat[0]' " ) or die ( mysql_error() );
					$db->query  ( " UPDATE $db_subcategory SET ssccounter = ssccounter-1 where catsel = '$cat[0]' AND catsubsel = '$cat[1]'" ) or die ( mysql_error() );

                                        logsto("$def_admin_log_subsubcatdeleted  $f[subsubcategory]");
				}
				else msg_text('80%',$def_admin_message_error,$def_admin_edcat12);
			}
		}
	}


	$r=$db->query ("select * from $db_category  ORDER BY $_SESSION[sort_cat]") or die ("mySQL error!");
	$results_amount=mysql_num_rows($r);
        
        ?>

<style type="text/css">
    .main_list {
	border: 1px solid #A6B2D5;
	border-collapse: collapse;
	margin-top: 20px;
	}
    .main_list td {
        padding: 5px;
        text-align: center;
	border: 1px solid #A6B2D5;
	}
    .main_list th {
        background-image: url(images/table_files_bg.gif);
	height: 25px;
	padding-top: 2px;
	padding-left: 5px;
	text-align: center;
	border: 1px solid #A6B2D5;
        }
    hr {
	border: 1px dotted #CCCCCC;
        }
</style>

<form action="" method="post" name="edcat.php">
<table width="1000" class="main_list" align="center">
  <tr>
    <th width="100">ID</th>
    <th width="60">Редактировать</th> 
    <th>Название</th>
    <th width="70">Компаний</th>
    <th width="100">Изображение</th>
    <th width="60">Удалить</th>
  </tr>

        <?

	for ($x=0;$x<$results_amount;$x++){
		$f=$db->fetcharray ($r);

                if ($f[img]!='') $img_ok='<img src="../images/category/'.$f['selector'].'.'.$f['img'].'" width="24" height="24" align="absmiddle" border="0" alt="Иконка" title="Иконка" hspace="2" vspace="2" />'; else $img_ok='';

		// echo '<tr><td width="100%" align="left" valign="top"><input type="radio" name="chosen" value="'.$f[selector].'" style="border:0;" /><b style="color: #0000FF">'.$f[category].'</b> <a href="?edcat='.$f[selector].'" title="Редактировать"><img src="images/edit_cat.png" width="24" height="24" align="absmiddle" border="0" alt="Редактировать" title="Редактировать" hspace="2" vspace="2" /></a>'.$img_ok.'<span style="color: #999999; font-size:9px;">(id '.$f[selector].', subs: '.$f[sccounter].'/ subsubs: '.$f[ssccounter].'/ listings: <b>'.$f[fcounter].'</b>)</span><br /></td></tr>';
                // echo "\n";
                
                ?>
  
<tr class="selecttr">
    <td<? echo $class_yt; ?>><div class="slink"><a href="<? echo $def_mainlocation; ?>/index.php?category=<? echo $f['selector']; ?>" target="_blank"><? echo $f['selector']; ?></a></div></td>
    <td<? echo $class_yt; ?>><a href="?edcat=<? echo $f['selector']; ?>" title="Редактировать"><img src="images/edit_cat.png" width="24" height="24" align="absmiddle" border="0" alt="Редактировать" title="Редактировать" hspace="2" vspace="2" /></a></td>
    <td<? echo $class_yt; ?>><div align="left"><input type="radio" name="chosen" value="<? echo $f['selector']; ?>" style="border:0;" /><b style="color: #0000FF;"><? echo $f['category']; ?></b></div></td>
    <td<? echo $class_yt; ?>><? echo $f['fcounter']; ?></td>
    <td<? echo $class_yt; ?>><? echo $img_ok; ?></td>
    <td<? echo $class_yt; ?>><? if ($f['fcounter']==0)  { ?><a href="?delcat=<? echo $f['selector']; ?>" title="Удалить"><img src="images/delete.png" width="24" height="24" align="absmiddle" border="0" alt="Удалить" title="Удалить" hspace="2" vspace="2" /></a><? } ?></td>
</tr>
  
                <?

		$re=$db->query ("select * from $db_subcategory where catsel=$f[selector] ORDER BY $_SESSION[sort_subcat]") or die ("mySQL error!");
		$results_amount2=mysql_num_rows($re);
                
                if ($results_amount2>0) {

		for ($x1=0;$x1<$results_amount2;$x1++){

			$fe=$db->fetcharray ($re);
                        
                        if ($fe[img]!='') $img_ok='<img src="../images/subcat/'.$fe['catsubsel'].'.'.$fe['img'].'" width="24" height="24" align="absmiddle" border="0" alt="Иконка" title="Иконка" hspace="2" vspace="2" />'; else $img_ok='';

                        ?>

<tr class="selecttr">
    <td<? echo $class_yt; ?>><div class="slink"><img src="images/tree.gif" width="31" height="17" align="absmiddle" /><a href="<? echo $def_mainlocation; ?>/index.php?cat=<? echo $f['selector']; ?>&subcat=<? echo $fe['catsubsel']; ?>" target="_blank"><? echo $fe['catsubsel']; ?></a></div></td>
    <td<? echo $class_yt; ?>><a href="?edcat=<? echo $f['selector']; ?>&edsubcat=<? echo $fe['catsubsel']; ?>" title="Редактировать"><img src="images/edit_cat.png" width="24" height="24" align="absmiddle" border="0" alt="Редактировать" title="Редактировать" hspace="2" vspace="2" /></a></td>    
    <td<? echo $class_yt; ?>><div align="left" style="padding-left: 5px;"><img src="images/tree.gif" width="31" height="17" align="absmiddle" /><input type="radio" name="chosen" value="<? echo $f['selector']; ?>::<? echo $fe['catsubsel']; ?>" style="border:0;" /><b style="color: #006600"><? echo $fe['subcategory']; ?></b></div></td>
    <td<? echo $class_yt; ?>><? echo $fe['fcounter']; ?></td>
    <td<? echo $class_yt; ?>><? echo $img_ok; ?></td>
    <td<? echo $class_yt; ?>><? if ($fe['fcounter']==0)  { ?><a href="?delcat=<? echo $f['selector']; ?>&delsubcat=<? echo $fe['catsubsel']; ?>" title="Удалить"><img src="images/delete.png" width="24" height="24" align="absmiddle" border="0" alt="Удалить" title="Удалить" hspace="2" vspace="2" /></a><? } ?></td>
</tr>                        
                        <?
			
                        $ree=$db->query ("select * from $db_subsubcategory where catsubsel=$fe[catsubsel] and catsel=$f[selector] ORDER BY $_SESSION[sort_subsubcat]") or die ("mySQL error!");
			$results_amount3=mysql_num_rows($ree);
                        
                        if ($results_amount3>0) {

			for ($y1=0;$y1<$results_amount3;$y1++){

				$fee=$db->fetcharray ($ree);
                                if ($fee[img]!='') $img_ok='<img src="../images/subsubcat/'.$fee['catsubsubsel'].'.'.$fee['img'].'" width="24" height="24" align="absmiddle" border="0" alt="Иконка" title="Иконка" hspace="2" vspace="2" />'; else $img_ok='';
                              
                                ?>
                                
<tr class="selecttr">
    <td<? echo $class_yt; ?>><div style="padding-left: 10px;" class="slink"><img src="images/tree.gif" width="31" height="17" align="absmiddle" /><a href="<? echo $def_mainlocation; ?>/index.php?cat=<? echo $f['selector']; ?>&subcat=<? echo $fe['catsubsel']; ?>&subsubcat=<? echo $fee['catsubsubsel']; ?>" target="_blank"><? echo $fee['catsubsubsel']; ?></a></div></td>
    <td<? echo $class_yt; ?>><a href="?edcat=<? echo $f['selector']; ?>&edsubcat=<? echo $fe['catsubsel']; ?>&edsubsubcat=<? echo $fee['catsubsubsel']; ?>" title="Редактировать"><img src="images/edit_cat.png" width="24" height="24" align="absmiddle" border="0" alt="Редактировать" title="Редактировать" hspace="2" vspace="2" /></a></td>    
    <td<? echo $class_yt; ?>><div align="left" style="padding-left: 15px;"><img src="images/tree.gif" width="31" height="17" align="absmiddle" /><input type="radio" name="chosen" value="<? echo $f['selector']; ?>::<? echo $fe['catsubsel']; ?>::<? echo $fee['catsubsubsel']; ?>"  style="border:0;" /><? echo $fee['subsubcategory']; ?></div></td>
    <td<? echo $class_yt; ?>><? echo $fee['fcounter']; ?></td>
    <td<? echo $class_yt; ?>><? echo $img_ok; ?></td>
    <td<? echo $class_yt; ?>><? if ($fee['fcounter']==0)  { ?><a href="?delcat=<? echo $f['selector']; ?>&delsubcat=<? echo $fe['catsubsel']; ?>&delsubsubcat=<? echo $fee['catsubsubsel']; ?>" title="Удалить"><img src="images/delete.png" width="24" height="24" align="absmiddle" border="0" alt="Удалить" title="Удалить" hspace="2" vspace="2" /></a><? } ?></td>
</tr>                                 
                                <?
                        } }                        
                } }
	}
?>
</table>
    <div align="center">
    <br /><br /><input type="text" size="50" name="disp" />
    <br /><br /><input type="submit" name="submit" value="<? echo $def_admin_addcat; ?>" />&nbsp;&nbsp;<input type="submit" name="submit" value="<? echo $def_admin_addsubcat; ?>" />&nbsp;&nbsp;<input type="submit" name="submit" value="<? echo $def_admin_addsubsubcat; ?>" /><br /><br/><input type="submit" name="submit" value="<? echo $def_admin_catren; ?>" />&nbsp;&nbsp;<input type="submit" name="submit" value="<? echo $def_admin_delcat; ?>" style="color: #FFFFFF; background: #D55454;" />
    </div>
</form>

<?
}

 else {

if (isset ($_POST['id_cat'])) {

    $title=safeHTML($_POST['title']);
    $description=safeHTML($_POST['description']);
    $keywords=safeHTML($_POST['keywords']);
    $recomend=safeHTML($_POST['recomend']);
    $id_cat_post=intval($_POST['id_cat']);
    $description_full=addslashes($_POST['description_full']);
    $imgExt = array('gif', 'png', 'bmp', 'jpg', 'jpeg', 'tif', 'tiff');
    $images_r='';
    
    $post_cat=safeHTML($_POST['post_cat']);
    
    if ($post_cat=='subsubcat') {
        
        $dir_img='subsubcat';
        $db_tablecat=$db_subsubcategory;
        $id_razdel="catsubsubsel='$id_cat_post'";
        
    }
    
    if ($post_cat=='subcat') {
        
        $dir_img='subcat';
        $db_tablecat=$db_subcategory;
        $id_razdel="catsubsel='$id_cat_post'";
        
    }
    
    if ($post_cat=='cat') {
        
        $dir_img='category';
        $db_tablecat=$db_category;
        $id_razdel="selector='$id_cat_post'";
        
    }     

    if ( isset($_FILES[key]) && is_uploaded_file($_FILES[key]['tmp_name']) )
		{
			$name	= strtolower($_FILES[key]['name']);
			$ext	= pathinfo($name, PATHINFO_EXTENSION);
			if (!in_array($ext, $imgExt))
			{
				msg_text('80%',$def_admin_message_error,'Загружайте разрешённые картинки.');
			}

                        else {

			$name	= '../images/'.$dir_img.'/'.$id_cat_post.'.' . $ext;
                        $name_old="../images/'.$dir_img.'/$id_cat_post.$_POST[type_img]";

                        @unlink($name);
                        @unlink($name_old);

			if ( move_uploaded_file($_FILES[key]['tmp_name'], $name) )
			{
				$images_r = $ext;
			}
			else
                            {
                                	msg_text('80%',$def_admin_message_error,'Ошибка загрузки файла.');
                            }
                        }
		}
                
    if ($images_r!='') $db->query  ( " UPDATE $db_tablecat SET title='$title', description = '$description', keywords='$keywords', description_full='$description_full', recomend='$recomend', img='$images_r' where $id_razdel " ) or die ( mysql_error() );
    else $db->query  ( " UPDATE $db_tablecat SET title='$title', description = '$description', keywords='$keywords', description_full='$description_full', recomend='$recomend' where $id_razdel " ) or die ( mysql_error() );

    logsto("Выполнено редактирование категории <b>id=$id_cat_post</b>");
    
    $mess_ok_cat='ok';

}

if ($_POST['do_delete'] == "Удалить иконку") {
    
    $post_cat=safeHTML($_POST['post_cat']);
    
    if ($post_cat=='subsubcat') {
        
        $dir_img='subsubcat';
        $db_tablecat=$db_subsubcategory;
        $id_razdel="catsubsubsel='$id_cat_post'";
        
    }
    
    if ($post_cat=='subcat') {
        
        $dir_img='subcat';
        $db_tablecat=$db_subcategory;
        $id_razdel="catsubsel='$id_cat_post'";
        
    }
    
    if ($post_cat=='cat') {
        
        $dir_img='category';
        $db_tablecat=$db_category;
        $id_razdel="selector='$id_cat_post'";
        
    }     

    $id_cat_post=intval($_POST['id_cat']);
    $name="../images/$dir_img/$id_cat_post.$_POST[type_img]";
    @unlink($name);
    $db->query  ( " UPDATE $db_tablecat SET img='' where $id_razdel " ) or die ( mysql_error() );
    logsto("Удалена иконка к категории <b>id=$id_cat_post</b>");

}

    $help_section = (string)$cat2_help;

    $id_category=intval($_GET['edcat']);
    $id_subcat=intval($_GET['edsubcat']);
    $id_subsubcat=intval($_GET['edsubsubcat']);
    
    if ($id_subsubcat!=0) {
        $db_tablecat=$db_subsubcategory;
        $id_razdel="catsubsubsel='$id_subsubcat'";
        $id_cat=$id_subsubcat;
        $dir_img='subsubcat';
        $edit_link='edcat.php?edcat='.$id_category.'&edsubcat='.$id_subcat.'&edsubsubcat='.$id_subsubcat;
        $name_cat_title='раздел подкатегории';
        $name_cat_title_form='раздела подкатегории';
    } elseif ($id_subcat!=0) {
        $db_tablecat=$db_subcategory;
        $id_razdel="catsubsel='$id_subcat'";
        $id_cat=$id_subcat;
        $dir_img='subcat';
        $edit_link='edcat.php?edcat='.$id_category.'&edsubcat='.$id_subcat;
        $name_cat_title='подкатегорию';
        $name_cat_title_form='подкатегории';
        
    } else { 
        $db_tablecat=$db_category;
        $id_razdel="selector='$id_category'";
        $id_cat=$id_category;
        $dir_img='category';
        $edit_link='edcat.php?edcat='.$id_category;
        $name_cat_title='категорию';
        $name_cat_title_form='категории';
    }

    $r_cat=$db->query ("select * from $db_tablecat where $id_razdel LIMIT 1") or die ("mySQL error!");
    $results_amount=mysql_num_rows($r_cat);
    $f_cat=$db->fetcharray ($r_cat);
    
    if ($id_subsubcat!=0) { $f_cat['category']=$f_cat['subsubcategory'];  $post_cat='subsubcat'; } elseif ($id_subcat!=0) { $f_cat['category']=$f_cat['subcategory']; $post_cat='subcat'; } else { $post_cat='cat'; }

    $title_cp = 'Редактировать '.$name_cat_title.' - ';
    $speedbar = ' | <a href="edcat.php">'.$def_admin_edcat.'</a> | <a href="'.$edit_link.'">Редактировать '.$name_cat_title.' - '.$f_cat['category'].'</a>';

    require_once 'template/header.php';
    
    table_item_top ('Редактировать '.$name_cat_title.' - '.$f_cat['category'],'tmpl.png');
    
?>

<form action="" method="post">
 &nbsp;&nbsp;Использовать WYSIWYG редактор:
  <select name="editor_uses" onchange="this.form.submit();">
    <option value="nicEdit" <? if ($_COOKIE['editor_uses']=='nicEdit') echo 'selected="selected"'; ?>>nicEdit</option>
    <option value="TinyMCE" <? if ($_COOKIE['editor_uses']=='TinyMCE') echo 'selected="selected"'; ?>>TinyMCE</option>
    <option value="noedit" <? if ($_COOKIE['editor_uses']=='noedit') echo 'selected="selected"'; ?>>Без редактора</option>
  </select>
<br /><br />
</form>

<?    

    if ($mess_ok_cat=='ok') msg_text('80%',$def_admin_message_ok, "Выполнено редактирование раздела <b>id=$id_cat_post</b>");
    
    table_fdata_top ($def_item_form_data);

    if ($results_amount==0) msg_text('80%',$def_admin_message_error,'Категория с данным id не найдена.');

    else {

if ($_COOKIE['editor_uses'] == 'nicEdit') { ?>
<script src="../includes/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
        new nicEditor().panelInstance('area_full');
});
</script>
<? } 

if ($_COOKIE['editor_uses'] == 'TinyMCE') include ('../includes/editor/tiny.php');

?>

 <form action="" method="post" enctype="multipart/form-data">
 <table width="900" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="right">Название <? echo $name_cat_title_form; ?>:</td>
    <td align="left"><b><? echo $f_cat['category']; ?></b> (id=<? echo $id_cat; ?>)</td>
  </tr>
  <tr>
    <td align="right">Заголовок категории (мета-тег Title):</td>
    <td align="left"><input type="text" name="title" value="<? echo $f_cat['title']; ?>" style="width: 350px;" /></td>
  </tr>  
  <tr>
    <td align="right">Описание категории (мета-тег Description):</td>
    <td align="left"><input type="text" name="description" value="<? echo $f_cat['description']; ?>" style="width: 350px;" /></td>
  </tr>
  <tr>
    <td align="right">Ключевые слова (мета-тег Keywords):</td>
    <td align="left"><textarea name="keywords" cols="45" rows="5"><? echo $f_cat['keywords']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Описание категории:</td>
    <td align="left"><textarea name="description_full" cols="40" rows="5" id="area_full" style="width: 400px; height: 300px;"><? echo stripcslashes($f_cat['description_full']); ?></textarea></td>
  </tr>
  
<? if ($id_subsubcat==0) { ?>
  
  <tr>
    <td align="right">Рекомендуемые компании:</td>
    <td align="left"><input type="text" name="recomend" value="<? echo $f_cat['recomend']; ?>" style="width: 350px;" /></td>
  </tr>
  
<? } ?>
  
  <tr>
    <td align="right">Иконка:</td>
    <td align="left"><input type="file" name="key" />
<?
    if ($f_cat['img']!='') $name_img="../images/$dir_img/$id_cat.$f_cat[img]";
    if (file_exists($name_img)) {

        echo '<br /><img src="'.$name_img.'" border="0" /><br />';

        $size	= getimagesize($name_img);
	$size	= $size[0] . ' x ' . $size[1] . ' px';
	$fSize	= filesize($name_img);
	$fSize	= round(($fSize / 1024),2) . ' KB';

        echo 'Формат: '.$f_cat['img'].'<br />';
        echo 'Размер: '.$size.'<br />';
	echo 'Вес: '.$fSize;

    }
?>
    </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left"><input type="submit" name="save" value="Сохранить" />
    <input type="submit" name="do_delete" value="Удалить иконку" />
    <input type="hidden" name="id_cat" value="<? echo $id_cat; ?>" />
    <input type="hidden" name="type_img" value="<? echo $f_cat['img']; ?>" />
    <input type="hidden" name="post_cat" value="<? echo $post_cat; ?>" />
    </td>
  </tr>
</table>
</form>
  
<?

    }

    table_fdata_bottom();

}

require_once 'template/footer.php';

?>
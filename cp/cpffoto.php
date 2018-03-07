<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by construktor7 (D. Zaharov) & D.Madi
=====================================================
 Файл: cpfoto.php
-----------------------------------------------------
 Назначение: Управление фотогалереей
=====================================================
*/

session_start();

require_once './defaults.php';


if($_POST['filterScat'] == "Все альбомы")
{
	unset($_SESSION['filtercatA']);
	unset($_SESSION['filtersscatA']);
	unset($_SESSION['filtercatlikeA']);
	unset($_SESSION['filterscatA']);
}
elseif($_POST['formfiltersscat'] && $_POST['formfiltersscat'] != "Все альбомы")
{
	
	list($_SESSION['filtercatA'], $_SESSION['filterscatA'], $_SESSION['filtersscatA']) = explode("#",preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",trim($_POST['formfiltersscat'])));
	$_SESSION['filtercatlikeA'] = " and (category IS NOT NULL and category != '') and  category like '".$_SESSION['filtercatA']."#".$_SESSION['filterscatA']."#".$_SESSION['filtersscatA']."'";
}
elseif($_POST['formfilterscat'] && $_POST['formfilterscat'] != "Все альбомы")
{
	unset($_SESSION['filtersscatA']);
	list($_SESSION['filtercatA'], $_SESSION['filterscatA']) = explode("#",preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",trim($_POST['formfilterscat'])));
	$_SESSION['filtercatlikeA'] = " and (category IS NOT NULL and category != '') and (category like '".$_SESSION['filtercatA']."#".$_SESSION['filterscatA']."' or category like '".$_SESSION['filtercatA']."#".$_SESSION['filterscatA']."#%')";
}
elseif($_POST['filterScat']) 
{
	
	unset($_SESSION['filtersscatA']);
	unset($_SESSION['filterscatA']);
	$_SESSION['filtercatA'] = preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",trim($_POST['filterScat']));
	$_SESSION['filtercatlikeA'] = " and (category IS NOT NULL and category != '') and (category like '".$_SESSION['filtercatA']."' or category like '".$_SESSION['filtercatA']."#%')";
	
}

function multicodes($str) 
	{
		if (@preg_match('+.+u', $str)) 
		{
			$Array_CP_UTF = Array( 0x80 => 0x402, 0x81 => 0x403,0x82 => 0x201A,0x83 => 0x453, 0x84 => 0x201E, 0x85 => 0x2026,0x86 => 0x2020,0x87 => 0x2021,0x88 => 0x20AC,0x89 => 0x2030,0x8A => 0x409,0x8B => 0x2039,0x8C => 0x40A,0x8D => 0x40C,0x8E => 0x40B,0x8F => 0x40F,0x90 => 0x452,0x91 => 0x2018,0x92 => 0x2019,0x93 => 0x201C,0x94 => 0x201D,0x95 => 0x2022,0x96 => 0x2013,0x97 => 0x2014,0x99 => 0x2122,0x9A => 0x459,0x9B => 0x203A,0x9C => 0x45A,0x9D => 0x45C,0x9E => 0x45B,0x9F => 0x45F,0xA0 => 0xA0,0xA1 => 0x40E,0xA2 => 0x45E,0xA3 => 0x408,0xA4 => 0xA4,0xA5 => 0x490,0xA6 => 0xA6,0xA7 => 0xA7,0xA8 => 0x401,0xA9 => 0xA9,0xAA => 0x404,0xAB => 0xAB,0xAC => 0xAC,0xAD => 0xAD,0xAE => 0xAE,0xAF => 0x407,0xB0 => 0xB0,0xB1 => 0xB1,0xB2 => 0x406,0xB3 => 0x456,0xB4 => 0x491,0xB5 => 0xB5,0xB6 => 0xB6,0xB7 => 0xB7,0xB8 => 0x451,0xB9 => 0x2116,0xBA => 0x454,0xBB => 0xBB,0xBC => 0x458,0xBD => 0x405,0xBE => 0x455,0xBF => 0x457);
			$Array_UTF_CP = array_flip($Array_CP_UTF);
			$strig = "";
			for($i=0; $i<mb_strlen($str); $i++)
				{
					$s = ord($str{$i});
					if($s == 0x0A) $strig .= " ";
					//elseif($s == 0x3C || $s == 0x3E)	$strig .= ""; сжираем <>
					elseif($s > 31 && $s < 127)	$strig .= $str{$i};
					elseif($s > 127)
					{
						if(($s >> 5) == 6) 
						{ 
							$strig .= (($t = ((($s-192)<<6)+(ord($str{++$i})-128))) >= 0x410 && $t <= 0x44F)?chr($t-848):((array_key_exists($t,$Array_UTF_CP))?chr($Array_UTF_CP[$t]):"&#".$t.";"); 
						}
						elseif(($s >> 4) == 14)
						{
							$strig .= "&#".((($s-224)<<12)+((ord($str{++$i})-128)<<6)+(ord($str{++$i})-128)).";";
						}
						elseif(($s >> 3) == 30)
						{
							$strig .= "&#".((($s-240)<<18)+((ord($str{++$i})-128)<<12)+((ord($str{++$i})-128)<<6)+(ord($str{++$i})-128)).";";
						}
					}	
				}

			return $strig;
		} else return $str;
	}


if($_FILES['name']["name"])
{
	$date = date ( "Y-m-d" );

		if($_POST['galcat_u']) $category_gal = trim(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",trim(multicodes($_POST['galcat_u']))));
		if($_POST['galscat_u']) $category_gal .= "#".trim(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",trim(multicodes($_POST['galscat_u']))));
		if($_POST['galsscat_u']) $category_gal .= "#".trim(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",trim(multicodes($_POST['galsscat_u']))));
		
		$message = (intval($_POST['namefoto']) == 1)?mysql_real_escape_string (multicodes(substr($_FILES['name']["name"], 0,-strlen(strrchr($_FILES['name']["name"],"."))))):"";
		mysql_query( "INSERT INTO $db_foto (item, date, sort, category) VALUES ('".$message."', '$date', '0', '".mysql_real_escape_string(($category_gal))."')" );
		$num = mysql_insert_id();
		
		if($category_gal)
		{
			
			$category_gal_array = explode("#",$category_gal);
			if($category_gal && count($category_gal_array) > 1 && mysql_result(mysql_query("select count(*) from $db_foto_meta where item='".mysql_real_escape_string($category_gal_array[0])."'"),0) == 0)
			{
				mysql_query("insert into $db_foto_meta (item,rewrite) values ('".mysql_real_escape_string($category_gal_array[0])."', '".str_replace("#","/",rewrite($category_gal_array[0]))."') ");
			}
			if($category_gal && count($category_gal_array) > 2 && mysql_result(mysql_query("select count(*) from $db_foto_meta where item='".mysql_real_escape_string($category_gal_array[0]."#".$category_gal_array[1])."'"),0) == 0)
			{
				mysql_query("insert into $db_foto_meta (item,rewrite) values ('".mysql_real_escape_string($category_gal_array[0]."#".$category_gal_array[1])."', '".str_replace("#","/",rewrite($category_gal_array[0]."#".$category_gal_array[1]))."') ");
			}
			if($category_gal && mysql_result(mysql_query("select count(*) from $db_foto_meta where item='".mysql_real_escape_string($category_gal)."'"),0) == 0)
			{
				mysql_query("insert into $db_foto_meta (item,rewrite) values ('".mysql_real_escape_string($category_gal)."', '".str_replace("#","/",rewrite($category_gal))."') ");
			}
		}
					
		copy ($_FILES['name']['tmp_name'], ".././foto/".$num.".jpg") or die("Ошибка") ;

		$img = imagecreatefromstring(file_get_contents('.././foto/'.$num.'.jpg'));
		$w = imagesx($img);
		$h = imagesy($img);
		$k = $width_small_foto / $w;
		$img2 = imagecreatetruecolor($w * $k, $h * $k);
		imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
		imagejpeg($img2, '.././foto/s_'.$num.'.jpg', 100);
				
		if ($w > $max_foto_width_big)
		{
			$k = $max_foto_width_big / $w;
			$img2 = imagecreatetruecolor($w * $k, $h * $k);
			imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
			imagejpeg($img2, '.././foto/'.$num.'.jpg', 100);
			$w *= $k;
			$h *= $k;
			$img = $img2;
		}

		if ($def_foto_wattermark == 'YES')
		{
			$img2 = imagecreatefrompng('.././foto/_watermark.png');
			$w_ = imagesx($img2);
			$h_ = imagesy($img2);
			imagecopyresampled($img, $img2, $w - $w_, $h - $h_, 0, 0, $w_, $h_, $w_, $h_);
			imagejpeg($img, '.././foto/'.$num.'.jpg', 100);
		}
		header("Content-type: text/javascript; charset=windows-1251");

		print("ok");
	
	exit;
}

$help_section = (string)$foto_help;

$title_cp = 'Фотогалерея - ';
$speedbar = ' | <a href="cpffoto.php">Фотогалерея</a>';

check_login_cp('3_2','cpffoto.php');

require_once 'template/header.php';

if ($_REQUEST["changed"]== "true") 
{
    if (( $_POST["but"] == "$def_images_delete" ) or ($_GET['delete']=="true"))
	{
		@unlink ( ".././foto/$_REQUEST[seek].gif" );
		@unlink ( ".././foto/$_REQUEST[seek].bmp" );
		@unlink ( ".././foto/$_REQUEST[seek].jpg" );
		@unlink ( ".././foto/$_REQUEST[seek].png" );

		@unlink ( ".././foto/s_".$_REQUEST['seek'].".gif" );
		@unlink ( ".././foto/s_".$_REQUEST['seek'].".bmp" );
		@unlink ( ".././foto/s_".$_REQUEST['seek'].".jpg" );
		@unlink ( ".././foto/s_".$_REQUEST['seek'].".png" );

		$db->query  ( "DELETE FROM $db_foto WHERE num='$_$_REQUEST[seek]'" )
		or die ( "ERROR011: mySQL error, can't delete from IMAGES. (cpffoto.php)" );
	}

	if ((($_POST["but"] == "$def_offers_edit_but") and (isset($_POST['seek']))) or ($_GET['editfoto']=="true"))
	{
	$res_images = $db->query  ( "SELECT * FROM $db_foto WHERE num='$_REQUEST[seek]' ".(($_SESSION['filtercatlikeA'])?$_SESSION['filtercatlikeA']:"")."");
        $fe_images = $db->fetcharray  ( $res_images );
        $form_item = $fe_images['item'];
        $form_message = $fe_images['message'];
        $form_message = str_replace("<br>", "\n", $form_message);
      	$form_sort = $fe_images['sort'];
        $form_change = 'true';
	} 
	else $form_change = 'false';
}


if ( $_POST["add"] == "true" )
{
	if($_POST['galcat']) $category_gal = trim(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",trim($_POST['galcat'])));
	if($_POST['galscat']) $category_gal .= "#".trim(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",trim($_POST['galscat'])));
	if($_POST['galsscat']) $category_gal .= "#".trim(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",trim($_POST['galsscat'])));
		
	$item = safeHTML ($_POST["item"]);
	$message = safeHTML ($_POST["message"]);
	$sort = safeHTML ($_POST["sort"]);

	$allcountgal = mysql_result(mysql_query("SELECT count(*) FROM $db_foto" ),0);
	if (strlen($message) > $def_image_descr_size)
	{
		$message = substr($message, 0, $def_image_descr_size);
		$message = substr($message, 0, strrpos($message, ' '));
		$message = trim($message) . ' ...';
	}

	if ( ( empty ( $item ) ) and ( $_POST[but] != "$def_images_delete" ) ) $empty = "Вы не заполнили обязательное поле - изображение.";
	if ( ( empty ( $_FILES['img1']['tmp_name'] ) ) and ( $_POST["edit"] != 'true' ) ) $empty = 'Вы не выбрали файл изображения!';
	if (!$_POST['galcat']) $empty = 'Вы не указали категорию!';
	if ( filesize ( $_FILES['img1']['tmp_name'] )>$def_foto_pic_size ) $empty = (string)$def_admin_error_file;

	// *********************************************************
	if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_offers_change" ) )
	{
		$db->query  ( "UPDATE $db_foto SET category='".mysql_real_escape_string($category_gal)."', item='$item', message='$message', sort='$sort' WHERE num='$_POST[seek]'" )
		or die ( "ERROR012: mySQL error, can't update INFO. (cominfo.php)" );
    }

	if ( ( empty ( $empty ) ) and ( $_POST["but"] == "$def_images_add" ) )
	{
		$r = $db->query  ( "SELECT * FROM $db_foto ".(($_SESSION['filtercatlikeA'])?" WHERE ".$_SESSION['filtercatlikeA']:"")."" );
		@$results_amount=mysql_num_rows($r);
		@$db->freeresult ($r);

		$f_FOTO = substr($_FILES['img1']['name'], -4);
		if ( !in_array($f_FOTO, array('.jpg', '.JPG', 'jpeg', 'JPEG'))) $empty = (string)$def_admin_error_jpg_file;
				
		if (!isset($empty)) 
		{
			$date = date ( "Y-m-d" );
			mysql_query( "INSERT INTO $db_foto (item, date, message, sort, category) VALUES ('$item', '$date', '$message', '$sort', '".mysql_real_escape_string($category_gal)."')" )
			or die ( "ERROR010: mySQL error, cant insert into IMAGES. (cpffoto.php)" );
			if ($_POST['edit']!='true') $_POST['seek'] = mysql_insert_id();
		}
	}
	if(!isset($empty))
	{
	
		if ( $_FILES['img1']['tmp_name'] )
		{
			chmod ( $_FILES['img1']['tmp_name'], 0777 )
			or die ( "ERROR007: Can't change file permission. (cpffoto.php) ");
			$type = "jpg";
	
			copy ( $_FILES['img1']['tmp_name'], ".././foto/$_POST[seek].$type" )
			or $upload = (string)$def_imagespic_error;

			chmod ( ".././foto/$_POST[seek].$type", 0777 )
			or die ( "ERROR008: Can't change file permission. (cpffoto.php) ");

			$type = ".jpg";
			$out = 'imagejpeg';
			$q = 100;
			$img = imagecreatefromstring( file_get_contents('../foto/'.$_POST['seek'].$type) );
			$w = imagesx($img);
			$h = imagesy($img);
			$k = $width_small_foto / $w;
			$img2 = imagecreatetruecolor($w * $k, $h * $k);
			imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
			$out($img2, '../foto/s_'.$_POST['seek'].$type, $q);
			if ($w > $max_foto_width_big)
			{
				$k = $max_foto_width_big / $w;
				$img2 = imagecreatetruecolor($w * $k, $h * $k);
				imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
				$out($img2, '../foto/'.$_POST[seek].$type, $q);
				$w *= $k;
				$h *= $k;
				$img = $img2;
			}

			if ($def_foto_wattermark == 'YES')
			{
				$img2 = imagecreatefrompng('../foto/_watermark.png');
				$w_ = imagesx($img2);
				$h_ = imagesy($img2);
				imagecopyresampled($img, $img2, $w - $w_, $h - $h_, 0, 0, $w_, $h_, $w_, $h_);
				$out($img, '../foto/'.$_POST[seek].$type, $q);
			}
			$upload = (string)$def_images_pic_ok;
			logsto("Добавлено изображение");
		}
	}
}

// *********************************************************

    $pages=7;

    $r = $db->query  ( "SELECT * FROM $db_foto  WHERE (category IS NOT NULL and category != '') ".(($_SESSION['filtercatlikeA'])?"".$_SESSION['filtercatlikeA']:"")." ORDER BY sort, num DESC" ) or die ("2mySQL error!");
    @$results_amount = mysql_num_rows ( $r );
    @$results_amount_all = mysql_num_rows ( $r );
	$allcountgal = mysql_result(mysql_query("SELECT count(*) FROM $db_foto" ),0);
    if ($results_amount>$pages) 
	{
		$page1=intval($_POST['page'])*$pages;
		$r=$db->query ("SELECT * FROM $db_foto  WHERE (category IS NOT NULL and category != '') ".(($_SESSION['filtercatlikeA'])?"".$_SESSION['filtercatlikeA']:"")." ORDER BY sort, num DESC LIMIT $page1, $pages") or die ("3mySQL error!");
		@$results_amount = mysql_num_rows ( $r );
    }

	if($category_gal)
	{
		
		$category_gal_array = explode("#",$category_gal);
		if($category_gal && count($category_gal_array) > 1 && mysql_result(mysql_query("select count(*) from $db_foto_meta where item='".mysql_real_escape_string($category_gal_array[0])."'"),0) == 0)
		{
			mysql_query("insert into $db_foto_meta (item,rewrite) values ('".mysql_real_escape_string($category_gal_array[0])."', '".str_replace("#","/",rewrite($category_gal_array[0]))."') ");
		}
		if($category_gal && count($category_gal_array) > 2 && mysql_result(mysql_query("select count(*) from $db_foto_meta where item='".mysql_real_escape_string($category_gal_array[0]."#".$category_gal_array[1])."'"),0) == 0)
		{
			mysql_query("insert into $db_foto_meta (item,rewrite) values ('".mysql_real_escape_string($category_gal_array[0]."#".$category_gal_array[1])."', '".str_replace("#","/",rewrite($category_gal_array[0]."#".$category_gal_array[1]))."') ");
		}
		if($category_gal && mysql_result(mysql_query("select count(*) from $db_foto_meta where item='".mysql_real_escape_string($category_gal)."'"),0) == 0)
		{
			mysql_query("insert into $db_foto_meta (item,rewrite) values ('".mysql_real_escape_string($category_gal)."', '".str_replace("#","/",rewrite($category_gal))."') ");
		}
	}
	
	if($_POST['rewrite'])
	{
		mysql_query("update $db_foto_meta SET title='".mysql_real_escape_string($_POST['title'])."', rewrite='".mysql_real_escape_string($_POST['rewrite'])."', keywords='".mysql_real_escape_string($_POST['keywords'])."', description='".mysql_real_escape_string($_POST['description'])."' where item='".mysql_real_escape_string($_POST['item'])."' ");
	}
	
table_item_top ('Фотогалерея','iset.png');


table_fdata_top ("Параметры фотоальбомов");
	
	$RfilterGcM = mysql_query("select distinct substring_index(category,'#',1) as category  from $db_foto where (category IS NOT NULL and category != '') ");
	
	if(mysql_num_rows($RfilterGcM) > 0)
	{
		while($FfilterGcM = mysql_fetch_array($RfilterGcM))
		{
			echo "<div class=\"metacat\"><div class=\"edit_foto_gal\"></div>";
			$RfiltersGcM = mysql_query("select distinct substring_index(category,'#',2) as category  from $db_foto where (category IS NOT NULL and category != '') and (category regexp '^".($FfilterGcM[0])."#[^#]+$'  or category regexp '^".($FfilterGcM[0])."#[^#]+#[^#]+$')");
			if(mysql_num_rows($RfiltersGcM) > 0) echo "<span></span>";
			echo "<b>".$FfilterGcM[0]."</b>";
			
			$rey = mysql_query("select * from $db_foto_meta where item='".$FfilterGcM[0]."'");
			$frey = mysql_fetch_array($rey);
			
			echo '<form action="" method="post" enctype="multipart/form-data" style="display: none">';
				echo "<div><span>Мета-тег Title: </span><input type=\"text\" value=\"".$frey['title']."\" name=\"title\" style=\"width: 350px;\"></div>";
				echo "<div><span>Альтернативное имя: </span><input type=\"text\" value=\"".$frey['rewrite']."\" name=\"rewrite\" style=\"width: 350px;\"></div>";
				echo "<div><span>Мета-тег Keywords: </span><input type=\"text\" value=\"".$frey['keywords']."\" name=\"keywords\" style=\"width: 350px;\"></div>";
				echo "<div><span>Мета-тег Description: </span><input type=\"text\" value=\"".$frey['description']."\" name=\"description\" style=\"width: 350px;\"></div>";	
				echo "<input type=\"hidden\" name=\"item\" value=\"".$frey['item']."\" />";	
				echo "<input type=\"submit\" value=\"Отправить\" />";
                                echo '&nbsp;<a href="cpfoto_edit.php?addedit='.$frey['rewrite'].'" class="butlink">Добавить описание и положение на карте</a>';
			echo "</form>";
			
			if(mysql_num_rows($RfiltersGcM) > 0) 
				echo "<div class=\"pmetacat\" style=\"display: none\">";
			
				while($FfiltersGcM = mysql_fetch_array($RfiltersGcM))
				{
					echo "<div class=\"metacat\"><div class=\"edit_foto_gal\"></div>";
					$RfilterssGcM = mysql_query("select distinct substring_index(category,'#',3) as category  from $db_foto where (category IS NOT NULL and category != '') and (category regexp '^".($FfiltersGcM[0])."#[^#]+$'  or category regexp '^".($FfiltersGcM[0])."#[^#]+#[^#]+$')");
					if(mysql_num_rows($RfilterssGcM) > 0) echo "<span></span>";
					echo "<b>".substr(strrchr($FfiltersGcM[0],"#"),1)."</b>";
					
					$reys = mysql_query("select * from $db_foto_meta where item='".$FfiltersGcM[0]."'");
					$freys = mysql_fetch_array($reys);
					echo '<form action="" method="post" enctype="multipart/form-data" style="display: none">';
						echo "<div><span>Мета-тег Title: </span><input type=\"text\" value=\"".$freys['title']."\" name=\"title\" style=\"width: 350px;\"></div>";
						echo "<div><span>Альтернативное имя: </span><input type=\"text\" value=\"".$freys['rewrite']."\" name=\"rewrite\" style=\"width: 350px;\"></div>";
						echo "<div><span>Мета-тег Keywords: </span><input type=\"text\" value=\"".$freys['keywords']."\" name=\"keywords\" style=\"width: 350px;\"></div>";
						echo "<div><span>Мета-тег Description: </span><input type=\"text\" value=\"".$freys['description']."\" name=\"description\" style=\"width: 350px;\"></div>";	
						echo "<input type=\"hidden\" name=\"item\" value=\"".$freys['item']."\" />";	
						echo "<input type=\"submit\" value=\"Отправить\" />";
                                                echo '&nbsp;<a href="cpfoto_edit.php?addedit='.$freys['rewrite'].'" class="butlink">Добавить описание и положение на карте</a>';
					echo "</form>";
					
					if(mysql_num_rows($RfilterssGcM) > 0) 
						echo "<div class=\"pmetacat\" style=\"display: none\">";
					
						while($FfilterssGcM = mysql_fetch_array($RfilterssGcM))
						{
							echo "<div class=\"metacat\">";
								echo "<div class=\"edit_foto_gal\"></div>";
								echo '<b><img src="images/tree.gif" />'.substr(strrchr($FfilterssGcM[0],"#"),1).'</b>';
								
								$reyss = mysql_query("select * from $db_foto_meta where item='".$FfilterssGcM[0]."'");
								$freyss = mysql_fetch_array($reyss);
								echo '<form action="" method="post" enctype="multipart/form-data" style="display: none">';
									echo "<div>&nbsp;<span>Мета-тег Title: </span><input type=\"text\" value=\"".$freyss['title']."\" name=\"title\" style=\"width: 350px;\"></div>";
									echo "<div>&nbsp;<span>Альтернативное имя: </span><input type=\"text\" value=\"".$freyss['rewrite']."\" name=\"rewrite\" style=\"width: 350px;\"></div>";
									echo "<div>&nbsp;<span>Мета-тег Keywords: </span><input type=\"text\" value=\"".$freyss['keywords']."\" name=\"keywords\" style=\"width: 350px;\"></div>";
									echo "<div>&nbsp;<span>Мета-тег Description: </span><input type=\"text\" value=\"".$freyss['description']."\" name=\"description\" style=\"width: 350px;\"></div>";	
									echo "&nbsp;<input type=\"hidden\" name=\"item\" value=\"".$freyss['item']."\" />";	
									echo "&nbsp;<input type=\"submit\" value=\"Отправить\" />";
                                                                        echo '&nbsp;<a href="cpfoto_edit.php?addedit='.$freyss['rewrite'].'" class="butlink">Добавить описание и положение на карте</a>';
								echo "</form>";
								
							echo "</div>";
						}
						
					if(mysql_num_rows($RfilterssGcM) > 0) 		
						echo "</div>";
						
					echo "</div>";
				}
				
			if(mysql_num_rows($RfiltersGcM) > 0) 	
				echo "</div>";
			echo "</div>";
		}
		?>
		<script>
			for(var i = 0; i<document.querySelectorAll(".metacat > span").length; i++)
			(function(i){
				document.querySelectorAll(".metacat > span")[i].onclick = function()
				{
					document.querySelectorAll(".metacat >  .pmetacat")[i].style.display 
					= (document.querySelectorAll(".metacat > .pmetacat")[i].style.display == "block")
					?"none":"block";
					
					this.style.backgroundPosition
					= (document.querySelectorAll(".metacat > .pmetacat")[i].style.display == "block")
					?"1px 0px":"28px 0px";
				}
			})(i);
			for(var i = 0; i<document.querySelectorAll(".edit_foto_gal").length; i++)
			(function(i){
				document.querySelectorAll(".edit_foto_gal")[i].onclick = function()
				{
					document.querySelectorAll(".metacat >  form")[i].style.display 
					= (document.querySelectorAll(".metacat > form")[i].style.display == "block")
					?"none":"block";
				}
			})(i);
			
		</script>
		<?php
	}
	else
	{	
		echo "<div style=\"padding: 30px; text-align: center; width: 100%;\">Фотоальбомы отсутствуют!</div>";
	}
	
table_fdata_bottom();



echo "<br /><br />";

?>
<div class="filterG">
			<form action="" method="post" enctype="multipart/form-data" name="formfiltercat">
			<?php
				if($RfilterGc = mysql_query("select distinct substring_index(category,'#',1) as category  from $db_foto where (category IS NOT NULL and category != '') ")) 
				{
			?>
					<select class="filterScat" name="filterScat">
			<?php 
						echo '<option>Все альбомы</option>'; 
						while($FfilgerGc = mysql_fetch_array($RfilterGc))
						{
							$CountCat = mysql_result(mysql_query("select count(*) from $db_foto where (category IS NOT NULL and category != '') and (category like '".$FfilgerGc['category']."' or category like '".$FfilgerGc['category']."#%') "),0);
							echo '<option value="'.$FfilgerGc['category'].'" '.(($_SESSION['filtercatA'] && $_SESSION['filtercatA'] == $FfilgerGc['category'])?'selected':'').'>'.$FfilgerGc['category'].' ['.$CountCat.']</option>'; 
						}	
			?>
					</select>
			<? } ?>
					<select class="filterSscat" style="<? echo ($_SESSION["filtercatA"])?"":"display: none"; ?>" name="formfilterscat">
					<?php
						$RfilterGsc = mysql_query("select distinct substring_index(category,'#',2) as category from $db_foto where (category IS NOT NULL and category != '')  and (category like '".$_SESSION["filtercatA"]."#%') "); 
						
						echo '<option>Все альбомы</option>'; 
						while($FfilgerGsc = mysql_fetch_array($RfilterGsc))
						{
							$CountCat = mysql_result(mysql_query("select count(*) from $db_foto where (category IS NOT NULL and category != '') and (category like '".$FfilgerGsc["category"]."%' or category like '".$FfilgerGsc["category"]."')"),0);
							echo '<option value="'.$FfilgerGsc['category'].'" '.(($_SESSION['filterscatA'] && $_SESSION["filtercatA"]."#".$_SESSION["filterscatA"] == $FfilgerGsc['category'])?'selected':'').'>'.substr(strrchr($FfilgerGsc['category'],"#"),1).' ['.$CountCat.']</option>'; 
						}	
					?>
					</select>
					<select class="filterSsscat" style="<? echo ($_SESSION["filterscatA"])?"":"display: none"; ?>" name="formfiltersscat">
					<?php
						$RfilterGssc = mysql_query("select category, count(*) from $db_foto where (category IS NOT NULL and category != '') and category like '".$_SESSION["filtercatA"]."#".$_SESSION["filterscatA"]."#%' group by category "); 
						
						echo '<option>Все альбомы</option>'; 
						while($FfilgerGssc = mysql_fetch_array($RfilterGssc))
						{
							echo '<option value="'.$FfilgerGssc['category'].'" '.(($_SESSION['filterscatA'] && $_SESSION["filtercatA"]."#".$_SESSION["filterscatA"]."#".$_SESSION["filtersscatA"] == $FfilgerGssc['category'])?'selected':'').'>'.substr(strrchr($FfilgerGssc['category'],"#"),1).' ['.$FfilgerGssc['count(*)'].']</option>'; 
						}	
					?>
					</select>
					<input type="submit" name="catFirm" class="catFirm" value="">
			</form>
		</div>
<?php
if ($results_amount_all > $pages){ ?>
<div style="text-align:right; width: 1000px; margin: auto"  class="page_number">
<form action="cpffoto.php" method="post">
  Страница : <select name="page" onchange="this.form.submit();">
<?php
                $z=0;
                $xp1=0;
			for($x=0; $x<$results_amount_all; $x=$x+$pages)
			{
                            $xp1=$z+1;
				if ($z == $_POST['page']) { echo '<option value="'.$_POST['page'].'" selected>'.$xp1.'</option>'; } else {echo '<option value="'.$z.'">'.$xp1.'</option>';}
                                $z++;
			}
?>
    </select>
</form>
</div><br>
<?php
}

 if ( isset ( $over ) )
 {
     msg_text("80%",$def_admin_message_mess,$over);
 }

 if (!empty ($empty)) msg_text("80%",$def_admin_message_mess,$empty);

 if (isset($upload))  msg_text("80%",$def_admin_message_mess,$upload);
echo '<a id="updates" href="cpffoto.php?REQ=auth" class="btn btn-warning" style="display: none; text-decoration: none; color: red; background: rgba(255,0,0,0.1);padding: 10px;text-align: center;">Обновить</a>';
 echo '<form action="cpffoto.php" method="post" enctype="multipart/form-data" class="formedgal">
             <table cellpadding="0" cellspacing="0" border="0" width="1000" align="center">
              <tr>
               <td align="middle" valign="middle" width="5%" id="table_files">'.$def_images_choice.'</td>
               <td colspan="2" align="middle" valign="middle" width="50%" id="table_files_r">'.$def_images_item.'</td>
              </tr>';

 $banhandle = opendir ( ".././foto" );

 $bancount=0;

 while ( false !== ( $banfile = readdir ( $banhandle ) ) )

 {
 	if ( $banfile != "." && $banfile != ".." )

 	{
 		$banbanner[$bancount] = "$banfile";
 		$bancount++;
 	}
 }

 closedir ( $banhandle );

 for ( $i=0; $i<$results_amount; $i++ )

 {
 	$f = $db->fetcharray  ( $r );

 	$pictext="";

 	for ( $aaa=0;$aaa<count ( $banbanner );$aaa++ )

 	{
 		$banrbanner = explode( ".", $banbanner[$aaa] );

 		if ( $banrbanner[0] == $f[num] )

 		$pictext = "<img style=\"padding:5px;\" src=\".././foto/s_".$f['num'].".jpg\" alt=\"$f[item]\" />";
 	}

 ?>

     <tr>
      <td valign="middle" align="center" id="table_files_i">
          <div align="center">
       <a class="slink" href="?changed=true&editfoto=true&seek=<?php echo $f['num']; ?>#form_u" title="Редактировать"><img src="images/idedit.gif" border="0" /></a>
       <input type="radio" name="seek" value="<?php echo $f[num]; ?>" style="border:0;" <?php if ( $f[num] == $_POST['seek'] ) echo "CHECKED"; ?>>
       <br />
       <a class="slink" href="?changed=true&delete=true&seek=<?php echo $f['num']; ?>" title="Удалить"><img src="images/delactiv.gif" border="0" /></a>
          </div>
      </td>

 <?php

 $cols="";

 $widht_table_img=$max_foto_width_big+20;

 if ($pictext != "")

 echo '<td align="left" valign="middle" width="'.$widht_table_img.'" id="table_files_i_c">'.$pictext.'</td>';

 else

 $cols = "colspan=2";
 
 if ($f['item']=='') $f['item'] = 'Название отсутствует';
 if ($f['message']=='') $f['message'] = 'Описание отсутствует';
 
  echo '<td  width="90%" '.$cols.' align="left" valign="middle" id="table_files_i_r">
            <b><span id="'.$f['num'].'" class="edit_p">'.$f['item'].'</span></b> ('. undate($f[date], $def_datetype).')
             <br /><br /><b>'.$def_images_description.'</b>: <span id="'.$f['num'].'" class="txt" style="padding:2px;">'.$f['message'].'</span><br /><br />
             <b>Альбом: </b>'.str_replace("#"," / ",$f['category']).'<br /><br />
             <b>Рейтинг</b> ('.$f['rateNum'].'/'.$f['rateVal'].')    
       </td>
       </tr>';
 }
?>
<link href="gallery/gallery.css" rel="stylesheet" type="text/css">
<?php
list($catgalecho, $scatgalecho, $sscatgalecho) = explode("#",$fe_images['category']); 
 echo '</table><br /><div align="center">
&nbsp;<input type="submit" name="but" value="'.$def_images_delete.'" style="color: #FFFFFF; background: #D55454;">
&nbsp;<input type="submit" name="but" value="'.$def_offers_edit_but.'">
<input type="hidden" name="changed" value="true">
<input type="hidden" name="notdop" value="true">
<br /><br /></div>
</form>';
echo "<br /><br />";
table_fdata_top ('Редактирование параметров изображения');

 echo '<br /><form action="cpffoto.php" method="post" enctype="multipart/form-data">
          <table cellpadding="3" cellspacing="3" border="0" width="97%" align="center">
           <tr>
            <td align="right" width="80%">';
		echo "<b>Альбом</b>: <span id=\"galcat\">".$catgalecho."</span> <span id=\"galscat\">".(($scatgalecho)?"/ ".$scatgalecho:" ")."</span>  <span id=\"galsscat\">".(($sscatgalecho)?"/ ".$sscatgalecho:" ")."</span>
			<div class=\"category_gal\">
				Выбрать\добавить категорию фотоальбома<br />
				<input name=\"category_gal\" type=\"text\" value=\"".$catgalecho."\">
				<input name=\"galcat\" type=\"hidden\" value=\"".$catgalecho."\">
				<div id=\"catselect\" style=\"display: none;\"></div>
				<span del></span>
				<span add></span>
				<span select></span>
			</div>
			<div class=\"category_sgal\" style=\"".(($catgalecho)?"":"display: none")."\">
				Выбрать\добавить подкатегорию фотоальбома<br />
				<input name=\"category_sgal\" type=\"text\" value=\"".$scatgalecho."\">
				<input name=\"galscat\" type=\"hidden\" value=\"".$scatgalecho."\">
				<div id=\"scatselect\" style=\"display: none;\"></div>
				<span del></span>
				<span add></span>
				<span select></span>
			</div>
			<div class=\"category_ssgal\"  style=\"".(($scatgalecho)?"":"display: none")."\">
				Выбрать\добавить подподкатегорию фотоальбома<br />
				<input name=\"category_ssgal\" type=\"text\" value=\"".$sscatgalecho."\">
				<input name=\"galsscat\" type=\"hidden\" value=\"".$sscatgalecho."\">
				<div id=\"sscatselect\" style=\"display: none;\"></div>
				<span del></span>
				<span add></span>
				<span select></span>
			</div>";
          echo $def_images_item.': <span style="color:#FF0000;">*</span> <input type="text" name="item" value="'.$form_item.'" size="45" maxlength="100" /><br /><br />
          '.$def_images_description.': &nbsp;&nbsp;<textarea name="message" cols="45" rows="5" style="width:400px; height:200px;">'.$form_message.'</textarea><br /><br />
          '.$def_images_sort.': <input type="text" name="sort" value="'.$form_sort.'" size="45" maxlength="10" style="width: 40px;" /><br /><br />
          '.$def_offers_imageupload.' (jpg, Допустимый размер: '.$def_foto_pic_size.' байты): &nbsp;&nbsp;<input type="file" NAME="img1" SIZE="34" /><br /><br />';
 echo '     </td>
           </tr>';
 echo '<tr><td align="center" colspan="3">';

 if ($form_change == 'true') echo '<input type="submit" name="but" value="'.$def_offers_change.'" /><input type="hidden" name="edit" value="true" /><input type="hidden" name="add" value="true" /><br />';
 else echo '<input type="submit" name="but" value="'.$def_images_add.'"><input type="hidden" name="add" value="true" /><br />';
 if (isset($_POST[seek])) echo '<input type="hidden" name="seek" value="'.$_POST[seek].'" />';
 
 echo '  </td>
       </tr>';
 echo '</table></form>';
 
table_fdata_bottom();

echo "<br /><br />";

table_fdata_top ("Пакетная загрузка");

 echo "<a name=\"form_u\"></a>";
 echo "<table cellpadding=\"5\" cellspacing=\"1\" border=\"0\" width=\"100%\">
           <tr>
            <td bgColor=\"$def_form_back_color\" align=\"right\" width=\"80%\">
			<b>Альбом</b>: <span id=\"galcat_u\"></span> <span id=\"galscat_u\"></span>  <span id=\"galsscat_u\"></span>
			<div class=\"category_gal_u\">
				Выбрать\добавить категорию фотоальбома<br />
				<input name=\"category_gal_u\" type=\"text\" value=\"\">
				<input name=\"galcat_u\" type=\"hidden\" value=\"\">
				<div id=\"catselect_u\" style=\"display: none;\"></div>
				<span del></span>
				<span add></span>
				<span select></span>
			</div>
			<div class=\"category_sgal_u\" style=\"display: none\">
				Выбрать\добавить подкатегорию фотоальбома<br />
				<input name=\"category_sgal_u\" type=\"text\" value=\"\">
				<input name=\"galscat_u\" type=\"hidden\" value=\"\">
				<div id=\"scatselect_u\" style=\"display: none;\"></div>
				<span del></span>
				<span add></span>
				<span select></span>
			</div>
			<div class=\"category_ssgal_u\"  style=\"display: none\">
				Выбрать\добавить подподкатегорию фотоальбома<br />
				<input name=\"category_ssgal_u\" type=\"text\" value=\"\">
				<input name=\"galsscat_u\" type=\"hidden\" value=\"\">
				<div id=\"sscatselect_u\" style=\"display: none;\"></div>
				<span del></span>
				<span add></span>
				<span select></span>
			</div>
		
          
  <br><b>Загрузить изображения:</b><br>
  Вы можете выбрать несколько файлов одновременно!<br><br>
  <select id=\"namefoto\" name=\"name_foto\"><option value=\"1\">Заполнять название изображений именами файлов</option><option value=\"0\">Название изображений оставить пустыми</option></select><br /><br />  
	<div id=\"divfileload\">                     
			<span id=\"TextFil\"><b>Выбрать изображения<b></span>
			<input type=\"file\" name=\"filelload\" multiple=\"true\">
	</div><br><br>";

 echo"</td></tr>";

 echo "<tr><td align=\"center\" bgColor=\"$def_form_header_color\" colspan=\"3\">";
 
 echo '<div id="uploadgal"></span></div>';;
 
 echo "</td>
       </tr>
      </table>";

table_fdata_bottom();

?>

<script src="<? echo $def_mainlocation; ?>/includes/js/jquery.jeditable.mini.js" type="text/javascript"></script>
<script>
formfiltercat.filterScat[(!-[1,])?"onpropertychange":"onchange"] = function()
{
	formfiltercat.formfilterscat.innerHTML = "";
	formfiltercat.formfiltersscat.innerHTML = "";
	formfiltercat.formfiltersscat.style.display = "none";
	formfiltercat.formfilterscat.style.display = "none";
	if(this.value != "Все альбомы") returnsCatGal("catF="+this.value,formfiltercat.formfilterscat);
}

formfiltercat.formfilterscat[(!-[1,])?"onpropertychange":"onchange"] = function()
{
	formfiltercat.formfiltersscat.innerHTML = "";
	formfiltercat.formfiltersscat.style.display = "none";
		
	if(this.value != "Все альбомы") returnsCatGal("catF="+this.value,formfiltercat.formfiltersscat);
}

document.querySelector(".category_gal [name=\"category_gal\"]").onkeyup = function(event)
{
	var rep = document.querySelector(".category_gal [name=\"category_gal\"]").value.replace(/([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)/g,"");
	if(rep != document.querySelector(".category_gal [name=\"category_gal\"]").value) 
	{
		var t = document.querySelector(".category_gal [name=\"category_gal\"]");
		var caret = t.selectionStart;
		t.value = t.value.toLocaleLowerCase();
		t.size = (t.value)?t.value.length:1;
		document.querySelector(".category_gal [name=\"category_gal\"]").value = rep;
		t.setSelectionRange(caret,caret-1);
	}
}	
document.getElementById("catselect").onclick = function(event)
{
	event = event || window.event;
	var target = event.target || event.srcElement;
	if(target.tagName == "DIV" || target.tagName == "B")
	{
		document.getElementById("galcat").innerHTML = target.getAttribute("value");
		document.querySelector(".category_gal [name=\"galcat\"]").value = target.getAttribute("value");
		document.querySelector(".category_gal [name=\"category_gal\"]").value = target.getAttribute("value");

		document.querySelector(".category_sgal").style.display = "block";
		document.getElementById("galscat").innerHTML = "";
		document.querySelector(".category_sgal [name=\"galscat\"]").value = "";
		document.querySelector(".category_sgal [name=\"category_sgal\"]").value = "";
		
		document.querySelector(".category_ssgal").style.display = "none";
		document.getElementById("galsscat").innerHTML = "";
		document.querySelector(".category_ssgal [name=\"galsscat\"]").value = "";
		document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value = "";
		
		document.getElementById("catselect").style.display = "none"; 
	}
}
document.querySelector(".category_gal [select]").onclick = function()
{
	document.getElementById("scatselect").style.display = "none"; 
	document.getElementById("sscatselect").style.display = "none"; 
	if(document.getElementById("catselect").style.display == "none")
	{
		returnsCatGal("catRoot=1",document.getElementById("catselect"));
		document.querySelector(".category_gal [select]").style.backgroundImage = "url(<? echo $def_mainlocation?>/users/template/images/gal_cat_filter_preloader.GIF)";
	}
	else
		document.getElementById("catselect").style.display = "none"; 
}
document.querySelector(".category_gal [add]").onclick = function()
{
	if(document.querySelector(".category_gal [name=\"category_gal\"]").value != "")
	{
		document.getElementById("galcat").innerHTML = document.querySelector(".category_gal [name=\"category_gal\"]").value;
		document.querySelector(".category_gal [name=\"galcat\"]").value = document.querySelector(".category_gal [name=\"category_gal\"]").value;
		
		document.querySelector(".category_sgal").style.display = "block";
		document.getElementById("galscat").innerHTML = "";
		document.querySelector(".category_sgal [name=\"galscat\"]").value = "";
		document.querySelector(".category_sgal [name=\"category_sgal\"]").value = "";
		
		document.querySelector(".category_ssgal").style.display = "none";
		document.getElementById("galsscat").innerHTML = "";
		document.querySelector(".category_ssgal [name=\"galsscat\"]").value = "";
		document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value = "";
	}
}

document.querySelector(".category_gal [del]").onclick = function()
{
		document.querySelector(".category_gal [name=\"category_gal\"]").value = ""
		document.getElementById("galcat").innerHTML = "";
		document.querySelector(".category_gal [name=\"galcat\"]").value = "";
		
		document.querySelector(".category_sgal").style.display = "none";
		document.getElementById("galscat").innerHTML = "";
		document.querySelector(".category_sgal [name=\"galscat\"]").value = "";
		document.querySelector(".category_sgal [name=\"category_sgal\"]").value = "";
		
		document.querySelector(".category_ssgal").style.display = "none";
		document.getElementById("galsscat").innerHTML = "";
		document.querySelector(".category_ssgal [name=\"galsscat\"]").value = "";
		document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value = "";
}
document.querySelector(".category_sgal [select]").onclick = function()
{
	document.getElementById("sscatselect").style.display = "none"; 
	document.getElementById("catselect").style.display = "none"; 
	if(document.getElementById("scatselect").style.display == "none")
	{
		returnsCatGal("catR="+document.querySelector(".category_gal [name=\"galcat\"]").value,document.getElementById("scatselect"));
		document.querySelector(".category_sgal [select]").style.backgroundImage = "url((<? echo $def_mainlocation?>/users/template/images/gal_cat_filter_preloader.GIF)";
	}
	else
		document.getElementById("scatselect").style.display = "none"; 
}
document.getElementById("scatselect").onclick = function(event)
{
	event = event || window.event;
	var target = event.target || event.srcElement;
	if(target.tagName == "DIV" || target.tagName == "B")
	{
		var v = target.getAttribute("value").split("#")[target.getAttribute("value").split("#").length-1];
		document.getElementById("galscat").innerHTML = "/ "+v;
		document.querySelector(".category_sgal [name=\"galscat\"]").value = v;
		document.querySelector(".category_sgal [name=\"category_sgal\"]").value = v;
			
		document.querySelector(".category_ssgal").style.display = "block";
		document.getElementById("galsscat").innerHTML = "";
		document.querySelector(".category_ssgal [name=\"galsscat\"]").value = "";
		document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value = "";
		
		document.getElementById("scatselect").style.display = "none";
	}
}
document.querySelector(".category_sgal [add]").onclick = function()
{
	if(document.querySelector(".category_sgal [name=\"category_sgal\"]").value != "")
	{
		document.getElementById("galscat").innerHTML = "/ "+document.querySelector(".category_sgal [name=\"category_sgal\"]").value;
		document.querySelector(".category_sgal [name=\"galscat\"]").value = document.querySelector(".category_sgal [name=\"category_sgal\"]").value;
			
		document.querySelector(".category_ssgal").style.display = "block";
		document.getElementById("galsscat").innerHTML = "";
		document.querySelector(".category_ssgal [name=\"galsscat\"]").value = "";
		document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value = "";
	}
}

document.querySelector(".category_sgal [del]").onclick = function()
{
		document.getElementById("galscat").innerHTML = "";
		document.querySelector(".category_sgal [name=\"galscat\"]").value = "";
		document.querySelector(".category_sgal [name=\"category_sgal\"]").value = "";
		
		document.querySelector(".category_ssgal").style.display = "none";
		document.getElementById("galsscat").innerHTML = "";
		document.querySelector(".category_ssgal [name=\"galsscat\"]").value = "";
		document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value = "";
}
document.querySelector(".category_ssgal [select]").onclick = function()
{
	document.getElementById("catselect").style.display = "none"; 
	document.getElementById("scatselect").style.display = "none"; 
	if(document.getElementById("sscatselect").style.display == "none")
	{
		returnsCatGal("catRR="+document.querySelector(".category_gal [name=\"galcat\"]").value+"#"+document.querySelector(".category_sgal [name=\"galscat\"]").value,document.getElementById("sscatselect"));
		document.querySelector(".category_ssgal [select]").style.backgroundImage = "url((<? echo $def_mainlocation?>/users/template/images/gal_cat_filter_preloader.GIF)";
	}
	else
		document.getElementById("sscatselect").style.display = "none"; 
}

document.getElementById("sscatselect").onclick = function(event)
{
	event = event || window.event;
	var target = event.target || event.srcElement;
	if(target.tagName == "DIV" || target.tagName == "B")
	{
		var v = target.getAttribute("value").split("#")[target.getAttribute("value").split("#").length-1];
		document.getElementById("galsscat").innerHTML = "/ "+v;
		document.querySelector(".category_ssgal [name=\"galsscat\"]").value = v;
		document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value = v;
		
		document.getElementById("sscatselect").style.display = "none";
	}
}
document.querySelector(".category_ssgal [add]").onclick = function()
{
	if(document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value != "")   
	{
		
		document.getElementById("galsscat").innerHTML = "/ "+document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value;
		document.querySelector(".category_ssgal [name=\"galsscat\"]").value = document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value;
		document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value = document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value;
	}
}

document.querySelector(".category_ssgal [del]").onclick = function()
{
		document.getElementById("galsscat").innerHTML = "";
		document.querySelector(".category_ssgal [name=\"galsscat\"]").value = "";
		document.querySelector(".category_ssgal [name=\"category_ssgal\"]").value = "";
}
function returnsCatGal(param,elem)
	{
		try { ro = new XMLHttpRequest(); }
		catch(e) { try { ro = new ActiveXObject("Msxml2.XMLHTTP");  }
		catch(e) { ro = new ActiveXObject("Microsoft.XMLHTTP"); } }
		
		ro.open("POST", "<? echo $def_mainlocation; ?>/includes/category_adm.php", true);
		ro.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		
		ro.onreadystatechange = function()
		{
			if((ro.readyState == 4) && (ro.status == 200)) 
			{
				elem.innerHTML = ro.responseText;
				elem.style.display = "";
				if(document.querySelector(".category_gal [select]").style.backgroundImage != "")
					document.querySelector(".category_gal [select]").style.backgroundImage = "";	
				else if(document.querySelector(".category_sgal [select]").style.backgroundImage != "")
					document.querySelector(".category_sgal [select]").style.backgroundImage = "";
				else if(document.querySelector(".category_ssgal [select]").style.backgroundImage != "")
					document.querySelector(".category_ssgal [select]").style.backgroundImage = "";					
			}
		}
		ro.send(param);  
	}
	
document.querySelector(".category_gal_u [name=\"category_gal_u\"]").onkeyup = function(event)
{
	var rep = document.querySelector(".category_gal_u [name=\"category_gal_u\"]").value.replace(/([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)/g,"");
	if(rep != document.querySelector(".category_gal_u [name=\"category_gal_u\"]").value) 
	{
		var t = document.querySelector(".category_gal_u [name=\"category_gal_u\"]");
		var caret = t.selectionStart;
		t.value = t.value.toLocaleLowerCase();
		t.size = (t.value)?t.value.length:1;
		document.querySelector(".category_gal_u [name=\"category_gal_u\"]").value = rep;
		t.setSelectionRange(caret,caret-1);
	}
}	
document.getElementById("catselect_u").onclick = function(event)
{
	event = event || window.event;
	var target = event.target || event.srcElement;
	if(target.tagName == "DIV" || target.tagName == "B")
	{
		document.getElementById("galcat_u").innerHTML = target.getAttribute("value");
		document.querySelector(".category_gal_u [name=\"galcat_u\"]").value = target.getAttribute("value");
		document.querySelector(".category_gal_u [name=\"category_gal_u\"]").value = target.getAttribute("value");
            
		document.querySelector(".category_sgal_u").style.display = "block";
		document.getElementById("galscat_u").innerHTML = "";
		document.querySelector(".category_sgal_u [name=\"galscat_u\"]").value = "";
		document.querySelector(".category_sgal_u [name=\"category_sgal_u\"]").value = "";
		
		document.querySelector(".category_ssgal_u").style.display = "none";
		document.getElementById("galsscat_u").innerHTML = "";
		document.querySelector(".category_ssgal_u [name=\"galsscat_u\"]").value = "";
		document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value = "";
		
		document.getElementById("catselect_u").style.display = "none"; 
	}
}
document.querySelector(".category_gal_u [select]").onclick = function()
{
	document.getElementById("scatselect_u").style.display = "none"; 
	document.getElementById("sscatselect_u").style.display = "none"; 
	if(document.getElementById("catselect_u").style.display == "none")
	{
		returnsCatGal_u("catRoot=1",document.getElementById("catselect_u"));
		document.querySelector(".category_gal_u [select]").style.backgroundImage = "url(./template/images/gal_cat_filter_preloader.GIF)";
	}
	else
		document.getElementById("catselect_u").style.display = "none"; 
}
document.querySelector(".category_gal_u [add]").onclick = function()
{
	if(document.querySelector(".category_gal_u [name=\"category_gal_u\"]").value != "")
	{
		document.getElementById("galcat_u").innerHTML = document.querySelector(".category_gal_u [name=\"category_gal_u\"]").value;
		document.querySelector(".category_gal_u [name=\"galcat_u\"]").value = document.querySelector(".category_gal_u [name=\"category_gal_u\"]").value;
		
		document.querySelector(".category_sgal_u").style.display = "block";
		document.getElementById("galscat_u").innerHTML = "";
		document.querySelector(".category_sgal_u [name=\"galscat_u\"]").value = "";
		document.querySelector(".category_sgal_u [name=\"category_sgal_u\"]").value = "";
		
		document.querySelector(".category_ssgal_u").style.display = "none";
		document.getElementById("galsscat_u").innerHTML = "";
		document.querySelector(".category_ssgal_u [name=\"galsscat_u\"]").value = "";
		document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value = "";
	}
}

document.querySelector(".category_gal_u [del]").onclick = function()
{
		document.querySelector(".category_gal_u [name=\"category_gal_u\"]").value = ""
		document.getElementById("galcat_u").innerHTML = "";
		document.querySelector(".category_gal_u [name=\"galcat_u\"]").value = "";
		
		document.querySelector(".category_sgal_u").style.display = "none";
		document.getElementById("galscat_u").innerHTML = "";
		document.querySelector(".category_sgal_u [name=\"galscat_u\"]").value = "";
		document.querySelector(".category_sgal_u [name=\"category_sgal_u\"]").value = "";
		
		document.querySelector(".category_ssgal_u").style.display = "none";
		document.getElementById("galsscat_u").innerHTML = "";
		document.querySelector(".category_ssgal_u [name=\"galsscat_u\"]").value = "";
		document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value = "";
}
document.querySelector(".category_sgal_u [select]").onclick = function()
{
	document.getElementById("sscatselect_u").style.display = "none"; 
	document.getElementById("catselect_u").style.display = "none"; 
	if(document.getElementById("scatselect_u").style.display == "none")
	{
		returnsCatGal_u("catR="+document.querySelector(".category_gal_u [name=\"galcat_u\"]").value,document.getElementById("scatselect_u"));
		document.querySelector(".category_sgal_u [select]").style.backgroundImage = "url(./template/images/gal_cat_filter_preloader.GIF)";
	}
	else
		document.getElementById("scatselect_u").style.display = "none"; 
}
document.getElementById("scatselect_u").onclick = function(event)
{
	event = event || window.event;
	var target = event.target || event.srcElement;
	if(target.tagName == "DIV" || target.tagName == "B")
	{
		var v = target.getAttribute("value").split("#")[target.getAttribute("value").split("#").length-1];
		document.getElementById("galscat_u").innerHTML = "/ "+v;
		document.querySelector(".category_sgal_u [name=\"galscat_u\"]").value = v;
		document.querySelector(".category_sgal_u [name=\"category_sgal_u\"]").value = v;
			
		document.querySelector(".category_ssgal_u").style.display = "block";
		document.getElementById("galsscat_u").innerHTML = "";
		document.querySelector(".category_ssgal_u [name=\"galsscat_u\"]").value = "";
		document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value = "";
		
		document.getElementById("scatselect_u").style.display = "none";
	}
}
document.querySelector(".category_sgal_u [add]").onclick = function()
{
	if(document.querySelector(".category_sgal_u [name=\"category_sgal_u\"]").value != "")
	{
		document.getElementById("galscat_u").innerHTML = "/ "+document.querySelector(".category_sgal_u [name=\"category_sgal_u\"]").value;
		document.querySelector(".category_sgal_u [name=\"galscat_u\"]").value = document.querySelector(".category_sgal_u [name=\"category_sgal_u\"]").value;
			
		document.querySelector(".category_ssgal_u").style.display = "block";
		document.getElementById("galsscat_u").innerHTML = "";
		document.querySelector(".category_ssgal_u [name=\"galsscat_u\"]").value = "";
		document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value = "";
	}
}

document.querySelector(".category_sgal_u [del]").onclick = function()
{
		document.getElementById("galscat_u").innerHTML = "";
		document.querySelector(".category_sgal_u [name=\"galscat_u\"]").value = "";
		document.querySelector(".category_sgal_u [name=\"category_sgal_u\"]").value = "";
		
		document.querySelector(".category_ssgal_u").style.display = "none";
		document.getElementById("galsscat_u").innerHTML = "";
		document.querySelector(".category_ssgal_u [name=\"galsscat_u\"]").value = "";
		document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value = "";
}
document.querySelector(".category_ssgal_u [select]").onclick = function()
{
	document.getElementById("catselect_u").style.display = "none"; 
	document.getElementById("scatselect_u").style.display = "none"; 
	if(document.getElementById("sscatselect_u").style.display == "none")
	{
		returnsCatGal_u("catRR="+document.querySelector(".category_gal_u [name=\"galcat_u\"]").value+"#"+document.querySelector(".category_sgal_u [name=\"galscat_u\"]").value,document.getElementById("sscatselect_u"));
		document.querySelector(".category_ssgal_u [select]").style.backgroundImage = "url(./template/images/gal_cat_filter_preloader.GIF)";
	}
	else
		document.getElementById("sscatselect_u").style.display = "none"; 
}

document.getElementById("sscatselect_u").onclick = function(event)
{
	event = event || window.event;
	var target = event.target || event.srcElement;
	if(target.tagName == "DIV" || target.tagName == "B")
	{
		var v = target.getAttribute("value").split("#")[target.getAttribute("value").split("#").length-1];
		document.getElementById("galsscat_u").innerHTML = "/ "+v;
		document.querySelector(".category_ssgal_u [name=\"galsscat_u\"]").value = v;
		document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value = v;
		
		document.getElementById("sscatselect_u").style.display = "none";
	}
}
document.querySelector(".category_ssgal_u [add]").onclick = function()
{
	if(document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value != "")   
	{
		
		document.getElementById("galsscat_u").innerHTML = "/ "+document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value;
		document.querySelector(".category_ssgal_u [name=\"galsscat_u\"]").value = document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value;
		document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value = document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value;
	}
}

document.querySelector(".category_ssgal_u [del]").onclick = function()
{
		document.getElementById("galsscat_u").innerHTML = "";
		document.querySelector(".category_ssgal_u [name=\"galsscat_u\"]").value = "";
		document.querySelector(".category_ssgal_u [name=\"category_ssgal_u\"]").value = "";
}
function returnsCatGal_u(param,elem)
	{
		try { ro = new XMLHttpRequest(); }
		catch(e) { try { ro = new ActiveXObject("Msxml2.XMLHTTP");  }
		catch(e) { ro = new ActiveXObject("Microsoft.XMLHTTP"); } }
		
		ro.open("POST", "<? echo $def_mainlocation; ?>/includes/category_adm.php", true);
		ro.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		
		ro.onreadystatechange = function()
		{
			if((ro.readyState == 4) && (ro.status == 200)) 
			{
				elem.innerHTML = ro.responseText;
				elem.style.display = "";
				if(document.querySelector(".category_gal_u [select]").style.backgroundImage != "")
					document.querySelector(".category_gal_u [select]").style.backgroundImage = "";	
				else if(document.querySelector(".category_sgal_u [select]").style.backgroundImage != "")
					document.querySelector(".category_sgal_u [select]").style.backgroundImage = "";
				else if(document.querySelector(".category_ssgal_u [select]").style.backgroundImage != "")
					document.querySelector(".category_ssgal_u [select]").style.backgroundImage = "";					
			}
		}
		ro.send(param);  
	}
	
	document.querySelector("[name=\"filelload\"]")[(!-[1,])?"onpropertychange":"onchange"] = function()
	{	
		if(document.getElementById("galcat_u").innerHTML.length == 0)
		{
			alert("Вы не указали Фотоальбом");
			return false;
		}
		for(var i = 0; i<this.files.length; i++)
		{
			if (window.FileReader && (this.files[i].type.match(/image\/(jpg|jpeg)/i))) 
			{
				var reader = new FileReader();
				reader["file"] = this.files[i]; 
				reader.onload = function(e) 
				{
					var xhrS = new XMLHttpRequest();
					var fData = new FormData();
					var tfiles = this.file;
					fData.append("galcat_u",document.getElementById("galcat_u").innerHTML);
					fData.append("galscat_u",document.getElementById("galscat_u").innerHTML);
					fData.append("galsscat_u",document.getElementById("galsscat_u").innerHTML);
					fData.append("name",this.file);
                                        fData.append("namefoto",document.getElementById("namefoto").value);
					var element = document.createElement("div");
					xhrS.upload.onloadstart = function()
					{
						// "onloadstart — вызывается в момент начала чтения файла."
						document.querySelector(".filterG").style.display = "none";
						if(document.querySelector(".page_number"))document.querySelector(".page_number").style.display = "none";
						document.querySelector(".formedgal").style.display = "none";
						document.getElementById("updates").style.display = "block";
						element.innerHTML = "<div></div><img src=\""+e.target.result+"\"><span>"+tfiles.name.split(".").slice(0,-1).join()+"</span>";
						document.getElementById("uploadgal").appendChild(element);
					}
							
					xhrS.onreadystatechange = function()
					{
						if (xhrS.readyState == 4) 
						{
							if(xhrS.status == 200) 
							{
								if(xhrS.responseText == "ok")  element.setAttribute("yes","");
								else 
								{
									element.setAttribute("no","");
								}
							} 
							else 
							{
								element.setAttribute("no","");
							}
						}
					}
								
					xhrS.upload.onprogress = function(event)  
					{
						//"onprogress — периодически вызывается в течение чтения файла.";
						var len = (-25-(parseInt(event.loaded/event.total*100)));
						element.children[0].style.left = len+"px";
						element.children[0].style.top = len+"px";
					}
					xhrS.open("POST", "", true);
					xhrS.send(fData);
				}
				reader.readAsDataURL(this.files[i]);
			}
		}
	} 
</script>
<script type="text/javascript">
$(function() {
     $('.edit_p').editable('inc/ajaxnamefoto.php', {
         type      : 'text',
         cancel    : 'Отменить',
         submit    : 'OK',
         style     : 'padding:10px;',
         indicator : '<img src="../images/go.gif">',
         tooltip   : 'Нажмите для изменения...'
     });
     $('.txt').editable('inc/ajaxmessfoto.php', {
         type      : 'textarea',
         cancel    : 'Отменить',
         submit    : 'OK',
         style     : 'padding:10px;',
         rows      : '5',
         indicator : '<img src="../images/go.gif">',
         tooltip   : 'Нажмите для изменения...',
                      data: function(value, settings) {
      /* Convert <br> to newline. */
      var retval = value.replace(/<br[\s\/]?>/gi, '\n');
      return retval;
             }
     });
 });
</script>
<? require_once 'template/footer.php'; ?>
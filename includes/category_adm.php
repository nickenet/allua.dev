<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by construktor7 (D. Zaharov) & D.Madi
=====================================================
 Файл: category_adm.php
-----------------------------------------------------
 Назначение: Категории фотогалереи
=====================================================
*/


include (".././conf/config.php");
include (".././includes/$def_dbtype.php");
include (".././connect.php");

function multicode($str) 
	{
		if (@preg_match('+.+u', $str)) 
		{
			$Array_CP_UTF = Array( 0x80 => 0x402, 0x81 => 0x403,0x82 => 0x201A,0x83 => 0x453, 0x84 => 0x201E, 0x85 => 0x2026,0x86 => 0x2020,0x87 => 0x2021,0x88 => 0x20AC,0x89 => 0x2030,0x8A => 0x409,0x8B => 0x2039,0x8C => 0x40A,0x8D => 0x40C,0x8E => 0x40B,0x8F => 0x40F,0x90 => 0x452,0x91 => 0x2018,0x92 => 0x2019,0x93 => 0x201C,0x94 => 0x201D,0x95 => 0x2022,0x96 => 0x2013,0x97 => 0x2014,0x99 => 0x2122,0x9A => 0x459,0x9B => 0x203A,0x9C => 0x45A,0x9D => 0x45C,0x9E => 0x45B,0x9F => 0x45F,0xA0 => 0xA0,0xA1 => 0x40E,0xA2 => 0x45E,0xA3 => 0x408,0xA4 => 0xA4,0xA5 => 0x490,0xA6 => 0xA6,0xA7 => 0xA7,0xA8 => 0x401,0xA9 => 0xA9,0xAA => 0x404,0xAB => 0xAB,0xAC => 0xAC,0xAD => 0xAD,0xAE => 0xAE,0xAF => 0x407,0xB0 => 0xB0,0xB1 => 0xB1,0xB2 => 0x406,0xB3 => 0x456,0xB4 => 0x491,0xB5 => 0xB5,0xB6 => 0xB6,0xB7 => 0xB7,0xB8 => 0x451,0xB9 => 0x2116,0xBA => 0x454,0xBB => 0xBB,0xBC => 0x458,0xBD => 0x405,0xBE => 0x455,0xBF => 0x457);
			$Array_UTF_CP = array_flip($Array_CP_UTF);
			$strig = "";
			for($i=0; $i<strlen($str); $i++)
			{
				$s = ord($str{$i});
				if($s == 0x0A) $strig .= " ";
				elseif($s == 0x3C || $s == 0x3E)	$strig .= "";
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

header('Content-Type:text/html; charset=windows-1251');
$likeR = "";
$firmsel = "";
if($_POST['catF'])
{
	if($_POST['catF']) $likeR = " and (category regexp '^".(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",multicode(trim($_POST['catF']))))."#[^#]+$'  or category regexp '^".(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",multicode(trim($_POST['catF']))))."#[^#]+#[^#]+$')";
	$r = mysql_query("select distinct substring_index(category,'#',".(preg_match("|#|",$_POST['catF'])?3:2).") as category from $db_foto where (category IS NOT NULL and category != '') ".$likeR." ");
	//print("select distinct substring_index(category,'#',2) as category from $db_foto where (category IS NOT NULL and category != '') ".$likeR." ");
	echo "<option>Все альбомы</option>";
	while($f = mysql_fetch_array($r))
	{
		$CountCat = mysql_result(mysql_query("select count(*) from $db_foto where (category IS NOT NULL and category != '') and (category like '".$f['category']."' or category like '".$f['category']."#%') "),0);
		echo "<option value=\"".$f['category']."\">".substr(strrchr($f['category'],"#"),1)." [".$CountCat."]</option>";
		
	}
} 
else
{
	if(isset($_POST['catRoot']))
	{
		$r = mysql_query("select distinct substring_index(category,'#',1) as category from $db_foto where (category IS NOT NULL and category != '') ".$likeR." ");
		while($f = mysql_fetch_array($r))
		{
			$CountCat = mysql_result(mysql_query("select count(*) from $db_foto where (category IS NOT NULL and category != '') and (category like '".$f['category']."' or category like '".$f['category']."#%') "),0);
			echo "<div value=\"".$f['category']."\">".$f['category']." [".$CountCat."]</div>";
		}
	}
	elseif($_POST['catR']) 
	{
		
		$catR = (preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",multicode(trim($_POST['catR']))));
		$likeR = " and (category like '".$catR."#%')";
		
		$r = mysql_query("select distinct substring_index(category,'#',2) as category from $db_foto where (category IS NOT NULL and category != '') ".$likeR." ");
		
		while($f = mysql_fetch_array($r))
		{
			$CountCat = mysql_result(mysql_query("select count(*) from $db_foto where (category IS NOT NULL and category != '') and (category like '".$f['category']."' or category like '".$f['category']."#%') "),0);
			echo "<div value=\"".$f['category']."\">".strtok(substr(strchr($f['category'],"#"),1),"#")." [".$CountCat."]</div>";
		}
	}
	elseif($_POST['catRR']) 
	{
		$catR = (preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",multicode(trim($_POST['catRR']))));
		$likeR = " and (category like '".$catR."#%')";

		$r = mysql_query("select  category, count(*) from $db_foto where (category IS NOT NULL and category != '') ".$likeR." group by category");
		while($f = mysql_fetch_array($r))
		{
			$CountCat = $f['count(*)'];
			echo "<div value=\"".$f['category']."\">".substr(strrchr($f['category'],"#"),1)." [".$CountCat."]</div>";
		}
	}
}
?>
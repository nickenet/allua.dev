<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by construktor7 (D. Zaharov) & D.Madi
=====================================================
 Файл: foto.php
-----------------------------------------------------
 Назначение: Фотогалерея
=====================================================
*/

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
include ( "./defaults.php" );

if($_POST["imagealbumform"]) 
{
	foreach($_POST as $k=>$v)
	{
		$kvk .= $k."=".preg_replace("|([^0-9a-zA-Z_-]+)|is","",(string)$v).";\n";
	}
	file_put_contents("system/album",$kvk);
	exit;
}
if($_POST["imagefotoalbumform"]) 
{
	foreach($_POST as $k=>$v)
	{
		$kvk .= $k."=".preg_replace("|([^0-9a-zA-Z_-]+)|is","",(string)$v).";\n";
	}
	file_put_contents("system/fotoalbum",$kvk);
	exit;
}
function buildRate($id, $val, $inside = 0)
{
	global $def_mainlocation;
	$val = round($val);
	if (!$inside) $rate_img='<div id="rateWrap'.$id.'" class="rateWrap">';

	$rate_img.='<div id="rate'.$id.'">';
	for ($i = 1; $i <= 5; ++$i) {
                if ($val >= $i) $rateOn='rateOn'; else $rateOn='';
		$rate_img.= "<a href=\"#\" class=\"rateItem $rateOn\"
			onclick=\"return rate($id, $i)\"
			onmouseover=\"seeOn(this)\" onmouseout=\"seeOff(this)\"> </a>";
        }
	$rate_img.= '</div>';
	$rate_img.= '<img id="ratePic'.$id.'" src="'.$def_mainlocation.'/images/go.gif" border="0" style="display: none" align="center">';
	$rate_img.= '<br>';
	if (!$inside) $rate_img.= '</div>';

        return $rate_img;
}

if ( !empty($_REQUEST['rate']) )
{
	$_REQUEST['rate'] = (int)$_REQUEST['rate'];
        $z_rate = $db->query  ( "SELECT rateNum, rateVal FROM $db_foto WHERE num = '$_REQUEST[rate]'" );
        $curFoto = $db->fetcharray  ( $z_rate );
	$tmp = empty($_COOKIE['rateimg']) ? array() : explode(',', $_COOKIE['rateimg']);
	if ( !in_array($_REQUEST['rate'], $tmp) )
	{
		$tmp[] = $_REQUEST['rate'];
		setcookie('rateimg', join(',', $tmp), time() + 24 * 3600,"/");
		$curFoto['rateVal'] = $curFoto['rateNum'] * $curFoto['rateVal'] + (int)$_REQUEST['val'];
		$curFoto['rateVal'] /= ++$curFoto['rateNum'];
                $db->query  ( "UPDATE $db_foto SET rateNum='$curFoto[rateNum]', rateVal='$curFoto[rateVal]' WHERE num='$_REQUEST[rate]' " );
	}

	header('Content-Type: text/html; charset=windows-1251');

	echo 'ok';
	echo buildRate($_REQUEST['rate'], $curFoto['rateVal']);

	return;
}

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_col_foto;
$catlike = "";

	$category = 0;
	$maincategory = "";

	$subcategory = 0;
	$mainsubcategory = "";

	$subsubcategory = 0;
	$mainsubsubcategory = "";

if ($cat != 0) $category = $cat;
if ($subcat != 0)	$subcategory = $subcat;
if ($subsubcat != 0)	$subsubcategory = $subsubcat;
if($_GET['galcatcpu'])
{
	$itr = mysql_query("select * from $db_foto_meta where rewrite='".mysql_real_escape_string($_GET['galcatcpu'])."' ");
	$itf = mysql_fetch_array($itr);
	if($itf['description']) $descriptions_meta = $itf['description'];
	if($itf['keywords']) $keywords_meta = $itf['keywords'];
	if($itf['title']) $incomingline = $itf['title'];
	list($_GET['galcat'],$_GET['galscat'],$_GET['galsscat']) = explode("#",$itf['item']);
        if ($itf['full']) $full_text_foto = $itf['full']; else $full_text_foto=''; 
        if ($itf['object']) $name_object = $itf['object']; else $name_object='';
        if ($itf['map']) $map_foto = $itf['map']; else $map_foto='';
        if ($itf['mapstype']) $mapstype_foto = $itf['mapstype']; else $mapstype_foto='';
               

	if($_GET['galsscat'])
	{
		$catgal = mysql_real_escape_string(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",(string)multicode($_GET['galcat'])));
		$catsgal = mysql_real_escape_string(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",(string)multicode($_GET['galscat'])));
		$catssgal = mysql_real_escape_string(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",(string)multicode($_GET['galsscat'])));
		$catlike = " (category IS NOT NULL and category != '') and (category like '".$catgal."#".$catsgal."#".$catssgal."')";
		$catgalpage = $catgal."/".$catsgal."/".$catssgal;
		
		if(!$descriptions_meta) $descriptions_meta = $catssgal;
		if(!$keywords_meta) $keywords_meta = $catssgal;
		if(!$incomingline) $incomingline = $catssgal;
		
		$titlefotoalbum = '<a href="'.$def_mainlocation.'/foto/">'.$def_title_foto.'</a> / <a href="'.$def_mainlocation.'/foto/'.mysql_result(mysql_query("select rewrite from $db_foto_meta where item='".$catgal."'"),0).'/">'.$catgal.'</a> / <a href="'.$def_mainlocation.'/foto/'.mysql_result(mysql_query("select rewrite from $db_foto_meta where item='".$catgal."#".$catsgal."'"),0).'/">'.$catsgal.'</a> / '.$catssgal;
	}
	elseif($_GET['galscat'])
	{
		$catgal = mysql_real_escape_string(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",(string)multicode($_GET['galcat'])));
		$catsgal = mysql_real_escape_string(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",(string)multicode($_GET['galscat'])));
		$catlike = " (category IS NOT NULL and category != '') and (category like '".$catgal."#".$catsgal."' or category like '".$catgal."#".$catsgal."%')";
		$catgalpage = $catgal."/".$catsgal;
		
		if(!$descriptions_meta) $descriptions_meta = $catsgal;
		if(!$keywords_meta) $keywords_meta = $catsgal;
		if(!$incomingline) $incomingline = $catsgal;
		
		$titlefotoalbum = '<a href="'.$def_mainlocation.'/foto/">'.$def_title_foto.'</a> / <a href="'.$def_mainlocation.'/foto/'.mysql_result(mysql_query("select rewrite from $db_foto_meta where item='".$catgal."'"),0).'/">'.$catgal.'</a> / '.$catsgal;
	}
	elseif($_GET['galcat'])
	{
		$catgalpage = $catgal = mysql_real_escape_string(preg_replace("|([^\)\(\:\,\.\?\!\#\$\%a-zA-ZА-Яа-я0-9_ -]+)|is","",(string)multicode($_GET['galcat'])));
		$catlike = " (category IS NOT NULL and category != '') and (category like '".$catgal."' or category like '".$catgal."#%')";

		if(!$descriptions_meta) $descriptions_meta = $catgal;
		if(!$keywords_meta) $keywords_meta = $catgal;
		if(!$incomingline) $incomingline = $catgal;
		
		$titlefotoalbum = '<a href="'.$def_mainlocation.'/foto/">'.$def_title_foto.'</a> / '.$catgal;
	}
}
else
{
	$titlefotoalbum = $def_title_foto;
	$incomingline = $def_title_foto;
        $descriptions_meta = $def_foto_descriptions_meta;
        $keywords_meta = $def_foto_keywords_meta;	
}

    $r_all = $db->query  ( "SELECT num FROM $db_foto ".((!$catlike)?"":"WHERE")."  ".$catlike );

    @$results_amount_all = mysql_num_rows ( $r_all );

    $rz = $db->query  ( "SELECT * FROM $db_foto ".((!$catlike)?"":"WHERE")." ".(($catlike)?$catlike:"")." ORDER BY sort, num DESC LIMIT $page1, $def_col_foto" );

    @$results_amount = mysql_num_rows ( $rz );

$help_section = $foto_help;

$titlefotoalbum = '
				  <div id="imagealbumh">
					<div id="imagealbumsetting">
						<span></span>
						<nobr>'.$titlefotoalbum.'</nobr>
					</div>
					<div id="imagealbumsize">
					
					</div>
					<div id="imagealbumeffect">
					
					</div>
					<div id="imagealbumnumbereffect">
					
					</div>
					<div id="imagealbumsettingeffect">
					
					</div>
				  </div>';
if ( $results_amount > 0 )
{

$show_banner="NO";

include ( "./template/$def_template/header.php" );

?>
<link rel="stylesheet" href="<? echo $def_mainlocation; ?>/images/gallery/gallery.css">
<link rel="stylesheet" href="<? echo $def_mainlocation; ?>/images/gallery/gallery_effect.css">
<script type="text/javascript" src="<? echo $def_mainlocation; ?>/images/gallery/gallery.js"></script>
<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/rate.js"></script>
<link rel="stylesheet" href="<? echo "$def_mainlocation/includes/css/"; ?>rate.css">
<?php
function imagealbumecho($prefix,$id)
{
		$f = file("system/".$id);
	
	foreach($f as $v)
	{
		
		$coc = strtok($v,"=");
		if(isset($_COOKIE[$coc]) && $id == 0) 
		{
			$r .= str_replace($prefix,"",$coc)."=\"".$_COOKIE[$coc]."\" ";
		}
                else { $r .= str_replace("=","=\"",str_replace(";","\"",str_replace($prefix,"",$v)))." "; }
	}
	return $r;
}
$imagealbumdiv = '<div class="imagealbum" '.imagealbumecho("imagealbum","album").'>';


		if($_GET['galscat'] && !$_GET['galsscat'])
		{
			$rgal = mysql_query("select substring_index($db_foto.category,'#',3) as category,  max(".$db_foto.".num)  as num, $db_foto_meta.rewrite, count(*) from $db_foto left join $db_foto_meta on substring_index($db_foto.category,'#',3)=$db_foto_meta.item where (category IS NOT NULL and category != '') and (category like '".$catgal."#".$catsgal."#%') group by substring_index(category,'#',3)");
			
			if(mysql_num_rows ( $rgal ) > 0)
			{
				$imagealbumh = true;
				main_table_top_gal($titlefotoalbum); 
				echo $imagealbumdiv;
                                require 'includes/sub_component/top_fotogallery.php';
				while($fgal = mysql_fetch_array($rgal))
				{
					
					$CountCat = $fgal['count(*)'];
					$split2 = explode("#",substr(strchr($fgal['category'],"#"),1)); 
					?>
					<div class="ih-item">
						<a href="<? 
							echo $def_mainlocation.'/foto/'.$fgal['rewrite'].'/'; 
						?>">
							<div class="spinner"></div>
							<div class="mask1"></div>
							<div class="mask2"></div>
							<div class="img-container"> 
								<div class="img">
									<span>
										<img src="<? echo $def_mainlocation;?>/foto/s_<? echo $fgal['num']; ?>.jpg" border="0" alt="<? echo strtok(substr(strchr($fgal['category'],"#"),1),"#"); ?>" title="<? echo $CountCat.' фото'; ?>">
									</span>
								</div>
							</div> 
							<div class="info-container">
								<div class="info">
									<div class="info-back">
										<h3><? echo $split2[1]; ?></h3>
										<p><? echo $CountCat.' '.$def_num_foto; ?></p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<?php
				}
				echo'</div>';
			}
			else { main_table_top_gal($titlefotoalbum); require 'includes/sub_component/top_fotogallery.php'; }
		}
		elseif($_GET['galcat'] && !$_GET['galsscat'])
		{
			$rgal = mysql_query("select substring_index($db_foto.category,'#',2) as category,  max(".$db_foto.".num)  as num,  $db_foto_meta.rewrite, count(*) from $db_foto left join  $db_foto_meta on substring_index($db_foto.category,'#',2)=$db_foto_meta.item where (category IS NOT NULL and category != '') and (category like '".$catgal."#%') group by substring_index(category,'#',2)");
			if(mysql_num_rows ( $rgal ) > 0)
			{
				$imagealbumh = true;
				 main_table_top_gal($titlefotoalbum); 
				echo $imagealbumdiv;
                                require 'includes/sub_component/top_fotogallery.php';
				while($fgal = mysql_fetch_array($rgal))
				{
					$CountCat = $fgal['count(*)'];
					?>
					<div class="ih-item">
						<a href="<? 
							echo $def_mainlocation.'/foto/'.$fgal['rewrite'].'/'; 
						?>">
							<div class="spinner"></div>
							<div class="mask1"></div>
							<div class="mask2"></div>
							<div class="img-container"> 
								<div class="img">
									<span>
										<img src="<? echo $def_mainlocation;?>/foto/s_<? echo $fgal['num']; ?>.jpg" border="0" alt="<? echo strtok(substr(strchr($fgal['category'],"#"),1),"#"); ?>" title="<? echo $CountCat.' фото'; ?>">
									</span>
								</div>
							</div> 
							<div class="info-container">
								<div class="info">
									<div class="info-back">
										<h3><? echo strtok(substr(strchr($fgal['category'],"#"),1),"#"); ?></h3>
										<p><? echo $CountCat.' фото'; ?></p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<?php
				}
				echo'</div>';
			}
                        else { main_table_top_gal($titlefotoalbum); require 'includes/sub_component/top_fotogallery.php'; }                                                    
		}
		elseif(!$_GET['galsscat'])
		{                    			
			$rgal = mysql_query("select substring_index($db_foto.category,'#',1) as category,  max(".$db_foto.".num) as num, $db_foto_meta.rewrite, count(*) from $db_foto left join  $db_foto_meta on substring_index($db_foto.category,'#',1)=$db_foto_meta.item where (category IS NOT NULL and category != '') group by substring_index(category,'#',1)");

			$rgalw = mysql_query("select substring_index($db_foto.category,'#',1) as category, max(".$db_foto.".num) as num,  count(*) from $db_foto ");
			
			if(mysql_num_rows ( $rgal ) > 0)
			{			
				$imagealbumh = true;
				main_table_top_gal($titlefotoalbum); 
				echo $imagealbumdiv;
                                require 'includes/sub_component/top_fotogallery.php';
				while($fgal = mysql_fetch_array($rgal))
				{
					$CountCat = $fgal['count(*)'];
					?>
					<div class="ih-item">
						<a href="<? 
							echo $def_mainlocation.'/foto/'.$fgal['rewrite'].'/'; 
						?>">
							<div class="spinner"></div>
							<div class="mask1"></div>
							<div class="mask2"></div>
							<div class="img-container"> 
								<div class="img">
									<span>
										<img src="<? echo $def_mainlocation;?>/foto/s_<? echo $fgal['num']; ?>.jpg" border="0" alt="<? echo $fgal['category']; ?>" title="<? echo $CountCat.' фото'; ?>">
									</span>
								</div>
							</div> 
							<div class="info-container">
								<div class="info">
									<div class="info-back">
										<h3><? echo $fgal['category']; ?></h3>
										<p><? echo $CountCat.' '.$def_num_foto; ?></p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<?php
				}
				echo'</div>';
			}
                        else { main_table_top_gal($titlefotoalbum); }                        
		}
                else { main_table_top_gal($titlefotoalbum);  require 'includes/sub_component/top_fotogallery.php'; }
		
		main_table_bottom_gal(); 
		
	$def_images = '<div id="imagefotoalbumh">
		<div id="imagefotoalbumsetting">
			<span></span>
			<nobr>'.$def_images.'</nobr>
		</div>
		<div id="imagefotoalbumsize">
		
		</div>
		<div id="imagefotoalbumeffect">
		
		</div>
		<div id="imagefotoalbumnumbereffect">
		
		</div>
		<div id="imagefotoalbumsettingeffect">
		
		</div>
		<div id="imagefotoalbumtype" style="display: none">
			<div class="imagetotoleft"></div>
			<div class="imagetotoright"></div>
			<div class="imagetotocenter"></div>
		</div>
	  </div>
	';
        main_table_top_gal($def_images);?>
      
	  <?php

		echo '<div class="imagefotoalbum" '.imagealbumecho("imagefotoalbum","fotoalbum").'>';
		for ($ig=0; $ig<$results_amount; $ig++ )
		{
			$fz = $db->fetcharray  ( $rz );
			?>
			<div class="ih-item">
			<? echo buildRate($fz['num'], $fz['rateVal']); ?>
				<a class="galcatimage" href="<? echo $def_mainlocation;?>/foto/<? echo $fz['num']; ?>.jpg" alt="<? echo $fz['item']; ?>">
					<div class="spinner"></div>
					<div class="mask1"></div>
					<div class="mask2"></div>
					<div class="img-container"> 
						<div class="img">
							<span>
								<img src="<? echo $def_mainlocation;?>/foto/s_<? echo $fz['num']; ?>.jpg" border="0" alt="<? echo $fz['item']; ?>" title="<? echo $fz['message']; ?>">
							</span>
						</div>
					</div> 
					<div class="info-container">
						<div class="info">
							<div class="info-back">
								<h3><? echo $fz['item']; ?></h3>
								<p><? echo $fz['message']; ?></p>
							</div>
						</div>
					</div>
				</a>
			</div>
			<?php	
		}
		echo'</div>';
    

        echo '<br><br>';

	if ( $results_amount_all > $def_col_foto )

	{
                $prev_page=''; $page_news=''; $next_page='';

		if ((($kPage*$def_col_foto)-($def_col_foto*5)) >= 0) $first=($kPage*$def_col_foto)-($def_col_foto*5);
		else $first=0;

		if ((($kPage*$def_col_foto)+($def_col_foto*6)) <= $results_amount_all) $last =($kPage*$def_col_foto)+($def_col_foto*6);
		else $last = $results_amount_all;

		@$z=$first/$def_col_foto;

		if ($kPage > 0) 
		{
			$z_prev=$kPage-1;
			if($_GET['galcatcpu'])
				$prev_page = '<a href="'.$def_mainlocation.'/foto/'.$_GET['galcatcpu'].'/'.(($z_prev==0)?0:($kPage-1)).'.html"><b>'.$def_previous.'</b></a>&nbsp;';	
			else
				$prev_page = '<a href="'.$def_mainlocation.'/foto/'.(($z_prev==0)?0:($kPage-1)).'.html"><b>'.$def_previous.'</b></a>&nbsp;';	
			
		}
		$page_news = '';
		for ( $x=$first; $x<$last;$x=$x+$def_col_foto )
		{
			if ( $z == $kPage )
			{
				$page_news .= '[ <b>'.($z+1).'</b> ]&nbsp;';
			}
			else
			{
				if($_GET['galcatcpu'])
					$page_news .= '<a href="'.$def_mainlocation.'/foto/'.$_GET['galcatcpu'].'/'.(($z==0)?0:($z)).'.html"><b>'.($z+1).'</b></a>&nbsp;';
				else
					$page_news .= '<a href="'.$def_mainlocation.'/foto/'.(($z==0)?0:($z)).'.html"><b>'.($z+1).'</b></a>&nbsp;';
			}
			$z++;
		}
		if ($kPage - (($results_amount_all / $def_col_foto) - 1) < 0)
		{
			if($_GET['galcatcpu'])
				$next_page = '<a href="'.$def_mainlocation.'/foto/'.$_GET['galcatcpu'].'/'.($kPage+1).'.html"><b>'.$def_next.'</b></a>';
			else
				$next_page = '<a href="'.$def_mainlocation.'/foto/'.($kPage+1).'.html"><b>'.$def_next.'</b></a>';
		}

        
        include ( "./template/$def_template/pages.php" ); // подключаем обработку страниц        
                
        $template_page_news = implode ('', file('./template/' . $def_template . '/pages.tpl'));

        $template_pages = new Template;

        $template_pages->load($template_page_news);

        $template_pages->replace("prev", $prev_page);
        $template_pages->replace("next", $next_page);
        $template_pages->replace("page", $page_news);

        $template_pages->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_pages->publish();        

	}
        
        if (!$_GET['galcat'] and $kPage==0) include ( "./template/$def_template/main_foto.php" );
}

else 

{
	$incomingline = '<a href="'.$def_mainlocation.'"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> |'.$def_title_foto;
        $incomingline_firm = $def_title_foto;
        $incomingline = $def_title_foto;
        $descriptions_meta = $def_foto_descriptions_meta;
            include ( "./template/$def_template/header.php" );
            $def_title_error = $def_title_error_foto; 
            $def_message_error = $def_error_foto_main;
                include ( "./includes/error_page.php" );
            include ( "./template/$def_template/footer.php" );
}
?>
<script>
var kshover = {
	"circle" : {
		"effect" : {
			"0" : {},
			"1" : {
				"recurse" : "on"
			},
			"2" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"3" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"4" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"5" : {
				"recurse" : "on",
				"run" : Array("vertical", "horizontal")
			},
			"6" : {
				"recurse" : "on",
				"run" : Array("scale_down_up", "scale_up", "scale_down")
			},
			"7" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"8" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"9" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"10" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "top_to_bottom")
			},
			"11" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"12" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"13" : {
				"recurse" : "on",
				"run" : Array("from_left_and_right", "top_down_to_center", "center_to_top_down","top_to_bottom", "bottom_to_top")
			},
			"14" : { 
				"recurse" : "on",
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"15" : {
				"recurse" : "on"
			},
			"16" : {
				"run" : Array("left_to_right", "right_to_left")
			},
			"17" : {
				"recurse" : "on"
			},
			"18" : {
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"19" : {
				"recurse" : "on"
			},
			"20" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "left_to_right", "right_to_left", "top_to_bottom")
			},
			"21" : {
				"recurse" : "on"
			},
			"22" : {},
			"23" : {
				"recurse" : "on"
			}
		}
	},
	"square" : {
		"effect" : {
			"0" : {},
			"1" : {
				"recurse" : "on",
				"run" : Array("left_and_right", "top_to_bottom", "bottom_to_top")
			},
			"2" : {
				"recurse" : "on"
			},
			"3" : {
				"recurse" : "on",
				"run" : Array("top_to_bottom", "bottom_to_top")
			},
			"4" : {
				"recurse" : "on"
			},
			"5" : {
				"recurse" : "on",
				"run" : Array("left_to_right", "right_to_left")
			},
			"6" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "top_to_bottom", "from_left_and_right", "from_top_and_bottom")
			},
			"7" : {
				"recurse" : "on"
			},
			"8" : {
				"recurse" : "on",
				"run" : Array("scale_down", "scale_up")
			},
			"9" : {
				"recurse" : "on",
				"run" : Array("left_to_right", "right_to_left", "top_to_bottom", "bottom_to_top")
			},
			"10" : {
				"recurse" : "on",
				"run" : Array("left_to_right", "right_to_left", "top_to_bottom", "bottom_to_top")
			},
			"11" : {
				"recurse" : "on",
				"run" : Array("left_to_right", "right_to_left", "top_to_bottom", "bottom_to_top")
			},
			"12" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "top_to_bottom", "right_to_left", "left_to_right")
			},
			"13" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "top_to_bottom", "right_to_left", "left_to_right")
			},
			"14" : {
				"recurse" : "on",
				"run" : Array("bottom_to_top", "top_to_bottom", "right_to_left", "left_to_right")
			},
			"15" : {
				"recurse" : "on",
				"run" : Array("left_to_right", "right_to_left", "top_to_bottom", "bottom_to_top")
			}
		}
	},
	"form" : Array("circle","square","revers","save"),
	"size" : Array("top-left","top","top-right","left","center","right","bottom-left","bottom","bottom-right"),
	"close" : "windows,new,present,mobile",
	"prefix": 
	{
		"aero": {borderSize:51,overlayOpacity:0.5},
		"tinting": {borderSize:21},
		"windows": {borderSize:57},
		"natural": {},
		"public": {borderSize:21},
		"grey": {borderSize:16},
		"new": {},
		"retro": {},
		"minimalism": {},
		"run": {},
		"plain": {},
		"present": {},
		"metro": {},
		"opacity": {},
		"bright": {},
		"power": {},
		"contact": {},
		"robot": {},
		"blue": {},
		"board": {},
		"shadow": {},
		"bookmark": {},
		"white": {},
		"black": {},
		"mobile": {borderSize:57},
		"standart": {}
	},
	"save" : Array("form","effect","revers","size","run","prefix"),
	"click" : false,
	"saves" : false
}
	
	$().galleryKS(kshover.prefix[$(".imagefotoalbum").attr("prefix")]);
	
var ksamimate = function(ar,i,parentelement,ii,iii,f,el)
{
	var newdir = document.createElement("div");
	parentelement.appendChild(newdir);
	newdir.setAttribute(ar[i].toString(),"");
	var vii = ii;
	var Iid = setInterval(function()
	{
		vii = vii+30;
		
		newdir.style.MozTransform = 'rotate3d(0, 1, 0, '+vii+'deg)';
		newdir.style.WebkitTransform = 'rotate3d(0, 1, 0, '+vii+'deg)';
		newdir.style.OTransform = 'rotate3d(0, 1, 0, '+vii+'deg)';
		newdir.style.MsTransform = 'rotate3d(0, 1, 0, '+vii+'deg)';
		newdir.style.transform = 'rotate3d(0, 1, 0, '+vii+'deg)';
		
		if(vii == iii)
		{
			if(ar[++i]) ksamimate(ar,i,parentelement,ii,iii,f,el);
			else if(typeof f == "function") f();
			clearInterval(Iid);
			
		}
		
	},20); 
}
var ksamimateoff = function(parentelement,ii,iii,f)
{
	var newdir = parentelement.children[parentelement.children.length-1];
	var vii = ii;
	var Iid = setInterval(function()
	{
		vii = vii-30;
		
		newdir.style.MozTransform = 'rotate3d(0, 1, 0, '+vii+'deg)';
		newdir.style.WebkitTransform = 'rotate3d(0, 1, 0, '+vii+'deg)';
		newdir.style.OTransform = 'rotate3d(0, 1, 0, '+vii+'deg)';
		newdir.style.MsTransform = 'rotate3d(0, 1, 0, '+vii+'deg)';
		newdir.style.transform = 'rotate3d(0, 1, 0, '+vii+'deg)';
		
		if(vii == iii)
		{
			parentelement.removeChild(newdir);
			if(parentelement.children.length > 0) ksamimateoff(parentelement,ii,iii,f);
			else if(typeof f == "function") f();
			clearInterval(Iid);
		}
	},20); 
}
<? if($imagealbumh) { ?>

	document.querySelector("#imagealbumsetting > span").onclick = function ()
	{
		if(kshover.click) return false;
		kshover.click = true;
		if(document.getElementById("imagealbumsize").offsetHeight == 0)
		{
			var i = 7;
			var ii = 7;
			var f = function()
			{
				document.querySelector("#imagealbumsize > div["+document.querySelector(".imagealbum").getAttribute("size")+"]").setAttribute("on","");
				document.querySelector("#imagealbumeffect > div["+document.querySelector(".imagealbum").getAttribute("form")+"]").setAttribute("on","");
				if(document.querySelector(".imagealbum").getAttribute("revers") == "on") document.querySelector("#imagealbumeffect > div[revers]").setAttribute("on","");
				kshover.click = false;
			}
			var Iid = setInterval(function()
			{
				i--;
				if(i>0)
				{
					document.querySelector("#imagealbumsetting > nobr").style.MozTransform = 'rotate3d(0, 1, 0, '+(90-(i*10))+'deg)';
					document.querySelector("#imagealbumsetting > nobr").style.WebkitTransform = 'rotate3d(0, 1, 0, '+(90-(i*10))+'deg)';
					document.querySelector("#imagealbumsetting > nobr").style.OTransform = 'rotate3d(0, 1, 0, '+(90-(i*10))+'deg)';
					document.querySelector("#imagealbumsetting > nobr").style.MsTransform = 'rotate3d(0, 1, 0, '+(90-(i*10))+'deg)';
					document.querySelector("#imagealbumsetting > nobr").style.transform = 'rotate3d(0, 1, 0, '+(90-(i*10))+'deg)';
					document.getElementById("imagealbumsize").style.height = (document.getElementById("imagealbumsize").offsetHeight+8)+"px";
				}
				else
				{
					document.querySelector("#imagealbumsetting > nobr").style.display = "none";
					document.getElementById("imagealbumsize").style.backgroundPosition = -((--ii)*5)+"px center";
				}
				if(i==-7) 
				{
					
					clearInterval(Iid);
					ksamimate(kshover.size,0,document.getElementById("imagealbumsize"),90,180,f,document.querySelector(".imagealbum"));
					ksamimate(kshover.form,0,document.getElementById("imagealbumeffect"),90,180,false,document.querySelector(".imagealbum"));
					document.getElementById("imagealbumsetting").setAttribute("on","");
				}
			},20); 
		}
		else
		{
			function f()
			{
				var i = 7;
				var ii = 0;
				document.querySelector("#imagealbumsetting > nobr").style.display = "inline-block";
				var Iid = setInterval(function()
				{
					i--;
					if(i<0)
					{
						document.getElementById("imagealbumsize").style.height = (document.getElementById("imagealbumsize").offsetHeight-8)+"px";
					}
					else
					{
						document.querySelector("#imagealbumsetting > nobr").style.MozTransform = 'rotate3d(0, 1, 0, '+(i*10)+'deg)';
						document.querySelector("#imagealbumsetting > nobr").style.WebkitTransform = 'rotate3d(0, 1, 0, '+(i*10)+'deg)';
						document.querySelector("#imagealbumsetting > nobr").style.OTransform = 'rotate3d(0, 1, 0, '+(i*10)+'deg)';
						document.querySelector("#imagealbumsetting > nobr").style.MsTransform = 'rotate3d(0, 1, 0, '+(i*10)+'deg)';
						document.querySelector("#imagealbumsetting > nobr").style.transform = 'rotate3d(0, 1, 0, '+(i*10)+'deg)';
						document.getElementById("imagealbumsize").style.backgroundPosition =  -((++ii)*5)+"px center";
					}
					if(i==-7) 
					{
						clearInterval(Iid);
						document.querySelector("#imagealbumsetting > nobr").style.MozTransform = 'rotate3d(0, 1, 0, 0deg)';
						document.querySelector("#imagealbumsetting > nobr").style.WebkitTransform = 'rotate3d(0, 1, 0, 0deg)';
						document.querySelector("#imagealbumsetting > nobr").style.OTransform = 'rotate3d(0, 1, 0, 0deg)';
						document.querySelector("#imagealbumsetting > nobr").style.MsTransform = 'rotate3d(0, 1, 0, 0deg)';
						document.querySelector("#imagealbumsetting > nobr").style.transform = 'rotate3d(0, 1, 0, 0deg)';
						kshover.click = false;
					}
				},20); 
			}
			ksamimateoff(document.getElementById("imagealbumsize"),180,90,f);
			ksamimateoff(document.getElementById("imagealbumeffect"),180,90,false);
			document.getElementById("imagealbumsetting").removeAttribute("on");
			if(document.getElementById("imagealbumsettingeffect").children.length > 0)	
				ksamimateoff(document.getElementById("imagealbumsettingeffect"),360,90,false);
			if(document.getElementById("imagealbumnumbereffect").children.length > 0)
				ksamimateoff(document.getElementById("imagealbumnumbereffect"),360,90,false);
		}
	}
	document.querySelector("#imagealbumeffect").onclick = function(event)
	{
		if(kshover.click) return false;
		kshover.click = true;
		event = event || window.event;	
		var target = event.target || event.srcElement;
		if(target.hasAttribute("revers"))
		{
			if(document.querySelector(".imagealbum").getAttribute("revers") == "on")
			{
				target.removeAttribute("on");
				document.querySelector(".imagealbum").setAttribute("revers","");
			}
			else
			{
				document.querySelector(".imagealbum").setAttribute("revers","on");
				target.setAttribute("on","");
			}
			kshover.click = false;
		}
		else if(target.hasAttribute("circle"))
		{
			target.setAttribute("on","");
			if(document.querySelector("#imagealbumeffect > div[square]").hasAttribute("on")) 
				document.querySelector("#imagealbumeffect > div[square]").removeAttribute("on");
			if(document.getElementById("imagealbumsettingeffect").children.length > 0)	
				ksamimateoff(document.getElementById("imagealbumsettingeffect"),360,90,false);
		
			document.querySelector(".imagealbum").setAttribute("effect","0");
			document.querySelector(".imagealbum").setAttribute("revers","");
			if(document.querySelector("#imagealbumeffect > div[revers]").hasAttribute("on")) 
				document.querySelector("#imagealbumeffect > div[revers]").removeAttribute("on");
			document.querySelector("#imagealbumeffect > div[revers]").style.display = "none";
			var aa = Array();
			Object.keys(kshover.circle.effect).forEach(function(a,b,c){ aa[b] = "e"+c[b];});
			document.querySelector(".imagealbum").setAttribute("form","circle");
			if(document.getElementById("imagealbumnumbereffect").children.length > 0)
			{
				var f = function() 
				{ 
					document.getElementById("imagealbumnumbereffect").setAttribute("forms","circle");
					var f2 = function()
					{
						document.querySelector("#imagealbumnumbereffect > div[e"+document.querySelector(".imagealbum").getAttribute("effect")+"]").setAttribute("on","");
						kshover.click = false;
					}
					return ksamimate(aa,0,document.getElementById("imagealbumnumbereffect"),90,360,f2,document.querySelector(".imagealbum")); 
				}
				ksamimateoff(document.getElementById("imagealbumnumbereffect"),360,90,f);
			}
			else 
			{
				document.getElementById("imagealbumnumbereffect").setAttribute("forms","circle");
				var f = function()
				{
					document.querySelector("#imagealbumnumbereffect > div[e"+document.querySelector(".imagealbum").getAttribute("effect")+"]").setAttribute("on","");
					kshover.click = false;
				}
				ksamimate(aa,0,document.getElementById("imagealbumnumbereffect"),90,360,f,document.querySelector(".imagealbum"));
			}
		}	
		else if(target.hasAttribute("square"))
		{
			target.setAttribute("on","");
			if(document.querySelector("#imagealbumeffect > div[circle]").hasAttribute("on")) 
				document.querySelector("#imagealbumeffect > div[circle]").removeAttribute("on");
			if(document.getElementById("imagealbumsettingeffect").children.length > 0)	
				ksamimateoff(document.getElementById("imagealbumsettingeffect"),360,90,false);
			
			document.querySelector(".imagealbum").setAttribute("effect","0");
			document.querySelector(".imagealbum").setAttribute("revers","");
			if(document.querySelector("#imagealbumeffect > div[revers]").hasAttribute("on")) 
				document.querySelector("#imagealbumeffect > div[revers]").removeAttribute("on");
			document.querySelector("#imagealbumeffect > div[revers]").style.display = "none";
			var aa = Array();
			Object.keys(kshover.square.effect).forEach(function(a,b,c){ aa[b] = "e"+c[b];});
			document.querySelector(".imagealbum").setAttribute("form","square");
			if(document.getElementById("imagealbumnumbereffect").children.length > 0)
			{
				var f = function() 
				{
					var f2 = function()
					{
						document.querySelector("#imagealbumnumbereffect > div[e"+document.querySelector(".imagealbum").getAttribute("effect")+"]").setAttribute("on","");
						kshover.click = false;
					}
					document.getElementById("imagealbumnumbereffect").setAttribute("forms","square");
					return ksamimate(aa,0,document.getElementById("imagealbumnumbereffect"),90,360,f2,document.querySelector(".imagealbum")); 
				}
				ksamimateoff(document.getElementById("imagealbumnumbereffect"),360,90,f);
			}
			else 
			{
				document.getElementById("imagealbumnumbereffect").setAttribute("forms","square");
				var f = function()
				{
					document.querySelector("#imagealbumnumbereffect > div[e"+document.querySelector(".imagealbum").getAttribute("effect")+"]").setAttribute("on","");
					kshover.click = false;
				}
				ksamimate(aa,0,document.getElementById("imagealbumnumbereffect"),90,360,f,document.querySelector(".imagealbum"));
			}
		}
		else if(target.hasAttribute("save"))
		{
			if(kshover.saves) {kshover.click = false; return false; }
			var saves = "";
			for(v in kshover.save)
			{
				saves += "imagealbum"+kshover.save[v]+"="+document.querySelector(".imagealbum").getAttribute(kshover.save[v])+"&";
				document.cookie = "imagealbum"+kshover.save[v]+"="+document.querySelector(".imagealbum").getAttribute(kshover.save[v])+"; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
			}
			<? if($_SESSION["admin_login"]) { ?>
				try { ro = new XMLHttpRequest(); }
				catch(e) { try { ro = new ActiveXObject("Msxml2.XMLHTTP");  }
				catch(e) { ro = new ActiveXObject("Microsoft.XMLHTTP"); } }
				ro.open("POST", "<? echo $def_mainlocation; ?>/foto.php?"+Math.random().toString(), true);
				ro.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				kshover.saves = true;
				t = target;
				t.setAttribute("go","");
				ro.onreadystatechange = function()
				{
					if((ro.readyState == 4) && (ro.status == 200)) 
					{ 
						kshover.saves = false;
						t.removeAttribute("go");
						t.setAttribute("yes","");
						setTimeout(function(){ t.removeAttribute("yes");}, 7000);
					}
					else if((ro.readyState == 4) && (ro.status != 200 && ro.status != 0))
					{
						kshover.saves = false;
						t.removeAttribute("go");
						t.setAttribute("no","");
						setTimeout(function(){ t.removeAttribute("no"); }, 7000);
					}
				}
				ro.send(saves);
			<? } else { ?>
			kshover.saves = false;
			<? } ?>
			kshover.click = false;
		}
	}
	document.getElementById("imagealbumsize").onclick = function(event)
	{

		event = event || window.event;	
		var target = event.target || event.srcElement;
		for(s in kshover.size) 
		{
			if(document.querySelector("#imagealbumsize > div["+kshover.size[s]+"]") == target)
			{
				if(document.querySelector("#imagealbumsize > div[on]")) document.querySelector("#imagealbumsize > div[on]").removeAttribute("on");
				target.setAttribute("on","");
				document.querySelector(".imagealbum").setAttribute("size",kshover.size[s]);
			}
		}
	}
	document.querySelector("#imagealbumnumbereffect").onclick = function(event)
	{
		if(kshover.click) return false;
		kshover.click = true;
		event = event || window.event;	
		var target = event.target || event.srcElement;
		if(document.querySelector("#imagealbumnumbereffect") != target)
		{
			var ob = kshover[document.querySelector(".imagealbum").getAttribute("form")].effect[target.attributes[0].name.substr(1)];
			if(ob.recurse == "on")
				document.querySelector("#imagealbumeffect > div[revers]").style.display = "block";
			else
				document.querySelector("#imagealbumeffect > div[revers]").style.display = "none";
				
			if(document.getElementById("imagealbumsettingeffect").children.length > 0)
			{
				var f = function()
				{
					if(ob.run) 
					{
						var f2 = function()
						{
							document.querySelector("#imagealbumsettingeffect > div["+ob.run[0]+"]").setAttribute("on","");
							document.querySelector(".imagealbum").setAttribute("run",ob.run[0]);
						}
						return ksamimate(ob.run,0,document.getElementById("imagealbumsettingeffect"),90,360,f2,document.querySelector(".imagealbum"));
					}
				}
				ksamimateoff(document.getElementById("imagealbumsettingeffect"),360,90,f);
			}
			else if(ob.run) 
			{
				var f2 = function()
				{
					document.querySelector("#imagealbumsettingeffect > div["+ob.run[0]+"]").setAttribute("on","");
					document.querySelector(".imagealbum").setAttribute("run",ob.run[0]);
				}
				ksamimate(ob.run,0,document.getElementById("imagealbumsettingeffect"),90,360,f2,document.querySelector(".imagealbum"));	
			}
			
			if(document.querySelector("#imagealbumnumbereffect > div[on]"))
				document.querySelector("#imagealbumnumbereffect > div[on]").removeAttribute("on");
				
			target.setAttribute("on","");
			document.querySelector(".imagealbum").setAttribute("effect",target.attributes[0].name.substr(1));
		}
		kshover.click = false;
	}
	document.getElementById("imagealbumsettingeffect").onclick = function()
	{
		event = event || window.event;	
		var target = event.target || event.srcElement;
		if(document.querySelector("#imagealbumsettingeffect") != target)
		{
			document.querySelector(".imagealbum").setAttribute("run",target.attributes[0].name);
			document.querySelector("#imagealbumsettingeffect > div[on]").removeAttribute("on")
			document.querySelector("#imagealbumsettingeffect > div["+target.attributes[0].name+"]").setAttribute("on","");
		}
	}
<? } ?>

	document.querySelector("#imagefotoalbumsetting > span").onclick = function ()
	{
		if(kshover.click) return false;
		kshover.click = true;
		if(document.getElementById("imagefotoalbumsize").offsetHeight == 0)
		{
			
			var i = 7;
			var ii = 7;
			document.getElementById("imagefotoalbumtype").style.width = "0%";
			document.getElementById("imagefotoalbumtype").style.display = "block";
			document.querySelector(".imagetotocenter").style.backgroundImage = "url(<? echo $def_mainlocation;?>/images/gallery/"+$(".imagefotoalbum").attr("prefix")+".jpg)";
			var Iid = setInterval(function()
			{
				if(parseInt(document.getElementById("imagefotoalbumtype").style.width) != 100)
					document.getElementById("imagefotoalbumtype").style.width = (parseInt(document.getElementById("imagefotoalbumtype").style.width)+20)+"%";
					
				i--;
				if(i>0)
				{
					document.querySelector("#imagefotoalbumsetting > nobr").style.MozTransform = 'rotate3d(0, 1, 0, '+(90-(i*10))+'deg)';
					document.querySelector("#imagefotoalbumsetting > nobr").style.WebkitTransform = 'rotate3d(0, 1, 0, '+(90-(i*10))+'deg)';
					document.querySelector("#imagefotoalbumsetting > nobr").style.OTransform = 'rotate3d(0, 1, 0, '+(90-(i*10))+'deg)';
					document.querySelector("#imagefotoalbumsetting > nobr").style.MsTransform = 'rotate3d(0, 1, 0, '+(90-(i*10))+'deg)';
					document.querySelector("#imagefotoalbumsetting > nobr").style.transform = 'rotate3d(0, 1, 0, '+(90-(i*10))+'deg)';
					document.getElementById("imagefotoalbumsize").style.height = (document.getElementById("imagefotoalbumsize").offsetHeight+8)+"px";
				}
				else 
				{
					document.querySelector("#imagefotoalbumsetting > nobr").style.display = "none";
					document.getElementById("imagefotoalbumsize").style.backgroundPosition = -((--ii)*5)+"px center";
				}
				if(i==-7) 
				{
					var f = function()
					{ 
						document.querySelector("#imagefotoalbumsize > div["+document.querySelector(".imagefotoalbum").getAttribute("size")+"]").setAttribute("on","");
						document.querySelector("#imagefotoalbumeffect > div["+document.querySelector(".imagefotoalbum").getAttribute("form")+"]").setAttribute("on","");
						if(document.querySelector(".imagefotoalbum").getAttribute("revers") == "on") document.querySelector("#imagefotoalbumeffect > div[revers]").setAttribute("on","");
						kshover.click = false;
					}
					clearInterval(Iid);
					ksamimate(kshover.size,0,document.getElementById("imagefotoalbumsize"),90,180,f,document.querySelector(".imagefotoalbum"));
					ksamimate(kshover.form,0,document.getElementById("imagefotoalbumeffect"),90,180,false,document.querySelector(".imagefotoalbum"));
					document.getElementById("imagefotoalbumsetting").setAttribute("on","");
				}
			},20); 
		}
		else
		{
			function f()
			{
				
				var i = 7;
				var ii = 0;
			
				document.getElementById("imagefotoalbumtype").style.width = "100%";
				document.querySelector("#imagefotoalbumsetting > nobr").style.display = "inline-block";
				var Iid = setInterval(function()
				{
					i--;
					if(i<0)
					{ 
						document.getElementById("imagefotoalbumsize").style.height = (document.getElementById("imagefotoalbumsize").offsetHeight-8)+"px";
					}
					else 
					{
						document.querySelector("#imagefotoalbumsetting > nobr").style.MozTransform = 'rotate3d(0, 1, 0, '+(i*10)+'deg)';
						document.querySelector("#imagefotoalbumsetting > nobr").style.WebkitTransform = 'rotate3d(0, 1, 0, '+(i*10)+'deg)';
						document.querySelector("#imagefotoalbumsetting > nobr").style.OTransform = 'rotate3d(0, 1, 0, '+(i*10)+'deg)';
						document.querySelector("#imagefotoalbumsetting > nobr").style.MsTransform = 'rotate3d(0, 1, 0, '+(i*10)+'deg)';
						document.querySelector("#imagefotoalbumsetting > nobr").style.transform = 'rotate3d(0, 1, 0, '+(i*10)+'deg)';
						document.getElementById("imagefotoalbumsize").style.backgroundPosition =  -((++ii)*5)+"px center";
					}
					if(parseInt(document.getElementById("imagefotoalbumtype").style.width) == 0)
						document.getElementById("imagefotoalbumtype").style.display = "none";
					else document.getElementById("imagefotoalbumtype").style.width = (parseInt(document.getElementById("imagefotoalbumtype").style.width)-20)+"%";
					if(i==-7)
					{					
						clearInterval(Iid);
						document.querySelector("#imagefotoalbumsetting > nobr").style.MozTransform = 'rotate3d(0, 1, 0, 0deg)';
						document.querySelector("#imagefotoalbumsetting > nobr").style.WebkitTransform = 'rotate3d(0, 1, 0, 0deg)';
						document.querySelector("#imagefotoalbumsetting > nobr").style.OTransform = 'rotate3d(0, 1, 0, 0deg)';
						document.querySelector("#imagefotoalbumsetting > nobr").style.MsTransform = 'rotate3d(0, 1, 0, 0deg)';
						document.querySelector("#imagefotoalbumsetting > nobr").style.transform = 'rotate3d(0, 1, 0, 0deg)';
						kshover.click = false;
					}
				},20); 
			}
			ksamimateoff(document.getElementById("imagefotoalbumsize"),180,90,f);
			ksamimateoff(document.getElementById("imagefotoalbumeffect"),180,90,false);
			document.getElementById("imagefotoalbumsetting").removeAttribute("on");
			if(document.getElementById("imagefotoalbumsettingeffect").children.length > 0)	
				ksamimateoff(document.getElementById("imagefotoalbumsettingeffect"),360,90,false);
			if(document.getElementById("imagefotoalbumnumbereffect").children.length > 0)
				ksamimateoff(document.getElementById("imagefotoalbumnumbereffect"),360,90,false);
		}
	}
	document.querySelector("#imagefotoalbumeffect").onclick = function(event)
	{
		if(kshover.click) return false;
		kshover.click = true;
		event = event || window.event;	
		var target = event.target || event.srcElement;
		if(target.hasAttribute("revers"))
		{
			if(document.querySelector(".imagefotoalbum").getAttribute("revers") == "on")
			{
				target.removeAttribute("on");
				document.querySelector(".imagefotoalbum").setAttribute("revers","");
			}
			else
			{
				document.querySelector(".imagefotoalbum").setAttribute("revers","on");
				target.setAttribute("on","");
			}
			kshover.click = false;
		}
		else if(target.hasAttribute("circle"))
		{
			target.setAttribute("on","");
			if(document.querySelector("#imagefotoalbumeffect > div[square]").hasAttribute("on")) 
				document.querySelector("#imagefotoalbumeffect > div[square]").removeAttribute("on");
			if(document.getElementById("imagefotoalbumsettingeffect").children.length > 0)	
				ksamimateoff(document.getElementById("imagefotoalbumsettingeffect"),360,90,false);
		
			document.querySelector(".imagefotoalbum").setAttribute("effect","0");
			document.querySelector(".imagefotoalbum").setAttribute("revers","");
			if(document.querySelector("#imagefotoalbumeffect > div[revers]").hasAttribute("on")) 
				document.querySelector("#imagefotoalbumeffect > div[revers]").removeAttribute("on");
			document.querySelector("#imagefotoalbumeffect > div[revers]").style.display = "none";
			var aa = Array();
			Object.keys(kshover.circle.effect).forEach(function(a,b,c){ aa[b] = "e"+c[b];});
			document.querySelector(".imagefotoalbum").setAttribute("form","circle");
			if(document.getElementById("imagefotoalbumnumbereffect").children.length > 0)
			{
				var f = function() 
				{ 
					document.getElementById("imagefotoalbumnumbereffect").setAttribute("forms","circle");
					var f2 = function()
					{
						document.querySelector("#imagefotoalbumnumbereffect > div[e"+document.querySelector(".imagefotoalbum").getAttribute("effect")+"]").setAttribute("on","");
						kshover.click = false;
					}
					return ksamimate(aa,0,document.getElementById("imagefotoalbumnumbereffect"),90,360,f2,document.querySelector(".imagefotoalbum")); 
				}
				ksamimateoff(document.getElementById("imagefotoalbumnumbereffect"),360,90,f);
			}
			else 
			{
				document.getElementById("imagefotoalbumnumbereffect").setAttribute("forms","circle");
				var f = function()
				{
					document.querySelector("#imagefotoalbumnumbereffect > div[e"+document.querySelector(".imagefotoalbum").getAttribute("effect")+"]").setAttribute("on","");
					kshover.click = false;
				}
				ksamimate(aa,0,document.getElementById("imagefotoalbumnumbereffect"),90,360,f,document.querySelector(".imagefotoalbum"));
			}
		}	
		else if(target.hasAttribute("square"))
		{
			target.setAttribute("on","");
			if(document.querySelector("#imagefotoalbumeffect > div[circle]").hasAttribute("on")) 
				document.querySelector("#imagefotoalbumeffect > div[circle]").removeAttribute("on");
			if(document.getElementById("imagefotoalbumsettingeffect").children.length > 0)	
				ksamimateoff(document.getElementById("imagefotoalbumsettingeffect"),360,90,false);
			
			document.querySelector(".imagefotoalbum").setAttribute("effect","0");
			document.querySelector(".imagefotoalbum").setAttribute("revers","");
			if(document.querySelector("#imagefotoalbumeffect > div[revers]").hasAttribute("on")) 
				document.querySelector("#imagefotoalbumeffect > div[revers]").removeAttribute("on");
			document.querySelector("#imagefotoalbumeffect > div[revers]").style.display = "none";
			var aa = Array();
			Object.keys(kshover.square.effect).forEach(function(a,b,c){ aa[b] = "e"+c[b];});
			document.querySelector(".imagefotoalbum").setAttribute("form","square");
			if(document.getElementById("imagefotoalbumnumbereffect").children.length > 0)
			{
				var f = function() 
				{
					var f2 = function()
					{
						document.querySelector("#imagefotoalbumnumbereffect > div[e"+document.querySelector(".imagefotoalbum").getAttribute("effect")+"]").setAttribute("on","");
						kshover.click = false;
					}
					document.getElementById("imagefotoalbumnumbereffect").setAttribute("forms","square");
					return ksamimate(aa,0,document.getElementById("imagefotoalbumnumbereffect"),90,360,f2,document.querySelector(".imagefotoalbum")); 
				}
				ksamimateoff(document.getElementById("imagefotoalbumnumbereffect"),360,90,f);
			}
			else 
			{
				document.getElementById("imagefotoalbumnumbereffect").setAttribute("forms","square");
				var f = function()
				{
					document.querySelector("#imagefotoalbumnumbereffect > div[e"+document.querySelector(".imagefotoalbum").getAttribute("effect")+"]").setAttribute("on","");
					kshover.click = false;
				}
				ksamimate(aa,0,document.getElementById("imagefotoalbumnumbereffect"),90,360,f,document.querySelector(".imagefotoalbum"));
			}
		}
		else if(target.hasAttribute("save"))
		{
			if(kshover.saves) {kshover.click = false; return false; }
			var saves = "";
			for(v in kshover.save)
			{
				saves += "imagefotoalbum"+kshover.save[v]+"="+document.querySelector(".imagefotoalbum").getAttribute(kshover.save[v])+"&";
				document.cookie = "imagefotoalbum"+kshover.save[v]+"="+document.querySelector(".imagefotoalbum").getAttribute(kshover.save[v])+"; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
			}
			<? if($_SESSION["admin_login"]) { ?>
				try { ro = new XMLHttpRequest(); }
				catch(e) { try { ro = new ActiveXObject("Msxml2.XMLHTTP");  }
				catch(e) { ro = new ActiveXObject("Microsoft.XMLHTTP"); } }
				ro.open("POST", "<? echo $def_mainlocation; ?>/foto.php?"+Math.random().toString(), true);
				ro.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				kshover.saves = true;
				t = target;
				t.setAttribute("go","");
				ro.onreadystatechange = function()
				{
					if((ro.readyState == 4) && (ro.status == 200)) 
					{ 
						kshover.saves = false;
						t.removeAttribute("go");
						t.setAttribute("yes","");
						setTimeout(function(){ t.removeAttribute("yes");}, 7000);
					}
					else if((ro.readyState == 4) && (ro.status != 200 && ro.status != 0))
					{
						kshover.saves = false;
						t.removeAttribute("go");
						t.setAttribute("no","");
						setTimeout(function(){ t.removeAttribute("no");}, 7000);
					}
				}
				ro.send(saves);
			<? } else { ?>
			kshover.saves = false;
			<? } ?>
			kshover.click = false;
		}
	}
	document.getElementById("imagefotoalbumsize").onclick = function(event)
	{
		event = event || window.event;	
		var target = event.target || event.srcElement;
		for(s in kshover.size) 
		{
			if(document.querySelector("#imagefotoalbumsize > div["+kshover.size[s]+"]") == target)
			{
				if(document.querySelector("#imagefotoalbumsize > div[on]")) document.querySelector("#imagefotoalbumsize > div[on]").removeAttribute("on");
				target.setAttribute("on","");
				document.querySelector(".imagefotoalbum").setAttribute("size",kshover.size[s]);
			}
		}
	}
	document.querySelector("#imagefotoalbumnumbereffect").onclick = function(event)
	{
		if(kshover.click) return false;
		event = event || window.event;	
		var target = event.target || event.srcElement;
		if(document.querySelector("#imagefotoalbumnumbereffect") != target)
		{
			kshover.click = true;
			var ob = kshover[document.querySelector(".imagefotoalbum").getAttribute("form")].effect[target.attributes[0].name.substr(1)];
			if(ob.recurse == "on")
			{
				document.querySelector("#imagefotoalbumeffect > div[revers]").style.display = "block";
			}
			else
				document.querySelector("#imagefotoalbumeffect > div[revers]").style.display = "none";
				
			if(document.getElementById("imagefotoalbumsettingeffect").children.length > 0)
			{
				var f = function()
				{
					if(ob.run) 
					{
						var f2 = function()
						{
							document.querySelector("#imagefotoalbumsettingeffect > div["+ob.run[0]+"]").setAttribute("on","");
							document.querySelector(".imagefotoalbum").setAttribute("run",ob.run[0]);
						}
						return ksamimate(ob.run,0,document.getElementById("imagefotoalbumsettingeffect"),90,360,f2,document.querySelector(".imagefotoalbum"));
					}
				}
				ksamimateoff(document.getElementById("imagefotoalbumsettingeffect"),360,90,f);
			}
			else if(ob.run) 
			{
				var f2 = function()
				{
					document.querySelector("#imagefotoalbumsettingeffect > div["+ob.run[0]+"]").setAttribute("on","");
					document.querySelector(".imagefotoalbum").setAttribute("run",ob.run[0]);
				}
				ksamimate(ob.run,0,document.getElementById("imagefotoalbumsettingeffect"),90,360,f2,document.querySelector(".imagefotoalbum"));	
			}
			
			
			if(document.querySelector("#imagefotoalbumnumbereffect > div[on]"))
				document.querySelector("#imagefotoalbumnumbereffect > div[on]").removeAttribute("on");
				
			target.setAttribute("on","");
			document.querySelector(".imagefotoalbum").setAttribute("effect",target.attributes[0].name.substr(1));
			kshover.click = false;
		}
	}
	document.getElementById("imagefotoalbumsettingeffect").onclick = function()
	{
		event = event || window.event;	
		var target = event.target || event.srcElement;
		if(document.querySelector("#imagefotoalbumsettingeffect") != target)
		{
			document.querySelector(".imagefotoalbum").setAttribute("run",target.attributes[0].name);
			document.querySelector("#imagefotoalbumsettingeffect > div[on]").removeAttribute("on")
			document.querySelector("#imagefotoalbumsettingeffect > div["+target.attributes[0].name+"]").setAttribute("on","");
		}
	}
	document.querySelector(".imagetotoright").onclick = function()
	{
		document.querySelector(".imagetotocenter").style.marginLeft = "45%";
		var prefix = setInterval(function()
		{
			if(parseInt(document.querySelector(".imagetotocenter").style.marginLeft) == 40)
			{
				document.querySelector(".imagetotocenter").style.marginLeft = "";
				clearInterval(prefix);
			}
			else if(parseInt(document.querySelector(".imagetotocenter").style.marginLeft) == 100)
			{
				document.querySelector(".imagetotocenter").style.marginLeft = 0;
				var stop = false;
				var prf = $(".imagefotoalbum").attr("prefix");
				for(v in kshover.prefix) 
				{
					if(v == "standart")
					{
						$(".imagefotoalbum").attr("prefix","aero");
						document.querySelector(".imagetotocenter").style.backgroundImage = "url(<? echo $def_mainlocation;?>/images/gallery/aero.jpg)";
						$().galleryKS(kshover.prefix[$(".imagefotoalbum").attr("prefix")]);
						break;
					}
					if(v == prf)
					{
						var stop = true;
					}
					else if(stop)
					{
						$(".imagefotoalbum").attr("prefix",v);
						document.querySelector(".imagetotocenter").style.backgroundImage = "url(<? echo $def_mainlocation;?>/images/gallery/"+v+".jpg)";
						$().galleryKS(kshover.prefix[$(".imagefotoalbum").attr("prefix")]);
						break;
					}
				}
			}
			
			document.querySelector(".imagetotocenter").style.marginLeft = (parseInt(document.querySelector(".imagetotocenter").style.marginLeft)+5)+"%";
		},20);
	}
	document.querySelector(".imagetotoleft").onclick = function()
	{
		document.querySelector(".imagetotocenter").style.marginLeft = "45%";
		var prefix = setInterval(function()
		{
			if(parseInt(document.querySelector(".imagetotocenter").style.marginLeft) == 50)
			{
				document.querySelector(".imagetotocenter").style.marginLeft = "";
				clearInterval(prefix);
			}
			else if(parseInt(document.querySelector(".imagetotocenter").style.marginLeft) == 0)
			{
				document.querySelector(".imagetotocenter").style.marginLeft = "100%";
				var stop = false;
				var prf = $(".imagefotoalbum").attr("prefix");
				for(v in kshover.prefix) 
				{
					if(prf == "aero")
					{
						$(".imagefotoalbum").attr("prefix","standart");
						document.querySelector(".imagetotocenter").style.backgroundImage = "url(<? echo $def_mainlocation;?>/images/gallery/standart.jpg)";
						$().galleryKS(kshover.prefix[$(".imagefotoalbum").attr("prefix")]);
						break;
					}
					else if(v == prf)
					{
						$(".imagefotoalbum").attr("prefix",stop);
						document.querySelector(".imagetotocenter").style.backgroundImage = "url(<? echo $def_mainlocation;?>/images/gallery/"+stop+".jpg)";
						$().galleryKS(kshover.prefix[$(".imagefotoalbum").attr("prefix")]);
						break;
							
					}
					else
					{
						stop = v; 
					}
				}
			}
			
			document.querySelector(".imagetotocenter").style.marginLeft = (parseInt(document.querySelector(".imagetotocenter").style.marginLeft)-5)+"%";
		},20);
	}
</script>
<?php
if ( $results_amount > 0 ) main_table_bottom_gal();
include ( "./template/$def_template/footer.php" );
?>
<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: functions.php
-----------------------------------------------------
 Назначение: Основные функции
=====================================================
*/


function safeHTML ( $str )

{

    global $def_charset;

	$str = preg_replace ( "'<script[^>]*?>.*?</script>'si", "", $str );
	$str = preg_replace ( "'<head[^>]*?>.*?</head>'si", "", $str );

	$allowed = "b|i|u|a";

	$str = preg_replace ( "/<((?!\/?($allowed)\b)[^>]*>)/xis", "", $str );
	$str = preg_replace ( "/<($allowed).*?>/i", "<\\1>", $str );

	$str = htmlspecialchars ( $str,ENT_QUOTES,$def_charset );

	$str = preg_replace("/ +/", " ", $str);

	$str = preg_replace("/(\r\n|\n|\r)/", "\n", $str); // cross-platform newlines
	$str = preg_replace("/\n\n+/", "\n\n", $str); // take care of duplicates
	$str = str_replace("\n", "<br>", $str);

	return $str;

}


function unHTML ( $str )

{

	$str = str_replace ( "&amp;", "&", $str );
	$str = str_replace ( "&quot;", "\"", $str );
	$str = str_replace ( "&#039;", "\'", $str );
	$str = str_replace ( "&lt;", "<", $str );
	$str = str_replace ( "&gt;", ">", $str );
	//     $str = html_entity_decode ( $str );

	$trans_tbl = get_html_translation_table (HTML_ENTITIES);
	$trans_tbl = array_flip ($trans_tbl);
	$str = strtr ($str, $trans_tbl);
	$str = preg_replace('/\&\#([0-9]+)\;/me', "chr('\\1')", $str);

	return $str;

}

function safeInfo($text)
{
	# Разрешённые теги
	$allowed = array('strong', 'em', 'u', 'p', 'br', 'span', 'div', 'ol', 'li', 'ul', 'BLOCKQUOTE', 'hr');
	
	# Теги для полного вырезания
	$cutted = array('iframe', 'script', 'a', 'img');

	# Теги для одиночного вырезания
	$cuttag = array ('http', 'https', 'ftp', 'alert', 'script', 'iframe', 'ftp' ,'code', 'select', 'where', 'eval');
	
	$list = array();
	foreach ($allowed as $tag)
	{
		$list[] = '#<(' . $tag . '[^>]*)>#i';
		$list[] = '#<(/' . $tag . ')>#i';
	}
	
	$text = preg_replace($list, '###$1|||', $text);
	
	foreach ($cutted as $tag)
	{
		do
		{
			$tag1 = '<' . $tag;
			$tag2 = '</' . $tag . '>';
			$p1 = stripos($text, $tag1);
			$p2 = stripos($text, $tag2, $p1);
			if ($p1 === false && $p2 === false)
			{
				break;
			}
			elseif ($p1 === false && $p2 !== false)
			{
				$text = substr_replace($text, '', $p2, strlen($tag2));
			}
			elseif ($p1 !== false && $p2 === false)
			{
				$p2 = strpos($text, '>', $p1);
				if ($p2 !== false)
				{
					$text = substr_replace($text, '', $p1, ($p2 + 1) - $p1);
				}
				else
				{
					$text = substr_replace($text, '', $p1, strlen($tag1));
				}
			}
			else
			{
				$text = substr_replace($text, '', $p1, ($p2 + strlen($tag2)) - $p1);
			}
		}
		while (true);
	}
	
	$text = str_replace(array('<?', '?>'), array('&lt;?', '?&gt;'), $text);
	
	$text = str_replace(array('###', '|||'), array('<', '>'), $text);
	
	$text = preg_replace('#((\s|&nbsp;|&32;){3})(\s|&nbsp;|&32;)+#', '$1', $text);
	$text = preg_replace('#((<br[^>]*>\s*){3})(<br[^>]*>\s*)+#i', '$1', $text);

	foreach ($cuttag as $tag)
	{
 		$text = str_replace($tag,'',$text);
	}

	if( function_exists( "get_magic_quotes_gpc" ) && get_magic_quotes_gpc() ) $text = stripslashes( $text );

    	$text = addslashes( $text );
	
	return $text;
}

function safe_business($flag, $text)
{
        $test=trim($text);

	# Теги для полного вырезания
	if ($flag=='D') { $cutted = array('iframe', 'script', 'a', 'img'); $cuttag = array ('http', 'https', 'ftp', 'alert', 'script', 'iframe', 'ftp' ,'code', 'select', 'where', 'include', 'requery'); }
        else { $cutted = array('iframe', 'script'); $cuttag = array ('alert', 'script', 'iframe', 'ftp' , 'select', 'where', 'include', 'requery','eval'); }
	
	foreach ($cutted as $tag)
	{
		do
		{
			$tag1 = '<' . $tag;
			$tag2 = '</' . $tag . '>';
			$p1 = stripos($text, $tag1);
			$p2 = stripos($text, $tag2, $p1);
			if ($p1 === false && $p2 === false)
			{
				break;
			}
			elseif ($p1 === false && $p2 !== false)
			{
				$text = substr_replace($text, '', $p2, strlen($tag2));
			}
			elseif ($p1 !== false && $p2 === false)
			{
				$p2 = strpos($text, '>', $p1);
				if ($p2 !== false)
				{
					$text = substr_replace($text, '', $p1, ($p2 + 1) - $p1);
				}
				else
				{
					$text = substr_replace($text, '', $p1, strlen($tag1));
				}
			}
			else
			{
				$text = substr_replace($text, '', $p1, ($p2 + strlen($tag2)) - $p1);
			}
		}
		while (true);
	}

	$text = str_replace(array('<?', '?>'), array('&lt;?', '?&gt;'), $text);

	$text = str_replace(array('###', '|||'), array('<', '>'), $text);

	$text = preg_replace('#((\s|&nbsp;|&32;){3})(\s|&nbsp;|&32;)+#', '$1', $text);
	$text = preg_replace('#((<br[^>]*>\s*){3})(<br[^>]*>\s*)+#i', '$1', $text);

	foreach ($cuttag as $tag)
	{
 		$text = str_replace($tag,'',$text);
	}

	if( function_exists( "get_magic_quotes_gpc" ) && get_magic_quotes_gpc() ) $text = stripslashes( $text );

    	$text = addslashes( $text );

	return $text;
}


function rewrite ($str)

{

// Сначала заменяем "односимвольные" фонемы.

    $str=strtr($str,"абвгдеёзийклмнопрстуфхъыэ_",

    "abvgdeeziyklmnoprstufh'iei");

    $str=strtr($str,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_",

    "ABVGDEEZIYKLMNOPRSTUFH'IEI");

    // Затем - "многосимвольные".

    $str=strtr($str, 

                    array(

                        "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", 

                        "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya",

                        "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH", 

                        "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",

                        "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye"

                        )

             );

	$str=trim($str);	
	$str=str_replace(' ', "-", $str);
	$str=str_replace('/', "", $str);
	$str=str_replace(',', "", $str);
	return $str;
}

function undate ( $str2, $type )

{

	$str = explode ( "-", $str2 );

	$str_year = $str[0];

	if (strlen($str[1]) < 2)
	$str_month = "0". $str[1];
	else
	$str_month = $str[1];

	if (strlen($str[2]) < 2)
	$str_day = "0". $str[2];
	else
	$str_day = $str[2];

	if ($type == "MM-DD-YYYY") $str2 = "$str_month-$str_day-$str_year";
	elseif ($type == "DD-MM-YYYY") $str2 = "$str_day-$str_month-$str_year";
	elseif ($type == "YYYY-MM-DD") $str2 = "$str_year-$str_month-$str_day";
	elseif ($type == "YYYY-DD-MM") $str2 = "$str_year-$str_day-$str_month";
	elseif ($type == "DD.MM.YYYY") $str2 = "$str_day.$str_month.$str_year";
	else $str2 = "Incorrect date type setting in config.php ($type)";

	return $str2;

}


/* ************************************************************************* */

// Template class.

class Template {

	var $template;

        function set_file ($file)

	{
            global $def_template;

            if (!file_exists('./template/' . $def_template . '/'.$file)) die ('Not found '.$file);

		$this->template = file_get_contents ('./template/' . $def_template . '/'.$file);
	}

	function load ($file)

	{
		$this->template = $file;
	}

	function replace ($var, $content)

	{
		$this->template = str_replace("*$var*", $content, $this->template);
	}

	function replace_all ($var_all, $content_all)

	{
		$this->template = str_replace($var_all, $content_all, $this->template);
	}

	function publish ()

	{
		eval("?>".$this->template."<?");
	}

}

/* ************************************************************************* */


// Ограничение символов в описании

function parseDescription ($flag, $description)

{
	global $def_box_descr_size;
	global $def_short_descr_size;

	$description = strip_tags(stripslashes( $description ),'<li><p><br><br />');

        $description=str_replace("</p>", "<br>", $description);
        $description=str_replace("<p>", "", $description);
        $description=str_replace("<p></p>", "", $description);
        $description=str_replace("<p>&nbsp;</p>", "", $description);
        $description=str_replace("<br /><br />", "", $description);
        $description=str_replace("<br><br>", "", $description);
   
	if ( ($flag == "X") and ($description != "") ) $descr = substr (strip_tags($description), 0, $def_short_descr_size) .  "...";
	if ( ($flag == "Z") and ($description != "") ) $descr = substr (strip_tags($description), 0, $def_box_descr_size);

			$descr=str_replace("[b]", "", $descr);
			$descr=str_replace("[/b]", "", $descr);
			$descr=str_replace("[i]", "", $descr);
			$descr=str_replace("[/i]", "", $descr);
			$descr=str_replace("[u]", "", $descr);
			$descr=str_replace("[/u]", "", $descr);

                        $descr=str_replace("< ", "", $descr);
                        $descr=str_replace(" >", "", $descr);

	return $descr;

}

/* ************************************************************************* */

// Новый

function ifNew ($date)

{
	if ($date=="") { $new_listing = ""; return $new_listing; }

	global $def_new;

	$date_day = date ( "d" );
	$date_month = date ( "m" );
	$date_year = date ( "Y" );

	list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $date );

	$first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
	$second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

	if ( $second_date > $first_date ) $days = $second_date - $first_date;

	else $days = $first_date - $second_date;

	$current_result = ( $days ) / ( 60 * 60 * 24 );

	if ( $current_result <= 5 ) $new_listing = "$def_new";

	else $new_listing = "";

	return $new_listing;
}

/* ************************************************************************* */

// Рейтинговый

function ifHot ($countrating, $votes)

{
	global $def_hot;

	if ( ( $countrating == 5 ) and ( $votes > 5 ) ) $hot_listing = $def_hot;

	else $hot_listing = "";

	return $hot_listing;
}

/* ************************************************************************* */

// Обновлен

function ifUpdated ($date)

{

IF ($date<>"") {

	global $def_updated;


	$date_day = date ( "d" );
	$date_month = date ( "m" );
	$date_year = date ( "Y" );

	list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $date );     
	$first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
	$second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

	if ( $second_date > $first_date ) $days = $second_date - $first_date;

	else $days = $first_date - $second_date;

	$current_result = ( $days ) / ( 60 * 60 * 24 );

	if ( $current_result <= 5 ) $updated_listing = $def_updated;

	else $updated_listing = "";

}
else $updated_listing = "";

	return $updated_listing;

}

/* ************************************************************************* */

// Логотип

function ifLogo ($flag, $selector, $width, $title = "")

{
	// Predefine the required
	// global variables

	global $def_A_logo;
	global $def_B_logo;
	global $def_C_logo;
	global $def_D_logo;
	global $def_mainlocation;

	// Loading all logo images from the /logo
	// folder

	$handle = opendir ( "./logo" );

	$count = 0;

	while ( false != ( $file = readdir ( $handle ) ) )

	{

		if ( $file != "." && $file != ".." )

		{
			$logo[$count] = "$file";
			$count++;
		}
	}

	closedir ( $handle );

	// Checking if the image from this
	// listing exist

	$logotag = "";

	for ( $a=0; $a<count($logo); $a++ )

	{
		$logoname = explode ( ".", $logo[$a] );

		if ( $logoname[0] == $selector )

		{
			$logovar =  "def_".$flag."_logo";

			if ($width != "") $width_out = "width=$width"; else $width_out = "";
		
			if ($$logovar == "YES")
			{
				$logotag = "<img src=\"$def_mainlocation/logo/$logoname[0].$logoname[1]\" $width_out alt=\"$title\" title=\"$title\" border=0>";
			}

			else

			$logotag = "";
		}
	}

	return $logotag;
}

/* ************************************************************************* */

// Схема проезда

function ifSxema ($flag, $selector, $width)

{
	// Predefine the required
	// global variables

	global $def_A_sxema;
	global $def_B_sxema;
	global $def_C_sxema;
	global $def_D_sxema;
	global $def_mainlocation;

	// Loading all logo images from the /logo
	// folder

	$handle = opendir ( "./sxema" );

	$count = 0;

	while ( false != ( $file = readdir ( $handle ) ) )

	{

		if ( $file != "." && $file != ".." )

		{
			$sxema[$count] = "$file";
			$count++;
		}
	}

	closedir ( $handle );

	$sxematag = "";

	for ( $a=0; $a<count($sxema); $a++ )

	{
		$sxemaname = explode ( ".", $sxema[$a] );

		if ( $sxemaname[0] == $selector )

		{

			$sxemavar =  "def_".$flag."_sxema";

			if ($width != "") $width_out = "width=$width"; else $width_out = "";
		
			if ($$sxemavar == "YES")
			{
				$sxematag = "<img src=\"$def_mainlocation/sxema/$sxemaname[0].$sxemaname[1]\" alt=\"Схема проезда\" width=\"40\" height=\"40\" border=0 hspace=3 align=absmiddle> <a href=\"$def_mainlocation/sxema/$sxemaname[0].$sxemaname[1]\" target=\"_blank\">схема проезда</a>";
			}

			else

			$sxematag = "";
		}
	}

	return $sxematag;
}


/* ************************************************************************* */

// Разрешено / Запрещено тарифным планом

function ifEnabled ($flag, $field)

{
	$fieldvar =  "def_".$flag."_".$field;

	include ("./conf/memberships.php");

	if ($$fieldvar == "YES")
	return True;
	else
	return False;
}

/* ************************************************************************* */

// Рейтинг компании

function show_rating ($countrating, $votes)

{

	global $def_rating_allowed;
	global $def_rating;
	global $def_cat_font_color_empty;
	global $def_votes;
	global $def_template;
	global $def_mainlocation;

	if ( ( $def_rating_allowed == "YES" ) and ( $countrating > 0 ) and ( $votes > 0 ) )

	{

		$countrating = $countrating / $votes;

		$rating_listing = "";

		for ( $i=1;$i<6;$i++ )

		{

 		 if ($countrating - $i >= 0)

		  {
			$rating_listing.= "<img src='" . $def_mainlocation . "/template/" . $def_template . "/images/star.gif' border='0' alt='' />";
		  }

		else

		  {
			if ( (($i - $countrating) <= 0.5) and (($i - $countrating) > 0) )
  	                $rating_listing.= "<img src='" . $def_mainlocation . "/template/" . $def_template . "/images/star-half.gif' border='0' alt='' />";
			else
  	                $rating_listing.= "<img src='" . $def_mainlocation . "/template/" . $def_template . "/images/star-empty.gif' border='0' alt='' />";
		  }

		}

		$rating_listing.= " <font color='#808080'> ($votes $def_votes) </font>";
	}

	return $rating_listing;
}

/* ************************************************************************* */

// Сообщение об ошибке

function error ($type, $message)

{
	echo "<font face=arial size=4><b>$type</b></font>\n
          <br ><br >
           <font face=arial size=2 color=#808080>$message</font>";
	exit();
}

/* ************************************************************************* */

// TITLE каталога

function title ($text)

{

 global $def_title;

  $text = preg_replace ( "/<((?!\/?($allowed)\b)[^>]*>)/xis", "", $text );
  $text = preg_replace ( "/<($allowed).*?>/i", "<\\1>", $text );
  $text = str_replace(">", "", $text);
  $text = str_replace("<", "", $text);

  echo $text . " - " . $def_title;

}

/* ************************************************************************* */

// Определение мобильного устройства

function check_smartphone() {

	$phone_array = array('iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'mobile windows', 'cellphone', 'opera mobi', 'operamobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'symbos', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser', 'android');
	$agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );

	foreach ($phone_array as $value) {

		if ( strpos($agent, $value) !== false ) return true;

	}

	return false;

}

/* ************************************************************************* */

// Для compare.php

function ifcompare ($iftarif)

{
	global $def_mainlocation;

	if ($iftarif=="YES")

		$y_n = "<img src=\"$def_mainlocation/images/compare/YES.gif\" border=\"0\" alt=\"разрешено\" title=\"разрешено\">";

	else 

		$y_n = "<img src=\"$def_mainlocation/images/compare/NO.gif\" border=\"0\" alt=\"запрещено\" title=\"запрещено\">";

        return $y_n;
}

// md5 шифрование

function my_crypt($pass)
{

	global $salt;

	$spec=array('~','!','@','#','$','%','^','&','*','?');
	$crypted=md5(md5($salt).md5($pass));
	$c_text=md5($pass);
	for ($i=0;$i<strlen($crypted);$i++)
	{
	if (ord($c_text[$i])>=48 and ord($c_text[$i])<=57){
		@$temp.=$spec[$c_text[$i]];
	} elseif(ord($c_text[$i])>=97 and ord($c_text[$i])<=100){
		@$temp.=strtoupper($crypted[$i]);
	} else {
		@$temp.=$crypted[$i];
	}
	}
	return md5($temp);
}

// Проверка логина

function check_loginup ($idf, $login, $passw, $num_rows, $login1, $passw1, $passwmd5)
{

	global $db_users;

	if (($login==$login1) and ($passw==mysql_real_escape_string(md5($passwmd5))) and ($num_rows==1)) {

		$passmd=my_crypt($passwmd5);
		$sql = "UPDATE $db_users SET pass='$passmd' WHERE selector='$idf'" ;
		$rfg = mysql_query ($sql);

	return true; }

	if (($login==$login1) and ($passw==$passw1) and ($num_rows==1)) return true;

return false;

}

function imgM_Cat($image_cat, $id_cat, $imgNFolder = false) {

    global $def_mainlocation, $def_template;
    
                            switch ($imgNFolder)
				{

					case "news":
						$folderImgGo = 'images/newsicon';
						break;
                                        
                                        case "subcat":
						$folderImgGo = 'images/subcat';
						break;
                                            
                                        case "subsubcat":
						$folderImgGo = 'images/subsubcat';
						break;                                                
                                            
                                        default: $folderImgGo = 'images/category';
                                }

    if ($image_cat!='') $name_img="$folderImgGo/$id_cat.$image_cat";
    if (file_exists($name_img)) {

        $img_to_main = '<img src="'.$def_mainlocation.'/'.$name_img.'" hspace="5" vspace="5">';

    } else $img_to_main = '<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/point.gif" hspace="5" vspace="5">';

    return $img_to_main;

}


function phighslide () {

    global $def_mainlocation;
    
?>
   
<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/highslide/highslide.js"></script>
<link media="screen" href="<?php echo $def_mainlocation; ?>/includes/highslide/highslide.css" type="text/css" rel="stylesheet" />

<script language="javascript" type="text/javascript">  
<!--  
	hs.graphicsDir = '<?php echo $def_mainlocation; ?>/includes/highslide/graphics/';
	hs.outlineType = 'rounded-white';
	hs.numberOfImagesToPreload = 0;
	hs.showCredits = false;
	
	hs.lang = {
		loadingText :     'Загрузка...',
		playTitle :       'Просмотр слайдшоу (пробел)',
		pauseTitle:       'Пауза',
		previousTitle :   'Предыдущее изображение',
		nextTitle :       'Следующее изображение',
		moveTitle :       'Переместить',
		closeTitle :      'Закрыть (Esc)',
		fullExpandTitle : 'Развернуть до полного размера',
		restoreTitle :    'Кликните для закрытия картинки, нажмите и удерживайте для перемещения',
		focusTitle :      'Сфокусировать',
		loadingTitle :    'Нажмите для отмены'
	};
	
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.addSlideshow({
		interval: 4000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
//-->

</script>

<?php
    
}

// Сохранение запросов

function qserch_table ($results_amount_q, $words_q) {

    global $db_zsearch, $db;

if (($results_amount_q>0) and ($words_q!="")) {

    $q_words=strtolower($words_q);
    $q_search = $db->query  ( "SELECT * FROM $db_zsearch WHERE item = '$q_words'" );
    @$results_qsearch = mysql_num_rows ( $q_search );
    $f_qsearch = $db->fetcharray  ( $q_search );

    if ($results_qsearch>0) $db->query  ( "UPDATE $db_zsearch SET item='$q_words', number='$results_amount_q' WHERE num='$f_qsearch[num]' " ) or die ( "ERROR012: mySQL error, can't update ZSEARCH. " );
    else $db->query  ( "INSERT INTO $db_zsearch (item, number) VALUES ('$q_words', '$results_amount_q')" ) or die ( "ERROR010: mySQL error, cant insert into ZSEARCH. " );

}

}

function qautocomplete_echo() {

    global $def_mainlocation;

?>

<link rel="stylesheet" href="<?php echo "$def_mainlocation/includes/css/"; ?>autocomplete.css">
<script src="<?php echo "$def_mainlocation/includes/"; ?>autocomplete.js"></script>
<script type="text/javascript">
$().ready(function() {
	$("#autocomplete").autocomplete('<?php echo "$def_mainlocation/includes/"; ?>qsearch.php', {
		delay: 10,
		minChars: 3,
		matchSubset: 1,
		autoFill: false,
		maxItemsToShow: 15
	});
});
</script>

<?php

}

// Обработка даты
  function data_to_news($idata) {
    $monn = array('','января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
    $a = preg_split("/[^\d]/",$idata);
    $today = date('Ymd');
    if(($a[0].$a[1].$a[2])==$today) { return("Сегодня, ".$a[3].":".$a[4]); } else {
      $b = explode("-",date("Y-m-d"));
      $tom = date("Ymd",mktime(0,0,0,$b[1],$b[2]-1,$b[0]));
    if(($a[0].$a[1].$a[2])==$tom) { return("Вчера, ".$a[3].":".$a[4]); } else {
        $mm = intval($a[1]);
        return($a[2]." ".$monn[$mm]." ".$a[0].", ".$a[3].":".$a[4]);
      }
    }
  }

// Обработка массива облака тегов
function compare_tags($a, $b) {

	if( $a['tag'] == $b['tag'] ) return 0;

	return strcasecmp( $a['tag'], $b['tag'] );

}

// Автоматическое формирование ключевых слов

function check_keywords($story) {

        $keyword_count = 20;
	$newarr = array ();
	$quotes = array ("\x22", "\x60", "\t", '\n', '\r', "\n", "\r", '\\', ",", ".", "/", "¬", "#", ";", ":", "@", "~", "[", "]", "{", "}", "=", "-", "+", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"', "«", "»" );
	$story = str_replace( "&nbsp;", " ", $story );
	$story = str_replace( '<br />', ' ', $story );
	$story = trim( strip_tags( $story ) );
        $story = str_replace( $quotes, '', $story );

        $arr = explode( " ", $story );

		foreach ( $arr as $word ) {
			if( strlen( $word ) > 4 ) $newarr[] = $word;
		}

		$arr = array_count_values( $newarr );
		arsort( $arr );
		$arr = array_keys( $arr );
		$total = count( $arr );
		$offset = 0;
		$arr = array_slice( $arr, $offset, $keyword_count );
		$keywords = implode( ", ", $arr );

                return $keywords;
}

// Чистим для мета-тегов

function chek_meta($story) {

        $fastquotes = array ("\x22", "\x60", "\t", "\n", "\r", '"', '\r', '\n', "$", "{", "}", "[", "]", "<", ">");
        $meta_ex=strip_tags( stripslashes($story) );
        $meta_ex=str_replace( $fastquotes, '', $meta_ex );
        $htmlquotes = array ("&amp;", "&quot;", "&#039;", "&lt;", "&ldquo;", "&rdquo;", "&nbsp;", "&ndash;", "&" );
        
        $meta_ex = str_replace ( $htmlquotes, "", $meta_ex );

    	$cleanList = array('ЧП', 'АО', 'ИП', 'ООО', 'ОО', 'ТОО', 'фирма', 'компания', 'магазин', 'салон', 'организация','&quot;');
	foreach ($cleanList as &$row)
	{
		$row = '#^' . $row . '\s#i';
	}
        unset($row);
	$meta_ex = preg_replace($cleanList, '', $meta_ex);

        return $meta_ex;

}

// сокращение текста
function isb_sub($text,$len) {

    if (strlen($text)==0) return $text;

    if (strlen($text)>$len) {

    			$text = substr($text, 0, $len);
			$text = substr($text, 0, strrpos($text, ' '));
			$text = trim($text) . ' ...';
    }

    return $text;
    
}

// Выбор шаблона

function set_tFile ($file)

{
    global $def_template;

    if (!file_exists('./template/' . $def_template . '/'.$file)) die ('Not found '.$file);
    
       $file_to = file_get_contents ('./template/' . $def_template . '/'.$file);

    return $file_to;
}

// Отправка e-mail

function mailHTML($to,$subject,$message,$from) {

	mail($to, stripcslashes($subject), stripcslashes($message), "From: $from\r\nContent-Type: text/html; charset=windows-1251\r\n"."Reply-To: $from\r\n"."MIME-Version: 1.0\n"."X-Sender: $from\n"."X-Mailer: I-Soft Bizness\n"."X-Priority: 3 (Normal)\n") or die('Функция mail() не сработала.');
}

// Преобразование домена для класса punicode

function punicode_url($input_url) {

    $input_url=parse_url($input_url);

    require_once('classes/idna_convert.class.php');

    $IDN = new idna_convert();
    $input = iconv('CP1251', 'UTF-8', $input_url[host].$input_url[path]);

    $output_url = $input_url[scheme].'://'.$IDN->encode($input);

    return $output_url;
}

// Перенаправление на страницу

function goto_url ($url) {

echo <<<HTML
<script language='Javascript'><!--
function reload() {location = "$url"}; setTimeout('reload()', 0);
//--></script>
HTML;
exit;

}

// Получение параметров основной категории
function correct_url ($cat_all,$get_func,$id) {

    global $def_rewrite, $def_mainlocation;

    	$category_list = explode(":", $cat_all);
	$category_list = explode("#", $category_list[0]);

        if ($def_rewrite=="YES") $go_url=$def_mainlocation.'/'.$get_func.'-'.$id.'-0-'.$category_list[0].'-'.$category_list[1].'-'.$category_list[2].'.html'; else
        $go_url=$def_mainlocation.'/'.$get_func.'.php?id='.$id.'&cat='.$category_list[0].'&subcat='.$category_list[1].'&subsubcat='.$category_list[2];

# Не задана верно страница
if (isset($_GET['page']) and ($_GET['page']=='')) {
    header("HTTP/1.0 301 Moved Permanently");
    header("Location: $go_url");
    die("Redirect");
}
# Не заданы верно категории
if (isset($_GET['cat']) and ($_GET['cat']=='')) {
    header("HTTP/1.0 301 Moved Permanently");
    header("Location: $go_url");
    die("Redirect");
}
if (isset($_GET['subcat']) and ($_GET['subcat']=='')) {
    header("HTTP/1.0 301 Moved Permanently");
    header("Location: $go_url");
    die("Redirect");
}
if (isset($_GET['subsubcat']) and ($_GET['subsubcat']=='')) {
    header("HTTP/1.0 301 Moved Permanently");
    header("Location: $go_url");
    die("Redirect");
}
if (empty($_GET['cat'])) {
    header("HTTP/1.0 301 Moved Permanently");
    header("Location: $go_url");
    die("Redirect");
}

}

// Определяем каноническую ссылку
function to_canonical($main_category,$gucat,$gusubcat,$gusubsubcat) {

    $category_list_can = explode(":", $main_category);
    $category_list_can = explode("#", $category_list_can[0]);

    if (($category_list_can[0]!=$guCat) and ($category_list_can[1]!=$guSubCat) and ($category_list_can[2]!=$guSubSubCat))

        return array($category_list_can[0],$category_list_can[1],$category_list_can[2]);

    else return 0;

}

?>
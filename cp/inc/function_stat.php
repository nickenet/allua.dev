<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: function_stat.php
-----------------------------------------------------
 Назначение: Функция добавления статической страницы
=====================================================
*/

function replace_news($way, $sourse, $replce_n_to_br=TRUE, $use_html=TRUE){
    global $config_allow_html_in_news, $config_allow_html_in_comments, $config_http_script_dir, $config_smilies;
    $sourse = stripslashes($sourse);

    if($way == "show")
    {
		$find= array(

/* 11 */				"'\[upimage=(.*?) ([^\]]{1,})\]'i",
/* 2 */					"'\[upimage=(.*?)\]'i",
/* 3 */					"'\[b\](.*?)\[/b\]'i",
/* 4 */					"'\[i\](.*?)\[/i\]'i",
/* 5 */					"'\[u\](.*?)\[/u\]'i",
/* 6 */					"'\[link\](.*?)\[/link\]'i",
/* 7 */					"'\[color=(.*?)\](.*?)\[/color\]'i",
/* 8 */					"'\[size=(.*?)\](.*?)\[/size\]'i",
/* 9 */					"'\[font=(.*?)\](.*?)\[/font\]'i",
/* 10 */ 				"'\[align=(.*?)\](.*?)\[/align\]'i",
/* 11 */				"'\[image=(.*?) ([^\]]{1,})\]'i",
/* 12 */ 				"'\[image=(.*?)\]'i",
/* 13 */ 				"'\[link=(.*?)\](.*?)\[/link\]'i",

/* 14 */                "'\[quote=(.*?)\](.*?)\[/quote\]'i",
/* 15 */                "'\[quote\](.*?)\[/quote\]'i",

/* 16 */                "'\[list\]'i",
/* 17 */                "'\[/list\]'i",
/* 18 */                "'\[\*\]'i",

    	                "'{nl}'",
                       );

		$replace=array(

/* 1 */					"<img \\2 src=\"${config_http_script_dir}/images/upimages/\\1\" border=0>",
/* 2 */					"<img src=\"${config_http_script_dir}/images/upimages/\\1\" border=0>",
/* 3 */					"<b>\\1</b>",
/* 4 */					"<i>\\1</i>",
/* 5 */					"<u>\\1</u>",
/* 6 */					"<a href=\"\\1\">\\1</a>",
/* 7 */					"<font color=\\1>\\2</font>",
/* 8 */					"<font size=\\1>\\2</font>",
/* 9 */					"<font face=\"\\1\">\\2</font>",
/* 10 */				"<div align=\\1>\\2</div>",
/* 11 */				"<img \\2 src=\"\\1\" border=0>",
/* 12 */				"<img src=\"\\1\" border=0>",
/* 13 */				"<a href=\"\\1\">\\2</a>",

/* 14 */				"<blockquote><div style=\"font-size: 13px;\">quote (\\1):</div><hr noshade size=1>\\2<hr noshade size=1></blockquote>",
/* 15 */				"<blockquote><div style=\"font-size: 13px;\">quote:</div><hr noshade size=1>\\1<hr noshade size=1></blockquote>",

/* 16 */				"<ul>",
/* 17 */				"</ul>",
/* 18 */				"<li>",

    					"\n",
                        );

    	$smilies_arr = explode(",", $config_smilies);
	    foreach($smilies_arr as $smile){
	        $smile = trim($smile);
	        $find[] = "':$smile:'";
	        $replace[] = "<img border=0 src=\"$config_http_script_dir/images/emoticons/$smile.gif\" />";
	    }
    }
    elseif($way == "add"){

		$find = array(
					"'\|'",
					"'\r'",
	                 );
		$replace = array(
					"&#124",
					"",
	                 );

		if($use_html != TRUE){
        	$find[] 	= "'<'";
        	$find[] 	= "'>'";

			$replace[] 	= "&lt;";
			$replace[] 	= "&gt;";
        }
		if($replce_n_to_br == TRUE){
        	$find[] 	= "'\n'";
			$replace[] 	= "<br />";
        }else{
        	$find[] 	= "'\n'";
			$replace[] 	= "{nl}";
        }

    }
    elseif($way == "admin"){

		$find = array(
					"''",
					"'<br />'",
					"'{nl}'",
                    );
		$replace = array(
					"",
					"\n",
					"\n",
	                 );

    }

$sourse  = preg_replace($find,$replace,$sourse);
return $sourse;
}
function msg($type, $title, $text, $back=FALSE){
  	echo"<table border=0 cellpading=0 cellspacing=0 width=654 height=100% ><tr><td>$text";
    if($back){
		echo"<br /><br> <a href=\"$back\">назад</a>";
    }
    echo"</td></tr></table>";
exit();
}

?>
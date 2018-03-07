<?php
/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D.Madi
  =====================================================
  Файл: video_firms.php
  -----------------------------------------------------
  Назначение: Класс по трансляции видеоролика
  =====================================================
 */

class Fvideo
{
	var $video_widht = 500;
	var $video_height = 281;
	var $link_video = "";

	// Функция трансляции видеоролика
	function showVideo($view)
	{
            global $def_error_video, $def_video_allowed;

            $allowedVideo = explode(",", $def_video_allowed);

            $iframeData = array('width' => 0, 'height' => 0, 'src' => '');

                    $urlv = str_replace("&lt;", "<", $this->link_video);
                    $urlv = str_replace("&gt;", ">", $urlv);
                    $urlv = str_replace("'", '"', $urlv);
                    $urlv = str_replace('"//www.', '"https://', $urlv);
                    $urlv = stripcslashes($urlv);

            // Обработка ссылки youtube.com
            if ((stripos($this->link_video,'iframe')===false) and (stripos($this->link_video,'object')===false)) {

                    $url = urldecode( $this->link_video );
                    $url = str_replace("&amp;","&", $url );

                    $source = parse_url ( $url );

                    $source['host'] = str_replace( "www.", "", strtolower($source['host']) );

                    $error_video="";

                    if ($source['host'] != "youtube.com" AND $source['host'] != "youtu.be") $error_video=$def_error_video;

                    if ($source['host'] == "youtube.com") {

                            $a = explode('&', $source['query']);
                            $j = 0;

                            while ($j < count($a)) {
                                $b = explode('=', $a[$j]);
                                if ($b[0] == "v") $video_link = $b[1];
                                $j++;
                            }
                    }

                    if ($source['host'] == "youtu.be") {
			$video_link = str_replace( "/", "", $source['path'] );
			$video_link = htmlspecialchars($video_link, ENT_QUOTES,$def_charset);
		    }

                    if ($error_video=="") {

                        if (($source['host'] == "youtube.com") or ($source['host'] == "youtu.be")) $video = "<iframe width=\"$this->video_widht\" height=\"$this->video_height\" src=\"//www.youtube.com/embed/$video_link?rel=0\" frameborder=\"0\" allowfullscreen></iframe>";
                        $iframeData['src']='https://www.youtube.com/embed/'.$video_link.'?rel=0';

                    } else $video = $def_error_video;

                }

                // Обработка кода iframe
                if (stripos($this->link_video,'iframe')!==false) {

                    $matches = array();
                    preg_match('#<iframe[^>]+>#', $urlv, $matches);
                    $urlv = $matches[0];

                    $matches = array();
                    preg_match_all('#(width|height|src)="([^"]+)"#', $urlv, $matches);

                    foreach ($matches[1] as $index => $key) {
                        $iframeData[$key] = $matches[2][$index];
                    }

                    $host = parse_url($iframeData['src'], PHP_URL_HOST);
                    $host = str_replace('www.', '', $host);

                    //if (!in_array($host, $allowedVideo)) {
                        //$video = $def_error_video;
                        //$iframeData = array();    
                    //}
                    //else 
                        $video = '<iframe width="'.$this->video_widht.'" height="'.$this->video_height.'" src="'.$iframeData['src'].'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>';
                }

                // Обработка кода object
                if (stripos($this->link_video,'object')!==false) {

                    $urlv=str_replace('video_yandex','https',$urlv);
                    $matches = array();

                    preg_match('#<embed[^>]+>#', $urlv, $matches);
                    $urlv = $matches[0];

                    $matches = array();
                    preg_match_all('#(width|height|src)="([^"]+)"#', $urlv, $matches);

                    foreach ($matches[1] as $index => $key) {
                        $iframeData[$key] = $matches[2][$index];
                    }

                    $host = parse_url($iframeData['src'], PHP_URL_HOST);
                    $host = str_replace('www.', '', $host);

                    if (!in_array($host, $allowedVideo)) {
                        $video = $def_error_video;
                        $iframeData = array();
                    }
                    else $video = '<object width="'.$this->video_widht.'" height="'.$this->video_height.'"><param name="movie" value="'.$iframeData['src'].'"></param><param name="wmode" value="transparent" /><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="'.$iframeData['src'].'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="transparent" width="'.$this->video_widht.'" height="'.$this->video_height.'"></embed></object>';
           
                  }

                if ($view!='url') return $video; else return $iframeData['src'];
	}
}
?>
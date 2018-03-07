<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya
=====================================================
 Файл: kurses.php
-----------------------------------------------------
 Назначение: Класс вывода RSS лент
=====================================================
*/

class rssData
{
	public  $list = array();

 	private static $_cache = 'system/irss.dat';
 	
	private $_url = '';
	private $_num = 0;
	private $_max = 0;
	private $_dif = 0;
	
	
	public function __construct($showNum = 0)
	{
		require 'conf/config.php';
	
		if ( !$this->_checkServer() )
		{
			return;
		}
		
		if ($showNum < 1)
		{
			$showNum = $def_rss_number;
		}
		
		$this->_num = $showNum;
		$this->_url = $def_rss_url;
		$this->_max = $def_rss_chars;
		$this->_dif = $def_rss_period;
		
		$this->_update();
		
		$this->_parse();
		
		$this->show();
	}
	
	
	private function _checkServer()
	{
		$ret = true;
		if ( !function_exists('simplexml_load_string') )
		{
			echo 'Ошибка XML. ';
			$ret = false;
		}
		
		if ( !ini_get('allow_url_fopen') )
		{
			echo 'Ошибка URL. ';
			$ret = false;
		}
		
		if ( file_exists(self::$_cache) )
		{
			if ( !is_writable(self::$_cache) )
			{
				echo 'Ошибка записи файла. ';
				$ret = false;
			}
		}
		elseif ( !is_writable( dirname(self::$_cache) ) )
		{
			echo 'Ошибка записи директории. ';
			$ret = false;
		}
		
		return $ret;
	}
	
	
	private function _update()
	{
    	if ($this->_dif) # Если период обновления задан
    	{
	    	$time = 0;
	    	if ( file_exists(self::$_cache) )
	    	{
	    		$time = filemtime(self::$_cache) + $this->_dif * 3600;
	    	}
	    	
	    	if ( $time > time() )
	    	{
	    		return;
	    	}
    	}
    	
    	$data = file_get_contents($this->_url);
		file_put_contents(self::$_cache, $data);
	}
	
	
	private function _parse()
	{
		$data = file_get_contents(self::$_cache);
		
		# Отсюда данные всегда в юникоде получаются
		$data = simplexml_load_string($data);
		if (!$data)
		{
			return;
		}
		
		foreach($data->channel->item as $item) 
		{ 
			$row = array();
			
			$row['title'] = (string)$item->title;
			$row['text']  = (string)$item->description;

			$row['title'] = iconv('windows-1251', 'UTF-8', $row['title']);
			$row['text']  = iconv('windows-1251', 'UTF-8', $row['text']);
			
			$text = strip_tags($row['text']);
			$text = htmlspecialchars_decode($text);
			$text = trim($text);
			if (strlen($text) > $this->_max)
			{
				$text = substr($text, 0, $this->_max);
				$text = substr($text, 0, strrpos($text, ' '));
				$text = trim($text) . ' ...';
			}
			
			$row['text']  = $text;
			$row['link']  = $item->link;
			$pubDate = $item->pubDate;
			$row['date']  = date ('d.m.y',strtotime($pubDate));	
			$this->list[] = $row;
		} 
	}
	
	
	public function show()
	{
		if ( empty($this->list) )
		{
			echo 'Новости отсутствуют';
			
			return;
		}
		
		array_splice($this->list, $this->_num);
		?> 
		<div> 
			<?php foreach ($this->list as $item) : ?>
		  	<div style="font-weight: bold">
		    	» <a href="<?php echo $item['link']; ?>" title="<?php echo $item['date']; ?>" target="_blank">
		    		<?php echo $item['title']; ?>
		    	</a>	
		  	</div>
		  	<div style="margin-bottom: 10px">
		    	<?php echo htmlspecialchars($item['text']); ?>
		  	</div>
			<?php endforeach; ?>  
		</div>
		<?php
	}
} 
?>

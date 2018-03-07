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
 Назначение: Класс для получения курса валют
=====================================================
*/
 
class Rates
{
	public  $list     = array();
	
	private $_cache   = 'system/kurs.dat';
	private $_hour    = 0; # Время обновление данных на сайте
	private $_imgUp   = 'images/up.png';
	private $_imgDown = 'images/down.png';						
	private $_getLink = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=';
	private $_codes   = array('840' => 'dollar',
				  '978' => 'euro',
				  '398' => 'kzt',
				  '980' => 'uah');
	private $_loaded  = false;
	
	
	function __construct()
	{
		if ( !$this->_checkServer() )
		{
			return;
		}
		
		$this->_update();
		
		$this->_parse();

		# Если проблемы с сервером, пробуем ещё раз
		if ( !$this->_loaded && empty($this->list) )
		{
			$this->_load();
			$this->_parse();
		}
		
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
		
		if ( file_exists($this->_cache) )
		{
			if ( !is_writable($this->_cache) )
			{
				echo 'Ошибка записи файла. ';
				$ret = false;
			}
		}
		elseif ( !is_writable( dirname($this->_cache) ) )
		{
			echo 'Ошибка записи директории. ';
			$ret = false;
		}
		
		return $ret;
	}
	
	
	private function _update()
	{
		$update = true;
		if ( file_exists($this->_cache) )
		{
			$new  = mktime($this->_hour, 0, 0, date('m'), date('d'), date('Y'));
			$last = filemtime($this->_cache);
			# Обновление было сегодня
			if ($last > $new)
			{
				$update = false;
			}
			# Вчерашние данные ещё актуальны
			elseif ($last > $new - 24 * 3600 && time() < $new)
			{
				$update = false;
			}
		}
		
		if ($update)
		{
			$this->_load();
		}
	}
	
	
	private function _load()
	{
    	$data = array();
    	
    	# Вчера
    	$link 			   	= $this->_getLink . date('d/m/Y', time() - 24 * 3600);
    	$data['yesterday'] 	= file_get_contents($link);
    	
    	# Сегодня
    	$link 		   		= $this->_getLink . date('d/m/Y'); 
		$data['today'] 		= file_get_contents($link);
		
		file_put_contents($this->_cache, serialize($data));
		
		$this->_loaded = true;
	}
	
	
	private function _parse()
	{
		$data = file_get_contents($this->_cache);
		$data = unserialize($data);
		
		$day 		= 'yesterday';
		$data[$day] = simplexml_load_string($data[$day]);
		foreach($data[$day]->Valute as $item) 
		{ 
			$val = str_replace(',', '.', (string)$item->Value);
			$key = (string)$item->NumCode;
			if ( isset($this->_codes[$key]) )
			{
				$key = $this->_codes[$key];
				$this->list[$key][$day] = $val;
			}
		} 
		
		$day 		= 'today';
		$data[$day] = simplexml_load_string($data[$day]);
		foreach($data[$day]->Valute as $item) 
		{ 
			$val = str_replace(',', '.', (string)$item->Value);
			$key = (string)$item->NumCode;
			if ( isset($this->_codes[$key]) )
			{
				$key = $this->_codes[$key];
				$this->list[$key][$day] = $val;
				
				$val -= $this->list[$key]['yesterday']; 
				if ($val > 0)
				{
					$val = '+' . $val;
				}
				
				$this->list[$key]['diff'] = $val;
			}
		} 
	}
	
	
	public function showOne($key)
	{

		global $def_mainlocation;

		echo '<strong>' . $this->list[$key]['today'] . '</strong> ';
		$diff = $this->list[$key]['diff'];
		if ($diff != 0)
		{
			$img = ($diff > 0) ? $this->_imgUp : $this->_imgDown;
			echo '<img src="'.$def_mainlocation.'/' . $img . '" alt="" align="absmiddle" ' .
				 	'title="Курс вчера ' . $this->list[$key]['yesterday'] . ', ' .
				 		$diff . '" />';
		}
	}
	
	
	public function show()
	{
		if ( empty($this->list) )
		{
			echo 'Cервер недоступен';
			
			return;
		}
		
		?>
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
		  <tr>
		    <td height="3" colspan="2"></td>
		  </tr>
		  <tr>
		    <td width="55%" align="right">Доллар США</td>
		    <td width="35%"><?php echo $this->showOne('dollar'); ?></td>
		  </tr>
		  <tr>
		    <td width="55%" align="right">Евро</td>
		    <td width="35%"><?php echo $this->showOne('euro'); ?></td>
		  </tr>
		  <tr>
		    <td width="55%" align="right">100 Казахстанских Тенге</td>
		    <td width="35%"><?php echo $this->showOne('kzt'); ?></td>
		  </tr>
		  <tr>
		    <td width="55%" align="right">10 Украинских гривен</td>
		    <td width="35%"><?php echo $this->showOne('uah'); ?></td>
		  </tr>
		</table>
		<?php
	}
} 


?>

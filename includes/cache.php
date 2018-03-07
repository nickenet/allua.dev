<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya. K
=====================================================
 Файл: cache.php
-----------------------------------------------------
 Назначение: Класс для кэширования информационных блоков
=====================================================
*/
 
class Cache

{
	private $data 	= array(); # Данные из модулей
	private $times 	= array(); # Время последнего кэширования для каждого модуля
	private $mini 	= array(); # Время актуальности кэша
	private $module = '';	   # Текущий модуль
	private $file 	= 'system/cache.dat';
	private $saving = true;	   # Сохранять ли данные в файл, активен ли сам кэш
	
	function __construct()
	{
		require 'conf/config.php';
		
		if ( !isset($def_cache_mod) || !isset($def_cache_time) )
		{
			$this->error('Укажите настройки для кеша.');
		}
		
		if ( $def_cache_mod!="YES" )
		{
			$this->saving = false;
			
			return;
		}
		
		$this->mini = time() - $def_cache_time * 60;
		
		if ( file_exists($this->file) )
		{
			$tmp = file_get_contents($this->file);
			$tmp = unserialize($tmp);
			
			$this->data  = unserialize($tmp['data']);
			$this->times = unserialize($tmp['times']);
		}
	}
	
	
	function error($message)
	{
		echo $message;
		
		exit;
	}
	
	
	function setModule($name)
	{
		$this->module = $name;
	}
	
	
	function unsetModule()
	{
		$this->module = '';
	}


	function checkModule()
	{
		if ($this->module == '')
		{
			$this->error('Укажите модуль.');
		}
		
		if ( !isset($this->times[ $this->module ]) )
		{
			$this->times[ $this->module ] = null;
		}
		
		if ( !isset($this->data[ $this->module ]) )
		{
			$this->data[ $this->module ] = null;
		}
	}
	
	
	function isActive()
	{
		$this->checkModule();

		if (!$this->saving 
			|| empty($this->times[ $this->module ]) 
			|| $this->times[ $this->module ] < $this->mini)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	
	function get()
	{
		$this->checkModule();

		return $this->data[ $this->module ];
	}
	
	
	function save($data)
	{
		$this->checkModule();

		if (!$this->saving)
		{
			return;
		}
		
		$this->data[  $this->module ] = $data;
		$this->times[ $this->module ] = time();
		
		if ( !file_exists($this->file) )
		{
			touch($this->file);
		}
		
		if ( !is_writable($this->file) )
		{
			$this->error('Ошибка записи кеша.');
		}
		
		$tmp 			= array();
		$tmp['data']  	= serialize($this->data);
		$tmp['times'] 	= serialize($this->times);
		$tmp 		  	= serialize($tmp);
		
		file_put_contents($this->file, $tmp);
	}
} 
?>

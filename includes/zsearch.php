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
 Назначение: Сохранение поисковых запросов
=====================================================
*/


class zSearch
{
	private $fileConf = 'conf/config.php';
	private $fileData = 'system/zsearch.dat';

	private $maxNum = 0;
	private $filter = '';

	private $data   = array();

	function __construct()
	{
		if ( !file_exists($this->fileConf) )
		{
			echo 'Вы не указали настройки!';

			exit;
		}

		include $this->fileConf;

		$this->maxNum = $def_zsearch_num;
		$this->filter = $def_zsearch_filter;

		if ( file_exists($this->fileData) )
		{
			$this->data = file_get_contents($this->fileData);
			$this->data = unserialize($this->data);
		}
	}


	function add($text, $num = 0)
	{
		$text = trim($text);
		if ($text === '')
		{
			return;
		}

		$this->filter = strtolower($this->filter);
		$list = explode(',', $this->filter);
		$tmp  = strtolower($text);
		foreach ($list as $v)
		{
			$v = trim($v);
			if (strpos($tmp, $v) !== false)
			{
				return;
			}
		}

		$this->data[] = array('text' => $text, 'num' => $num, 'time' => time());
		uasort($this->data, array('zSearch', 'sortTime'));
		array_splice($this->data, $this->maxNum);

		file_put_contents( $this->fileData, serialize($this->data) );
	}


	static function sortTime($a, $b)
	{
		if ($a['time'] == $b['time'])
		{
			return 0;
		}

		return $a['time'] < $b['time'] ? 1 : -1;
	}


	function get($num = 0)
	{

		global $def_mainlocation;
		
		if (!$num)
		{
			$num = $this->maxNum;
		}

		uasort($this->data, array('zSearch', 'sortTime'));
		array_splice($this->data, $num);

		foreach ($this->data as $v)
		{
			$text .= date('d.m.y H:i', $v['time'])
				.' <b><a href='.$def_mainlocation.'/search-1.php?locationcoded=ANY&search='.$v['text'].'>'
					.$v['text'].'</a></b> - найдено '.$v['num'].'<br>';
		}

		return $text;
	}


	function simular($text, $num = 0)
	{

		global $def_mainlocation;
		
		if (!$num)
		{
			$num = $this->maxNum;
		}

		$text = trim($text);
		if ($text === '')
		{
			return 'Не найдено';
		}

		$text = strtolower($text);
		uasort($this->data, array('zSearch', 'sortTime'));

		$list = array();
		reset($this->data);
		while ( count($list) < $num
			&& list(, $v) = each($this->data) )
		{
			$tmp = strtolower($v['text']);
			$add = false;
			if (strpos($tmp, $text) !== false)
			{
				$add = true;
			}
			else
			{
				$words = explode(' ', $text);
				foreach ($words as $w)
				{
					$w = trim($w);
					if (strlen($w) > 3 && strpos($tmp, $w) !== false)
					{
						$add = true;

						break;
					}
				}
			}

			if ($add)
			{
				$list[] = date('d.m.y H:i', $v['time'])
					.' <b><a href='.$def_mainlocation.'/search-1.php?locationcoded=ANY&search='.$v['text'].'>'
						.$v['text'].'</a></b> - найдено '.$v['num'];
			}
		}

		if ( empty($list) )
		{
			return 'Не найдено';
		}
		else
		{
			return join('<br>', $list);
		}
	}
}
?>
<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by K.Ilya
=====================================================
 Файл: banner_classes.php
-----------------------------------------------------
 Назначение: Класс управления баннерами
=====================================================
*/

class bannerAdmin
{
	const indexUrl	= '../';
	
	static $extList	= array('gif', 'jpg', 'png', 'bmp');
	static $list	= array();
	static $conf	= array();
	static $msg	= array();
	static $path	= array('top'  => 'banner/',
				'side' => 'banner2/');


	static function checkPost()
	{
		global $db, $db_users;

		if ( empty($_POST['action']) )
		{
			return;
		}

		$dir = '../' . self::$path[ self::$conf['type'] ];

		switch ($_POST['action'])
		{
			case 'delete':
			{
				$list = isset($_POST['list']) ? explode(',', $_POST['list']) : 0;
				foreach ($list as $name)
				{
					$name = $dir . $name;
					if (file_exists($name))
					{
						unlink($name);
					}

					if ( !empty($_POST['update_stat']) )
					{
						$id = explode('.', basename($name));
						$id = (int)$id[0];
						$sql = 'UPDATE `' . $db_users . '` SET banner_show = 0, banner_click = 0 '
							 . 'WHERE selector = ' . $id;
						$db->query($sql);
					}
				}

				self::$msg[] = 'Баннеры удаленны';
			}
				break;

			case 'edit':
			{
				$num = (int)$_POST['new_val'];
				$sql = array();
				$sql[] = 'UPDATE `' . $db_users . '` SET';
				if ( !empty($_POST['edit_click']) )
				{
					$sql[] = 'banner_click = ' . $num;
				}
				else
				{
					$sql[] = 'banner_show = ' . $num;
				}
				
				$sql[] = 'WHERE selector = ' . (int)$_POST['id'];
				$sql = join(' ', $sql);
				$db->query($sql);

				echo $num;
				
				exit;
			}
				break;
		}
	}


	static function parseConf($name, $reqName, $def)
	{
		$val = empty($_REQUEST[ $reqName ]) ? 0 : $_REQUEST[ $reqName ];
		if ($name == 'type')
		{
			if ( !in_array($val, array('side', 'top')) )
			{
				$val = 0;
			}
		}
		else
		{
			$val = (int)$val;
		}

		if (!$val)
		{
			$val = empty($_SESSION['banner'][ $name ]) ? 0 : $_SESSION['banner'][ $name ];
		}

		if (!$val)
		{
			$val = $def;
		}

		$_SESSION['banner'][ $name ] = $val;
		self::$conf[ $name ] = $val;
	}


	static function initConf()
	{
		self::parseConf('page',	 'p',  1);
		self::parseConf('limit', 'l', 10);
		self::parseConf('type',	 't', 'side');
	}


	static function loadData()
	{
		global $db, $db_users;

		$dir  = self::$path[ self::$conf['type'] ];
		$list = glob('../' . $dir . '*');

		$cleanList = array();
		foreach ($list as $file)
		{
			$path	= pathinfo($file);
			$id		= explode('.', $path['basename']);
			$id		= $id[0];
			$cleanList[ $id ] = array(	'ext'	=> $path['extension'],
										'firm'	=> '-',
										'click' => '',
										'show'	=> '',
										'date'	=> filemtime($file),
										'size'	=> filesize($file),
										'url'	=> self::indexUrl . $dir . $path['basename'],
										);
		}

		$list = array_filter($cleanList, array(self, 'filterExt'));

		self::$conf['max_page'] = ceil(count($list) / self::$conf['limit']);
		if (self::$conf['page'] > self::$conf['max_page'])
		{
			self::$conf['page']= self::$conf['max_page'];
			$_SESSION['banner']['page'] = self::$conf['page'];
		}

		$start	= (self::$conf['page'] - 1) * self::$conf['limit'];
		$list	= array_slice($list, $start, self::$conf['limit'], true);
		if ( empty($list) )
		{
			return;
		}

		$sql = 'SELECT selector, firmname, banner_show, banner_click FROM `' . $db_users . '` '
			 . 'WHERE selector IN (' . join(', ', array_keys($list)) . ')';
		#$row = array('id' => 1, 'firmname' => 'firm', 'banner_show' => 4, 'banner_click' => 3);
		$res = $db->query($sql);
		while ( $row = mysql_fetch_assoc($res) )
		{
			$tmp			=& $list[ $row['selector'] ];
			
			$tmp['firm']	= $row['firmname'];
			$tmp['click']	= $row['banner_click'];
			$tmp['show']	= $row['banner_show'];
		}

		unset($tmp);
		self::$list = $list;
	}


	static function filterExt($file)
	{
		return in_array($file['ext'], self::$extList);
	}


	static function countCtr(&$row)
	{
		$res = 0;
		if ($row['show'] != 0)
		{
			$res = ceil($row['click'] / $row['show'] * 100);
		}

		$res = $res . ' %';

		return $res;
	}
}
?>

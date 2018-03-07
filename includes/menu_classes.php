<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by K.Ilya
=====================================================
 Файл: menu_classes.php
-----------------------------------------------------
 Назначение: Класс управления меню
=====================================================
*/

class menuItem
{
	public $id = 0;
	public $name;
	public $url;
	public $title;
	public $target = '_self';
	public $image;
	public $active = 1;
	public $sorting = -1;

	public $noindex;
	public $fWidthOn;
	public $fWidth;
	public $fHeightOn;
	public $fHeight;


	final function setOn()
	{
		$this->active = true;
	}


	final function setOff()
	{
		$this->active = false;
	}


	function initNew()
	{
		$this->id = ++menuAdmin::$maxId;
	}


	function setPostData($skip, $checks)
	{
		foreach ($checks as $k)
		{
			$this->$k = (int)!empty($_POST[$k]);
		}

		foreach ($this as $k => $v)
		{
			if ( in_array($k, $skip) || in_array($k, $checks) )
			{
				continue;
			}
			
			# Значения без галок оставляю прежними.
			$ch = $k . 'On';
			if ( in_array($ch, $checks) && !$this->$ch )
			{
				continue;
			}

			$this->$k = isset($_POST[$k]) ? $_POST[$k] : '';
		}
	}


	function doUpload($key = 'image')
	{
		if ( !empty($_FILES[$key]) && is_uploaded_file($_FILES[$key]['tmp_name']) )
		{
			$name	= strtolower($_FILES[$key]['name']);
			$ext	= pathinfo($name, PATHINFO_EXTENSION);
			if (!in_array($ext, menuAdmin::$imgExt))
			{
				menuAdmin::log('Загружайте разрешённые картинки.');
				return false;
			}
			
			$name	= menuAdmin::imgPath . $this->id . '.' . $ext;
			if ( move_uploaded_file($_FILES[$key]['tmp_name'], $name) )
			{
				if ($this->image != $ext)
				{
					$this->doDelete();
				}
				
				$this->image = $ext;

				return $name;
			}
			else
			{
				menuAdmin::log('Ошибка загрузки файла.');
			}
		}

		return false;
	}


	function doDelete()
	{
		$name = menuAdmin::imgPath . $this->id . '.' . $this->image;
		if ( file_exists($name) )
		{
			unlink($name);
		}
	}

	
	function doSave()
	{
		$skip	= array('id', 'sorting', 'image');
		$checks = array('active', 'noindex', 'fWidthOn', 'fHeightOn');
		$this->setPostData($skip, $checks);

		$newFile = $this->doUpload();
	}


	function showLink()
	{

		global $def_mainlocation, $def_charset;
		
		$target = '';
		if ($this->target)
		{
			$target = ' target="' . $this->target . '"';
		}

		$rel = '';
		if ($this->noindex)
		{
			$rel = ' rel="nofollow"';
		}

		$http_op = strpos($this->url, "http");

		if ($http_op===false) $this->url=$def_mainlocation.$this->url;

		$res	= '<a href="' . $this->url . '" title="' . htmlspecialchars($this->title,ENT_QUOTES,$def_charset) . '" ' . $target . $rel . '>'
				.	htmlspecialchars($this->name,ENT_QUOTES,$def_charset)
				. '</a>';

		if ($this->noindex)
		{
			$res = '<noindex>' . $res . '</noindex>';
		}

		return $res;
	}

	
	function showImg($inAdmin = false)
	{

		global $def_mainlocation, $def_charset;		

		if (!$this->image)
		{
			return '';
		}
		
		$image	= $def_mainlocation.'/'.menuAdmin::imgUrl . $this->id . '.' . $this->image;
		
		$text	= htmlspecialchars($this->name,ENT_QUOTES,$def_charset);
		
		$size	= '';
		if ($this->fWidthOn)
		{
			$size .= ' width="' . $this->fWidth . '"';
		}

		if ($this->fHeightOn)
		{
			$size .= ' height="' . $this->fHeight . '"';
		}

		$res	= '<img src="' . $image . '" alt="' . $text . '" ' . $size . ' border="0" />';

		return $res;
	}
}


class menuAdmin
{
	const file			= '../system/menu.dat';
	const imgPath		= '../images/menu/';
	const imgUrl		= 'images/menu/';
	const adminUrl		= 'menu.php';
	
	static $list		= array();
	static $formItem	= null;
	static $formButton	= '';
	static $maxId		= 1;
	static $messages	= array();
	static $imgExt		= array('gif', 'png', 'bmp', 'jpg', 'jpeg', 'tif', 'tiff');
	
	static $targets = array('_blank'	=> '_blank (в новом окне)',
							'_top'		=> '_top (во всем текущем окне браузера)',
							'_self'		=> '_self (в текущем окне)',
							'_parent'	=> '_parent (в своем фреймсете)'
							);


	static function log($s)
	{
		self::$messages[] = $s;
	}


	static function checkSystem()
	{
		if (file_exists(self::file) && !is_writeable(self::file))
		{
			$t = filemtime(self::file);
			$message	= 'Ошибка записи файла данных!<br />'
						. 'Предыдущее обновление было ' . date('H:i d.m.Y', $t);
			self::log($message);
		}
	}


	static function loadData()
	{
		$selfDir = dirname(__FILE__) . '/';

		if (!file_exists($selfDir . self::file))
		{
			return;
		}

		$data = file_get_contents($selfDir . self::file);
		$data = unserialize($data);
		if (!is_array($data))
		{
			self::log('Файл данных повреждён, следует удалить его.');

			return;
		}

		if ($data)
		{
			self::$maxId = max(array_keys($data));
		}
		
		self::$list = $data;
	}


	function processPost()
	{
		$id = empty($_REQUEST['id']) ? 0 : (int)$_REQUEST['id'];
		self::$formItem = new menuItem();
		switch ($_REQUEST['do'])
		{
			case 'edit':
			{
				self::$formButton = 'Изменить';
				if ( isset(self::$list[$id]) )
				{
					self::$formItem = self::$list[$id];
				}
				else
				{
					self::log('Указанный пункт отсутствует.');
					break;
				}
			}

			default:
			case 'add':
			{
				
			}
				break;

			case 'update':
			{
				foreach (self::$list as &$item)
				{
					if (!empty($_REQUEST['active']))
					{
						$id = array_search($item->id, $_REQUEST['active']);
						if ($id !== false)
						{
							$item->setOn();
						}
						else
						{
							$item->setOff();
						}
					}

					if (!empty($_REQUEST['sort']))
					{
						$id = array_search($item->id, $_REQUEST['sort']);
						if ($id !== false)
						{
							$item->sorting = $id;
						}
					}
				}

				unset($item);

				self::flushData(true);
			}
				break;

			case 'save':
			{
				if ( isset(self::$list[$id]) )
				{
					$cont = self::$list[$id];
				}
				else
				{
					$cont = new menuItem();
					$cont->initNew();
				}

				$cont->doSave();
				self::$list[ $cont->id ] = $cont;
				self::flushData(true);
			}
				break;

			case 'delete':
			{
				if ( isset(self::$list[$id]) )
				{
					self::$list[$id]->doDelete();
					unset(self::$list[$id]);
					self::flushData(true);
				}
				else
				{
					self::log('Указанный пункт отсутствует.');
					break;
				}
			}
				break;
		}

		if (empty(self::$formButton))
		{
			self::$formButton = 'Сохранить';
		}

		uasort(self::$list, array('menuAdmin', 'sortShow'));
	}


	static function flushData($showMessage = false)
	{
		$data = serialize(self::$list);
		if (!file_put_contents(self::file, $data))
		{
			self::log('Ошибка записи файла.');
			
			return false;
		}
		elseif ($showMessage)
		{
			self::log('Данные обновленны.');
		}

		return true;
	}

	static function sortShow($cont1, $cont2)
	{
		if ($cont1->sorting == $cont2->sorting)
		{
			if ($cont1->sorting == -1)
			{
				if ($cont1->id != $cont2->id)
				{
					return ($cont1->id < $cont2->id) ? 1 : -1;
				}
			}

			return 0;
		}

		return ($cont1->sorting < $cont2->sorting) ? -1 : 1;
	}


	static function filterActive($cont)
	{
		return $cont->active;
	}
}
?>

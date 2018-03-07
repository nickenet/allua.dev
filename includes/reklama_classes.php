<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by K.Ilya
=====================================================
 Файл: reklama_classes.php
-----------------------------------------------------
 Назначение: Класс управления рекламными местами
=====================================================
*/
 
abstract class reklamBase
{
	public $id;
	public $title;
	public $pid;
	public $partner;
	public $active = 1;
	public $info;

	public $dateCreate;
	public $dateFrom;
	public $dateTo;

	public $maxShow;
	public $maxShowOn;
	public $numShow;


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
		if ( !empty($_POST['id']) )
		{
			$id = (int)$_POST['id'];
		}
		else
		{
			$id = ++reklamAdmin::$max['id'];
		}
		
		$this->id = $id;
		$this->pid = (int)$_POST['pid'];
		$this->dateCreate = time();
	}


	function parseDate(&$date)
	{
		# PHP >=5.3
		#$tmp = date_parse_from_format(reklamAdmin::dateFormat, $date);
		#$tmp = mktime(0, 0, 0, $tmp['month'], $tmp['day'], $tmp['year']);
		
		if ( empty($date) )
		{
			return 0;
		}
		
		# Формат вида dd.mm.YYYY
		$tmp = explode('.', $date);
		$tmp = mktime(0, 0, 0, (int)$tmp[1], (int)$tmp[0], (int)$tmp[2]);

		return $tmp;
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

		$this->dateFrom = $this->parseDate($this->dateFrom);
		$this->dateTo	= $this->parseDate($this->dateTo);
	}


	function doUpload($key = 'upload')
	{
		if ( !empty($_FILES[$key]) && is_uploaded_file($_FILES[$key]['tmp_name']) )
		{
			$name	= strtolower($_FILES[$key]['name']);
			$ext	= pathinfo($name, PATHINFO_EXTENSION);
			$name	= reklamAdmin::imgPath . $this->id . '.' . $ext;
			if ( move_uploaded_file($_FILES[$key]['tmp_name'], $name) )
			{
				if ($this->file != $ext)
				{
					$this->doDelete();
				}
				
				$this->file = $ext;

				return $name;
			}
			else
			{
				reklamAdmin::log('Ошибка загрузки файла.');
			}
		}

		return false;
	}


	abstract function doDelete();
	abstract function showEdit();
	abstract function doSave();
	abstract function doShow();

}


class reklamImg extends reklamBase
{
	public $type = 'img';
	public $file;
	public $url;
	public $target;
	public $alt;

	public $fWidth;
	public $fWidthOn;
	public $fHeight;
	public $fHeightOn;

	public $maxClick;
	public $maxClickOn;
	public $numClick;
	public $lastClickIp;


	function doDelete()
	{
		$name = reklamAdmin::imgPath . $this->id . '.' . $this->file;
		if ( file_exists($name) )
		{
			unlink($name);
		}
	}


	function doSave()
	{
		$skip	= array('id', 'pid', 'dateCreate', 'file');
		$checks = array('active', 'maxShowOn', 'maxClickOn', 'fWidthOn', 'fHeightOn');
		$this->setPostData($skip, $checks);

		$newFile = $this->doUpload();
	}


	function doShow()
	{

		global $def_mainlocation;
		global $def_rewrite;
                global $def_charset;


		$url	= $def_mainlocation . reklamAdmin::redirUrl . '?redir=' . $this->id;
		$file	= $def_mainlocation . reklamAdmin::imgUrl . $this->id . '.' . $this->file;
		$text	= htmlspecialchars($this->alt,ENT_QUOTES,$def_charset);
		$size	= '';
		if ($this->fWidthOn)
		{
			$size .= ' width="' . $this->fWidth . '"';
		}

		if ($this->fHeightOn)
		{
			$size .= ' height="' . $this->fHeight . '"';
		}

		$target = '';
		if ($this->target)
		{
			$target = ' target="' . $this->target . '"';
		}

		$res	= '<a href="' . $url . '" title="' . $text . '" ' . $target . '>'
				.	'<img src="' . $file . '" alt="' . $text . '" ' . $size . ' border="0" />'
				. '</a>';

		echo $res;
	}


	function  showEdit()
	{
            global $def_charset;
		?>
		<tr>
			<td class="tdr">
				Файл
			</td>
			<td>
				<input name="upload" value="" type="file" />
			</td>
		</tr>
		<tr>
			<td class="tdr">

			</td>
			<td>
				<?php
				if ($this->file)
				{
					$fUrl	= '..'.reklamAdmin::imgUrl . $this->id . '.' . $this->file;
					$fName	= reklamAdmin::imgPath . $this->id . '.' . $this->file;

					$size	= getimagesize($fName);
					$size	= $size[0] . ' x ' . $size[1] . ' px';

					$fSize	= filesize($fName);
					$fSize	= round($fSize / 1024) . ' KB';

					?>
					<div id="img_info">
						<img src="<?php echo $fUrl; ?>" alt="" /><br />
						Формат: <?php echo $this->file; ?><br />
						Размер: <?php echo $size; ?><br />
						Вес: <?php echo $fSize; ?>
					</div>
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="tdr">
				URL для перехода при клике на изображении
			</td>
			<td>
				<input name="url" value="<?php echo htmlspecialchars($this->url); ?>"
					   type="text" class="long" />
			</td>
		</tr>
		<tr>
			<td class="tdr">
				Где развернуть URL<br />
				(атрибут target)
			</td>
			<td>
				<select name="target" class="middle">
					<?php
					foreach (reklamAdmin::$targets as $key => $val)
					{
						$sel = $key == $this->target ? ' selected="selected"' : '';
						echo '<option value="' . $key . '"' . $sel . '>' . htmlspecialchars($val,ENT_QUOTES,$def_charset) . '</option>';
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="tdr">
				Текст всплывающей подсказки<br />
				(атрибут alt)
			</td>
			<td>
				<input name="alt" value="<?php echo htmlspecialchars($this->alt,ENT_QUOTES,$def_charset); ?>"
					   type="text" size="30" />
			</td>
		</tr>
		<tr>
			<td class="tdr">
				Задать строгий размер<br />
				(пиксели)
			</td>
			<td>
				<label for="ch_f_width_on">ширина</label>
				<input name="fWidthOn" id="ch_f_width_on" type="checkbox" value="1"
				  <?php echo $this->fWidthOn ? 'checked="checked"' : ''; ?> />
				<input name="fWidth" value="<?php echo htmlspecialchars($this->fWidth); ?>"
					   id="f_width" type="text" class="short" />

				<label for="ch_f_height_on">высота</label>
				<input name="fHeightOn" id="ch_f_height_on" type="checkbox" value="1"
				  <?php echo $this->fHeightOn ? 'checked="checked"' : ''; ?> />
				<input name="fHeight" value="<?php echo htmlspecialchars($this->fHeight); ?>"
					   id="f_height" type="text" class="short" />
			</td>
		</tr>
		<tr>
			<td class="tdr">
				Статистика:
			</td>
			<td>
				показов
				<input name="numShow" value="<?php echo htmlspecialchars($this->numShow); ?>"
					   type="text" class="short" />
				кликов
				<input name="numClick" value="<?php echo htmlspecialchars($this->numClick); ?>"
					   type="text" class="short" />
				CTR - <?php echo reklamAdmin::countCtr($this);  ?>
			</td>
		</tr>
		<tr>
			<td class="tdr">
				<label for="ch_max_click_on">Максимальное число кликов</label>
			</td>
			<td>
				<input name="maxClickOn" id="ch_max_click_on" type="checkbox" value="1"
				  <?php echo $this->maxClickOn ? 'checked="checked"' : ''; ?> />
				<input name="maxClick" value="<?php echo htmlspecialchars($this->maxClick); ?>"
					   id="max_click" type="text" class="short" />
			</td>
		</tr>
		<?php
	}
}


class reklamHtml extends reklamBase
{
	public $type = 'html';
	public $code;

	function doDelete()
	{
		;
	}


	function doSave()
	{
		$skip	= array('id', 'pid', 'dateCreate');
		$checks = array('active', 'maxShowOn');
		$this->setPostData($skip, $checks);
	}


	function  doShow()
	{
		$code_reklam=stripslashes($this->code);
		echo $code_reklam;
	}


	function  showEdit()
	{
		?>
		<tr>
			<td class="tdr">
				Код
			</td>
			<td>
				<textarea name="code" cols="40" class="long"
						  rows="10"><?php echo stripslashes(htmlspecialchars($this->code)); ?></textarea><br />
			</td>
		</tr>
		<tr>
			<td class="tdr">
				Статистика:
			</td>
			<td>
				показов
				<input name="numShow" value="<?php echo htmlspecialchars($this->numShow); ?>"
					   type="text" class="short" />
			</td>
		</tr>
		<?php
	}
}


class reklamFlash extends reklamBase
{
	public $type = 'flash';
	public $file;
	public $url;
	public $target;

	public $fWidth;
	public $fWidthOn;
	public $fHeight;
	public $fHeightOn;


	function doDelete()
	{
		$name = reklamAdmin::imgPath . $this->id . '.' . $this->file;
		if ( file_exists($name) )
		{
			unlink($name);
		}
	}


	function  doSave()
	{
		$skip	= array('id', 'pid', 'dateCreate', 'file');
		$checks = array('active', 'maxShowOn', 'fWidthOn', 'fHeightOn');
		$this->setPostData($skip, $checks);

		$newFile = $this->doUpload();
		if ($newFile && $this->file != 'swf')
		{
			reklamAdmin::log('Для flash допустимо только расширение swf.');
			reklamAdmin::log('Попытка загрузить "' . $this->file . '".');
			unlink($newFile);
			$this->file = null;
		}
	}


	function doShow()
	{

		global $def_mainlocation;
		global $def_rewrite;
                global $def_charset;

		$url	= $this->url;
		$file	= $def_mainlocation.reklamAdmin::imgUrl . $this->id . '.' . $this->file;
		$text	= htmlspecialchars($this->alt,ENT_QUOTES,$def_charset);
		$size	= '';
		if ($this->fWidthOn)
		{
			$size .= ' width="' . $this->fWidth . '"';
		}

		if ($this->fHeightOn)
		{
			$size .= ' height="' . $this->fHeight . '"';
		}

		$target = '';
		if ($this->target)
		{
			$target = ' target="' . $this->target . '"';
		}

		$res	= '<a href="' . $url . '" ' . $target . '>'
				.	'<object type="application/x-shockwave-flash" data="' . $file . '" ' . $size . '>
						<param name="movie" value="' . $file . '">
					</object>'
				. '</a>';

		echo $res;
	}


	function  showEdit()
	{
            global $def_charset;
		?>
		<tr>
			<td class="tdr">
				Файл
			</td>
			<td>
				<input name="upload" value="" type="file" />
			</td>
		</tr>
		<tr>
			<td class="tdr">

			</td>
			<td>
				<?php
				if ($this->file)
				{
					$fUrl	= '..'.reklamAdmin::imgUrl . $this->id . '.' . $this->file;
					$fName	= reklamAdmin::imgPath . $this->id . '.' . $this->file;

					$fSize	= filesize($fName);
					$fSize	= round($fSize / 1024) . ' KB';

					?>
					<div id="img_info">
						<object type="application/x-shockwave-flash" data="<?php echo $fUrl; ?>">
							<param name="movie" value="<?php echo $fUrl; ?>">
						</object><br />
						Формат: <?php echo $this->file; ?><br />
						Вес: <?php echo $fSize; ?>
					</div>
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="tdr">
				Установить ссылку на Flash-баннере<br />
				(если внутри ролика нет ссылок)
			</td>
			<td>
				<input name="url" value="<?php echo htmlspecialchars($this->url); ?>"
					   type="text" class="long" />
			</td>
		</tr>
		<tr>
			<td class="tdr">
				Где развернуть URL<br />
				(атрибут target)
			</td>
			<td>
				<select name="target" class="middle">
					<?php
					foreach (reklamAdmin::$targets as $key => $val)
					{
						$sel = $key == $this->target ? ' selected="selected"' : '';
						echo '<option value="' . $key . '"' . $sel . '>' . htmlspecialchars($val,ENT_QUOTES,$def_charset) . '</option>';
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="tdr">
				Задать строгий размер<br />
				(пиксели)
			</td>
			<td>
				<label for="ch_f_width_on">ширина</label>
				<input name="fWidthOn" id="ch_f_width_on" type="checkbox" value="1"
				  <?php echo $this->fWidthOn ? 'checked="checked"' : ''; ?> />
				<input name="fWidth" value="<?php echo htmlspecialchars($this->fWidth); ?>"
					   id="f_width" type="text" class="short" />

				<label for="ch_f_height_on">высота</label>
				<input name="fHeightOn" id="ch_f_height_on" type="checkbox" value="1"
				  <?php echo $this->fHeightOn ? 'checked="checked"' : ''; ?> />
				<input name="fHeight" value="<?php echo htmlspecialchars($this->fHeight); ?>"
					   id="f_height" type="text" class="short" />
			</td>
		</tr>
		<tr>
			<td class="tdr">
				Статистика:
			</td>
			<td>
				показов
				<input name="numShow" value="<?php echo htmlspecialchars($this->numShow); ?>"
					   type="text" class="short" />
			</td>
		</tr>
		<?php
	}
}


class reklamPlace
{
	public $id;
	public $title;
	public $info;
	public $subs = array();
	
	
	static function doNew()
	{
		$place = new self;
		$place->id		= ++reklamAdmin::$max['pid'];
		$place->title	= $_POST['title'];
		$place->info	= $_POST['info'];

		reklamAdmin::$list[ $place->id ] =& $place;
		reklamAdmin::flushData();
	}	

	
	static function doEdit()
	{
		reklamAdmin::$page = 'edit_place';
		$id = (int)$_GET['id'];
		if ( isset(reklamAdmin::$list[$id]) )
		{
			reklamAdmin::$pageData = reklamAdmin::$list[$id];
		}
		else
		{
			reklamAdmin::log('Такое место отсуствует.');
		}
	}
	
	
	static function doSave()
	{
		$pid = (int)$_POST['id'];
		if ( isset(reklamAdmin::$list[$pid]) )
		{
			if ( !empty($_POST['do_del']) )
			{
				foreach (reklamAdmin::$list[$pid]->subs as $cont)
				{
					$cont->doDelete();
				}
				
				unset(reklamAdmin::$list[$pid]);
			}
			else
			{
				reklamAdmin::$list[$pid]->title	= $_POST['title'];
				reklamAdmin::$list[$pid]->info	= $_POST['info'];
			}

			reklamAdmin::flushData(true);
		}
		else
		{
			reklamAdmin::log('Сохраняемое место отсуствует.');
		}
	}	
}


class reklamAdmin
{
	const file			= '../system/reklama.dat';
        const file_bak          = '../system/reklama.bak'; 
	const imgPath		= '../reklama/';
	const imgUrl		= '/reklama/';
	const indexUrl		= '';
	const redirUrl		= '/reklama.php';
	const adminUrl		= 'reklama.php';
	const dateFormat	= 'd.m.Y';
        const time_bak_file     = 10800; // сек, по умолчанию через 3 часа, через сколько времени делать копию файла, 0 - укажите если никогда
	
	static $list		= array();
	static $max			= array('pid' => 1, 'id' => 1);
	static $messages	= array();
	static $page		= '';
	static $pageData	= array();
	
	static $types	= array('img'		=> 'Изображение',
							'flash'		=> 'Flash',
							'html'		=> 'HTML'
							);
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
		chdir( dirname(__FILE__) );
		if (!file_exists(self::file))
		{
			return;
		}

		$data = file_get_contents(self::file);
		$data = unserialize($data);
		if (!isset($data['places'], $data['content'])
				|| !is_array($data['places']) || !is_array($data['content']))
		{
                    $data = file_get_contents(self::file_bak);
                    $data = unserialize($data);
		}

		if (!isset($data['places'], $data['content'])
				|| !is_array($data['places']) || !is_array($data['content']))
		{
			self::log('Файл данных повреждён, следует удалить его.');
			return;
		}

		if ($data['places'])
		{
			self::$max['pid']	= max(array_keys($data['places']));
		}

		if ($data['content'])
		{
			self::$max['id']	= max(array_keys($data['content']));
		}
		
		self::$list = $data['places'];
		foreach ($data['content'] as &$cont)
		{
			self::$list[ $cont->pid ]->subs[ $cont->id ] = $cont;
		}

		unset($cont);
	}


	static function checkPost()
	{
		if (empty($_REQUEST['action']))
		{
			return;
		}

		$action = $_REQUEST['action'];
		switch ($action)
		{
			case 'process':
			{
				$list = explode(',', $_POST['list']);
				$act = $_POST['do'];
				if ($act == 'edit')
				{
					array_splice($list, 1);
				}
				
				foreach (reklamAdmin::$list as $place)
				{
					foreach ($place->subs as $cont)
					{
						if ( !in_array($cont->id, $list) )
						{
							continue;
						}
						
						switch ($act)
						{
							case 'on':
							{
								$cont->setOn();
							}
								break;

							case 'off':
							{
								$cont->setOff();
							}
								break;

							case 'del':
							{
								$cont->doDelete();
								unset($place->subs[ $cont->id ]);
							}
								break;
						}
					}
				}

				reklamAdmin::flushData(true);
			}
				break;

			case 'new_place':
			case 'edit_place':
			case 'save_place':
			{
				$act = explode('_', $action);
				$act = 'do' . $act[0];
				
				reklamPlace::$act();
			}
				break;

			case 'new_content':
			{
				self::$page = 'edit';
				$name = self::getContentClass();
				self::$pageData = new $name;
				self::$pageData->initNew();
			}
				break;

			case 'save':
			{
				$name	= self::getContentClass();
				$id		= (int)$_POST['id'];
				$pid	= (int)$_POST['pid'];
				if ( isset(self::$list[ $pid ]) )
				{
					if ( isset(self::$list[ $pid ]->subs[$id]) )
					{
						$cont = self::$list[ $pid ]->subs[$id];
					}
					else
					{
						$cont = new $name;
						$cont->initNew();
					}

					$cont->doSave();
					self::$list[ $cont->pid ]->subs[ $cont->id ] =& $cont;
					self::flushData(true);
				}
				else
				{
					self::log('Указанное рекламное место для сохранения материала отсутствует.');
				}
			}
				break;

			case 'edit':
			{
				$id		= (int)$_GET['id'];
				$pid	= self::getPidById($id);
				if ($pid)
				{
					self::$page = 'edit';
					self::$pageData = self::$list[ $pid ]->subs[$id];
				}
				else
				{
					self::log('Указанное рекламное место отсутствует.');
				}
			}
				break;
		}
	}


	static function getPidById($id)
	{
		$res = 0;
		foreach (self::$list as $pid => $place)
		{
			foreach ($place->subs as $curId => $cont)
			{
				if ($curId == $id)
				{
					$res = $pid;

					break 2;
				}
			}
		}

		return $res;
	}


	static function getContentClass()
	{
		$types = array_keys(self::$types);

		$type = $_POST['type'];
		if ( !in_array($type, $types) )
		{
			$type = array_slice($types, 2, 1);
		}

		$name = 'reklam' . $type;

		return $name;
	}


	static function flushData($showMessage = false)
	{
		$data = array();
		$data['places']		= array();
		$data['content']	= array();

		foreach (self::$list as $row)
		{
			$row = clone $row;
			foreach ($row->subs as $cont)
			{
				$data['content'][ $cont->id ] = $cont;
			}

			$row->subs = array();
			$data['places'][ $row->id ] = $row;
		}

		$data = serialize($data);
		if (!file_put_contents(self::file, $data))
		{
			self::log('Ошибка записи файла.');
			
			return false;
		}
		elseif ($showMessage)
		{
			self::log('Данные обновленны.');
		}
                if ($showMessage!=false)  $file_put_contents_bak = file_put_contents(self::file_bak, $data);

                if (self::time_bak_file!=0) {

                    $time_bak=time();
                    $time_file=filemtime(self::file_bak);
                    $time_bak_ok=$time_bak-$time_file;
                
                if ($time_bak_ok>self::time_bak_file) $file_put_contents_bak = file_put_contents(self::file_bak, $data);

                }

		return true;
	}


	static function countCtr(&$row)
	{
		$res = 0;
		if ($row->numShow != 0)
		{
			$res = ceil($row->numClick / $row->numShow * 100);
		}

		$res = $res . ' %';

		return $res;
	}


	static function sortShow($cont1, $cont2)
	{
		$cont1 = $cont1->numShow;
		$cont2 = $cont2->numShow;
		if ($cont1 == $cont2)
		{
			return 0;
		}

		return ($cont1 < $cont2) ? -1 : 1;
	}


	static function filterActive($cont)
	{
		$tt = (($cont->dateFrom <= time() || $cont->dateFrom == 0)
				&& (time() <= $cont->dateTo || $cont->dateTo == 0));
		
		return ($cont->active && $tt);
	}
}
?>

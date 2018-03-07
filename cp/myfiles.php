<?php
/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by K.Ilya
=====================================================
 Файл: myfiles.php
-----------------------------------------------------
 Назначение: Мои файлы
=====================================================
*/

error_reporting(E_ALL);

session_start();

require_once './defaults.php';
require_once './inc/bmp_lib.php';

$help_section = (string)$myfiles_help;

$title_cp = 'Мои файлы - ';
$speedbar = ' | <a href="myfiles.php">Мои файлы</a>';

check_login_cp('3_8','myfiles.php');

require_once 'template/header.php';

FileViewer::main();

require_once 'template/footer.php';


class FileViewer
{
	const START_DIR = '../myfiles';
	const BASE_URL = '/myfiles';
	const UP_DIR = '..';

	static $imageTypes = array('jpg', 'png', 'gif', 'bmp');
	static $curDir = '/';
	static $list = array();
	static $sort = array('list' => array('name', 'ext', 'date'),
		'current' => array('key' => 'name', 'val' => 'A'),
		'html' => array());

	static function load($file)
	{
		if (is_dir($file))
		{
			return new DirType($file);
		}

		$ext = FileType::get_ext($file);
		if (in_array($ext, self::$imageTypes))
		{
			return new FileTypeImage($file);
		}

		return new FileType($file);
	}

	static function init_list()
	{
		$dir = self::START_DIR . self::$curDir;

		if (!file_exists($dir))
		{
			return false;
		}

		self::$list = glob($dir . '{,.}*', GLOB_BRACE);
		self::$list = array_map(array('self', 'load'), self::$list);
		self::$list = array_filter(self::$list, array('self', 'filter_list'));

		if (!empty($_GET['sort']))
		{
			list($sKey, $sVal) = explode('_', $_GET['sort']);

			if (in_array($sKey, self::$sort['list']) && ($sVal == 'A' || $sVal == 'Z'))
			{
				self::$sort['current'] = array('key' => $sKey, 'val' => $sVal);
			}
		}

		$sUrl = '?dir=' . basename(self::$curDir) . '&sort=';
		foreach (self::$sort['list'] as $key)
		{
			if (self::$sort['current']['key'] == $key)
			{
				$val = self::$sort['current']['val'];
				$sVal = ($val == 'A' ? 'Z' : 'A');
				$html = '<a href="' . $sUrl . $key . '_' . $sVal . '">'
						. '<img src="images/sort' . $val . '.gif" alt="' . $val . '" /></a>';
			}
			else
			{
				$html = '<a href="' . $sUrl . $key . '_A">'
						. '<img src="images/sortA.gif" alt="A" /></a>'
						. '<a href="' . $sUrl . $key . '_Z">'
						. '<img src="images/sortZ.gif" alt="Z" /></a>';
			}

			self::$sort['html'][$key] = $html;
		}

		unset($val);

		usort(self::$list, array('self', 'sort_list'));
	}

	static function main()
	{
		if (!empty($_GET['dir']))
		{
			self::$curDir = self::$curDir . $_GET['dir'] . '/';
		}

		$uploader = new FileUpload();
		
		self::show_head();
		echo '<br />';
		echo '<div style="color: green; text-align: center">' . $uploader->message . '</div>';
		echo '<div style="color: red; text-align: center">' . $uploader->error . '</div>';
		echo '<br />';
		self::show_load_form();
		self::show_list();
	}

	static function show_head()
	{
		?>
		<table width="100%" border="0">
			<tr>
				<td>
					<img src="images/myfiles.png" width="32" height="32" align="absmiddle" alt="" />
					<span class="maincat">&nbsp;Мои файлы</span>
				</td>
			</tr>
			<tr>
				<td height="1" bgcolor="#D7D7D7"></td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="3"><img alt="" src="images/button-l.gif" width="3" height="34" /></td>
							<td style="background: url('images/button-b.gif')">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" alt="" /></td>
										<td class="vclass" align="left">
											<img src="images/folders_open.png" width="16" height="16" alt="" align="absmiddle" />
											Текущая директория <b><?php echo self::$curDir ?></b>
										</td>
										<td class="vclass" align="left"><?php self::show_new_form() ?></td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
							<td width="3"><img alt="" src="images/button-r.gif" width="5" height="34" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<?php
	}

	static function show_list()
	{
		self::init_list();

		$sort = self::$sort['html'];
		echo <<<HTML
		<form method="post" action="" onsubmit="return confirm('Удалить файлы?');">
			<table style="width:900px" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td id="table_files_b">&nbsp;</td>
				<td id="table_files_bc">название {$sort['name']}</td>
				<td id="table_files_b"style="text-align: center">расширение {$sort['ext']}</td>
				<td id="table_files_bc" style="text-align: center">размер</td>
				<td id="table_files_b" style="text-align: center">дата {$sort['date']}</td>
				<td id="table_files_bc" style="text-align: center">ширина</td>
				<td id="table_files_b" style="text-align: center">высота</td>
			</tr>
HTML;
		$totalSize = 0;
		foreach (self::$list as $item)
		{
			if (!empty($_POST['del'][$item->hash]))
			{
				$item->do_delete();

				continue;
			}

			$totalSize += $item->size;
			echo '<tr class="selecttr">
				' . $item->print_view() . '</tr>';
			echo '<tr><td height="1" colspan="7" bgcolor="#A6B2D5"></td></tr>';
		}

		echo '<tr>
				<td colspan="2"><br /><input type="submit" value="Удалить" /></td>
				<th>Всего</th>
				<th>' . self::format_size($totalSize) . '</th>
				</tr>
				</table>
			
			</form>';
	}

	static function show_new_form()
	{
		if (self::$curDir == '/')
		{
			echo <<<HTML
			<form method="post" action="">
			<img alt="" src="images/folder_new.png" width="16" height="16" align="absmiddle" />
			<input type="text" value="" name="new_dir" />
			<input type="submit" value="Создать директорию" />
			</form>
HTML;
		}
	}

	static function return_bytes($val)
	{
		$val = trim($val);
		$last = strtolower($val{strlen($val) - 1});
		switch ($last)
		{
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}

	static function show_load_form()
	{
		$maxSize = ini_get('upload_max_filesize');
		$maxSize = self::return_bytes($maxSize);

		?>
			<script type="text/javascript">
			var itemRow;
			$(function(){
				itemRow = $('.item_row').first().clone();
				$('input[name="resize"]').click(function(){
					$('#resize_box').toggle(this.checked);
				});
			});
			
			function load_more()
			{
				if ($('.item_list .item_row').length >= 10)
				{
					return;
				}

				itemRow.clone().appendTo('.item_list');
			}

			function load_less()
			{
				$('.item_row').last().remove();
			}
			</script>
			<form method="post" action="" enctype="multipart/form-data" style="text-align: center">
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxSize ?>" />
			<table width="700px" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td width="220" id="table_files">Откуда</td>
					<td id="table_files_r">Файл</td>
				</tr>
				<tr>
					<td width="220" id="table_files_i">С жесткого диска</td>
					<td id="table_files_i_r">
						<div style="float:right">
							<input type="button" onclick="load_less()" value="-" style="width:20px;" />
							<input type="button" onclick="load_more()" value="+" style="width:20px;" />&nbsp;
						</div>
						<div class="item_list">
							<div class="item_row">
								<input type="file" value="" name="new_file[]" size="40" />
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td width="220" id="table_files_i">С сервера (URL): </td>
					<td id="table_files_i_r">
						<input type="text" name="new_file_url" maxlength="100" size="40" />
					</td>
				</tr>
				<tr>
					<td width="220" id="table_files_i">
						Обработать картинки:
					</td>
					<td id="table_files_i_r">
						<label>
							Наложить водяной знак
							<input type="checkbox" name="wattermark" value="on" />
						</label>
						<br />
						<label>
							Изменить размер
							<input type="checkbox" name="resize" value="on" />
						</label><br/>
						<div id="resize_box" style="display: none">
							<br />Ширина: <input type="text" name="r_width" value="" size="5" /> Высота: <input type="text" name="r_height" value="" size="5" /><br /><br />
						</div>
					</td>
				</tr>
			</table>
			
			<br/>
			<input type="submit" value="Загрузить" />
			</form>
			<br/>
			<br/>
			<?php
	}

	static function filter_list(FileType $item)
	{
		$remove = array('.', '.htaccess');
		if (self::$curDir == '/')
		{
			$remove[] = self::UP_DIR;
		}

		return!in_array($item->baseName, $remove);
	}

	static function sort_list(FileType $item1, FileType $item2)
	{
		if ($item1 instanceof DirType || $item2 instanceof DirType)
		{
			if (!($item2 instanceof DirType) || strcmp($item1->baseName, self::UP_DIR) == 0)
			{
				return -1;
			}

			if (!($item1 instanceof DirType) || strcmp($item2->baseName, self::UP_DIR) == 0)
			{
				return 1;
			}
		}

		$sKey = self::$sort['current']['key'];
		$sort1 = strtolower($item1->$sKey);
		$sort2 = strtolower($item2->$sKey);
		$res = strcmp($sort1, $sort2);
		if (self::$sort['current']['val'] == 'Z')
		{
			$res *= - 1;
		}

		return $res;
	}

	static function format_size($size)
	{
		$list = array('B', 'KB', 'MB', 'GB', 'TB');
		$baseNum = 1024;
		if ($size >= $baseNum)
		{
			$pow = log($size, $baseNum);
			$pow = floor($pow);
			$size /= pow(1024, $pow);
		}
		else
		{
			$pow = 0;
		}

		$size = number_format($size, ($pow >= 1) ? 2 : 0);

		return $size . ' ' . $list[$pow];
	}

}

class FileType
{

	public $baseName;
	public $name;
	public $ext;
	public $size;
	public $date;
	public $hash;
	public $path;

	public function __construct($path)
	{
		if (!file_exists($path))
		{
			return false;
		}

		$this->baseName = basename($path);
		$this->hash = md5($this->baseName);
		$this->name = pathinfo($path, PATHINFO_FILENAME);
		$this->ext = self::get_ext($path);
		$this->size = filesize($path);
		$this->date = filemtime($path);
		$this->path = $path;

		return true;
	}

	static function get_ext($path)
	{
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$ext = strtolower($ext);

		return $ext;
	}

	public function print_view()
	{
		if (strcmp($this->baseName, FileViewer::UP_DIR))
		{
			$delBox = '<input type="checkbox" name="del[' . $this->hash . ']" value="1" />';
		}
		else
		{
			$delBox = '';
		}

		$row = '<td style="text-align: center">' . $delBox . '</td>
				<td style="text-align: center" class="slink" height="25">' . $this->get_link() . '</td>
				<td style="text-align: center">' . $this->ext . '</td>
				<td style="text-align: center">' . FileViewer::format_size($this->size) . '</td>
				<td style="text-align: center">' . date('d.m.Y H:i', $this->date) . '</td>';

		return $row;
	}

	public function get_link()
	{
	
	global $def_mainlocation;

		// $url = FileViewer::BASE_URL . FileViewer::$curDir . $this->baseName;
		$url = $def_mainlocation . FileViewer::BASE_URL . FileViewer::$curDir . $this->baseName;
		$link = sprintf('<a href="%s" target="_blank">%s</a>', $url, $this->name);

		return $link;
	}

	public function do_delete()
	{
		$file = FileViewer::START_DIR . FileViewer::$curDir . $this->baseName;
		if (file_exists($file))
		{
			unlink($file);
		}
	}

}

class DirType extends FileType
{

	public function __construct($path)
	{
		parent::__construct($path);

		$this->size = 0;
		if (strcmp($this->baseName, FileViewer::UP_DIR))
		{
			# Размер файлов в директории
			$list = glob($path . '/*');
			if ($list)
			{
				foreach ($list as $f)
				{
					$this->size += filesize($f);
				}
			}
		}
	}

	public function get_link()
	{

		if ($this->name == '.')
		{
			$title = FileViewer::UP_DIR;
			$url = $_SERVER['PHP_SELF'];
		}
		else
		{
			$title = $this->name;
			$url = $_SERVER['PHP_SELF'] . '?dir=' . $this->name;
		}

		$link = sprintf('[ <a href="%s">%s</a> ]', $url, $title);

		return $link;
	}

	public function do_delete()
	{
		$path = FileViewer::START_DIR . FileViewer::$curDir . $this->baseName;
		$list = glob($path . '/*');
		if ($list)
		{
			foreach ($list as $file)
			{
				unlink($file);
			}
		}

		rmdir($path);
	}

}

class FileTypeImage extends FileType
{

	public $width;
	public $height;

	public function __construct($path)
	{
		$parent = parent::__construct($path);
		if (!$parent)
		{
			return false;
		}

		list($this->width, $this->height) = getimagesize($path);

		return true;
	}

	public function print_view()
	{
		$row = parent::print_view();

		$row .= '<td style="text-align: center">' . $this->width . '</td>
				<td style="text-align: center">' . $this->height . '</td>';

		return $row;
	}

	public function resize($w, $h)
	{
		$w = (int)$w;
		$h = (int)$h;
		if ($w < 0 || $h < 0
				|| (!$w && !$h))
		{
			return;
		}

		if (!$w || !$h)
		{
			$ratio = $this->width / $this->height;
			if (!$w)
			{
				$w = $h * $ratio;
			}

			if (!$h)
			{
				$h = $w / $ratio;
			}

			$w = floor($w);
			$h = floor($h);
		}

		$img = $this->create();
		$imgNew = imagecreatetruecolor($w, $h);
		imagecopyresampled($imgNew, $img, 0, 0, 0, 0, $w, $h, $this->width, $this->height);

		$this->width = $w;
		$this->height = $h;

		$this->save($imgNew);
	}

	private function create()
	{
		$img = null;
		switch ($this->ext)
		{
			case 'jpg':
				{
					$img = imagecreatefromjpeg($this->path);
				}
				break;

			case 'png':
				{
					$img = imagecreatefrompng($this->path);
				}
				break;

			case 'gif':
				{
					$img = imagecreatefromgif($this->path);
				}
				break;

			case 'bmp':
				{
					$img = imagecreatefrombmp($this->path);
				}
				break;
		}

		return $img;
	}

	private function save(&$img)
	{
		switch ($this->ext)
		{
			case 'jpg':
				{
					imagejpeg($img, $this->path);
				}
				break;

			case 'png':
				{
					imagepng($img, $this->path);
				}
				break;

			case 'gif':
				{
					imagegif($img, $this->path);
				}
				break;

			case 'bmp':
				{
					imagebmp($img, $this->path);
				}
				break;
		}
	}

	public function watermark()
	{
		$file = '../foto/_watermark.png';
		if (!file_exists($file))
		{
			return;
		}

		$wm = imagecreatefrompng($file);
		list($w, $h) = getimagesize($file);
		$x = $this->width - $w;
		$y = $this->height - $h;

		if ($x < 0 || $y < 0)
		{
			return;
		}

		$img = $this->create();
		imagecopy($img, $wm, $x, $y, 0, 0, $w, $h);

		$this->save($img);
	}

}

class FileUpload
{
	public $message;
	public $error;

	function __construct()
	{
		if (!empty($_POST['new_file_url']))
		{
			$this->load_url($_POST['new_file_url']);
		}

		if (!empty($_FILES['new_file']['name'][0]))
		{
			$this->load_list($_FILES['new_file']);
		}

		if (!empty($_POST['new_dir']))
		{
			$this->new_dir($_POST['new_dir']);
		}
	}

	static function getFilePath($name)
	{
		$name = basename($name);
		$name = preg_replace('#[^a-z0-9\._-]#i', '_', $name);
		$name = preg_replace('#[_]{2,}#', '_', $name);
		if ($name == '')
		{
			$name = 'blank.name';
		}

		return FileViewer::START_DIR . FileViewer::$curDir . $name;
	}

	function new_dir($dir)
	{
		$path = self::getFilePath($dir);
		if (!mkdir($path, 0777))
		{
			$this->error = 'Ошибка создания директории.';
			return;
		}

		$this->message = 'Создание директории успешно.';
	}

	function load_url($url)
	{
		$tmp = parse_url($url, PHP_URL_SCHEME);
		if (empty($tmp))
		{
			$this->error = 'Такой адрес отсутствует.';
			return;
		}

		$path = parse_url($url, PHP_URL_PATH);
		$path = self::getFilePath($path);
		$data = file_get_contents($url);
		if ($data === false)
		{
			$this->error = 'Данные по адресу отсутствуют.';
			return;
		}

		$res = file_put_contents($path, $data);
		if ($res === false)
		{
			$this->error = 'Ошибка записи данных.';
			return;
		}

		$this->message = 'Копирование файла успешно.';

		$this->post_process($path);
	}

	function load_list(array $list)
	{
		foreach ($list['name'] as $num => $name)
		{
			if (!is_uploaded_file($list['tmp_name'][$num]))
			{
				$this->error = 'Ошибка загрузки файла.';
				return;
			}

			$path = self::getFilePath($name);
			if (!move_uploaded_file($list['tmp_name'][$num], $path))
			{
				$this->error = 'Ошибка копирования файла.';
				return;
			}

			$this->message = 'Загрузка файла успешна.';
			$this->post_process($path);
		}
	}

	function post_process($file)
	{
		$item = FileViewer::load($file);
		if ($item instanceof FileTypeImage)
		{
			if (!empty($_POST['resize'])
					&& (!empty($_POST['r_width']) || !empty($_POST['r_height'])))
			{
				$item->resize($_POST['r_width'], $_POST['r_height']);
			}

			if (!empty($_POST['wattermark']))
			{
				$item->watermark();
			}
		}
	}

}

<?php

/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by K.Ilya
  =====================================================
  Файл: tarif_manager.php
  -----------------------------------------------------
  Назначение: Класс по работе с тарифным планом
  =====================================================
 */

class TarifManager
{

	public $confFile = '../../conf/memberships.php';
	static $order = array('D', 'C', 'B', 'A');
	static $labels = array(
		'price' => 'Стоимость пребывания',
		'expiration' => 'Срок (в днях)',
		'description' => 'Описание компании',
		'address' => 'Адрес',
		'zip' => 'Индекс',
		'phone' => 'Телефонный номер',
		'fax' => 'Факс',
		'mobile' => 'Мобильный номер',
		'icq' => 'ICQ',
		'manager' => 'Контактное лицо',
		'email' => 'E-mail адрес',
		'www' => 'Адрес сайта',
		'map' => 'Путь маршрута',
		'filial' => 'Филиалы',
		'review' => 'Управление комментариями',
		'stat' => 'Расширенная статистика',
		'social' => 'Подключение социальной страницы к каталогу',
		'logo' => 'Логотип компании',
		'sxema' => 'Схема проезда',
		'maps' => 'Местоположение на карте',
		'banner' => 'Верхний баннер',
		'infoblock' => 'Информационный блок',
                'banner2' => 'Маленькие баннеры',
		'setinfo' => 'Количество публикаций',
		'products' => 'Продукция и услуги',
		'setproducts' => 'Количество наименований',
		'offer_thumbnail' => 'Показ изображений',
		'offerIM' => 'Загрузка изображений',
		'images' => 'Галерея изображений',
		'setimages' => 'Количество изображений',
		'exel' => 'Прайсы',
		'setexel' => 'Количество прайсов',
		'video' => 'Видеоролики',
		'konstruktor' => 'Конструктор сайтов',
		'setvideo' => 'Количество видеороликов'
	);
	public $list = array();

	/**
	 * Загружает данные из конфигурационного файла в $this->list для обработки
	 */
	function load_config()
	{
		$this->confFile = dirname(__FILE__) . '/' . $this->confFile;
		$data = file_get_contents($this->confFile);
		$matches = array();
		preg_match_all('#\$def_([a-z])_([a-z_]+\w) = "([^"]+)"#i', $data, $matches, PREG_SET_ORDER);
		foreach ($matches as $row)
		{
			$this->list[$row[1]][$row[2]] = $row[3];
		}

		# Проверяем все ли значения для каждого плана определенны
		$first = array_slice($this->list, 0, 1);
		$first = array_shift($first);

		foreach ($this->list as $key => $item)
		{
			$diff = array_diff_key($first, $item);
			if (!$diff)
			{
				$diff = array_diff_key($item, $first);
			}

			if ($diff)
			{
				echo 'В тарифе ', $key, ' обнаружены различия:', print_r($diff, 1), '<br><br>';
			}
		}
	}

	/**
	 * Показывает значение для всех тарифных планов
	 * 
	 * @param string $key название конфигурации
	 * @param boolean $edit формат для редактирования?
	 */
	static function show_row($key, $edit = false)
	{
		$row = '<td class="row_title">' . self::$labels[$key] . '</td>';
		foreach (self::$order as $tarif)
		{
			$var = 'def_' . $tarif . '_' . $key;
			$var = $GLOBALS[$var];
			if ($edit)
			{
				if (self::is_bool($var))
				{
					$checked = $var == 'YES' ? 'checked="checked"' : '';
					$var = sprintf('<input type="checkbox" name="def[%s][%s]" value="YES" %s />', $tarif, $key, $checked);
				}
				else
				{
					$var = sprintf('<input type="text" name="def[%s][%s]" value="%s" />', $tarif, $key, htmlspecialchars($var));
				}
			}
			else
			{
				if (self::is_bool($var))
				{
					$var = ifcompare($var, true);
				}
			}

			$row .= '<td>' . $var . '</td>';
		}

		$row = '<tr>' . $row . '</tr>';

		echo $row;
	}

	/**
	 * Проверяет, является ли значение бинарным
	 * 
	 * @param string $var
	 * @return boolean бинарное значение?
	 */
	static function is_bool($var)
	{
		return ($var == 'YES' || $var == 'NO');
	}

	/**
	 * Отображает все загруженные значения в виде формы
	 */
	function edit_all()
	{
		foreach ($this->list['D'] as $key => $value)
		{
			self::show_row($key, true);
		}
	}

	/**
	 * Сохраняем данные из формы в базу и в конфигурационный файл
	 * 
	 * @return array список сообщений
	 */
	function update()
	{
		$dbList = array(
			'prices' => 'setproducts',
			'images' => 'setimages',
			'exel' => 'setexel',
			'video' => 'setvideo');
		foreach (self::$order as $tarif)
		{
			$sql = array();
			foreach ($dbList as $dbKey => $varKey)
			{
				$sql[] = $dbKey . ' = ' . (int)$_POST['def'][$tarif][$varKey];
			}

			$sql = 'UPDATE ' . $GLOBALS['db_users'] . ' SET ' . join(', ', $sql) . ' WHERE flag = "' . $tarif . '"';
                        $GLOBALS['db']->query($sql) or die('ERROR: mySQL error, can\'t update USERS. (cpmemberships.php): ' . mysql_error());
		}
  
		# Обновление файла
		$messages = array();
		$data = file_get_contents($this->confFile);
		foreach (self::$order as $tarif)
		{
			foreach ($this->list[$tarif] as $key => $value)
			{
				$var = '';
				if (isset($_POST['def'][$tarif][$key]))
				{
					$var = $_POST['def'][$tarif][$key];
				}

				if (self::is_bool($value))
				{
					if ($var != 'YES')
					{
						$var = 'NO';
					}
				}

				$oldConf = sprintf('$def_%s_%s = "%s"', $tarif, $key, $value);
				$newConf = sprintf('$def_%s_%s = "%s"', $tarif, $key, $var);
				if ($newConf !== $oldConf)
				{
					# Обновляем текущее значение, чтобы было в таблице видно
					$var = $GLOBALS['def_' . $tarif . '_' . $key] = $var;

					$count = 0;
					$data = str_replace($oldConf, $newConf, $data, $count);
					if (!$count)
					{
						$messages[] = 'Значение ' . $oldConf . ' отсутствует';
					}
				}
			}
		}

		@chmod(dirname($this->confFile), 0777);
		# Делаю копию файла перед записью
		copy($this->confFile, $this->confFile . '.bak');
		@chmod($this->confFile, 0666);
		
		$fp = fopen($this->confFile, 'w+') or die('Извините, невозможно записать в файл <b>' . $this->confFile . '</b><br />
			Проверьте правильность проставленного CHMOD для файла и папки!');
		$count = fwrite($fp, $data);
		fclose($fp);
		
		@chmod($this->confFile, 0644);
		@chmod(dirname($this->confFile), 0755);
		
		if (!$count)
		{
			$messages[] = 'Отсутствует возможность записи в файл ' . $this->confFile;
		}

		return $messages;
	}

}

?>

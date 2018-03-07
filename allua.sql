-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 07 2018 г., 16:22
-- Версия сервера: 5.6.37-log
-- Версия PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `allua`
--

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_admin`
--

CREATE TABLE `pmd_admin` (
  `login` text,
  `password` text,
  `num` int(10) UNSIGNED NOT NULL,
  `IP` text,
  `name` text,
  `mail` text,
  `icq` int(11) DEFAULT NULL,
  `phone` text,
  `adress` text,
  `menu` text,
  `access` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pmd_admin`
--

INSERT INTO `pmd_admin` (`login`, `password`, `num`, `IP`, `name`, `mail`, `icq`, `phone`, `adress`, `menu`, `access`) VALUES
('nicke', 'ce6a67d0b5d3fababb07e43d61105717', 1, NULL, NULL, 'mail@domain.com', NULL, NULL, NULL, '0:1:1:0:1:0#<li><a href=\"firms.php?REQ=auth\">Активация контрагентов</a></li><li><a href=\"register.php\">Создать нового контрагента</a></li><li><a href=\"reviews2.php?REQ=auth\">Одобрить комментарии</a></li>', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_case`
--

CREATE TABLE `pmd_case` (
  `id` int(10) UNSIGNED NOT NULL,
  `firmselector` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `notes` text NOT NULL,
  `banking` text NOT NULL,
  `contact` text NOT NULL,
  `bin` varchar(255) NOT NULL DEFAULT '',
  `info` text NOT NULL,
  `alpha` varchar(5) NOT NULL DEFAULT '',
  `codefirm` varchar(6) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_category`
--

CREATE TABLE `pmd_category` (
  `selector` int(11) DEFAULT NULL,
  `category` text,
  `sccounter` int(11) NOT NULL DEFAULT '0',
  `ssccounter` int(11) NOT NULL DEFAULT '0',
  `fcounter` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `img` text,
  `title` text,
  `description` text,
  `keywords` text,
  `description_full` text,
  `recomend` text,
  `ip` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_categorynews`
--

CREATE TABLE `pmd_categorynews` (
  `selector` int(10) UNSIGNED NOT NULL,
  `status_off` tinyint(1) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `ncount` int(11) NOT NULL,
  `top` int(11) NOT NULL,
  `img` text NOT NULL,
  `description` text NOT NULL,
  `metatitle` varchar(255) NOT NULL DEFAULT '',
  `metadescr` varchar(255) NOT NULL DEFAULT '',
  `metakeywords` text NOT NULL,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `short_tpl` varchar(50) NOT NULL DEFAULT '',
  `full_tpl` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pmd_categorynews`
--

INSERT INTO `pmd_categorynews` (`selector`, `status_off`, `category`, `name`, `ncount`, `top`, `img`, `description`, `metatitle`, `metadescr`, `metakeywords`, `ip`, `short_tpl`, `full_tpl`) VALUES
(1, 0, 'Новости каталога', 'Novostiikataloga', 1, 0, '', 'Возможности <span style=\"font-weight: bold;\">нашего каталога. Новости, акции, объявления.<br>', 'Новости каталога', 'Наши новости. Возможности каталога фирм.', 'новости, каталог, фирмы, справка, бизнес, купить, товар', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_complaint`
--

CREATE TABLE `pmd_complaint` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` text NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `firmselector` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_engines`
--

CREATE TABLE `pmd_engines` (
  `id` int(10) UNSIGNED NOT NULL,
  `firmselector` int(11) NOT NULL,
  `yandex` int(11) NOT NULL,
  `google` int(11) NOT NULL,
  `mail` int(11) NOT NULL,
  `bing` int(11) NOT NULL,
  `yahoo` int(11) NOT NULL,
  `rambler` int(11) NOT NULL,
  `aport` int(11) NOT NULL,
  `twitter` int(11) NOT NULL,
  `facebook` int(11) NOT NULL,
  `odnoklassniki` int(11) NOT NULL,
  `vk` int(11) NOT NULL,
  `mymail` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_exelp`
--

CREATE TABLE `pmd_exelp` (
  `firmselector` int(11) DEFAULT NULL,
  `num` int(10) UNSIGNED NOT NULL,
  `item` text,
  `date` text,
  `message` text,
  `reserved_1` text,
  `reserved_2` text,
  `reserved_3` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_filial`
--

CREATE TABLE `pmd_filial` (
  `firmselector` int(11) DEFAULT NULL,
  `firmname` text,
  `category` text,
  `flag` text,
  `num` int(10) UNSIGNED NOT NULL,
  `namef` text,
  `businessf` text,
  `countryf` text,
  `statef` text,
  `cityf` text,
  `zipf` text,
  `addressf` text,
  `phonef` text,
  `faxf` text,
  `mobilef` text,
  `managerf` text,
  `koordinatif` text,
  `www` text,
  `img_on` int(11) DEFAULT NULL,
  `img_type` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_foto`
--

CREATE TABLE `pmd_foto` (
  `num` int(10) UNSIGNED NOT NULL,
  `item` text,
  `date` varchar(50) DEFAULT NULL,
  `message` text,
  `sort` int(11) DEFAULT NULL,
  `rateNum` int(11) DEFAULT NULL,
  `rateVal` int(11) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `category` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_foto_meta`
--

CREATE TABLE `pmd_foto_meta` (
  `rewrite` text,
  `title` text,
  `keywords` text,
  `description` text,
  `item` text,
  `object` text,
  `map` varchar(255) DEFAULT NULL,
  `mapstype` varchar(50) DEFAULT NULL,
  `full` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_images`
--

CREATE TABLE `pmd_images` (
  `firmselector` int(11) DEFAULT NULL,
  `num` int(10) UNSIGNED NOT NULL,
  `item` text,
  `date` text,
  `message` text,
  `sort` int(11) DEFAULT NULL,
  `rateNum` int(11) DEFAULT NULL,
  `rateVal` int(11) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `ip` text,
  `reserved_1` text,
  `reserved_2` text,
  `reserved_3` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_info`
--

CREATE TABLE `pmd_info` (
  `firmselector` int(11) DEFAULT NULL,
  `firmname` text,
  `category` text,
  `num` int(10) UNSIGNED NOT NULL,
  `show_info` int(11) DEFAULT NULL,
  `date` text,
  `datetime` text,
  `type` int(11) DEFAULT NULL,
  `period` text,
  `item` text,
  `shortstory` text,
  `fullstory` text,
  `img_on` int(11) DEFAULT NULL,
  `video` text,
  `f_name1` text,
  `f_name2` text,
  `f_name3` text,
  `f_name4` text,
  `f_name5` text,
  `f_name6` text,
  `f_name7` text,
  `f_name8` text,
  `f_name9` text,
  `f_name10` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_infofields`
--

CREATE TABLE `pmd_infofields` (
  `num` int(10) UNSIGNED NOT NULL,
  `f_info` text,
  `f_name1` text,
  `f_type1` int(11) DEFAULT NULL,
  `f_on1` int(11) DEFAULT NULL,
  `f_name2` text,
  `f_type2` int(11) DEFAULT NULL,
  `f_on2` int(11) DEFAULT NULL,
  `f_name3` text,
  `f_type3` int(11) DEFAULT NULL,
  `f_on3` int(11) DEFAULT NULL,
  `f_name4` text,
  `f_type4` int(11) DEFAULT NULL,
  `f_on4` int(11) DEFAULT NULL,
  `f_name5` text,
  `f_type5` int(11) DEFAULT NULL,
  `f_on5` int(11) DEFAULT NULL,
  `f_name6` text,
  `f_type6` int(11) DEFAULT NULL,
  `f_on6` int(11) DEFAULT NULL,
  `f_name7` text,
  `f_type7` int(11) DEFAULT NULL,
  `f_on7` int(11) DEFAULT NULL,
  `f_name8` text,
  `f_type8` int(11) DEFAULT NULL,
  `f_on8` int(11) DEFAULT NULL,
  `f_name9` text,
  `f_type9` int(11) DEFAULT NULL,
  `f_on9` int(11) DEFAULT NULL,
  `f_name10` text,
  `f_type10` int(11) DEFAULT NULL,
  `f_on10` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pmd_infofields`
--

INSERT INTO `pmd_infofields` (`num`, `f_info`, `f_name1`, `f_type1`, `f_on1`, `f_name2`, `f_type2`, `f_on2`, `f_name3`, `f_type3`, `f_on3`, `f_name4`, `f_type4`, `f_on4`, `f_name5`, `f_type5`, `f_on5`, `f_name6`, `f_type6`, `f_on6`, `f_name7`, `f_type7`, `f_on7`, `f_name8`, `f_type8`, `f_on8`, `f_name9`, `f_type9`, `f_on9`, `f_name10`, `f_type10`, `f_on10`) VALUES
(1, 'Новости', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Тендеры', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Объявления', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Вакансии', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Пресс-релизы', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_links`
--

CREATE TABLE `pmd_links` (
  `selector` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metka` varchar(255) NOT NULL DEFAULT '',
  `url` text NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `hit` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_location`
--

CREATE TABLE `pmd_location` (
  `locationselector` int(11) DEFAULT NULL,
  `location` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pmd_location`
--

INSERT INTO `pmd_location` (`locationselector`, `location`) VALUES
(1, 'Страна / Город');

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_log`
--

CREATE TABLE `pmd_log` (
  `selector` int(10) UNSIGNED NOT NULL,
  `log` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pmd_log`
--

INSERT INTO `pmd_log` (`selector`, `log`) VALUES
(1, '15:36:58  2018/03/05 - [nicke, 127.0.0.1] - Войти');

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_lost`
--

CREATE TABLE `pmd_lost` (
  `id` int(10) UNSIGNED NOT NULL,
  `lostid` mediumint(8) NOT NULL DEFAULT '0',
  `lostmail` text NOT NULL,
  `lost` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_news`
--

CREATE TABLE `pmd_news` (
  `selector` int(11) UNSIGNED NOT NULL,
  `status_off` tinyint(1) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `category` int(10) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `hit` int(11) NOT NULL,
  `short` text NOT NULL,
  `full` text NOT NULL,
  `keywords` text NOT NULL,
  `metatitle` varchar(255) NOT NULL DEFAULT '',
  `metadescr` varchar(255) NOT NULL DEFAULT '',
  `metakeywords` text NOT NULL,
  `short_tpl` varchar(50) NOT NULL DEFAULT '',
  `full_tpl` varchar(50) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `rateNum` int(10) NOT NULL,
  `rateVal` int(10) NOT NULL,
  `comment_off` tinyint(1) NOT NULL,
  `comments` int(11) NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  `main` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pmd_news`
--

INSERT INTO `pmd_news` (`selector`, `status_off`, `date`, `category`, `title`, `name`, `hit`, `short`, `full`, `keywords`, `metatitle`, `metadescr`, `metakeywords`, `short_tpl`, `full_tpl`, `ip`, `rateNum`, `rateVal`, `comment_off`, `comments`, `fixed`, `main`) VALUES
(1, 0, '2014-04-25 12:08:03', 1, 'Приглашаем к регистрации в каталоге', 'register', 1, '<p>В сегодняшний век высоких технологий абсолютно недопустимо оставаться безызвестным. Если вы желаете успеха своему бизнесу, то вы должны рассказать о нем всем людям. Или хотя бы самому активному контингенту &ndash; пользователям Интернет. В наши дни всё меньше людей обращаются к печатным справочникам, и всё больше &ndash; к виртуальным каталогам. <br /> Для большинства фирм важна именно региональная привязка. <strong>Поэтому регистрация в подобном каталоге принесет ощутимую выгоду</strong>. <strong>Наш сайт &ndash; это каталог организаций I-Soft Bizness</strong>, который практически не имеет себе равных.</p>', '<p>В сегодняшний век высоких технологий абсолютно недопустимо оставаться безызвестным. Если вы желаете успеха своему бизнесу, то вы должны рассказать о нем всем людям. Или хотя бы самому активному контингенту &ndash; пользователям Интернет. В наши дни всё меньше людей обращаются к печатным справочникам, и всё больше &ndash; к виртуальным каталогам. <br /> Для большинства фирм важна именно региональная привязка. <strong>Поэтому регистрация в подобном каталоге принесет ощутимую выгоду</strong>. <strong>Наш сайт &ndash; это каталог организаций I-Soft Bizness</strong>, который практически не имеет себе равных.<br /><br /><span style=\"color: #ff0000;\"><strong>Зарегистрировавшись</strong></span> у нас, вы получаете возможность:<br /><br />- использовать свой логотип; ведь не секрет, что визуальное отображение не менее важно, чем текстовое;<br />- выложить всю необходимую информацию о компании на самом видном месте &ndash; её не придётся искать.<br />- размещения подробного прайс-листа своих товаров и услуг. Покажите товар лицом клиенту, заинтересуйте его и пожинайте плоды, а качественный функционал нашего каталога сделает за вас практически всю работу.<br /><br />Но на этом преимущества каталога не ограничиваются. Если вы хотите быть постоянно на виду, то ваш логотип будет отражаться на баннере, который всё время висит на сайте. Там в случайном порядке показываются фирмы, зарегистрированные в каталоге, и вполне возможно, что пользователь зайдет именно к вам. Даже если он искал какую-то другую компанию.<br /><br />Кстати, у нас выгодно быть новичком. Как только вы регистрируетесь на нашем сайте, информация о вашем предприятии показывается на всех страницах сайта в специальном разделе. И только с регистрацией новых предприятий она спускается вниз.<br /><br />Но особенно выгодно у нас быть лидером. Наш сайт &ndash; это почти как поисковик. Если компания пользуется известностью, и ее аккаунт посещает множество людей, то она всегда на видном месте. А это ведет к еще большему потоку клиентов.<br /><br />Но регистрация в нашем каталоге &ndash; это не просто добавление контактов. <strong>Вам предоставляется возможность</strong> влиять на собственное присутствие. Разнообразный функционал сайта позволит собирать статистику о пользователях, зашедших к вам, видеть их мнение, подсчитывать конверсию и т.д. То есть самый настоящий инструментарий для оптимизации своего успеха.<br /><br />Итак, наш каталог поможет вам:<br /><br />- сделать визуальную &laquo;зацепку&raquo; посетителя посредством логотипа фирмы;<br />- предоставить пользователю полную информацию о себе;<br />- в наилучшем виде презентовать прайс-лист с фотографиями товаров;<br />- быть постоянно на виду при помощи баннеров;<br />- стать настолько популярными, что известность начнет сама работать на вас.<br /><br /> <a href=\"http://vkaragande.info\">I-Soft Bizness</a></p>', 'каталог, возможности, регистрация, добавить фирму', 'Приглашаем к регистрации в каталоге', 'Регистрация в нашем каталоге. Добавить фирму, магазин или товар.', 'каталог, регистрация, бизнес, фирма, купить, продать, товары, услуги', '', '', '127.0.0.1', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_newsrev`
--

CREATE TABLE `pmd_newsrev` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT '',
  `date` varchar(20) NOT NULL DEFAULT '',
  `news` int(11) NOT NULL,
  `user` varchar(100) NOT NULL DEFAULT '',
  `review` text NOT NULL,
  `profil` text NOT NULL,
  `avatar` text NOT NULL,
  `mail` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_offers`
--

CREATE TABLE `pmd_offers` (
  `firmselector` int(11) DEFAULT NULL,
  `num` int(10) UNSIGNED NOT NULL,
  `item` text,
  `date` text,
  `type` int(11) DEFAULT NULL,
  `message` text,
  `quantity` text,
  `packaging` text,
  `price` text,
  `period` text,
  `www` text,
  `paypal` text,
  `currency` text,
  `reserved_1` text,
  `reserved_2` text,
  `reserved_3` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_rating`
--

CREATE TABLE `pmd_rating` (
  `id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `ip_internal` text,
  `ip_external` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_reply`
--

CREATE TABLE `pmd_reply` (
  `num` int(10) UNSIGNED NOT NULL,
  `id_com` int(11) NOT NULL,
  `reply` text NOT NULL,
  `company` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_reviews`
--

CREATE TABLE `pmd_reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` text,
  `status` text,
  `company` text,
  `user` text,
  `review` text,
  `profil` text,
  `avatar` text,
  `rtype` int(10) DEFAULT NULL,
  `rateNum` int(11) DEFAULT NULL,
  `rateVal` int(11) DEFAULT NULL,
  `otvet` int(10) DEFAULT NULL,
  `mail` text,
  `www` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_stat`
--

CREATE TABLE `pmd_stat` (
  `id` int(10) UNSIGNED NOT NULL,
  `firmselector` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `m01` int(11) NOT NULL,
  `m02` int(11) NOT NULL,
  `m03` int(11) NOT NULL,
  `m04` int(11) NOT NULL,
  `m05` int(11) NOT NULL,
  `m06` int(11) NOT NULL,
  `m07` int(11) NOT NULL,
  `m08` int(11) NOT NULL,
  `m09` int(11) NOT NULL,
  `m10` int(11) NOT NULL,
  `m11` int(11) NOT NULL,
  `m12` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_states`
--

CREATE TABLE `pmd_states` (
  `stateselector` int(11) DEFAULT NULL,
  `state` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pmd_states`
--

INSERT INTO `pmd_states` (`stateselector`, `state`) VALUES
(1, 'Область');

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_static`
--

CREATE TABLE `pmd_static` (
  `selector` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(200) NOT NULL DEFAULT '',
  `hit` int(11) NOT NULL,
  `full` text NOT NULL,
  `metatitle` varchar(255) NOT NULL DEFAULT '',
  `metadescr` varchar(255) NOT NULL DEFAULT '',
  `metakeywords` text NOT NULL,
  `full_tpl` varchar(50) NOT NULL DEFAULT '',
  `sitemap_off` tinyint(1) NOT NULL,
  `noindex` tinyint(1) NOT NULL,
  `ip` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pmd_static`
--

INSERT INTO `pmd_static` (`selector`, `date`, `title`, `name`, `hit`, `full`, `metatitle`, `metadescr`, `metakeywords`, `full_tpl`, `sitemap_off`, `noindex`, `ip`) VALUES
(1, '2014-06-10 18:00:00', 'Правила добавления организаций или фирм в наш каталог', 'info', 1, '<p>Каталог организаций - это место, где можно добавить свою организацию или фирму, а посетитель - просмотреть её.<br />Для размещения свой организации нужно зарегистрироваться, указав раздел, название организации, описание, контактные данные, логин и пароль в системе. Если Вы вдруг забудете Имя или Пароль для входа в каталог, то система Вышлет Вам регистрационные данные на E-mail, указанный при регистрации.<br />Все регистрации активируются администратором каталога.<br /><br /><br />Выполняйте следующие условия:<br /><br /><span style=\"color: red;\"><strong>В каталоге разрешается:</strong></span><br />- регистрировать организации;<br />- загрузить логотип, схему проезда, указать контактные данные и филиалы;<br />- размещать прайс-листы на срок от <strong>3 до 360</strong> дней;<br />- размещать галлерею товаров и услуг;<br />- размещать excel прайсы;<br />- размещать публикации (новости, тендеры, объявления, вакансии, пресс-релизы);<br />- размещать видеоролики;<br />- проводить рекламные компании.<br /><br /><span style=\"color: red;\"><strong>В каталоге запрещается:</strong></span><br />- размещать организацию, содержание которой не соответствует теме выбранного раздела;<br />- вставлять в объявление мета-теги, всевозможный код, непонятные символы и рисунки;<br />- подача регистрации без указания данных для обратной связи (емайл, телефон или URL);<br />- подача регистрации, содержащих ненормативную лексику и нарушающие нормы морали;<br />- размещать организацию общего рекламного характера, сообщения не соответствующие тематике раздела.<br /><br /><br />В случае нарушения правил, Ваш аккаунт будет удален, а также Вам будет закрыт доступ для дальнейшей работы с каталогом.<br />Администрация сайта никоим образом не несёт ответственность за услуги или товар, предложение которых находится на данном каталоге, а также оставляет за собой право удалять любые регистрации без объяснения причин.</p>', 'Правила добавления организаций или фирм в наш каталог', 'Правила добавления фирм', 'разрешается, запрещается', '', 0, 0, '127.0.0.1'),
(2, '2014-06-10 18:05:00', 'О каталоге', 'catalog', 1, '<p>Каталог очень прост в обращении, как клиентам, которые размещают информацию о своей организации или фирме, так и для посетителей, которые ищут информацию о нужной продукции или услугах.<br />Конечной целью для клиентов является, чтобы их компания была найдена и вся информация была представлена посетителю. Посетители в свою очередь могут получить полный список всех организаций удовлетворяющих их запросу. Здесь весь секрет. Необходимо привлечь клиента, чтобы его компания была найдена первой, и посетитель проявил интерес к его компании.<br /><br />Для того чтобы достичь максимального результата в рекламной компании в каталоге необходимо наиболее эффективно использовать все свойства каталога.<br /><br />Дадим несколько рекомендаций для клиентов каталога.<br />Каталог позволяет загружать логотип компании. Возможно, посетитель видел где-то Ваш логотип и уже припоминает Вашу торговую марку.<br /><br />Описание организации должно быть кратким, но максимально информативным. Посетитель должен от описания получить всю информацию о Вашей сфере деятельности. Контактные данные должны быть наиболее полными, укажите все возможные способы, с помощью которых посетитель сможет с Вами связаться. Не думайте, что такой атрибут, как ICQ может быть не интересен посетителю, напротив, может это лучший способ для него выйти на связь с Вами или Вашими менеджерами по продажам. Немаловажным является наличие ссылки на web сайт или страничку хотя бы Ваших партнеров или поставщиков.<br /><br />Каталог позволяет формировать прайс-листы продукции или услуг с возможностью показа фотографий. Обязательно следует заполнить прайс-лист Вашей продукцией или услугами. Посетитель сможет уже визуально оценить Ваше предложение. Помимо создания прайса, каталог даёт возможность создания галереи изображений. Поместите туда лучшие товары. Как говорят, лучше 1 раз увидеть, чем 100 раз услышать.<br /><br />Самым эффективным рекламным инструментом в каталоге является размещение баннеров, которые показываются случайным образом в каталоге и способствуют переходам на вашу страничку. Привлекательный баннер обязательно заинтересует посетителя. Доказано, что довольно часто посетители ищут в каталоге одну информацию, а благодаря баннерной рекламе, еще узнают параллельно об услугах в других направлениях, которые смогут их заинтересовать в недалеком будущем.<br /><br />При регистрации в каталоге, Ваша организация попадает в раздел &ldquo;новые фирмы&rdquo; с кратким описанием, которые показываются на всех страницах каталога. По мере появления новых клиентов их позиции утрачиваются и в конце концов они исчезают с раздела и найти их можно либо локальным поисковиком, либо просматривая категории и разделы вручную.<br /><br />Пять фирм с максимальной посещаемостью аккаунта и имеющие максимальный рейтинг в каталоге оказываются в пятерке &ldquo;популярных фирм&rdquo; расположенной также на всех страницах каталога, что еще больше увеличивает их рейтинг.<br />Попасть в пятерку, также дает возможность рекламной компании в виде баннеров.<br /><br />Каталог дает подробную статистику: количество просмотров аккаунта, количество переходов по ссылке на Ваш сайт, количество показов баннеров, кликов по баннерам, CTR баннеров, комментарии и оценку которые оставили посетители.<br /><br />Проанализировав полученную информацию, Вы сможете еще более эффективно использовать все возможности каталога.</p>', 'О каталоге организаций и фирм', 'Каталог, фирмы и организации', '', '', 0, 0, '127.0.0.1'),
(3, '2014-06-10 19:00:00', 'Погода в регионе', 'pogoda', 0, 'Погода в регионе<br />Установите погодные информеры', '', '', '', '', 0, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_subcategory`
--

CREATE TABLE `pmd_subcategory` (
  `catsel` int(11) DEFAULT NULL,
  `catsubsel` int(11) DEFAULT NULL,
  `subcategory` text,
  `ssccounter` int(11) NOT NULL DEFAULT '0',
  `fcounter` int(11) NOT NULL DEFAULT '0',
  `img` text,
  `title` text,
  `description` text,
  `keywords` text,
  `description_full` text,
  `recomend` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_subsubcategory`
--

CREATE TABLE `pmd_subsubcategory` (
  `catsel` int(11) DEFAULT NULL,
  `catsubsel` int(11) DEFAULT NULL,
  `catsubsubsel` int(11) DEFAULT NULL,
  `subsubcategory` text,
  `fcounter` int(11) NOT NULL DEFAULT '0',
  `img` text,
  `title` text,
  `description` text,
  `keywords` text,
  `description_full` text,
  `recomend` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_users`
--

CREATE TABLE `pmd_users` (
  `firmstate` varchar(4) DEFAULT NULL,
  `flag` varchar(4) DEFAULT NULL,
  `comment` text,
  `selector` int(10) UNSIGNED NOT NULL,
  `category` text,
  `login` text,
  `domen` varchar(255) DEFAULT NULL,
  `domen1` varchar(255) DEFAULT NULL,
  `firmname` text,
  `keywords` text,
  `theme` varchar(50) DEFAULT NULL,
  `design` varchar(200) DEFAULT NULL,
  `setting_s` text,
  `metatitle` varchar(255) DEFAULT NULL,
  `metadescr` varchar(255) DEFAULT NULL,
  `metakeywords` text,
  `business` text,
  `map` varchar(255) DEFAULT NULL,
  `mapstype` varchar(50) DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `city` text,
  `address` text,
  `zip` text,
  `phone` text,
  `fax` text,
  `mobile` text,
  `icq` text,
  `manager` text,
  `mail` text,
  `tcase` tinyint(1) DEFAULT NULL,
  `tmail` mediumint(5) DEFAULT NULL,
  `www` text,
  `social` text,
  `pass` text,
  `date_mod` text,
  `on_newrev` tinyint(1) DEFAULT NULL,
  `on_rating` tinyint(1) DEFAULT NULL,
  `off_mail` tinyint(1) DEFAULT NULL,
  `off_mailer` tinyint(1) DEFAULT NULL,
  `off_rev` tinyint(1) DEFAULT NULL,
  `new_rev` int(11) DEFAULT NULL,
  `rev_good` int(11) DEFAULT NULL,
  `rev_bad` int(11) DEFAULT NULL,
  `off_friends` int(11) DEFAULT NULL,
  `filial` int(11) DEFAULT NULL,
  `prices` int(11) DEFAULT NULL,
  `images` int(11) DEFAULT NULL,
  `exel` int(11) DEFAULT NULL,
  `video` int(11) DEFAULT NULL,
  `info` int(11) DEFAULT NULL,
  `news` int(11) DEFAULT NULL,
  `tender` int(11) DEFAULT NULL,
  `board` int(11) DEFAULT NULL,
  `job` int(11) DEFAULT NULL,
  `pressrel` int(11) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL,
  `date_update` varchar(20) DEFAULT NULL,
  `ip_update` varchar(20) DEFAULT NULL,
  `date_upgrade` varchar(20) DEFAULT NULL,
  `loch_m` tinyint(1) DEFAULT NULL,
  `counter` int(11) DEFAULT NULL,
  `hits_d` int(11) DEFAULT NULL,
  `hits_m` int(11) DEFAULT NULL,
  `webcounter` int(11) DEFAULT NULL,
  `mailcounter` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL,
  `countrating` int(11) DEFAULT NULL,
  `banner_show` int(11) DEFAULT NULL,
  `banner_click` int(11) DEFAULT NULL,
  `price_show` int(11) DEFAULT NULL,
  `reserved_1` text,
  `reserved_2` text,
  `reserved_3` text,
  `counterip` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_video`
--

CREATE TABLE `pmd_video` (
  `firmselector` int(11) DEFAULT NULL,
  `num` int(10) UNSIGNED NOT NULL,
  `item` text,
  `urlv` text,
  `date` text,
  `message` text,
  `sort` int(11) DEFAULT NULL,
  `rateNum` int(11) DEFAULT NULL,
  `rateVal` int(11) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `full` text,
  `recommend` varchar(50) DEFAULT NULL,
  `metatitle` varchar(255) DEFAULT NULL,
  `metadescr` varchar(255) DEFAULT NULL,
  `metakeywords` text,
  `name` varchar(255) DEFAULT NULL,
  `reserved_1` text,
  `reserved_2` text,
  `reserved_3` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pmd_zsearch`
--

CREATE TABLE `pmd_zsearch` (
  `num` int(10) UNSIGNED NOT NULL,
  `item` text NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `pmd_admin`
--
ALTER TABLE `pmd_admin`
  ADD PRIMARY KEY (`num`);

--
-- Индексы таблицы `pmd_case`
--
ALTER TABLE `pmd_case`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pmd_categorynews`
--
ALTER TABLE `pmd_categorynews`
  ADD PRIMARY KEY (`selector`);

--
-- Индексы таблицы `pmd_complaint`
--
ALTER TABLE `pmd_complaint`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pmd_engines`
--
ALTER TABLE `pmd_engines`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pmd_exelp`
--
ALTER TABLE `pmd_exelp`
  ADD PRIMARY KEY (`num`);
ALTER TABLE `pmd_exelp` ADD FULLTEXT KEY `item` (`item`,`message`);

--
-- Индексы таблицы `pmd_filial`
--
ALTER TABLE `pmd_filial`
  ADD PRIMARY KEY (`num`);
ALTER TABLE `pmd_filial` ADD FULLTEXT KEY `namef` (`namef`,`businessf`);

--
-- Индексы таблицы `pmd_foto`
--
ALTER TABLE `pmd_foto`
  ADD PRIMARY KEY (`num`);
ALTER TABLE `pmd_foto` ADD FULLTEXT KEY `item` (`item`,`message`);

--
-- Индексы таблицы `pmd_images`
--
ALTER TABLE `pmd_images`
  ADD PRIMARY KEY (`num`);
ALTER TABLE `pmd_images` ADD FULLTEXT KEY `item` (`item`,`message`);

--
-- Индексы таблицы `pmd_info`
--
ALTER TABLE `pmd_info`
  ADD PRIMARY KEY (`num`);
ALTER TABLE `pmd_info` ADD FULLTEXT KEY `item` (`item`,`fullstory`);

--
-- Индексы таблицы `pmd_infofields`
--
ALTER TABLE `pmd_infofields`
  ADD PRIMARY KEY (`num`);

--
-- Индексы таблицы `pmd_links`
--
ALTER TABLE `pmd_links`
  ADD PRIMARY KEY (`selector`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `pmd_log`
--
ALTER TABLE `pmd_log`
  ADD PRIMARY KEY (`selector`);

--
-- Индексы таблицы `pmd_lost`
--
ALTER TABLE `pmd_lost`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pmd_news`
--
ALTER TABLE `pmd_news`
  ADD PRIMARY KEY (`selector`),
  ADD KEY `date` (`date`),
  ADD KEY `category` (`category`),
  ADD KEY `name` (`name`);
ALTER TABLE `pmd_news` ADD FULLTEXT KEY `short` (`short`,`full`,`title`,`keywords`);

--
-- Индексы таблицы `pmd_newsrev`
--
ALTER TABLE `pmd_newsrev`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pmd_offers`
--
ALTER TABLE `pmd_offers`
  ADD PRIMARY KEY (`num`);
ALTER TABLE `pmd_offers` ADD FULLTEXT KEY `item` (`item`,`message`);

--
-- Индексы таблицы `pmd_reply`
--
ALTER TABLE `pmd_reply`
  ADD PRIMARY KEY (`num`);

--
-- Индексы таблицы `pmd_reviews`
--
ALTER TABLE `pmd_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pmd_stat`
--
ALTER TABLE `pmd_stat`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pmd_static`
--
ALTER TABLE `pmd_static`
  ADD PRIMARY KEY (`selector`),
  ADD KEY `date` (`date`),
  ADD KEY `name` (`name`);
ALTER TABLE `pmd_static` ADD FULLTEXT KEY `full` (`full`,`title`);

--
-- Индексы таблицы `pmd_users`
--
ALTER TABLE `pmd_users`
  ADD PRIMARY KEY (`selector`);
ALTER TABLE `pmd_users` ADD FULLTEXT KEY `firmname` (`firmname`,`business`);
ALTER TABLE `pmd_users` ADD FULLTEXT KEY `business` (`business`);

--
-- Индексы таблицы `pmd_video`
--
ALTER TABLE `pmd_video`
  ADD PRIMARY KEY (`num`);
ALTER TABLE `pmd_video` ADD FULLTEXT KEY `item` (`item`,`message`);

--
-- Индексы таблицы `pmd_zsearch`
--
ALTER TABLE `pmd_zsearch`
  ADD PRIMARY KEY (`num`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `pmd_admin`
--
ALTER TABLE `pmd_admin`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `pmd_case`
--
ALTER TABLE `pmd_case`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_categorynews`
--
ALTER TABLE `pmd_categorynews`
  MODIFY `selector` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `pmd_complaint`
--
ALTER TABLE `pmd_complaint`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_engines`
--
ALTER TABLE `pmd_engines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_exelp`
--
ALTER TABLE `pmd_exelp`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_filial`
--
ALTER TABLE `pmd_filial`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_foto`
--
ALTER TABLE `pmd_foto`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_images`
--
ALTER TABLE `pmd_images`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_info`
--
ALTER TABLE `pmd_info`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_infofields`
--
ALTER TABLE `pmd_infofields`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `pmd_links`
--
ALTER TABLE `pmd_links`
  MODIFY `selector` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_log`
--
ALTER TABLE `pmd_log`
  MODIFY `selector` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `pmd_lost`
--
ALTER TABLE `pmd_lost`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_news`
--
ALTER TABLE `pmd_news`
  MODIFY `selector` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `pmd_newsrev`
--
ALTER TABLE `pmd_newsrev`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_offers`
--
ALTER TABLE `pmd_offers`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_reply`
--
ALTER TABLE `pmd_reply`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_reviews`
--
ALTER TABLE `pmd_reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_stat`
--
ALTER TABLE `pmd_stat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_static`
--
ALTER TABLE `pmd_static`
  MODIFY `selector` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `pmd_users`
--
ALTER TABLE `pmd_users`
  MODIFY `selector` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_video`
--
ALTER TABLE `pmd_video`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pmd_zsearch`
--
ALTER TABLE `pmd_zsearch`
  MODIFY `num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: upgrade_system.php
-----------------------------------------------------
 Назначение: Функция проверки обновлений
=====================================================
*/

function file_put_connect ($str_replace) {

    @chmod("../connect.php", 0666);
    $con_file = fopen("../connect.php", "w+") or die("Извините, но невозможно записать в файл <b>connect.php</b><br />Проверьте правильность проставленного CHMOD!");
    fwrite($con_file, $str_replace);
    fclose($con_file);
    @chmod("../connect.php", 0644);

}

$key = htmlspecialchars($_GET['key'],ENT_QUOTES,$def_charset);
$sql = '';

$connect_data=file_get_contents('../connect.php');

    switch ($key) {

        // Обновление галереи изображений и поиска по каталогу
        case "4.7.1":

            if (empty($db_zsearch)) {
                $connect_data = str_replace ('$db = new Dbaccess;', "\n".'$db_zsearch = $prefix_b ."_zsearch";'."\n"."\n".'$db = new Dbaccess;', $connect_data );
                file_put_connect($connect_data);
            }

            include ("../connect.php");

            mysql_query("DROP TABLE $db_zsearch");
            mysql_query("create table $db_zsearch (num INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, item text NOT NULL default '', number int(11) NOT NULL ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")  or die ("<b>Создание</b> LOST TABLE as $db_zsearch - </b>  - <font color=red>FAILED</font><br>");

            $sql.= "create table $db_zsearch (num INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, item text NOT NULL default '', number int(11) NOT NULL ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci\n";
            
            $sql0 = "ALTER TABLE `$db_images` ADD `sort` int(11) AFTER `message`";
            $sql1 = "ALTER TABLE `$db_images` ADD `rateNum` int(11) AFTER `message`";
            $sql2 = "ALTER TABLE `$db_images` ADD `rateVal` int(11) AFTER `message`";
            $sql3 = "ALTER TABLE `$db_images` ADD `hits` int(11) AFTER `message`";
            $sql4 = "ALTER TABLE `$db_images` ADD `ip` text AFTER `message`";

            $db->query ( $sql4 );
            $db->query ( $sql3 );
            $db->query ( $sql2 );
            $db->query ( $sql1 );
            $db->query ( $sql0 );


            $sql.="$sql0\n"; $sql.="$sql1\n"; $sql.="$sql2\n"; $sql.="$sql3\n";            

        break;

        // Обновление возможностей комментариев в каталоге
        case "4.7.4":

            if (empty($db_reply)) {
                $connect_data = str_replace ('$db = new Dbaccess;', "\n".'$db_reply = $prefix_b ."_reply";'."\n"."\n".'$db = new Dbaccess;', $connect_data );
                file_put_connect($connect_data);
            }

            include ("../connect.php");

            mysql_query("DROP TABLE $db_reply");
            mysql_query("create table $db_reply (num INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, id_com int(11) NOT NULL, reply text NOT NULL default '', company int(11) NOT NULL  ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")  or die ("<b>Создание</b> REPLY TABLE as $db_reply - </b>  - <font color=red>FAILED</font><br>");

            $sql.="create table $db_reply (num INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, id_com int(11) NOT NULL, reply text NOT NULL default '', company int(11) NOT NULL  ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

            $sql0 = "ALTER TABLE `$db_reviews` ADD `profil` text AFTER `review`";
            $sql1 = "ALTER TABLE `$db_reviews` ADD `avatar` text AFTER `profil`";
            $sql2 = "ALTER TABLE `$db_reviews` ADD `rtype` int(10) AFTER `avatar`";
            $sql3 = "ALTER TABLE `$db_reviews` ADD `rateNum` int(11) AFTER `rtype`";
            $sql4 = "ALTER TABLE `$db_reviews` ADD `rateVal` int(11) AFTER `rateNum`";
            $sql5 = "ALTER TABLE `$db_reviews` ADD `otvet` int(10) AFTER `review`";

            $sql6 = "ALTER TABLE `$db_users` ADD `rev_good` int(10) AFTER `new_rev`";
            $sql7 = "ALTER TABLE `$db_users` ADD `rev_bad` int(10) AFTER `new_rev`";

            $db->query ( $sql0 );
            $db->query ( $sql1 );
            $db->query ( $sql2 );
            $db->query ( $sql3 );
            $db->query ( $sql4 );
            $db->query ( $sql5 );
            $db->query ( $sql6 );
            $db->query ( $sql7 );

            $sql8 = "UPDATE $db_reviews SET `rtype` = '1'";

            $db->query ( $sql8 );

            $sql.="$sql0\n"; $sql.="$sql1\n"; $sql.="$sql2\n"; $sql.="$sql3\n"; $sql.="$sql4\n"; $sql.="$sql5\n"; $sql.="$sql6\n"; $sql.="$sql7\n"; $sql.="$sql8\n";


        break;

        // Мои ссылки
        case "4.7.7":

            if (empty($db_links)) {
                $connect_data = str_replace ('$db = new Dbaccess;', "\n".'$db_links = $prefix_b ."_links";'."\n"."\n".'$db = new Dbaccess;', $connect_data );
                file_put_connect($connect_data);
            }

            include ("../connect.php");

            mysql_query("DROP TABLE $db_links");
            mysql_query("create table $db_links (selector INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, date datetime NOT NULL default '0000-00-00 00:00:00', metka varchar(255) NOT NULL default '', url text NOT NULL default '', name varchar(255) NOT NULL default '', hit int(11) NOT NULL, UNIQUE KEY `name` (`name`) ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")  or die ("<b>Создание</b> REPLY TABLE as $db_links - </b>  - <font color=red>FAILED</font><br>");

            $sql.="create table $db_links (selector INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, date datetime NOT NULL default '0000-00-00 00:00:00', metka varchar(255) NOT NULL default '', url text NOT NULL default '', name varchar(255) NOT NULL default '', hit int(11) NOT NULL, UNIQUE KEY `name` (`name`) ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

        break;

        // Новости каталога
        case "4.7.8":

            if (empty($db_categorynews)) {
                $connect_data = str_replace ('$db = new Dbaccess;', "\n".'$db_categorynews = $prefix_b ."_categorynews";'."\n".'$db_news = $prefix_b ."_news";'."\n".'$db_newsrev = $prefix_b ."_newsrev";'."\n"."\n".'$db = new Dbaccess;', $connect_data );
                file_put_connect($connect_data);
            }

            include ("../connect.php");

            mysql_query("DROP TABLE $db_categorynews");
            mysql_query("create table $db_categorynews (selector INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, status_off tinyint(1) NOT NULL, category varchar(255) NOT NULL default '', name varchar(50) NOT NULL default '', ncount int(11) NOT NULL, top int(11) NOT NULL, img text NOT NULL default '', description text NOT NULL default '', metatitle varchar(255) NOT NULL default '', metadescr varchar(255) NOT NULL default '', metakeywords text NOT NULL default '',   ip varchar(50) NOT NULL default '', short_tpl varchar(50) NOT NULL default '', full_tpl varchar(50) NOT NULL default '' ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")  or die ("<b>Создание</b> REPLY TABLE as $db_categorynews - </b>  - <font color=red>FAILED</font><br>");

            mysql_query("DROP TABLE $db_news");
            mysql_query("create table $db_news (selector INT(11) UNSIGNED AUTO_INCREMENT NOT NULL, status_off tinyint(1) NOT NULL, date datetime NOT NULL default '0000-00-00 00:00:00', category int(10) NOT NULL, title varchar(255) NOT NULL default '', name varchar(50) NOT NULL default '', hit int(11) NOT NULL, short text NOT NULL default '', full text NOT NULL default '', keywords text NOT NULL default '', metatitle varchar(255) NOT NULL default '', metadescr varchar(255) NOT NULL default '', metakeywords text NOT NULL default '', short_tpl varchar(50) NOT NULL default '', full_tpl varchar(50) NOT NULL default '', ip varchar(50) NOT NULL default '', rateNum int(10) NOT NULL, rateVal int(10) NOT NULL, comment_off tinyint(1) NOT NULL, comments int(11) NOT NULL, fixed tinyint(1) NOT NULL, main tinyint(1) NOT NULL, PRIMARY KEY  (selector), KEY `date` (`date`), KEY `category` (`category`), KEY `name` (`name`), FULLTEXT (short, full, title, keywords)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")  or die ("<b>Создание</b> REPLY TABLE as $db_news - </b>  - <font color=red>FAILED</font><br>");

            mysql_query("DROP TABLE $db_newsrev");
            mysql_query("create table $db_newsrev (id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, status varchar(5) NOT NULL default '', date varchar(20) NOT NULL default '', news int(11) NOT NULL, user varchar(100) NOT NULL default '', review text NOT NULL default '', profil text NOT NULL default '', avatar text  NOT NULL default '', mail varchar(100) NOT NULL default '' ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")  or die ("<b>Создание</b> NEWSREV TABLE as $db_newsrev - </b>  - <font color=red>FAILED</font><br>");

            $db->query("INSERT INTO $db_categorynews (`selector`, `status_off`, `category`, `name`, `ncount`, `top`, `img`, `description`, `metatitle`, `metadescr`, `metakeywords`, `ip`, `short_tpl`, `full_tpl`) VALUES
            (1, 0, 'Новости каталога', 'Novostiikataloga', 1, 0, '', 'Возможности <span style=\"font-weight: bold;\">нашего каталога</span>. Новости, акции, объявления.<br>', 'Новости каталога', 'Наши новости. Возможности каталога фирм.', 'новости, каталог, фирмы, справка, бизнес, купить, товар', '', '', '')");

            $db->query("INSERT INTO $db_news (`selector`, `status_off`, `date`, `category`, `title`, `name`, `hit`, `short`, `full`, `keywords`, `metatitle`, `metadescr`, `metakeywords`, `short_tpl`, `full_tpl`, `ip`, `rateNum`, `rateVal`, `comment_off`, `comments`, `fixed`) VALUES
            (1, 0, '2012-04-09 04:17:43', 1, 'Приглашаем к регистрации в каталоге', 'register', 1, '<p>В сегодняшний век высоких технологий абсолютно недопустимо оставаться безызвестным. Если вы желаете успеха своему бизнесу, то вы должны рассказать о нем всем людям. Или хотя бы самому активному контингенту &ndash; пользователям Интернет. В наши дни всё меньше людей обращаются к печатным справочникам, и всё больше &ndash; к виртуальным каталогам. <br /> Для большинства фирм важна именно региональная привязка. <strong>Поэтому регистрация в подобном каталоге принесет ощутимую выгоду</strong>. <strong>Наш сайт &ndash; это каталог организаций I-Soft Bizness</strong>, который практически не имеет себе равных.</p>', '<p>В сегодняшний век высоких технологий абсолютно недопустимо оставаться безызвестным. Если вы желаете успеха своему бизнесу, то вы должны рассказать о нем всем людям. Или хотя бы самому активному контингенту &ndash; пользователям Интернет. В наши дни всё меньше людей обращаются к печатным справочникам, и всё больше &ndash; к виртуальным каталогам. <br /> Для большинства фирм важна именно региональная привязка. <strong>Поэтому регистрация в подобном каталоге принесет ощутимую выгоду</strong>. <strong>Наш сайт &ndash; это каталог организаций I-Soft Bizness</strong>, который практически не имеет себе равных.<br /><br /><span style=\"color: #ff0000;\"><strong>Зарегистрировавшись</strong></span> у нас, вы получаете возможность:<br /><br />- использовать свой логотип; ведь не секрет, что визуальное отображение не менее важно, чем текстовое;<br />- выложить всю необходимую информацию о компании на самом видном месте &ndash; её не придётся искать.<br />- размещения подробного прайс-листа своих товаров и услуг. Покажите товар лицом клиенту, заинтересуйте его и пожинайте плоды, а качественный функционал нашего каталога сделает за вас практически всю работу.<br /><br />Но на этом преимущества каталога не ограничиваются. Если вы хотите быть постоянно на виду, то ваш логотип будет отражаться на баннере, который всё время висит на сайте. Там в случайном порядке показываются фирмы, зарегистрированные в каталоге, и вполне возможно, что пользователь зайдет именно к вам. Даже если он искал какую-то другую компанию.<br /><br />Кстати, у нас выгодно быть новичком. Как только вы регистрируетесь на нашем сайте, информация о вашем предприятии показывается на всех страницах сайта в специальном разделе. И только с регистрацией новых предприятий она спускается вниз.<br /><br />Но особенно выгодно у нас быть лидером. Наш сайт &ndash; это почти как поисковик. Если компания пользуется известностью, и ее аккаунт посещает множество людей, то она всегда на видном месте. А это ведет к еще большему потоку клиентов.<br /><br />Но регистрация в нашем каталоге &ndash; это не просто добавление контактов. <strong>Вам предоставляется возможность</strong> влиять на собственное присутствие. Разнообразный функционал сайта позволит собирать статистику о пользователях, зашедших к вам, видеть их мнение, подсчитывать конверсию и т.д. То есть самый настоящий инструментарий для оптимизации своего успеха.<br /><br />Итак, наш каталог поможет вам:<br /><br />- сделать визуальную &laquo;зацепку&raquo; посетителя посредством логотипа фирмы;<br />- предоставить пользователю полную информацию о себе;<br />- в наилучшем виде презентовать прайс-лист с фотографиями товаров;<br />- быть постоянно на виду при помощи баннеров;<br />- стать настолько популярными, что известность начнет сама работать на вас.<br /><br /> <a href=\"http://vkaragande.info\">I-Soft Bizness</a></p>', 'каталог, возможности, регистрация, добавить фирму', 'Приглашаем к регистрации в каталоге', 'Регистрация в нашем каталоге. Добавить фирму, магазин или товар.', 'каталог, регистрация, бизнес, фирма, купить, продать, товары, услуги', '', '', '127.0.0.1', 0, 0, 0, 0, 0)");

            $sql.="create table $db_categorynews (selector INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, status_off tinyint(1) NOT NULL, category varchar(255) NOT NULL default '', name varchar(50) NOT NULL default '', ncount int(11) NOT NULL, top int(11) NOT NULL, img text NOT NULL default '', description text NOT NULL default '', metatitle varchar(255) NOT NULL default '', metadescr varchar(255) NOT NULL default '', metakeywords text NOT NULL default '',   ip varchar(50) NOT NULL default '', short_tpl varchar(50) NOT NULL default '', full_tpl varchar(50) NOT NULL default '' ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $sql.="\n";
            $sql.="create table $db_news (selector INT(11) UNSIGNED AUTO_INCREMENT NOT NULL, status_off tinyint(1) NOT NULL, date datetime NOT NULL default '0000-00-00 00:00:00', category int(10) NOT NULL, title varchar(255) NOT NULL default '', name varchar(50) NOT NULL default '', hit int(11) NOT NULL, short text NOT NULL default '', full text NOT NULL default '', keywords text NOT NULL default '', metatitle varchar(255) NOT NULL default '', metadescr varchar(255) NOT NULL default '', metakeywords text NOT NULL default '', short_tpl varchar(50) NOT NULL default '', full_tpl varchar(50) NOT NULL default '', ip varchar(50) NOT NULL default '', rateNum int(10) NOT NULL, rateVal int(10) NOT NULL, comment_off tinyint(1) NOT NULL, comments int(11) NOT NULL, fixed tinyint(1) NOT NULL, main tinyint(1) NOT NULL, PRIMARY KEY  (selector), KEY `date` (`date`), KEY `category` (`category`), KEY `name` (`name`), FULLTEXT (short, full, title, keywords)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $sql.="\n";
            $sql.="create table $db_newsrev (id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, status varchar(5) NOT NULL default '', date varchar(20) NOT NULL default '', news int(11) NOT NULL, user varchar(100) NOT NULL default '', review text NOT NULL default '', profil text NOT NULL default '', avatar text  NOT NULL default '', mail varchar(100) NOT NULL default '' ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $sql.="\n";
            $sql.=strip_tags("INSERT INTO $db_categorynews (`selector`, `status_off`, `category`, `name`, `ncount`, `top`, `img`, `description`, `metatitle`, `metadescr`, `metakeywords`, `ip`, `short_tpl`, `full_tpl`) VALUES
            (1, 0, 'Новости каталога', 'Novostiikataloga', 1, 0, '', 'Возможности <span style=\"font-weight: bold;\">нашего каталога</span>. Новости, акции, объявления.<br>', 'Новости каталога', 'Наши новости. Возможности каталога фирм.', 'новости, каталог, фирмы, справка, бизнес, купить, товар', '', '', '')");
            $sql.="\n";
            $sql.=strip_tags("INSERT INTO $db_news (`selector`, `status_off`, `date`, `category`, `title`, `name`, `hit`, `short`, `full`, `keywords`, `metatitle`, `metadescr`, `metakeywords`, `short_tpl`, `full_tpl`, `ip`, `rateNum`, `rateVal`, `comment_off`, `comments`, `fixed`) VALUES
            (1, 0, '2012-04-09 04:17:43', 1, 'Приглашаем к регистрации в каталоге', 'register', 1, '<p>В сегодняшний век высоких технологий абсолютно недопустимо оставаться безызвестным. Если вы желаете успеха своему бизнесу, то вы должны рассказать о нем всем людям. Или хотя бы самому активному контингенту &ndash; пользователям Интернет. В наши дни всё меньше людей обращаются к печатным справочникам, и всё больше &ndash; к виртуальным каталогам. <br /> Для большинства фирм важна именно региональная привязка. <strong>Поэтому регистрация в подобном каталоге принесет ощутимую выгоду</strong>. <strong>Наш сайт &ndash; это каталог организаций I-Soft Bizness</strong>, который практически не имеет себе равных.</p>', '<p>В сегодняшний век высоких технологий абсолютно недопустимо оставаться безызвестным. Если вы желаете успеха своему бизнесу, то вы должны рассказать о нем всем людям. Или хотя бы самому активному контингенту &ndash; пользователям Интернет. В наши дни всё меньше людей обращаются к печатным справочникам, и всё больше &ndash; к виртуальным каталогам. <br /> Для большинства фирм важна именно региональная привязка. <strong>Поэтому регистрация в подобном каталоге принесет ощутимую выгоду</strong>. <strong>Наш сайт &ndash; это каталог организаций I-Soft Bizness</strong>, который практически не имеет себе равных.<br /><br /><span style=\"color: #ff0000;\"><strong>Зарегистрировавшись</strong></span> у нас, вы получаете возможность:<br /><br />- использовать свой логотип; ведь не секрет, что визуальное отображение не менее важно, чем текстовое;<br />- выложить всю необходимую информацию о компании на самом видном месте &ndash; её не придётся искать.<br />- размещения подробного прайс-листа своих товаров и услуг. Покажите товар лицом клиенту, заинтересуйте его и пожинайте плоды, а качественный функционал нашего каталога сделает за вас практически всю работу.<br /><br />Но на этом преимущества каталога не ограничиваются. Если вы хотите быть постоянно на виду, то ваш логотип будет отражаться на баннере, который всё время висит на сайте. Там в случайном порядке показываются фирмы, зарегистрированные в каталоге, и вполне возможно, что пользователь зайдет именно к вам. Даже если он искал какую-то другую компанию.<br /><br />Кстати, у нас выгодно быть новичком. Как только вы регистрируетесь на нашем сайте, информация о вашем предприятии показывается на всех страницах сайта в специальном разделе. И только с регистрацией новых предприятий она спускается вниз.<br /><br />Но особенно выгодно у нас быть лидером. Наш сайт &ndash; это почти как поисковик. Если компания пользуется известностью, и ее аккаунт посещает множество людей, то она всегда на видном месте. А это ведет к еще большему потоку клиентов.<br /><br />Но регистрация в нашем каталоге &ndash; это не просто добавление контактов. <strong>Вам предоставляется возможность</strong> влиять на собственное присутствие. Разнообразный функционал сайта позволит собирать статистику о пользователях, зашедших к вам, видеть их мнение, подсчитывать конверсию и т.д. То есть самый настоящий инструментарий для оптимизации своего успеха.<br /><br />Итак, наш каталог поможет вам:<br /><br />- сделать визуальную &laquo;зацепку&raquo; посетителя посредством логотипа фирмы;<br />- предоставить пользователю полную информацию о себе;<br />- в наилучшем виде презентовать прайс-лист с фотографиями товаров;<br />- быть постоянно на виду при помощи баннеров;<br />- стать настолько популярными, что известность начнет сама работать на вас.<br /><br /> <a href=\"http://vkaragande.info\">I-Soft Bizness</a></p>', 'каталог, возможности, регистрация, добавить фирму', 'Приглашаем к регистрации в каталоге', 'Регистрация в нашем каталоге. Добавить фирму, магазин или товар.', 'каталог, регистрация, бизнес, фирма, купить, продать, товары, услуги', '', '', '127.0.0.1', 0, 0, 0, 0, 0)");

        break;

        // Социальная страница компании и другие обновления скрипта
        case "4.7.9":

            $sql1 = "ALTER TABLE `$db_users` CHANGE `on_newrev` `on_newrev` TINYINT( 1 ) NULL DEFAULT NULL ,
            CHANGE `on_rating` `on_rating` TINYINT( 1 ) NULL DEFAULT NULL ,
            CHANGE `off_mail` `off_mail` TINYINT( 1 ) NULL DEFAULT NULL ,
            CHANGE `off_mailer` `off_mailer` TINYINT( 1 ) NULL DEFAULT NULL ,
            CHANGE `off_rev` `off_rev` TINYINT( 1 ) NULL DEFAULT NULL";

            $db->query ( $sql1 );

            $sql2 = "ALTER TABLE `$db_users` ADD `social` text not NULL AFTER `www`";

            $db->query ( $sql2 );

            $sql3 = "ALTER TABLE `$db_users` ADD `domen` varchar(255) not NULL AFTER `login`";

            $db->query ( $sql3 );

            $sql5 = "ALTER TABLE `$db_users` ADD `metatitle` varchar(255) not NULL AFTER `firmname`";

            $db->query ( $sql5 );

            $sql6 = "ALTER TABLE `$db_users` ADD `metadescr` varchar(255) not NULL AFTER `metatitle`";

            $db->query ( $sql6 );

            $sql7 = "ALTER TABLE `$db_users` ADD `metakeywords` text not NULL AFTER `metadescr`";

            $db->query ( $sql7 );

            $sql7 = "ALTER TABLE `$db_users` ADD `keywords` text not NULL AFTER `firmname`";

            $db->query ( $sql7 );

            $sql8 = "ALTER TABLE `$db_users` ADD `theme` varchar(50) not NULL AFTER `keywords`";

            $db->query ( $sql8 );

            $sql9 = "ALTER TABLE `$db_users` ADD `design` varchar(200) not NULL AFTER `theme`";

            $db->query ( $sql9 );

            $sql10 = "ALTER TABLE `$db_users` ADD `setting_s` text not NULL AFTER `design`";

            $db->query ( $sql10 );

            $sql.=$sql1."\n".$sql2."\n".$sql3."\n".$sql4."\n".$sql5."\n".$sql6."\n".$sql7."\n".$sql8."\n".$sql9."\n".$sql10;

        break;

        // Местоположение фирмы на карте
        case "4.7.11":

            $sql1 = "ALTER TABLE `$db_users` ADD `map` varchar(255) not NULL AFTER `business`";

            $db->query ( $sql1 );

            $sql2 = "ALTER TABLE `$db_users` ADD `mapstype` varchar(50) not NULL AFTER `map`";

            $db->query ( $sql2 );

            $sql.=$sql1."\n".$sql2;
 
        break;

        // Новый рейтинг организаций и фирм
        case "4.7.13":

            if (empty($db_engines )) {
                $connect_data = str_replace ('$db = new Dbaccess;', "\n".'$db_engines = $prefix_b ."_engines";'."\n".'$db_stat = $prefix_b ."_stat";'."\n"."\n".'$db = new Dbaccess;', $connect_data );
                file_put_connect($connect_data);
            }

            include ("../connect.php");

            $sql1 = "ALTER TABLE `$db_users` ADD `hits_m` INT( 11 ) NOT NULL AFTER `counter` ";

            $sql2 = "ALTER TABLE `$db_users` ADD `hits_d` INT( 11 ) NOT NULL AFTER `counter` ";

            $db->query ( $sql1 );

            $db->query ( $sql2 );

            $sql3="create table $db_engines (id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, firmselector int(11) NOT NULL, yandex int(11) NOT NULL, google int(11) NOT NULL, mail int(11) NOT NULL, bing int(11) NOT NULL, yahoo int(11) NOT NULL, rambler int(11) NOT NULL, aport int(11) NOT NULL, twitter int(11) NOT NULL, facebook int(11) NOT NULL, odnoklassniki int(11) NOT NULL, vk int(11) NOT NULL, mymail int(11) NOT NULL ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

            mysql_query("DROP TABLE $db_engines");
            mysql_query($sql3)  or die ("<b>Создание</b> ENGINES TABLE as $db_engines - </b>  - <font color=red>FAILED</font><br>");

            $sql4="create table $db_stat (id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, firmselector int(11) NOT NULL, year int(11) NOT NULL, m01 int(11) NOT NULL, m02 int(11) NOT NULL, m03 int(11) NOT NULL, m04 int(11) NOT NULL, m05 int(11) NOT NULL, m06 int(11) NOT NULL, m07 int(11) NOT NULL, m08 int(11) NOT NULL, m09 int(11) NOT NULL, m10 int(11) NOT NULL, m11 int(11) NOT NULL, m12 int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

            mysql_query("DROP TABLE $db_stat");
            mysql_query($sql4)  or die ("<b>Создание</b> STAT TABLE as $db_stat - </b>  - <font color=red>FAILED</font><br>");

            $sql.=$sql1."\n".$sql2."\n".$sql3."\n".$sql4;

        break;

        // Пожаловаться на содержимое компании
        case "4.7.15":

            if (empty($db_complaint)) {
                $connect_data = str_replace ('$db = new Dbaccess;', "\n".'$db_complaint = $prefix_b ."_complaint";'."\n"."\n".'$db = new Dbaccess;', $connect_data );
                file_put_connect($connect_data);
            }

            include ("../connect.php");

            $r = mysql_query("SELECT `domen1` FROM $db_users WHERE 0");

            if (!$r) $sql1 = "ALTER TABLE `$db_users` ADD `domen1` varchar(255) NOT NULL AFTER `domen` ";

            $db->query ( $sql1 );

            $sql2="create table $db_complaint (id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, date datetime NOT NULL default '0000-00-00 00:00:00', url text NOT NULL default '', category varchar(255) NOT NULL default '', name varchar(100) NOT NULL default '', email varchar(100) NOT NULL default '', comment text NOT NULL default '', firmselector int(11) NOT NULL ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

            mysql_query("DROP TABLE $db_complaint");
            mysql_query($sql2)  or die ("<b>Создание</b> ENGINES TABLE as $db_complaint - </b>  - <font color=red>FAILED</font><br>");

            $sql.=$sql1."\n".$sql2;

        break;

        // Проверка компании
        case "4.7.19":

            if (empty($db_case)) {
                $connect_data = str_replace ('$db = new Dbaccess;', "\n".'$db_case = $prefix_b ."_case";'."\n"."\n".'$db = new Dbaccess;', $connect_data );
                file_put_connect($connect_data);
            }

            include ("../connect.php");

            $r = mysql_query("SELECT `tcase` FROM $db_users WHERE 0");

            if (!$r) $sql1 = "ALTER TABLE `$db_users` ADD `tcase` tinyint(1) NOT NULL AFTER `mail` ";
            if (!$r) $sql11 = "ALTER TABLE `$db_users` ADD `tmail` mediumint (5) NOT NULL AFTER `mail` ";

            $db->query ( $sql1 );
            $db->query ( $sql11 );

            $sql2="create table $db_case (id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, firmselector int(10) NOT NULL, status tinyint(1) NOT NULL, date datetime NOT NULL default '0000-00-00 00:00:00', notes text NOT NULL default '', banking text NOT NULL default '', contact text NOT NULL default '', bin varchar( 255 ) NOT NULL default '', info text NOT NULL default '', alpha varchar( 5 ) NOT NULL default '', codefirm varchar( 6 ) NOT NULL default '') ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

            mysql_query("DROP TABLE $db_case");
            mysql_query($sql2)  or die ("<b>Создание</b> ENGINES TABLE as $db_case - </b>  - <font color=red>FAILED</font><br>");

            $sql.=$sql1."\n".$sql11."\n".$sql2;

            $sql12 = "ALTER TABLE `$db_users` CHANGE `on_newrev` `on_newrev` TINYINT( 1 ) NULL DEFAULT NULL ,
            CHANGE `on_rating` `on_rating` TINYINT( 1 ) NULL DEFAULT NULL ,
            CHANGE `off_mail` `off_mail` TINYINT( 1 ) NULL DEFAULT NULL ,
            CHANGE `off_mailer` `off_mailer` TINYINT( 1 ) NULL DEFAULT NULL ,
            CHANGE `loch_m` `loch_m` TINYINT( 1 ) NULL DEFAULT NULL ,
            CHANGE `date` `date` varchar(20) NULL DEFAULT NULL ,
            CHANGE `date_update` `date_update` varchar(20) NULL DEFAULT NULL ,
            CHANGE `ip_update` `ip_update` varchar(20) NULL DEFAULT NULL ,
            CHANGE `ip` `ip` varchar(20) NULL DEFAULT NULL ,
            CHANGE `date_upgrade` `date_upgrade` varchar(20) NULL DEFAULT NULL ,
            CHANGE `counterip` `counterip` varchar(20) NULL DEFAULT NULL ,
            CHANGE `flag` `flag` varchar(4) NULL DEFAULT NULL ,
            CHANGE `firmstate` `firmstate` varchar(4) NULL DEFAULT NULL ,
            CHANGE `off_rev` `off_rev` TINYINT( 1 ) NULL DEFAULT NULL";

            @$db->query ( $sql12 );

        break;

        // Статические страницы
        case "4.7.21":

            if (empty($db_static)) {
                $connect_data = str_replace ('$db = new Dbaccess;', "\n".'$db_static = $prefix_b ."_static";'."\n"."\n".'$db = new Dbaccess;', $connect_data );
                file_put_connect($connect_data);
            }

            include ("../connect.php");

            mysql_query("DROP TABLE $db_static");
            mysql_query("create table $db_static (selector INT(11) UNSIGNED AUTO_INCREMENT NOT NULL, date datetime NOT NULL default '0000-00-00 00:00:00', title varchar(255) NOT NULL default '', name varchar(200) NOT NULL default '', hit int(11) NOT NULL, full text NOT NULL default '', metatitle varchar(255) NOT NULL default '', metadescr varchar(255) NOT NULL default '', metakeywords text NOT NULL default '', full_tpl varchar(50) NOT NULL default '', sitemap_off tinyint(1) NOT NULL,  noindex tinyint(1) NOT NULL, ip varchar(50) NOT NULL default '', PRIMARY KEY  (selector), KEY `date` (`date`), KEY `name` (`name`), FULLTEXT (full, title)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")  or die ("<b>Создание</b> REPLY TABLE as $db_static - </b>  - <font color=red>FAILED</font><br>");

            $sql.="create table $db_static (selector INT(11) UNSIGNED AUTO_INCREMENT NOT NULL, date datetime NOT NULL default '0000-00-00 00:00:00', title varchar(255) NOT NULL default '', name varchar(200) NOT NULL default '', hit int(11) NOT NULL, full text NOT NULL default '', metatitle varchar(255) NOT NULL default '', metadescr varchar(255) NOT NULL default '', metakeywords text NOT NULL default '', full_tpl varchar(50) NOT NULL default '', sitemap_off tinyint(1) NOT NULL,  noindex tinyint(1) NOT NULL, ip varchar(50) NOT NULL default '', PRIMARY KEY  (selector), KEY `date` (`date`), KEY `name` (`name`), FULLTEXT (full, title)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $sql.="\n";

        break;
        
        // Поиск с картами и новая версия видеоролики
        case "4.7.22":

            include ("../connect.php");

            $sql0 = "ALTER TABLE `$db_category` ADD `title` text AFTER `img`";
            $sql1 = "ALTER TABLE `$db_subcategory` ADD `title` text AFTER `fcounter`";
            $sql2 = "ALTER TABLE `$db_subcategory` ADD `description` text AFTER `title`";
            $sql3 = "ALTER TABLE `$db_subcategory` ADD `keywords` text AFTER `description`";
            $sql4 = "ALTER TABLE `$db_subcategory` ADD `img` varchar(255) AFTER `keywords`";
            $sql5 = "ALTER TABLE `$db_subcategory` ADD `description_full` text AFTER `img`";
            $sql6 = "ALTER TABLE `$db_subcategory` ADD `recomend` text AFTER `description_full`";
            $sql7 = "ALTER TABLE `$db_subsubcategory` ADD `title` text AFTER `fcounter`";
            $sql8 = "ALTER TABLE `$db_subsubcategory` ADD `description` text AFTER `title`";
            $sql9 = "ALTER TABLE `$db_subsubcategory` ADD `keywords` text AFTER `description`";
            $sql10 = "ALTER TABLE `$db_subsubcategory` ADD `img` varchar(255) AFTER `keywords`";
            $sql11 = "ALTER TABLE `$db_subsubcategory` ADD `description_full` text AFTER `img`";
            $sql12 = "ALTER TABLE `$db_subsubcategory` ADD `recomend` text AFTER `description_full`";

            $db->query ( $sql0 );
            $db->query ( $sql1 );
            $db->query ( $sql2 );
            $db->query ( $sql3 );
            $db->query ( $sql4 );
            $db->query ( $sql5 );
            $db->query ( $sql6 );
            $db->query ( $sql7 );
            $db->query ( $sql8 );
            $db->query ( $sql9 );
            $db->query ( $sql10 );
            $db->query ( $sql11 );
            $db->query ( $sql12 );

            $sql.="$sql0\n"; $sql.="$sql1\n"; $sql.="$sql2\n"; $sql.="$sql3\n"; $sql.="$sql4\n"; $sql.="$sql5\n"; $sql.="$sql6\n"; $sql.="$sql7\n"; $sql.="$sql8\n"; $sql.="$sql9\n"; $sql.="$sql10\n"; $sql.="$sql11\n"; $sql.="$sql12\n";

            @chmod("../images/subcat/", 0777);
            @chmod("../images/subsubcat", 0777);
            

            $sql0 = "ALTER TABLE `$db_video` ADD `sort` int(11) AFTER `message`";
            $sql1 = "ALTER TABLE `$db_video` ADD `rateNum` int(11) AFTER `message`";
            $sql2 = "ALTER TABLE `$db_video` ADD `rateVal` int(11) AFTER `message`";
            $sql3 = "ALTER TABLE `$db_video` ADD `hits` int(11) AFTER `message`";
            $sql4 = "ALTER TABLE `$db_video` ADD `ip` varchar(20) AFTER `message`";
            $sql5 = "ALTER TABLE `$db_video` ADD `full` text AFTER `message`";
            $sql6 = "ALTER TABLE `$db_video` ADD `recommend` varchar(50) AFTER `hits`";
            $sql7 = "ALTER TABLE `$db_video` ADD `metatitle` varchar(255) AFTER `hits`";
            $sql8 = "ALTER TABLE `$db_video` ADD `metadescr` varchar(255) AFTER `hits`";
            $sql9 = "ALTER TABLE `$db_video` ADD `metakeywords` text AFTER `hits`";
            $sql10 = "ALTER TABLE `$db_video` ADD `name` varchar(255) AFTER `hits`";

            $db->query ( $sql4 );
            $db->query ( $sql3 );
            $db->query ( $sql2 );
            $db->query ( $sql1 );
            $db->query ( $sql0 );
            $db->query ( $sql5 );
            $db->query ( $sql6 );
            $db->query ( $sql7 );
            $db->query ( $sql8 );
            $db->query ( $sql9 );
            $db->query ( $sql10 );

            $sql.="$sql5\n"; $sql.="$sql0\n"; $sql.="$sql1\n"; $sql.="$sql2\n"; $sql.="$sql3\n"; $sql.="$sql4\n"; $sql.="$sql6\n"; $sql.="$sql7\n"; $sql.="$sql8\n"; $sql.="$sql9\n"; $sql.="$sql10\n";

        break;
    
        // Фотогалерея
        case "4.7.23":

            if (empty($db_foto)) {                
                $connect_data = str_replace ('$db = new Dbaccess;', "\n".'$db_foto = $prefix_b ."_foto";'."\n".'$db_foto_meta = $prefix_b ."_foto_meta";'."\n"."\n".'$db = new Dbaccess;', $connect_data );
                file_put_connect($connect_data);
            }

            include ("../connect.php");

            mysql_query("DROP TABLE $db_foto");
            mysql_query("create table $db_foto (`num` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, `item` TEXT NULL, `date` varchar(50) NULL, `message` TEXT NULL, `sort` INT(11) NULL DEFAULT NULL, `rateNum` INT(11) NULL DEFAULT NULL,  `rateVal` INT(11) NULL DEFAULT NULL, `hits` INT(11) NULL DEFAULT NULL, `category` VARCHAR(250) NULL DEFAULT NULL, PRIMARY KEY (`num`), FULLTEXT INDEX `item` (`item`, `message`)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")  or die ("<b>Создание</b> REPLY TABLE as $db_foto - </b>  - <font color=red>FAILED</font><br>");
            mysql_query("DROP TABLE $db_foto_meta");
            mysql_query("create table $db_foto_meta (`rewrite` TEXT NULL, `title` TEXT NULL, `keywords` TEXT NULL, `description` TEXT NULL, `item` TEXT NULL, `object` TEXT NULL, `map` varchar(255) NULL, `mapstype` varchar(50) NULL, `full` TEXT NULL) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")  or die ("<b>Создание</b> REPLY TABLE as $db_foto_meta - </b>  - <font color=red>FAILED</font><br>");

            $sql.="create table $db_foto (`num` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, `item` TEXT NULL, `date` varchar(50) NULL, `message` TEXT NULL, `sort` INT(11) NULL DEFAULT NULL, `rateNum` INT(11) NULL DEFAULT NULL,  `rateVal` INT(11) NULL DEFAULT NULL, `hits` INT(11) NULL DEFAULT NULL, `category` VARCHAR(250) NULL DEFAULT NULL, PRIMARY KEY (`num`), FULLTEXT INDEX `item` (`item`, `message`)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $sql.="\n";
            $sql.="create table $db_foto_meta (`rewrite` TEXT NULL, `title` TEXT NULL, `keywords` TEXT NULL, `description` TEXT NULL, `item` TEXT NULL, `object` TEXT NULL, map varchar(255) NULL, mapstype(50) NULL) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $sql.="\n";

        break;    

        default: echo'';
    }

    if ($sql!='') {

        msg_text('80%',$def_admin_message_ok,'Операция по обновлению таблиц для кода <b>'.$key.'</b> выполнена успешно!<br /><br />'.$sql);

    }

    else {

        msg_text('80%',$def_admin_message_error,'Операция по обновлению таблиц для кода <b>'.$key.'</b> не выполнено!<br />Попробуйте повторить процедуру.');

    }

?>

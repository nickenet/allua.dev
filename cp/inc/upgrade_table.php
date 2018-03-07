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

function upgrade_table($key_up) {

    global $db, $db_users, $db_zsearch, $db_reviews, $db_links, $db_news, $db_newsrev, $db_engines, $db_complaint, $error_version, $db_case, $db_static,$db_video,$db_category,$db_foto, $db_foto_meta;

    $key_up=trim($key_up);

    unset($r);

    switch ($key_up) {

        // Обновление галереи изображений и поиска по каталогу
        case "4.7.1":

            $r = mysql_query("SELECT `item` FROM $db_zsearch WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;

        // Редактор шаблонов
        case "4.7.2":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Галерея изображений компаний
        case "4.7.3":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Обновление возможностей комментариев в каталоге
        case "4.7.4":

            $r = mysql_query("SELECT `avatar` FROM $db_reviews WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;

        // Мои файлы
        case "4.7.5":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Устраненные ошибки и небольшие модификации
        case "4.7.6":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Мои ссылки
        case "4.7.7":

            $r = mysql_query("SELECT `selector` FROM $db_links WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;

        // Новости каталога
        case "4.7.8":

            $r = mysql_query("SELECT `id` FROM $db_newsrev WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;

        // Социальная страница компании и другие обновления скрипта
        case "4.7.9":

            $r = mysql_query("SELECT `theme` FROM $db_users WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;

        // Карта сайта Sitemap
        case "4.7.10":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Местоположение фирмы на карте
        case "4.7.11":

            $r = mysql_query("SELECT `map` FROM $db_users WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;

        // Новый формат e-mail сообщений, рассылка и дополнения к соц. странице
        case "4.7.12":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Новый рейтинг организаций и фирм
        case "4.7.13":

            $r = mysql_query("SELECT `yandex` FROM $db_engines WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;

        // Изменение тарифных планов и другие обновления скрипта
        case "4.7.14":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Пожаловаться на содержимое компании
        case "4.7.15":

            $r = mysql_query("SELECT `date` FROM $db_complaint WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;

        // Проверка обновлений системы
        case "4.7.16":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Обновление мобильной версии
        case "4.7.17":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Обновление галереи изображений
        case "4.7.18":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Проверенная компания
        case "4.7.19":

            $r = mysql_query("SELECT `status` FROM $db_case WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;

        // Сайты организаций
        case "4.7.20":

            echo '<img src="images/ok_table.png" alt="Таблицы не требуются" title="Таблицы не требуются" width="22" height="22" align="absmiddle" />';

        break;

        // Статические страницы
        case "4.7.21":

            $r = mysql_query("SELECT `name` FROM $db_static WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;
        
        // Поиск с картами
        case "4.7.22":

            $r = mysql_query("SELECT `title` FROM $db_category WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;  
        
        // Фотогалерея
        case "4.7.23":

            $r = mysql_query("SELECT `item` FROM $db_foto WHERE 0");
            if ($r) echo '<img src="images/ok.png" alt="Таблицы найдены" title="Таблицы найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<div align="center" class="slink"><img src="images/warning.png" alt="Таблицы не найдены" title="Таблицы не найдены" width="22" height="22" align="absmiddle" /> <a href="?key='.$key_up.'">Исправить</a></div>'; $error_version++; }

        break;         

        default: echo'';;

    }

}

?>

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

function upgrade_system($key_up) {

    global $db_zsearch, $db_reply, $def_offer_showNum, $db_links, $db_news, $def_news_module, $def_min_pos_social, $def_map_type,
           $def_from_email, $db_stat, $def_news_cache_cat, $def_charset, $db_complaint, $error_version, $def_pda, $def_operator_mobile, $def_gallery_h_w, $def_gallery_gallery,
            $def_short_message_offers, $def_reklamamail, $def_map_iconA, $db_static, $def_foto_showNum, $db_foto_meta;


    $key_up=trim($key_up);

    switch ($key_up) {

        // Обновление галереи изображений и поиска по каталогу
        case "4.7.1":

            if (isset($db_zsearch)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

       // Редактор шаблонов
       case "4.7.2":

            if (file_exists('shablon.php')) echo '<img src="images/ok.png" alt="Файл найден" title="Файл найден" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Файл не найден" title="Файл не найден" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

       // Галерея изображений компаний
       case "4.7.3":

            if (file_exists('../allimg.php')) echo '<img src="images/ok.png" alt="Файл найден" title="Файл найден" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Файл не найден" title="Файл не найден" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Обновление возможностей комментариев в каталоге
        case "4.7.4":

            if (isset($db_reply)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

       // Мои файлы
       case "4.7.5":

            if (file_exists('myfiles.php')) echo '<img src="images/ok.png" alt="Файл найден" title="Файл найден" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Файл не найден" title="Файл не найден" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Устраненные ошибки и небольшие модификации
        case "4.7.6":

            if (isset($def_offer_showNum)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Мои ссылки
        case "4.7.7":

            if (isset($db_links) and file_exists('mylinks.php')) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Новости каталога
        case "4.7.8":

            if (isset($def_news_module) and  isset($db_news) and file_exists('../news.php')) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Социальная страница компании и другие обновления скрипта
        case "4.7.9":

            if (isset($def_min_pos_social) and file_exists('../includes/components/social_firm.php')) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Карта сайта Sitemap
        case "4.7.10":

            if (file_exists('sitemap.php')) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Местоположение фирмы на карте
        case "4.7.11":

            if (isset($def_map_type) and file_exists('../includes/components/maps_firm.php')) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Новый формат e-mail сообщений, рассылка и дополнения к соц. странице
        case "4.7.12":

            if (isset($def_from_email)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Новый рейтинг организаций и фирм
        case "4.7.13":

            if (isset($db_stat)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Изменение тарифных планов и другие обновления скрипта
        case "4.7.14":

            if (isset($def_news_cache_cat) and isset($def_charset)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Пожаловаться на содержимое компании
        case "4.7.15":

            if (isset($db_complaint)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Проверка обновлений системы
        case "4.7.16":

            if (file_exists('upgrade.php')) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Обновление мобильной версии
        case "4.7.17":

            if (isset($def_pda) and  isset($def_operator_mobile)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Обновление галереи изображений
        case "4.7.18":

            if (isset($def_gallery_gallery) and  isset($def_gallery_h_w)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Проверенная компания
        case "4.7.19":

            if (isset($def_short_message_offers) and  isset($def_reklamamail)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Сайты организаций
        case "4.7.20":

            if (isset($def_map_iconA)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Статические страницы
        case "4.7.21":

            if (isset($db_static)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;

        // Поиск с картами
        case "4.7.22":

            if (isset($db_static)) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;
        
        // Фотогалерея
        case "4.7.23":

            if ((isset($def_foto_showNum)) and (isset($db_foto_meta))) echo '<img src="images/ok.png" alt="Переменные найдены" title="Переменные найдены" width="22" height="22" align="absmiddle" />';
            else { echo '<img src="images/warning.png" alt="Переменные не найдены" title="Переменные не найдены" width="22" height="22" align="absmiddle" />'; $error_version++; }

        break;        

        default: echo'';;

    }

}

?>

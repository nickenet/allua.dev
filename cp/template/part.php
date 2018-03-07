<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: part.php
-----------------------------------------------------
 Назначение: Разделы CP
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

	$rstat=$db->query ("select firmstate from $db_users where firmstate='off' and firmname!=''") or die ("mySQL error!");
	$firms_nonregistered=mysql_num_rows($rstat);
	mysql_free_result($rstat);

        if (empty($_SESSION['comnews'])) {
            $rstat_comnews = $db->query('SELECT status FROM ' . $db_newsrev . ' WHERE status="off"');
            $_SESSION['comnews']=mysql_num_rows ($rstat_comnews);
            mysql_free_result($rstat_comnews);
        }

        if (empty($_SESSION['complaint'])) {
            $rstat_complaint = $db->query("SELECT * FROM $db_complaint");
            $_SESSION['complaint']=mysql_num_rows($rstat_complaint);
            mysql_free_result($rstat_complaint);
        }
        if (empty($_SESSION['complaint'])) {
            $rstat_case=$db->query ("select COUNT(*) from $db_case where status='1'");
            @$_SESSION['case_admin'] = mysql_result($rstat_case, 0 ,0);
            @mysql_free_result($rstat_case);
        }

?>

<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><img src="images/cont_bg_vt.gif" width="105" height="25" /></td>
    <td height="25" background="images/cont_bg_g.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="105" align="center" background="images/cont_bg.gif"><img src="images/content.png" width="48" height="48" /><br />
      <span class="closed">Контент</span></td>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/iptools.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="find.php?REQ=auth" class="vibor">Быстрый поиск компании</a><br />
              Быстрый поиск контрагентов и редактирования их данных,  продукции и изображений. </td>
          </tr>
        </table></td>
        <td><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/find_base.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="search.php?REQ=auth" class="vibor">Найти/Редактировать контрагента </a><br />
              Расширенный поиск контрагентов и редактирования их данных, продукции и изображений. </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/users.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="firms.php?REQ=auth" class="vibor">Активация контрагентов (<? echo "$firms_nonregistered"; ?>)</a><br />
              Для одобрения/отклонения новой регистрации</td>
          </tr>
        </table></td>
        <td><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/pset.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="register.php" class="vibor">Создать нового контрагента </a><br />
              Для добавления нового контрагента</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/fset.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="reviews2.php?REQ=auth" class="vibor">Найти/Удалить/Редактировать комментарии </a><br />
              Поиск, удаление или редактирование комментариев. </td>
          </tr>
        </table></td>
        <td><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/general.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><? 

if ($def_reviews_enable == "YES") {

	$rstat123=$db->query ("select status from $db_reviews where status='off'") or die ("mySQL error!");
	$revs2=mysql_num_rows($rstat123);
	mysql_free_result($rstat123);
?>
                <a href="reviews.php?REQ=auth" class="vibor">Одобрить комментарии  (<? echo "$revs2"; ?>)</a><br />
              Для одобрения комментариев.
              <? } ?>            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/banner.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="banner.php" class="vibor">Баннеры контрагентов</a><br />
              Управление загруженными баннерами контрагентов.</td>
          </tr>
        </table></td>
         <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/case.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="case.php" class="vibor">Проверка документов (<? echo $_SESSION['case_admin']; ?>)</a><br />
              Проверка загруженных документов компании.</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td background="images/cont_bg_v.gif">&nbsp;</td>
    <td height="25" background="images/cont_bg_g.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="105" align="center" background="images/cont_bg.gif"><img src="images/network.png" width="48" height="48" /><br />
      <span class="closed">Размещения</span></td>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/dbset.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="edlocations.php" class="vibor">Редактировать размещения </a><br />
              Для редактирования размещения (Стран/городов, в зависимости от конфигурации). </td>
          </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/tmpl.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="edstates.php" class="vibor">Редактировать области </a><br />
              Для редактирования областей. </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="50%">&nbsp;</td>
        <td width="50%">&nbsp;</td>
      </tr>
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/cats.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="edcat.php" class="vibor">Редактировать категории</a><br />
              Для создания или редактирования категорий или подкатегорий каталога. </td>
          </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/usersgroup.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="move.php?REQ=auth" class="vibor">Перемещение контрагентов </a><br />
              Перемещение контрагентов из одной категории каталога в другую. </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td background="images/cont_bg_v.gif">&nbsp;</td>
    <td height="25" background="images/cont_bg_g.gif">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" background="images/cont_bg.gif"><img src="images/modules.png" width="48" height="48" /><br />
      <span class="closed">Модули</span></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/fset.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="static.php" class="vibor">Статические страницы</a><br />
              Создание и редактирование страниц, которые как правило редко изменяются и имеют   постоянный адрес. </td>
          </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/xprof.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="vote.php" class="vibor">Управление голосованиями </a><br />
              Создание и редактирование различных опросов или голосований.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="50%">&nbsp;</td>
        <td width="50%">&nbsp;</td>
      </tr>
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/iset.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="cpffoto.php" class="vibor">Фотогалерея</a><br />
              Управление разделом фотогалерея. Загрузка, удаление, редактирование фотографий. Управление комментариями к фотографиям.</td>
          </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/tags.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="cptags.php" class="vibor">Облако тегов</a><br />
              Создание и редактирование ссылок каталога для облака тегов.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="50%">&nbsp;</td>
        <td width="50%">&nbsp;</td>
      </tr>
      <tr>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/reklama.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="reklama.php" class="vibor">Рекламные места</a><br />
              Добавление и управление рекламными материалами, которые публикуются в каталоге.</td>
          </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/email.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="mailer.php" class="vibor">Рассылка </a><br />
              Для отправки сообщения всем контрагентам или группе.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="50%">&nbsp;</td>
        <td width="50%">&nbsp;</td>
      </tr>
      <tr>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/kmenu.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="menu.php" class="vibor">Меню каталога</a><br />
              Создание и редактирование разделов меню каталога.</td>
          </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/myfiles.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="myfiles.php" class="vibor">Мои файлы</a><br />
              Загрузка необходимых файлов на сервер.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="50%">&nbsp;</td>
        <td width="50%">&nbsp;</td>
      </tr>
      <tr>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/news.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="editallnews.php" class="vibor">Новости (<? echo $_SESSION['comnews']; ?>)</a><br />
              Создание и редактирование новостей в каталоге.</td>
          </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/mylinks.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="mylinks.php" class="vibor">Мои ссылки</a><br />
              Создание и редактирование ссылок.</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td background="images/cont_bg_v.gif">&nbsp;</td>
    <td height="25" background="images/cont_bg_g.gif">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" background="images/cont_bg.gif"><img src="images/utilites.png" width="48" height="48" /><br />
      <span class="closed">Утилиты</span></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/mcache.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="cpcache.php" class="vibor">Очистка кэша</a><br />
              Работа с кэшированными данными.</td>
          </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/news_pole.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="infofields.php" class="vibor">Управление дополнительными полями</a><br />
              Создание и редактирование дополнительных полей в информационном блоке.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/rootpassword.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="cppassword.php" class="vibor">Изменить логин/пароль</a><br />
              Изменение логина или пароля контрагента.</td>
          </tr>
        </table></td>
        <td><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/rating.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="up_rating.php" class="vibor">Изменить рейтинг</a><br />
              Увеличить/уменьшить рейтинг компании.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/shablon.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="shablon.php" class="vibor">Шаблоны каталога</a><br />
              Редактирование шаблонов, которые используются в каталоге.</td>
          </tr>
        </table></td>
        <td><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/complaint.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="complaint.php" class="vibor">Жалобы (<? echo $_SESSION['complaint']; ?>)</a><br />
              В данном разделе вы можете просмотреть список жалоб, поступивших от посетителей каталога.</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td background="images/cont_bg_v.gif">&nbsp;</td>
    <td height="25" background="images/cont_bg_g.gif">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" background="images/cont_bg.gif"><img src="images/stat.png" width="48" height="48" /><br />
      <span class="closed">Статистика</span></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/stats.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="./stat.php" class="vibor">Статистика </a><br />
              Общая информация по каталогу. </td>
          </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/votes.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="counter.php?REQ=auth" class="vibor">Счетчик статистики </a><br />
              Для просмотра статистики посещаемости каталога.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/db_opt.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="csv.php?file=stats-<? echo date("Y-m-d"); ?>.csv" class="vibor">Статистика по контрагентам</a><br />
              Общая информация по всем зарегистрированным контрагентам в формате CVS. </td>
          </tr>
        </table></td>
        <td width="50%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
    <tr>
    <td background="images/cont_bg_v.gif">&nbsp;</td>
    <td height="25" background="images/cont_bg_g.gif">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" background="images/cont_bg.gif"><img src="images/configurations.png" width="48" height="48" /><br />
      <span class="closed">Конфигурации</span></td>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50"><img src="images/eduser.png" width="48" height="48" /></td>
              <td valign="top" class="zag"><a href="profil.php" class="vibor">Администратор</a><br />
                Управление и настройка личного профиля администратора.</td>
            </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50"><img src="images/user_add.png" width="48" height="48" /></td>
              <td valign="top" class="zag"><a href="admin_user.php" class="vibor">Управление администраторами</a><br />
                Создание и редактирование администраторов. Назначение прав доступа к разделам.</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50"><img src="images/dboption.png" width="48" height="48" /></td>
              <td valign="top" class="zag"><a href="dumper.php" class="vibor">Управление базой данных</a><br />
                Резервное копирование и восстановление базы данных. </td>
            </tr>
        </table></td>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/memberships.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a href="cpmemberships.php" class="vibor">Управление тарифными планами</a><br />
              Настройка и редактирование тарифных планов.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50"><img src="images/sitemap.png" width="48" height="48" /></td>
              <td valign="top" class="zag"><a href="sitemap.php" class="vibor">Карта сайта Sitemap</a><br />
                Создание карт сайта для поисковых систем.</td>
            </tr>
        </table></td>
        <td><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50"><img src="images/components.png" width="48" height="48" /></td>
              <td valign="top" class="zag"><a href="in_work_out.php" class="vibor">Компоненты</a><br />
                Подключение сторонних файлов, модулей к системе.</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td background="images/cont_bg_v.gif">&nbsp;</td>
    <td height="25" background="images/cont_bg_g.gif">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" background="images/cont_bg.gif"><img src="images/dop_mod.png" width="48" height="48" /><br />
      <span class="slink">Сторонние<br />
      модули</span></td>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50"><img src="images/market.png" width="48" height="48" /></td>
            <td valign="top" class="zag"><a target="_blank" href="http://market.vkaragande.info/" class="vibor">Магазин приложений </a><br />
              Модули и модификации сторонних разработчиков.</td>
          </tr>
        </table></td>
        <td width="50%"><? require_once 'apx/apx.php'; ?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
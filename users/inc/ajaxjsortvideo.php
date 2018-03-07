<?php

/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi 
  =====================================================
  Файл: ajaxsortvideo.php
  -----------------------------------------------------
  Назначение: Ajax действия по сортировке видео
  =====================================================
 */

header("Content-type: text/plain; charset=windows-1251");

// Including configuration file
include ( "../../conf/config.php" );

// Including mysql class
include ( "../../includes/$def_dbtype.php" );

// Connecting to the database
include ( "../../connect.php" );

// Including functions
include ( "../../includes/sqlfunctions.php" );

      $itemsArray = array_reverse(explode(',', $_GET['items']));

      for($item = 0; $item < count($itemsArray); $item++) {
         $sql = "UPDATE $db_video SET sort=" . intval($item) . " WHERE num=" . intval($itemsArray[$item]) . " LIMIT 1";
         mysql_query($sql);
      }

echo 'Успешно выполнено!';


?>
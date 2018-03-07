<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: stat.php
-----------------------------------------------------
 Назначение: Работа со статистикой
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$date=date ("m-d-Y"); 

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Работа со статистикой</li>
            </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Статистика</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td>

              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td width="280" align="right">Дата регистрации в каталаге:</td>
                  <td><b><? echo undate($f[date], $def_datetype); ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">Регистрация в категориях:</td>
<?php

$catzzz=explode(":", $f[category]);

for ($zzz=0;$zzz<count($catzzz);$zzz++)

{

$catzzz1 = explode ("#", $catzzz[$zzz]);

     $res2 = $db->query ( "SELECT * FROM $db_category WHERE selector='$catzzz1[0]'");
     $fe2 = $db->fetcharray ( $res2 );

if ($db->numrows($res2) > 0)
{
    $caturl = "category=$catzzz1[0]";
    $showcategory2 = "$fe2[category]";
}
else
     $showcategory2 = "";

     $db->freeresult ( $res2 );

     $res = $db->query ( "SELECT * FROM $db_subcategory WHERE catsubsel='$catzzz1[1]'");
     $fe = $db->fetcharray ( $res );
if ($db->numrows($res) > 0)
{
$caturl = "cat=$catzzz1[0]&subcat=$catzzz1[1]";
$showcategory = " / $fe[subcategory]";
}
else
{
     $showcategory = "";
}
     $db->freeresult ( $res );

     $res3 = $db->query ( "SELECT * FROM $db_subsubcategory WHERE catsel='$catzzz1[0]' and catsubsel='$catzzz1[1]' and catsubsubsel='$catzzz1[2]'");
     $fe3 = $db->fetcharray ( $res3 );
if ($db->numrows($res3) > 0)
{
     $caturl .= "&subsubcat=$catzzz1[2]";
     $showsubcategory = " / $fe3[subsubcategory]";
}
else
     $showsubcategory = "";

     $db->freeresult ( $res3 );

if ($zzz==1) $dev_out.=  "&raquo; <a href=$def_mainlocation/index.php?$caturl>$showcategory2 $showcategory $showsubcategory</a>";
else $dev_out.=  "&raquo; <a href=$def_mainlocation/index.php?$caturl>$showcategory2 $showcategory $showsubcategory</a><br>";

}

?>

                  <td><b><? echo $dev_out; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">Просмотров за все время:</td>
                  <td><b><? echo $f['counter']; ?></b></td>
                </tr>
                 <tr>
                  <td width="280" align="right">Просмотров за месяц:</td>
                  <td><b><? echo $f['hits_m']; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">Просмотров за сегодня:</td>
                  <td><b><? echo $f['hits_d']; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">Посетителей сайта:</td>
                  <td><b><? echo "$f[webcounter]"; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">Полученные сообщения:</td>
                  <td><b><? echo "$f[mailcounter]"; ?></b></td>
                </tr>
		<tr>
                  <td width="280" align="right">Филиалов:</td>
                  <td><b><? echo "$f[filial]"; ?></b></td>
                </tr>
<?php
if (( $f["info"] > 0 ) and ($def_allow_info == "YES"))

		{
?>
                <tr>
                  <td width="280" align="right"><?php echo "$def_info_dop"; ?>:</td>
                  <td><b><? echo "$f[info]"; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right"><?php echo "$def_info_news"; ?>:</td>
                  <td><b><? echo "$f[news]"; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right"><?php echo "$def_info_tender"; ?>:</td>
                  <td><b><? echo "$f[tender]"; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right"><?php echo "$def_info_board"; ?>:</td>
                  <td><b><? echo "$f[board]"; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right"><?php echo "$def_info_job"; ?>:</td>
                  <td><b><? echo "$f[job]"; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right"><?php echo "$def_info_pressrel"; ?>:</td>
                  <td><b><? echo "$f[pressrel]"; ?></b></td>
                </tr>

<?php
}
if (( $f["prices"] > 0 ) and ($def_allow_products == "YES"))

		{

			$r = mysql_query ( "SELECT * FROM $db_offers WHERE firmselector='$f[selector]'" );
			@$results_amount_offers = mysql_num_rows ( $r );
?>
                <tr>
                  <td width="280" align="right">Загружено продукции и услуг:</td>
                  <td><b><? echo "$results_amount_offers"; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">Просмотров продукции и услуг:</td>
                  <td><b><? echo "$f[price_show]"; ?></b></td>
                </tr>
<?php

		}
?>

<?php
if (( $f["images"] > 0 ) and ($def_allow_images == "YES"))

		{

			$rc = mysql_query ( "SELECT * FROM $db_images WHERE firmselector='$f[selector]'" );
			@$results_amount_images = mysql_num_rows ( $rc );
?>
		<tr>
                  <td width="280" align="right">Загружено изображений в галерею:</td>
                  <td><b><? echo "$results_amount_images"; ?></b></td>
                </tr>
<?php
		}
?>

<?php
if (( $f["exel"] > 0 ) and ($def_allow_exel == "YES"))

		{

			$rce = mysql_query ( "SELECT * FROM $db_exelp WHERE firmselector='$f[selector]'" );
			@$results_amount_exel = mysql_num_rows ( $rce );
?>
		<tr>
                  <td width="280" align="right">Загружено Excel прайсов:</td>
                  <td><b><? echo "$results_amount_exel"; ?></b></td>
                </tr>
<?php
		}
?>

<?php
if (( $f["video"] > 0 ) and ($def_allow_video == "YES"))

		{

			$rcv = mysql_query ( "SELECT * FROM $db_video WHERE firmselector='$f[selector]'" );
			@$results_amount_video = mysql_num_rows ( $rcv );
?>
		<tr>
                  <td width="280" align="right">Видеороликов:</td>
                  <td><b><? echo "$results_amount_video"; ?></b></td>
                </tr>
<?php
		}
?>


<?php
if ($def_banner_allowed == "YES") {

	if ( (($f[flag] == "D") and ($def_D_banner == "YES")) or (($f[flag] == "C") and ($def_C_banner == "YES")) or (($f[flag] == "B") and ($def_B_banner == "YES")) or (($f[flag] == "A") and ($def_A_banner == "YES")) )

	{

		@ $bannerctr=$f["banner_click"]*100/$f["banner_show"];
		@ $bannerctr=round($bannerctr,2);
?>

                <tr>
                  <td width="280" align="right">Показы баннеров:</td>
                  <td><b><? echo "$f[banner_show]"; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">Кликов по баннеру:</td>
                  <td><b><? echo "$f[banner_click]"; ?></b></td>
                </tr>
                <tr>
                  <td width="280" align="right">CTR (%) баннера:</td>
                  <td><b><? echo "$bannerctr%"; ?></b></td>
                </tr>

<?php
	}
}

if ($def_reviews_enable == "YES")

{
		$rev=$db->query ("SELECT * from $db_reviews where company = '$f[selector]'") or die (mysql_error());
		$reviews=mysql_num_rows($rev);

?>
                <tr>
                  <td width="280" align="right">Комментарии:</td>
                  <td><b><? echo $reviews; ?></b> [Положительных <? echo $f['rev_good']; ?> Отрицательных <? echo $f['rev_bad']; ?>]</td>
                </tr>
<?php
}

if ($def_rating_allowed == "YES") {

	unset($rating_listing);

	if (($def_rating_allowed == "YES") and ($f[countrating] > 0) and ($f[votes] > 0)) {
		$rating_listing="";
		for ($rate=0;$rate<$f[countrating];$rate++) {
			$rating_listing.="<img src=\"$def_mainlocation/template/$def_template/images/star.gif\" border=0 alt=\"\">";
		}

		$rating_listing.=" ($f[votes] $def_votes)";
?>

                <tr>
                  <td width="280" align="right">Оценка посетителей:</td>
                  <td><? echo "$rating_listing"; ?></td>
                </tr>

<?php
	}
}
?> 
                <tr>
                  <td width="280" align="right"></td>
                  <td><br />
<FORM ACTION="stat_csv.php" METHOD="POST">
<input type="hidden" name="cid" value="<? echo "$f[selector]"; ?>">
<input type="hidden" name="file_csv" value="<? echo "Статистика_от_$date.csv"; ?>">
<input type="submit" name="buttoncsv" id="button" value="Cформировать файл статистики (CSV формат)" class="btn btn-success">
</FORM>
		  </td>
                </tr>
            </table>

<?

    if (ifEnabled_user($f[flag], "stat")) echo ''; else echo '<div class="alert alert-error">Ваш <b>тарифный план</b> не позволяет вести расширенную статистику на данный момент.</div>';

     $stat = $db->query ( "SELECT * FROM $db_stat WHERE firmselector='$f[selector]'");
     $r_stat = $db->fetcharray ( $stat );

     for ( $i=1;$i<13;$i++ ) {

         if ($i<10) $m="m0$i"; else $m="m$i";
	 $bar_y=$r_stat[$m]+1;
         if ($r_stat[$m]>0) $r_stat_view[]="[$i, $bar_y]";
         $r_stat_max[]=$r_stat[$m];

     }

     if (count($r_stat_view)>0) {
        $r_stat_view =  implode(",",  $r_stat_view);
        arsort($r_stat_max);
        $max = current($r_stat_max);
        if ($max<1000 and $max>100) $max=$max+200;
        if ($max<100) $max=$max+20;
     } else echo '<br><div class="alert alert-error">Ваша компания пока не имеет посещений аккаунта за указанный период.</div>';
     

?>

 <br><br><span class="btn btn-large disabled">Статистика просмотров за <? echo $r_stat['year']; ?> год</span><br>

<script type="text/javascript" src="../includes/js/jqPlot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="../includes/js/jqPlot/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="../includes/js/jqPlot/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="../includes/js/jqPlot/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="../includes/js/jqPlot/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="../includes/js/jqPlot/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="../includes/js/jqPlot/jqplot.donutRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/js/jqPlot/jquery.jqplot.css" />
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../includes/js/jqPlot/excanvas.min.js"></script><![endif]-->

<script type="text/javascript">

   $(document).ready(function () {
        var s1 = [<? echo $r_stat_view; ?>];
        var s2 = [<? echo $r_stat_view; ?>];

    plot1 = $.jqplot("chart1", [s2, s1], {        
        animate: true,
        animateReplot: true,
        cursor: {
            show: true,
            zoom: true,
            looseZoom: true,
            showTooltip: false
        },
        series:[
            {
                pointLabels: {
                    show: true
                },
                renderer: $.jqplot.BarRenderer,
                showHighlight: false,
                yaxis: 'y2axis',
                rendererOptions: {
                    animation: {
                        speed: 2500
                    },
                    barWidth: 30,
                    barPadding: -15,
                    barMargin: 0,
                    highlightMouseOver: false
                }
            },
            {
                rendererOptions: {
                    animation: {
                        speed: 2000
                    }
                }
            }
        ],
        axesDefaults: {
            pad: 0
        },
        axes: {
            xaxis: {
                tickInterval: 1,
                drawMajorGridlines: false,
                drawMinorGridlines: true,
                drawMajorTickMarks: false,
                min: 1,
                max: 12,
                rendererOptions: {
                tickInset: 0.5,
                minorTicks: 1
            }
            },
            yaxis: {
                min: 0,
                max: <? echo $max; ?>,
                tickOptions: {
                    formatString: " %'d"
                },
                rendererOptions: {
                    forceTickAt0: true
                }
            },
            y2axis: {
                min: 0,
                max: <? echo $max; ?>,
                tickOptions: {
                    formatString: " %'d"
                },
                rendererOptions: {
                    alignTicks: true,
                    forceTickAt0: true
                }
            }
        },
        highlighter: {
            show: true,
            showLabel: true,
            tooltipAxes: 'y',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
        }
    });

});


</script>

 <div id="chart1" style="width:700px; height:300px"></div>

 <br><span class="btn btn-large disabled">Переходы с поисковых систем</span><br>

 <?

     $stat_engine = $db->query ( "SELECT * FROM $db_engines WHERE firmselector='$f[selector]'");
     $r_stat_engine = $db->fetcharray ( $stat_engine );
     $r_view_engine = "['Yandex', $r_stat_engine[yandex]], ['Google', $r_stat_engine[google]], ['Mail.ru', $r_stat_engine[mail]], ['Bing', $r_stat_engine[bing]], ['Yahoo', $r_stat_engine[yahoo]], ['Rambler', $r_stat_engine[rambler]], ['Aport', $r_stat_engine[aport]]";
     $r_view_social = "['Twitter', $r_stat_engine[twitter]], ['Facebook', $r_stat_engine[facebook]], ['Одноклассники', $r_stat_engine[odnoklassniki]], ['ВКонтакте', $r_stat_engine[vk]], ['Мой Мир', $r_stat_engine[mymail]]";

 ?>

 <script type="text/javascript">
 $(document).ready(function(){
  var data = [
    <? echo $r_view_engine; ?>
  ];
  var plot1 = jQuery.jqplot ('chart2', [data],
    {
      seriesDefaults: {
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          showDataLabels: true
        }
      },
      legend: { show:true, location: 'e' }
    }
  );
});
</script>

 <div id="chart2" style="height:300px; width:500px;"></div>
 
 <span class="btn btn-large disabled">Переходы с социальных сетей</span><br>

<script type="text/javascript">
 $(document).ready(function(){
  var data = [
    <? echo $r_view_social; ?>
  ];
  var plot1 = jQuery.jqplot ('chart3', [data],
    {
      seriesDefaults: {
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          showDataLabels: true
        }
      },
      legend: { show:true, location: 'e' }
    }
  );
});
</script>

 <div id="chart3" style="height:300px; width:500px;"></div>

			</td>
                        </tr>
                  </table></td>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                </tr>
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_left_r.gif" width="3" height="1"></td>
                  <td background="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif" width="3" height="1"></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_right_r.gif" width="3" height="1"></td>
                </tr>
              </table>
            </div>
            </div>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
          <div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
          <div class="CollapsiblePanelContent">
            <? echo "$help_stat"; ?>
          </div>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
//-->
</script>
<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.MAdi
=====================================================
 Файл: ratingtop.php
-----------------------------------------------------
 Назначение: Рейтинг фирм и организаций. ТОП20
=====================================================
*/

include ( "./defaults.php" );

$def_show_number_box1=20; // Сколько фирм участвует в рейтинге

$help_section = $ratingtop_help;

$incomingline = '<a href="index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | '.$def_title_rating;
$incomingline_firm=$def_title_rating;

include ( "./template/$def_template/header.php" );

$main_table_top = main_table_top ($def_title_rating); // Вверх заголовка


if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$top_q=$db->query("SELECT firmname, flag, category, selector, theme, domen, hits_m, hits_d, counter, rating, votes FROM $db_users where firmstate='on' $hide_d ORDER by  hits_m DESC, countrating DESC LIMIT $def_show_number_box1");
	
$top_r=$db->numrows($top_q);

$rate_firm='';

for ($top_f=0; $top_f<$top_r; $top_f++) {

 	$top_res=$db->fetcharray($top_q);
 	$category_list = explode(":", $top_res[category]);
 	$category_list = explode("#", $category_list[0]);

 	$mesto=$top_f+1;

        if (($top_res['theme']!='') and ($top_res['domen']!='') and (ifEnabled($top_res[flag], "social"))) $link_rate = $def_mainlocation ."/".$top_res['domen'];
        else $link_rate="$def_mainlocation/view.php?id=$top_res[selector]&amp;cat=$category_list[0]&amp;subcat=$category_list[1]&amp;subsubcat=$category_list[2]";

if ($top_f<=4) {

$rate_firm .= "
  <tr>
    <td height=22 align=center><b>$mesto</b></td>
    <td><a href=\"$link_rate\"><b><u>$top_res[firmname]</u></b></a></td>
    <td align=center><b>$top_res[hits_m]</b></td>";

$ratingv=show_rating ($top_res[rating], $top_res[votes]);

$rate_firm .= "
    <td align=center>$ratingv</td>
  </tr>
  <tr>
    <td colspan=4 height=1 bgcolor=#79797A></td>
  </tr>
";

} else {

$rate_firm .= "
  <tr>
    <td height=22 align=center>$mesto</td>
    <td><a href=\"$link_rate\"><u>$top_res[firmname]</u></a></td>
    <td align=center>$top_res[hits_m]</td>";

$ratingv=show_rating ($top_res[rating], $top_res[votes]);

$rate_firm .= "
    <td align=center>$ratingv</td>
  </tr>
  <tr>
    <td colspan=4 height=1 bgcolor=#79797A></td>
  </tr>
";
}
    if ($top_f<10) {

        $s1[]=$top_res['hits_d'];
        $s2[]=$top_res['hits_m'];
        $s3[]=$top_res['counter'];
        $namefirm[]=isb_sub(chek_meta(strip_tags($top_res['firmname'])),15);
    }
}

@$s1='['.implode(", ", $s1).']';
@$s2='['.implode(", ", $s2).']';
@$s3='['.implode(", ", $s3).']';
@$namefirm="['".implode("', '", $namefirm)."']";

// График рейтинга

$graph_rating="

<script type=\"text/javascript\" src=\"includes/js/jqPlot/jquery.jqplot.min.js\"></script>
<script type=\"text/javascript\" src=\"includes/js/jqPlot/jqplot.barRenderer.min.js\"></script>
<script type=\"text/javascript\" src=\"includes/js/jqPlot/jqplot.categoryAxisRenderer.min.js\"></script>
<script type=\"text/javascript\" src=\"includes/js/jqPlot/jqplot.canvasAxisTickRenderer.min.js\"></script>
<script type=\"text/javascript\" src=\"includes/js/jqPlot/jqplot.canvasTextRenderer.min.js\"></script>
<script type=\"text/javascript\" src=\"includes/js/jqPlot/jqplot.pointLabels.min.js\"></script>
<link rel=\"stylesheet\" type=\"text/css\" href=\"includes/js/jqPlot/jquery.jqplot.css\" />
<!--[if lt IE 9]><script language=\"javascript\" type=\"text/javascript\" src=\"includes/js/jqPlot/excanvas.min.js\"></script><![endif]-->

<script type=\"text/javascript\">
$(document).ready(function(){
    var s1 = $s1;
    var s2 = $s2;
    var ticks = $namefirm;
    var plot1 = $.jqplot('chart1', [s1, s2], {
       animate: true,
        animateReplot: true,
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true}
        },
axesDefaults: {
        tickRenderer: $.jqplot.CanvasAxisTickRenderer 
    },
        series:[
            {label:'$def_hits_day'},
            {label:'$def_hits_month'}
        ],
        legend: {
            show: true,
            location: 'ne'
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks,
        tickOptions: {
          angle: -90,
          fontSize: '12px'
        }
            },
            yaxis: {
                min: 0,
                pad: 1.05,
                tickOptions: {formatString: '%d'}
            }
        }
    });
});
</script>

<div id=\"chart1\" style=\"width:95%; height:300px\"></div>

";

$template = new Template;

$template->set_file('rating.tpl');

$template->replace("position", $def_num_rating);
$template->replace("firmname", $def_firm_rating);
$template->replace("hits", $def_hits_rating);
$template->replace("rate", $def_rate_rating);
$template->replace("view_rating", $rate_firm);

$template->replace("main_table_top", $main_table_top);
$template->replace("main_table_bottom", $main_table_bottom);

$template->replace("graph_rating", $graph_rating);

$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

$template->publish();

$main_table_bottom = main_table_bottom(); // Низ заголовка

include ( "./template/$def_template/footer.php" );

?>
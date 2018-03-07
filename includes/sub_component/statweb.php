<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: catweb.php
-----------------------------------------------------
 Назначение: Рейтинг сайтов и статистика
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$tmp = file_get_contents('system/webstat.dat');
$stat_web=  explode(":", $tmp);

        $template_web=set_tFile('webstat.tpl');

        $template = new Template;

        $template->load($template_web);

        $template->replace("site",$stat_web[1]);
        $template->replace("hit", $stat_web[0]);

        $template->replace("data", date("d.m.Y"));

        $template->replace("pravila", $def_rating_pravila);

@$s1='['.implode(", ", $s1).']';
@$namefirm="['".implode("', '", $namefirm)."']";

// График рейтинга

$graph_rating="

<script type=\"text/javascript\" src=\"$def_mainlocation/includes/js/jqPlot/jquery.jqplot.min.js\"></script>
<script type=\"text/javascript\" src=\"$def_mainlocation/includes/js/jqPlot/jqplot.barRenderer.min.js\"></script>
<script type=\"text/javascript\" src=\"$def_mainlocation/includes/js/jqPlot/jqplot.categoryAxisRenderer.min.js\"></script>
<script type=\"text/javascript\" src=\"$def_mainlocation/includes/js/jqPlot/jqplot.canvasAxisTickRenderer.min.js\"></script>
<script type=\"text/javascript\" src=\"$def_mainlocation/includes/js/jqPlot/jqplot.canvasTextRenderer.min.js\"></script>
<script type=\"text/javascript\" src=\"$def_mainlocation/ncludes/js/jqPlot/jqplot.pointLabels.min.js\"></script>
<link rel=\"stylesheet\" type=\"text/css\" href=\"$def_mainlocation/includes/js/jqPlot/jquery.jqplot.css\" />
<!--[if lt IE 9]><script language=\"javascript\" type=\"text/javascript\" src=\"$def_mainlocation/includes/js/jqPlot/excanvas.min.js\"></script><![endif]-->

<script type=\"text/javascript\">
$(document).ready(function(){
    var s1 = $s1;
    var ticks = $namefirm;
    var plot1 = $.jqplot('chart1', [s1], {
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
            {label:'$def_hits_site'}
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

";

        $template->replace("graph_rating", $graph_rating);
        $template->replace("dir_to_main", $def_mainlocation);
        $template->replace("color", $color);
        $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template->publish();
		
?>

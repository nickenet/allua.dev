<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: tiny.php
-----------------------------------------------------
 Назначение: Подключение редактора TinyMCE
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        theme : "advanced",
	skin : "cirkuit",
	mode : "exact",
        elements : "business",
	language : "ru",
	width : "400",
	height : "500",
	plugins : "layer,table,style,advhr,spellchecker,advimage,emotions,inlinepopups,insertdatetime,media,searchreplace,print,contextmenu,paste,fullscreen,nonbreaking,typograf",

	relative_urls : false,
	convert_urls : false,
	remove_script_host : false,
	media_strict : false,
	dialog_type : 'window',
	extended_valid_elements : "noindex,div[align|class|style|id|title]",
	custom_elements : 'noindex',
	paste_auto_cleanup_on_paste : false,
	paste_text_use_dialog: true,

	// Theme options
	theme_advanced_buttons1 : "formatselect,fontselect,fontsizeselect,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,forecolor,backcolor,|,removeformat,cleanup",
	theme_advanced_buttons2 : "print,|,tablecontrols,|,hr,visualaid,|,styleprops,typograf,|,sub,sup,|,charmap,advhr,|,insertdate,inserttime,|,insertlayer,absolute",
	theme_advanced_buttons3 : "fullscreen,|,cut,copy,|,paste,pastetext,pasteword,|,search,|,outdent,indent,|,undo,redo,|,link,image,media,|,code",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	plugin_insertdate_dateFormat : "%d-%m-%Y",
	plugin_insertdate_timeFormat : "%H:%M:%S",
	spellchecker_languages : "+Russian=ru,Ukrainian=uk,English=en",


	// Example content CSS (should be your site CSS)
	content_css : "<? echo $def_mainlocation; ?>/includes/editor/css/content.css"

});
</script>
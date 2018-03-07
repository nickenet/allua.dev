<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: search-3.php
-----------------------------------------------------
 Назначение: Расширенный поиск
=====================================================
*/

include ( "./defaults.php" );

require_once 'includes/zsearch.php';

$requests = new zSearch;

$incomingline = $def_search_adv;

if ( $_GET["categoryset"] <> "" ) $category1 = safeHTML(rawurldecode($_GET['categoryset']));
else $category1 = safeHTML($_POST['category']);

if ( $_GET["firmname"] <> "" ) $firmname1 = safehtml(rawurldecode($_GET['firmname']));
else $firmname1 = safehtml($_POST['firmname']);

if ( $_GET["business"] <> "" ) $business = safehtml(rawurldecode($_GET['business']));
else $business = safehtml($_POST['business']);

if ( $_GET["location"] <> "" ) $location1 = safehtml(rawurldecode($_GET["location"]));
else $location1 = safehtml($_POST['location']);

if ( $_GET["state"] <> "" ) $state1 = safehtml(rawurldecode($_GET['state']));
else $state1 = safehtml($_POST['state']);

if ( $_GET["city"] <> "" ) $city1 = safehtml(rawurldecode($_GET['city']));
else $city1 = safehtml($_POST['city']);
    
if ( $_GET["address"] <> "" ) $address = safehtml(rawurldecode( $_GET['address']));
else $address = safehtml($_POST['address']);

if ( $_GET["zip"] <> "" ) $zip = safehtml(rawurldecode($_GET['zip']));
else 	$zip = safehtml($_POST['zip']);

if ( $_GET["phone"] <> "" ) $phone = safehtml(rawurldecode($_GET['phone']));
else $phone = safehtml($_POST['phone']);

if ( $_GET["fax"] <> "" ) $fax = safehtml(rawurldecode($_GET['fax']));
else $fax = safehtml($_POST['fax']);

if ( $_GET["mobile"] <> "" ) $mobile = safehtml(rawurldecode ($_GET['mobile']));
else $mobile = safehtml($_POST['mobile']);

if ( $_GET["icq"] <> "" ) $icq = safehtml(rawurldecode ($_GET['icq']));
else $icq = safehtml($_POST['icq']);

if ( $_GET["mail"] <> "" ) $mail = safehtml(rawurldecode($_GET['mail']));
else $mail = safehtml($_POST['mail']);

if ( $_GET["www"] <> "" ) $www = safehtml(rawurldecode($_GET['www']));
else $www = safehtml(rawurldecode($_POST['www']));

if ( $_GET["manager"] <> "" ) $manager = safehtml(rawurldecode($_GET['manager']));
else $manager = safehtml(rawurldecode($_POST['manager']));

if ( $_GET["mail"] <> "" ) $www = safehtml(rawurldecode($_GET['manager']));
else $www = safehtml(rawurldecode($_POST['mail']));

if ($def_reserved_1_enabled == "YES") {
    if ( $_GET["reserved_1"] <> "" ) $reserved_1 = safehtml(rawurldecode($_GET['reserved_1']));
    else $reserved_1 = safehtml($_POST['reserved_1']);
}

if ($def_reserved_2_enabled == "YES") {
    if ( $_GET["reserved_2"] <> "" ) $reserved_2 = safehtml(rawurldecode($_GET['reserved_2']));
    else $reserved_2 = safehtml($_POST['reserved_2']);
}

if ($def_reserved_3_enabled == "YES") {
    if ( $_GET["reserved_3"] <> "" ) $reserved_3 = safehtml(rawurldecode($_GET['reserved_3']));
    else $reserved_3 = safehtml($_POST['reserved_3']);
}

$def_count=intval($_REQUEST['def_find_page']);

if ($def_count!=0) $def_count_srch = $def_count;

$KsPage=intval($_GET['spage']);

$npage = $KsPage + 1;
$ppage = $KsPage - 1;
$page1 = $KsPage * $def_count_srch;

$query .= " FROM $db_users WHERE ";

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$query .= " firmstate='on' $hide_d ";

if (($category1 != "ANY") and ($category1!=''))  $query .= " AND ((category LIKE '$category1#%') or (category LIKE '%:$category1#%')) ";

if ( $firmname1 != "" ) $query .= " AND firmname LIKE '%$firmname1%' ";

if ( $business != "" ) $query .= " AND business LIKE '%$business%' ";

if ( $business != "" ) $query .= " AND keywords LIKE '%$business%' ";

if (($location1 != "ANY") and ($location1 != '')) $query .= " AND location = '$location1' ";

if ( $def_states_allow == "YES" ) {

	if (($state1 != "ANY") and ($state1 !='')) $query .= " AND state = '$state1' ";
}

if ( $def_country_allow == "YES" ) {

	if ( $city1 != "" ) $query .= " AND city LIKE '%$city1%' ";
        
}

if ( $address != "" ) $query .= " AND address LIKE '%$address%' ";

if ( $zip != "" ) $query .= " AND zip LIKE '%$zip%' ";

if ( $phone != "" ) $query .= " AND phone LIKE '%$phone%' ";

    // обрабатываем телефон

$fastquotes = array (' ', '(', ')', '-', '\\', '"', "{", "}", "[", "]", "<", ">","+");
$phone=str_replace( $fastquotes, '', $phone );
            $phone=str_replace( ';', ',', $phone );
            $phone_m=explode(",", $phone);
            $phone=$phone_m[0];
            
if ( $phone != "" ) $query .= " AND phone LIKE '%$phone%' ";

if ( $fax != "" ) $query .= " AND fax LIKE '%$fax%' ";

if ( $mobile != "" ) $query .= " AND mobile LIKE '%$mobile%' ";

$mobile=str_replace( $fastquotes, '', $mobile );
            $mobile=str_replace( ';', ',', $mobile );
            $mobile_m=explode(",", $mobile);
            $mobile=$mobile_m[0];
            
if ( $mobile != "" ) $query .= " AND mobile LIKE '%$mobile%' ";            

if ( $icq != "" ) $query .= " AND icq LIKE '%$icq%' ";

if ( $mail != "" ) $query .= " AND mail LIKE '%$mail%' ";

if ( $www != "" ) $query .= " AND www LIKE '%$www%' ";

if ( $manager != "" ) $query .= " AND manager LIKE '%$manager%' ";

if ( $reserved_1 != "" ) $query .= " AND reserved_1 LIKE '%$reserved_1%' ";

if ( $reserved_2 != "" ) $query .= " AND reserved_2 LIKE '%$reserved_2%' ";

if ( $reserved_3 != "" ) $query .= " AND reserved_3 LIKE '%$reserved_3%' ";

$query .= " ORDER BY flag, firmname";

$ra = $db->query  ( "SELECT COUNT(*) $query" );
$results_amount_search = mysql_result ( $ra, 0, 0 );
@$db->freeresult  ( $ra );

if ( $results_amount_search > 0 ) {

$r = $db->query  ( "SELECT * $query LIMIT $page1, $def_count_srch");
$results_amount2 = $db->numrows ( $r );

$rmaps = $db->query  ( "SELECT flag, firmname, map, selector $query LIMIT $page1, $def_count_srch");
$results_maps = $db->numrows ( $rmaps);

require 'includes/components/maps_find.php'; // выборка данных для карты

$help_section = $adv_search2_help;

$sdate1 = date("H:i:s");
$sdate2 = date("Y-m-d");
$sdate3 = undate($sdate2, $def_datetype);

// формируем титле запроса

if (($def_country_allow != "YES") and  ($location1!='') and ($location1!='ANY')) {
        $locationselect=intval($location1);
        $rt = $db->query  ( "SELECT locationselector, location FROM $db_location WHERE locationselector='$locationselect' LIMIT 1" );
        $ft = $db->fetcharray  ( $rt );
        $title_city = $ft['location'];
        $db->freeresult  ( $rt );
} else $title_city = $city1;
    
if (($state1!='') and ($state1!='ANY')) {
       	$stateselector = intval($state1); 
        $rt = $db->query  ( "SELECT stateselector, state FROM $db_states WHERE stateselector='$state1' LIMIT 1" );
	$ft = $db->fetcharray  ( $rt );
        $title_state = $ft['state'];
        $db->freeresult  ( $rt );
} else $title_state = '';
    
if (($category1!='') and ($category1!='ANY')) { 
    $selector = intval($category1);
    $rt = $db->query  ( "SELECT selector, category FROM $db_category WHERE selector='$selector' LIMIT 1" );
    $ft = $db->fetcharray  ( $rt );
    $title_category = $ft['category'];
    $db->freeresult  ( $rt );
} else $title_category='';

if ($business!="") $incomingline_firm=$business;
if ($firmname1!="") $incomingline_firm=$firmname1;
    
if ($title_city!='') $incomingline_firm .= $title_city.'. ';
if ($title_state!='') $incomingline_firm .= $def_state.' '.$title_state.'. ';
if ($title_category!='') $incomingline_firm .= $title_category;

include ( "./template/$def_template/header.php" );

include ( "./template/$def_template/search_top.php" ); // Подключаем верхний шаблон поиска

if ($def_count_srch > $results_amount2) $fetchcounter = $results_amount2;
else $fetchcounter = $def_count_srch;

if (($page1==0) and (!isset($_GET['spage']))) $requests->add($firmname1, $results_amount_search);

include ("./includes/sub.php");

$category2 = rawurlencode ( $category1 );
if ($category2!='') $link_to_find .="categoryset=$category2";

$firmname2 = rawurlencode ( $firmname1 );
if ($firmname2!='') $link_to_find .="&firmname=$firmname2";

$business2 = rawurlencode ( $business );
if ($business2!='') $link_to_find .="&business=$business2";

$location2 = rawurlencode ( $location1 );
if (($location2!='') and ($location2!='ANY')) $link_to_find .="&location=$location2";

$state2 = rawurlencode ( $state1 );
if (($state2!='') and ($state2!='ANY')) $link_to_find .="&state=$state2";

$city2 = rawurlencode ( $city1 );
if ($city2!='') $link_to_find .="&city=$city2";

$address2 = rawurlencode ( $address );
if ($address2!='') $link_to_find .="&address=$address2";

$zip2 = rawurlencode ( $zip );
if ($zip2!='') $link_to_find .="&zip=$zip2";

$phone2 = rawurlencode ( $phone );
if ($phone2!='') $link_to_find .="&phone=$phone2";

$fax2 = rawurlencode ( $fax );
if ($fax2!='') $link_to_find .="&fax=$fax2";

$mobile2 = rawurlencode ( $mobile );
if ($mobile2!='') $link_to_find .="&mobile=$mobile2";

$icq2 = rawurlencode ( $icq );
if ($icq2!='') $link_to_find .="&icq=$icq2";

$manager2 = rawurlencode ( $manager );
if ($manager2!='') $link_to_find .="&manager=$manager2";

$mail2 = rawurlencode ( $mail );
if ($mail2!='') $link_to_find .="&mail=$mail2";

$www2 = rawurlencode ( $www );
if ($mail2!='') $link_to_find .="&www=$www2";

$reserved_1_2 = rawurlencode ( $reserved_1 );
$reserved_2_2 = rawurlencode ( $reserved_2 );
$reserved_3_2 = rawurlencode ( $reserved_3 );
if ($reserved_1_2!='') $link_to_find .="&reserved_1=$reserved_1_2";
if ($reserved_2_2!='') $link_to_find .="&reserved_2=$reserved_2_2";
if ($reserved_3_2!='') $link_to_find .="&reserved_3=$reserved_3_2";

$link_to_find1='';
if ($KsPage!=0) $link_to_find1 .="&spage=$KsPage";
if ($def_count!=0) $link_to_find .="&def_find_page=$def_count";

if ( $results_amount_search > $def_count_srch )

{
    $prev_page=''; $page_news=''; $next_page='';
    
	if ((($KsPage*$def_count_srch)-($def_count_srch*5)) >= 0) $first=($KsPage*$def_count_srch)-($def_count_srch*5);
	else $first=0;

	if ((($KsPage*$def_count_srch)+($def_count_srch*6)) <= $results_amount_search) $last =($KsPage*$def_count_srch)+($def_count_srch*6);
	else $last = $results_amount_search;

	@$z=$first/$def_count_srch;

            if ($KsPage > 0) {
    
                $z_prev=$KsPage-1;
                if ($z_prev==0) $prev_page = '<a href="'.$def_mainlocation.'/search-3.php?'.$link_to_find.'"><b>'.$def_previous.'</b></a>&nbsp;';
                else $prev_page = '<a href="'.$def_mainlocation.'/search-3.php?'.$link_to_find.'&spage='.($KsPage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';         
                
            }
	
	for ( $x=$first; $x < $last; $x=$x+$def_count_srch )
	{
		if ( $z == $KsPage )

		{
			$page_news.= '[ <b>'. ($z+1) .'</b> ]&nbsp;';
			$z++;
		}

		else

		{
                    if ($z==0) $page_news.= '<a href="'.$def_mainlocation.'/search-3.php?'.$link_to_find.'"><b>'.($z+1).'</b></a>&nbsp;';
                    else $page_news.= '<a href="'.$def_mainlocation.'/search-3.php?'.$link_to_find.'&spage='. $z.'"><b>'.($z+1).'</b></a>&nbsp;';
                    $z++;                    
                }
			
        }

	if ($KsPage - (($results_amount_search / $def_count_srch) - 1) < 0)
        $next_page = '<a href="'.$def_mainlocation.'/search-3.php?'.$link_to_find.'&spage='.($KsPage+1).'"><b>'.$def_next.'</b></a>&nbsp;';

        include ( "./template/$def_template/pages.php" ); // подключаем обработку страниц        
        
        $template_page_news = set_tFile('pages.tpl');

        $template_pages = new Template;

        $template_pages->load($template_page_news);

        $template_pages->replace("prev", $prev_page);
        $template_pages->replace("next", $next_page);
        $template_pages->replace("page", $page_news);

        $template_pages->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_pages->publish();
}

include ( "./template/$def_template/search_bottom.php" ); // Подключаем нижний шаблон поиска	

} else {
    
$meta_index='<meta name="robots" content="noindex,nofollow" />'."\n";    
    
include ( "./template/$def_template/header.php" );

    $def_title_error = $def_warning_msg;
    $def_message_error = "$def_nothing_found<br><br><a href=\"javascript:history.back()\">$def_back</a>";

    include ( "./includes/error_page.php" );    
}

include ( "./template/$def_template/footer.php" );

?>
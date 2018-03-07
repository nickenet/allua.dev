<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: sub.php
-----------------------------------------------------
 Назначение: Вывод списка компаний
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if (!isset($fetchcounter) ) $fetchcounter = 1;

$fastquotes = array (' ', '(', ')', '-', '\\', '"', "{", "}", "[", "]", "<", ">");

$operator_mob =  explode("#", $def_operator_mobile);
$map_filter_ok=0;
$mobile_filter_ok=0;
$category_city = array();

for ( $jjj=0; $jjj<$fetchcounter; $jjj++ )

{
	$f_filter = $db->fetcharray ( $r_filter );
        if ($f_filter['map']!='') $map_filter_ok=1;
        if ($f_filter['mobile']!='') $mobile_filter_ok=1;
        if ($f_filter['category']!='') {
            $expl_cat_city = explode('#', $f_filter['category']);
            $expl_cat_city = explode(':', $expl_cat_city[0]);
            $category_city [] = $expl_cat_city[0];
        }
        $mobile='';
        if ($f_filter['mobile']!='') {
            $mobile=str_replace( $fastquotes, '', $f_filter['mobile'] );
            $mobile=str_replace( ';', ',', $mobile );
            $mobile=explode(",", $mobile);
            $mobile=$mobile[0];
            $mobile_find=str_replace( '+', '', $mobile );
            $mobile_find = substr($mobile_find, 0, 5);

            unset($value);

            foreach ($operator_mob as $value) {

                $pos=strpos($mobile_find, $value);

                if ($pos !== false) $operator_filter_array []= "$value";
            }
        }
}

if (count($operator_filter_array)>0) {

    $operator_mob = array_count_values( $operator_filter_array );
    arsort( $operator_mob );
    $operator_mob = array_keys( $operator_mob );
    $operator_mob = array_slice( $operator_mob, 0, $def_count_dir );

}

include ("./template/$def_template/sub_begin.php");

$template_sub_a = implode ('', file('./template/' . $def_template . '/sub_a.tpl'));
$template_sub_b = implode ('', file('./template/' . $def_template . '/sub_b.tpl'));
$template_sub_c = implode ('', file('./template/' . $def_template . '/sub_c.tpl'));
$template_sub_d = implode ('', file('./template/' . $def_template . '/sub_d.tpl'));

for ( $iii=0; $iii<$fetchcounter; $iii++ )

{
	$f = $db->fetcharray ( $r );
	$id = intval($f['selector']);

	if ($f[flag] == "A") $template_sub = $template_sub_a;
	if ($f[flag] == "B") $template_sub = $template_sub_b;
	if ($f[flag] == "C") $template_sub = $template_sub_c;
	if ($f[flag] == "D") $template_sub = $template_sub_d;

		$getcat = intval($_GET['cat']);
		$getcategory = intval($_GET['category']);
		$getsubcat = intval($_GET['subcat']);
		$getsubsubcat = intval($_GET['subsubcat']);

	if ( (empty($getcat)) and (empty($getcategory)) )

	{
		$maincatx = explode (":", $f['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getcategory = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
	}

        $filter='';

	if ( $iii%2 == 0 ) $color = $def_form_back_color; else $color = $def_background;

	$template = new Template;

	$template->load($template_sub);

	$template->replace("link", $def_mainlocation_pda ."/view.php?id=" . $id );

	$template->replace("flag", $f['flag']);
	$template->replace("company", $f['firmname']);
        $business=parseDescription("X", $f['business']);
        $fastquotesb = array ('<br><br>', '<br /><br />', '<br><br><br>', '<br /><br /><br />', '<br> <br>', '<br /> <br />');
        $business=str_replace( $fastquotesb, '<br />', $business);
	$template->replace("description", $business);

	$template->replace("color", $color);

	$template->replace("date", undate($f['date'], $def_datetype));

	$location_r = $db->query  ( "SELECT location FROM $db_location WHERE locationselector = '$f[location]'" );
	$location_f = $db->fetcharray   ( $location_r );

	if ( $def_country_allow == "YES" ) { $country = $location_f['location']; $city = $f['city']; }
	if ( $def_country_allow != "YES" ) { $city = $location_f['location']; $country = ""; }
	if ( $def_states_allow == "YES" ) {
            $state_r = $db->query  ( "SELECT state FROM $db_states WHERE stateselector = '$f[state]'" );
            $state_f = $db->fetcharray   ( $state_r );
            $state = $state_f['state'];
	} else $state = "";


	if ($country!='') $template->replace("country", "$country<br />"); else $template->replace("country", "");
	if ($state!='') $template->replace("state", "$state<br />"); else $template->replace("state", "");
	if ($city!='') $template->replace("city", "($city)"); else $template->replace("city", "");

        
        $phone='';
        if ($f['phone']!='') {
            $phone=str_replace( $fastquotes, '', $f['phone'] );
            $phone=str_replace( ';', ',', $phone );
            $phone=explode(",", $phone);
            $phone=$phone[0];
        }
        $mobile='';
        if ($f['mobile']!='') {
            $mobile=str_replace( $fastquotes, '', $f['mobile'] );
            $mobile=str_replace( ';', ',', $mobile );
            $mobile=explode(",", $mobile);
            $mobile=$mobile[0];
            $filter = 'mob';
            $mobile_find=str_replace( '+', '', $mobile );
            $mobile_find = substr($mobile_find, 0, 4);

            unset($value);

            foreach ($operator_mob as $value) {

                $pos=strpos($mobile_find, "$value");

                if ($pos !== false) { $filter .= " $value"; }
            }
        }

        if ($f['map']!='') { $filter .= ' map'; $adress="<a href=\"$def_mainlocation_pda/view.php?id=$id\" class=\"adress\">".$f['address']."</a>"; } else $adress=$f['address'];

	if ((ifEnabled($f[flag], "address")) and  ($f[address]!='')) $template->replace("address", "<span class=\"icon-tmf-c\"></span>$adress"); else $template->replace("address", "");
	if (ifEnabled($f[flag], "zip")) $template->replace("zip", $f['zip']); else $template->replace("zip", "");
	if ((ifEnabled($f[flag], "phone")) and  ($phone!='')) $template->replace("phone", "<span class=\"icon-tmf-t\"></span><a href=\"tel:$phone\" class=\"tphone\">$phone</a>"); else $template->replace("phone", "");
	if ((ifEnabled($f[flag], "fax")) and  ($f['fax']!='')) $template->replace("fax", $f['fax']); else $template->replace("fax", "");
	if ((ifEnabled($f[flag], "mobile")) and  ($f['mobile']!='')) $template->replace("mobile", "<span class=\"icon-tmf-m\"></span><a href=\"tel:$mobile\" class=\"tphone\">$mobile</a>"); else $template->replace("mobile", "");
	if (ifEnabled($f[flag], "manager")) $template->replace("contact", $f['manager']); else $template->replace("manager", "");

		$template->replace("reserved_1", $f[reserved_1]);
		$template->replace("reserved_2", $f[reserved_2]);
		$template->replace("reserved_3", $f[reserved_3]);

        if ($filter!='') $template->replace("filter", $filter); else $template->replace("filter", "");

	$template->publish();

}

include ("./template/$def_template/sub_end.php");

?>
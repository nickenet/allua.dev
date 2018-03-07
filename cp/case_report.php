<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: case_report.php
-----------------------------------------------------
 Назначение: Отчет по документам компании
=====================================================
*/

session_start();

require_once './defaults.php';

$form_selector=intval($_REQUEST['id']);

check_login_cp('3_10','case_report.php');

if ($form_selector!=0) {

    $r=$db->query ("SELECT $db_case.id, $db_case.firmselector, $db_case.bin, $db_case.info, $db_case.alpha, $db_case.codefirm, $db_case.notes, $db_case.banking, $db_case.contact, $db_users.firmname, $db_users.selector, $db_users.tmail, $db_users.mail, $db_users.tcase, $db_users.flag, $db_users.flag, $db_users.business, $db_users.map, $db_users.mapstype, $db_users.location, $db_users.state, $db_users.city, $db_users.address, $db_users.zip, $db_users.phone, $db_users.fax, $db_users.mobile, $db_users.icq, $db_users.manager, $db_users.mail, $db_users.www, $db_users.social, $db_users.date, $db_users.domen, $db_users.domen1  FROM $db_case INNER JOIN $db_users ON $db_case.firmselector = $db_users.selector WHERE $db_case.firmselector='$form_selector' LIMIT 1") or die ("mySQL error!");
    $results_case = mysql_num_rows ( $r );

 

    if ($results_case>0) {

    // Обрабатываем поля
    $f_case=$db->fetcharray ($r);
    $selector=$f_case['firmselector'];
    $firmname=$f_case['firmname'];
    $data_case=$f_case['date'];
    $bin=$f_case['bin'];
    $info=$f_case['info'];
    $alpha=$f_case['alpha'];
    $mail=$f_case['mail'];
    $notes=$f_case['notes'];
    $banking=$f_case['banking'];
    $contact=$f_case['contact'];
    $flag=$f_case['flag'];

        if ($flag=='D') $tarif=$def_D;
        if ($flag=='C') $tarif=$def_C;
        if ($flag=='B') $tarif=$def_B;
        if ($flag=='A') $tarif=$def_A;

    $business=$f_case['business'];
    $map=$f_case['map'];
    $mapstype=$f_case['mapstype'];

        $location_r = $db->query  ( "SELECT location FROM $db_location WHERE locationselector = '$f_case[location]'" );
	$location_f = $db->fetcharray   ( $location_r );
        $location = $location_f['location'];

    if ( $def_states_allow == "YES" )
		{
                    $state_r = $db->query  ( "SELECT state FROM $db_states WHERE stateselector = '$f_case[state]'" );
                    $state_f = $db->fetcharray   ( $state_r );
                    $state = $state_f['state'];
		} else $state = "";
    
    $city=$f_case['city'];
    $address=$f_case['address'];
    $zip=$f_case['zip'];
    $phone=$f_case['phone'];
    $fax=$f_case['fax'];
    $mobile=$f_case['mobile'];
    $icq=$f_case['icq'];
    $manager=$f_case['manager'];
    $mail=$f_case['mail'];
    $www=$f_case['www'];

         if ($f_case['social']!='') {
                 $social = explode(":", $f_case['social']);

                     if ($social[0]!='') $twitter='<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/twitter_big.png" alt="twitter" vspace="2" align="absmiddle" border="0"> http://twitter.com/'.$social[0].'<br>'; else $twitter='';
                     if ($social[1]!='') $facebook='<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/facebook_big.png" alt="facebook" vspace="2" align="absmiddle" border="0"> http://facebook.com/'.$social[1].'<br>'; else $facebook='';
                     if ($social[2]!='') $vkontakte='<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/vkontakte_big.png" alt="vkontakte" vspace="2" align="absmiddle" border="0"> http://vk.com/'.$social[2].'<br>'; else $vkontakte='';
                     if ($social[3]!='') $odnoklassniki='<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/odnoklassniki_big.png" alt="odnoklassniki" vspace="2" align="absmiddle" border="0"> http://odnoklassniki.ru/'.$social[3]; else $odnoklassniki='';
                 }

                $img_src=$def_mainlocation.'/includes/classes/resize.php?src='.$def_mainlocation.'/doci/' .my_crypt($f_case['fdate'].$f_case['selector']).'.'.$f_case['codefirm'].'&h=100&w=100&zc=1';
                $link_src = $def_mainlocation.'/doci/' .my_crypt($f_case['fdate'].$f_case['selector']).'.'.$f_case['codefirm'];
                $link_src_file = '../doci/' .my_crypt($f_case['fdate'].$f_case['selector']).'.'.$f_case['codefirm'];

                $qr_code='<img src="http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$def_mainlocation.'/view.php?id='.$f_case['selector'].'" />';

                if ($f_case['map']!='') {

                $map_type=$f_case['mapstype'];
                $map_zoom=$def_map_zoom;
		$maps_view_all=explode(',',$f_case['map']);
		$shirota=round($maps_view_all[0],3);
		$dolgota=round($maps_view_all[1],3);

			$type_static_map="map";
			if ($map_type=="map") $type_static_map="map";
			if ($map_type=="satellite") $type_static_map="sat";
			if ($map_type=="hybrid") $type_static_map="sat,skl";
			if ($map_type=="publicMap") $type_static_map="pmap";
			if ($map_type=="publicMapHybrid") $type_static_map="pmap,sat,skl";

                $ymap="<img src=\"http://static-maps.yandex.ru/1.x/?ll=$dolgota,$shirota&size=380,210&z=$map_zoom&l=$type_static_map&pt=$dolgota,$shirota\" />";

                } else $ymap='';

                $view=$def_mainlocation.'/view.php?id='.$f_case['selector'];
                if ($f_case['domen']!='') $view_domen=$def_mainlocation.'/'.$f_case['domen']; else $view_domen='';


                require_once 'template/case_report.inc';

                
    }


    
    if ($results_case==0) echo 'Компания с указанным ID не найдена!';
        
}



?>
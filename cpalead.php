<?php

    /*
        Plugin Name: CPAlead Ads
        Description: This plugin will allow you to add content locker on any page/post or category you would like.
        Author: CPAlead
        Version: 3.0
        Author URI: http://www.cpalead.com/
    */

    register_activation_hook(__FILE__, 'my_gateway_install');
    register_activation_hook(__FILE__, 'installAdTbl');
    add_action('admin_menu', 'my_gateway_menu');

    define("MAIN_URL", "https://www.cpalead.com/");
    define("API_URL", "https://www.cpalead.com/ad_banners_api.php");
    define("BANNERS_URL", "https://trklvs.com/contact.html");
    define("SUPERLINK_URL", "https://trklvs.com/index.html");
    define("SCRIPTS_URL", "https://trklvs.com/track.html");

    function checkOffers() {

        global $wpdb;
        $Res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cpasettings LIMIT 1");
        $pub_id = $Res[0]->pub_id;
        $token = $Res[0]->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL."?q=get_offers&limit=1&pub_id=".$pub_id."&token=".$token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $parsed_json = curl_exec($ch);
        $Offers = json_decode($parsed_json);
        curl_close($ch);

        if(count($Offers) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    if (!function_exists('my_gateway_menu')) {
        
        function my_gateway_menu() {

            add_menu_page(__('CPAlead Options', 'textdomain'), 'CPAlead Ads', 'manage_options', 'CPAlead', 'my_gateway_options', plugins_url('cpaleadcom-wordpress-plugin/img/icon.png'), 3);

            add_submenu_page('Edit banner', 'Edit Banner Ad', 'Edit Banner Ad', 'manage_options', 'edit_banner_ad', 'pageEditBannerAd', 0);
            add_submenu_page('Edit publisher ID', 'Edit Publisher ID', 'Edit Publisher ID', 'manage_options', 'set_pub_id', 'pageEditPublisherId', 0);

            add_submenu_page('CPAlead', 'Add Banners', 'Add Banners', 'manage_options', 'add_banner_ad', 'pageAddBannerAd', 1);
            add_submenu_page('CPAlead', 'Add CustomAd', 'Add CustomAd', 'manage_options', 'add_custom_ad', 'pageAddBannerAd', 2);
            add_submenu_page('CPAlead', 'Add PopUnder', 'Add PopUnder', 'manage_options', 'add_pop_under_ad', 'pageAddBannerAd', 3);
            add_submenu_page('CPAlead', 'Add Interstitial', 'Add Interstitial', 'manage_options', 'add_interstitial_ad', 'pageAddBannerAd', 4);
            add_submenu_page('CPAlead', 'Add Superlink', 'Add Superlink', 'manage_options', 'add_superlink_ad', 'pageAddBannerAd', 5);
            add_submenu_page('CPAlead', 'Add PushUp', 'Add PushUp', 'manage_options', 'add_push_up_ad', 'pageAddBannerAd', 6);
            add_submenu_page('CPAlead', 'Add Locker', 'Add Locker', 'manage_options', 'add_locker', 'pageAddBannerAd', 7);
            if(checkOffers() == 1) {
                add_submenu_page('CPAlead', 'Hot Offers', 'Hot Offers', 'manage_options', 'hot_offers', 'hotOffers', 8);
            }
            add_submenu_page('CPAlead', 'Manage Ads', 'Manage Ads', 'manage_options', 'manage_ads', 'page_manage_ads', 9);

            global $submenu;
            unset($submenu['CPAlead'][0]);
        }
    }


    if (isset($_GET['page']) && $_GET['page'] == 'CPAlead') {

        wp_register_style('cpa_custom_css', plugin_dir_url(__FILE__) . '/css/style.css');
        wp_enqueue_style('cpa_custom_css');
    }
    
    function page_manage_ads() {

        global $wpdb;
        $Res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cpasettings LIMIT 1");
        $pub_id = $Res[0]->pub_id;
        $token = $Res[0]->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL."?q=check_token&pub_id=".$pub_id."&token=".$token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $parsed_json = curl_exec($ch);
        $Res = json_decode($parsed_json);
        curl_close($ch);
        if($Res == "1") {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, API_URL."?q=get&pub_id=".$pub_id."&token=".$token);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $parsed_json = curl_exec($ch);
            $Res = json_decode($parsed_json);
            curl_close($ch);

            include_once 'AdsListing.php';
        } else {
            $incorrect_token = 1;
            include_once 'SetPublisher.php';
        }
    }

    function getBanner($id) {
        
        global $wpdb;
        $Res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cpasettings LIMIT 1");
        $pub_id = $Res[0]->pub_id;
        $token = $Res[0]->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL."?q=get&requested_id=".$id."&pub_id=".$pub_id."&token=".$token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $parsed_json = curl_exec($ch);
        $Res = json_decode($parsed_json);

        curl_close($ch);

        return $Res[0];
    }

    function getBanners() {
        
        global $wpdb;
        $Res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cpasettings LIMIT 1");
        $pub_id = $Res[0]->pub_id;
        $token = $Res[0]->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL."?q=get&pub_id=".$pub_id."&token=".$token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $parsed_json = curl_exec($ch);
        $Res = json_decode($parsed_json);
        curl_close($ch);

        return $Res;
    }

    function pageAddBannerAd() {

        global $wpdb;
        $Res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cpasettings LIMIT 1");
        $pub_id = $Res[0]->pub_id;
        $token = $Res[0]->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL."?q=check_token&pub_id=".$pub_id."&token=".$token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $parsed_json = curl_exec($ch);
        $Res = json_decode($parsed_json);
        curl_close($ch);
        if($Res == "1") {
            include_once 'AdsAdd.php';
        } else {
            $incorrect_token = 1;
            include_once 'SetPublisher.php';
        }
    }

    function hotOffers() {

        global $wpdb;
        $Res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cpasettings LIMIT 1");
        $pub_id = $Res[0]->pub_id;
        $token = $Res[0]->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL."?q=check_token&pub_id=".$pub_id."&token=".$token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $parsed_json = curl_exec($ch);
        $Res = json_decode($parsed_json);
        curl_close($ch);
        if($Res == "1") {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, API_URL."?q=get_offers&pub_id=".$pub_id."&token=".$token);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $parsed_json = curl_exec($ch);
            $Offers = json_decode($parsed_json);
            curl_close($ch);

            include_once 'Offers.php';
        } else {
            $incorrect_token = 1;
            include_once 'SetPublisher.php';
        }
    }

    function pageEditBannerAd() {

        global $wpdb;
        $Res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cpasettings LIMIT 1");
        $pub_id = $Res[0]->pub_id;
        $token = $Res[0]->token;

        include_once 'AdsEdit.php';
    }

    function pageEditPublisherId() {
        global $wpdb;
        $Res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cpasettings LIMIT 1");
        $pub_id = $Res[0]->pub_id;
        $token = $Res[0]->token;

        if($token != '') {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, API_URL."?q=check_token&pub_id=".$pub_id."&token=".$token);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $parsed_json = curl_exec($ch);
            $Res = json_decode($parsed_json);
            curl_close($ch);
            if($Res != "1") {
                $incorrect_token = 1;
            }
        }

        include_once 'SetPublisher.php';
    }

    function installAdTbl() {

        global $wpdb;
        $TblName = $wpdb->prefix . 'cpasettings';
        $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $TblName . "` (
              `pub_id` int(11) NOT NULL,
              `token` varchar(20) NOT NULL
            ) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
        ");
    }

    function setPubId($pub_id, $token) {

        global $wpdb;
        $Res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cpasettings LIMIT 1");
        $token = preg_replace("/\W/", "", $token);
        if($Res[0]->pub_id=='') {
            $wpdb->query("INSERT INTO " . $wpdb->prefix . "cpasettings" . " (pub_id, token) VALUES ('".intval($pub_id)."', '".$token."')");
        } else {
            $wpdb->query("UPDATE " . $wpdb->prefix . "cpasettings  SET pub_id = '".intval($pub_id)."', token = '".$token."'");
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL."?q=validate_domain&pub_id=".$pub_id."&token=".$token."&domain=".get_home_url());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $parsed_json = curl_exec($ch);
        print_r($parsed_json);
        curl_close($ch);
    }

    include('functions.php');
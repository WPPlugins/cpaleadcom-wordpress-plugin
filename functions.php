<?php

    define('CPALEAD_VERSION', '1.1');

    add_action('wp_head', 'my_gateway_head');

    global $wpdb;
    $table_name = $wpdb->prefix . 'cpalead_gateways';

    if (!function_exists('my_gateway_install')) {

        function my_gateway_install() {

            global $wpdb;
            $table_name = $wpdb->prefix . 'cpalead_gateways';
            if ($wpdb->get_var("SHOW TABLES LIKE  $table_name") != $table_name) {
                $charset_collate = $wpdb->get_charset_collate();
                $sql = $wpdb->query("CREATE TABLE $table_name (
                      id mediumint(9) NOT NULL AUTO_INCREMENT,
                      name VARCHAR( 255 ) NOT NULL,
                      content_type VARCHAR( 255 ) NOT NULL,
            		  gateway_code  TEXT NOT NULL,
                      PRIMARY KEY id (id)
                 ) $charset_collate;");
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sql);
            }
        }
    }

    if (!function_exists('cpalead_display_ad')) {
        
        function cpalead_display_ad($attrs) {

            global $wpdb;
            $Res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cpasettings LIMIT 1");
            $pub_id = $Res[0]->pub_id;

            $a = shortcode_atts(array(
                'banner' => '0',
                'width' => '',
                'height' => '',
                'content' => ''
            ), $attrs);

            ob_start();
            if($a['width'] == '' && $a['width'] == '') {
                if($a['content'] != '') {
                    echo '<a href="'.SUPERLINK_URL.'?b='.intval($a['banner']).'&s='.intval($pub_id).'">'.$a['content'].'</a>';
                } else {
                    echo '<script type="text/javascript" src="'.SCRIPTS_URL.'?js='.intval($a['banner']).'"></script>';
                }
            } else if($a['banner'] > 0) {
                echo "<iframe src='".BANNERS_URL."?id=".intval($a['banner'])."' style='border:none;overflow:hidden;width:".$a['width']."; height: ".$a['height']."'></iframe>";
            }
            echo ob_get_clean();
        }
        add_shortcode('cpalead', 'cpalead_display_ad');
    }

    if (!function_exists('cpalead_styles_scripts')) {

        function cpalead_styles_scripts() {
            wp_enqueue_style('cpalead_display_ad_style', plugin_dir_url( __FILE__) . 'css/styleiv.css', array(), CPALEAD_VERSION, 'all');
        }
        add_action('wp_enqueue_scripts', 'cpalead_styles_scripts');
    }

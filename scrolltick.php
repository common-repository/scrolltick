<?php
/*
Plugin Name: ScrollTick
Plugin URI: https://wordpress.org/plugins/scrolltick/
Description: ScrollTick allows to add any news to be scrolled on site. It has tons of options where you can scroll the news in horizontal or vertical way.
Author: UISumo Team
Version: 1.0
Author URI: https://uisumo.com/
Text Domain: scrolltick
Domain Path: languages
*/

if( ! defined('WPINC') ) {
    die;
}

defined("WP_ST_NAME") OR define("WP_ST_NAME", __("ScrollTick", 'scrolltick'));
defined('WP_ST_FILE') OR define('WP_ST_FILE', plugin_basename(__FILE__));
defined('WP_ST_PATH') OR define('WP_ST_PATH', plugin_dir_path(__FILE__)); # Plugin DIR
defined('WP_ST_URL') OR define('WP_ST_URL', plugins_url('', __FILE__));
defined('WP_ST_V') OR define('WP_ST_V', '1.0');


if( ! function_exists("scrolltick") ) {
    require_once( WP_ST_PATH . 'includes/functions.php' );
    require_once( WP_ST_PATH . 'bootstrap.php' );
    /**
     * @return ScrollTick class instance
     */
    function scrolltick() {
        return ScrollTick::instance();
    }

}

scrolltick();

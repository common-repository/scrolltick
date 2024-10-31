<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 06-02-2018
 * Time: 04:56 PM
 */

final class ScrollTick_Register_Widgets {
    private static $_instance = NULL;
    private static $_settings = NULL;
    private static $_shortcodes = NULL;

    public function __construct() {
        add_action('wpsf_widgets', array( &$this, 'add_widgets' ));
    }

    public static function instance() {
        if( self::$_instance === NULL ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function add_widgets() {
        require_once WP_ST_PATH . '/includes/widgets/scrolltick_widgets.php';
        register_widget('scrolltick_widgets');
    }
}

return ScrollTick_Register_Widgets::instance();
<?php

/**
 * Class ScrollTick
 */
final class ScrollTick {
    private static $_instance = NULL;

    public function __construct() {
        $this->load_required_files();
        add_action('wp_enqueue_scripts', array( &$this, 'register_load_scripts' ));
    }

    public function load_required_files() {
        require_once( WP_ST_PATH . 'includes/class-register-cpt.php' );
        require_once( WP_ST_PATH . 'includes/class-query.php' );
        require_once( WP_ST_PATH . 'includes/wpsf/wpsf-framework.php' );

        if( is_admin() || defined("DOING_AJAX") === TRUE ) {
            require_once( WP_ST_PATH . 'includes/class-admin.php' );
            require_once( WP_ST_PATH . 'includes/class-settings.php' );
            require_once( WP_ST_PATH . 'includes/class-metaboxes.php' );
        }

        require_once( WP_ST_PATH . 'includes/class-register-widgets.php' );
        require_once( WP_ST_PATH . 'includes/class-shortcodes.php' );

        do_action('scrolltick_loaded');
    }

    /**
     * @return ScrollTick
     */
    public static function instance() {
        if( self::$_instance === NULL ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function register_load_scripts() {
        wp_register_script('scrolltick-js', WP_ST_URL . '/assets/js/frontend.js', array( 'jquery' ), WP_ST_V, FALSE);
        wp_register_style('scrolltick-css', WP_ST_URL . '/assets/js/style.css', array(), WP_ST_V, FALSE);
        wp_enqueue_script('scrolltick-js');
        wp_enqueue_style('scrolltick-css');
    }

    /**
     * Throw error on object clone.
     *
     * Cloning instances of the class is forbidden.
     *
     * @since 1.0
     * @return void
     */
    public function __clone() {
        _doing_it_wrong(__FUNCTION__, __('Cloning instances of the class is forbidden.', 'scrolltick'), WP_ST_V);
    }

    /**
     * Disable unserializing of the class
     *
     * Unserializing instances of the class is forbidden.
     *
     * @since 1.0
     * @return void
     */
    public function __wakeup() {
        _doing_it_wrong(__FUNCTION__, __('Unserializing instances of the class is forbidden.', 'scrolltick'), WP_ST_V);
    }
}
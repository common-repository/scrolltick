<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 06-02-2018
 * Time: 04:13 PM
 */

final class ScrollTick_Settings {
    private static $_instance = NULL;
    private static $_settings = NULL;
    private static $_shortcodes = NULL;

    public function __construct() {
        add_action('wpsf_framework_loaded', array( &$this, 'add_settings' ));
    }

    public static function instance() {
        if( self::$_instance === NULL ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function add_settings() {
        self::$_settings = new WPSFramework_Settings(array(
            'menu_title'       => __("Settings", 'scrolltick'),
            'menu_slug'        => 'scrolltick-settings',
            'framework_title'  => __("ScrollTick Settings", 'scrolltick'),
            'buttons'          => array(
                'reset'   => FALSE,
                'restore' => FALSE,
            ),
            'menu_type'        => 'submenu',
            'menu_parent'      => 'edit.php?post_type=scrolltick',
            'is_sticky_header' => TRUE,
            'is_single_page'   => TRUE,
            'option_name'      => '_scrolltick_options',
        ), $this->settings_page_fields());

        self::$_shortcodes = new WPSFramework_Shortcode_Manager(array(
            'settings' => array(
                'button_title'      => __("ST Shortcodes", 'scrolltick'),
                'button_class'      => 'button button-primary scrolltick-shortcode-btn',
                'auto_select'       => 'yes',
                'exclude_posttypes' => array( 'scrolltick' ),
            ),

            array(
                'title'      => __("ST Shortcodes", 'scrolltick'),
                'shortcodes' => array(
                    array(
                        'name'   => 'scrolltick',
                        'title'  => __("ScrollTick", 'scrolltick'),
                        'fields' => array_merge(array(
                            array(
                                'id'         => 'groups',
                                'type'       => 'select',
                                'title'      => __("Group", 'scrolltick'),
                                'multiple'   => TRUE,
                                'options'    => 'tags',
                                'desc_field' => __("Select Any Group To Display Posts From", 'scrolltick'),
                                'attributes' => array(
                                    'data-allow-clear'          => 'true',
                                    'data-minimum-input-length' => '2',
                                    'style'                     => 'width:50%;',
                                    'data-placeholder'          => __("Select A Group", 'scrolltick'),
                                ),
                                'query_args' => array( 'taxonomy' => 'scrolltick_group' ),
                                'settings'   => array( 'is_ajax' => TRUE ),
                                'class'      => 'select2',
                            ),

                            array(
                                'id'         => 'posts',
                                'type'       => 'select',
                                'title'      => __("Posts", 'scrolltick'),
                                'options'    => 'posts',
                                'multiple'   => TRUE,
                                'attributes' => array(
                                    'data-allow-clear'          => 'true',
                                    'data-minimum-input-length' => '2',
                                    'style'                     => 'width:50%;',
                                    'data-placeholder'          => __("Select Posts", 'scrolltick'),
                                ),
                                'query_args' => array( 'post_type' => 'scrolltick', 'posts_per_page' => 10 ),
                                'settings'   => array( 'is_ajax' => TRUE ),
                                'class'      => 'select2',
                            ),
                        ), $this->get_js_options_outside()),
                    ),
                ),
            ),
        ));
    }

    public function settings_page_fields() {
        return array(
            'js_options' => array(
                'name'   => 'js_options',
                'title'  => __("Marquee Options", 'scrolltick'),
                'icon'   => 'dashicons dashicons-megaphone ',
                'fields' => array(
                    array(
                        'id'         => 'delay_before_start',
                        'title'      => __("Delay Before Start", 'scrolltick'),
                        'desc_field' => __("Time in milliseconds before the marquee starts animating. Default is <code>1000</code>", 'scrolltick'),
                        'type'       => 'number',
                        'default'    => 1000,
                    ),

                    array(
                        'id'         => 'direction',
                        'title'      => __("Direction", 'scrolltick'),
                        'desc_field' => __("Direction towards which the marquee will animate", 'scrolltick'),
                        'type'       => 'select',
                        'class'      => 'select2',
                        'default'    => 'left',
                        'options'    => array(
                            'up'    => __("UP", 'scrolltick'),
                            'down'  => __("Down", 'scrolltick'),
                            'left'  => __("Left", 'scrolltick'),
                            'right' => __("Right", 'scrolltick'),
                        ),
                    ),

                    array(
                        'id'         => 'duplicated',
                        'title'      => __("Duplicated", 'scrolltick'),
                        'desc_field' => __("Should the marquee be duplicated to show an effect of continuous flow. Use this only when the text is shorter than the container", 'scrolltick'),
                        'type'       => 'switcher',
                    ),

                    array(
                        'id'         => 'gap',
                        'title'      => __("Marquee Gap", 'scrolltick'),
                        'desc_field' => __("Gap in pixels between the tickers.. Default is <code>20</code> Note: <code>20</code> means <code>20px</code>", 'scrolltick'),
                        'type'       => 'number',
                        'dependency' => array( 'duplicated', '==', 'true' ),
                        'default'    => 20,
                    ),

                    array(
                        'id'         => 'duration',
                        'title'      => __("Marquee Duration", 'scrolltick'),
                        'desc_field' => __("Duration in milliseconds in which you want your element to travel. Default is <code>5000</code>", 'scrolltick'),
                        'type'       => 'number',
                        'default'    => 5000,
                    ),

                    array(
                        'id'         => 'speed',
                        'title'      => __("Speed", 'scrolltick'),
                        'desc_field' => __("Speed will override duration. Speed allows you to set a relatively constant marquee speed regardless of the width of the containing element. Speed is measured in pixels per second", 'scrolltick'),
                        'type'       => 'number',
                    ),

                    array(
                        'id'         => 'pause_on_hover',
                        'title'      => __("Pause On Hover ", 'scrolltick'),
                        'desc_field' => __("On hover pause the marquee", 'scrolltick'),
                        'type'       => 'switcher',
                    ),

                    array(
                        'id'         => 'pause_on_cycle',
                        'title'      => __("Pause On Cycle ", 'scrolltick'),
                        'desc_field' => __("On cycle, pause the marquee for <code>Delay Before Start</code> milliseconds", 'scrolltick'),
                        'type'       => 'switcher',
                    ),

                    array(
                        'id'         => 'start_visible',
                        'title'      => __("Start Visible ", 'scrolltick'),
                        'desc_field' => __(" The marquee will be visible in the start if set to On", 'scrolltick'),
                        'type'       => 'switcher',
                    ),
                ),
            ),
        );
    }

    public function get_js_options_outside() {
        $options = $this->settings_page_fields();
        $options = $options['js_options']['fields'];
        $new_options = array( 'default' => __("Default", 'scrolltick'), 'yes' => __("Yes", 'scrolltick'), 'no' => __("No", 'scrolltick') );
        foreach( $options as $id => $val ) {
            if( $val['type'] === 'switcher' ) {
                $options[$id]['type'] = 'select';
                $options[$id]['class'] = 'chosen';
                $options[$id]['options'] = $new_options;
            }
        }
        return $options;
    }
}


return ScrollTick_Settings::instance();
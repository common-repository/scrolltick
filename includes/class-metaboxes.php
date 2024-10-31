<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 06-02-2018
 * Time: 03:36 PM
 */

final class ScrollTick_PostType_Metaboxes {
    private static $_instance = NULL;
    private static $_metabox_instance = NULL;

    public function __construct() {
        add_action('wpsf_framework_loaded', array( &$this, 'add_metabox' ));
    }

    public static function instance() {
        if( self::$_instance === NULL ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function add_metabox() {
        self::$_metabox_instance = new WPSFramework_Metabox($this->metabox_fields());
    }

    private function metabox_fields() {
        return array(
            array(
                'id'        => '_scrolltick_options',
                'title'     => __("ScrollTick Options", 'scrolltick'),
                'post_type' => 'scrolltick',
                'context'   => 'normal',
                'priority'  => 'default',
                'sections'  => array(
                    array(
                        'name'   => 'section_4',
                        'fields' => array(
                            array(
                                'id'         => 'order',
                                'type'       => 'number',
                                'title'      => __("Display Order", 'scrolltick'),
                                'attributes' => array(
                                    'min' => 0,
                                ),
                            ),
                            array(
                                'id'    => 'linkto',
                                'type'  => 'links',
                                'title' => __("Link To", 'scrolltick'),
                            ),
                            array(
                                'id'       => 'start_date',
                                'type'     => 'date_picker',
                                'title'    => __("Start Date", 'scrolltick'),
                                'settings' => array(
                                    'mode'       => 'range',
                                    'minDate'    => 'today',
                                    'altInput'   => TRUE,
                                    'altFormat'  => 'F j, Y',
                                    'dateFormat' => 'Y-m-d',
                                ),
                            ),
                            /*array(
                                'id'    => 'end_date',
                                'type'  => 'date_picker',
                                'title' => __("End Date"),
                            ),*/
                        ),
                    ),
                ),

            ),
        );
    }
}

return ScrollTick_PostType_Metaboxes::instance();

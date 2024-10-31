<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 07-02-2018
 * Time: 07:05 AM
 */

final class ScrollTick_Admin {
    private static $_instance = NULL;

    public function __construct() {
        add_filter('post_row_actions', array( &$this, 'add_custom_action' ), 10, 2);
        add_filter('manage_scrolltick_posts_columns', array( &$this, 'add_custom_columns' ), 10);
        add_action('manage_scrolltick_posts_custom_column', array( &$this, 'add_custom_column_data' ), 10, 200);
    }

    public static function instance() {
        if( self::$_instance === NULL ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function add_custom_columns($columns = array()) {
        $columns = scrolltick_array_insert_before('date', $columns, 'show_date', __("Date Period", 'scrolltick'));
        return $columns;
    }

    public function add_custom_action($action = array(), $post = array()) {
        if( isset($post->post_type) && $post->post_type === 'scrolltick' ) {
            $action = array_merge(array(
                'post-id' => '<span class="post-id" style="color:#777;">' . __("ID :", 'scrolltick') . $post->ID . '</span>',
            ), $action);
        }
        return $action;
    }

    public function add_custom_column_data($key, $post_id) {
        if( $key === 'show_date' ) {
            $meta = ScrollTick_Query::meta($post_id);
            $format = get_option('date_format');
            if( ! empty($meta['start_date']) ) {
                $date = $meta['start_date'];
                $date = explode(' to ', $date);

                if( ! empty($date[0]) ) {
                    echo '<strong>' . __("Start Date : ", 'scrolltick') . '</strong>' . date($format, strtotime($date[0])) . '<br/>';
                }


                if( ! empty($date[1]) ) {
                    echo '<strong>' . __("End Date : ", 'scrolltick') . '</strong>' . date($format, strtotime($date[1]));
                }

            } else {
                echo '-';
            }
        }
    }
}

return ScrollTick_Admin::instance();
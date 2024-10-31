<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 06-02-2018
 * Time: 06:22 PM
 */

final class ScrollTick_Query {
    private static $query_args = array();

    public static function get_post_by_args($args = array()) {
        self::$query_args = array(
            'post_type'   => array( 'scrolltick' ),
            'fields'      => 'ids',
            'post_status' => array('published','publish',),
        );

        if( ! empty($args['groups']) ) {
            self::get_by_group($args['groups']);
        } else if( ! empty($args['posts']) ) {
            self::$query_args['post__in'] = self::is_explode($args['posts']);
        }

        return self::handle_posts(get_posts(self::$query_args));
    }

    private static function get_by_group($group = array()) {
        $group = self::is_explode($group);

        if( ! empty($group) ) {
            $is_term_id = ( isset($group[0]) && is_numeric($group[0]) ) ? TRUE : FALSE;

            self::$query_args['tax_query'] = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'scrolltick_group',
                    'field'    => ( $is_term_id === TRUE ) ? 'term_id' : 'slug',
                    'terms'    => $group,
                ),
            );
        }
        return TRUE;
    }

    private static function is_explode($data) {
        if( ! is_array($data) ) {
            $data = explode(',', $data);
        }
        return $data;
    }

    private static function handle_posts($post = array()) {
        if( is_wp_error($post) ) {
            return array();
        }

        $return = array();
        foreach( $post as $p ) {
            $return[] = self::handle_post($p);
        }

        return self::reorder_array(array_filter($return));
    }

    private static function handle_post($post_id) {
        $meta = self::meta($post_id);
        $is_valid = scrolltick_is_valid_post($meta['start_date']);
        if( $is_valid ) {
            $post = get_post($post_id);
            return array_merge(array(
                'content' => $post->post_content,
                'post_id' => $post_id,
            ), $meta);
        }
        return array();
    }

    public static function meta($post) {
        $defaults = array(
            'order'      => 0,
            'linkto'     => array(),
            'start_date' => '',
        );

        $meta = get_post_meta($post, '_scrolltick_options', TRUE);
        $meta = ( is_array($meta) ) ? $meta : array();
        return wp_parse_args($meta, $defaults);
    }

    private static function reorder_array($array) {
        if( ! empty($array) ) {
            usort($array, 'scrolltick_sort_array');
        }
        return $array;
    }


}
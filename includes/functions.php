<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 06-02-2018
 * Time: 05:29 PM
 */

global $wp_scrolltick_options;
$wp_scrolltick_options = array();

add_action('scrolltick_loaded', 'scrolltick_load_options');


if( ! function_exists('scrolltick_load_options') ) {
    function scrolltick_load_options() {
        global $wp_scrolltick_options;
        $options = get_option('_scrolltick_options', TRUE);
        if( ! is_array($options) ) {
            $options = array();
        }

        $wp_scrolltick_options = $options;
    }
}

if( ! function_exists('scrolltick_option') ) {
    function scrolltick_option($key = '', $default = FALSE) {
        global $wp_scrolltick_options;

        if( isset($wp_scrolltick_options[$key]) ) {
            return $wp_scrolltick_options[$key];
        }

        return $default;
    }
}

if( ! function_exists('scrolltick_is_valid_post') ) {
    function scrolltick_is_valid_post($date) {
        if( empty($date) ) {
            return TRUE;
        }

        $date = explode(' to ', $date);
        $current_time = time();

        if( ! empty($date) ) {
            $min = $date[0];
            $max = $date[1];

            if( $current_time >= strtotime($min) && $current_time <= strtotime($max) ) {
                return TRUE;
            } else if( strtotime($min) < $current_time && strtotime($max) < $current_time ) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        return TRUE;
    }
}

if( ! function_exists('scrolltick_sort_array') ) {
    function scrolltick_sort_array($a, $b) {
        if( $a['order'] == $b['order'] ) {
            return 0;
        }
        return ( $a['order'] < $b['order'] ) ? -1 : 1;
    }
}

if( ! function_exists('scrolltick_array_insert_before') ) {
    /*
     * Inserts a new key/value before the key in the array.
     * @param $key The key to insert before.
     * @param $array An array to insert in to.
     * @param $new_key The key to insert.
     * @param $new_value An value to insert.
     * @return The new array if the key exists, FALSE otherwise.
     * @see array_insert_after()
     */
    function scrolltick_array_insert_before($key, array &$array, $new_key, $new_value) {
        if( array_key_exists($key, $array) ) {
            $new = array();
            foreach( $array as $k => $value ) {
                if( $k === $key ) {
                    $new[$new_key] = $new_value;
                }
                $new[$k] = $value;
            }
            return $new;
        }
        return FALSE;
    }

}
if( ! function_exists('scrolltick_array_insert_after') ) {
    /*
    * Inserts a new key/value after the key in the array.
    * @param $key The key to insert after.
    * @param $array An array to insert in to.
    * @param $new_key The key to insert.
    * @param $new_value An value to insert.
    * @return The new array if the key exists, FALSE otherwise.
    * @see array_insert_before()
    */
    function scrolltick_array_insert_after($key, array &$array, $new_key, $new_value) {
        if( array_key_exists($key, $array) ) {
            $new = array();
            foreach( $array as $k => $value ) {
                $new[$k] = $value;
                if( $k === $key ) {
                    $new[$new_key] = $new_value;
                }
            }
            return $new;
        }
        return FALSE;
    }
}
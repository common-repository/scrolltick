<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 06-02-2018
 * Time: 04:58 PM
 */

final class ScrollTick_Widgets extends WPSFramework_Widget {

    public function __construct() {
        parent::__construct('scrolltick', __("ScrollTick", 'scrolltick'));
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        echo $args['before_widget'];
        if( ! empty($title) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        //$instance = array_filter($instance);
        $shortcode = ScrollTick_Shortcodes::instance();
        echo $shortcode->render_shortcode($instance);
        echo $args['after_widget'];
    }

    /**
     * @return array
     */
    public function form_fields() {
        $instance = ScrollTick_Settings::instance();
        $fields = $instance->get_js_options_outside();

        return array_merge(array(
            array(
                'title' => __("Widget Title", 'scrolltick'),
                'type'  => 'text',
                'id'    => 'title',
            ),
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
        ), $fields);
    }

}
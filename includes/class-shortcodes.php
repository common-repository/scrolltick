<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 06-02-2018
 * Time: 05:24 PM
 */

final class ScrollTick_Shortcodes {
    private static $_instance = NULL;

    public function __construct() {
        add_action('init', array( &$this, 'on_init' ));
    }

    public static function instance() {
        if( self::$_instance === NULL ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function on_init() {
        add_shortcode('scrolltick', array( &$this, 'render_shortcode' ));
    }

    public function render_shortcode($atts) {
        $atts = shortcode_atts($this->default_shortcode_args(), $atts, 'scrolltick');
        $atts = $this->handle_shortcode_args($atts);
        $data = ScrollTick_Query::get_post_by_args($atts);
        $attributes = $this->remap_attribtues($atts);
        $r = '<div class="scrolltick" ' . $attributes . '>';
        foreach( $data as $d ) {

            if( ! empty($d['linkto']) ) {
                $href = $d['linkto']['url'];
                $target = $d['linkto']['target'];
                $title = $d['linkto']['title'];
                $d['content'] = sprintf('<a href="%s" title="%s" target="%s">%s</a>', $href, $title, $target, $d['content']);
            }

            $r .= '<p class="scrolltick-single-content">' . $d['content'] . '</p>';
        }
        $r .= '</div>';
        return $r;
    }

    public function default_shortcode_args() {
        return array(
            'groups'             => '',
            'posts'              => '',
            'delay_before_start' => scrolltick_option('delay_before_start', 1000),
            'direction'          => scrolltick_option('direction', 'left'),
            'duplicated'         => scrolltick_option('duplicated'),
            'gap'                => scrolltick_option('gap', 20),
            'duration'           => scrolltick_option('duration', 5000),
            'speed'              => scrolltick_option('speed'),
            'pause_on_hover'     => scrolltick_option('pause_on_hover'),
            'pause_on_cycle'     => scrolltick_option('pause_on_cycle'),
            'start_visible'      => scrolltick_option('start_visible'),
        );
    }

    public function handle_shortcode_args($atts) {
        foreach( $atts as $id => $val ) {
            if( $val == 'default' ) {
                $atts[$id] = scrolltick_option($id);
            }

            if( $val == 'true' || $val == '1' ) {
                $atts[$id] = TRUE;
            }

            if( $val == 'false' || $val == '0' ) {
                $atts[$id] = FALSE;
            }

        }

        return $atts;
    }

    private function remap_attribtues($atts) {
        $OK_Attrs = $this->white_list_attrs();
        $return = '';
        foreach( array_filter($atts) as $id => $val ) {
            if( isset($OK_Attrs[$id]) ) {
                $return .= ' data-' . $OK_Attrs[$id] . '="' . esc_attr($val) . '" ';
            }
        }

        return $return;
    }

    private function white_list_attrs() {
        return array(
            'allow_css3_support' => 'allowCss3Support',
            'css3_easing'        => 'css3easing',
            'delay'              => 'delayBeforeStart',
            'direction'          => 'direction',
            'duplicated'         => 'duplicated',
            'duration'           => 'duration',
            'speed'              => 'speed',
            'gap'                => 'gap',
            'pause_hover'        => 'pauseOnHover',
            'pause_cycle'        => 'pauseOnCycle',
            'start_visible'      => 'startVisible',
        );
    }
}

return ScrollTick_Shortcodes::instance();
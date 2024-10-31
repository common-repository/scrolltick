<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 06-02-2018
 * Time: 03:20 PM
 */

final class ScrollTick_PostTypes {
    private static $_instance = NULL;

    public function __construct() {
        add_action('init', array( &$this, 'register_cpt' ));
    }

    public static function instance() {
        if( self::$_instance === NULL ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function register_cpt() {
        register_post_type('scrolltick', $this->post_type_args());
        register_taxonomy('scrolltick_group', array( 'scrolltick' ), $this->taxonomy_args());
    }

    private function post_type_args() {
        return array(
            'label'               => __('ScrollTick', 'scrolltick'),
            'description'         => __('Post Type Description', 'scrolltick'),
            'labels'              => $this->post_type_labels(),
            'supports'            => array( 'title','editor' ),
            'taxonomies'          => array( 'scrolltick_group' ),
            'hierarchical'        => FALSE,
            'public'              => TRUE,
            'show_ui'             => TRUE,
            'show_in_menu'        => TRUE,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-megaphone',
            'show_in_admin_bar'   => FALSE,
            'show_in_nav_menus'   => TRUE,
            'can_export'          => TRUE,
            'has_archive'         => '',
            'exclude_from_search' => TRUE,
            'publicly_queryable'  => TRUE,
            'rewrite'             => TRUE,
            'capability_type'     => 'post',
        );
    }

    public function post_type_labels() {
        return array(
            'name'                  => __('ScrollTick', 'scrolltick'),
            'singular_name'         => __('ScrollTick', 'scrolltick'),
            'menu_name'             => __('ScrollTicks', 'scrolltick'),
            'name_admin_bar'        => __('Post Type', 'scrolltick'),
            'archives'              => __('Item Archives', 'scrolltick'),
            'attributes'            => __('Item Attributes', 'scrolltick'),
            'parent_item_colon'     => __('Parent Item:', 'scrolltick'),
            'all_items'             => __('All Items', 'scrolltick'),
            'add_new_item'          => __('Add New Item', 'scrolltick'),
            'add_new'               => __('Add New', 'scrolltick'),
            'new_item'              => __('New Item', 'scrolltick'),
            'edit_item'             => __('Edit Item', 'scrolltick'),
            'update_item'           => __('Update Item', 'scrolltick'),
            'view_item'             => __('View Item', 'scrolltick'),
            'view_items'            => __('View Items', 'scrolltick'),
            'search_items'          => __('Search Item', 'scrolltick'),
            'not_found'             => __('Not found', 'scrolltick'),
            'not_found_in_trash'    => __('Not found in Trash', 'scrolltick'),
            'featured_image'        => __('Featured Image', 'scrolltick'),
            'set_featured_image'    => __('Set featured image', 'scrolltick'),
            'remove_featured_image' => __('Remove featured image', 'scrolltick'),
            'use_featured_image'    => __('Use as featured image', 'scrolltick'),
            'insert_into_item'      => __('Insert into item', 'scrolltick'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'scrolltick'),
            'items_list'            => __('Items list', 'scrolltick'),
            'items_list_navigation' => __('Items list navigation', 'scrolltick'),
            'filter_items_list'     => __('Filter items list', 'scrolltick'),
        );
    }

    public function taxonomy_args() {
        return array(
            'labels'            => $this->taxonomy_labels(),
            'hierarchical'      => TRUE,
            'public'            => TRUE,
            'show_ui'           => TRUE,
            'show_admin_column' => TRUE,
            'show_in_nav_menus' => TRUE,
            'show_tagcloud'     => TRUE,
        );
    }

    public function taxonomy_labels() {
        return array(
            'name'                       => _x('Groups', 'Taxonomy General Name', 'scrolltick'),
            'singular_name'              => _x('Group', 'Taxonomy Singular Name', 'scrolltick'),
            'menu_name'                  => __('Group', 'scrolltick'),
            'all_items'                  => __('All Groups', 'scrolltick'),
            'parent_item'                => __('Parent Group', 'scrolltick'),
            'parent_item_colon'          => __('Parent Group :', 'scrolltick'),
            'new_item_name'              => __('New Group Name', 'scrolltick'),
            'add_new_item'               => __('Add New Group', 'scrolltick'),
            'edit_item'                  => __('Edit Group', 'scrolltick'),
            'update_item'                => __('Update Group', 'scrolltick'),
            'view_item'                  => __('View Group', 'scrolltick'),
            'separate_items_with_commas' => __('Separate Groups with commas', 'scrolltick'),
            'add_or_remove_items'        => __('Add or remove Groups', 'scrolltick'),
            'choose_from_most_used'      => __('Choose from the most used', 'scrolltick'),
            'popular_items'              => __('Popular Groups', 'scrolltick'),
            'search_items'               => __('Search Groups', 'scrolltick'),
            'not_found'                  => __('Not Found', 'scrolltick'),
            'no_terms'                   => __('No Groups', 'scrolltick'),
            'items_list'                 => __('Groups list', 'scrolltick'),
            'items_list_navigation'      => __('Groups list navigation', 'scrolltick'),
        );
    }
}

return ScrollTick_PostTypes::instance();
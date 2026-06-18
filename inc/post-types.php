<?php
/**
 * Register Custom Post Types
 *
 * @package bubble-stop
 */

function bubble_stop_register_post_types() {
    $labels = array(
        'name'                  => _x( 'Products', 'Post Type General Name', 'bubble-stop' ),
        'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'bubble-stop' ),
        'menu_name'             => __( 'Products', 'bubble-stop' ),
        'name_admin_bar'        => __( 'Product', 'bubble-stop' ),
        'archives'              => __( 'Product Archives', 'bubble-stop' ),
        'attributes'            => __( 'Product Attributes', 'bubble-stop' ),
        'parent_item_colon'     => __( 'Parent Product:', 'bubble-stop' ),
        'all_items'             => __( 'All Products', 'bubble-stop' ),
        'add_new_item'          => __( 'Add New Product', 'bubble-stop' ),
        'add_new'               => __( 'Add New', 'bubble-stop' ),
        'new_item'              => __( 'New Product', 'bubble-stop' ),
        'edit_item'             => __( 'Edit Product', 'bubble-stop' ),
        'update_item'           => __( 'Update Product', 'bubble-stop' ),
        'view_item'             => __( 'View Product', 'bubble-stop' ),
        'view_items'            => __( 'View Products', 'bubble-stop' ),
        'search_items'          => __( 'Search Product', 'bubble-stop' ),
        'not_found'             => __( 'Not found', 'bubble-stop' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'bubble-stop' ),
        'featured_image'        => __( 'Featured Image', 'bubble-stop' ),
        'set_featured_image'    => __( 'Set featured image', 'bubble-stop' ),
        'remove_featured_image' => __( 'Remove featured image', 'bubble-stop' ),
        'use_featured_image'    => __( 'Use as featured image', 'bubble-stop' ),
        'insert_into_item'      => __( 'Insert into product', 'bubble-stop' ),
        'uploaded_to_this_item' => __( 'Uploaded to this product', 'bubble-stop' ),
        'items_list'            => __( 'Products list', 'bubble-stop' ),
        'items_list_navigation' => __( 'Products list navigation', 'bubble-stop' ),
        'filter_items_list'     => __( 'Filter products list', 'bubble-stop' ),
    );
    $args = array(
        'label'                 => __( 'Product', 'bubble-stop' ),
        'description'           => __( 'Custom product post type', 'bubble-stop' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-archive',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => array( 'slug' => 'products' ),
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type( 'bubble_product', $args );

    // Register Product Category Taxonomy
    $labels = array(
        'name'                       => _x( 'Product Categories', 'Taxonomy General Name', 'bubble-stop' ),
        'singular_name'              => _x( 'Product Category', 'Taxonomy Singular Name', 'bubble-stop' ),
        'menu_name'                  => __( 'Product Categories', 'bubble-stop' ),
        'all_items'                  => __( 'All Categories', 'bubble-stop' ),
        'parent_item'                => __( 'Parent Category', 'bubble-stop' ),
        'parent_item_colon'          => __( 'Parent Category:', 'bubble-stop' ),
        'new_item_name'              => __( 'New Category Name', 'bubble-stop' ),
        'add_new_item'               => __( 'Add New Category', 'bubble-stop' ),
        'edit_item'                  => __( 'Edit Category', 'bubble-stop' ),
        'update_item'                => __( 'Update Category', 'bubble-stop' ),
        'view_item'                  => __( 'View Category', 'bubble-stop' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'bubble-stop' ),
        'add_or_remove_items'        => __( 'Add or remove categories', 'bubble-stop' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'bubble-stop' ),
        'popular_items'              => __( 'Popular Categories', 'bubble-stop' ),
        'search_items'               => __( 'Search Categories', 'bubble-stop' ),
        'not_found'                  => __( 'Not Found', 'bubble-stop' ),
        'no_terms'                   => __( 'No categories', 'bubble-stop' ),
        'items_list'                 => __( 'Categories list', 'bubble-stop' ),
        'items_list_navigation'      => __( 'Categories list navigation', 'bubble-stop' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rewrite'                    => array( 'slug' => 'product-category' ),
    );
    register_taxonomy( 'product_category', array( 'bubble_product' ), $args );
}
add_action( 'init', 'bubble_stop_register_post_types', 0 );

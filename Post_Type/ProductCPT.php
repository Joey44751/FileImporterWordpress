<?php

namespace joey\uploader\Post_Type;

class ProductCPT
{
    public static function custom_post_type_init(): void
    {
        register_post_type('Products',
            array(
                'labels' => array(
                    'name' => 'Products',
                    'add_new' => 'Product toevoegen',
                    'add_new_item' => 'Nieuwe Product toevoegen',
                    'item_published' => 'Product Toegevoegd',
                    'item_updated' => 'Product Gewijzigd ',
                    'edit_item' => 'Wijzig Product',
                    'all_items' => 'Alle Product',
                    'view_item' => 'Toon Product',
                    'search_items' => 'Zoek Product',
                    'not_found' => 'Geen Product gevonden',
                    'not_found_in_trash' => 'Geen Product gevonden in de prullenmand',
                    'show_in_rest' => true,
                    'label' => 'Products',

                ),
                'has_archive' => true,
                'rewrite' => array('slug' => 'Product'),
                'menu_icon' => 'dashicons-store',
                'show_in_rest' => true,
                "public" => true,
                'capability_type'  => 'post',
                'capabilities' => array( 'create_posts' => false ),
                'map_meta_cap' => true,
                "show_ui" => true,
                "show_in_menu" => false,
                "show_in_nav_menus" => false,
                "show_in_admin_bar" => false,
                "supports" => false
            )
        );
    }

}
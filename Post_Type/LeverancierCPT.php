<?php

namespace joey\uploader\Post_Type;

class LeverancierCPT
{
    public static function custom_post_type_init(): void
    {
        register_post_type('Leveranciers',
            array(
                'labels' => array(
                    'name' => 'Leveranciers',
                    'add_new' => 'Leverancier toevoegen',
                    'add_new_item' => 'Nieuwe Leverancier toevoegen',
                    'item_published' => 'Leverancier Toegevoegd',
                    'item_updated' => 'Leverancier Gewijzigd ',
                    'edit_item' => 'Wijzig Leverancier',
                    'all_items' => 'Alle Leverancier',
                    'view_item' => 'Toon Leverancier',
                    'search_items' => 'Zoek Leverancier',
                    'not_found' => 'Geen Leverancier gevonden',
                    'not_found_in_trash' => 'Geen Leverancier gevonden in de prullenmand',
                    'show_in_rest' => true,
                    'label' => 'Leveranciers',

                ),
                'has_archive' => true,
                'rewrite' => array('slug' => 'leverancier'),
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
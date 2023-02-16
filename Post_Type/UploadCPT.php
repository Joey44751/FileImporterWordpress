<?php

namespace joey\uploader\Post_Type;

class UploadCPT
{
    public static function custom_post_type_init(): void
    {
        register_post_type('Stores',
            array(
                'labels' => array(
                    'name' => 'Winkels',
                    'add_new' => 'Winkel toevoegen',
                    'add_new_item' => 'Nieuwe winkel toevoegen',
                    'item_published' => 'Winkel Toegevoegd',
                    'item_updated' => 'Winkel Gewijzigd ',
                    'edit_item' => 'Wijzig Winkel',
                    'all_items' => 'Alle winkels',
                    'view_item' => 'Toon winkel',
                    'search_items' => 'Zoek Winkels',
                    'not_found' => 'Geen winkel gevonden',
                    'not_found_in_trash' => 'Geen winkel gevonden in de prullenmand',
                    'show_in_rest' => true,
                    'label' => 'Stores',

                ),
                'has_archive' => true,
                'rewrite' => array('slug' => 'stores'),
                'menu_icon' => 'dashicons-store',
                'show_in_rest' => true,
                'capability_type'  => 'post',
                'capabilities' => array( 'create_posts' => false ),
                'map_meta_cap' => true,
                "public" => true,
                "show_ui" => true,
                "show_in_menu" => false,
                "show_in_nav_menus" => false,
                "show_in_admin_bar" => false,
                "supports" => false
            )
        );
    }
}



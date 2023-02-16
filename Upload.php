<?php
/*
Plugin Name: File Uploader
Description: Easily Upload CSV , JSON , XML using Gravity Forms
Version: 1.3
Author: Joey
*/


/*
 *
 * Solid prince checklist:
 *      S -> 1 file = een verantwoordelijkheid (bv inlezen , verwerken ,etc)
 *      O -> Open voor bijvoegen maar gesloten voor bijwerken
 *      L -> Elke child class zou moeten werken bij aanroepen parent class
 *      I -> Enkel Interfaces met functies die duidelijk zijn en gebruikt worden
 *      D -> Objecten gemaakt van Abstracte classes , non depended op low level modules
 *
*/

use joey\uploader\Custom_Fields\UploadCAC;
use joey\uploader\Custom_Fields\UploadMetaBox;
use joey\uploader\Functions\UploadHandler;
use joey\uploader\Functions\UploadMimes;
use joey\uploader\Post_Type\LeverancierCPT;
use joey\uploader\Post_Type\ProductCPT;
use joey\uploader\Post_Type\UploadCPT;
use joey\uploader\Post_Type\UploadPostData;
use joey\uploader\Settings\SettingsAPI;

require_once __DIR__ . '/vendor/autoload.php';


wp_enqueue_style('jquery-datatables-css', '//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css');
wp_enqueue_script('jquery-datatables-js', '//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js', array('jquery'));
wp_enqueue_style('select2-css', '//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
wp_enqueue_script('select2-js', '//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
wp_enqueue_style('dashicons');
wp_enqueue_script('mapbox-gl.js','https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js');
wp_enqueue_style('mapbox-gl.css','https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css');


add_action("admin_menu", [SettingsAPI::class, 'add_new_menu_items'], 10);
add_action('init', [UploadCPT::class, 'custom_post_type_init']);
add_action('init', [LeverancierCPT::class, 'custom_post_type_init']);
add_action('init', [ProductCPT::class, 'custom_post_type_init']);
add_filter('upload_mimes', [UploadMimes::class, 'add_upload_types']);
add_action('add_meta_boxes', [UploadMetaBox::class, 'metabox_save']);
add_action('save_post', [UploadPostData::class, "dataHandle"]);
add_filter('manage_stores_posts_columns', [UploadCAC::class, 'columns_stores'], 10, 1);
add_action('manage_posts_custom_column', [UploadCAC::class, 'store_admin_columns'], 10, 2);
add_action('gform_after_submission', [UploadHandler::class, 'handle_gform_data'], 10, 1);
add_filter('post_row_actions', [UploadCAC::class, 'remove_quick_edit'], 10, 1);
add_action( 'admin_menu', function () {remove_meta_box( 'submitdiv', 'Products', 'side' );} );
add_action( 'admin_menu', function () {remove_meta_box( 'submitdiv', 'Stores', 'side' );} );
add_action( 'admin_menu', function () {remove_meta_box( 'submitdiv', 'Leveranciers', 'side' );} );
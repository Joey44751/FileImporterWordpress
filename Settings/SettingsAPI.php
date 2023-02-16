<?php

namespace joey\uploader\Settings;

class SettingsAPI
{
    static function add_new_menu_items()
    {
        add_menu_page(
            "Beheer",
            "Beheer",
            "manage_options",
            "winkel-options",
            [self::class, 'winkel_options_page'],
            "dashicons-store",
            100
        );
    }


    static function winkel_options_page()
    {
        ?>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <h1>Beheer</h1>
            <form method="post" action="">
                <?php

                echo
                '<h2 class="nav-tab-wrapper">
                    <a href="?page=winkel-options&tab=winkel" class="nav-tab">Winkel Options</a>
                     <a href="?page=winkel-options&tab=leverancier" class="nav-tab">Leverancier Options</a>
                     <a href="?page=winkel-options&tab=producten" class="nav-tab">Product Options</a>
                     <a href="?page=winkel-options&tab=link" class="nav-tab">View Products Links</a>
                    </h2>';

                if (isset($_GET['tab'])) {
                    $active_tab = $_GET['tab'];
                } else {
                    $active_tab = 'winkel';
                }

                if ($active_tab == 'winkel') {
                    register_setting('store_create', 'store_create', SettingsFunctions::createStore());
                    add_settings_section("store_form_content", "Winkel Toevoegen", [SettingsStyle::class, "display_store_form_content"], "winkel-options");
                    do_settings_sections("winkel-options");
                } else if ($active_tab == 'leverancier') {
                    register_setting('leverancier_create', 'leverancier_create', SettingsFunctions::createLeverancier());
                    add_settings_section("leverancier_form_content", "Leverancier Toevoegen", [SettingsStyle::class, "display_leverancier_form_content"], "winkel-options");
                    do_settings_sections("winkel-options");
                } else if ($active_tab == 'producten') {
                    register_setting('product_create', 'product_create', SettingsFunctions::createProduct());
                    add_settings_section("product_form_content", "Product Toevoegen", [SettingsStyle::class, "display_product_form_content"], "winkel-options");
                    do_settings_sections("winkel-options");
                } else if ($active_tab == 'link') {
                    add_settings_section("link_form_content", "Link Toevoegen", [SettingsStyle::class, "display_link_form_content"], "winkel-options");
                    do_settings_sections("winkel-options");
                } else {
                    echo '<div class="notice notice-error is-dismissible">
                    <p>Tablad niet gevonden</p>
                    </div>';
                }

                ?>
            </form>
        </div>
        <?php
    }
    // Fotos


}
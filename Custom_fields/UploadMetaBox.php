<?php

namespace joey\uploader\Custom_Fields;


use joey\uploader\Models\LeveranciersModel;
use joey\uploader\Models\ProductModel;
use joey\uploader\Models\UploadModel;
use joey\uploader\Settings\SettingsFunctions;
use WP_Screen;

class UploadMetaBox
{
    public static function metabox_save(): void
    {
        add_meta_box("store_add", "Winkel", [self::class, "store_store_meta_box"], WP_Screen::get('Stores'));
        add_meta_box("lev_add", "Winkel", [self::class, "lev_store_meta_box"], WP_Screen::get('Leveranciers'));
        add_meta_box("prod_add", "Winkel", [self::class, "prod_store_meta_box"], WP_Screen::get('Products'));
    }

    static function store_store_meta_box(): void
    {
        $store = (new UploadModel())->getById(get_the_ID());



        echo ' 
            <div style="display: flex;justify-content:space-between;flex-direction: row;">
              <div style="display: flex; flex-direction: column;width: 50%; justify-content: space-evenly" >
                <p>Winkel naam</p>
                <p>Straat</p>
                <p>Huisnummer</p>
                <p>Postcode</p>
                <p>Gemeente</p>
              </div>
              <div style="display: flex; flex-direction: column;width: 50%;justify-content: space-evenly">
                <form action="UploadPostData.php" method="POST">
                    <input required type="text" name="store_name" value="' . $store->getStoreName() . '">
                    <input required type="text" name="store_street" value="' . $store->getStreet() . '">
                    <input required type="text" name="store_house_number" value="' . $store->getHouseNumber() . '">
                    <input required type="text" name="store_postal_code" value="' . $store->getPostalCode() . '">
                    <input required type="text" name="store_city" disabled value="' . $store->getCity() . '">
                </form>
              </div>
            </div>';
        submit_button('Save Store');
        SettingsFunctions::getCoordinates($store->getStreet(),$store->getHouseNumber(),$store->getPostalCode(),$store->getCity());
    }

    static function lev_store_meta_box(): void
    {
        $lev = (new LeveranciersModel())->getById(get_the_ID());

        echo ' 
            <div style="display: flex;justify-content:space-between;flex-direction: row;">
              <div style="display: flex; flex-direction: column;width: 50%; justify-content: space-evenly" >
                <p>Leverancier naam</p>
                <p>Leverancier Specialiteit</p>
              </div>
              <div style="display: flex; flex-direction: column;width: 50%;justify-content: space-evenly">
                <form action="UploadPostData.php" method="POST">
                    <input required type="text" name="leverancier_name" value="' . $lev->getNaam() . '">
                    <input required type="text" name="leverancier_specialiteit" value="' . $lev->getSpecialiteit() . '">
                </form>
              </div>
            </div>
        ';
        submit_button('Save Leverancier');
    }

    static function prod_store_meta_box(): void
    {
        $prod = (new ProductModel())->getById(get_the_ID());
        $argsLev = array(
            'post_type' => 'Leveranciers',
            'post_status' => 'publish',
            'numberposts' => -1
        );
        $my_posts_lev = get_posts($argsLev);
        echo ' <div style="display: flex;justify-content:space-between;flex-direction: row;">
              <div style="display: flex; flex-direction: column;width: 15%; justify-content: space-evenly" >
                    <p>Product naam</p>
                    <p>Leverancier</p>
              </div>
              <div style="display: flex; flex-direction: column;width: 100%;margin-top: 10px;">
                    <input style="margin-bottom: 15px;" required type="text" name="product_name" value="'.$prod->getNaam().'">
                    <select id="levid" name="leverancier_id">';
        foreach ($my_posts_lev as $key => $data) {
            $metadata = get_post_meta($data->ID);
            if($prod->getLevID() == $data->ID){
                echo '<option required selected name="leverancier_id" value="' . $data->ID . '">' . $metadata['leverancier_name'][0] . '</option>';
            }
            else if (isset($metadata['leverancier_name'][0])) {
                echo '<option required name="leverancier_id" value="' . $data->ID . '">' . $metadata['leverancier_name'][0] . '</option>';
            }
        }
        echo '</select>
              </div>
            </div>';

        echo "<script>jQuery(document).ready(function($) {
    $('#levid').select2();
} );</script>";
        submit_button('Save Product');


    }
}
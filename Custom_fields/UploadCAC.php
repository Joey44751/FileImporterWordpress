<?php

namespace joey\uploader\Custom_Fields;

use joey\uploader\Models\UploadModel;
use Carbon\Carbon;

class UploadCAC
{

    public static function store_admin_columns($column, $postid): void
    {
        $store = (new UploadModel())->getById($postid);
        switch ($column) {
            case 'store_name':
                echo $store->getStoreName();
                break;
            case 'store_street':
                echo $store->getStreet();
                break;
            case 'store_house_number':
                echo $store->getHouseNumber();
                break;
            case 'store_postal_code':
                echo $store->getPostalCode();
                break;
            case 'store_city':
                echo $store->getCity();
                break;
            case 'store_map':
                echo "<a target='_blank' href='https://www.google.be/maps/place/" . $store->getStreet() . "+" . $store->getHouseNumber() . "+" .
                    $store->getPostalCode() . "+" . $store->getCity() . "'>Kaart</a>";
                break;
            case 'store_create_date':
                echo Carbon::createFromTimestamp(get_post_time('U', true, $store->getId()), 'Europe/Brussels')->format("H:i:s | d-m-Y");
                break;
        }
    }

    public static function columns_stores($columns)
    {
        unset($columns['title']);
        unset($columns['date']);
        $columns['store_name'] = 'Winkel';
        $columns['store_street'] = "Straat";
        $columns['store_house_number'] = 'Huisnummer';
        $columns['store_postal_code'] = "Postcode";
        $columns['store_city'] = "Gemeente";
        $columns['store_map'] = "Map";
        $columns['store_create_date'] = "Gemaakt op";
        return $columns;
    }

    static function remove_quick_edit($columns)
    {
        unset($columns['inline hide-if-no-js']);
        return $columns;
    }


}
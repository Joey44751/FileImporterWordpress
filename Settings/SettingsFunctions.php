<?php

namespace joey\uploader\Settings;

use joey\uploader\Factory\LeverancierFactory;
use joey\uploader\Factory\ProductFactory;
use joey\uploader\Factory\UploadWCFactory;

class SettingsFunctions
{
    static function createStore(): void
    {
        if (isset($_POST['store_name'])) {
            $post_id = wp_insert_post(
                array(
                    'post_status' => 'publish',
                    'post_title' => $_POST['store_name'],
                    'post_type' => 'Stores'
                )
            );
            $_POST['ID'] = $post_id;
            UploadWCFactory::create($_POST);
        }
    }

    static function createLeverancier(): void
    {
        if (isset($_POST['leverancier_name'])) {
            $post_id = wp_insert_post(
                array(
                    'post_status' => 'publish',
                    'post_title' => $_POST['leverancier_name'],
                    'post_type' => 'Leveranciers'
                )
            );
            $_POST['ID'] = $post_id;
            LeverancierFactory::create($_POST);
        }
    }

    static function createProduct(): void
    {
        if (isset($_POST['product_name'])) {
            $post_id = wp_insert_post(
                array(
                    'post_status' => 'publish',
                    'post_title' => $_POST['product_name'],
                    'post_type' => 'Products'
                )
            );
            $_POST['ID'] = $post_id;
            ProductFactory::create($_POST);
        }
    }

    public static  function getCoordinates($street,$house_number,$postalcode,$city)
    {
        $coords_json = file_get_contents("http://api.positionstack.com/v1/forward?access_key=b5053fdd91a5227af3e7e6760c5c9849&query=". $street . "%20" . $house_number
            . "%20". $postalcode. "%20". $city);
        $coords = json_decode($coords_json, true);
        ?>
            <style>
                .my-icon {
                    border-radius: 100%;
                    width: 20px;
                    height: 20px;
                    text-align: center;
                    line-height: 20px;
                    color: black;
                }

                .icon-dc {
                    background: black;
                }
            </style>


        <div id="map" class="my-icon icon-dc" style='width: 50%; height: 350px;justify-content: center;justify-self: center;display: flex;align-self: center;align-items: center
        ;margin-left: auto;margin-right: auto'></div>
        <script>
            mapboxgl.accessToken = 'pk.eyJ1Ijoiam9leTQ0NzUxIiwiYSI6ImNsYnc4OTlqZzF6eWozdnFuZ2xxazI4ejEifQ.St-mU6-rh4Gmnx5mOG8ClQ';
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [<?php echo $coords['data'][0]['longitude']; ?>, <?php echo $coords['data'][0]['latitude'];?>],
                zoom: 12,
            });
            new mapboxgl.Marker()
                .setLngLat([<?php echo $coords['data'][0]['longitude']; ?>, <?php echo $coords['data'][0]['latitude'];?>])
                .addTo(map);
        </script>

        <?php
    }

}
<?php

namespace joey\uploader\Post_Type;

use joey\uploader\Adapter\LeverancierAdapter;
use joey\uploader\Adapter\ProductAdapter;
use joey\uploader\Adapter\UploadAdapter;
use joey\uploader\Models\LeveranciersModel;
use joey\uploader\Models\ProductModel;
use joey\uploader\Models\UploadModel;

class UploadPostData
{
    public static function dataHandle()
    {
        remove_action('save_post', [UploadPostData::class, 'dataHandle']);
        if (array_key_exists('ID', $_POST)) {
            if (array_key_exists('store_name', $_POST)) {
                (new UploadModel())->save(new UploadAdapter($_POST));
            } else if (array_key_exists('leverancier_name', $_POST)) {
                (new LeveranciersModel())->save(new LeverancierAdapter($_POST));
            } else {
                var_dump(json_encode($_POST,true));die;
                // WHAT IF 1 PRODUCT == MULTIPLE LEVERANCIERS?
                if($_POST('product_name') == $prod->getNaam()){
                    var_dump();
                }
                (new ProductModel())->save(new ProductAdapter($_POST));
            }
            echo '<div class="notice notice-success is-dismissible">
                 <p>Success.</p>
             </div>';
        }
        add_action('save_post', [UploadPostData::class, 'dataHandle']);
    }
}
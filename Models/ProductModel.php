<?php

namespace joey\uploader\Models;

use joey\uploader\Adapter\LeverancierAdapter;
use joey\uploader\Adapter\ProductAdapter;
use joey\uploader\Functions\MetaDataFunc;

class ProductModel
{
    private const META_KEYS = array(
        'product_name' => 'getNaam',
        'leverancier_id' => 'getLevID',
    );

    public function getById($post_id): ProductAdapter
    {
        return new ProductAdapter(MetaDataFunc::getMetaData($post_id));
    }

    public function save(ProductAdapter $product): ProductAdapter
    {
        wp_update_post(array(
            'ID' => $product->getId(),
            'post_status' => 'publish',
            'post_title' => $product->getNaam(),
            'post_type' => 'Products'
        ));
        foreach (array_keys(self::META_KEYS) as $key) {
            update_post_meta($product->getId(), $key, $product->{self::META_KEYS[$key]}());
        }
        return $product;
    }

}
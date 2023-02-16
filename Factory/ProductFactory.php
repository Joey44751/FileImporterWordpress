<?php

namespace joey\uploader\Factory;

use joey\uploader\Adapter\ProductAdapter;
use joey\uploader\Models\ProductModel;

;

class ProductFactory
{
    public static function create($item): ProductAdapter
    {
        return (new ProductModel())->save(new ProductAdapter($item));
    }

}
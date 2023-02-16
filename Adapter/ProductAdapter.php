<?php

namespace joey\uploader\Adapter;

class ProductAdapter
{
    public function __construct(private array $product)
    {
        if (!array_key_exists('product_name', $this->product)) {
            $this->product = array(
                'ID' => $this->product['ID'],
                'product_name' => '',
                'leverancier_id' => '',
            );
        }
    }

    function getId(): int
    {
        return $this->product['ID'];
    }

    function getNaam(): string
    {
        return $this->product['product_name'];
    }

    function getLevID(): int
    {
        return $this->product['leverancier_id'];
    }

}
<?php

namespace joey\uploader\Adapter;

use joey\uploader\Interface\UploadInterface;

class UploadAdapter implements UploadInterface
{
    public function __construct(private array $store)
    {
        if (!array_key_exists('store_name', $this->store)) {
            $this->store = array(
                'ID' => $this->store['ID'],
                'store_name' => '',
                'store_street' => '',
                'store_house_number' => '',
                'store_postal_code' => '',
                'store_city' => '',
            );
        }
    }

    public function getId(): int
    {
        return $this->store['ID'];
    }

    public function getStoreName(): string
    {
        return $this->store['store_name'];
    }

    public function getStreet(): string
    {
        return $this->store['store_street'];
    }

    public function getHouseNumber(): string
    {
        return $this->store['store_house_number'];
    }

    public function getPostalCode(): string
    {
        return $this->store['store_postal_code'];
    }

    public function getCity()
    {
        if ($this->getPostalCode() != null) {
            $postcode = file_get_contents("https://www.opzoeken-postcode.be/" . $this->getPostalCode() . ".json");
            $postcode_split = json_decode($postcode, true);
            if ($postcode_split == null || !isset($postcode_split)) {
                return $this->store['store_city'] = "Niet in België";
            }
            $output = $postcode_split[0]["Postcode"]["naam_deelgemeente"];
            $this->store['store_postal_code'] = $postcode_split[0]["Postcode"]["postcode_deelgemeente"];
            return $this->store['store_city'] = $output;
        }
    }

}
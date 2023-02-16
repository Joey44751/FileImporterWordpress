<?php

namespace joey\uploader\Models;


use joey\uploader\Adapter\UploadAdapter;
use joey\uploader\Functions\MetaDataFunc;

class UploadModel
{
    private const META_KEYS = array(
        'store_name' => 'getStoreName',
        'store_street' => 'getStreet',
        'store_house_number' => 'getHouseNumber',
        'store_postal_code' => 'getPostalCode',
        'store_city' => 'getCity'
    );

    public function __construct()
    {
    }

    public function getById($post_id): UploadAdapter
    {
        return new UploadAdapter(MetaDataFunc::getMetaData($post_id));
    }

    public function save(UploadAdapter $store): void
    {
        wp_update_post(array(
            'ID' => $store->getId(),
            'post_status' => 'publish',
            'post_title' => $store->getStoreName()
        ));
        foreach (array_keys(self::META_KEYS) as $key) {
            update_post_meta($store->getId(), $key, $store->{self::META_KEYS[$key]}());
        }
    }

    public function bulkSave(array $stores): UploadAdapter
    {
        if (count($stores) == count($stores, COUNT_RECURSIVE)) {
            $this->save(new UploadAdapter($stores));
            return $this->getById($stores['ID']);
        } else {
            foreach ($stores as $store) {
                $post_id = wp_insert_post(
                    array(
                        'post_status' => 'publish',
                        'post_title' => $store['store_name'],
                        'post_type' => 'Stores',
                    )
                );
                $store['ID'] = $post_id;
                +
                $this->save(new UploadAdapter($store));
            }
            return $this->getById($post_id);
        }
    }

}
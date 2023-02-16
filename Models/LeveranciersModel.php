<?php

namespace joey\uploader\Models;

use joey\uploader\Adapter\LeverancierAdapter;
use joey\uploader\Functions\MetaDataFunc;

class LeveranciersModel
{
    private const META_KEYS = array(
        'leverancier_name' => 'getNaam',
        'leverancier_specialiteit' => 'getSpecialiteit',
    );


    public function getById($post_id): LeverancierAdapter
    {
        return new LeverancierAdapter(MetaDataFunc::getMetaData($post_id));
    }

    public function save(LeverancierAdapter $leverancier): LeverancierAdapter
    {
        wp_update_post(array(
            'ID' => $leverancier->getId(),
            'post_status' => 'publish',
            'post_title' => $leverancier->getNaam(),
            'post_type' => 'Leveranciers'
        ));
        foreach (array_keys(self::META_KEYS) as $key) {
            update_post_meta($leverancier->getId(), $key, $leverancier->{self::META_KEYS[$key]}());
        }
        return $this->getById($leverancier->getId());
    }
}
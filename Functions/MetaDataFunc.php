<?php

namespace joey\uploader\Functions;

class MetaDataFunc
{
    static function getMetaData($post_id): array
    {
        $post_metas = get_post_meta($post_id, '', true);
        $post_metas = array_combine(
            array_keys($post_metas),
            array_column($post_metas, '0')
        );

        $post_metas['ID'] = $post_id;
        return $post_metas;

    }
}
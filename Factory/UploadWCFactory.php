<?php

namespace joey\uploader\Factory;

use joey\uploader\Adapter\UploadAdapter;
use joey\uploader\Models\UploadModel;

class UploadWCFactory
{
    public static function create($item): UploadAdapter
    {
        return (new UploadModel())->bulkSave($item);
    }

}
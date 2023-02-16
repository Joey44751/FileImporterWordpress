<?php

namespace joey\uploader\Functions;

use joey\uploader\Factory\UploadWCFactory;
use joey\uploader\Handler\csvHandler;
use joey\uploader\Handler\jsonHandler;
use joey\uploader\Handler\xmlHandler;

class UploadHandler
{
    public static function handle_gform_data($entry): void
    {
        $file_url = $entry[1];
        $split_url = explode('.', $file_url);
        switch ($split_url[2]) {
            case 'csv':
                new csvHandler(new UploadWCFactory(), $file_url);
                break;
            case 'xml':
                new xmlHandler(new UploadWCFactory(), $file_url);
                break;
            case 'json':
                new jsonHandler(new UploadWCFactory(), $file_url);
                break;

        }
    }

}
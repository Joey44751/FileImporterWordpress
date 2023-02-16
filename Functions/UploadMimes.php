<?php

namespace joey\uploader\Functions;

class UploadMimes
{
    static function add_upload_types($mimes)
    {
        $mimes['json'] = 'application/json';
        $mimes['xml'] = 'text/xml';
        return $mimes;
    }

}
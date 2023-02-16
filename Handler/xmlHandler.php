<?php

namespace joey\uploader\Handler;

use joey\uploader\Adapter\UploadAdapter;
use joey\uploader\Factory\UploadWCFactory;
use joey\uploader\Interface\UploadHandlerInterface;

class xmlHandler implements UploadHandlerInterface
{
    private UploadAdapter $data;

    public function __construct(UploadWCFactory $fac, string $file_url)
    {
        $file_content = file_get_contents($file_url);
        $this->data = $fac::create($this->setData($file_content));
    }

    function setData($file): array
    {
        $xml = simplexml_load_string($file);
        $json_xml = json_encode($xml);
        $json_decode = json_decode($json_xml, true);
        return $json_decode['row'];
    }

    function getData(): UploadAdapter
    {
        return $this->data;
    }
}
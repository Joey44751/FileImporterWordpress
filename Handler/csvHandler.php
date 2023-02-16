<?php

namespace joey\uploader\Handler;

use joey\uploader\Adapter\UploadAdapter;
use joey\uploader\Factory\UploadWCFactory;
use joey\uploader\Interface\UploadHandlerInterface;
use ParseCsv\Csv;

class csvHandler implements UploadHandlerInterface
{
    private $data;

    public function __construct(UploadWCFactory $fac, string $file_url)
    {
        $file_content = file_get_contents($file_url);
        $this->data = $fac::create($this->setData($file_content));

    }

    function setData($file): array
    {
        $csv = new Csv();
        $csv->auto($file);
        return $csv->data;
    }

    function getData(): UploadAdapter
    {
        return $this->data;
    }
}
<?php

namespace joey\uploader\Interface;

use joey\uploader\Adapter\UploadAdapter;

interface UploadHandlerInterface
{
    function setData($file): array;

    function getData(): UploadAdapter;

}
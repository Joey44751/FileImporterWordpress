<?php

namespace joey\uploader\Factory;

use joey\uploader\Adapter\LeverancierAdapter;
use joey\uploader\Models\LeveranciersModel;

class LeverancierFactory
{
    public static function create($item): LeverancierAdapter
    {
        return (new LeveranciersModel())->save(new LeverancierAdapter($item));
    }
}


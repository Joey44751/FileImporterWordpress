<?php

namespace joey\uploader\Adapter;

use joey\uploader\Interface\LeverancierInterface;

class LeverancierAdapter implements LeverancierInterface
{

    public function __construct(private array $leverancier)
    {
        if (!array_key_exists('leverancier_name', $this->leverancier)) {
            $this->leverancier = array(
                'ID' => $this->leverancier['ID'],
                'leverancier_name' => '',
                'leverancier_specialiteit' => '',
            );
        }
    }

    function getId(): int
    {
        return $this->leverancier['ID'];
    }

    function getNaam(): string
    {
        return $this->leverancier['leverancier_name'];
    }

    function getSpecialiteit(): string
    {
        return $this->leverancier['leverancier_specialiteit'];
    }
}
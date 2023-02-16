<?php

namespace joey\uploader\Interface;

interface UploadInterface
{
    public function getId(): int;

    public function getStoreName(): string;

    public function getStreet(): string;

    public function getHouseNumber(): string;

    public function getPostalCode(): string;

    public function getCity();
}
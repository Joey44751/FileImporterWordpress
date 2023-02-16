<?php

namespace joey\uploader\Interface;

interface LeverancierInterface
{
    function getId(): int;

    function getNaam(): string;

    function getSpecialiteit(): string;

}
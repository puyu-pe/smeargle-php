<?php

namespace PuyuPe\Smeargle\styles;

enum SmgScale: string
{
    case SMOOTH = "SMOOTH";
    case DEFAULT = "DEFAULT";
    case FAST = "FAST";
    case REPLICATE = "REPLICATE";
    case AREA_AVERAGING = "AREA_AVERAGING";

    public function getValue(): string
    {
        return $this->value;
    }

}


<?php

namespace PuyuPe\Smeargle\blocks\qr;

enum SmgQrErrorLevel: string
{
    //25%
    case Q = "Q";
    //7%
    case L = "L";
    //15%
    case M = "M";
    //30%
    case H = "H";

    public function getValue(): string
    {
        return $this->value;
    }

}

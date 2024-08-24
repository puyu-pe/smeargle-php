<?php

namespace PuyuPe\Smeargle\blocks\qr;

enum SmgQrType: string
{
    case IMG = "IMG";
    case NATIVE = "NATIVE";

    public function getValue(): string
    {
        return $this->value;
    }
}

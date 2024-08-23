<?php

namespace PuyuPe\Smeargle\properties;

enum SmgCutMode: string
{
    case FULL = 'FULL';
    case PART = 'PART';

    public function getValue(): string
    {
        return $this->value;
    }

}

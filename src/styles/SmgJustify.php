<?php

namespace PuyuPe\Smeargle\styles;

enum SmgJustify: string
{
    case CENTER = "CENTER";
    case LEFT = "LEFT";
    case RIGHT = "RIGHT";

    public function getValue(): string
    {
        return $this->value;
    }

}


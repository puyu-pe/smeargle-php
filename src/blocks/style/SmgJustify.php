<?php

namespace PuyuPe\Smeargle\blocks\style;

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


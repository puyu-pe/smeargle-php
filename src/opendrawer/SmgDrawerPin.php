<?php
namespace PuyuPe\Smeargle\opendrawer;

enum SmgDrawerPin: int
{
    case _2 = 2;
    case _5 = 5;

    public function getValue(): string
    {
        return $this->value;
    }

}

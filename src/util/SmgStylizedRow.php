<?php

namespace PuyuPe\Smeargle\util;

use PuyuPe\Smeargle\blocks\text\SmgRow;
use PuyuPe\Smeargle\styles\SmgMapStyles;
use PuyuPe\Smeargle\styles\SmgStyle;

class SmgStylizedRow
{
    private SmgRow $row;
    private SmgMapStyles $styles;

    public function __construct()
    {
        $this->row = new SmgRow();
        $this->styles = new SmgMapStyles();
    }

    public static function build(): SmgStylizedRow
    {
        return new SmgStylizedRow();
    }

    public function add(string $text, SmgStyle $style): self
    {
        $class = $style->uniqueClassName();
        $this->row->add($text, $class);
        $this->styles->setIfNotExists($class, $style);
        return $this;
    }

    public function getStyles(): SmgMapStyles
    {
        return $this->styles;
    }

    public function getData(): SmgRow
    {
        return $this->row;
    }
}

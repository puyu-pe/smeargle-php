<?php

namespace PuyuPe\Smeargle\blocks\text;

use PuyuPe\Smeargle\blocks\style\SmgMapStyles;
use PuyuPe\Smeargle\blocks\style\SmgStyle;

class SmgTextBlockConfig
{
    private array $object;
    private SmgMapStyles $styles;

    private function __construct()
    {
        $this->object = [];
        $this->styles = new SmgMapStyles();
    }

    public function separator(string $char): self
    {
        if (isset($char[0])) {
            $this->object["separator"] = $char[0];
        }
        return $this;
    }

    public function styleForColumn(int $index, SmgStyle $style): self
    {
        $this->styles->setIfNotExists($index, $style);
        return $this;
    }

    public function styleForClass(string $class, SmgStyle $style): self
    {
        $this->styles->setIfNotExists($class, $style);
        return $this;
    }

    public function styles(SmgMapStyles $styles): self
    {
        $this->styles = $this->styles->merge($styles);
        return $this;
    }

    public function getStyles(): SmgMapStyles
    {
        return $this->styles;
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) return null;
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

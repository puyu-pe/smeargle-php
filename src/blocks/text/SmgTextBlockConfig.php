<?php

namespace PuyuPe\Smeargle\blocks\text;

use PuyuPe\Smeargle\blocks\style\SmgMapStyles;

class SmgTextBlockConfig
{
    private array $object;
    private SmgMapStyles $styles;

    private function __construct()
    {
        $this->object = [];
        $this->styles = new SmgMapStyles();
    }

    public static function instance(): SmgTextBlockConfig
    {
        return new SmgTextBlockConfig();
    }

    public function gap(int $gap): self
    {
        $this->object["gap"] = max($gap, 0);
        return $this;
    }

    public function separator(string $char): self
    {
        if (isset($char[0])) {
            $this->object["separator"] = $char[0];
        }
        return $this;
    }

    public function nColumns(int $nColumns): self
    {
        $this->object["nColumns"] = max($nColumns, 0);
        return $this;
    }

    public function styles(SmgMapStyles $styles): self
    {
        $this->styles = SmgMapStyles::copy($styles);
        return $this;
    }

    public function getStyles(): SmgMapStyles
    {
        return $this->styles;
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) return null;
        return json_encode($this->object);
    }

}

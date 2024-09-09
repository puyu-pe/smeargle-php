<?php

namespace PuyuPe\Smeargle\blocks\qr;

use PuyuPe\Smeargle\blocks\SmgBlock;
use PuyuPe\Smeargle\styles\SmgJustify;
use PuyuPe\Smeargle\styles\SmgMapStyles;
use PuyuPe\Smeargle\styles\SmgScale;
use PuyuPe\Smeargle\styles\SmgStyle;

class SmgQrBlock implements SmgBlock
{
    private array $object;
    private SmgStyle $style;

    private function __construct(array $object)
    {
        $this->object = $object;
        $this->style = SmgStyle::builder();
    }

    public static function build(string $data, ?SmgQrConfig $config = null): SmgQrBlock
    {
        $object = [];
        $object["qr"] = ["data" => $data];
        if ($config != null) {
            $configJson = $config->toJson();
            if ($configJson != null) {
                $object["qr"] = array_merge($object["qr"], json_decode($configJson, true));
            }
        }
        return new SmgQrBlock($object);
    }

    public function width(int $width): self
    {
        $this->style->width($width);
        return $this;
    }

    public function height(int $height): self
    {
        $this->style->height($height);
        return $this;
    }

    public function size(int $size): self
    {
        $this->style->width($size);
        $this->style->height($size);
        return $this;
    }

    public function scale(SmgScale $scale): self
    {
        $this->style->scale($scale);
        return $this;
    }

    public function center(): self
    {
        return $this->align(SmgJustify::CENTER);
    }

    public function left(): self
    {
        return $this->align(SmgJustify::LEFT);
    }

    public function right(): self
    {
        return $this->align(SmgJustify::RIGHT);
    }

    public function align(SmgJustify $justify): self
    {
        $this->style->align($justify);
        return $this;
    }

    public function style(SmgStyle $style): self
    {
        $this->style->merge($style);
        return $this;
    }

    public function toJson(): ?string
    {
        $styles = new SmgMapStyles();
        $styles->set('$qr', $this->style);
        if (!$styles->isEmpty()) {
            $this->object["styles"] = json_decode($styles->toJson(), true);
        }
        if (count($this->object) == 0)
            return null;
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }
}

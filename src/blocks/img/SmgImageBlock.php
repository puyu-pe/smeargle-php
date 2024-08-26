<?php

namespace PuyuPe\Smeargle\blocks\img;

use PuyuPe\Smeargle\blocks\SmgBlock;
use PuyuPe\Smeargle\blocks\style\SmgJustify;
use PuyuPe\Smeargle\blocks\style\SmgMapStyles;
use PuyuPe\Smeargle\blocks\style\SmgScale;
use PuyuPe\Smeargle\blocks\style\SmgStyle;

class SmgImageBlock implements SmgBlock
{
    private array $object;
    private SmgStyle $style;

    private function __construct()
    {
        $this->object = [];
        $this->style = SmgStyle::builder();
    }

    public static function build(string $imgPath): SmgImageBlock
    {
        $imageBlock = new SmgImageBlock();
        $imageBlock->object["imgPath"] = $imgPath;
        return $imageBlock;
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
        $styles->set('$img', $this->style);
        if (!$styles->isEmpty()) {
            $this->object["styles"] = json_decode($styles->toJson(), true);
        }
        if (count($this->object) == 0)
            return null;
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

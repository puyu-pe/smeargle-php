<?php

namespace PuyuPe\Smeargle\blocks\style;

class SmgStyle
{
    private array $object;

    private function __construct()
    {
        $this->object = [];
    }

    public static function builder(): SmgStyle
    {
        return new SmgStyle();
    }

    public static function copy(SmgStyle $style): SmgStyle
    {
        $newStyle = new SmgStyle();
        $newStyle->object = json_decode($style->toJson(), true);
        return $newStyle;
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) {
            return null;
        }
        return json_encode($this->object);
    }

    public function fontWidth(int $fontWidth): self
    {
        $this->object["fontWidth"] = min(max($fontWidth, 1), 7);
        return $this;
    }

    public function fontHeight(int $fontHeight): self
    {
        $this->object["fontHeight"] = min(max($fontHeight, 1), 7);
        return $this;
    }

    public function fontSize(int $fontSize): self
    {
        $this->fontWidth($fontSize);
        $this->fontHeight($fontSize);
        return $this;
    }

    public function bold(bool $bold = true): self
    {
        $this->object["bold"] = $bold;
        return $this;
    }

    public function normalize(bool $normalize = true): self
    {
        $this->object["normalize"] = $normalize;
        return $this;
    }

    public function bgInverted(bool $bgInverted = true): self
    {
        $this->object["bgInverted"] = $bgInverted;
        return $this;
    }

    public function pad(string $char): self
    {
        if (isset($char[0])) {
            $this->object["pad"] = $char[0];
        }
        return $this;
    }

    public function align(SmgJustify $justify): self
    {
        $this->object["align"] = $justify;
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

    public function span(int $span): self
    {
        $this->object["span"] = max($span, 0);
        return $this;
    }

    public function maxSpan(): self
    {
        return $this->span(1000);
    }

    public function scale(SmgScale $scale): self
    {
        $this->object["scale"] = $scale->getValue();
        return $this;
    }

    public function width(int $width): self
    {
        $this->object["width"] = max($width, 0);
        return $this;
    }

    public function height(int $height): self
    {
        $this->object["height"] = max($height, 0);
        return $this;
    }
}

<?php

namespace PuyuPe\Smeargle\styles;

class SmgStyle
{
    private array $object;

    private function __construct()
    {
        $this->object = [];
    }

    public function reset(array $object = []): self
    {
        $this->object = $object;
        return $this;
    }

    public function uniqueClassName(): string
    {
        ksort($this->object);
        $className = "";
        foreach ($this->object as $key => $value) {
            $className .= $key . "=" . $value . "|";
        }
        return $className;
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

    public function ifThen(bool $condition, SmgStyle $style): self
    {
        if ($condition) {
            $this->merge($style);
        }
        return $this;
    }

    public function ifElse(bool $condition, SmgStyle $trueStyle, SmgStyle $falseStyle): self
    {
        if ($condition) {
            $this->merge($trueStyle);
        } else {
            $this->merge($falseStyle);
        }
        return $this;
    }

    public function merge(SmgStyle $parentStyle): self
    {
        $this->object = array_merge($this->object, $parentStyle->object);
        return $this;
    }

    public function isEmpty(): bool
    {
        return count($this->object) == 0;
    }

    public function toJson(): string
    {
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

    public function fontWidth(?int $value): self
    {
        if ($value !== null) {
            $this->object["fontWidth"] = min(max($value, 1), 7);
        }
        return $this;
    }

    public function fontHeight(?int $value): self
    {
        if ($value !== null) {
            $this->object["fontHeight"] = min(max($value, 1), 7);
        }
        return $this;
    }

    public function fontSize(?int $value): self
    {
        $this->fontWidth($value);
        $this->fontHeight($value);
        return $this;
    }

    public function bold(?bool $value = true): self
    {
        if ($value !== null) {
            $this->object["bold"] = $value;
        }
        return $this;
    }

    public function normalize(?bool $value = true): self
    {
        if ($value !== null) {
            $this->object["normalize"] = $value;
        }
        return $this;
    }

    public function bgInverted(?bool $value = true): self
    {
        if ($value !== null) {
            $this->object["bgInverted"] = $value;
        }
        return $this;
    }

    public function pad(?string $char): self
    {
        if ($char !== null && isset($char[0])) {
            $this->object["pad"] = $char[0];
        }
        return $this;
    }

    public function align(?SmgJustify $justify): self
    {
        if ($justify !== null) {
            $this->object["align"] = $justify->getValue();
        }
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

    public function charxels(?int $value): self
    {
        if ($value !== null) {
            $this->object["charxels"] = max($value, 0);
        }
        return $this;
    }

    public function scale(?SmgScale $value): self
    {
        if ($value !== null) {
            $this->object["scale"] = $value->getValue();
        }
        return $this;
    }

    public function width(?int $value): self
    {
        if ($value !== null) {
            $this->object["width"] = max($value, 0);
        }
        return $this;
    }

    public function height(?int $value): self
    {
        if ($value !== null) {
            $this->object["height"] = max($value, 0);
        }
        return $this;
    }

    public function size(?int $value): self
    {
        $this->width($value);
        $this->height($value);
        return $this;
    }

    public function charCode(?string $value): self
    {
        if($value !== null){
            $this->object["charCode"] = $value;
        }
        return $this;
    }
}

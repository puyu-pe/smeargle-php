<?php

namespace PuyuPe\Smeargle\blocks\text;

use PuyuPe\Smeargle\blocks\style\SmgStyle;

class SmgCell
{
    private array $object;
    private SmgStyle $style;

    public function __construct(string $value, null|string|SmgStyle $style = null)
    {
        $this->object = [];
        $this->style = SmgStyle::builder();
        $this->text($value);
        $this->style($style);
    }

    public function text(string $value): self
    {
        $this->object["text"] = $value;
        return $this;
    }

    public function style(string|SmgStyle|null $style): self
    {
        if ($style != null) {
            if (!is_string($style)) {
                $this->object["class"] = $style->uniqueClassName();
                $this->style = SmgStyle::copy($style);
            } else {
                $this->object["class"] = $style;
            }
        }
        return $this;
    }

    public function getStyle(): SmgStyle
    {
        return SmgStyle::copy($this->style);
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0 ) {
            return null;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

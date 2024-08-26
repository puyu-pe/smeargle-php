<?php

namespace PuyuPe\Smeargle\blocks\text;

class SmgCell
{
    private string|int $value;
    private ?string $class;

    public function __construct(string|int $value, ?string $class = null)
    {
        $this->value = $value;
        $this->class = $class;
    }

    public function toJson(): ?string
    {
        $cell = [];
        $cell["text"] = $this->value;
        if ($this->class != null) {
            $cell["class"] = $this->class;
        }
        return json_encode($cell, JSON_UNESCAPED_UNICODE);
    }

}

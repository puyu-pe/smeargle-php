<?php

namespace PuyuPe\Smeargle\blocks\text;

use PuyuPe\Smeargle\blocks\style\SmgStyle;

class SmgCell
{
    private array $object;

    public function __construct(string $text, ?string $class = null)
    {
        $this->object = [];
        $this->object["text"] = $text;
        if (trim($class) !== "") {
            $this->object["class"] = $text;
        }
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) {
            return null;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

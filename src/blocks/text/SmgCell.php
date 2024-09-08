<?php

namespace PuyuPe\Smeargle\blocks\text;

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

    public static function new(string $text, ?string $class = null): SmgCell
    {
        return new SmgCell($text, $class);
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) {
            return null;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

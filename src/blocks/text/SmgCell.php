<?php

namespace PuyuPe\Smeargle\blocks\text;

class SmgCell
{
    private array $object;

    public function __construct(string $text, ?string $class = null)
    {
        $this->object = [];
        $this->object["text"] = $text;
        if ($class != null && trim($class) !== "") {
            $this->object["class"] = $class;
        }
    }

    public static function build(string $text, ?string $class = null): SmgCell
    {
        return new SmgCell(trim($text), $class);
    }

    public function toJson(): string
    {
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

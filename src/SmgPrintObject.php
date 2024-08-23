<?php

namespace PuyuPe\Smeargle;

use PuyuPe\Smeargle\blocks\SmgBlock;

class SmgPrintObject
{
    private array $object;
    private array $data;

    private function __construct(array $object)
    {
        $this->object = $object;
        $this->data = [];
    }

    public static function build(?SmgPrintObjectConfig $config = null): SmgPrintObject
    {
        $object = [];
        if ($config != null) {
            $configJson = $config->toJson();
            if ($configJson != null) {
                $object = json_decode($configJson, true);
            }
        }
        return new SmgPrintObject($object);
    }

    public function block(SmgBlock $block): self
    {
        $blockJson = $block->toJson();
        if ($blockJson != null) {
            $this->data[] = json_decode($blockJson, true);
        }
        return $this;
    }

    public function text(string $text): self
    {
        $this->data[] = $text;
        return $this;
    }

    public function toJson(): string
    {
        if (count($this->data) > 0) {
            $this->object["data"] = $this->data;
        }
        return json_encode($this->object);
    }
}




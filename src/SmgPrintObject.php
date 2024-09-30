<?php

namespace PuyuPe\Smeargle;

use PuyuPe\Smeargle\blocks\SmgBlock;
use PuyuPe\Smeargle\opendrawer\SmgDrawer;
use PuyuPe\Smeargle\properties\SmgProperties;
use PuyuPe\Smeargle\styles\SmgMapStyles;

class SmgPrintObject
{
    private array $object;
    private array $data;
    private array $metadata;

    private function __construct()
    {
        $this->object = [];
        $this->data = [];
        $this->metadata = [];
    }

    public function setProperties(SmgProperties $properties): self
    {
        $jsonProperties = $properties->toJson();
        if ($jsonProperties != null) {
            $this->object["properties"] = json_decode($jsonProperties, true);
        }
        return $this;
    }

    public function addInfo(string $key, $value): self
    {
        $this->metadata[$key] = $value;
        return $this;
    }

    public static function builder(): SmgPrintObject
    {
        return new SmgPrintObject();
    }

    public function addBlock(SmgBlock $block): self
    {
        $this->data[] = json_decode($block->toJson(), true);
        return $this;
    }

    public function addText(string $text): self
    {
        $this->data[] = $text;
        return $this;
    }

    public function openDrawer(SmgDrawer|bool $openDrawer = true): self
    {
        if (is_bool($openDrawer)) {
            $this->object["openDrawer"] = $openDrawer;
        } else {
            $this->object["openDrawer"] = json_decode($openDrawer->toJson(), true);
        }
        return $this;
    }

    public function setStyles(SmgMapStyles $styles): self
    {
        if (!$styles->isEmpty()) {
            $this->object["styles"] = json_decode($styles->toJson(), true);
        }
        return $this;
    }

    public function toJson(): string
    {
        if (count($this->data) > 0) {
            $this->object["data"] = $this->data;
        }
        $this->object = array_merge($this->metadata, $this->object);
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }
}

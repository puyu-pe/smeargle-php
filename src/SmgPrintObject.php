<?php

namespace PuyuPe\Smeargle;

use PuyuPe\Smeargle\blocks\SmgBlock;
use PuyuPe\Smeargle\opendrawer\SmgDrawer;
use PuyuPe\Smeargle\styles\SmgMapStyles;

class SmgPrintObject
{
    private array $object;
    private array $data;
    private SmgMapStyles $styles;
    private array $metadata;

    private function __construct()
    {
        $this->object = [];
        $this->data = [];
        $this->styles = new SmgMapStyles();
        $this->metadata = [];
    }

    public function addInfo(string $key, $value): self
    {
        $this->metadata[$key] = $value;
        return $this;
    }

    public static function build(): SmgPrintObject
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
            if ($openDrawer) {
                $this->object["openDrawer"] = [];
            } else {
                unset($this->object["openDrawer"]);
            }
        } else {
            $this->object["openDrawer"] = json_decode($openDrawer->toJson(), true);
        }
        return $this;
    }

    public function addStyles(SmgMapStyles $styles): self
    {
        $this->styles->merge($styles);
        return $this;
    }

    public function getStyles(): SmgMapStyles
    {
        return $this->styles;
    }

    public function toJson(): string
    {
        if (count($this->data) > 0) {
            $this->object["data"] = $this->data;
        }
        if (!$this->styles->isEmpty()) {
            $this->object["styles"] = json_decode($this->styles->toJson(), true);
        }
        $this->object = array_merge($this->metadata, $this->object);
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }
}




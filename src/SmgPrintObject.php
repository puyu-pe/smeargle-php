<?php

namespace PuyuPe\Smeargle;

use PuyuPe\Smeargle\blocks\SmgBlock;
use PuyuPe\Smeargle\opendrawer\SmgDrawer;
use PuyuPe\Smeargle\opendrawer\SmgDrawerPin;

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

    public function openDrawer(SmgDrawer|bool $openDrawer = true): self
    {
        if (is_bool($openDrawer)) {
            if ($openDrawer) {
                $drawer = SmgDrawer::builder()->pin(SmgDrawerPin::_2);
                $this->object["openDrawer"] = json_decode($drawer->toJson(), true);
            } else {
                unset($this->object["openDrawer"]);
            }
        } else {
            $this->object["openDrawer"] = json_decode($openDrawer->toJson(), true);
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
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }
}




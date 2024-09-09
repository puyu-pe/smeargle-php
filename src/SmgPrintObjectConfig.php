<?php

namespace PuyuPe\Smeargle;

use PuyuPe\Smeargle\opendrawer\SmgDrawer;
use PuyuPe\Smeargle\opendrawer\SmgDrawerPin;
use PuyuPe\Smeargle\properties\SmgCutProperty;
use PuyuPe\Smeargle\properties\SmgProperties;

class SmgPrintObjectConfig
{
    private array $object;
    private array $metadata;
    private SmgProperties $properties;

    private function __construct()
    {
        $this->metadata = [];
        $this->object = [];
        $this->properties = SmgProperties::builder();
    }

    public static function instance(): SmgPrintObjectConfig
    {
        return new SmgPrintObjectConfig();
    }

    public function info(string $key, array|string $value): self
    {
        $this->metadata[$key] = $value;
        return $this;
    }

    public function blockWidth(int $blockWidth): self
    {
        $this->properties->setBlockWidth($blockWidth);
        return $this;
    }

    public function normalize(bool $normalize = true): self
    {
        $this->properties->normalize($normalize);
        return $this;
    }

    public function charCode(string $charCode): self
    {
        $this->properties->charCode($charCode);
        return $this;
    }

    public function cut(SmgCutProperty $cutProperty): self
    {
        $this->properties->setCut($cutProperty);
        return $this;
    }

    public function properties(SmgProperties $properties): self
    {
        $this->properties->merge($properties);
        return $this;
    }

    public function toJson(): ?string
    {
        if (!$this->properties->isEmpty()) {
            $this->object["properties"] = json_decode($this->properties->toJson(), true);
        }
        $this->object = array_merge($this->metadata, $this->object);
        if (count($this->object) == 0) return null;
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }
}

<?php

namespace PuyuPe\Smeargle\properties;

class SmgProperties
{
    private array $object;

    private function __construct()
    {
        $this->object = [];
    }

    public static function builder(): SmgProperties
    {
        return new SmgProperties();
    }

    public function merge(SmgProperties $otherProperties): self
    {
        $this->object = array_merge($this->object, $otherProperties->object);
        return $this;
    }

    public function blockWidth(int $blockWidth): self
    {
        $this->object["blockWidth"] = max(0, $blockWidth);
        return $this;
    }

    public function normalize(bool $normalize = true): self
    {
        $this->object["normalize"] = $normalize;
        return $this;
    }

    public function charCode(string $charCode): self
    {
        $this->object["charCode"] = $charCode;
        return $this;
    }

    public function cut(SmgCutProperty $cutProperty): self
    {
        $cut = $cutProperty->toJson();
        if ($cut != null) {
            $this->object["cut"] = json_decode($cutProperty->toJson(), true);
        }
        return $this;
    }

    public function isEmpty(): bool
    {
        return count($this->object) == 0;
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) {
            return null;
        }
        return json_encode($this->object);
    }


}

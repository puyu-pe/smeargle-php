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

    public function setBlockWidth(int $charxels): self
    {
        $this->object["blockWidth"] = max(0, $charxels);
        return $this;
    }

    public function setCut(SmgCutProperty $cutProperty): self
    {
        $cut = $cutProperty->toJson();
        if ($cut !== null) {
            $this->object["cut"] = json_decode($cutProperty->toJson(), true);
        }
        return $this;
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) {
            return null;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

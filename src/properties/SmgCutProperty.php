<?php

namespace PuyuPe\Smeargle\properties;

class SmgCutProperty
{
    private array $object;

    private function __construct()
    {
        $this->object = [];
    }

    public static function builder(): SmgCutProperty{
        return new SmgCutProperty();
    }

    public function feed(int $feed): self
    {
        $this->object["feed"] = min(max($feed, 1), 255);
        return $this;
    }

    public function mode(SmgCutMode $mode): self{
        $this->object["mode"] = $mode->getValue();
        return $this;
    }

    public function toJson(): ?string
    {
        if(count($this->object) == 0)
            return null;
        return json_encode($this->object);
    }
}

<?php

namespace PuyuPe\Smeargle\opendrawer;

class SmgDrawer
{
    private array $object;

    private function __construct()
    {
        $this->object = [];
    }

    public static function builder(): SmgDrawer{
        return new SmgDrawer();
    }

    public function pin(SmgDrawerPin $pin): self
    {
        $this->object["pin"] = $pin->getValue();
        return $this;
    }

    public function t1(int $t1): self
    {
        $this->object["t1"] = min(max($t1, 0), 255);
        return $this;
    }

    public function t2(int $t2): self
    {
        $this->object["t2"] = min(max($t2, 0), 255);
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

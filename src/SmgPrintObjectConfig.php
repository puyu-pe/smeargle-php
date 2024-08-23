<?php

namespace PuyuPe\Smeargle;

use PuyuPe\Smeargle\opendrawer\SmgDrawer;
use PuyuPe\Smeargle\opendrawer\SmgDrawerPin;
use PuyuPe\Smeargle\properties\SmgProperties;

class SmgPrintObjectConfig
{
    private array $object;

    private function __construct()
    {
        $this->object = [];
    }

    public function properties(SmgProperties $properties): self
    {
        $propertiesObj = $properties->toJson();
        if ($propertiesObj != null) {
            $this->object["properties"] = json_decode($propertiesObj, true);
        }
        return $this;
    }

    public static function instance(): SmgPrintObjectConfig
    {
        return new SmgPrintObjectConfig();
    }

    public function openDrawer(?SmgDrawer $openDrawer = null): self
    {
        $drawer = $openDrawer ?? SmgDrawer::builder()->pin(SmgDrawerPin::_2);
        $this->object["openDrawer"] = json_decode($drawer->toJson(), true);
        return $this;
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) return null;
        return json_encode($this->object);
    }
}

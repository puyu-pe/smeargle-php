<?php

namespace PuyuPe\Smeargle\blocks\qr;

use PuyuPe\Smeargle\blocks\SmgBlock;

class SmgQrBlock implements SmgBlock
{
    private array $object;
    private array $qrObject;

    private function __construct()
    {
        $this->object = ["type" => "qr"];
        $this->qrObject = [];
    }

    public static function builder(): SmgQrBlock
    {
        return new SmgQrBlock();
    }

    public function setData(string $stringData): self
    {
        $this->qrObject["data"] = $stringData;
        return $this;
    }

    public function setClass(string $class): self
    {
        $this->qrObject["class"] = $class;
        return $this;
    }

    public function setCorrectionLevel(SmgQrErrorLevel $level): self
    {
        $this->qrObject["correctionLevel"] = $level->getValue();
        return $this;
    }

    public function setQrType(SmgQrType $type): self
    {
        $this->qrObject["type"] = $type->getValue();
        return $this;
    }

    public function toJson(): string
    {
        if (count($this->qrObject) != 0) {
            $this->object["qr"] = $this->qrObject;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }
}

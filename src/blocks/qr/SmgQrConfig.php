<?php

namespace PuyuPe\Smeargle\blocks\qr;

class SmgQrConfig
{
    private array $object;

    public static function instance(): SmgQrConfig
    {
        return new SmgQrConfig();
    }

    public function type(SmgQrType $type): self
    {
        $this->object["type"] = $type->getValue();
        return $this;
    }

    public function errorLevel(SmgQrErrorLevel $level): self
    {
        $this->object["correctionLevel"] = $level->getValue();
        return $this;
    }

    public function quartile(): self
    {
        return $this->errorLevel(SmgQrErrorLevel::Q);
    }

    public function high(): self
    {
        return $this->errorLevel(SmgQrErrorLevel::H);
    }

    public function low(): self
    {
        return $this->errorLevel(SmgQrErrorLevel::L);
    }

    public function medium(): self
    {
        return $this->errorLevel(SmgQrErrorLevel::M);
    }

    public function likeImg(): self
    {
        return $this->type(SmgQrType::IMG);
    }

    public function native(): self
    {
        return $this->type(SmgQrType::NATIVE);
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) {
            return null;
        }
        return json_encode($this->object);
    }
}

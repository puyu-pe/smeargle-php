<?php

namespace PuyuPe\Smeargle\styles;

class SmgMapStyles
{
    private array $object;
    private SmgStyle $globalStyle;

    public function __construct()
    {
        $this->object = [];
        $this->globalStyle = SmgStyle::builder();
    }

    public static function builder(): SmgMapStyles
    {
        return new SmgMapStyles();
    }

    public function addGlobalStyle(SmgStyle $style): self
    {
        $this->globalStyle->merge($style);
        return $this;
    }

    public function set(string $class, SmgStyle $style): self
    {
        if (!$style->isEmpty()) {
            $this->object[$class] = json_decode($style->toJson(), true);
        }
        return $this;
    }

    public function get(string $class): ?SmgStyle
    {
        if ($this->has($class)) {
            return SmgStyle::builder()->reset($this->object[$class]);
        }
        return null;
    }

    public function remove(string|int $class): self
    {
        unset($this->object[$class]);
        return $this;
    }

    public function merge(SmgMapStyles $otherStyles): self
    {
        $this->object = array_merge($this->object, $otherStyles->object);
        return $this;
    }

    public function has(string $class): bool
    {
        return array_key_exists($class, $this->object);
    }

    public function setIfNotExists(string $class, SmgStyle $style): self
    {
        if (!$this->has($class)) {
            $this->set($class, $style);
        }
        return $this;
    }

    public function isEmpty(): bool
    {
        return count($this->object) == 0 && $this->globalStyle->isEmpty();
    }

    public function toJson(): string
    {
        if (!$this->globalStyle->isEmpty()) {
            $this->set("*", $this->globalStyle);
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

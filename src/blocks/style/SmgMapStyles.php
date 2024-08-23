<?php

namespace PuyuPe\Smeargle\blocks\style;

class SmgMapStyles
{
    private array $object;

    public function __construct()
    {
        $this->object = [];
    }

    public function set(string|int $class, SmgStyle $style): self
    {
        $jsonStyle = $style->toJson();
        if ($jsonStyle != null) {
            $this->object[$class] = json_decode($jsonStyle ,true);
        }
        return $this;
    }

    public function remove(string|int $class): self
    {
        unset($this->object[$class]);
        return $this;
    }

    public function has(string $class): bool
    {
        return array_key_exists($class, $this->object);
    }

    public static function copy(SmgMapStyles $styles): SmgMapStyles
    {
        $newStyles = new SmgMapStyles();
        $copy = $styles->toJson();
        if ($copy != null) {
            $newStyles->object = json_decode($copy, true);
        }
        return $newStyles;
    }

    public function isEmpty(): bool
    {
        return count($this->object) == 0;
    }

    public function toJson(): ?string
    {
        if ($this->isEmpty()) {
            return null;
        }
        return json_encode($this->object);
    }

}

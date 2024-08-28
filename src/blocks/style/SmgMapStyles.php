<?php

namespace PuyuPe\Smeargle\blocks\style;

class SmgMapStyles
{
    private array $object;

    public function __construct()
    {
        $this->object = [];
    }

    public function set(string|int $classOrIndex, SmgStyle $style): self
    {
        $jsonStyle = $style->toJson();
        if ($jsonStyle != null) {
            $this->object[$classOrIndex] = json_decode($jsonStyle, true);
        }
        return $this;
    }

    public function get(string $class): ?SmgStyle
    {
        if ($this->has($class)) {
            return SmgStyle::builder()->reset(json_decode($this->object[$class], true));
        }
        return null;
    }

    public function getOrCreate(string $class, SmgStyle $default): SmgStyle
    {
        if (!$this->has($class)) {
            $this->set($class, $default);
            return $default;
        } else {
            return $this->get($class) ?? $default;
        }
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

    public function setIfNotExists(string $class, SmgStyle $style): self
    {
        if (!$this->has($class)) {
            $this->set($class, $style);
        }
        return $this;
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

    public function merge(SmgMapStyles $otherStyles): self
    {
        $this->object = array_merge($this->object, $otherStyles->object);
        return $this;
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
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

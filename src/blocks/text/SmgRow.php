<?php

namespace PuyuPe\Smeargle\blocks\text;

class SmgRow
{
    private array $row;

    public function __construct()
    {
        $this->row = [];
    }

    public static function build(): SmgRow{
        return new SmgRow();
    }

    public function add(string $text, ?string $class = null): self
    {
        $cell = SmgCell::build($text, $class);
        $this->row[] = json_decode($cell->toJson(), true);
        return $this;
    }

    public function isEmpty(): bool
    {
        return $this->size() == 0;
    }

    public function size(): int
    {
        return count($this->row);
    }

    public function toJson(): string
    {
        return json_encode($this->row, JSON_UNESCAPED_UNICODE);
    }
}

<?php

namespace PuyuPe\Smeargle\blocks\text;

class SmgRow
{
    private array $array;

    /**
     * @param string[] $row
     */
    public function __construct(string $class, array $row = [])
    {
        $this->array = [];
        for ($i = 0; $i < count($row); ++$i) {
            $this->add($row[$i], $class);
        }
    }

    public function add(string $text, ?string $class = null): self
    {
        $cell = new SmgCell($text, $class);
        $this->array[] = json_decode($cell->toJson(), true);
        return $this;
    }

    public function toJson(): ?string
    {
        if (count($this->array) == 0) {
            return null;
        }
        return json_encode($this->array, JSON_UNESCAPED_UNICODE);
    }
}

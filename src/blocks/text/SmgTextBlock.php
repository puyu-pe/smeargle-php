<?php

namespace PuyuPe\Smeargle\blocks\text;

use PuyuPe\Smeargle\blocks\SmgBlock;

class SmgTextBlock implements SmgBlock
{
    protected array $object;
    protected array $rows;

    private function __construct(?string $separator = null)
    {
        $this->object = ["type" => "text"];
        $this->rows = [];
        if ($separator !== null && trim($separator) !== "") {
            $this->object["separator"] = $separator;
        }
    }

    public function addText(string $text): self
    {
        $this->rows[] = trim($text);
        return $this;
    }

    public function addRow(SmgRow $row): self
    {
        $this->rows[] = json_decode($row->toJson(), true);
        return $this;
    }

    public function addCell(SmgCell $cell): self
    {
        $this->rows[] = json_decode($cell->toJson(), true);
        return $this;
    }

    public static function builder(?string $separator = null): SmgTextBlock
    {
        return new SmgTextBlock($separator);
    }

    public function isEmpty(): bool
    {
        return count($this->rows) == 0;
    }

    public function toJson(): string
    {
        if (count($this->rows) > 0) {
            $this->object["rows"] = $this->rows;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

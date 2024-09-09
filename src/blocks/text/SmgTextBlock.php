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
        if ($separator != null && trim($separator) !== "") {
            $this->object["separator"] = $separator;
        }
    }

    public function addText(string $text): self
    {
        $this->rows[] = $text;
        return $this;
    }

    /**
     * @param SmgCell[] $cells
     * @return $this
     */
    public function addRow(array $cells): self
    {
        $row = [];
        foreach ($cells as $cell) {
            $row[] = json_decode($cell->toJson(), true);
        }
        $this->rows[] = $row;
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

    public function toJson(): string
    {
        if (count($this->rows) > 0) {
            $this->object["rows"] = $this->rows;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

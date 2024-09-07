<?php

namespace PuyuPe\Smeargle\blocks\text;

use PuyuPe\Smeargle\blocks\style\SmgMapStyles;
use PuyuPe\Smeargle\blocks\style\SmgStyle;

class SmgRow
{

    private array $object;
    private SmgMapStyles $styles;

    /**
     * @param string[] $row
     */
    public function __construct(array $row = [], SmgStyle|string|null $style = null)
    {
        $this->object = [];
        $this->styles = new SmgMapStyles();
        for ($i = 0; $i < count($row); ++$i) {
            $this->add($row[$i], $style);
        }
    }

    public function add(string $text, SmgStyle|string|null $style = null): self
    {
        $cell = new SmgCell($text);
        if ($style != null) {
            if (!is_string($style)) {
                if (!$style->isEmpty()) {
                    $class = $style->uniqueClassName();
                    $this->styles->setIfNotExists($class, $style);
                    $cell = new SmgCell($text, $class);
                }
            } else {
                $cell = new SmgCell($text, $style); // $style like className
            }
        }
        $this->object[] = json_decode($cell->toJson(), true);
        return $this;
    }

    public function getStyles(): SmgMapStyles
    {
        return $this->styles;
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) {
            return null;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }
}

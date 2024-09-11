<?php

namespace PuyuPe\Smeargle\util;

use PuyuPe\Smeargle\blocks\text\SmgCell;
use PuyuPe\Smeargle\blocks\text\SmgTextBlock;
use PuyuPe\Smeargle\styles\SmgMapStyles;
use PuyuPe\Smeargle\styles\SmgStyle;

class SmgTextLayout
{

    private SmgMapStyles $styles;
    private SmgTextBlock $textBlock;

    private function __construct(?string $separator = null)
    {
        $this->textBlock = SmgTextBlock::builder($separator);
        $this->styles = new SmgMapStyles();
    }

    public static function build(?string $separator = null): SmgTextLayout
    {
        return new SmgTextLayout($separator);
    }

    public function addText(string $text, ?SmgStyle $style = null): self
    {
        if ($style != null) {
            $class = $style->uniqueClassName();
            $this->textBlock->addCell(SmgCell::build($text, $class));
            $this->styles->setIfNotExists($class, $style);
        } else {
            $this->textBlock->addText($text);
        }
        return $this;
    }

    public function addStylizedRow(SmgStylizedRow $row): self
    {
        $this->textBlock->addRow($row->getData());
        $this->styles->merge($row->getStyles());
        return $this;
    }

    public function addLine(string $char = " ", ?SmgStyle $customStyle = null): self
    {
        $lineStyle = Smg::pad($char);
        if ($customStyle != null) {
            $lineStyle = SmgStyle::copy($customStyle)->merge($lineStyle);
        }
        $class = $lineStyle->uniqueClassName();
        $this->textBlock->addCell(SmgCell::build("", $class));
        $this->styles->setIfNotExists($class, $lineStyle);
        return $this;
    }

    public function getStyles(): SmgMapStyles
    {
        return $this->styles;
    }

    public function getBlock(): SmgTextBlock
    {
        return $this->textBlock;
    }
}

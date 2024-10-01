<?php

namespace PuyuPe\Smeargle\util;

use PuyuPe\Smeargle\blocks\img\SmgImageBlock;
use PuyuPe\Smeargle\blocks\qr\SmgQrBlock;
use PuyuPe\Smeargle\opendrawer\SmgDrawer;
use PuyuPe\Smeargle\properties\SmgCutProperty;
use PuyuPe\Smeargle\properties\SmgProperties;
use PuyuPe\Smeargle\SmgPrintObject;
use PuyuPe\Smeargle\styles\SmgMapStyles;
use PuyuPe\Smeargle\styles\SmgStyle;

class SmgTicket
{
    private SmgProperties $properties;
    private SmgMapStyles $styles;
    private SmgPrintObject $printObject;
    private SmgTextLayout $currentLayout;

    public function __construct(?SmgProperties $properties = null, ?SmgMapStyles $styles = null)
    {
        $this->printObject = SmgPrintObject::builder();
        $this->styles = $styles ?? new SmgMapStyles();
        $this->properties = $properties ?? SmgProperties::builder();
        $this->currentLayout = SmgTextLayout::build();
    }

    public static function builder(?SmgProperties $properties = null, ?SmgMapStyles $styles = null): SmgTicket
    {
        return new SmgTicket($properties, $styles);
    }

    public function addInfo(string $key, $value): self
    {
        $this->printObject->addInfo($key, $value);
        return $this;
    }

    public function addText(string $text, ?SmgStyle $style = null): self
    {
        $this->currentLayout->addText($text, $style);
        return $this;
    }

    public function addRow(SmgStylizedRow $row): self
    {
        $this->currentLayout->addStylizedRow($row);
        return $this;
    }

    public function addLine(string $char = " ", ?SmgStyle $customStyle = null): self
    {
        $this->currentLayout->addLine($char, $customStyle);
        return $this;
    }

    public function addTextLayout(SmgTextLayout $layout): self
    {
        $this->dumpLayout();
        $block = $layout->getBlock();
        if (!$block->isEmpty()) {
            $this->printObject->addBlock($block);
            $this->styles->merge($layout->getStyles());
        }
        return $this;
    }

    public function addImage(SmgImageBlock $img, ?SmgStyle $style = null): self
    {
        $this->dumpLayout();
        if ($style !== null) {
            $class = $style->uniqueClassName();
            $img->setClass($class);
            $this->styles->set($class, $style);
        }
        $this->printObject->addBlock($img);
        return $this;
    }

    public function addQrCode(SmgQrBlock $qr, ?SmgStyle $style = null): self
    {
        $this->dumpLayout();
        if ($style !== null) {
            $class = $style->uniqueClassName();
            $qr->setClass($class);
            $this->styles->set($class, $style);
        }
        $this->printObject->addBlock($qr);
        return $this;
    }

    public function openDrawer(SmgDrawer|bool $openDrawer = true): self
    {
        $this->printObject->openDrawer($openDrawer);
        return $this;
    }

    public function dumpLayout(): void
    {
        $block = $this->currentLayout->getBlock();
        if (!$block->isEmpty()) {
            $this->printObject->addBlock($block);
            $this->styles->merge($this->currentLayout->getStyles());
            $this->currentLayout = SmgTextLayout::build();
        }
    }

    public function getPrintObject(): SmgPrintObject
    {
        return $this->printObject;
    }

    public function toJson(): string
    {
        $this->dumpLayout();
        $this->printObject->setStyles($this->styles);
        $this->printObject->setProperties($this->properties);
        return $this->printObject->toJson();
    }
}

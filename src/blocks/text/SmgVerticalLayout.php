<?php

namespace PuyuPe\Smeargle\blocks\text;

use PuyuPe\Smeargle\blocks\SmgBlock;
use PuyuPe\Smeargle\blocks\style\Smg;
use PuyuPe\Smeargle\blocks\style\SmgStyle;

class SmgVerticalLayout implements SmgBlock
{
    private SmgTextBlock $textBlock;

    public function __construct(?SmgTextBlockConfig $config = null)
    {
        $this->textBlock = SmgTextBlock::build($config);
    }

    public static function build(?SmgTextBlockConfig $config = null): SmgVerticalLayout
    {
        return new SmgVerticalLayout($config);
    }

    public function line(?string $char = null, ?SmgStyle $style = null): self
    {
        $this->textBlock->line($char, $style);
        return $this;
    }

    /**
     * @param SmgRow[] $rows
     */
    public function rows(array $rows): self
    {
        foreach ($rows as $row) {
            $this->row($row);
        }
        return $this;
    }

    public function row(SmgRow $row): self
    {
        $this->textBlock->row($row);
        return $this;
    }

    /**
     * @param string[] $row
     */

    public function simpleRow(array $row, SmgStyle|string|null $styleOrClass = null): self
    {
        $row = new SmgRow($row, $styleOrClass);
        $this->textBlock->row($row);
        return $this;
    }

    public function toCenter(string $text, ?SmgStyle $customStyle = null): self
    {
        return $this->custom($text, Smg::center(), $customStyle);
    }

    public function toLeft(string $text, ?SmgStyle $customStyle = null): self
    {
        return $this->custom($text, Smg::left(), $customStyle);
    }

    public function toRight(string $text, ?SmgStyle $customStyle = null): self
    {
        return $this->custom($text, Smg::right(), $customStyle);
    }

    public function title(string $text, ?SmgStyle $customStyle = null): self
    {
        return $this->custom($text, Smg::title(), $customStyle);
    }

    public function subtitle(string $text, ?SmgStyle $customStyle = null): self
    {
        return $this->custom($text, Smg::subtitle(), $customStyle);
    }

    public function custom(string $text, SmgStyle $primaryStyle, ?SmgStyle $secondaryStyle = null): self
    {
        if ($secondaryStyle != null && !$secondaryStyle->isEmpty()) {
            $primaryStyle = SmgStyle::copy($secondaryStyle)->merge($primaryStyle);
        }
        $primaryStyle->maxSpan();
        $class = $primaryStyle->uniqueClassName();
        $this->textBlock->createStyle($class, $primaryStyle);
        $this->textBlock->text($text, $class);
        return $this;
    }

    public function textWithClass(string $text, string $class): self
    {
        $this->textBlock->text($text, $class);
        return $this;
    }

    public
    function toJson(): ?string
    {
        return $this->textBlock->toJson();
    }
}

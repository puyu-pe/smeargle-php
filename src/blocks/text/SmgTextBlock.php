<?php

namespace PuyuPe\Smeargle\blocks\text;

use PuyuPe\Smeargle\blocks\SmgBlock;
use PuyuPe\Smeargle\blocks\style\SmgMapStyles;
use PuyuPe\Smeargle\blocks\style\SmgStyle;

class SmgTextBlock implements SmgBlock
{
    private array $object;
    private array $rows;
    private SmgMapStyles $styles;

    private function __construct(array $object, SmgMapStyles $styles)
    {
        $this->object = $object;
        $this->styles = $styles;
        $this->rows = [];
    }

    public function line(?string $char = null, ?SmgStyle $style = null): self
    {
        if ($char == null) $char = "-";
        if ($style == null) $style = SmgStyle::builder()->fontWidth(1);
        $class = '$line_' . count($this->rows);
        $this->styles->set($class, SmgStyle::copy($style)->pad($char)->span(1000));
        $this->rows[] = json_decode((new SmgCell("", $class))->toJson(), true);
        return $this;
    }

    /**
     * @param string|int[] $texts
     */
    public function texts(array $texts, SmgStyle|string|null $styleOrClass = null): self
    {
        $class = is_string($styleOrClass) ? $styleOrClass : '$text_' . count($this->rows);
        if ($styleOrClass != null && !is_string($styleOrClass)) {
            $this->styles->set($class, $styleOrClass);
        }
        for ($i = 0; $i < count($texts); ++$i) {
            if (is_string($texts[$i]) || is_int($texts[$i])) {
                if ($styleOrClass != null) {
                    $this->rows[] = json_decode((new SmgCell($texts[$i], $class))->toJson(), true);
                } else {
                    $this->rows[] = $texts[$i];
                }
            }
        }
        return $this;
    }

    public function text(string|int $text, SmgStyle|string|null $styleOrClass = null): self
    {
        return $this->texts([$text], $styleOrClass);
    }

    public function row(SmgRow ...$rows): self
    {
        return $this->rows($rows);
    }

    /**
     * @param SmgRow[] $rows
     */
    public function rows(array $rows): self
    {
        for ($i = 0; $i < count($rows); ++$i) {
            $this->rows[] = json_decode($rows[$i]->toJson(), true);
        }
        return $this;
    }

    public static function build(?SmgTextBlockConfig $config = null): SmgTextBlock
    {
        $object = [];
        $styles = new SmgMapStyles();
        if ($config != null) {
            $configJson = $config->toJson();
            if ($configJson != null) {
                $object = json_decode($configJson, true);
            }
            $styles = $config->getStyles();
        }
        return new SmgTextBlock($object, $styles);
    }

    public function toJson(): ?string
    {
        if (count($this->rows) > 0) {
            $this->object["rows"] = $this->rows;
        }
        if (!$this->styles->isEmpty()) {
            $this->object["styles"] = json_decode($this->styles->toJson(), true);
        }
        if (count($this->object) == 0) {
            return null;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }
}

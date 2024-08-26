<?php

namespace PuyuPe\Smeargle\blocks\text;

class SmgRow
{

    private array $object;

    /**
     * @param string[]|int[]|SmgCell[] $values
     */
    public function __construct(array $values = [])
    {
        $this->object = [];
        $this->addAll($values);
    }

    /**
     * @param string[]|int[] $texts
     */
    public function addTextList(array $texts, ?string $class = null): self
    {
        for ($i = 0; $i < count($texts); ++$i) {
            if (is_int($texts[$i]) || is_string($texts[$i])) {
                $this->addText($texts[$i], $class);
            }
        }
        return $this;
    }

    public function addText(string|int $text, ?string $class = null): self
    {
        if ($class != null) {
            $this->object[] = json_decode((new SmgCell($text, $class))->toJson(), true);
        } else {
            $this->object[] = $text;
        }
        return $this;
    }

    public function addCell(SmgCell ...$cells): self
    {
        for ($i = 0; $i < count($cells); ++$i) {
            $this->object[] = json_decode($cells[$i]->toJson(), true);
        }
        return $this;
    }

    /**
     * @param string[]|int[]|SmgCell[] $values
     */
    public function addAll(array $values): self
    {
        for ($i = 0; $i < count($values); ++$i) {
            $this->add($values[$i]);
        }
        return $this;
    }

    public function add(string|int|SmgCell $value): self
    {
        if (is_int($value) || is_string($value)) {
            $this->addText($value);
        } else {
            $this->addCell($value);
        }
        return $this;
    }

    public function toJson(): ?string
    {
        if (count($this->object) == 0) {
            return null;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }
}

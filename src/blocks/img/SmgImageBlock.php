<?php

namespace PuyuPe\Smeargle\blocks\img;

use PuyuPe\Smeargle\blocks\SmgBlock;

class SmgImageBlock implements SmgBlock
{
    private array $object;
    private array $imgObject;

    private function __construct()
    {
        $this->object = ["type" => "img"];
        $this->imgObject = [];
    }

    public static function builder(): SmgImageBlock
    {
        return new SmgImageBlock();
    }

    public function setPath(string $localPath): self
    {
        $this->imgObject["path"] = $localPath;
        return $this;
    }

    public function setClass(string $class): self
    {
        $this->imgObject["class"] = $class;
        return $this;
    }

    public function toJson(): string
    {
        if (count($this->imgObject) != 0) {
            $this->object["img"] = $this->imgObject;
        }
        return json_encode($this->object, JSON_UNESCAPED_UNICODE);
    }

}

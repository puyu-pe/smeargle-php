<?php
require_once __DIR__ . '/vendor/autoload.php';

use PuyuPe\Smeargle\SmgPrintObject;
use PuyuPe\Smeargle\Smg;
use PuyuPe\Smeargle\blocks\text\SmgTextBlock;
use PuyuPe\Smeargle\styles\SmgMapStyles;
use PuyuPe\Smeargle\blocks\text\SmgCell;
use PuyuPe\Smeargle\blocks\img\SmgImageBlock;
use PuyuPe\Smeargle\blocks\qr\SmgQrBlock;

$styles = new SmgMapStyles();
$styles->addGlobalStyle(Smg::normalize(true));
$styles->set("header", Smg::bold());

$text = SmgTextBlock::builder()
    ->addText("hello world")
    ->addRow(SmgCell::build("text", "class1"), "pepe", " column 3");

$img = SmgImageBlock::builder()->setClass('$img')->setPath("/Images/logo.png");

$printObject = SmgPrintObject::build()
    ->setStyles($styles)
    ->setProperties(Smg::blockWidth(48))
    ->addBlock($img)
    ->addBlock($text);


echo json_encode(json_decode($printObject->toJson(), true), JSON_PRETTY_PRINT);

<?php
require_once __DIR__ . '/vendor/autoload.php';

use \PuyuPe\Smeargle\blocks\text\SmgTextBlock;
use \PuyuPe\Smeargle\blocks\text\SmgTextBlockConfig;
use \PuyuPe\Smeargle\blocks\style\SmgStyle;
use \PuyuPe\Smeargle\blocks\style\SmgMapStyles;
use \PuyuPe\Smeargle\blocks\text\SmgRow;
use \PuyuPe\Smeargle\blocks\text\SmgCell;
use \PuyuPe\Smeargle\SmgPrintObjectConfig;
use \PuyuPe\Smeargle\SmgPrintObject;
use \PuyuPe\Smeargle\properties\SmgProperties;
use \PuyuPe\Smeargle\properties\SmgCutProperty;
use \PuyuPe\Smeargle\properties\SmgCutMode;
use \PuyuPe\Smeargle\opendrawer\SmgDrawer;
use \PuyuPe\Smeargle\opendrawer\SmgDrawerPin;
use \PuyuPe\Smeargle\blocks\img\SmgImageBlock;
use \PuyuPe\Smeargle\blocks\style\SmgScale;
use \PuyuPe\Smeargle\blocks\qr\SmgQrBlock;
use \PuyuPe\Smeargle\blocks\qr\SmgQrConfig;

$mapStyles = new SmgMapStyles();
$mapStyles->set("own-style", SmgStyle::builder()->width(255));
$mapStyles->set("mirror-style", SmgStyle::builder()->height(234)->span(2));
$mapStyles->set("class1", SmgStyle::builder()->left()->span(7));
$config = SmgTextBlockConfig::instance()
    ->nColumns(6)
    ->styles($mapStyles)
    ->separator("|");

$style = SmgStyle::builder()->normalize()->bgInverted()->center()->bold();
$row = new SmgRow(["hello", "fddsf", 3, new SmgCell("cell1", "class1")]);
$row->addAll(["add1", 34]);
$textBlock = SmgTextBlock::build($config)
    ->row($row)
    ->text(2, $style)
    ->text("mirror-text", "mirror-style")
    ->line()
    ->line("*");

$imageBlock = SmgImageBlock::build('c:\\lele')
    ->center()
    ->scale(SmgScale::SMOOTH)
    ->style(SmgStyle::builder()->height(255)->width(4040))
    ->size(4)
    ->width(10)
    ->height(20);


$qrConfig = SmgQrConfig::instance()->low()->native();
$qrBlock = SmgQrBlock::build("fdfasfasf")
    ->width(34)
    ->center()
    ->scale(SmgScale::REPLICATE)
    ->height(100);

$openDrawer = SmgDrawer::builder()->pin(SmgDrawerPin::_5)->t1(120)->t2(240);
$cut = SmgCutProperty::builder()->feed(4)->mode(SmgCutMode::PART);
$properties = SmgProperties::builder()->blockWidth(48)->normalize()->cut($cut);

$printer = [
    "name" => "EPSON",
    "type" => "SYSTEM"
];

$printObjectConfig = SmgPrintObjectConfig::instance()
    ->info("times", 1)
    ->info("printer", $printer)
    ->properties($properties)
    ->openDrawer($openDrawer);

$printObject = SmgPrintObject::build($printObjectConfig)
    ->text("hola")
    ->block($textBlock)
    ->block($imageBlock)
    ->block($qrBlock);

echo json_encode(json_decode($printObject->toJson(), true), JSON_PRETTY_PRINT);

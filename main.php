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
use \PuyuPe\Smeargle\properties\SmgCutProperty;
use \PuyuPe\Smeargle\properties\SmgCutMode;
use \PuyuPe\Smeargle\opendrawer\SmgDrawer;
use \PuyuPe\Smeargle\opendrawer\SmgDrawerPin;
use \PuyuPe\Smeargle\blocks\img\SmgImageBlock;
use \PuyuPe\Smeargle\blocks\style\SmgScale;
use \PuyuPe\Smeargle\blocks\qr\SmgQrBlock;
use \PuyuPe\Smeargle\blocks\qr\SmgQrConfig;

$items = [
    ["name" => "leche", "price" => "3.75", "units" => 4],
    ["name" => "arroz", "price" => "5.0", "units" => 1],
    ["name" => "azucar", "price" => "7.00", "units" => 2],
    ["name" => "cafe", "price" => "8.30", "units" => 5],
    ["name" => "gaseosa", "price" => "9.55", "units" => 1]
];
$total = "490.75";

$styles = new SmgMapStyles();
$styles->set(1, SmgStyle::builder()->center());
$styles->set(2, SmgStyle::builder()->right());
$styles->set("title", SmgStyle::builder()->center()->bold()->fontSize(2)->maxSpan());
$styles->set("totalStr", SmgStyle::builder()->right()->maxSpan()->bold()->span(4));
$styles->set("totalPrice", SmgStyle::builder()->right()->maxSpan()->bold());

$header = new SmgRow(["Name", "Units", "Price"]);
$body = array_map(function ($item) {
    return new SmgRow([$item["name"], $item["units"], $item["price"]]);
}, $items);
$footer = new SmgRow([
    new SmgCell("Total:", "totalStr"),
    new SmgCell($total, "totalPrice")
]);

$tableConfig = SmgTextBlockConfig::instance()->styles($styles)->separator("|");
$table = SmgTextBlock::build($tableConfig)
    ->text("Tabla de precios", "title")
    ->row($header)
    ->line()
    ->rows($body)
    ->line()
    ->row($footer);

$printObjectConfig = SmgPrintObjectConfig::instance()->blockWidth(48)->openDrawer();
$jsonString = SmgPrintObject::build($printObjectConfig)->block($table)->toJson();


echo json_encode(json_decode($jsonString, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

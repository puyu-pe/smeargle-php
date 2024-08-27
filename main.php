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
use \PuyuPe\Smeargle\blocks\style\Smg;
use \PuyuPe\Smeargle\blocks\text\SmgVerticalLayout;

$products = [
    ["name" => "item1", "units" => "3", "price" => "3.50"],
    ["name" => "item2", "units" => "5", "price" => "6.20"],
    ["name" => "item3", "units" => "1", "price" => "1.20"],
    ["name" => "item4", "units" => "2", "price" => "9.30"],
    ["name" => "item5", "units" => "1", "price" => "4.30"],
    ["name" => "item6", "units" => "1", "price" => "5.70"],
];

$header = new SmgRow(["header1", "header2", "header3"], Smg::bold());

$body = array_map(function ($product) {
    return new SmgRow([$product["name"], $product["units"], $product["price"]]);
}, $products);

$footer = new SmgRow();
$footer->add("total:", Smg::bold()->right()->span(4));
$footer->add("450.47");

$tablePrintConfig = SmgTextBlockConfig::instance()
    ->separator("|")
    ->styleForColumn(0, Smg::left())
    ->styleForColumn(1, Smg::center())
    ->styleForColumn(2, Smg::right());

$table = new SmgVerticalLayout($tablePrintConfig);
$table
    ->title("Tabla de ejemplo")
    ->line("*")
    ->row($header)
    ->line()
    ->rows($body)
    ->line()
    ->row($footer);

$printObjectConfig = SmgPrintObjectConfig::instance()->blockWidth(48);
$jsonString = SmgPrintObject::build($printObjectConfig)->block($table)->toJson();

echo json_encode(json_decode($jsonString, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

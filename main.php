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

$testPrintConfig = SmgTextBlockConfig::instance()
    ->styleForColumn(0, Smg::span(2))
    ->styleForClass("customClass", Smg::bold()->bgInverted()->maxSpan())
    ->styleForClass("rowClass", Smg::bold()->bgInverted()->maxSpan()->right())
    ->styleForColumn(1, Smg::maxSpan());

$testRow = new SmgRow();
$testRow->add("customRow", "rowClass");

$test = new SmgVerticalLayout($testPrintConfig);
$test
    ->title("Servicio de impresión PUKA - PUYU")
    ->toCenter("Esta es una prueba de impresión")
    ->line("*")
    ->row(["name_system:", "192.168.18.39"])
    ->row(["port:", "9100"])
    ->row(new SmgRow(["blockWidth:", "48"]))
    ->row($testRow)
    ->textWithClass("custom text", "customClass")
    ->line()
    ->toCenter("Gracias, que tenga  un buen dia.");

/*
 for(){
    ->toCenter("precuenta", Smg::ifElse(support, Smg::bgInverted(), Smg::pad(*)->bold()));
    $row = new SmgRow();
    $row->add("text",  Smg::bold());
    $row->add("text",  Smg::if($mount > 0, Smg::bold());
    $row->add("text", Smg::center()->bgInverted()->maxSpan());
    $test->row($row);
 }

 * */

$printObjectConfig = SmgPrintObjectConfig::instance()->blockWidth(48);
$jsonString = SmgPrintObject::build($printObjectConfig)->block($test)->toJson();

echo json_encode(json_decode($jsonString, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

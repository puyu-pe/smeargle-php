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

SmgDrawer::builder()->pin(SmgDrawerPin::_5)->t2(120)->t2(240);

$config = SmgPrintObjectConfig::instance()
    ->blockWidth(48)
    ->normalize()
    ->info("key", "value")
    ->cut(SmgCutProperty::builder()->mode(SmgCutMode::FULL))
    ->openDrawer();

$layout = SmgVerticalLayout::build()->toCenter("al centro", Smg::bold());
$style = SmgStyle::builder()->bold();

$printObject = SmgPrintObject::build($config)->block($textBlock);

echo json_encode(json_decode($printObject->toJson(), true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

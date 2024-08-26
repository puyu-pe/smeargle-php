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

//$businessConfig = SmgTextBlockConfig::instance()->styles();
$business = SmgTextBlock::build()
    ->text("PUYU SRL")
    ->text("De: Velnae")
    ->text("RUC 12345678910 JR PUYU N° 101")
    ->text("ABANCAY - ABANCAY - AV. PUYU")
    ->text("TEL : 083323805 CEL. 999999999")
    ->line(" ")
    ->text("BOLETA ELECTRÓNICA B001-31237")
    ->line(" ")
    ->text("ADQUIRIENTE")
    ->text("DNI: -")
    ->text("clientes varios")
    ->line(" ")
    ->text("ADQUIRIENTE")
    ->text("DNI: -")
    ->text("clientes varios");

/*
textTitle()

textLeft
 * */

$style1 = SmgStyle::builder()
    ->maxSpan()
    ->width(40)
    ->bold(false)
    ->bold()
    ->normalize()
    ->bgInverted()
    ->buildUniqueClassName();
echo $style1;
//echo json_encode(json_decode($business, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

<?php
require_once __DIR__ . '/vendor/autoload.php';

use PuyuPe\Smeargle\blocks\img\SmgImageBlock;
use PuyuPe\Smeargle\blocks\text\SmgCell;
use PuyuPe\Smeargle\blocks\text\SmgTextBlock;
use PuyuPe\Smeargle\SmgPrintObject;
use PuyuPe\Smeargle\styles\SmgMapStyles;
use PuyuPe\Smeargle\util\Smg;
use PuyuPe\Smeargle\util\SmgTicket;
use PuyuPe\Smeargle\util\SmgStylizedRow;
use PuyuPe\Smeargle\properties\SmgProperties;
use PuyuPe\Smeargle\blocks\text\SmgRow;
use PuyuPe\Smeargle\blocks\qr\SmgQrBlock;
use PuyuPe\Smeargle\opendrawer\SmgDrawer;
use PuyuPe\Smeargle\opendrawer\SmgDrawerPin;
use PuyuPe\Smeargle\properties\SmgCutProperty;
use PuyuPe\Smeargle\properties\SmgCutMode;
use PuyuPe\Smeargle\styles\SmgScale;
use PuyuPe\Smeargle\blocks\qr\SmgQrErrorLevel;
use PuyuPe\Smeargle\blocks\qr\SmgQrType;

$qr = SmgQrBlock::builder()->setQrType(SmgQrType::NATIVE);

$ticketJson = SmgTicket::builder()
    ->addQrCode($qr, Smg::width(290)
        ->height(290)
        ->scale(SmgScale::SMOOTH)
        ->center())
    ->openDrawer()
    ->toJson();

echo json_encode(json_decode($ticketJson, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

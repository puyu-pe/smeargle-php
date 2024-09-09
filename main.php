<?php
require_once __DIR__ . '/vendor/autoload.php';

use \PuyuPe\Smeargle\SmgPrintObject;
use \PuyuPe\Smeargle\Smg;

$printObject = SmgPrintObject::build()
    ->setProperties(Smg::blockWidth(48))
    ->addText("hello word");

echo json_encode(json_decode($printObject->toJson(), true), JSON_PRETTY_PRINT);

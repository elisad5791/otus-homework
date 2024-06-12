<?php

use Bitrix\Main\Page\Asset;

CJSCore::RegisterExt('working-day', [
    'js' => '/local/js/working-day.js',
    'css' => '/local/css/working-day.css'
]);
CJSCore::Init(['working-day']);

$asset = Asset::getInstance();
$asset->addString('<script>BX.ready(function () { BX.Working.registerTimemanEvent(); });</script>');
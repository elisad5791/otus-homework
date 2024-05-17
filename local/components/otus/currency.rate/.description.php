<?php
use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = [
    'NAME' => Loc::getMessage('CURRENCY_RATE_NAME'),
    'DESCRIPTION' => Loc::getMessage('CURRENCY_RATE_DESCRIPTION'),
    'ICON' => '/images/icon.gif',
    'SORT' => 10,
    'CACHE_PATH' => 'Y',
    'PATH' => [
        'ID' => 'Otus',
        'NAME' => Loc::getMessage('CURRENCY_RATE_PARENT')
    ]
];
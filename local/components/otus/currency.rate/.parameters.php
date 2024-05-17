<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

Loader::includeModule('currency');
$select = ['CURRENCY', 'FULLNAME' => 'CURRENT_LANG_FORMAT.FULL_NAME'];
$currencies = CurrencyTable::getList(['select' => $select])->fetchAll();
$currencies = array_column($currencies, 'FULLNAME', 'CURRENCY');

$arComponentParameters = [
    'GROUPS' => [
        'DATA' => [
            'NAME' => Loc::getMessage('CURRENCY_RATE_DATA'),
            'SORT' => 10
        ]
    ],
    'PARAMETERS' => [
        'CURRENCY' => [
            'PARENT' => 'DATA',
            'NAME' => Loc::getMessage('CURRENCY_RATE_INPUT'),
            'TYPE' => 'LIST',
            'VALUES' => $currencies
        ],
       'CACHE_TIME' => [
           'DEFAULT' => 3600
       ]
    ]
];
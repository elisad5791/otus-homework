<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$arActivityDescription = [
    'NAME' => Loc::getMessage('DADATA_NAME'),
    'DESCRIPTION' => Loc::getMessage('DADATA_DESCR'),
    'TYPE' => 'activity',
    'CLASS' => 'DadataActivity',
    'JSCLASS' => 'BizProcActivity',
    'CATEGORY' => ['ID' => 'other'],
    'RETURN' => ['COMPANY_ID' => ['NAME' => Loc::getMessage('DADATA_COMPANY_ID'), 'TYPE' => 'int']]
];

<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    'NAME' => Loc::getMessage('ELISAD_COMPONENT_NAME'),
    'DESCRIPTION' => Loc::getMessage('ELISAD_COMPONENT_DESCRIPTION'),
    'ICON' => '/images/icon.gif',
    'SORT' => 10,
    'CACHE_PATH' => 'Y',
    'PATH' => [
        'ID' => 'study_components',
        'NAME' => Loc::getMessage('ELISAD_COMPONENT_PARENT')
    ],
    'COMPLEX' => 'N'
];
<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$gridParams = [
    'GRID_ID' => $arResult['gridId'],
    'COLUMNS' => $arResult['columns'],
    'ROWS' => $arResult['rows'],
    'TOTAL_ROWS_COUNT' => $arResult['total'],
    'AJAX_MODE' => 'Y',
    'AJAX_OPTION_JUMP' => 'N',
    'AJAX_OPTION_HISTORY' => 'N',
    'SHOW_ROW_CHECKBOXES' => false,
    'SHOW_SELECTED_COUNTER' => false
];
$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', $gridParams);
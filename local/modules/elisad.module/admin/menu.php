<?php
defined('B_PROLOG_INCLUDED') && (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$aMenu = [
    'parent_menu' => 'global_menu_services',
    'sort' => 1,
    'text' => Loc::getMessage('ELISAD_ADD_TAB'),
    'items_id' => 'menu_elisad',
    'icon' => 'form_menu_icon'
];

$aMenu['items'] = [
    ['text' => Loc::getMessage('ELISAD_MODULE_PAGE'), 'url' => 'elisad.php?lang=' . LANGUAGE_ID],
    ['text' => Loc::getMessage('ELISAD_MODULE_SETTINGS'), 'url' => 'settings.php?lang=ru&mid=elisad.module']
];

return $aMenu;
<?php
use Bitrix\Main\EventManager;

$manager = EventManager::getInstance();

$handler = ['IblockEvents', 'onApplicationAdd'];
$manager->addEventHandler('iblock', 'OnAfterIBlockElementAdd', $handler);

$handler = ['IblockEvents', 'onApplicationUpdate'];
$manager->addEventHandler('iblock', 'OnAfterIBlockElementUpdate', $handler);

$handler = ['IblockEvents', 'onApplicationDelete'];
$manager->addEventHandler('iblock', 'OnBeforeIBlockElementDelete', $handler);

$handler = ['DealEvents', 'onDealAdd'];
$manager->addEventHandler('crm', 'OnAfterCrmDealAdd', $handler);

$handler = ['DealEvents', 'onDealUpdate'];
$manager->addEventHandler('crm', 'OnAfterCrmDealUpdate', $handler);

$handler = ['DealEvents', 'onDealDelete'];
$manager->addEventHandler('crm', 'OnAfterCrmDealDelete', $handler);
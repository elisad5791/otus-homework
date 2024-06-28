<?php
use Bitrix\Main\EventManager;

$manager = EventManager::getInstance();

$handler = ['Events', 'onApplicationAdd'];
$manager->addEventHandler('iblock', 'OnAfterIBlockElementAdd', $handler);

$handler = ['Events', 'onApplicationUpdate'];
$manager->addEventHandler('iblock', 'OnAfterIBlockElementUpdate', $handler);

$handler = ['Events', 'onApplicationDelete'];
$manager->addEventHandler('iblock', 'OnBeforeIBlockElementDelete', $handler);

$handler = ['Events', 'onDealUpdate'];
$manager->addEventHandler('crm', 'OnAfterCrmDealUpdate', $handler);
<?php
use Bitrix\Main\EventManager;

$manager = EventManager::getInstance();

$handler = ['ReservationField', 'GetUserTypeDescription'];
$manager->AddEventHandler('iblock', 'OnIBlockPropertyBuildList', $handler);
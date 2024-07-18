<?php
use Bitrix\Main\EventManager;

$manager = EventManager::getInstance();

$handler = ['RestEvents', 'onBuildDescription'];
$manager->addEventHandler('rest', 'OnRestServiceBuildDescription', $handler);
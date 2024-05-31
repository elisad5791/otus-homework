<?php

use Bitrix\Main\Application;

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$request = Application::getInstance()->getContext()->getRequest();
$componentData = $request->get('PARAMS');
$params = $componentData['params'];
$template = $componentData['template'];

$APPLICATION->IncludeComponent('elisad:data.view', $template, $params, false);
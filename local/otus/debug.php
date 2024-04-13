<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
use Bitrix\Main\Diag\Debug;

define('FILE_LOG', 'local/logs/logOtus.txt');

$var = date('Y-m-d H:i:s');
Debug::writeToFile($var, '', FILE_LOG);

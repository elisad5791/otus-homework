<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Курс валюты');
?>

<?php
$APPLICATION->IncludeComponent(
	'otus:currency.rate',
	'.default',
	[
		'CACHE_TIME' => '3600',
		'CACHE_TYPE' => 'A',
		'CURRENCY' => 'BYN'
	]
);
?>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>
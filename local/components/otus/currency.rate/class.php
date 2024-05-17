<?php

use Bitrix\Currency\CurrencyTable;
use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class CurrencyRateComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        $this->checkModules();
        if ($this->startResultCache()) {
            $select = ['CURRENT_BASE_RATE', 'FULLNAME' => 'CURRENT_LANG_FORMAT.FULL_NAME'];
            $filter = ['CURRENCY' => $this->arParams['CURRENCY']];
            $data = CurrencyTable::getList(['select' => $select, 'filter' => $filter])->fetch();
            $this->arResult = [
                'rate' => round($data['CURRENT_BASE_RATE'], 2),
                'title' => $data['FULLNAME']
            ];
            $this->IncludeComponentTemplate();
        }
    }

    private function checkModules()
    {
        if (!Loader::includeModule('currency')) {
            throw new Exception('Не загружен модуль Валюты');
        }
        return true;
    }
} 
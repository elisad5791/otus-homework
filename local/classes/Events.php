<?php

use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Loader;
use Bitrix\Iblock\Elements\ElementApplicationsTable;

class Events
{
    protected static $elementUpdateDisabled = false;
    protected static $dealUpdateDisabled = false;

    public static function onApplicationAdd($fields)
    {
        Loader::includeModule('crm');
        Loader::includeModule('iblock');

        $iblockId = static::getIblockId();
        if ($fields['IBLOCK_ID'] != $iblockId) {
            return;
        }

        $propIds = static::getPropertyIds($iblockId);
        $data = [
            'NAME' => $fields['NAME'],
            'SUM' => $fields['PROPERTY_VALUES'][$propIds['SUM']]['n0'],
            'RESPONSIBLE' => $fields['PROPERTY_VALUES'][$propIds['RESPONSIBLE']]['n0']['VALUE']
        ];

        $dealId = static::createDeal($data);
        $data['DEAL'] = $dealId;
        $id = $fields['ID'];

        static::$elementUpdateDisabled = true;
        static::updateElement($id, $data, $propIds);
        static::$elementUpdateDisabled = false;
    }

    public static function onApplicationUpdate($fields)
    {
        if (static::$elementUpdateDisabled) {
            return;
        }

        Loader::includeModule('crm');
        Loader::includeModule('iblock');

        $iblockId = static::getIblockId();
        if ($fields['IBLOCK_ID'] != $iblockId) {
            return;
        }

        $propIds = static::getPropertyIds($iblockId);
        $arr = $fields['PROPERTY_VALUES'][$propIds['SUM']];
        $sum = array_values($arr)[0];
        $arr = $fields['PROPERTY_VALUES'][$propIds['RESPONSIBLE']];
        $resposible = array_values($arr)[0]['VALUE'];
        $arr = $fields['PROPERTY_VALUES'][$propIds['DEAL']];
        $dealId = array_values($arr)[0]['VALUE'];

        $data = [
            'NAME' => $fields['NAME'],
            'SUM' => $sum,
            'RESPONSIBLE' => $resposible
        ];

        static::$dealUpdateDisabled = true;
        static::updateDeal($dealId, $data);
        static::$dealUpdateDisabled = false;
    }

    public static function onApplicationDelete($id)
    {
        Loader::includeModule('crm');
        Loader::includeModule('iblock');

        $dealId = static::getDealId($id);
        static::deleteDeal($dealId);
    }

    public static function onDealUpdate($fields)
    {
        if (static::$dealUpdateDisabled) {
            return;
        }

        Loader::includeModule('iblock');

        $elementId = static::getElementId($fields['ID']);
        if (empty($elementId)) {
            return;
        }

        $iblockId = static::getIblockId();
        $propIds = static::getPropertyIds($iblockId);
        $data = [
            'NAME' => $fields['TITLE'],
            'RESPONSIBLE' => $fields['ASSIGNED_BY_ID'],
            'DEAL' => $fields['ID'],
            'SUM' => $fields['OPPORTUNITY']
        ];

        static::$elementUpdateDisabled = true;
        static::updateElement($elementId, $data, $propIds);
        static::$elementUpdateDisabled = false;
    }

    protected static function getIblockId()
    {
        $select = ['ID'];
        $filter = ['CODE' => 'applications'];
        $iblock = IblockTable::getList(['select' => $select, 'filter' => $filter])->fetch();
        $iblockId = $iblock['ID'];
        return $iblockId;
    }

    protected static function getPropertyIds($iblockId)
    {
        $select = ['ID', 'CODE'];
        $filter = ['IBLOCK_ID' => $iblockId];
        $properties = PropertyTable::getList(['select' => $select, 'filter' => $filter])->fetchAll();
        $props = array_column($properties, 'ID', 'CODE');
        return $props;
    }

    protected static function getElementId($dealId)
    {
        $select = ['ID', 'DEAL_' => 'DEAL'];
        $filter = ['DEAL_VALUE' => $dealId];
        $app = ElementApplicationsTable::getList(['select' => $select, 'filter' => $filter])->fetch();
        $elementId = $app['ID'] ?? 0;
        return $elementId;
    }

    protected static function getDealId($id)
    {
        $select = ['DEAL_' => 'DEAL'];
        $app = ElementApplicationsTable::getByPrimary($id, ['select' => $select])->fetch();
        $dealId = $app['DEAL_VALUE'];
        return $dealId;
    }

    protected static function createDeal($data)
    {
        $deal = new CCrmDeal;
        $dealFields = [
            'TITLE' => $data['NAME'],
            'OPPORTUNITY' => $data['SUM'],
            'ASSIGNED_BY_ID' => $data['RESPONSIBLE']
        ];
        $dealId = $deal->add($dealFields);
        return $dealId;
    }

    protected static function updateDeal($id, $data)
    {
        $deal = new CCrmDeal;
        $dealFields = [
            'TITLE' => $data['NAME'],
            'OPPORTUNITY' => $data['SUM'],
            'ASSIGNED_BY_ID' => $data['RESPONSIBLE']
        ];
        $deal->update($id, $dealFields);
    }

    protected static function deleteDeal($id)
    {
        $deal = new CCrmDeal;
        $deal->delete($id);
    }

    protected static function updateElement($id, $data, $propIds)
    {
        $el = new CIBlockElement;
        $props = [];
        $props[$propIds['DEAL']] = $data['DEAL'];
        $props[$propIds['SUM']] = $data['SUM'];
        $props[$propIds['RESPONSIBLE']] = $data['RESPONSIBLE'];
        $fieldsForUpdate = [
            'NAME' => $data['NAME'],
            'PROPERTY_VALUES' => $props
        ];
        $el->Update($id, $fieldsForUpdate);
    }
}
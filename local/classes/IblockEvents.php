<?php

use Bitrix\Main\Loader;

/*
 * Класс содержит обработчики событий добавления, обновления и удаления элементов списка Заявки на покупку мебели
 */
class IblockEvents
{
    /**
     * @var string IBLOCK_CODE символьный код списка Заявки на покупку мебели
     */
    const IBLOCK_CODE = 'applications';

    /**
     * @var bool флаг отключения обработчика добавления элемента
     */
    public static bool $elementAddDisabled = false;

    /**
     * @var bool флаг отключения обработчика обновления элемента
     */
    public static bool $elementUpdateDisabled = false;

    /**
     * @var bool флаг отключения обработчика удаления элемента
     */
    public static bool $elementDeleteDisabled = false;

    /*
     * Обработчик события добавления элемента списка Заявки на покупку мебели
     * @param array $fields данные элемента
     * @return void
     */
    public static function onApplicationAdd(array $fields): void
    {
        if (static::$elementAddDisabled) {
            return;
        }
        if (!Loader::includeModule('crm') || !Loader::includeModule('iblock')) {
            return;
        }

        $iblockId = Util::getIblockIdByCode(static::IBLOCK_CODE);
        if ($fields['IBLOCK_ID'] != $iblockId) {
            return;
        }

        $propIds = Util::getIblockPropertyIds($iblockId);
        $data = [
            'TITLE' => $fields['NAME'],
            'OPPORTUNITY' => $fields['PROPERTY_VALUES'][$propIds['SUM']]['n0'],
            'ASSIGNED_BY_ID' => $fields['PROPERTY_VALUES'][$propIds['RESPONSIBLE']]['n0']['VALUE']
        ];

        DealEvents::$dealAddDisabled = true;
        $dealId = Util::createDeal($data);
        DealEvents::$dealAddDisabled = false;

        $prop = ['DEAL' => $dealId];
        CIBlockElement::SetPropertyValuesEx($fields['ID'], $iblockId, $prop);
    }

    /*
     * Обработчик события обновления элемента списка Заявки на покупку мебели
     * @param array $fields данные элемента
     * @return void
     */
    public static function onApplicationUpdate(array $fields): void
    {
        if (static::$elementUpdateDisabled) {
            return;
        }
        if (!Loader::includeModule('crm') || !Loader::includeModule('iblock')) {
            return;
        }

        $iblockId = Util::getIblockIdByCode(static::IBLOCK_CODE);
        if ($fields['IBLOCK_ID'] != $iblockId) {
            return;
        }

        $propIds = Util::getIblockPropertyIds($iblockId);
        $sum = current($fields['PROPERTY_VALUES'][$propIds['SUM']]);
        $resposible = current(current($fields['PROPERTY_VALUES'][$propIds['RESPONSIBLE']]));
        $dealId = current(current($fields['PROPERTY_VALUES'][$propIds['DEAL']]));

        $data = [
            'TITLE' => $fields['NAME'],
            'OPPORTUNITY' => $sum,
            'ASSIGNED_BY_ID' => $resposible
        ];

        DealEvents::$dealUpdateDisabled = true;
        Util::updateDeal($dealId, $data);
        DealEvents::$dealUpdateDisabled = false;
    }

    /*
     * Обработчик события удаления элемента списка Заявки на покупку мебели
     * @param int $id идентификатор элемента
     * @return void
     */
    public static function onApplicationDelete(int $id): void
    {
        if (static::$elementDeleteDisabled) {
            return;
        }
        if (!Loader::includeModule('crm') || !Loader::includeModule('iblock')) {
            return;
        }

        $currentIblockId = Util::getIblockIdForElement($id);
        $iblockId = Util::getIblockIdByCode(static::IBLOCK_CODE);
        if ($currentIblockId != $iblockId) {
            return;
        }

        $dealId = Util::getPropertyValue($id, 'DEAL', $iblockId);

        DealEvents::$dealDeleteDisabled = true;
        Util::deleteDeal($dealId);
        DealEvents::$dealDeleteDisabled = false;
    }
}
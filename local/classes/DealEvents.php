<?php

use Bitrix\Main\Loader;

/*
 * Класс содержит обработчики событий добавления, обновления и удаления сделок, привязанных к Заявкам на покупку мебели
 */
class DealEvents
{
    /**
     * @var string IBLOCK_CODE символьный код списка Заявки на покупку мебели
     */
    const IBLOCK_CODE = 'applications';

    /**
     * @var bool флаг отключения обработчика добавления сделки
     */
    public static bool $dealAddDisabled = false;

    /**
     * @var bool флаг отключения обработчика обновления сделки
     */
    public static bool $dealUpdateDisabled = false;

    /**
     * @var bool флаг отключения обработчика удаления сделки
     */
    public static bool $dealDeleteDisabled = false;

    /*
     * Обработчик события добавления сделки
     * @param array $fields данные сделки
     * @return void
     */
    public static function onDealAdd(array $fields): void
    {
        if (static::$dealAddDisabled) {
            return;
        }
        if (!Loader::includeModule('iblock')) {
            return;
        }

        $iblockId = Util::getIblockIdByCode(static::IBLOCK_CODE);
        $propIds = Util::getIblockPropertyIds($iblockId);
        $props = [];
        $props[$propIds['DEAL']] = $fields['ID'];
        $props[$propIds['SUM']] = $fields['OPPORTUNITY'];
        $props[$propIds['RESPONSIBLE']] = $fields['ASSIGNED_BY_ID'];

        $data = [
            'NAME' => $fields['TITLE'],
            'IBLOCK_ID' => $iblockId,
            'PROPERTY_VALUES' => $props
        ];

        IblockEvents::$elementAddDisabled = true;
        Util::createElement($data);
        IblockEvents::$elementAddDisabled = false;
    }

    /*
     * Обработчик события обновления сделки
     * @param array $fields данные сделки
     * @return void
     */
    public static function onDealUpdate(array $fields): void
    {
        if (static::$dealUpdateDisabled) {
            return;
        }
        if (!Loader::includeModule('iblock')) {
            return;
        }

        $iblockId = Util::getIblockIdByCode(static::IBLOCK_CODE);
        $elementId = Util::getElementIdByProperty('DEAL', $fields['ID'], $iblockId);
        if (empty($elementId)) {
            return;
        }

        $propIds = Util::getIblockPropertyIds($iblockId);
        $props = [];
        $props[$propIds['DEAL']] = $fields['ID'];
        $props[$propIds['SUM']] = $fields['OPPORTUNITY'];
        $props[$propIds['RESPONSIBLE']] = $fields['ASSIGNED_BY_ID'];
        $data = [
            'NAME' => $fields['TITLE'],
            'PROPERTY_VALUES' => $props
        ];

        IblockEvents::$elementUpdateDisabled = true;
        Util::updateElement($elementId, $data);
        IblockEvents::$elementUpdateDisabled = false;
    }

    /*
     * Обработчик события удаления сделки
     * @param int $dealId идентификатор сделки
     * @return void
     */
    public static function onDealDelete(int $dealId): void
    {
        if (static::$dealDeleteDisabled) {
            return;
        }
        if (!Loader::includeModule('iblock')) {
            return;
        }

        $iblockId = Util::getIblockIdByCode(static::IBLOCK_CODE);
        $id = Util::getElementIdByProperty('DEAL', $dealId, $iblockId);

        IblockEvents::$elementDeleteDisabled = true;
        Util::deleteElement($id);
        IblockEvents::$elementDeleteDisabled = false;
    }
}
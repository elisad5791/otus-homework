<?php

use Bitrix\Iblock\Iblock;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\ElementTable;

/*
 * Класс содержит вспомогательные методы для работы с элементами ИБ и сделками
 */
class Util
{
    /*
     * Метод получает идентификатор инфоблока по его символьному коду
     * @param string $code символьный код инфоблока
     * @return int идентификатор инфоблока
     */
    public static function getIblockIdByCode(string $code): int
    {
        $select = ['ID'];
        $filter = ['CODE' => $code];
        $iblock = IblockTable::getList(['select' => $select, 'filter' => $filter])->fetch();
        $iblockId = $iblock['ID'] ?? 0;
        return (int)$iblockId;
    }

    /*
     * Метод получает идентификатор инфоблока для конкретного элемента инфоблока
     * @param int $id идентификатор элемента
     * @return int идентификатор инфоблока
     */
    public static function getIblockIdForElement(int $id): int
    {
        $select = ['IBLOCK_ID'];
        $filter = ['ID' => $id];
        $element = ElementTable::getList(['select' => $select, 'filter' => $filter])->fetch();
        $iblockId = $element['IBLOCK_ID'] ?? 0;
        return (int)$iblockId;
    }

    /*
     * Метод получает идентикаторы и символьные коды инфоблока
     * @param int @iblockId идентификатор инфоблока
     * @return array массив, у которого ключи - символьные коды, а значения - идентификаторы свойств инфоблока
     */
    public static function getIblockPropertyIds(int $iblockId): array
    {
        $select = ['ID', 'CODE'];
        $filter = ['IBLOCK_ID' => $iblockId];
        $properties = PropertyTable::getList(['select' => $select, 'filter' => $filter])->fetchAll();
        $props = array_column($properties, 'ID', 'CODE');
        $props = array_map(fn($item) => (int) $item, $props);
        return $props;
    }

    /*
     * Метод получает идентификатор элемента инфоблока по значению его свойства
     * @param string $propName символьный код свойства
     * @param mixed $propValue значение свойства
     * @param int $iblockId идентификатор инфоблока
     * @return int идентификатор элемента
     */
    public static function getElementIdByProperty(string $propName, mixed $propValue, int $iblockId): int
    {
        $class = Iblock::wakeUp($iblockId)->getEntityDataClass();
        $select = ['ID'];
        $select[$propName . '_'] = $propName;
        $filter = [];
        $filter[$propName . '_VALUE'] = $propValue;
        $element = $class::getList(['select' => $select, 'filter' => $filter])->fetch();
        $elementId = $element['ID'] ?? 0;
        return (int)$elementId;
    }

    /*
     * Метод получает значение свойства элемента
     * @param int $id иденоификатор элемента
     * @param string $propName символьный код свойства
     * @param int $iblockId идентификатор инфоблока
     * @return mixed значение свойства
     */
    public static function getPropertyValue(int $id, string $propName, int $iblockId): mixed
    {
        $class = Iblock::wakeUp($iblockId)->getEntityDataClass();
        $select = [];
        $select[$propName . '_'] = $propName;
        $element = $class::getByPrimary($id, ['select' => $select])->fetch();
        $value = $element[$propName . '_VALUE'] ?? 0;
        return $value;
    }

    /*
     * Метод создает сделку
     * @param array $data данные сделки
     * @return int идентификатор созданной сделки
     */
    public static function createDeal(array $data): int
    {
        $deal = new CCrmDeal;
        $dealId = $deal->add($data);
        if (!$dealId) {
            debf('Не удалось создать сделку: ' . $deal->LAST_ERROR);
        }
        return (int)$dealId;
    }

    /*
     * Метод обновляет сделку
     * @param int $id идентификатор сделки
     * @param array $data данные сделки
     * @return void
     */
    public static function updateDeal(int $id, array $data): void
    {
        $deal = new CCrmDeal;
        $result = $deal->update($id, $data);
        if (!$result) {
            debf('Не удалось обновить сделку: ' . $deal->LAST_ERROR);
        }
    }

    /*
     * Метод удаляет сделку
     * @param int $id идентификатор сделки
     * @return void
     */
    public static function deleteDeal(int $id): void
    {
        $deal = new CCrmDeal;
        $result = $deal->delete($id);
        if (!$result) {
            debf('Не удалось удалить сделку: ' . $deal->LAST_ERROR);
        }
    }

    /*
     * Метод создает элемент инфоблока
     * @param array $data данные элемента
     * @return int идентификатор созданнго элемента
     */
    public static function createElement(array $data): int
    {
        $el = new CIBlockElement;
        $id = $el->Add($data);
        if (!$id) {
            debf('Не удалось создать элемент: ' . $el->LAST_ERROR);
        }
        return (int)$id;
    }

    /*
     * Метод обновляет элемент инфоблока
     * @param int @id идентификатор элемента
     * @param array $data данные элемента
     * @return void
     */
    public static function updateElement(int $id, array $data): void
    {
        $el = new CIBlockElement;
        $result = $el->Update($id, $data);
        if (!$result) {
            debf('Не удалось обновить элемент: ' . $el->LAST_ERROR);
        }
    }

    /*
     * Метод удаляет элемент инфоблока
     * @param int @id идентификатор элемента
     * @return void
     */
    public static function deleteElement(int $id): void
    {
        $el = new CIBlockElement;
        $result = $el->Delete($id);
        if (!$result) {
            debf('Не удалось удалить элемент: ' . $el->LAST_ERROR);
        }
    }
}
<?php

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\Validator\RegExp;

/*
 * Класс сущности Города
 */
class CityTable extends DataManager
{
    /*
     * Метод возвращает название таблицы
     * @return string название таблицы
     */
    public static function getTableName(): string
    {
        return 'my_city';
    }

    /*
     * Метод возвращает описание полей таблицы
     * @return array поля таблицы
     */
    public static function getMap(): array
    {
        return [
            new IntegerField('ID', ['primary' => true, 'autocomplete' => true]),
            new StringField('TITLE', [
                'required' => true,
                'validation' => fn() => [new RegExp('/^[А-Яа-я\s]+$/u')]
            ])
        ];
    }
}
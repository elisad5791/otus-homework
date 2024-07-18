<?php

/*
 * Класс для обработчиков событий модуля REST
 */
class RestEvents
{
    /*
     * Метод добавляет методы REST для сущности Города
     * @return array массив обработчиков для методов REST
     */
    public static function onBuildDescription(): array
    {
        return [
            'my.city' => array(
                'my.city.list' => [RestApi::class,'getList'],
                'my.city.add' => [RestApi::class,'add'],
                'my.city.update' => [RestApi::class,'update'],
                'my.city.delete' => [RestApi::class,'delete']
            )
        ];
    }
}
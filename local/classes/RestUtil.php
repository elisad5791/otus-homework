<?php

/*
 * Класс утилит для модуля REST
 */
class RestUtil
{
    /*
     * Метод готовит параметры навигации для метода REST
     * @param string $dataManager название класса
     * @param array $params массив, содержащий фильтр
     * @return array массив параметров навигации
     */
    public static function prepareNavigation (string $dataManager, array $params): array
    {
        $filter = $params['filter'] ?? [];
        $total = $dataManager::getCount($filter);

        $nav = ['total' => $total];
        if ($params['offset'] + $params['limit'] < $total) {
            $nav['next'] = $params['offset'] + $params['limit'];
        }

        return $nav;
    }
}
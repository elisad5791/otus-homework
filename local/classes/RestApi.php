<?php

use Bitrix\Rest\RestException;

/*
 * Класс, реализующий REST API для сущности Города
 */
class RestApi extends IRestService
{
    /*
     * Метод возвращает список элементов
     * @param array $params массив параметров для фильтрации, сортировки, выбора полей
     * @param int $start начальная позиция выборки
     * @return array список элементов
     */
    public static function getList(array $params, int $start): array
    {
        debf($params, 'list - params');
        debf($start, 'list - start');

        try {
            $data = [];

            if (isset($params['filter'])) {
                $data['filter'] = $params['filter'];
            }

            if (isset($params['select'])) {
                $data['select'] = $params['select'];
            }

            if (isset($params['order'])) {
                $data['order'] = $params['order'];
            }

            $data = array_merge($data, self::getNavData($start, true));
            $nav = RestUtil::prepareNavigation(CityTable::class, $data);

            $result = CityTable::getList($data)->fetchAll();
            $result = array_merge($result, $nav);

            debf($result, 'list - result');
            return $result;
        } catch (Exception $e) {
            debf($e->getMessage(), 'list -error');
            throw new RestException($e->getMessage());
        }
    }

    /*
     * Метод добавляет новый элемент
     * @param array $params массив с полями элемента
     * @return int идентификатор созданного элемента
     */
    public static function add(array $params): int
    {
        debf($params, 'add - params');

        $result = CityTable::add($params['fields']);

        if (!$result->isSuccess()) {
            $errors = implode(', ', $result->getErrorMessages());
            debf($errors, 'add - error');
            throw new RestException($errors);
        }

        $id = $result->getId();

        debf($id, 'add - result');
        return $id;
    }

    /*
     * Метод обновляет элемент
     * @param array $params массив с полями для обновления
     * @return string результат обновления
     */
    public static function update(array $params): string
    {
        debf($params, 'update - params');

        $id = $params['id'];
        $fields = $params['fields'];
        $result = CityTable::update($id, $fields);

        if (!$result->isSuccess()) {
            $errors = implode(', ', $result->getErrorMessages());
            debf($errors, 'update - error');
            throw new RestException($errors);
        }

        debf('updated', 'update - result');
        return 'updated';
    }

    /*
     * Метод удаляет элемент
     * @param array $params массив с идентификатором удаляемого элемента
     * @return string результат удаления
     */
    public static function delete(array $params): string
    {
        debf($params, 'delete - params');

        $id = $params['id'];
        $result = CityTable::delete($id);

        if (!$result->isSuccess()) {
            $errors = implode(', ', $result->getErrorMessages());
            debf($errors, 'delete - error');
            throw new RestException($errors);
        }

        debf('deleted', 'delete - result');
        return 'deleted';
    }
}
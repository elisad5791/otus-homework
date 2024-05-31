<?php

use Bitrix\Main\Loader;
use Elisad\Module\CommentsTable;
use Bitrix\Main\Localization\Loc;

class DataViewComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if ($this->StartResultCache()) {
            $id = $this->arParams['ENTITY_ID'];
            $entityId = $this->arParams['ENTITY_TYPE'];

            $this->arResult = [];
            $gridId = 'CRM_GRID';
            $this->arResult['gridId'] = $gridId;

            $this->arResult['columns'] = $this->getColumns();
            $this->arResult['rows'] = $this->getRows($id, $entityId);
            $this->arResult['total'] = count($this->arResult['rows']);

            $this->includeComponentTemplate();
        }
    }

    protected function getColumns()
    {
        $columns = [
            ['id' => 'ID', 'name' => '№', 'default' => true],
            ['id' => 'TITLE', 'name' => Loc::getMessage('ELISAD_COMMENT_TITLE'), 'default' => true],
            ['id' => 'CONTENT', 'name' => Loc::getMessage('ELISAD_COMMENT_CONTENT'), 'default' => true],
            ['id' => 'USER', 'name' => Loc::getMessage('ELISAD_COMMENT_USER'), 'default' => true],
            ['id' => 'CREATE_DATE', 'name' => Loc::getMessage('ELISAD_COMMENT_DATE'), 'default' => true]
        ];
        return $columns;
    }

    protected function getRows($id, $entityId)
    {
        Loader::includeModule('elisad.module');
        $select = [
            'ID',
            'TITLE',
            'CONTENT',
            'USER_NAME' => 'USER.NAME',
            'USER_LASTNAME' => 'USER.LAST_NAME',
            'CREATE_DATE'
        ];
        $filter = ['ENTITY_ID' => $id, 'ENTITY_TYPE_ID' => $entityId];
        $data = CommentsTable::getList(['select' => $select, 'filter' => $filter])->fetchAll();

        $rows = [];
        foreach ($data as $key => $item) {
            $cols = [
                'ID' => $item['ID'],
                'TITLE' => $item['TITLE'],
                'CONTENT' => $item['CONTENT'],
                'USER' => trim($item['USER_NAME'] . ' ' . $item['USER_LASTNAME']),
                'CREATE_DATE' => $item['CREATE_DATE']
            ];
            $row = ['id' => $key, 'columns' => $cols];
            $rows[] = $row;
        }

        return $rows;
    }
}
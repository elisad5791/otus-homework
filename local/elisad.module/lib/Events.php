<?php

namespace Elisad\Module;

use Bitrix\Main\EventResult;
use Bitrix\Main\Config\Option;

class Events
{
    static function createTab($event)
    {
        $fieldNames = [
            1 => 'leads',
            2 => 'deals',
            3 => 'contacts',
            4 => 'companies'
        ];

        $tabs = $event->getParameter('tabs');
        $entityID = $event->getParameter('entityID');
        $entityTypeID = $event->getParameter('entityTypeID');

        $module_id = 'elisad.module';
        $option = $fieldNames[$entityTypeID] . '_checkbox';
        $show = Option::get($module_id, $option);

        if ($show == 'Y') {
            $tabs[] = [
                'id' => 'commentsTab',
                'name' => 'Комментарии из таблицы',
                'loader' => [
                    'serviceUrl' => '/local/ajax/elisad.php',
                    'componentData' => [
                        'template' => '',
                        'params' => [
                            'ENTITY_ID' => $entityID,
                            'ENTITY_TYPE' => $entityTypeID,
                            'TAB_ID' => 'commentsTab'
                        ]
                    ]
                ]
            ];
        }

        return new EventResult(EventResult::SUCCESS, ['tabs' => $tabs]);
    }
}
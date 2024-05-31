<?php

namespace Elisad\Module;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Type\Date;
use Bitrix\Main\UserTable;

Loc::loadMessages(__FILE__);

class CommentsTable extends DataManager
{
    public static function getTableName()
    {
        return 'elisad_comments';
    }

    public static function getMap()
    {
        $join = Join::on('this.USER_ID', 'ref.ID');

        return [
            new IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
                'title' => Loc::getMessage('ELISAD_ID_FIELD')
            ]),
            new IntegerField('ENTITY_TYPE_ID', [
                'required' => true,
                'title' => Loc::getMessage('ELISAD_ENTITYTYPEID_FIELD')
            ]),
            new IntegerField('ENTITY_ID', [
                'required' => true,
                'title' => Loc::getMessage('ELISAD_ENTITYID_FIELD')
            ]),
            new StringField('TITLE', [
                'required' => true,
                'title' => Loc::getMessage('ELISAD_TITLE_FIELD')
            ]),
            new StringField('CONTENT', [
                'required' => true,
                'title' => Loc::getMessage('ELISAD_CONTENT_FIELD')
            ]),
            new IntegerField('USER_ID', [
                'required' => true,
                'title' => Loc::getMessage('ELISAD_USERID_FIELD')
            ]),
            new Reference('USER', UserTable::class, $join),
            new DateField('CREATE_DATE', [
                'default_value' => new Date,
                'title' => Loc::getMessage('ELISAD_CREATEDATE_FIELD')
            ]),
        ];
    }
}

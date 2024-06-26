<?php

use Bitrix\Bizproc\Activity\BaseActivity;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Bizproc\Activity\PropertiesDialog;
use Bitrix\Crm\EntityRequisite;
use Bitrix\Crm\RequisiteTable;

class CBPDadataActivity extends BaseActivity
{
    const TOKEN = 'token';
    const SECRET = 'secret';

    public function __construct($name)
    {
        parent::__construct($name);
        $this->arProperties = ['Title' => '', 'Inn' => '', 'Assigned' => '', 'COMPANY_ID' => null];
        $this->SetPropertiesTypes(['COMPANY_ID' => ['Type' => 'int']]);
    }

    protected static function getFileName(): string
    {
        return __FILE__;
    }

    protected function internalExecute(): ErrorCollection
    {
        $errors = parent::internalExecute();

        $oldCompany = $this->checkCompany($this->Inn);
        if (empty($oldCompany)) {
            $company = $this->getCompany($this->Inn);
            $id = $this->createCompany($company);
            $name = $company['name'];
        } else {
            $id = $oldCompany['ENTITY_ID'];
            $name = $oldCompany['RQ_COMPANY_NAME'];
        }

        $this->preparedProperties['COMPANY_ID'] = $id;
        $rootActivity = $this->GetRootActivity();
        $rootActivity->SetVariable('companyName', $name);
        return $errors;
    }

    public static function getPropertiesDialogMap(?PropertiesDialog $dialog = null): array
    {
        $inn = [
            'Name' => Loc::getMessage('DADATA_FIELD_INN'),
            'FieldName' => 'inn',
            'Type' => 'string',
            'Required' => true,
            'Options' => []
        ];
        $assigned = [
            'Name' => Loc::getMessage('DADATA_FIELD_ASSIGNED'),
            'FieldName' => 'assigned',
            'Type' => 'int',
            'Required' => true,
            'Options' => []
        ];
        $map = ['Inn' => $inn, 'Assigned' => $assigned];
        return $map;
    }

    protected function checkCompany($inn)
    {
        $select = ['ENTITY_ID', 'RQ_COMPANY_NAME'];
        $filter = ['ENTITY_TYPE_ID' => 4, 'RQ_INN' => $inn];
        $data = RequisiteTable::getList(['select' => $select, 'filter' => $filter])->fetch();
        return $data;
    }

    protected function getCompany($inn)
    {
        $dadata = new Dadata(static::TOKEN, static::SECRET);
        $dadata->init();
        $fields = ['query' => $inn, 'count' => 5];
        $result = $dadata->suggest('party', $fields);
        $dadata->close();
        $data = $result['suggestions'][0];
        $company = [
            'name' => $data['value'],
            'inn' => $data['data']['inn'],
            'kpp' => $data['data']['kpp'],
            'ogrn' => $data['data']['ogrn'],
            'okpo' => $data['data']['okpo'],
            'oktmo' => $data['data']['oktmo'],
            'country' => $data['data']['address']['data']['country'],
            'region' => $data['data']['address']['data']['region'],
            'city' => $data['data']['address']['data']['city'],
            'street' => $data['data']['address']['data']['street'],
            'house' => $data['data']['address']['data']['house']
        ];
        return $company;
    }

    protected function createCompany($company)
    {
        Loader::includeModule('crm');
        $fields = [
            'TITLE' => $company['name'],
            'OPENED' => 'Y',
            'COMPANY_TYPE' => 'CUSTOMER',
            'ASSIGNED_BY_ID' => $this->Assigned
        ];
        $obj = new CCrmCompany();
        $id = $obj->Add($fields);

        $address = [
            'ADDRESS_1' => $company['street'] . ', ' . $company['house'],
            'CITY' => $company['city'],
            'REGION' => $company['region'],
            'COUNTRY' => $company['country']
        ];

        $reqFields = [
            'ENTITY_TYPE_ID' => 4,
            'ENTITY_ID' => $id,
            'NAME' => $company['name'],
            'PRESET_ID' => 1,
            'RQ_COMPANY_NAME' => $company['name'],
            'RQ_INN' => $company['inn'],
            'RQ_KPP' => $company['kpp'],
            'RQ_OGRN' => $company['ogrn'],
            'RQ_OKPO' => $company['okpo'],
            'RQ_OKTMO' => $company['oktmo'],
            'RQ_ADDR' => [1 => $address]
        ];

        $req = new EntityRequisite();
        $req->add($reqFields);

        return $id;
    }
}

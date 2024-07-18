<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

if (!CityTable::getEntity()->getConnection()->isTableExists(CityTable::getTableName())) {
    CityTable::getEntity()->createDbTable();
    echo 'Table created';
} else {
    echo 'Table already exists';
}

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
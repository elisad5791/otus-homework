<?php

use Elisad\Module\CommentsTable;
use Bitrix\Main\Loader;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php';

$APPLICATION->SetTitle('Описание модуля');
Loader::includeModule('elisad.module');
$name = CommentsTable::getTableName();
$fields = CommentsTable::getMap();
?>

    <p>Модуль выводит комментарии из созданной таблицы в карточке сущности CRM.</p>
    <p>Комментарии привязаны к сущностям CRM - лидам, сделкам, контактам, компаниям.</p>
    <p>В настройках модуля можно указать, в карточках каких сущностей создавать новую вкладку с комментариями.</p>

    <h4>Характеристики таблицы</h4>
    <p><strong>Название</strong>: <?= $name ?></p>
    <p><strong>Поля</strong>: </p>
    <ul>
        <?php foreach ($fields as $field) { ?>
        <li style="margin-bottom:10px">
            <?= $field->getTitle() ?><br>
            <?= $field->getName() ?><br>
            Тип: <?= $field->getDataType() ?><br>
        </li>
        <?php } ?>
    </ul>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php';
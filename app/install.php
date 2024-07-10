<?php
require_once(__DIR__ . '/crest.php');

$result = CRest::installApp();

$params = ['filter' => ['XML_ID' => 'LAST_COMM']];
$data = CRest::call('crm.contact.userfield.list', $params);
$res = $data['result'];
$oldId = !empty($res) ? $res[0]['ID'] : 0;

$batch = [];

if (!empty($oldId)) {
    $params = ['id' => $oldId];
    $batch['userfieldDelete'] = ['method' => 'crm.contact.userfield.delete', 'params' => $params];
}

$params = [
    'fields' => [
        'FIELD_NAME' => 'LAST_COMM',
        'EDIT_FORM_LABEL' => 'Дата последней коммуникации (время мск)',
        'LIST_COLUMN_LABEL' => 'Дата последней коммуникации (время мск)',
        'USER_TYPE_ID' => 'datetime',
        'XML_ID' => 'LAST_COMM'
    ]
];
$batch['userfieldAdd'] = ['method' => 'crm.contact.userfield.add', 'params' => $params];

$events = [
    'onCrmActivityAdd'
];
$handler = 'https://bitrix-ref.online/handler.php';
foreach ($events as $event) {
    $params = ['event' => $event, 'handler' => $handler];
    $batch[$event] = ['method' => 'event.bind', 'params' => $params];
}

CRest::callBatch($batch);

if ($result['rest_only'] === false):?>
    <head>
        <script src="//api.bitrix24.com/api/v1/"></script>
        <?php if ($result['install'] == true): ?>
            <script>
                BX24.init(function () {
                    BX24.installFinish();
                });
            </script>
        <?php endif; ?>
    </head>
    <body>
    <?php if ($result['install'] == true): ?>
        installation has been finished
    <?php else: ?>
        installation error
    <?php endif; ?>
    </body>
<?php endif;
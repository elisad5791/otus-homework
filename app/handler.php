<?php
require_once(__DIR__ . '/crest.php');

$activityId = $_REQUEST['data']['FIELDS']['ID'] ?? 0;

if (!empty($activityId)) {
    $params = ['id' => $activityId];
    $data = CRest::call('crm.activity.get', $params);
    $res = $data['result'] ?? [];
    $typeId = $res['TYPE_ID'] ?? 0;
    $ownerTypeId = $res['OWNER_TYPE_ID'] ?? 0;
    $ownerId = $res['OWNER_ID'] ?? 0;

    $typeCondition = $typeId == 2 || $typeId == 4;
    if ($typeCondition && $ownerTypeId == 3 && !empty($ownerId)) {
        $params = ['id' => $ownerId, 'fields' => ['UF_CRM_LAST_COMM' => date('Y-m-d H:i:s')]];
        CRest::call('crm.contact.update', $params);
    }
}
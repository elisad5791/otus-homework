<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

if (!$USER->isAdmin()) {
    $APPLICATION->authForm(Loc::getMessage('ELISAD_ADMINS_ONLY'));
}

$request = Application::getInstance()->getContext()->getRequest();
$module_id = htmlspecialcharsbx($request['mid'] ?? '');

Loader::includeModule($module_id);

$options = [
    Loc::getMessage('ELISAD_TITLE_LEADS'),
    ['leads_checkbox', Loc::getMessage('ELISAD_CREATE_LEADS'), 'Y', ['checkbox']],
    Loc::getMessage('ELISAD_TITLE_DEALS'),
    ['deals_checkbox', Loc::getMessage('ELISAD_CREATE_DEALS'), 'Y', ['checkbox']],
    Loc::getMessage('ELISAD_TITLE_CONTACTS'),
    ['contacts_checkbox', Loc::getMessage('ELISAD_CREATE_CONTACTS'), 'Y', ['checkbox']],
    Loc::getMessage('ELISAD_TITLE_COMPANIES'),
    ['companies_checkbox', Loc::getMessage('ELISAD_CREATE_COMPANIES'), 'Y', ['checkbox']],
];

$aTabs = [
    [
        'DIV' => 'edit1',
        'TAB' => Loc::getMessage('ELISAD_CREATE_TABS'),
        'TITLE' => Loc::getMessage('ELISAD_TABS_SETTINGS'),
        'OPTIONS' => $options
    ]
];

if ($request->isPost() && !empty($update) && check_bitrix_sessid()) {
    foreach ($aTabs as $aTab) {
        foreach ($aTab['OPTIONS'] as $arOption) {
            if (!is_array($arOption)) {
                continue;
            }
            $optionValue = $request->getPost($arOption[0]);
            $optionValue = empty($optionValue) ? 'N' : 'Y';
            Option::set($module_id, $arOption[0], $optionValue);
        }
    }
    CAdminMessage::showMessage(['MESSAGE' => Loc::getMessage('ELISAD_SETTINGS_SAVED'), 'TYPE' => 'OK']);
}

$tabControl = new CAdminTabControl('tabControl', $aTabs);
$tabControl->Begin();
?>

    <form action="<?= $APPLICATION->GetCurPage() ?>?mid=<?= $module_id ?>" method="post">
        <?php
        foreach ($aTabs as $aTab) {
            if ($aTab['OPTIONS']) {
                $tabControl->BeginNextTab();
                __AdmSettingsDrawList($module_id, $aTab['OPTIONS']);
            }
        }
        $tabControl->Buttons();
        echo bitrix_sessid_post();
        ?>
        <input class="adm-btn-save" type="submit" name="update"
               value="<?= Loc::getMessage('ELISAD_SETTINGS_UPDATE') ?>"/>
    </form>

<?php
$tabControl->End();
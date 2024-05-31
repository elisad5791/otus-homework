<?php

use Bitrix\Main\Application;
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Elisad\Module\CommentsTable;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\IO\File;

Loc::loadMessages(__FILE__);

class elisad_module extends CModule
{
    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

        $this->MODULE_ID = 'elisad.module';
        $this->MODULE_NAME = Loc::getMessage('ELISAD_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('ELISAD_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('ELISAD_PARTNER_NAME');
        $this->PARTNER_URI = 'https://elisad.ru';
    }

    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $this->installDB();
        $this->InstallEvents();
        $this->InstallFiles();
    }

    public function doUninstall()
    {
        $this->uninstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function installDB()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            CommentsTable::getEntity()->createDbTable();
            $this->addData();
        }
    }

    public function uninstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            $connection = Application::getInstance()->getConnection();
            $connection->dropTable(CommentsTable::getTableName());
        }
    }

    protected function addData()
    {
        $items = [];
        for ($i = 1; $i <= 10; $i++) {
            $item = [
                'ENTITY_TYPE_ID' => 1,
                'ENTITY_ID' => 1,
                'TITLE' => 'Title' . $i,
                'CONTENT' => 'Content' . $i . ' content'. $i . ' content' . $i,
                'USER_ID' => 1
            ];
            $items[] = $item;
        }
        for ($i = 11; $i <= 20; $i++) {
            $item = [
                'ENTITY_TYPE_ID' => 2,
                'ENTITY_ID' => 1,
                'TITLE' => 'Title' . $i,
                'CONTENT' => 'Content' . $i . ' content'. $i . ' content' . $i,
                'USER_ID' => 1
            ];
            $items[] = $item;
        }

        foreach ($items as $item) {
            CommentsTable::add($item);
        }
    }

    function InstallEvents()
    {
        $manager = EventManager::getInstance();
        $event = 'onEntityDetailsTabsInitialized';
        $class = 'Elisad\Module\Events';
        $method = 'createTab';
        $manager->registerEventHandler('crm', $event, $this->MODULE_ID, $class, $method);
    }

    function UnInstallEvents()
    {
        $manager = EventManager::getInstance();
        $event = 'onEntityDetailsTabsInitialized';
        $class = 'Elisad\Module\Events';
        $method = 'createTab';
        $manager->unRegisterEventHandler('crm', $event, $this->MODULE_ID, $class, $method);
    }

    function installFiles()
    {
        $fromAdmin = __DIR__ . '/admin/';
        $toAdmin = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin';
        CopyDirFiles($fromAdmin, $toAdmin);

        $fromComp = __DIR__ . '/components/';
        $toComp = $_SERVER['DOCUMENT_ROOT'] . '/local/components';
        CopyDirFiles($fromComp, $toComp, true, true);

        $fromAjax = __DIR__ . '/ajax/';
        $toAjax = $_SERVER['DOCUMENT_ROOT'] . '/local/ajax';
        CopyDirFiles($fromAjax, $toAjax);
    }

    function unInstallFiles()
    {
        $admin = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/elisad.php';
        File::deleteFile($admin);

        $dataView = $_SERVER['DOCUMENT_ROOT'] . '/local/components/elisad/data.view';
        Directory::deleteDirectory($dataView);

        $elisad = $_SERVER['DOCUMENT_ROOT'] . '/local/components/elisad';
        $elisadEmpty = count(glob($elisad . '/*')) ? false : true;
        if ($elisadEmpty) {
            Directory::deleteDirectory($elisad);
        }

        $components = $_SERVER['DOCUMENT_ROOT'] . '/local/components';
        $componentsEmpty = count(glob($components . '/*')) ? false : true;
        if ($componentsEmpty) {
            Directory::deleteDirectory($components);
        }

        $elisadAjax = $_SERVER['DOCUMENT_ROOT'] . '/local/ajax/elisad.php';
        File::deleteFile($elisadAjax);

        $ajax = $_SERVER['DOCUMENT_ROOT'] . '/local/ajax';
        $ajaxEmpty = count(glob($ajax . '/*')) ? false : true;
        if ($ajaxEmpty) {
            Directory::deleteDirectory($ajax);
        }
    }
}

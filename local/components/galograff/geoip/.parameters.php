<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
Loader::includeModule("highloadblock");

use Bitrix\Highloadblock as HL;

$hlblockList = [];
$hlblockIterator = HL\HighloadBlockTable::getList();
while ($hlblock = $hlblockIterator->fetch()) {
    $hlblockList[$hlblock['ID']] = '[' . $hlblock['ID'] . '] ' . $hlblock['NAME'];

}

$arComponentParameters = array(
    "GROUPS" => array(
        "CUSTOM" => array(
            "NAME" => 'Выберите HL c Geo-базой'
        ),
    ),
    'PARAMETERS' => array(
        'HL_BLOCK' => array(
            'PARENT' => 'CUSTOM',
            'NAME' => 'Выберите Geo-базу',
            'TYPE' => 'LIST',
            'VALUES' => $hlblockList,
            'REFRESH' => 'Y',
            'DEFAULT' => '',
            'MULTIPLE' => 'N',
        ),

    ),
);
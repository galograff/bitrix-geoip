<?php

namespace Galograff\Components;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

use Bitrix\Main\Engine\Contract\Controllerable;

Loader::includeModule("highloadblock");

class GGeo extends \CBitrixComponent implements Controllerable
{

    public function configureActions()
    {
        // TODO: Implement configureActions() method.
        return [
            'deleteIp' => [
                'prefilters' => [],
            ],
            'searchIp' => [
                'prefilters' => [
                    //new Bitrix\Main\Engine\ActionFilter\Csrf(),
                ],
            ],
        ];
    }

    public function executeComponent()
    {
        try {
            $this->checkModules();
            $this->getResult();
        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }

    public function onIncludeComponentLang()
    {
        Loc::loadMessages(__FILE__);
    }

    protected function checkModules()
    {
        if (!Loader::includeModule('highloadblock'))
            throw new SystemException(Loc::getMessage('GGEO_HL_MODULE_NOT_INSTALLED'));
    }


    public function getResult()
    {
        $hlbl = (int)$this->arParams['HL_BLOCK'];
        $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $rsData = $entity_data_class::getList(array(
            'order' => array(
                'ID' => 'ASC'
            )
        ));

        while ($arData = $rsData->Fetch()) {
            $this->arResult[$arData['ID']] = $arData;
        }

        $this->IncludeComponentTemplate();
    }

    public function searchIpAction($get)
    {
        $checkIp = filter_var($get['ip'], FILTER_VALIDATE_IP, [‘flags’ => FILTER_FLAG_IPV4]);
        if ($checkIp === false) {
            return 'Неверно введен IP!';
        } else {
            $hlbl = (int)$this->arParams['HL_BLOCK'] || 1;
            $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();

            $rsData = $entity_data_class::getList(array(
                "select" => array("*"),
                "order" => array("ID" => "ASC"),
                "filter" => array("UF_IP" => $get['ip'])
            ));
            if ($arData = $rsData->Fetch()) {
                return $arData['UF_IP'] . ' | Город: ' . $arData['UF_CITY'] .
                    ' | Дополнительная информация: ' . $arData['UF_OTHER'];
            } else {
                $geo = json_decode(file_get_contents('http://api.sypexgeo.net/json/' . $get['ip']));
                if (!empty($geo->city->name_ru)) {
                    $hlbl = (int)$this->arParams['HL_BLOCK'] || 1;
                    $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

                    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                    $entity_data_class = $entity->getDataClass();

                    $UF_OTHER = $geo->country->name_ru . '[lat:' . $geo->city->lat . ' lon:' . $geo->city->lon . ']';

                    $data = array(
                        "UF_IP" => $get['ip'],
                        "UF_CITY" => $geo->city->name_ru,
                        "UF_OTHER" => $UF_OTHER,
                    );

                    $entity_data_class::add($data);
                    return $get['ip'] . ' | Город: ' . $geo->city->name_ru .
                        ' | Дополнительная информация: ' . $UF_OTHER;
                } else {
                    return 'Результатов не найдено!';
                }
            }
        }
    }

    public function deleteIpAction($get)
    {
        $hlbl = (int)$this->arParams['HL_BLOCK'] || 1;
        $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $entity_data_class::Delete($get['ip']);
        return $get['ip'] . ' удален';
    }
}
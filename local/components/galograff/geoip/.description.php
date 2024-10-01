<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = array(
    'NAME' => Loc::GetMessage("GGEO_TMPL_NAME"),
    'DESCRIPTION' => Loc::GetMessage("GGEO_TMPL_DESCRIPTION"),
    'SORT' => 30,
    'COMPLEX' => 'N',
    'PATH' => array(
        'ID' => 'content',
        'NAME' => Loc::GetMessage("GGEO_TMPL_PATH_NAME"),
        'CHILD' => [
            "ID" => 'geoip',
            "NAME" => Loc::GetMessage("GGEO_TMPL_PATH_NAME_CHILD_NAME")
        ],
    )
);
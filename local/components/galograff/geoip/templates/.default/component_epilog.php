<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;
Asset::getInstance()->addJs($templateFolder . "/vendor/jquery.inputmask/dist/jquery.inputmask.bundle.js");

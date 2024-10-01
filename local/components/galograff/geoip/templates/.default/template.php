<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\UI\Extension;
use Bitrix\Main\Localization\Loc;

Extension::load("ui.bootstrap4");
?>
<div class="container">
    <form name="search_ip" id="search_ip" class="d-inline-flex">
        <?= bitrix_sessid_post() ?>
        <input type="hidden" name="type" value="searchip">
        <div class="form-group">
            <input type="text" class="form-control" id="ip" name="ip"
                   placeholder="<?= Loc::GetMessage("GGEO_TMPL_INPUT_IP"); ?>">
        </div>
        <button type="submit" class="btn btn-primary"><?= Loc::GetMessage("GGEO_TMPL_CHECKED"); ?></button>
    </form>
    <div class="result alert mt-1 mb-1"></div>
    <?php
    if (!empty($arResult)) {
        ?>
        <div class="h2"><?= Loc::GetMessage("GGEO_TMPL_LIST"); ?></div>
        <ul class="ip-list">
            <?php
            foreach ($arResult as $k => $v) {
                ?>
                <li><?= $v['UF_IP'] ?> | <?= $v['UF_CITY'] ?> | <?= $v['UF_OTHER'] ?> |
                    <a href="#"
                       data-ip="<?= $v['ID'] ?>"
                       data-type="deleteip"
                       class="remove_ip">Удалить</a>
                </li>
                <?php
            } ?>
        </ul>
        <?php
    }
    ?>
</div>

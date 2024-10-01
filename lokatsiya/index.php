<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Определение города по IP");
?>

<?php
$APPLICATION->IncludeComponent(
	"galograff:geoip",
	"",
	Array(
		"HL_BLOCK" => "1"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
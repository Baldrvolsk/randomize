<?php
$APPLICATION->IncludeComponent(
    "baldr:randomize.draw",
    $templateName,
    Array(
        "DEMO_DRAW" => $arParams["DEMO_DRAW"],
        "DRAW_GROUP_PERMISSIONS" => $arParams["DRAW_GROUP_PERMISSIONS"],
        "LOTTERY_ID" => $arResult["VARIABLES"]["LOTTERY_ID"],
        "FOLDER" => $arResult["FOLDER"]
    )
);
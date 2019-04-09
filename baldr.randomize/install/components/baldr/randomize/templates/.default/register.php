<?php
$APPLICATION->IncludeComponent(
    "baldr:randomize.register",
    $templateName,
    Array(
        "FOLDER" => $arResult["FOLDER"],
        "URL_TEMPLATES" => $arResult["URL_TEMPLATES"],
        "VARIABLES" => $arResult["VARIABLES"],
        "EMAIL_TO" => $arResult["EMAIL_TO"],
        "OK_TEXT" => $arParams["OK_TEXT"],
        "USE_CAPTCHA" => $arParams["USE_CAPTCHA"]
    )
);
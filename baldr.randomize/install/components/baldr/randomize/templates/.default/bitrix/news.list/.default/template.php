<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="l-main l-main--grey">
	<div class="l-container n-l-container-overflow-hidden">
		<div class="n-wrap-geo n-wrap-geo--padding">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<div class="n-wrap-geo__news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<div class="n-wrap-geo__news-item__inside">
						<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
							<div class="n-wrap-geo__news-item__inside__pic">
								<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
									<a href="/optimalogi/<?=$arItem["PROPERTIES"]["OL_PAGE_LINK"]["VALUE"]?>/">
										<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
											title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" /></a>
								<?else:?>
									<img
										src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
										title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" />
								<?endif;?>
							</div>
						<?endif?>

						<div class="n-wrap-geo__news-item__inside__info">
							<div class="n-wrap-geo__news-item__inside__info__container">
								<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
									<div class="n-wrap-geo__news-item__inside__info__date">
										<?echo $arItem["DISPLAY_ACTIVE_FROM"]?>
									</div>
								<?endif?>

								<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
									<div class="n-wrap-geo__news-item__inside__info__header">
										<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
											<a href="/optimalogi/<?=$arItem["PROPERTIES"]["OL_PAGE_LINK"]["VALUE"]?>/"><?echo $arItem["NAME"]?></a>
										<?else:?>
											<?echo $arItem["NAME"]?>
										<?endif;?>
									</div>
								<?endif;?>

								<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
									<div class="n-wrap-geo__news-item__inside__info__text">
										<?echo $arItem["PREVIEW_TEXT"];?>
									</div>
								<?endif;?>

								<a href="/optimalogi/<?=$arItem["PROPERTIES"]["OL_PAGE_LINK"]["VALUE"]?>/" class="b-btn">Читать</a>
							</div>
						</div>
					</div>
				</div><!-- /.n-wrap-geo__news-item -->
			<?endforeach;?>
<pre>
<? var_dump($arResult); ?>
</pre>

		</div>
		<!-- /.n-wrap-geo -->
	</div>
	<!-- /.l-container -->
</div>
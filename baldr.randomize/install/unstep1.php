<?

use \Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid())
	return;

Loc::loadMessages(__FILE__);
?>
<form action="<?echo $APPLICATION->GetCurPage()?>">
<?=bitrix_sessid_post()?>
	<input type="hidden" name="lang" value="<?echo LANGUAGE_ID?>">
	<input type="hidden" name="id" value="baldr.randomize">
	<input type="hidden" name="uninstall" value="Y">
	<input type="hidden" name="step" value="2">
	<? CAdminMessage::ShowMessage(Loc::getMessage("MOD_UNINST_WARN"))?>
	<p><?echo Loc::getMessage("MOD_UNINST_SAVE")?></p>
	<p><input type="checkbox" name="savedata" id="savedata" value="Y" checked><label for="savedata"><?echo Loc::getMessage("MOD_UNINST_SAVE_TABLES")?></label></p>
    <p><input type="checkbox" name="savecomp" id="savecomp" value="Y" checked><label for="savecomp"><?echo Loc::getMessage("BALDR_RANDOMIZE_SAVE_COMPONENT")?></label></p>
	<input type="submit" name="" value="<?echo Loc::getMessage("MOD_UNINST_DEL")?>">
</form>
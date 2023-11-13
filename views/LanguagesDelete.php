<?php

namespace PHPMaker2023\new2023;

// Page object
$LanguagesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { languages: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var flanguagesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flanguagesdelete")
        .setPageId("delete")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="flanguagesdelete" id="flanguagesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="languages">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->Language_Code->Visible) { // Language_Code ?>
        <th class="<?= $Page->Language_Code->headerCellClass() ?>"><span id="elh_languages_Language_Code" class="languages_Language_Code"><?= $Page->Language_Code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Language_Name->Visible) { // Language_Name ?>
        <th class="<?= $Page->Language_Name->headerCellClass() ?>"><span id="elh_languages_Language_Name" class="languages_Language_Name"><?= $Page->Language_Name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Default->Visible) { // Default ?>
        <th class="<?= $Page->_Default->headerCellClass() ?>"><span id="elh_languages__Default" class="languages__Default"><?= $Page->_Default->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Site_Logo->Visible) { // Site_Logo ?>
        <th class="<?= $Page->Site_Logo->headerCellClass() ?>"><span id="elh_languages_Site_Logo" class="languages_Site_Logo"><?= $Page->Site_Logo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Site_Title->Visible) { // Site_Title ?>
        <th class="<?= $Page->Site_Title->headerCellClass() ?>"><span id="elh_languages_Site_Title" class="languages_Site_Title"><?= $Page->Site_Title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Default_Thousands_Separator->Visible) { // Default_Thousands_Separator ?>
        <th class="<?= $Page->Default_Thousands_Separator->headerCellClass() ?>"><span id="elh_languages_Default_Thousands_Separator" class="languages_Default_Thousands_Separator"><?= $Page->Default_Thousands_Separator->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Default_Decimal_Point->Visible) { // Default_Decimal_Point ?>
        <th class="<?= $Page->Default_Decimal_Point->headerCellClass() ?>"><span id="elh_languages_Default_Decimal_Point" class="languages_Default_Decimal_Point"><?= $Page->Default_Decimal_Point->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Default_Currency_Symbol->Visible) { // Default_Currency_Symbol ?>
        <th class="<?= $Page->Default_Currency_Symbol->headerCellClass() ?>"><span id="elh_languages_Default_Currency_Symbol" class="languages_Default_Currency_Symbol"><?= $Page->Default_Currency_Symbol->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Default_Money_Thousands_Separator->Visible) { // Default_Money_Thousands_Separator ?>
        <th class="<?= $Page->Default_Money_Thousands_Separator->headerCellClass() ?>"><span id="elh_languages_Default_Money_Thousands_Separator" class="languages_Default_Money_Thousands_Separator"><?= $Page->Default_Money_Thousands_Separator->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Default_Money_Decimal_Point->Visible) { // Default_Money_Decimal_Point ?>
        <th class="<?= $Page->Default_Money_Decimal_Point->headerCellClass() ?>"><span id="elh_languages_Default_Money_Decimal_Point" class="languages_Default_Money_Decimal_Point"><?= $Page->Default_Money_Decimal_Point->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->Language_Code->Visible) { // Language_Code ?>
        <td<?= $Page->Language_Code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_languages_Language_Code" class="el_languages_Language_Code">
<span<?= $Page->Language_Code->viewAttributes() ?>>
<?= $Page->Language_Code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Language_Name->Visible) { // Language_Name ?>
        <td<?= $Page->Language_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_languages_Language_Name" class="el_languages_Language_Name">
<span<?= $Page->Language_Name->viewAttributes() ?>>
<?= $Page->Language_Name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Default->Visible) { // Default ?>
        <td<?= $Page->_Default->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_languages__Default" class="el_languages__Default">
<span<?= $Page->_Default->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x__Default_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->_Default->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->_Default->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x__Default_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Site_Logo->Visible) { // Site_Logo ?>
        <td<?= $Page->Site_Logo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_languages_Site_Logo" class="el_languages_Site_Logo">
<span<?= $Page->Site_Logo->viewAttributes() ?>>
<?= $Page->Site_Logo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Site_Title->Visible) { // Site_Title ?>
        <td<?= $Page->Site_Title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_languages_Site_Title" class="el_languages_Site_Title">
<span<?= $Page->Site_Title->viewAttributes() ?>>
<?= $Page->Site_Title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Default_Thousands_Separator->Visible) { // Default_Thousands_Separator ?>
        <td<?= $Page->Default_Thousands_Separator->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_languages_Default_Thousands_Separator" class="el_languages_Default_Thousands_Separator">
<span<?= $Page->Default_Thousands_Separator->viewAttributes() ?>>
<?= $Page->Default_Thousands_Separator->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Default_Decimal_Point->Visible) { // Default_Decimal_Point ?>
        <td<?= $Page->Default_Decimal_Point->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_languages_Default_Decimal_Point" class="el_languages_Default_Decimal_Point">
<span<?= $Page->Default_Decimal_Point->viewAttributes() ?>>
<?= $Page->Default_Decimal_Point->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Default_Currency_Symbol->Visible) { // Default_Currency_Symbol ?>
        <td<?= $Page->Default_Currency_Symbol->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_languages_Default_Currency_Symbol" class="el_languages_Default_Currency_Symbol">
<span<?= $Page->Default_Currency_Symbol->viewAttributes() ?>>
<?= $Page->Default_Currency_Symbol->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Default_Money_Thousands_Separator->Visible) { // Default_Money_Thousands_Separator ?>
        <td<?= $Page->Default_Money_Thousands_Separator->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_languages_Default_Money_Thousands_Separator" class="el_languages_Default_Money_Thousands_Separator">
<span<?= $Page->Default_Money_Thousands_Separator->viewAttributes() ?>>
<?= $Page->Default_Money_Thousands_Separator->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Default_Money_Decimal_Point->Visible) { // Default_Money_Decimal_Point ?>
        <td<?= $Page->Default_Money_Decimal_Point->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_languages_Default_Money_Decimal_Point" class="el_languages_Default_Money_Decimal_Point">
<span<?= $Page->Default_Money_Decimal_Point->viewAttributes() ?>>
<?= $Page->Default_Money_Decimal_Point->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(flanguagesdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#flanguagesdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

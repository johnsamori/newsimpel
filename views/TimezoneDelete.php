<?php

namespace PHPMaker2023\new2023;

// Page object
$TimezoneDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { timezone: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var ftimezonedelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftimezonedelete")
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
<form name="ftimezonedelete" id="ftimezonedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="timezone">
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
<?php if ($Page->ID->Visible) { // ID ?>
        <th class="<?= $Page->ID->headerCellClass() ?>"><span id="elh_timezone_ID" class="timezone_ID"><?= $Page->ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Timezone->Visible) { // Timezone ?>
        <th class="<?= $Page->Timezone->headerCellClass() ?>"><span id="elh_timezone_Timezone" class="timezone_Timezone"><?= $Page->Timezone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Default->Visible) { // Default ?>
        <th class="<?= $Page->_Default->headerCellClass() ?>"><span id="elh_timezone__Default" class="timezone__Default"><?= $Page->_Default->caption() ?></span></th>
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
<?php if ($Page->ID->Visible) { // ID ?>
        <td<?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_timezone_ID" class="el_timezone_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Timezone->Visible) { // Timezone ?>
        <td<?= $Page->Timezone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_timezone_Timezone" class="el_timezone_Timezone">
<span<?= $Page->Timezone->viewAttributes() ?>>
<?= $Page->Timezone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Default->Visible) { // Default ?>
        <td<?= $Page->_Default->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_timezone__Default" class="el_timezone__Default">
<span<?= $Page->_Default->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x__Default_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->_Default->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->_Default->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x__Default_<?= $Page->RowCount ?>"></label>
</div></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(ftimezonedelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#ftimezonedelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

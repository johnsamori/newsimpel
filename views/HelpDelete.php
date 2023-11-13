<?php

namespace PHPMaker2023\new2023;

// Page object
$HelpDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { help: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fhelpdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fhelpdelete")
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
<form name="fhelpdelete" id="fhelpdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="help">
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
<?php if ($Page->Help_ID->Visible) { // Help_ID ?>
        <th class="<?= $Page->Help_ID->headerCellClass() ?>"><span id="elh_help_Help_ID" class="help_Help_ID"><?= $Page->Help_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Language->Visible) { // Language ?>
        <th class="<?= $Page->_Language->headerCellClass() ?>"><span id="elh_help__Language" class="help__Language"><?= $Page->_Language->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Topic->Visible) { // Topic ?>
        <th class="<?= $Page->Topic->headerCellClass() ?>"><span id="elh_help_Topic" class="help_Topic"><?= $Page->Topic->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
        <th class="<?= $Page->Category->headerCellClass() ?>"><span id="elh_help_Category" class="help_Category"><?= $Page->Category->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Order->Visible) { // Order ?>
        <th class="<?= $Page->Order->headerCellClass() ?>"><span id="elh_help_Order" class="help_Order"><?= $Page->Order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Display_in_Page->Visible) { // Display_in_Page ?>
        <th class="<?= $Page->Display_in_Page->headerCellClass() ?>"><span id="elh_help_Display_in_Page" class="help_Display_in_Page"><?= $Page->Display_in_Page->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Updated_By->Visible) { // Updated_By ?>
        <th class="<?= $Page->Updated_By->headerCellClass() ?>"><span id="elh_help_Updated_By" class="help_Updated_By"><?= $Page->Updated_By->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Last_Updated->Visible) { // Last_Updated ?>
        <th class="<?= $Page->Last_Updated->headerCellClass() ?>"><span id="elh_help_Last_Updated" class="help_Last_Updated"><?= $Page->Last_Updated->caption() ?></span></th>
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
<?php if ($Page->Help_ID->Visible) { // Help_ID ?>
        <td<?= $Page->Help_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_help_Help_ID" class="el_help_Help_ID">
<span<?= $Page->Help_ID->viewAttributes() ?>>
<?= $Page->Help_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Language->Visible) { // Language ?>
        <td<?= $Page->_Language->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_help__Language" class="el_help__Language">
<span<?= $Page->_Language->viewAttributes() ?>>
<?= $Page->_Language->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Topic->Visible) { // Topic ?>
        <td<?= $Page->Topic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_help_Topic" class="el_help_Topic">
<span<?= $Page->Topic->viewAttributes() ?>>
<?= $Page->Topic->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
        <td<?= $Page->Category->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_help_Category" class="el_help_Category">
<span<?= $Page->Category->viewAttributes() ?>>
<?= $Page->Category->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Order->Visible) { // Order ?>
        <td<?= $Page->Order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_help_Order" class="el_help_Order">
<span<?= $Page->Order->viewAttributes() ?>>
<?= $Page->Order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Display_in_Page->Visible) { // Display_in_Page ?>
        <td<?= $Page->Display_in_Page->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_help_Display_in_Page" class="el_help_Display_in_Page">
<span<?= $Page->Display_in_Page->viewAttributes() ?>>
<?= $Page->Display_in_Page->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Updated_By->Visible) { // Updated_By ?>
        <td<?= $Page->Updated_By->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_help_Updated_By" class="el_help_Updated_By">
<span<?= $Page->Updated_By->viewAttributes() ?>>
<?= $Page->Updated_By->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Last_Updated->Visible) { // Last_Updated ?>
        <td<?= $Page->Last_Updated->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_help_Last_Updated" class="el_help_Last_Updated">
<span<?= $Page->Last_Updated->viewAttributes() ?>>
<?= $Page->Last_Updated->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fhelpdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fhelpdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

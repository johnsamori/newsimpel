<?php

namespace PHPMaker2023\new2023;

// Page object
$ProposalPengabdianStatusDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposal_pengabdian_status: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fproposal_pengabdian_statusdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fproposal_pengabdian_statusdelete")
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
<form name="fproposal_pengabdian_statusdelete" id="fproposal_pengabdian_statusdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proposal_pengabdian_status">
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
<?php if ($Page->id_pengabdian->Visible) { // id_pengabdian ?>
        <th class="<?= $Page->id_pengabdian->headerCellClass() ?>"><span id="elh_proposal_pengabdian_status_id_pengabdian" class="proposal_pengabdian_status_id_pengabdian"><?= $Page->id_pengabdian->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
        <th class="<?= $Page->Kelompok_ID->headerCellClass() ?>"><span id="elh_proposal_pengabdian_status_Kelompok_ID" class="proposal_pengabdian_status_Kelompok_ID"><?= $Page->Kelompok_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th class="<?= $Page->Status->headerCellClass() ?>"><span id="elh_proposal_pengabdian_status_Status" class="proposal_pengabdian_status_Status"><?= $Page->Status->caption() ?></span></th>
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
<?php if ($Page->id_pengabdian->Visible) { // id_pengabdian ?>
        <td<?= $Page->id_pengabdian->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian">
<span<?= $Page->id_pengabdian->viewAttributes() ?>>
<?= $Page->id_pengabdian->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
        <td<?= $Page->Kelompok_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
<span<?= $Page->Kelompok_ID->viewAttributes() ?>>
<?= $Page->Kelompok_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <td<?= $Page->Status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fproposal_pengabdian_statusdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fproposal_pengabdian_statusdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

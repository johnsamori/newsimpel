<?php

namespace PHPMaker2023\new2023;

// Page object
$ProposalPenelitianDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposal_penelitian: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fproposal_penelitiandelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fproposal_penelitiandelete")
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
<form name="fproposal_penelitiandelete" id="fproposal_penelitiandelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proposal_penelitian">
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
<?php if ($Page->Id_kelompok->Visible) { // Id_kelompok ?>
        <th class="<?= $Page->Id_kelompok->headerCellClass() ?>"><span id="elh_proposal_penelitian_Id_kelompok" class="proposal_penelitian_Id_kelompok"><?= $Page->Id_kelompok->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Warna_Kaver->Visible) { // Warna_Kaver ?>
        <th class="<?= $Page->Warna_Kaver->headerCellClass() ?>"><span id="elh_proposal_penelitian_Warna_Kaver" class="proposal_penelitian_Warna_Kaver"><?= $Page->Warna_Kaver->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <th class="<?= $Page->Lembar_Pengesahan->headerCellClass() ?>"><span id="elh_proposal_penelitian_Lembar_Pengesahan" class="proposal_penelitian_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Soft_copy_Proposal->Visible) { // Soft_copy_Proposal ?>
        <th class="<?= $Page->Soft_copy_Proposal->headerCellClass() ?>"><span id="elh_proposal_penelitian_Soft_copy_Proposal" class="proposal_penelitian_Soft_copy_Proposal"><?= $Page->Soft_copy_Proposal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Surat_Pernyataan_Tidak_Studi->Visible) { // Surat_Pernyataan_Tidak_Studi ?>
        <th class="<?= $Page->Surat_Pernyataan_Tidak_Studi->headerCellClass() ?>"><span id="elh_proposal_penelitian_Surat_Pernyataan_Tidak_Studi" class="proposal_penelitian_Surat_Pernyataan_Tidak_Studi"><?= $Page->Surat_Pernyataan_Tidak_Studi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <th class="<?= $Page->Tanggal->headerCellClass() ?>"><span id="elh_proposal_penelitian_Tanggal" class="proposal_penelitian_Tanggal"><?= $Page->Tanggal->caption() ?></span></th>
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
<?php if ($Page->Id_kelompok->Visible) { // Id_kelompok ?>
        <td<?= $Page->Id_kelompok->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proposal_penelitian_Id_kelompok" class="el_proposal_penelitian_Id_kelompok">
<span<?= $Page->Id_kelompok->viewAttributes() ?>>
<?= $Page->Id_kelompok->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Warna_Kaver->Visible) { // Warna_Kaver ?>
        <td<?= $Page->Warna_Kaver->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proposal_penelitian_Warna_Kaver" class="el_proposal_penelitian_Warna_Kaver">
<span<?= $Page->Warna_Kaver->viewAttributes() ?>>
<?= $Page->Warna_Kaver->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <td<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proposal_penelitian_Lembar_Pengesahan" class="el_proposal_penelitian_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Soft_copy_Proposal->Visible) { // Soft_copy_Proposal ?>
        <td<?= $Page->Soft_copy_Proposal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proposal_penelitian_Soft_copy_Proposal" class="el_proposal_penelitian_Soft_copy_Proposal">
<span<?= $Page->Soft_copy_Proposal->viewAttributes() ?>>
<?= GetFileViewTag($Page->Soft_copy_Proposal, $Page->Soft_copy_Proposal->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Surat_Pernyataan_Tidak_Studi->Visible) { // Surat_Pernyataan_Tidak_Studi ?>
        <td<?= $Page->Surat_Pernyataan_Tidak_Studi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proposal_penelitian_Surat_Pernyataan_Tidak_Studi" class="el_proposal_penelitian_Surat_Pernyataan_Tidak_Studi">
<span<?= $Page->Surat_Pernyataan_Tidak_Studi->viewAttributes() ?>>
<?= GetFileViewTag($Page->Surat_Pernyataan_Tidak_Studi, $Page->Surat_Pernyataan_Tidak_Studi->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <td<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proposal_penelitian_Tanggal" class="el_proposal_penelitian_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fproposal_penelitiandelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fproposal_penelitiandelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

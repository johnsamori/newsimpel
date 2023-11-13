<?php

namespace PHPMaker2023\new2023;

// Page object
$KelompokPengabdianDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kelompok_pengabdian: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fkelompok_pengabdiandelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkelompok_pengabdiandelete")
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
<form name="fkelompok_pengabdiandelete" id="fkelompok_pengabdiandelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kelompok_pengabdian">
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
<?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
        <th class="<?= $Page->Id_Kelompok->headerCellClass() ?>"><span id="elh_kelompok_pengabdian_Id_Kelompok" class="kelompok_pengabdian_Id_Kelompok"><?= $Page->Id_Kelompok->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
        <th class="<?= $Page->Nama_Ketua->headerCellClass() ?>"><span id="elh_kelompok_pengabdian_Nama_Ketua" class="kelompok_pengabdian_Nama_Ketua"><?= $Page->Nama_Ketua->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
        <th class="<?= $Page->Nama_Anggota_1->headerCellClass() ?>"><span id="elh_kelompok_pengabdian_Nama_Anggota_1" class="kelompok_pengabdian_Nama_Anggota_1"><?= $Page->Nama_Anggota_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
        <th class="<?= $Page->Nama_Anggota_2->headerCellClass() ?>"><span id="elh_kelompok_pengabdian_Nama_Anggota_2" class="kelompok_pengabdian_Nama_Anggota_2"><?= $Page->Nama_Anggota_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <th class="<?= $Page->Tanggal->headerCellClass() ?>"><span id="elh_kelompok_pengabdian_Tanggal" class="kelompok_pengabdian_Tanggal"><?= $Page->Tanggal->caption() ?></span></th>
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
<?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
        <td<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kelompok_pengabdian_Id_Kelompok" class="el_kelompok_pengabdian_Id_Kelompok">
<span<?= $Page->Id_Kelompok->viewAttributes() ?>>
<?= $Page->Id_Kelompok->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
        <td<?= $Page->Nama_Ketua->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kelompok_pengabdian_Nama_Ketua" class="el_kelompok_pengabdian_Nama_Ketua">
<span<?= $Page->Nama_Ketua->viewAttributes() ?>>
<?= $Page->Nama_Ketua->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
        <td<?= $Page->Nama_Anggota_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kelompok_pengabdian_Nama_Anggota_1" class="el_kelompok_pengabdian_Nama_Anggota_1">
<span<?= $Page->Nama_Anggota_1->viewAttributes() ?>>
<?= $Page->Nama_Anggota_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
        <td<?= $Page->Nama_Anggota_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kelompok_pengabdian_Nama_Anggota_2" class="el_kelompok_pengabdian_Nama_Anggota_2">
<span<?= $Page->Nama_Anggota_2->viewAttributes() ?>>
<?= $Page->Nama_Anggota_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <td<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kelompok_pengabdian_Tanggal" class="el_kelompok_pengabdian_Tanggal">
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkelompok_pengabdiandelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fkelompok_pengabdiandelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

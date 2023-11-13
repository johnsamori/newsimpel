<?php

namespace PHPMaker2023\new2023;

// Page object
$LaporanPenelitianDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { laporan_penelitian: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var flaporan_penelitiandelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flaporan_penelitiandelete")
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
<form name="flaporan_penelitiandelete" id="flaporan_penelitiandelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="laporan_penelitian">
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
        <th class="<?= $Page->Id_Kelompok->headerCellClass() ?>"><span id="elh_laporan_penelitian_Id_Kelompok" class="laporan_penelitian_Id_Kelompok"><?= $Page->Id_Kelompok->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <th class="<?= $Page->Lembar_Pengesahan->headerCellClass() ?>"><span id="elh_laporan_penelitian_Lembar_Pengesahan" class="laporan_penelitian_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Laporan->Visible) { // Laporan ?>
        <th class="<?= $Page->Laporan->headerCellClass() ?>"><span id="elh_laporan_penelitian_Laporan" class="laporan_penelitian_Laporan"><?= $Page->Laporan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Luaran->Visible) { // Luaran ?>
        <th class="<?= $Page->Luaran->headerCellClass() ?>"><span id="elh_laporan_penelitian_Luaran" class="laporan_penelitian_Luaran"><?= $Page->Luaran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Surat_Pernyataan_Kesediaan_Anggota->Visible) { // Surat_Pernyataan_Kesediaan_Anggota ?>
        <th class="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->headerCellClass() ?>"><span id="elh_laporan_penelitian_Surat_Pernyataan_Kesediaan_Anggota" class="laporan_penelitian_Surat_Pernyataan_Kesediaan_Anggota"><?= $Page->Surat_Pernyataan_Kesediaan_Anggota->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <th class="<?= $Page->Tanggal->headerCellClass() ?>"><span id="elh_laporan_penelitian_Tanggal" class="laporan_penelitian_Tanggal"><?= $Page->Tanggal->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_laporan_penelitian_Id_Kelompok" class="el_laporan_penelitian_Id_Kelompok">
<span<?= $Page->Id_Kelompok->viewAttributes() ?>>
<?= $Page->Id_Kelompok->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <td<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_penelitian_Lembar_Pengesahan" class="el_laporan_penelitian_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Laporan->Visible) { // Laporan ?>
        <td<?= $Page->Laporan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_penelitian_Laporan" class="el_laporan_penelitian_Laporan">
<span<?= $Page->Laporan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Laporan, $Page->Laporan->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Luaran->Visible) { // Luaran ?>
        <td<?= $Page->Luaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_penelitian_Luaran" class="el_laporan_penelitian_Luaran">
<span<?= $Page->Luaran->viewAttributes() ?>>
<?= GetFileViewTag($Page->Luaran, $Page->Luaran->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Surat_Pernyataan_Kesediaan_Anggota->Visible) { // Surat_Pernyataan_Kesediaan_Anggota ?>
        <td<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_penelitian_Surat_Pernyataan_Kesediaan_Anggota" class="el_laporan_penelitian_Surat_Pernyataan_Kesediaan_Anggota">
<span<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->viewAttributes() ?>>
<?= GetFileViewTag($Page->Surat_Pernyataan_Kesediaan_Anggota, $Page->Surat_Pernyataan_Kesediaan_Anggota->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <td<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_penelitian_Tanggal" class="el_laporan_penelitian_Tanggal">
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(flaporan_penelitiandelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#flaporan_penelitiandelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

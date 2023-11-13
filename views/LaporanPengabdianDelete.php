<?php

namespace PHPMaker2023\new2023;

// Page object
$LaporanPengabdianDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { laporan_pengabdian: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var flaporan_pengabdiandelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flaporan_pengabdiandelete")
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
<form name="flaporan_pengabdiandelete" id="flaporan_pengabdiandelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="laporan_pengabdian">
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
        <th class="<?= $Page->Id_kelompok->headerCellClass() ?>"><span id="elh_laporan_pengabdian_Id_kelompok" class="laporan_pengabdian_Id_kelompok"><?= $Page->Id_kelompok->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <th class="<?= $Page->Lembar_Pengesahan->headerCellClass() ?>"><span id="elh_laporan_pengabdian_Lembar_Pengesahan" class="laporan_pengabdian_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Laporan->Visible) { // Laporan ?>
        <th class="<?= $Page->Laporan->headerCellClass() ?>"><span id="elh_laporan_pengabdian_Laporan" class="laporan_pengabdian_Laporan"><?= $Page->Laporan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Luaran->Visible) { // Luaran ?>
        <th class="<?= $Page->Luaran->headerCellClass() ?>"><span id="elh_laporan_pengabdian_Luaran" class="laporan_pengabdian_Luaran"><?= $Page->Luaran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Surat_Keterangan_dari_Tempat_Mengabdi->Visible) { // Surat_Keterangan_dari_Tempat_Mengabdi ?>
        <th class="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->headerCellClass() ?>"><span id="elh_laporan_pengabdian_Surat_Keterangan_dari_Tempat_Mengabdi" class="laporan_pengabdian_Surat_Keterangan_dari_Tempat_Mengabdi"><?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Dokumentasi->Visible) { // Dokumentasi ?>
        <th class="<?= $Page->Dokumentasi->headerCellClass() ?>"><span id="elh_laporan_pengabdian_Dokumentasi" class="laporan_pengabdian_Dokumentasi"><?= $Page->Dokumentasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Daftar_Hadir->Visible) { // Daftar_Hadir ?>
        <th class="<?= $Page->Daftar_Hadir->headerCellClass() ?>"><span id="elh_laporan_pengabdian_Daftar_Hadir" class="laporan_pengabdian_Daftar_Hadir"><?= $Page->Daftar_Hadir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <th class="<?= $Page->Tanggal->headerCellClass() ?>"><span id="elh_laporan_pengabdian_Tanggal" class="laporan_pengabdian_Tanggal"><?= $Page->Tanggal->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_laporan_pengabdian_Id_kelompok" class="el_laporan_pengabdian_Id_kelompok">
<span<?= $Page->Id_kelompok->viewAttributes() ?>>
<?= $Page->Id_kelompok->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <td<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_pengabdian_Lembar_Pengesahan" class="el_laporan_pengabdian_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Laporan->Visible) { // Laporan ?>
        <td<?= $Page->Laporan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_pengabdian_Laporan" class="el_laporan_pengabdian_Laporan">
<span<?= $Page->Laporan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Laporan, $Page->Laporan->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Luaran->Visible) { // Luaran ?>
        <td<?= $Page->Luaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_pengabdian_Luaran" class="el_laporan_pengabdian_Luaran">
<span<?= $Page->Luaran->viewAttributes() ?>>
<?= GetFileViewTag($Page->Luaran, $Page->Luaran->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Surat_Keterangan_dari_Tempat_Mengabdi->Visible) { // Surat_Keterangan_dari_Tempat_Mengabdi ?>
        <td<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_pengabdian_Surat_Keterangan_dari_Tempat_Mengabdi" class="el_laporan_pengabdian_Surat_Keterangan_dari_Tempat_Mengabdi">
<span<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->viewAttributes() ?>>
<?= GetFileViewTag($Page->Surat_Keterangan_dari_Tempat_Mengabdi, $Page->Surat_Keterangan_dari_Tempat_Mengabdi->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Dokumentasi->Visible) { // Dokumentasi ?>
        <td<?= $Page->Dokumentasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_pengabdian_Dokumentasi" class="el_laporan_pengabdian_Dokumentasi">
<span<?= $Page->Dokumentasi->viewAttributes() ?>>
<?= GetFileViewTag($Page->Dokumentasi, $Page->Dokumentasi->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Daftar_Hadir->Visible) { // Daftar_Hadir ?>
        <td<?= $Page->Daftar_Hadir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_pengabdian_Daftar_Hadir" class="el_laporan_pengabdian_Daftar_Hadir">
<span<?= $Page->Daftar_Hadir->viewAttributes() ?>>
<?= GetFileViewTag($Page->Daftar_Hadir, $Page->Daftar_Hadir->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <td<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_laporan_pengabdian_Tanggal" class="el_laporan_pengabdian_Tanggal">
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(flaporan_pengabdiandelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#flaporan_pengabdiandelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

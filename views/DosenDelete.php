<?php

namespace PHPMaker2023\new2023;

// Page object
$DosenDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dosen: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fdosendelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdosendelete")
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
<form name="fdosendelete" id="fdosendelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="dosen">
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
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <th class="<?= $Page->NIDN->headerCellClass() ?>"><span id="elh_dosen_NIDN" class="dosen_NIDN"><?= $Page->NIDN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
        <th class="<?= $Page->Id_Sinta->headerCellClass() ?>"><span id="elh_dosen_Id_Sinta" class="dosen_Id_Sinta"><?= $Page->Id_Sinta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <th class="<?= $Page->Nama_Lengkap->headerCellClass() ?>"><span id="elh_dosen_Nama_Lengkap" class="dosen_Nama_Lengkap"><?= $Page->Nama_Lengkap->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <th class="<?= $Page->Alamat->headerCellClass() ?>"><span id="elh_dosen_Alamat" class="dosen_Alamat"><?= $Page->Alamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th class="<?= $Page->_Email->headerCellClass() ?>"><span id="elh_dosen__Email" class="dosen__Email"><?= $Page->_Email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <th class="<?= $Page->Jenis_Kelamin->headerCellClass() ?>"><span id="elh_dosen_Jenis_Kelamin" class="dosen_Jenis_Kelamin"><?= $Page->Jenis_Kelamin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
        <th class="<?= $Page->Program_Studi->headerCellClass() ?>"><span id="elh_dosen_Program_Studi" class="dosen_Program_Studi"><?= $Page->Program_Studi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
        <th class="<?= $Page->Jenjang_Pendidikan->headerCellClass() ?>"><span id="elh_dosen_Jenjang_Pendidikan" class="dosen_Jenjang_Pendidikan"><?= $Page->Jenjang_Pendidikan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
        <th class="<?= $Page->Jabatan_Fungsional->headerCellClass() ?>"><span id="elh_dosen_Jabatan_Fungsional" class="dosen_Jabatan_Fungsional"><?= $Page->Jabatan_Fungsional->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
        <th class="<?= $Page->Kepakaran->headerCellClass() ?>"><span id="elh_dosen_Kepakaran" class="dosen_Kepakaran"><?= $Page->Kepakaran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
        <th class="<?= $Page->Rumpun_Ilmu->headerCellClass() ?>"><span id="elh_dosen_Rumpun_Ilmu" class="dosen_Rumpun_Ilmu"><?= $Page->Rumpun_Ilmu->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Aktif->Visible) { // Aktif ?>
        <th class="<?= $Page->Aktif->headerCellClass() ?>"><span id="elh_dosen_Aktif" class="dosen_Aktif"><?= $Page->Aktif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Validasi->Visible) { // Validasi ?>
        <th class="<?= $Page->Validasi->headerCellClass() ?>"><span id="elh_dosen_Validasi" class="dosen_Validasi"><?= $Page->Validasi->caption() ?></span></th>
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
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <td<?= $Page->NIDN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_NIDN" class="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
        <td<?= $Page->Id_Sinta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Id_Sinta" class="el_dosen_Id_Sinta">
<span<?= $Page->Id_Sinta->viewAttributes() ?>>
<?= $Page->Id_Sinta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <td<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Nama_Lengkap" class="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <td<?= $Page->Alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Alamat" class="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <td<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen__Email" class="el_dosen__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <td<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jenis_Kelamin" class="el_dosen_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
        <td<?= $Page->Program_Studi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Program_Studi" class="el_dosen_Program_Studi">
<span<?= $Page->Program_Studi->viewAttributes() ?>>
<?= $Page->Program_Studi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
        <td<?= $Page->Jenjang_Pendidikan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jenjang_Pendidikan" class="el_dosen_Jenjang_Pendidikan">
<span<?= $Page->Jenjang_Pendidikan->viewAttributes() ?>>
<?= $Page->Jenjang_Pendidikan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
        <td<?= $Page->Jabatan_Fungsional->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jabatan_Fungsional" class="el_dosen_Jabatan_Fungsional">
<span<?= $Page->Jabatan_Fungsional->viewAttributes() ?>>
<?= $Page->Jabatan_Fungsional->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
        <td<?= $Page->Kepakaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Kepakaran" class="el_dosen_Kepakaran">
<span<?= $Page->Kepakaran->viewAttributes() ?>>
<?= $Page->Kepakaran->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
        <td<?= $Page->Rumpun_Ilmu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Rumpun_Ilmu" class="el_dosen_Rumpun_Ilmu">
<span<?= $Page->Rumpun_Ilmu->viewAttributes() ?>>
<?= $Page->Rumpun_Ilmu->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Aktif->Visible) { // Aktif ?>
        <td<?= $Page->Aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Aktif" class="el_dosen_Aktif">
<span<?= $Page->Aktif->viewAttributes() ?>>
<?= $Page->Aktif->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Validasi->Visible) { // Validasi ?>
        <td<?= $Page->Validasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Validasi" class="el_dosen_Validasi">
<span<?= $Page->Validasi->viewAttributes() ?>>
<?= $Page->Validasi->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosendelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosendelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

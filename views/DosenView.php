<?php

namespace PHPMaker2023\new2023;

// Page object
$DosenView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="col-md-12">
  <div class="card shadow-sm">
    <div class="card-header">
	  <h4 class="card-title"><?php echo Language()->phrase("ViewCaption"); ?></h4>
	  <div class="card-tools">
	  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
	  </button>
	  </div>
	  <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
<?php } ?>
<form name="fdosenview" id="fdosenview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dosen: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fdosenview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdosenview")
        .setPageId("view")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="dosen">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->NIDN->Visible) { // NIDN ?>
    <tr id="r_NIDN"<?= $Page->NIDN->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_NIDN"><?= $Page->NIDN->caption() ?></span></td>
        <td data-name="NIDN"<?= $Page->NIDN->cellAttributes() ?>>
<span id="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
    <tr id="r_Id_Sinta"<?= $Page->Id_Sinta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Id_Sinta"><?= $Page->Id_Sinta->caption() ?></span></td>
        <td data-name="Id_Sinta"<?= $Page->Id_Sinta->cellAttributes() ?>>
<span id="el_dosen_Id_Sinta">
<span<?= $Page->Id_Sinta->viewAttributes() ?>>
<?= $Page->Id_Sinta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
    <tr id="r_Nama_Lengkap"<?= $Page->Nama_Lengkap->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Nama_Lengkap"><?= $Page->Nama_Lengkap->caption() ?></span></td>
        <td data-name="Nama_Lengkap"<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
    <tr id="r_Alamat"<?= $Page->Alamat->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Alamat"><?= $Page->Alamat->caption() ?></span></td>
        <td data-name="Alamat"<?= $Page->Alamat->cellAttributes() ?>>
<span id="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
    <tr id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen__Email"><?= $Page->_Email->caption() ?></span></td>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el_dosen__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
    <tr id="r_Jenis_Kelamin"<?= $Page->Jenis_Kelamin->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Jenis_Kelamin"><?= $Page->Jenis_Kelamin->caption() ?></span></td>
        <td data-name="Jenis_Kelamin"<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el_dosen_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
    <tr id="r_Program_Studi"<?= $Page->Program_Studi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Program_Studi"><?= $Page->Program_Studi->caption() ?></span></td>
        <td data-name="Program_Studi"<?= $Page->Program_Studi->cellAttributes() ?>>
<span id="el_dosen_Program_Studi">
<span<?= $Page->Program_Studi->viewAttributes() ?>>
<?= $Page->Program_Studi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
    <tr id="r_Jenjang_Pendidikan"<?= $Page->Jenjang_Pendidikan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Jenjang_Pendidikan"><?= $Page->Jenjang_Pendidikan->caption() ?></span></td>
        <td data-name="Jenjang_Pendidikan"<?= $Page->Jenjang_Pendidikan->cellAttributes() ?>>
<span id="el_dosen_Jenjang_Pendidikan">
<span<?= $Page->Jenjang_Pendidikan->viewAttributes() ?>>
<?= $Page->Jenjang_Pendidikan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
    <tr id="r_Jabatan_Fungsional"<?= $Page->Jabatan_Fungsional->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Jabatan_Fungsional"><?= $Page->Jabatan_Fungsional->caption() ?></span></td>
        <td data-name="Jabatan_Fungsional"<?= $Page->Jabatan_Fungsional->cellAttributes() ?>>
<span id="el_dosen_Jabatan_Fungsional">
<span<?= $Page->Jabatan_Fungsional->viewAttributes() ?>>
<?= $Page->Jabatan_Fungsional->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
    <tr id="r_Kepakaran"<?= $Page->Kepakaran->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Kepakaran"><?= $Page->Kepakaran->caption() ?></span></td>
        <td data-name="Kepakaran"<?= $Page->Kepakaran->cellAttributes() ?>>
<span id="el_dosen_Kepakaran">
<span<?= $Page->Kepakaran->viewAttributes() ?>>
<?= $Page->Kepakaran->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
    <tr id="r_Rumpun_Ilmu"<?= $Page->Rumpun_Ilmu->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Rumpun_Ilmu"><?= $Page->Rumpun_Ilmu->caption() ?></span></td>
        <td data-name="Rumpun_Ilmu"<?= $Page->Rumpun_Ilmu->cellAttributes() ?>>
<span id="el_dosen_Rumpun_Ilmu">
<span<?= $Page->Rumpun_Ilmu->viewAttributes() ?>>
<?= $Page->Rumpun_Ilmu->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Aktif->Visible) { // Aktif ?>
    <tr id="r_Aktif"<?= $Page->Aktif->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Aktif"><?= $Page->Aktif->caption() ?></span></td>
        <td data-name="Aktif"<?= $Page->Aktif->cellAttributes() ?>>
<span id="el_dosen_Aktif">
<span<?= $Page->Aktif->viewAttributes() ?>>
<?= $Page->Aktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Validasi->Visible) { // Validasi ?>
    <tr id="r_Validasi"<?= $Page->Validasi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Validasi"><?= $Page->Validasi->caption() ?></span></td>
        <td data-name="Validasi"<?= $Page->Validasi->cellAttributes() ?>>
<span id="el_dosen_Validasi">
<span<?= $Page->Validasi->viewAttributes() ?>>
<?= $Page->Validasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<div class="clearfix">&nbsp;</div>
</form>
<?php if (!$Page->IsModal) { ?>
		</div>
     <!-- /.card-body -->
     </div>
  <!-- /.card -->
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdosenadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdosenedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php } ?>

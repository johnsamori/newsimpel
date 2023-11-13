<?php

namespace PHPMaker2023\new2023;

// Page object
$KelompokPengabdianView = &$Page;
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
<form name="fkelompok_pengabdianview" id="fkelompok_pengabdianview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kelompok_pengabdian: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fkelompok_pengabdianview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkelompok_pengabdianview")
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
<input type="hidden" name="t" value="kelompok_pengabdian">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
    <tr id="r_Id_Kelompok"<?= $Page->Id_Kelompok->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kelompok_pengabdian_Id_Kelompok"><?= $Page->Id_Kelompok->caption() ?></span></td>
        <td data-name="Id_Kelompok"<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Id_Kelompok">
<span<?= $Page->Id_Kelompok->viewAttributes() ?>>
<?= $Page->Id_Kelompok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
    <tr id="r_Nama_Ketua"<?= $Page->Nama_Ketua->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kelompok_pengabdian_Nama_Ketua"><?= $Page->Nama_Ketua->caption() ?></span></td>
        <td data-name="Nama_Ketua"<?= $Page->Nama_Ketua->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Nama_Ketua">
<span<?= $Page->Nama_Ketua->viewAttributes() ?>>
<?= $Page->Nama_Ketua->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
    <tr id="r_Nama_Anggota_1"<?= $Page->Nama_Anggota_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kelompok_pengabdian_Nama_Anggota_1"><?= $Page->Nama_Anggota_1->caption() ?></span></td>
        <td data-name="Nama_Anggota_1"<?= $Page->Nama_Anggota_1->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Nama_Anggota_1">
<span<?= $Page->Nama_Anggota_1->viewAttributes() ?>>
<?= $Page->Nama_Anggota_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
    <tr id="r_Nama_Anggota_2"<?= $Page->Nama_Anggota_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kelompok_pengabdian_Nama_Anggota_2"><?= $Page->Nama_Anggota_2->caption() ?></span></td>
        <td data-name="Nama_Anggota_2"<?= $Page->Nama_Anggota_2->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Nama_Anggota_2">
<span<?= $Page->Nama_Anggota_2->viewAttributes() ?>>
<?= $Page->Nama_Anggota_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <tr id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kelompok_pengabdian_Tanggal"><?= $Page->Tanggal->caption() ?></span></td>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkelompok_pengabdianadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkelompok_pengabdianadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkelompok_pengabdianedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkelompok_pengabdianedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php } ?>

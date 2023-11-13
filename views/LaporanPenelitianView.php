<?php

namespace PHPMaker2023\new2023;

// Page object
$LaporanPenelitianView = &$Page;
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
<form name="flaporan_penelitianview" id="flaporan_penelitianview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { laporan_penelitian: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var flaporan_penelitianview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flaporan_penelitianview")
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
<input type="hidden" name="t" value="laporan_penelitian">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
    <tr id="r_Id_Kelompok"<?= $Page->Id_Kelompok->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Id_Kelompok"><?= $Page->Id_Kelompok->caption() ?></span></td>
        <td data-name="Id_Kelompok"<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el_laporan_penelitian_Id_Kelompok">
<span<?= $Page->Id_Kelompok->viewAttributes() ?>>
<?= $Page->Id_Kelompok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
    <tr id="r_Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?></span></td>
        <td data-name="Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_laporan_penelitian_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Laporan->Visible) { // Laporan ?>
    <tr id="r_Laporan"<?= $Page->Laporan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Laporan"><?= $Page->Laporan->caption() ?></span></td>
        <td data-name="Laporan"<?= $Page->Laporan->cellAttributes() ?>>
<span id="el_laporan_penelitian_Laporan">
<span<?= $Page->Laporan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Laporan, $Page->Laporan->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Luaran->Visible) { // Luaran ?>
    <tr id="r_Luaran"<?= $Page->Luaran->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Luaran"><?= $Page->Luaran->caption() ?></span></td>
        <td data-name="Luaran"<?= $Page->Luaran->cellAttributes() ?>>
<span id="el_laporan_penelitian_Luaran">
<span<?= $Page->Luaran->viewAttributes() ?>>
<?= GetFileViewTag($Page->Luaran, $Page->Luaran->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Surat_Pernyataan_Kesediaan_Anggota->Visible) { // Surat_Pernyataan_Kesediaan_Anggota ?>
    <tr id="r_Surat_Pernyataan_Kesediaan_Anggota"<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Surat_Pernyataan_Kesediaan_Anggota"><?= $Page->Surat_Pernyataan_Kesediaan_Anggota->caption() ?></span></td>
        <td data-name="Surat_Pernyataan_Kesediaan_Anggota"<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->cellAttributes() ?>>
<span id="el_laporan_penelitian_Surat_Pernyataan_Kesediaan_Anggota">
<span<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->viewAttributes() ?>>
<?= GetFileViewTag($Page->Surat_Pernyataan_Kesediaan_Anggota, $Page->Surat_Pernyataan_Kesediaan_Anggota->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <tr id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Tanggal"><?= $Page->Tanggal->caption() ?></span></td>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_laporan_penelitian_Tanggal">
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(flaporan_penelitianadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#flaporan_penelitianadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(flaporan_penelitianedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#flaporan_penelitianedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php } ?>

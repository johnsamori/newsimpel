<?php

namespace PHPMaker2023\new2023;

// Page object
$LaporanPengabdianView = &$Page;
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
<form name="flaporan_pengabdianview" id="flaporan_pengabdianview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { laporan_pengabdian: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var flaporan_pengabdianview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flaporan_pengabdianview")
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
<input type="hidden" name="t" value="laporan_pengabdian">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Id_kelompok->Visible) { // Id_kelompok ?>
    <tr id="r_Id_kelompok"<?= $Page->Id_kelompok->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Id_kelompok"><?= $Page->Id_kelompok->caption() ?></span></td>
        <td data-name="Id_kelompok"<?= $Page->Id_kelompok->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Id_kelompok">
<span<?= $Page->Id_kelompok->viewAttributes() ?>>
<?= $Page->Id_kelompok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
    <tr id="r_Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?></span></td>
        <td data-name="Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Laporan->Visible) { // Laporan ?>
    <tr id="r_Laporan"<?= $Page->Laporan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Laporan"><?= $Page->Laporan->caption() ?></span></td>
        <td data-name="Laporan"<?= $Page->Laporan->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Laporan">
<span<?= $Page->Laporan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Laporan, $Page->Laporan->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Luaran->Visible) { // Luaran ?>
    <tr id="r_Luaran"<?= $Page->Luaran->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Luaran"><?= $Page->Luaran->caption() ?></span></td>
        <td data-name="Luaran"<?= $Page->Luaran->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Luaran">
<span<?= $Page->Luaran->viewAttributes() ?>>
<?= GetFileViewTag($Page->Luaran, $Page->Luaran->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Surat_Keterangan_dari_Tempat_Mengabdi->Visible) { // Surat_Keterangan_dari_Tempat_Mengabdi ?>
    <tr id="r_Surat_Keterangan_dari_Tempat_Mengabdi"<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Surat_Keterangan_dari_Tempat_Mengabdi"><?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->caption() ?></span></td>
        <td data-name="Surat_Keterangan_dari_Tempat_Mengabdi"<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Surat_Keterangan_dari_Tempat_Mengabdi">
<span<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->viewAttributes() ?>>
<?= GetFileViewTag($Page->Surat_Keterangan_dari_Tempat_Mengabdi, $Page->Surat_Keterangan_dari_Tempat_Mengabdi->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Dokumentasi->Visible) { // Dokumentasi ?>
    <tr id="r_Dokumentasi"<?= $Page->Dokumentasi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Dokumentasi"><?= $Page->Dokumentasi->caption() ?></span></td>
        <td data-name="Dokumentasi"<?= $Page->Dokumentasi->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Dokumentasi">
<span<?= $Page->Dokumentasi->viewAttributes() ?>>
<?= GetFileViewTag($Page->Dokumentasi, $Page->Dokumentasi->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Daftar_Hadir->Visible) { // Daftar_Hadir ?>
    <tr id="r_Daftar_Hadir"<?= $Page->Daftar_Hadir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Daftar_Hadir"><?= $Page->Daftar_Hadir->caption() ?></span></td>
        <td data-name="Daftar_Hadir"<?= $Page->Daftar_Hadir->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Daftar_Hadir">
<span<?= $Page->Daftar_Hadir->viewAttributes() ?>>
<?= GetFileViewTag($Page->Daftar_Hadir, $Page->Daftar_Hadir->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <tr id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Tanggal"><?= $Page->Tanggal->caption() ?></span></td>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Tanggal">
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(flaporan_pengabdianadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#flaporan_pengabdianadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(flaporan_pengabdianedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#flaporan_pengabdianedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php } ?>

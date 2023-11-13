<?php

namespace PHPMaker2023\new2023;

// Page object
$ProposalPenelitianView = &$Page;
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
<form name="fproposal_penelitianview" id="fproposal_penelitianview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposal_penelitian: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fproposal_penelitianview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fproposal_penelitianview")
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
<input type="hidden" name="t" value="proposal_penelitian">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Id_kelompok->Visible) { // Id_kelompok ?>
    <tr id="r_Id_kelompok"<?= $Page->Id_kelompok->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Id_kelompok"><?= $Page->Id_kelompok->caption() ?></span></td>
        <td data-name="Id_kelompok"<?= $Page->Id_kelompok->cellAttributes() ?>>
<span id="el_proposal_penelitian_Id_kelompok">
<span<?= $Page->Id_kelompok->viewAttributes() ?>>
<?= $Page->Id_kelompok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
    <tr id="r_Judul_Penelitian"<?= $Page->Judul_Penelitian->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Judul_Penelitian"><?= $Page->Judul_Penelitian->caption() ?></span></td>
        <td data-name="Judul_Penelitian"<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el_proposal_penelitian_Judul_Penelitian">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Warna_Kaver->Visible) { // Warna_Kaver ?>
    <tr id="r_Warna_Kaver"<?= $Page->Warna_Kaver->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Warna_Kaver"><?= $Page->Warna_Kaver->caption() ?></span></td>
        <td data-name="Warna_Kaver"<?= $Page->Warna_Kaver->cellAttributes() ?>>
<span id="el_proposal_penelitian_Warna_Kaver">
<span<?= $Page->Warna_Kaver->viewAttributes() ?>>
<?= $Page->Warna_Kaver->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
    <tr id="r_Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?></span></td>
        <td data-name="Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_proposal_penelitian_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Soft_copy_Proposal->Visible) { // Soft_copy_Proposal ?>
    <tr id="r_Soft_copy_Proposal"<?= $Page->Soft_copy_Proposal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Soft_copy_Proposal"><?= $Page->Soft_copy_Proposal->caption() ?></span></td>
        <td data-name="Soft_copy_Proposal"<?= $Page->Soft_copy_Proposal->cellAttributes() ?>>
<span id="el_proposal_penelitian_Soft_copy_Proposal">
<span<?= $Page->Soft_copy_Proposal->viewAttributes() ?>>
<?= GetFileViewTag($Page->Soft_copy_Proposal, $Page->Soft_copy_Proposal->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Surat_Pernyataan_Tidak_Studi->Visible) { // Surat_Pernyataan_Tidak_Studi ?>
    <tr id="r_Surat_Pernyataan_Tidak_Studi"<?= $Page->Surat_Pernyataan_Tidak_Studi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Surat_Pernyataan_Tidak_Studi"><?= $Page->Surat_Pernyataan_Tidak_Studi->caption() ?></span></td>
        <td data-name="Surat_Pernyataan_Tidak_Studi"<?= $Page->Surat_Pernyataan_Tidak_Studi->cellAttributes() ?>>
<span id="el_proposal_penelitian_Surat_Pernyataan_Tidak_Studi">
<span<?= $Page->Surat_Pernyataan_Tidak_Studi->viewAttributes() ?>>
<?= GetFileViewTag($Page->Surat_Pernyataan_Tidak_Studi, $Page->Surat_Pernyataan_Tidak_Studi->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <tr id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Tanggal"><?= $Page->Tanggal->caption() ?></span></td>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_proposal_penelitian_Tanggal">
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fproposal_penelitianadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fproposal_penelitianadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fproposal_penelitianedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fproposal_penelitianedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php } ?>

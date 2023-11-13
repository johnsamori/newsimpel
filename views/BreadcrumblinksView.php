<?php

namespace PHPMaker2023\new2023;

// Page object
$BreadcrumblinksView = &$Page;
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
<form name="fbreadcrumblinksview" id="fbreadcrumblinksview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { breadcrumblinks: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fbreadcrumblinksview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fbreadcrumblinksview")
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
<input type="hidden" name="t" value="breadcrumblinks">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Page_Title->Visible) { // Page_Title ?>
    <tr id="r_Page_Title"<?= $Page->Page_Title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_breadcrumblinks_Page_Title"><?= $Page->Page_Title->caption() ?></span></td>
        <td data-name="Page_Title"<?= $Page->Page_Title->cellAttributes() ?>>
<span id="el_breadcrumblinks_Page_Title">
<span<?= $Page->Page_Title->viewAttributes() ?>>
<?= $Page->Page_Title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Page_URL->Visible) { // Page_URL ?>
    <tr id="r_Page_URL"<?= $Page->Page_URL->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_breadcrumblinks_Page_URL"><?= $Page->Page_URL->caption() ?></span></td>
        <td data-name="Page_URL"<?= $Page->Page_URL->cellAttributes() ?>>
<span id="el_breadcrumblinks_Page_URL">
<span<?= $Page->Page_URL->viewAttributes() ?>>
<?= $Page->Page_URL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Lft->Visible) { // Lft ?>
    <tr id="r_Lft"<?= $Page->Lft->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_breadcrumblinks_Lft"><?= $Page->Lft->caption() ?></span></td>
        <td data-name="Lft"<?= $Page->Lft->cellAttributes() ?>>
<span id="el_breadcrumblinks_Lft">
<span<?= $Page->Lft->viewAttributes() ?>>
<?= $Page->Lft->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Rgt->Visible) { // Rgt ?>
    <tr id="r_Rgt"<?= $Page->Rgt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_breadcrumblinks_Rgt"><?= $Page->Rgt->caption() ?></span></td>
        <td data-name="Rgt"<?= $Page->Rgt->cellAttributes() ?>>
<span id="el_breadcrumblinks_Rgt">
<span<?= $Page->Rgt->viewAttributes() ?>>
<?= $Page->Rgt->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fbreadcrumblinksadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fbreadcrumblinksadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fbreadcrumblinksedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fbreadcrumblinksedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php } ?>

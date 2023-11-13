<?php

namespace PHPMaker2023\new2023;

// Page object
$StatsCounterlogView = &$Page;
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
<form name="fstats_counterlogview" id="fstats_counterlogview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { stats_counterlog: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fstats_counterlogview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fstats_counterlogview")
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
<input type="hidden" name="t" value="stats_counterlog">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->IP_Address->Visible) { // IP_Address ?>
    <tr id="r_IP_Address"<?= $Page->IP_Address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counterlog_IP_Address"><?= $Page->IP_Address->caption() ?></span></td>
        <td data-name="IP_Address"<?= $Page->IP_Address->cellAttributes() ?>>
<span id="el_stats_counterlog_IP_Address">
<span<?= $Page->IP_Address->viewAttributes() ?>>
<?= $Page->IP_Address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Hostname->Visible) { // Hostname ?>
    <tr id="r_Hostname"<?= $Page->Hostname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counterlog_Hostname"><?= $Page->Hostname->caption() ?></span></td>
        <td data-name="Hostname"<?= $Page->Hostname->cellAttributes() ?>>
<span id="el_stats_counterlog_Hostname">
<span<?= $Page->Hostname->viewAttributes() ?>>
<?= $Page->Hostname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->First_Visit->Visible) { // First_Visit ?>
    <tr id="r_First_Visit"<?= $Page->First_Visit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counterlog_First_Visit"><?= $Page->First_Visit->caption() ?></span></td>
        <td data-name="First_Visit"<?= $Page->First_Visit->cellAttributes() ?>>
<span id="el_stats_counterlog_First_Visit">
<span<?= $Page->First_Visit->viewAttributes() ?>>
<?= $Page->First_Visit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Last_Visit->Visible) { // Last_Visit ?>
    <tr id="r_Last_Visit"<?= $Page->Last_Visit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counterlog_Last_Visit"><?= $Page->Last_Visit->caption() ?></span></td>
        <td data-name="Last_Visit"<?= $Page->Last_Visit->cellAttributes() ?>>
<span id="el_stats_counterlog_Last_Visit">
<span<?= $Page->Last_Visit->viewAttributes() ?>>
<?= $Page->Last_Visit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Counter->Visible) { // Counter ?>
    <tr id="r_Counter"<?= $Page->Counter->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counterlog_Counter"><?= $Page->Counter->caption() ?></span></td>
        <td data-name="Counter"<?= $Page->Counter->cellAttributes() ?>>
<span id="el_stats_counterlog_Counter">
<span<?= $Page->Counter->viewAttributes() ?>>
<?= $Page->Counter->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fstats_counterlogadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fstats_counterlogadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fstats_counterlogedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fstats_counterlogedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php } ?>

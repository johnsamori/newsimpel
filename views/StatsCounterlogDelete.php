<?php

namespace PHPMaker2023\new2023;

// Page object
$StatsCounterlogDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { stats_counterlog: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fstats_counterlogdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fstats_counterlogdelete")
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
<form name="fstats_counterlogdelete" id="fstats_counterlogdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stats_counterlog">
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
<?php if ($Page->IP_Address->Visible) { // IP_Address ?>
        <th class="<?= $Page->IP_Address->headerCellClass() ?>"><span id="elh_stats_counterlog_IP_Address" class="stats_counterlog_IP_Address"><?= $Page->IP_Address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Hostname->Visible) { // Hostname ?>
        <th class="<?= $Page->Hostname->headerCellClass() ?>"><span id="elh_stats_counterlog_Hostname" class="stats_counterlog_Hostname"><?= $Page->Hostname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->First_Visit->Visible) { // First_Visit ?>
        <th class="<?= $Page->First_Visit->headerCellClass() ?>"><span id="elh_stats_counterlog_First_Visit" class="stats_counterlog_First_Visit"><?= $Page->First_Visit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Last_Visit->Visible) { // Last_Visit ?>
        <th class="<?= $Page->Last_Visit->headerCellClass() ?>"><span id="elh_stats_counterlog_Last_Visit" class="stats_counterlog_Last_Visit"><?= $Page->Last_Visit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Counter->Visible) { // Counter ?>
        <th class="<?= $Page->Counter->headerCellClass() ?>"><span id="elh_stats_counterlog_Counter" class="stats_counterlog_Counter"><?= $Page->Counter->caption() ?></span></th>
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
<?php if ($Page->IP_Address->Visible) { // IP_Address ?>
        <td<?= $Page->IP_Address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stats_counterlog_IP_Address" class="el_stats_counterlog_IP_Address">
<span<?= $Page->IP_Address->viewAttributes() ?>>
<?= $Page->IP_Address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Hostname->Visible) { // Hostname ?>
        <td<?= $Page->Hostname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stats_counterlog_Hostname" class="el_stats_counterlog_Hostname">
<span<?= $Page->Hostname->viewAttributes() ?>>
<?= $Page->Hostname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->First_Visit->Visible) { // First_Visit ?>
        <td<?= $Page->First_Visit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stats_counterlog_First_Visit" class="el_stats_counterlog_First_Visit">
<span<?= $Page->First_Visit->viewAttributes() ?>>
<?= $Page->First_Visit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Last_Visit->Visible) { // Last_Visit ?>
        <td<?= $Page->Last_Visit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stats_counterlog_Last_Visit" class="el_stats_counterlog_Last_Visit">
<span<?= $Page->Last_Visit->viewAttributes() ?>>
<?= $Page->Last_Visit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Counter->Visible) { // Counter ?>
        <td<?= $Page->Counter->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stats_counterlog_Counter" class="el_stats_counterlog_Counter">
<span<?= $Page->Counter->viewAttributes() ?>>
<?= $Page->Counter->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fstats_counterlogdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fstats_counterlogdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

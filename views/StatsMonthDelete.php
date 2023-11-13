<?php

namespace PHPMaker2023\new2023;

// Page object
$StatsMonthDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { stats_month: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fstats_monthdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fstats_monthdelete")
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
<form name="fstats_monthdelete" id="fstats_monthdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stats_month">
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
<?php if ($Page->Year->Visible) { // Year ?>
        <th class="<?= $Page->Year->headerCellClass() ?>"><span id="elh_stats_month_Year" class="stats_month_Year"><?= $Page->Year->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Month->Visible) { // Month ?>
        <th class="<?= $Page->Month->headerCellClass() ?>"><span id="elh_stats_month_Month" class="stats_month_Month"><?= $Page->Month->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Hits->Visible) { // Hits ?>
        <th class="<?= $Page->Hits->headerCellClass() ?>"><span id="elh_stats_month_Hits" class="stats_month_Hits"><?= $Page->Hits->caption() ?></span></th>
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
<?php if ($Page->Year->Visible) { // Year ?>
        <td<?= $Page->Year->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stats_month_Year" class="el_stats_month_Year">
<span<?= $Page->Year->viewAttributes() ?>>
<?= $Page->Year->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Month->Visible) { // Month ?>
        <td<?= $Page->Month->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stats_month_Month" class="el_stats_month_Month">
<span<?= $Page->Month->viewAttributes() ?>>
<?= $Page->Month->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Hits->Visible) { // Hits ?>
        <td<?= $Page->Hits->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stats_month_Hits" class="el_stats_month_Hits">
<span<?= $Page->Hits->viewAttributes() ?>>
<?= $Page->Hits->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fstats_monthdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fstats_monthdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

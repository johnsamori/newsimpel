<?php

namespace PHPMaker2023\new2023;

// Page object
$BreadcrumblinksDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { breadcrumblinks: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fbreadcrumblinksdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fbreadcrumblinksdelete")
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
<form name="fbreadcrumblinksdelete" id="fbreadcrumblinksdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="breadcrumblinks">
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
<?php if ($Page->Page_Title->Visible) { // Page_Title ?>
        <th class="<?= $Page->Page_Title->headerCellClass() ?>"><span id="elh_breadcrumblinks_Page_Title" class="breadcrumblinks_Page_Title"><?= $Page->Page_Title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Page_URL->Visible) { // Page_URL ?>
        <th class="<?= $Page->Page_URL->headerCellClass() ?>"><span id="elh_breadcrumblinks_Page_URL" class="breadcrumblinks_Page_URL"><?= $Page->Page_URL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Lft->Visible) { // Lft ?>
        <th class="<?= $Page->Lft->headerCellClass() ?>"><span id="elh_breadcrumblinks_Lft" class="breadcrumblinks_Lft"><?= $Page->Lft->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Rgt->Visible) { // Rgt ?>
        <th class="<?= $Page->Rgt->headerCellClass() ?>"><span id="elh_breadcrumblinks_Rgt" class="breadcrumblinks_Rgt"><?= $Page->Rgt->caption() ?></span></th>
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
<?php if ($Page->Page_Title->Visible) { // Page_Title ?>
        <td<?= $Page->Page_Title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_breadcrumblinks_Page_Title" class="el_breadcrumblinks_Page_Title">
<span<?= $Page->Page_Title->viewAttributes() ?>>
<?= $Page->Page_Title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Page_URL->Visible) { // Page_URL ?>
        <td<?= $Page->Page_URL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_breadcrumblinks_Page_URL" class="el_breadcrumblinks_Page_URL">
<span<?= $Page->Page_URL->viewAttributes() ?>>
<?= $Page->Page_URL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Lft->Visible) { // Lft ?>
        <td<?= $Page->Lft->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_breadcrumblinks_Lft" class="el_breadcrumblinks_Lft">
<span<?= $Page->Lft->viewAttributes() ?>>
<?= $Page->Lft->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Rgt->Visible) { // Rgt ?>
        <td<?= $Page->Rgt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_breadcrumblinks_Rgt" class="el_breadcrumblinks_Rgt">
<span<?= $Page->Rgt->viewAttributes() ?>>
<?= $Page->Rgt->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fbreadcrumblinksdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fbreadcrumblinksdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

<?php

namespace PHPMaker2023\new2023;

// Page object
$UsersView = &$Page;
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
<form name="fusersview" id="fusersview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fusersview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fusersview")
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
<input type="hidden" name="t" value="users">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->_Username->Visible) { // Username ?>
    <tr id="r__Username"<?= $Page->_Username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users__Username"><?= $Page->_Username->caption() ?></span></td>
        <td data-name="_Username"<?= $Page->_Username->cellAttributes() ?>>
<span id="el_users__Username">
<span<?= $Page->_Username->viewAttributes() ?>>
<?= $Page->_Username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->First_Name->Visible) { // First_Name ?>
    <tr id="r_First_Name"<?= $Page->First_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_First_Name"><?= $Page->First_Name->caption() ?></span></td>
        <td data-name="First_Name"<?= $Page->First_Name->cellAttributes() ?>>
<span id="el_users_First_Name">
<span<?= $Page->First_Name->viewAttributes() ?>>
<?= $Page->First_Name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Last_Name->Visible) { // Last_Name ?>
    <tr id="r_Last_Name"<?= $Page->Last_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Last_Name"><?= $Page->Last_Name->caption() ?></span></td>
        <td data-name="Last_Name"<?= $Page->Last_Name->cellAttributes() ?>>
<span id="el_users_Last_Name">
<span<?= $Page->Last_Name->viewAttributes() ?>>
<?= $Page->Last_Name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
    <tr id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users__Email"><?= $Page->_Email->caption() ?></span></td>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el_users__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->User_Level->Visible) { // User_Level ?>
    <tr id="r_User_Level"<?= $Page->User_Level->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_User_Level"><?= $Page->User_Level->caption() ?></span></td>
        <td data-name="User_Level"<?= $Page->User_Level->cellAttributes() ?>>
<span id="el_users_User_Level">
<span<?= $Page->User_Level->viewAttributes() ?>>
<?= $Page->User_Level->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Report_To->Visible) { // Report_To ?>
    <tr id="r_Report_To"<?= $Page->Report_To->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Report_To"><?= $Page->Report_To->caption() ?></span></td>
        <td data-name="Report_To"<?= $Page->Report_To->cellAttributes() ?>>
<span id="el_users_Report_To">
<span<?= $Page->Report_To->viewAttributes() ?>>
<?= $Page->Report_To->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Activated->Visible) { // Activated ?>
    <tr id="r_Activated"<?= $Page->Activated->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Activated"><?= $Page->Activated->caption() ?></span></td>
        <td data-name="Activated"<?= $Page->Activated->cellAttributes() ?>>
<span id="el_users_Activated">
<span<?= $Page->Activated->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_Activated_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Activated->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Activated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Activated_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Locked->Visible) { // Locked ?>
    <tr id="r_Locked"<?= $Page->Locked->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Locked"><?= $Page->Locked->caption() ?></span></td>
        <td data-name="Locked"<?= $Page->Locked->cellAttributes() ?>>
<span id="el_users_Locked">
<span<?= $Page->Locked->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_Locked_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Locked->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Locked->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Locked_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
    <tr id="r_Photo"<?= $Page->Photo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Photo"><?= $Page->Photo->caption() ?></span></td>
        <td data-name="Photo"<?= $Page->Photo->cellAttributes() ?>>
<span id="el_users_Photo">
<span>
<?= GetFileViewTag($Page->Photo, $Page->Photo->getViewValue(), false) ?>
</span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fusersadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fusersadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fusersedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fusersedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php } ?>

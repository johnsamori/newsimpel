<?php

namespace PHPMaker2023\new2023;

// Page object
$ProposalPengabdianStatusAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposal_pengabdian_status: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fproposal_pengabdian_statusadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fproposal_pengabdian_statusadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["Kelompok_ID", [fields.Kelompok_ID.visible && fields.Kelompok_ID.required ? ew.Validators.required(fields.Kelompok_ID.caption) : null], fields.Kelompok_ID.isInvalid],
            ["Status", [fields.Status.visible && fields.Status.required ? ew.Validators.required(fields.Status.caption) : null], fields.Status.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "Kelompok_ID": <?= $Page->Kelompok_ID->toClientList($Page) ?>,
            "Status": <?= $Page->Status->toClientList($Page) ?>,
        })
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
<?php if (!$Page->IsModal) { ?>
<div class="col-md-12">
  <div class="card shadow-sm">
    <div class="card-header">
	  <h4 class="card-title"><?php echo Language()->phrase("AddCaption"); ?></h4>
	  <div class="card-tools">
	  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
	  </button>
	  </div>
	  <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
<?php } ?>
<form name="fproposal_pengabdian_statusadd" id="fproposal_pengabdian_statusadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proposal_pengabdian_status">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if (!$Page->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($Page->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_proposal_pengabdian_statusadd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Kelompok_ID"<?= $Page->Kelompok_ID->rowAttributes() ?>>
        <label id="elh_proposal_pengabdian_status_Kelompok_ID" for="x_Kelompok_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kelompok_ID->caption() ?><?= $Page->Kelompok_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kelompok_ID->cellAttributes() ?>>
<span id="el_proposal_pengabdian_status_Kelompok_ID">
    <select
        id="x_Kelompok_ID"
        name="x_Kelompok_ID"
        class="form-select ew-select<?= $Page->Kelompok_ID->isInvalidClass() ?>"
        <?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
        data-select2-id="fproposal_pengabdian_statusadd_x_Kelompok_ID"
        <?php } ?>
        data-table="proposal_pengabdian_status"
        data-field="x_Kelompok_ID"
        data-value-separator="<?= $Page->Kelompok_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kelompok_ID->getPlaceHolder()) ?>"
        <?= $Page->Kelompok_ID->editAttributes() ?>>
        <?= $Page->Kelompok_ID->selectOptionListHtml("x_Kelompok_ID") ?>
    </select>
    <?= $Page->Kelompok_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Kelompok_ID->getErrorMessage() ?></div>
<?= $Page->Kelompok_ID->Lookup->getParamTag($Page, "p_x_Kelompok_ID") ?>
<?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
<script>
loadjs.ready("fproposal_pengabdian_statusadd", function() {
    var options = { name: "x_Kelompok_ID", selectId: "fproposal_pengabdian_statusadd_x_Kelompok_ID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fproposal_pengabdian_statusadd.lists.Kelompok_ID?.lookupOptions.length) {
        options.data = { id: "x_Kelompok_ID", form: "fproposal_pengabdian_statusadd" };
    } else {
        options.ajax = { id: "x_Kelompok_ID", form: "fproposal_pengabdian_statusadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_pengabdian_status.fields.Kelompok_ID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Kelompok_ID"<?= $Page->Kelompok_ID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_pengabdian_status_Kelompok_ID"><?= $Page->Kelompok_ID->caption() ?><?= $Page->Kelompok_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Kelompok_ID->cellAttributes() ?>>
<span id="el_proposal_pengabdian_status_Kelompok_ID">
    <select
        id="x_Kelompok_ID"
        name="x_Kelompok_ID"
        class="form-select ew-select<?= $Page->Kelompok_ID->isInvalidClass() ?>"
        <?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
        data-select2-id="fproposal_pengabdian_statusadd_x_Kelompok_ID"
        <?php } ?>
        data-table="proposal_pengabdian_status"
        data-field="x_Kelompok_ID"
        data-value-separator="<?= $Page->Kelompok_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kelompok_ID->getPlaceHolder()) ?>"
        <?= $Page->Kelompok_ID->editAttributes() ?>>
        <?= $Page->Kelompok_ID->selectOptionListHtml("x_Kelompok_ID") ?>
    </select>
    <?= $Page->Kelompok_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Kelompok_ID->getErrorMessage() ?></div>
<?= $Page->Kelompok_ID->Lookup->getParamTag($Page, "p_x_Kelompok_ID") ?>
<?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
<script>
loadjs.ready("fproposal_pengabdian_statusadd", function() {
    var options = { name: "x_Kelompok_ID", selectId: "fproposal_pengabdian_statusadd_x_Kelompok_ID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fproposal_pengabdian_statusadd.lists.Kelompok_ID?.lookupOptions.length) {
        options.data = { id: "x_Kelompok_ID", form: "fproposal_pengabdian_statusadd" };
    } else {
        options.ajax = { id: "x_Kelompok_ID", form: "fproposal_pengabdian_statusadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_pengabdian_status.fields.Kelompok_ID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <label id="elh_proposal_pengabdian_status_Status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status->caption() ?><?= $Page->Status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status->cellAttributes() ?>>
<span id="el_proposal_pengabdian_status_Status">
<template id="tp_x_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="proposal_pengabdian_status" data-field="x_Status" name="x_Status" id="x_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x_Status"
    name="x_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_Status"
    data-target="dsl_x_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="proposal_pengabdian_status"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<?= $Page->Status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_pengabdian_status_Status"><?= $Page->Status->caption() ?><?= $Page->Status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Status->cellAttributes() ?>>
<span id="el_proposal_pengabdian_status_Status">
<template id="tp_x_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="proposal_pengabdian_status" data-field="x_Status" name="x_Status" id="x_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x_Status"
    name="x_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_Status"
    data-target="dsl_x_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="proposal_pengabdian_status"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<?= $Page->Status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fproposal_pengabdian_statusadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fproposal_pengabdian_statusadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
<?php if (!$Page->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php if (!$Page->IsModal) { ?>
		</div>
     <!-- /.card-body -->
     </div>
  <!-- /.card -->
</div>
<?php } ?>
<div class="clearfix">&nbsp;</div>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("proposal_pengabdian_status");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fproposal_pengabdian_statusadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fproposal_pengabdian_statusadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fproposal_pengabdian_statusadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

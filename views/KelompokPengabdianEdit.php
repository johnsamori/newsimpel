<?php

namespace PHPMaker2023\new2023;

// Page object
$KelompokPengabdianEdit = &$Page;
?>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="col-md-12">
  <div class="card shadow-sm">
    <div class="card-header">
	  <h4 class="card-title"><?php echo Language()->phrase("EditCaption"); ?></h4>
	  <div class="card-tools">
	  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
	  </button>
	  </div>
	  <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
<?php } ?>
<form name="fkelompok_pengabdianedit" id="fkelompok_pengabdianedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kelompok_pengabdian: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fkelompok_pengabdianedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkelompok_pengabdianedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Id_Kelompok", [fields.Id_Kelompok.visible && fields.Id_Kelompok.required ? ew.Validators.required(fields.Id_Kelompok.caption) : null], fields.Id_Kelompok.isInvalid],
            ["Nama_Ketua", [fields.Nama_Ketua.visible && fields.Nama_Ketua.required ? ew.Validators.required(fields.Nama_Ketua.caption) : null], fields.Nama_Ketua.isInvalid],
            ["Nama_Anggota_1", [fields.Nama_Anggota_1.visible && fields.Nama_Anggota_1.required ? ew.Validators.required(fields.Nama_Anggota_1.caption) : null], fields.Nama_Anggota_1.isInvalid],
            ["Nama_Anggota_2", [fields.Nama_Anggota_2.visible && fields.Nama_Anggota_2.required ? ew.Validators.required(fields.Nama_Anggota_2.caption) : null], fields.Nama_Anggota_2.isInvalid],
            ["Tanggal", [fields.Tanggal.visible && fields.Tanggal.required ? ew.Validators.required(fields.Tanggal.caption) : null], fields.Tanggal.isInvalid],
            ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid],
            ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null], fields.user.isInvalid],
            ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid]
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
            "Nama_Ketua": <?= $Page->Nama_Ketua->toClientList($Page) ?>,
            "Nama_Anggota_1": <?= $Page->Nama_Anggota_1->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kelompok_pengabdian">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if (!$Page->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($Page->IsMobileOrModal) { ?>
<div class="ew-edit-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_kelompok_pengabdianedit" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Id_Kelompok"<?= $Page->Id_Kelompok->rowAttributes() ?>>
        <label id="elh_kelompok_pengabdian_Id_Kelompok" for="x_Id_Kelompok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Id_Kelompok->caption() ?><?= $Page->Id_Kelompok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Id_Kelompok">
<input type="<?= $Page->Id_Kelompok->getInputTextType() ?>" name="x_Id_Kelompok" id="x_Id_Kelompok" data-table="kelompok_pengabdian" data-field="x_Id_Kelompok" value="<?= $Page->Id_Kelompok->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Id_Kelompok->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Id_Kelompok->formatPattern()) ?>"<?= $Page->Id_Kelompok->editAttributes() ?> aria-describedby="x_Id_Kelompok_help">
<?= $Page->Id_Kelompok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Id_Kelompok->getErrorMessage() ?></div>
<input type="hidden" data-table="kelompok_pengabdian" data-field="x_Id_Kelompok" data-hidden="1" data-old name="o_Id_Kelompok" id="o_Id_Kelompok" value="<?= HtmlEncode($Page->Id_Kelompok->OldValue ?? $Page->Id_Kelompok->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Id_Kelompok"<?= $Page->Id_Kelompok->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kelompok_pengabdian_Id_Kelompok"><?= $Page->Id_Kelompok->caption() ?><?= $Page->Id_Kelompok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Id_Kelompok">
<input type="<?= $Page->Id_Kelompok->getInputTextType() ?>" name="x_Id_Kelompok" id="x_Id_Kelompok" data-table="kelompok_pengabdian" data-field="x_Id_Kelompok" value="<?= $Page->Id_Kelompok->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Id_Kelompok->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Id_Kelompok->formatPattern()) ?>"<?= $Page->Id_Kelompok->editAttributes() ?> aria-describedby="x_Id_Kelompok_help">
<?= $Page->Id_Kelompok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Id_Kelompok->getErrorMessage() ?></div>
<input type="hidden" data-table="kelompok_pengabdian" data-field="x_Id_Kelompok" data-hidden="1" data-old name="o_Id_Kelompok" id="o_Id_Kelompok" value="<?= HtmlEncode($Page->Id_Kelompok->OldValue ?? $Page->Id_Kelompok->CurrentValue) ?>">
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Nama_Ketua"<?= $Page->Nama_Ketua->rowAttributes() ?>>
        <label id="elh_kelompok_pengabdian_Nama_Ketua" for="x_Nama_Ketua" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama_Ketua->caption() ?><?= $Page->Nama_Ketua->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama_Ketua->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Nama_Ketua">
    <select
        id="x_Nama_Ketua"
        name="x_Nama_Ketua"
        class="form-select ew-select<?= $Page->Nama_Ketua->isInvalidClass() ?>"
        <?php if (!$Page->Nama_Ketua->IsNativeSelect) { ?>
        data-select2-id="fkelompok_pengabdianedit_x_Nama_Ketua"
        <?php } ?>
        data-table="kelompok_pengabdian"
        data-field="x_Nama_Ketua"
        data-value-separator="<?= $Page->Nama_Ketua->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Nama_Ketua->getPlaceHolder()) ?>"
        <?= $Page->Nama_Ketua->editAttributes() ?>>
        <?= $Page->Nama_Ketua->selectOptionListHtml("x_Nama_Ketua") ?>
    </select>
    <?= $Page->Nama_Ketua->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Nama_Ketua->getErrorMessage() ?></div>
<?= $Page->Nama_Ketua->Lookup->getParamTag($Page, "p_x_Nama_Ketua") ?>
<?php if (!$Page->Nama_Ketua->IsNativeSelect) { ?>
<script>
loadjs.ready("fkelompok_pengabdianedit", function() {
    var options = { name: "x_Nama_Ketua", selectId: "fkelompok_pengabdianedit_x_Nama_Ketua" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fkelompok_pengabdianedit.lists.Nama_Ketua?.lookupOptions.length) {
        options.data = { id: "x_Nama_Ketua", form: "fkelompok_pengabdianedit" };
    } else {
        options.ajax = { id: "x_Nama_Ketua", form: "fkelompok_pengabdianedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.kelompok_pengabdian.fields.Nama_Ketua.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Nama_Ketua"<?= $Page->Nama_Ketua->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kelompok_pengabdian_Nama_Ketua"><?= $Page->Nama_Ketua->caption() ?><?= $Page->Nama_Ketua->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Nama_Ketua->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Nama_Ketua">
    <select
        id="x_Nama_Ketua"
        name="x_Nama_Ketua"
        class="form-select ew-select<?= $Page->Nama_Ketua->isInvalidClass() ?>"
        <?php if (!$Page->Nama_Ketua->IsNativeSelect) { ?>
        data-select2-id="fkelompok_pengabdianedit_x_Nama_Ketua"
        <?php } ?>
        data-table="kelompok_pengabdian"
        data-field="x_Nama_Ketua"
        data-value-separator="<?= $Page->Nama_Ketua->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Nama_Ketua->getPlaceHolder()) ?>"
        <?= $Page->Nama_Ketua->editAttributes() ?>>
        <?= $Page->Nama_Ketua->selectOptionListHtml("x_Nama_Ketua") ?>
    </select>
    <?= $Page->Nama_Ketua->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Nama_Ketua->getErrorMessage() ?></div>
<?= $Page->Nama_Ketua->Lookup->getParamTag($Page, "p_x_Nama_Ketua") ?>
<?php if (!$Page->Nama_Ketua->IsNativeSelect) { ?>
<script>
loadjs.ready("fkelompok_pengabdianedit", function() {
    var options = { name: "x_Nama_Ketua", selectId: "fkelompok_pengabdianedit_x_Nama_Ketua" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fkelompok_pengabdianedit.lists.Nama_Ketua?.lookupOptions.length) {
        options.data = { id: "x_Nama_Ketua", form: "fkelompok_pengabdianedit" };
    } else {
        options.ajax = { id: "x_Nama_Ketua", form: "fkelompok_pengabdianedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.kelompok_pengabdian.fields.Nama_Ketua.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Nama_Anggota_1"<?= $Page->Nama_Anggota_1->rowAttributes() ?>>
        <label id="elh_kelompok_pengabdian_Nama_Anggota_1" for="x_Nama_Anggota_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama_Anggota_1->caption() ?><?= $Page->Nama_Anggota_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama_Anggota_1->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Nama_Anggota_1">
    <select
        id="x_Nama_Anggota_1"
        name="x_Nama_Anggota_1"
        class="form-select ew-select<?= $Page->Nama_Anggota_1->isInvalidClass() ?>"
        <?php if (!$Page->Nama_Anggota_1->IsNativeSelect) { ?>
        data-select2-id="fkelompok_pengabdianedit_x_Nama_Anggota_1"
        <?php } ?>
        data-table="kelompok_pengabdian"
        data-field="x_Nama_Anggota_1"
        data-value-separator="<?= $Page->Nama_Anggota_1->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Nama_Anggota_1->getPlaceHolder()) ?>"
        <?= $Page->Nama_Anggota_1->editAttributes() ?>>
        <?= $Page->Nama_Anggota_1->selectOptionListHtml("x_Nama_Anggota_1") ?>
    </select>
    <?= $Page->Nama_Anggota_1->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Nama_Anggota_1->getErrorMessage() ?></div>
<?= $Page->Nama_Anggota_1->Lookup->getParamTag($Page, "p_x_Nama_Anggota_1") ?>
<?php if (!$Page->Nama_Anggota_1->IsNativeSelect) { ?>
<script>
loadjs.ready("fkelompok_pengabdianedit", function() {
    var options = { name: "x_Nama_Anggota_1", selectId: "fkelompok_pengabdianedit_x_Nama_Anggota_1" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fkelompok_pengabdianedit.lists.Nama_Anggota_1?.lookupOptions.length) {
        options.data = { id: "x_Nama_Anggota_1", form: "fkelompok_pengabdianedit" };
    } else {
        options.ajax = { id: "x_Nama_Anggota_1", form: "fkelompok_pengabdianedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.kelompok_pengabdian.fields.Nama_Anggota_1.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Nama_Anggota_1"<?= $Page->Nama_Anggota_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kelompok_pengabdian_Nama_Anggota_1"><?= $Page->Nama_Anggota_1->caption() ?><?= $Page->Nama_Anggota_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Nama_Anggota_1->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Nama_Anggota_1">
    <select
        id="x_Nama_Anggota_1"
        name="x_Nama_Anggota_1"
        class="form-select ew-select<?= $Page->Nama_Anggota_1->isInvalidClass() ?>"
        <?php if (!$Page->Nama_Anggota_1->IsNativeSelect) { ?>
        data-select2-id="fkelompok_pengabdianedit_x_Nama_Anggota_1"
        <?php } ?>
        data-table="kelompok_pengabdian"
        data-field="x_Nama_Anggota_1"
        data-value-separator="<?= $Page->Nama_Anggota_1->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Nama_Anggota_1->getPlaceHolder()) ?>"
        <?= $Page->Nama_Anggota_1->editAttributes() ?>>
        <?= $Page->Nama_Anggota_1->selectOptionListHtml("x_Nama_Anggota_1") ?>
    </select>
    <?= $Page->Nama_Anggota_1->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Nama_Anggota_1->getErrorMessage() ?></div>
<?= $Page->Nama_Anggota_1->Lookup->getParamTag($Page, "p_x_Nama_Anggota_1") ?>
<?php if (!$Page->Nama_Anggota_1->IsNativeSelect) { ?>
<script>
loadjs.ready("fkelompok_pengabdianedit", function() {
    var options = { name: "x_Nama_Anggota_1", selectId: "fkelompok_pengabdianedit_x_Nama_Anggota_1" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fkelompok_pengabdianedit.lists.Nama_Anggota_1?.lookupOptions.length) {
        options.data = { id: "x_Nama_Anggota_1", form: "fkelompok_pengabdianedit" };
    } else {
        options.ajax = { id: "x_Nama_Anggota_1", form: "fkelompok_pengabdianedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.kelompok_pengabdian.fields.Nama_Anggota_1.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Nama_Anggota_2"<?= $Page->Nama_Anggota_2->rowAttributes() ?>>
        <label id="elh_kelompok_pengabdian_Nama_Anggota_2" for="x_Nama_Anggota_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama_Anggota_2->caption() ?><?= $Page->Nama_Anggota_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama_Anggota_2->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Nama_Anggota_2">
<input type="<?= $Page->Nama_Anggota_2->getInputTextType() ?>" name="x_Nama_Anggota_2" id="x_Nama_Anggota_2" data-table="kelompok_pengabdian" data-field="x_Nama_Anggota_2" value="<?= $Page->Nama_Anggota_2->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Nama_Anggota_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama_Anggota_2->formatPattern()) ?>"<?= $Page->Nama_Anggota_2->editAttributes() ?> aria-describedby="x_Nama_Anggota_2_help">
<?= $Page->Nama_Anggota_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama_Anggota_2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Nama_Anggota_2"<?= $Page->Nama_Anggota_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kelompok_pengabdian_Nama_Anggota_2"><?= $Page->Nama_Anggota_2->caption() ?><?= $Page->Nama_Anggota_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Nama_Anggota_2->cellAttributes() ?>>
<span id="el_kelompok_pengabdian_Nama_Anggota_2">
<input type="<?= $Page->Nama_Anggota_2->getInputTextType() ?>" name="x_Nama_Anggota_2" id="x_Nama_Anggota_2" data-table="kelompok_pengabdian" data-field="x_Nama_Anggota_2" value="<?= $Page->Nama_Anggota_2->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Nama_Anggota_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama_Anggota_2->formatPattern()) ?>"<?= $Page->Nama_Anggota_2->editAttributes() ?> aria-describedby="x_Nama_Anggota_2_help">
<?= $Page->Nama_Anggota_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama_Anggota_2->getErrorMessage() ?></div>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fkelompok_pengabdianedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fkelompok_pengabdianedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("kelompok_pengabdian");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fkelompok_pengabdianedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkelompok_pengabdianedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkelompok_pengabdianedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

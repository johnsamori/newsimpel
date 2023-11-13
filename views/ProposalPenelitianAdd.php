<?php

namespace PHPMaker2023\new2023;

// Page object
$ProposalPenelitianAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposal_penelitian: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fproposal_penelitianadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fproposal_penelitianadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["Id_kelompok", [fields.Id_kelompok.visible && fields.Id_kelompok.required ? ew.Validators.required(fields.Id_kelompok.caption) : null], fields.Id_kelompok.isInvalid],
            ["Judul_Penelitian", [fields.Judul_Penelitian.visible && fields.Judul_Penelitian.required ? ew.Validators.required(fields.Judul_Penelitian.caption) : null], fields.Judul_Penelitian.isInvalid],
            ["Warna_Kaver", [fields.Warna_Kaver.visible && fields.Warna_Kaver.required ? ew.Validators.required(fields.Warna_Kaver.caption) : null], fields.Warna_Kaver.isInvalid],
            ["Lembar_Pengesahan", [fields.Lembar_Pengesahan.visible && fields.Lembar_Pengesahan.required ? ew.Validators.fileRequired(fields.Lembar_Pengesahan.caption) : null], fields.Lembar_Pengesahan.isInvalid],
            ["Soft_copy_Proposal", [fields.Soft_copy_Proposal.visible && fields.Soft_copy_Proposal.required ? ew.Validators.fileRequired(fields.Soft_copy_Proposal.caption) : null], fields.Soft_copy_Proposal.isInvalid],
            ["Surat_Pernyataan_Tidak_Studi", [fields.Surat_Pernyataan_Tidak_Studi.visible && fields.Surat_Pernyataan_Tidak_Studi.required ? ew.Validators.fileRequired(fields.Surat_Pernyataan_Tidak_Studi.caption) : null], fields.Surat_Pernyataan_Tidak_Studi.isInvalid],
            ["Tanggal", [fields.Tanggal.visible && fields.Tanggal.required ? ew.Validators.required(fields.Tanggal.caption) : null], fields.Tanggal.isInvalid],
            ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid],
            ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null], fields.user.isInvalid],
            ["User_Id", [fields.User_Id.visible && fields.User_Id.required ? ew.Validators.required(fields.User_Id.caption) : null], fields.User_Id.isInvalid]
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
            "Id_kelompok": <?= $Page->Id_kelompok->toClientList($Page) ?>,
            "Warna_Kaver": <?= $Page->Warna_Kaver->toClientList($Page) ?>,
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
<form name="fproposal_penelitianadd" id="fproposal_penelitianadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proposal_penelitian">
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
<table id="tbl_proposal_penelitianadd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->Id_kelompok->Visible) { // Id_kelompok ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Id_kelompok"<?= $Page->Id_kelompok->rowAttributes() ?>>
        <label id="elh_proposal_penelitian_Id_kelompok" for="x_Id_kelompok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Id_kelompok->caption() ?><?= $Page->Id_kelompok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Id_kelompok->cellAttributes() ?>>
<span id="el_proposal_penelitian_Id_kelompok">
    <select
        id="x_Id_kelompok"
        name="x_Id_kelompok"
        class="form-select ew-select<?= $Page->Id_kelompok->isInvalidClass() ?>"
        <?php if (!$Page->Id_kelompok->IsNativeSelect) { ?>
        data-select2-id="fproposal_penelitianadd_x_Id_kelompok"
        <?php } ?>
        data-table="proposal_penelitian"
        data-field="x_Id_kelompok"
        data-value-separator="<?= $Page->Id_kelompok->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Id_kelompok->getPlaceHolder()) ?>"
        <?= $Page->Id_kelompok->editAttributes() ?>>
        <?= $Page->Id_kelompok->selectOptionListHtml("x_Id_kelompok") ?>
    </select>
    <?= $Page->Id_kelompok->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Id_kelompok->getErrorMessage() ?></div>
<?= $Page->Id_kelompok->Lookup->getParamTag($Page, "p_x_Id_kelompok") ?>
<?php if (!$Page->Id_kelompok->IsNativeSelect) { ?>
<script>
loadjs.ready("fproposal_penelitianadd", function() {
    var options = { name: "x_Id_kelompok", selectId: "fproposal_penelitianadd_x_Id_kelompok" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fproposal_penelitianadd.lists.Id_kelompok?.lookupOptions.length) {
        options.data = { id: "x_Id_kelompok", form: "fproposal_penelitianadd" };
    } else {
        options.ajax = { id: "x_Id_kelompok", form: "fproposal_penelitianadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_penelitian.fields.Id_kelompok.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Id_kelompok"<?= $Page->Id_kelompok->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Id_kelompok"><?= $Page->Id_kelompok->caption() ?><?= $Page->Id_kelompok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Id_kelompok->cellAttributes() ?>>
<span id="el_proposal_penelitian_Id_kelompok">
    <select
        id="x_Id_kelompok"
        name="x_Id_kelompok"
        class="form-select ew-select<?= $Page->Id_kelompok->isInvalidClass() ?>"
        <?php if (!$Page->Id_kelompok->IsNativeSelect) { ?>
        data-select2-id="fproposal_penelitianadd_x_Id_kelompok"
        <?php } ?>
        data-table="proposal_penelitian"
        data-field="x_Id_kelompok"
        data-value-separator="<?= $Page->Id_kelompok->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Id_kelompok->getPlaceHolder()) ?>"
        <?= $Page->Id_kelompok->editAttributes() ?>>
        <?= $Page->Id_kelompok->selectOptionListHtml("x_Id_kelompok") ?>
    </select>
    <?= $Page->Id_kelompok->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Id_kelompok->getErrorMessage() ?></div>
<?= $Page->Id_kelompok->Lookup->getParamTag($Page, "p_x_Id_kelompok") ?>
<?php if (!$Page->Id_kelompok->IsNativeSelect) { ?>
<script>
loadjs.ready("fproposal_penelitianadd", function() {
    var options = { name: "x_Id_kelompok", selectId: "fproposal_penelitianadd_x_Id_kelompok" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fproposal_penelitianadd.lists.Id_kelompok?.lookupOptions.length) {
        options.data = { id: "x_Id_kelompok", form: "fproposal_penelitianadd" };
    } else {
        options.ajax = { id: "x_Id_kelompok", form: "fproposal_penelitianadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_penelitian.fields.Id_kelompok.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Judul_Penelitian"<?= $Page->Judul_Penelitian->rowAttributes() ?>>
        <label id="elh_proposal_penelitian_Judul_Penelitian" for="x_Judul_Penelitian" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Judul_Penelitian->caption() ?><?= $Page->Judul_Penelitian->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el_proposal_penelitian_Judul_Penelitian">
<textarea data-table="proposal_penelitian" data-field="x_Judul_Penelitian" name="x_Judul_Penelitian" id="x_Judul_Penelitian" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Judul_Penelitian->getPlaceHolder()) ?>"<?= $Page->Judul_Penelitian->editAttributes() ?> aria-describedby="x_Judul_Penelitian_help"><?= $Page->Judul_Penelitian->EditValue ?></textarea>
<?= $Page->Judul_Penelitian->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Judul_Penelitian->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Judul_Penelitian"<?= $Page->Judul_Penelitian->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Judul_Penelitian"><?= $Page->Judul_Penelitian->caption() ?><?= $Page->Judul_Penelitian->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el_proposal_penelitian_Judul_Penelitian">
<textarea data-table="proposal_penelitian" data-field="x_Judul_Penelitian" name="x_Judul_Penelitian" id="x_Judul_Penelitian" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Judul_Penelitian->getPlaceHolder()) ?>"<?= $Page->Judul_Penelitian->editAttributes() ?> aria-describedby="x_Judul_Penelitian_help"><?= $Page->Judul_Penelitian->EditValue ?></textarea>
<?= $Page->Judul_Penelitian->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Judul_Penelitian->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Warna_Kaver->Visible) { // Warna_Kaver ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Warna_Kaver"<?= $Page->Warna_Kaver->rowAttributes() ?>>
        <label id="elh_proposal_penelitian_Warna_Kaver" for="x_Warna_Kaver" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Warna_Kaver->caption() ?><?= $Page->Warna_Kaver->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Warna_Kaver->cellAttributes() ?>>
<span id="el_proposal_penelitian_Warna_Kaver">
    <select
        id="x_Warna_Kaver"
        name="x_Warna_Kaver"
        class="form-select ew-select<?= $Page->Warna_Kaver->isInvalidClass() ?>"
        <?php if (!$Page->Warna_Kaver->IsNativeSelect) { ?>
        data-select2-id="fproposal_penelitianadd_x_Warna_Kaver"
        <?php } ?>
        data-table="proposal_penelitian"
        data-field="x_Warna_Kaver"
        data-value-separator="<?= $Page->Warna_Kaver->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Warna_Kaver->getPlaceHolder()) ?>"
        <?= $Page->Warna_Kaver->editAttributes() ?>>
        <?= $Page->Warna_Kaver->selectOptionListHtml("x_Warna_Kaver") ?>
    </select>
    <?= $Page->Warna_Kaver->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Warna_Kaver->getErrorMessage() ?></div>
<?= $Page->Warna_Kaver->Lookup->getParamTag($Page, "p_x_Warna_Kaver") ?>
<?php if (!$Page->Warna_Kaver->IsNativeSelect) { ?>
<script>
loadjs.ready("fproposal_penelitianadd", function() {
    var options = { name: "x_Warna_Kaver", selectId: "fproposal_penelitianadd_x_Warna_Kaver" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fproposal_penelitianadd.lists.Warna_Kaver?.lookupOptions.length) {
        options.data = { id: "x_Warna_Kaver", form: "fproposal_penelitianadd" };
    } else {
        options.ajax = { id: "x_Warna_Kaver", form: "fproposal_penelitianadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_penelitian.fields.Warna_Kaver.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Warna_Kaver"<?= $Page->Warna_Kaver->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Warna_Kaver"><?= $Page->Warna_Kaver->caption() ?><?= $Page->Warna_Kaver->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Warna_Kaver->cellAttributes() ?>>
<span id="el_proposal_penelitian_Warna_Kaver">
    <select
        id="x_Warna_Kaver"
        name="x_Warna_Kaver"
        class="form-select ew-select<?= $Page->Warna_Kaver->isInvalidClass() ?>"
        <?php if (!$Page->Warna_Kaver->IsNativeSelect) { ?>
        data-select2-id="fproposal_penelitianadd_x_Warna_Kaver"
        <?php } ?>
        data-table="proposal_penelitian"
        data-field="x_Warna_Kaver"
        data-value-separator="<?= $Page->Warna_Kaver->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Warna_Kaver->getPlaceHolder()) ?>"
        <?= $Page->Warna_Kaver->editAttributes() ?>>
        <?= $Page->Warna_Kaver->selectOptionListHtml("x_Warna_Kaver") ?>
    </select>
    <?= $Page->Warna_Kaver->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Warna_Kaver->getErrorMessage() ?></div>
<?= $Page->Warna_Kaver->Lookup->getParamTag($Page, "p_x_Warna_Kaver") ?>
<?php if (!$Page->Warna_Kaver->IsNativeSelect) { ?>
<script>
loadjs.ready("fproposal_penelitianadd", function() {
    var options = { name: "x_Warna_Kaver", selectId: "fproposal_penelitianadd_x_Warna_Kaver" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fproposal_penelitianadd.lists.Warna_Kaver?.lookupOptions.length) {
        options.data = { id: "x_Warna_Kaver", form: "fproposal_penelitianadd" };
    } else {
        options.ajax = { id: "x_Warna_Kaver", form: "fproposal_penelitianadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_penelitian.fields.Warna_Kaver.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->rowAttributes() ?>>
        <label id="elh_proposal_penelitian_Lembar_Pengesahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Lembar_Pengesahan->caption() ?><?= $Page->Lembar_Pengesahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_proposal_penelitian_Lembar_Pengesahan">
<div id="fd_x_Lembar_Pengesahan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Lembar_Pengesahan"
        name="x_Lembar_Pengesahan"
        class="form-control ew-file-input"
        title="<?= $Page->Lembar_Pengesahan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="proposal_penelitian"
        data-field="x_Lembar_Pengesahan"
        data-size="255"
        data-accept-file-types="<?= $Page->Lembar_Pengesahan->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Lembar_Pengesahan->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Lembar_Pengesahan->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Lembar_Pengesahan_help"
        <?= ($Page->Lembar_Pengesahan->ReadOnly || $Page->Lembar_Pengesahan->Disabled) ? " disabled" : "" ?>
        <?= $Page->Lembar_Pengesahan->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Lembar_Pengesahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Lembar_Pengesahan->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Lembar_Pengesahan" id= "fn_x_Lembar_Pengesahan" value="<?= $Page->Lembar_Pengesahan->Upload->FileName ?>">
<input type="hidden" name="fa_x_Lembar_Pengesahan" id= "fa_x_Lembar_Pengesahan" value="0">
<table id="ft_x_Lembar_Pengesahan" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?><?= $Page->Lembar_Pengesahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_proposal_penelitian_Lembar_Pengesahan">
<div id="fd_x_Lembar_Pengesahan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Lembar_Pengesahan"
        name="x_Lembar_Pengesahan"
        class="form-control ew-file-input"
        title="<?= $Page->Lembar_Pengesahan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="proposal_penelitian"
        data-field="x_Lembar_Pengesahan"
        data-size="255"
        data-accept-file-types="<?= $Page->Lembar_Pengesahan->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Lembar_Pengesahan->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Lembar_Pengesahan->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Lembar_Pengesahan_help"
        <?= ($Page->Lembar_Pengesahan->ReadOnly || $Page->Lembar_Pengesahan->Disabled) ? " disabled" : "" ?>
        <?= $Page->Lembar_Pengesahan->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Lembar_Pengesahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Lembar_Pengesahan->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Lembar_Pengesahan" id= "fn_x_Lembar_Pengesahan" value="<?= $Page->Lembar_Pengesahan->Upload->FileName ?>">
<input type="hidden" name="fa_x_Lembar_Pengesahan" id= "fa_x_Lembar_Pengesahan" value="0">
<table id="ft_x_Lembar_Pengesahan" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Soft_copy_Proposal->Visible) { // Soft_copy_Proposal ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Soft_copy_Proposal"<?= $Page->Soft_copy_Proposal->rowAttributes() ?>>
        <label id="elh_proposal_penelitian_Soft_copy_Proposal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Soft_copy_Proposal->caption() ?><?= $Page->Soft_copy_Proposal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Soft_copy_Proposal->cellAttributes() ?>>
<span id="el_proposal_penelitian_Soft_copy_Proposal">
<div id="fd_x_Soft_copy_Proposal" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Soft_copy_Proposal"
        name="x_Soft_copy_Proposal"
        class="form-control ew-file-input"
        title="<?= $Page->Soft_copy_Proposal->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="proposal_penelitian"
        data-field="x_Soft_copy_Proposal"
        data-size="255"
        data-accept-file-types="<?= $Page->Soft_copy_Proposal->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Soft_copy_Proposal->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Soft_copy_Proposal->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Soft_copy_Proposal_help"
        <?= ($Page->Soft_copy_Proposal->ReadOnly || $Page->Soft_copy_Proposal->Disabled) ? " disabled" : "" ?>
        <?= $Page->Soft_copy_Proposal->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Soft_copy_Proposal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Soft_copy_Proposal->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Soft_copy_Proposal" id= "fn_x_Soft_copy_Proposal" value="<?= $Page->Soft_copy_Proposal->Upload->FileName ?>">
<input type="hidden" name="fa_x_Soft_copy_Proposal" id= "fa_x_Soft_copy_Proposal" value="0">
<table id="ft_x_Soft_copy_Proposal" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Soft_copy_Proposal"<?= $Page->Soft_copy_Proposal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Soft_copy_Proposal"><?= $Page->Soft_copy_Proposal->caption() ?><?= $Page->Soft_copy_Proposal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Soft_copy_Proposal->cellAttributes() ?>>
<span id="el_proposal_penelitian_Soft_copy_Proposal">
<div id="fd_x_Soft_copy_Proposal" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Soft_copy_Proposal"
        name="x_Soft_copy_Proposal"
        class="form-control ew-file-input"
        title="<?= $Page->Soft_copy_Proposal->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="proposal_penelitian"
        data-field="x_Soft_copy_Proposal"
        data-size="255"
        data-accept-file-types="<?= $Page->Soft_copy_Proposal->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Soft_copy_Proposal->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Soft_copy_Proposal->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Soft_copy_Proposal_help"
        <?= ($Page->Soft_copy_Proposal->ReadOnly || $Page->Soft_copy_Proposal->Disabled) ? " disabled" : "" ?>
        <?= $Page->Soft_copy_Proposal->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Soft_copy_Proposal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Soft_copy_Proposal->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Soft_copy_Proposal" id= "fn_x_Soft_copy_Proposal" value="<?= $Page->Soft_copy_Proposal->Upload->FileName ?>">
<input type="hidden" name="fa_x_Soft_copy_Proposal" id= "fa_x_Soft_copy_Proposal" value="0">
<table id="ft_x_Soft_copy_Proposal" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Surat_Pernyataan_Tidak_Studi->Visible) { // Surat_Pernyataan_Tidak_Studi ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Surat_Pernyataan_Tidak_Studi"<?= $Page->Surat_Pernyataan_Tidak_Studi->rowAttributes() ?>>
        <label id="elh_proposal_penelitian_Surat_Pernyataan_Tidak_Studi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Surat_Pernyataan_Tidak_Studi->caption() ?><?= $Page->Surat_Pernyataan_Tidak_Studi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Surat_Pernyataan_Tidak_Studi->cellAttributes() ?>>
<span id="el_proposal_penelitian_Surat_Pernyataan_Tidak_Studi">
<div id="fd_x_Surat_Pernyataan_Tidak_Studi" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Surat_Pernyataan_Tidak_Studi"
        name="x_Surat_Pernyataan_Tidak_Studi"
        class="form-control ew-file-input"
        title="<?= $Page->Surat_Pernyataan_Tidak_Studi->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="proposal_penelitian"
        data-field="x_Surat_Pernyataan_Tidak_Studi"
        data-size="255"
        data-accept-file-types="<?= $Page->Surat_Pernyataan_Tidak_Studi->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Surat_Pernyataan_Tidak_Studi->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Surat_Pernyataan_Tidak_Studi->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Surat_Pernyataan_Tidak_Studi_help"
        <?= ($Page->Surat_Pernyataan_Tidak_Studi->ReadOnly || $Page->Surat_Pernyataan_Tidak_Studi->Disabled) ? " disabled" : "" ?>
        <?= $Page->Surat_Pernyataan_Tidak_Studi->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Surat_Pernyataan_Tidak_Studi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Surat_Pernyataan_Tidak_Studi->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Surat_Pernyataan_Tidak_Studi" id= "fn_x_Surat_Pernyataan_Tidak_Studi" value="<?= $Page->Surat_Pernyataan_Tidak_Studi->Upload->FileName ?>">
<input type="hidden" name="fa_x_Surat_Pernyataan_Tidak_Studi" id= "fa_x_Surat_Pernyataan_Tidak_Studi" value="0">
<table id="ft_x_Surat_Pernyataan_Tidak_Studi" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Surat_Pernyataan_Tidak_Studi"<?= $Page->Surat_Pernyataan_Tidak_Studi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proposal_penelitian_Surat_Pernyataan_Tidak_Studi"><?= $Page->Surat_Pernyataan_Tidak_Studi->caption() ?><?= $Page->Surat_Pernyataan_Tidak_Studi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Surat_Pernyataan_Tidak_Studi->cellAttributes() ?>>
<span id="el_proposal_penelitian_Surat_Pernyataan_Tidak_Studi">
<div id="fd_x_Surat_Pernyataan_Tidak_Studi" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Surat_Pernyataan_Tidak_Studi"
        name="x_Surat_Pernyataan_Tidak_Studi"
        class="form-control ew-file-input"
        title="<?= $Page->Surat_Pernyataan_Tidak_Studi->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="proposal_penelitian"
        data-field="x_Surat_Pernyataan_Tidak_Studi"
        data-size="255"
        data-accept-file-types="<?= $Page->Surat_Pernyataan_Tidak_Studi->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Surat_Pernyataan_Tidak_Studi->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Surat_Pernyataan_Tidak_Studi->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Surat_Pernyataan_Tidak_Studi_help"
        <?= ($Page->Surat_Pernyataan_Tidak_Studi->ReadOnly || $Page->Surat_Pernyataan_Tidak_Studi->Disabled) ? " disabled" : "" ?>
        <?= $Page->Surat_Pernyataan_Tidak_Studi->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Surat_Pernyataan_Tidak_Studi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Surat_Pernyataan_Tidak_Studi->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Surat_Pernyataan_Tidak_Studi" id= "fn_x_Surat_Pernyataan_Tidak_Studi" value="<?= $Page->Surat_Pernyataan_Tidak_Studi->Upload->FileName ?>">
<input type="hidden" name="fa_x_Surat_Pernyataan_Tidak_Studi" id= "fa_x_Surat_Pernyataan_Tidak_Studi" value="0">
<table id="ft_x_Surat_Pernyataan_Tidak_Studi" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fproposal_penelitianadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fproposal_penelitianadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("proposal_penelitian");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fproposal_penelitianadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
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

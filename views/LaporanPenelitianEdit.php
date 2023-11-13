<?php

namespace PHPMaker2023\new2023;

// Page object
$LaporanPenelitianEdit = &$Page;
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
<form name="flaporan_penelitianedit" id="flaporan_penelitianedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { laporan_penelitian: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var flaporan_penelitianedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flaporan_penelitianedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Id_Kelompok", [fields.Id_Kelompok.visible && fields.Id_Kelompok.required ? ew.Validators.required(fields.Id_Kelompok.caption) : null], fields.Id_Kelompok.isInvalid],
            ["Lembar_Pengesahan", [fields.Lembar_Pengesahan.visible && fields.Lembar_Pengesahan.required ? ew.Validators.fileRequired(fields.Lembar_Pengesahan.caption) : null], fields.Lembar_Pengesahan.isInvalid],
            ["Laporan", [fields.Laporan.visible && fields.Laporan.required ? ew.Validators.fileRequired(fields.Laporan.caption) : null], fields.Laporan.isInvalid],
            ["Luaran", [fields.Luaran.visible && fields.Luaran.required ? ew.Validators.fileRequired(fields.Luaran.caption) : null], fields.Luaran.isInvalid],
            ["Surat_Pernyataan_Kesediaan_Anggota", [fields.Surat_Pernyataan_Kesediaan_Anggota.visible && fields.Surat_Pernyataan_Kesediaan_Anggota.required ? ew.Validators.fileRequired(fields.Surat_Pernyataan_Kesediaan_Anggota.caption) : null], fields.Surat_Pernyataan_Kesediaan_Anggota.isInvalid],
            ["Tanggal", [fields.Tanggal.visible && fields.Tanggal.required ? ew.Validators.required(fields.Tanggal.caption) : null], fields.Tanggal.isInvalid],
            ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid],
            ["User", [fields.User.visible && fields.User.required ? ew.Validators.required(fields.User.caption) : null], fields.User.isInvalid],
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
            "Id_Kelompok": <?= $Page->Id_Kelompok->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="laporan_penelitian">
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
<table id="tbl_laporan_penelitianedit" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Id_Kelompok"<?= $Page->Id_Kelompok->rowAttributes() ?>>
        <label id="elh_laporan_penelitian_Id_Kelompok" for="x_Id_Kelompok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Id_Kelompok->caption() ?><?= $Page->Id_Kelompok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el_laporan_penelitian_Id_Kelompok">
    <select
        id="x_Id_Kelompok"
        name="x_Id_Kelompok"
        class="form-select ew-select<?= $Page->Id_Kelompok->isInvalidClass() ?>"
        <?php if (!$Page->Id_Kelompok->IsNativeSelect) { ?>
        data-select2-id="flaporan_penelitianedit_x_Id_Kelompok"
        <?php } ?>
        data-table="laporan_penelitian"
        data-field="x_Id_Kelompok"
        data-value-separator="<?= $Page->Id_Kelompok->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Id_Kelompok->getPlaceHolder()) ?>"
        <?= $Page->Id_Kelompok->editAttributes() ?>>
        <?= $Page->Id_Kelompok->selectOptionListHtml("x_Id_Kelompok") ?>
    </select>
    <?= $Page->Id_Kelompok->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Id_Kelompok->getErrorMessage() ?></div>
<?= $Page->Id_Kelompok->Lookup->getParamTag($Page, "p_x_Id_Kelompok") ?>
<?php if (!$Page->Id_Kelompok->IsNativeSelect) { ?>
<script>
loadjs.ready("flaporan_penelitianedit", function() {
    var options = { name: "x_Id_Kelompok", selectId: "flaporan_penelitianedit_x_Id_Kelompok" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (flaporan_penelitianedit.lists.Id_Kelompok?.lookupOptions.length) {
        options.data = { id: "x_Id_Kelompok", form: "flaporan_penelitianedit" };
    } else {
        options.ajax = { id: "x_Id_Kelompok", form: "flaporan_penelitianedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.laporan_penelitian.fields.Id_Kelompok.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
<input type="hidden" data-table="laporan_penelitian" data-field="x_Id_Kelompok" data-hidden="1" data-old name="o_Id_Kelompok" id="o_Id_Kelompok" value="<?= HtmlEncode($Page->Id_Kelompok->OldValue ?? $Page->Id_Kelompok->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Id_Kelompok"<?= $Page->Id_Kelompok->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Id_Kelompok"><?= $Page->Id_Kelompok->caption() ?><?= $Page->Id_Kelompok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el_laporan_penelitian_Id_Kelompok">
    <select
        id="x_Id_Kelompok"
        name="x_Id_Kelompok"
        class="form-select ew-select<?= $Page->Id_Kelompok->isInvalidClass() ?>"
        <?php if (!$Page->Id_Kelompok->IsNativeSelect) { ?>
        data-select2-id="flaporan_penelitianedit_x_Id_Kelompok"
        <?php } ?>
        data-table="laporan_penelitian"
        data-field="x_Id_Kelompok"
        data-value-separator="<?= $Page->Id_Kelompok->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Id_Kelompok->getPlaceHolder()) ?>"
        <?= $Page->Id_Kelompok->editAttributes() ?>>
        <?= $Page->Id_Kelompok->selectOptionListHtml("x_Id_Kelompok") ?>
    </select>
    <?= $Page->Id_Kelompok->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Id_Kelompok->getErrorMessage() ?></div>
<?= $Page->Id_Kelompok->Lookup->getParamTag($Page, "p_x_Id_Kelompok") ?>
<?php if (!$Page->Id_Kelompok->IsNativeSelect) { ?>
<script>
loadjs.ready("flaporan_penelitianedit", function() {
    var options = { name: "x_Id_Kelompok", selectId: "flaporan_penelitianedit_x_Id_Kelompok" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (flaporan_penelitianedit.lists.Id_Kelompok?.lookupOptions.length) {
        options.data = { id: "x_Id_Kelompok", form: "flaporan_penelitianedit" };
    } else {
        options.ajax = { id: "x_Id_Kelompok", form: "flaporan_penelitianedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.laporan_penelitian.fields.Id_Kelompok.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
<input type="hidden" data-table="laporan_penelitian" data-field="x_Id_Kelompok" data-hidden="1" data-old name="o_Id_Kelompok" id="o_Id_Kelompok" value="<?= HtmlEncode($Page->Id_Kelompok->OldValue ?? $Page->Id_Kelompok->CurrentValue) ?>">
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->rowAttributes() ?>>
        <label id="elh_laporan_penelitian_Lembar_Pengesahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Lembar_Pengesahan->caption() ?><?= $Page->Lembar_Pengesahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_laporan_penelitian_Lembar_Pengesahan">
<div id="fd_x_Lembar_Pengesahan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Lembar_Pengesahan"
        name="x_Lembar_Pengesahan"
        class="form-control ew-file-input"
        title="<?= $Page->Lembar_Pengesahan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_penelitian"
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
<input type="hidden" name="fa_x_Lembar_Pengesahan" id= "fa_x_Lembar_Pengesahan" value="<?= (Post("fa_x_Lembar_Pengesahan") == "0") ? "0" : "1" ?>">
<table id="ft_x_Lembar_Pengesahan" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?><?= $Page->Lembar_Pengesahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_laporan_penelitian_Lembar_Pengesahan">
<div id="fd_x_Lembar_Pengesahan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Lembar_Pengesahan"
        name="x_Lembar_Pengesahan"
        class="form-control ew-file-input"
        title="<?= $Page->Lembar_Pengesahan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_penelitian"
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
<input type="hidden" name="fa_x_Lembar_Pengesahan" id= "fa_x_Lembar_Pengesahan" value="<?= (Post("fa_x_Lembar_Pengesahan") == "0") ? "0" : "1" ?>">
<table id="ft_x_Lembar_Pengesahan" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Laporan->Visible) { // Laporan ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Laporan"<?= $Page->Laporan->rowAttributes() ?>>
        <label id="elh_laporan_penelitian_Laporan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Laporan->caption() ?><?= $Page->Laporan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Laporan->cellAttributes() ?>>
<span id="el_laporan_penelitian_Laporan">
<div id="fd_x_Laporan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Laporan"
        name="x_Laporan"
        class="form-control ew-file-input"
        title="<?= $Page->Laporan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_penelitian"
        data-field="x_Laporan"
        data-size="255"
        data-accept-file-types="<?= $Page->Laporan->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Laporan->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Laporan->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Laporan_help"
        <?= ($Page->Laporan->ReadOnly || $Page->Laporan->Disabled) ? " disabled" : "" ?>
        <?= $Page->Laporan->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Laporan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Laporan->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Laporan" id= "fn_x_Laporan" value="<?= $Page->Laporan->Upload->FileName ?>">
<input type="hidden" name="fa_x_Laporan" id= "fa_x_Laporan" value="<?= (Post("fa_x_Laporan") == "0") ? "0" : "1" ?>">
<table id="ft_x_Laporan" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Laporan"<?= $Page->Laporan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Laporan"><?= $Page->Laporan->caption() ?><?= $Page->Laporan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Laporan->cellAttributes() ?>>
<span id="el_laporan_penelitian_Laporan">
<div id="fd_x_Laporan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Laporan"
        name="x_Laporan"
        class="form-control ew-file-input"
        title="<?= $Page->Laporan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_penelitian"
        data-field="x_Laporan"
        data-size="255"
        data-accept-file-types="<?= $Page->Laporan->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Laporan->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Laporan->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Laporan_help"
        <?= ($Page->Laporan->ReadOnly || $Page->Laporan->Disabled) ? " disabled" : "" ?>
        <?= $Page->Laporan->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Laporan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Laporan->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Laporan" id= "fn_x_Laporan" value="<?= $Page->Laporan->Upload->FileName ?>">
<input type="hidden" name="fa_x_Laporan" id= "fa_x_Laporan" value="<?= (Post("fa_x_Laporan") == "0") ? "0" : "1" ?>">
<table id="ft_x_Laporan" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Luaran->Visible) { // Luaran ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Luaran"<?= $Page->Luaran->rowAttributes() ?>>
        <label id="elh_laporan_penelitian_Luaran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Luaran->caption() ?><?= $Page->Luaran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Luaran->cellAttributes() ?>>
<span id="el_laporan_penelitian_Luaran">
<div id="fd_x_Luaran" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Luaran"
        name="x_Luaran"
        class="form-control ew-file-input"
        title="<?= $Page->Luaran->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_penelitian"
        data-field="x_Luaran"
        data-size="255"
        data-accept-file-types="<?= $Page->Luaran->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Luaran->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Luaran->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Luaran_help"
        <?= ($Page->Luaran->ReadOnly || $Page->Luaran->Disabled) ? " disabled" : "" ?>
        <?= $Page->Luaran->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Luaran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Luaran->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Luaran" id= "fn_x_Luaran" value="<?= $Page->Luaran->Upload->FileName ?>">
<input type="hidden" name="fa_x_Luaran" id= "fa_x_Luaran" value="<?= (Post("fa_x_Luaran") == "0") ? "0" : "1" ?>">
<table id="ft_x_Luaran" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Luaran"<?= $Page->Luaran->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Luaran"><?= $Page->Luaran->caption() ?><?= $Page->Luaran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Luaran->cellAttributes() ?>>
<span id="el_laporan_penelitian_Luaran">
<div id="fd_x_Luaran" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Luaran"
        name="x_Luaran"
        class="form-control ew-file-input"
        title="<?= $Page->Luaran->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_penelitian"
        data-field="x_Luaran"
        data-size="255"
        data-accept-file-types="<?= $Page->Luaran->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Luaran->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Luaran->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Luaran_help"
        <?= ($Page->Luaran->ReadOnly || $Page->Luaran->Disabled) ? " disabled" : "" ?>
        <?= $Page->Luaran->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Luaran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Luaran->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Luaran" id= "fn_x_Luaran" value="<?= $Page->Luaran->Upload->FileName ?>">
<input type="hidden" name="fa_x_Luaran" id= "fa_x_Luaran" value="<?= (Post("fa_x_Luaran") == "0") ? "0" : "1" ?>">
<table id="ft_x_Luaran" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Surat_Pernyataan_Kesediaan_Anggota->Visible) { // Surat_Pernyataan_Kesediaan_Anggota ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Surat_Pernyataan_Kesediaan_Anggota"<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->rowAttributes() ?>>
        <label id="elh_laporan_penelitian_Surat_Pernyataan_Kesediaan_Anggota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Surat_Pernyataan_Kesediaan_Anggota->caption() ?><?= $Page->Surat_Pernyataan_Kesediaan_Anggota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->cellAttributes() ?>>
<span id="el_laporan_penelitian_Surat_Pernyataan_Kesediaan_Anggota">
<div id="fd_x_Surat_Pernyataan_Kesediaan_Anggota" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Surat_Pernyataan_Kesediaan_Anggota"
        name="x_Surat_Pernyataan_Kesediaan_Anggota"
        class="form-control ew-file-input"
        title="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_penelitian"
        data-field="x_Surat_Pernyataan_Kesediaan_Anggota"
        data-size="255"
        data-accept-file-types="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Surat_Pernyataan_Kesediaan_Anggota_help"
        <?= ($Page->Surat_Pernyataan_Kesediaan_Anggota->ReadOnly || $Page->Surat_Pernyataan_Kesediaan_Anggota->Disabled) ? " disabled" : "" ?>
        <?= $Page->Surat_Pernyataan_Kesediaan_Anggota->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Surat_Pernyataan_Kesediaan_Anggota->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Surat_Pernyataan_Kesediaan_Anggota" id= "fn_x_Surat_Pernyataan_Kesediaan_Anggota" value="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->Upload->FileName ?>">
<input type="hidden" name="fa_x_Surat_Pernyataan_Kesediaan_Anggota" id= "fa_x_Surat_Pernyataan_Kesediaan_Anggota" value="<?= (Post("fa_x_Surat_Pernyataan_Kesediaan_Anggota") == "0") ? "0" : "1" ?>">
<table id="ft_x_Surat_Pernyataan_Kesediaan_Anggota" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Surat_Pernyataan_Kesediaan_Anggota"<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_penelitian_Surat_Pernyataan_Kesediaan_Anggota"><?= $Page->Surat_Pernyataan_Kesediaan_Anggota->caption() ?><?= $Page->Surat_Pernyataan_Kesediaan_Anggota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->cellAttributes() ?>>
<span id="el_laporan_penelitian_Surat_Pernyataan_Kesediaan_Anggota">
<div id="fd_x_Surat_Pernyataan_Kesediaan_Anggota" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Surat_Pernyataan_Kesediaan_Anggota"
        name="x_Surat_Pernyataan_Kesediaan_Anggota"
        class="form-control ew-file-input"
        title="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_penelitian"
        data-field="x_Surat_Pernyataan_Kesediaan_Anggota"
        data-size="255"
        data-accept-file-types="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Surat_Pernyataan_Kesediaan_Anggota_help"
        <?= ($Page->Surat_Pernyataan_Kesediaan_Anggota->ReadOnly || $Page->Surat_Pernyataan_Kesediaan_Anggota->Disabled) ? " disabled" : "" ?>
        <?= $Page->Surat_Pernyataan_Kesediaan_Anggota->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Surat_Pernyataan_Kesediaan_Anggota->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Surat_Pernyataan_Kesediaan_Anggota" id= "fn_x_Surat_Pernyataan_Kesediaan_Anggota" value="<?= $Page->Surat_Pernyataan_Kesediaan_Anggota->Upload->FileName ?>">
<input type="hidden" name="fa_x_Surat_Pernyataan_Kesediaan_Anggota" id= "fa_x_Surat_Pernyataan_Kesediaan_Anggota" value="<?= (Post("fa_x_Surat_Pernyataan_Kesediaan_Anggota") == "0") ? "0" : "1" ?>">
<table id="ft_x_Surat_Pernyataan_Kesediaan_Anggota" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="flaporan_penelitianedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="flaporan_penelitianedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("laporan_penelitian");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#flaporan_penelitianedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(flaporan_penelitianedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#flaporan_penelitianedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

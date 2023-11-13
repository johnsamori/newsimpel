<?php

namespace PHPMaker2023\new2023;

// Page object
$LaporanPengabdianAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { laporan_pengabdian: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var flaporan_pengabdianadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flaporan_pengabdianadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["Id_kelompok", [fields.Id_kelompok.visible && fields.Id_kelompok.required ? ew.Validators.required(fields.Id_kelompok.caption) : null], fields.Id_kelompok.isInvalid],
            ["Lembar_Pengesahan", [fields.Lembar_Pengesahan.visible && fields.Lembar_Pengesahan.required ? ew.Validators.fileRequired(fields.Lembar_Pengesahan.caption) : null], fields.Lembar_Pengesahan.isInvalid],
            ["Laporan", [fields.Laporan.visible && fields.Laporan.required ? ew.Validators.fileRequired(fields.Laporan.caption) : null], fields.Laporan.isInvalid],
            ["Luaran", [fields.Luaran.visible && fields.Luaran.required ? ew.Validators.fileRequired(fields.Luaran.caption) : null], fields.Luaran.isInvalid],
            ["Surat_Keterangan_dari_Tempat_Mengabdi", [fields.Surat_Keterangan_dari_Tempat_Mengabdi.visible && fields.Surat_Keterangan_dari_Tempat_Mengabdi.required ? ew.Validators.fileRequired(fields.Surat_Keterangan_dari_Tempat_Mengabdi.caption) : null], fields.Surat_Keterangan_dari_Tempat_Mengabdi.isInvalid],
            ["Dokumentasi", [fields.Dokumentasi.visible && fields.Dokumentasi.required ? ew.Validators.fileRequired(fields.Dokumentasi.caption) : null], fields.Dokumentasi.isInvalid],
            ["Daftar_Hadir", [fields.Daftar_Hadir.visible && fields.Daftar_Hadir.required ? ew.Validators.fileRequired(fields.Daftar_Hadir.caption) : null], fields.Daftar_Hadir.isInvalid],
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
<form name="flaporan_pengabdianadd" id="flaporan_pengabdianadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="laporan_pengabdian">
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
<table id="tbl_laporan_pengabdianadd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->Id_kelompok->Visible) { // Id_kelompok ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Id_kelompok"<?= $Page->Id_kelompok->rowAttributes() ?>>
        <label id="elh_laporan_pengabdian_Id_kelompok" for="x_Id_kelompok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Id_kelompok->caption() ?><?= $Page->Id_kelompok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Id_kelompok->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Id_kelompok">
    <select
        id="x_Id_kelompok"
        name="x_Id_kelompok"
        class="form-select ew-select<?= $Page->Id_kelompok->isInvalidClass() ?>"
        <?php if (!$Page->Id_kelompok->IsNativeSelect) { ?>
        data-select2-id="flaporan_pengabdianadd_x_Id_kelompok"
        <?php } ?>
        data-table="laporan_pengabdian"
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
loadjs.ready("flaporan_pengabdianadd", function() {
    var options = { name: "x_Id_kelompok", selectId: "flaporan_pengabdianadd_x_Id_kelompok" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (flaporan_pengabdianadd.lists.Id_kelompok?.lookupOptions.length) {
        options.data = { id: "x_Id_kelompok", form: "flaporan_pengabdianadd" };
    } else {
        options.ajax = { id: "x_Id_kelompok", form: "flaporan_pengabdianadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.laporan_pengabdian.fields.Id_kelompok.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Id_kelompok"<?= $Page->Id_kelompok->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Id_kelompok"><?= $Page->Id_kelompok->caption() ?><?= $Page->Id_kelompok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Id_kelompok->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Id_kelompok">
    <select
        id="x_Id_kelompok"
        name="x_Id_kelompok"
        class="form-select ew-select<?= $Page->Id_kelompok->isInvalidClass() ?>"
        <?php if (!$Page->Id_kelompok->IsNativeSelect) { ?>
        data-select2-id="flaporan_pengabdianadd_x_Id_kelompok"
        <?php } ?>
        data-table="laporan_pengabdian"
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
loadjs.ready("flaporan_pengabdianadd", function() {
    var options = { name: "x_Id_kelompok", selectId: "flaporan_pengabdianadd_x_Id_kelompok" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (flaporan_pengabdianadd.lists.Id_kelompok?.lookupOptions.length) {
        options.data = { id: "x_Id_kelompok", form: "flaporan_pengabdianadd" };
    } else {
        options.ajax = { id: "x_Id_kelompok", form: "flaporan_pengabdianadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.laporan_pengabdian.fields.Id_kelompok.selectOptions);
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
        <label id="elh_laporan_pengabdian_Lembar_Pengesahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Lembar_Pengesahan->caption() ?><?= $Page->Lembar_Pengesahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Lembar_Pengesahan">
<div id="fd_x_Lembar_Pengesahan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Lembar_Pengesahan"
        name="x_Lembar_Pengesahan"
        class="form-control ew-file-input"
        title="<?= $Page->Lembar_Pengesahan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
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
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?><?= $Page->Lembar_Pengesahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Lembar_Pengesahan">
<div id="fd_x_Lembar_Pengesahan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Lembar_Pengesahan"
        name="x_Lembar_Pengesahan"
        class="form-control ew-file-input"
        title="<?= $Page->Lembar_Pengesahan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
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
<?php if ($Page->Laporan->Visible) { // Laporan ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Laporan"<?= $Page->Laporan->rowAttributes() ?>>
        <label id="elh_laporan_pengabdian_Laporan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Laporan->caption() ?><?= $Page->Laporan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Laporan->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Laporan">
<div id="fd_x_Laporan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Laporan"
        name="x_Laporan"
        class="form-control ew-file-input"
        title="<?= $Page->Laporan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
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
<input type="hidden" name="fa_x_Laporan" id= "fa_x_Laporan" value="0">
<table id="ft_x_Laporan" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Laporan"<?= $Page->Laporan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Laporan"><?= $Page->Laporan->caption() ?><?= $Page->Laporan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Laporan->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Laporan">
<div id="fd_x_Laporan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Laporan"
        name="x_Laporan"
        class="form-control ew-file-input"
        title="<?= $Page->Laporan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
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
<input type="hidden" name="fa_x_Laporan" id= "fa_x_Laporan" value="0">
<table id="ft_x_Laporan" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Luaran->Visible) { // Luaran ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Luaran"<?= $Page->Luaran->rowAttributes() ?>>
        <label id="elh_laporan_pengabdian_Luaran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Luaran->caption() ?><?= $Page->Luaran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Luaran->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Luaran">
<div id="fd_x_Luaran" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Luaran"
        name="x_Luaran"
        class="form-control ew-file-input"
        title="<?= $Page->Luaran->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
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
<input type="hidden" name="fa_x_Luaran" id= "fa_x_Luaran" value="0">
<table id="ft_x_Luaran" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Luaran"<?= $Page->Luaran->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Luaran"><?= $Page->Luaran->caption() ?><?= $Page->Luaran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Luaran->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Luaran">
<div id="fd_x_Luaran" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Luaran"
        name="x_Luaran"
        class="form-control ew-file-input"
        title="<?= $Page->Luaran->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
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
<input type="hidden" name="fa_x_Luaran" id= "fa_x_Luaran" value="0">
<table id="ft_x_Luaran" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Surat_Keterangan_dari_Tempat_Mengabdi->Visible) { // Surat_Keterangan_dari_Tempat_Mengabdi ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Surat_Keterangan_dari_Tempat_Mengabdi"<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->rowAttributes() ?>>
        <label id="elh_laporan_pengabdian_Surat_Keterangan_dari_Tempat_Mengabdi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->caption() ?><?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Surat_Keterangan_dari_Tempat_Mengabdi">
<div id="fd_x_Surat_Keterangan_dari_Tempat_Mengabdi" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Surat_Keterangan_dari_Tempat_Mengabdi"
        name="x_Surat_Keterangan_dari_Tempat_Mengabdi"
        class="form-control ew-file-input"
        title="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
        data-field="x_Surat_Keterangan_dari_Tempat_Mengabdi"
        data-size="255"
        data-accept-file-types="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Surat_Keterangan_dari_Tempat_Mengabdi_help"
        <?= ($Page->Surat_Keterangan_dari_Tempat_Mengabdi->ReadOnly || $Page->Surat_Keterangan_dari_Tempat_Mengabdi->Disabled) ? " disabled" : "" ?>
        <?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Surat_Keterangan_dari_Tempat_Mengabdi" id= "fn_x_Surat_Keterangan_dari_Tempat_Mengabdi" value="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName ?>">
<input type="hidden" name="fa_x_Surat_Keterangan_dari_Tempat_Mengabdi" id= "fa_x_Surat_Keterangan_dari_Tempat_Mengabdi" value="0">
<table id="ft_x_Surat_Keterangan_dari_Tempat_Mengabdi" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Surat_Keterangan_dari_Tempat_Mengabdi"<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Surat_Keterangan_dari_Tempat_Mengabdi"><?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->caption() ?><?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Surat_Keterangan_dari_Tempat_Mengabdi">
<div id="fd_x_Surat_Keterangan_dari_Tempat_Mengabdi" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Surat_Keterangan_dari_Tempat_Mengabdi"
        name="x_Surat_Keterangan_dari_Tempat_Mengabdi"
        class="form-control ew-file-input"
        title="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
        data-field="x_Surat_Keterangan_dari_Tempat_Mengabdi"
        data-size="255"
        data-accept-file-types="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Surat_Keterangan_dari_Tempat_Mengabdi_help"
        <?= ($Page->Surat_Keterangan_dari_Tempat_Mengabdi->ReadOnly || $Page->Surat_Keterangan_dari_Tempat_Mengabdi->Disabled) ? " disabled" : "" ?>
        <?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Surat_Keterangan_dari_Tempat_Mengabdi" id= "fn_x_Surat_Keterangan_dari_Tempat_Mengabdi" value="<?= $Page->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName ?>">
<input type="hidden" name="fa_x_Surat_Keterangan_dari_Tempat_Mengabdi" id= "fa_x_Surat_Keterangan_dari_Tempat_Mengabdi" value="0">
<table id="ft_x_Surat_Keterangan_dari_Tempat_Mengabdi" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Dokumentasi->Visible) { // Dokumentasi ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Dokumentasi"<?= $Page->Dokumentasi->rowAttributes() ?>>
        <label id="elh_laporan_pengabdian_Dokumentasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Dokumentasi->caption() ?><?= $Page->Dokumentasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Dokumentasi->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Dokumentasi">
<div id="fd_x_Dokumentasi" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Dokumentasi"
        name="x_Dokumentasi"
        class="form-control ew-file-input"
        title="<?= $Page->Dokumentasi->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
        data-field="x_Dokumentasi"
        data-size="255"
        data-accept-file-types="<?= $Page->Dokumentasi->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Dokumentasi->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Dokumentasi->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Dokumentasi_help"
        <?= ($Page->Dokumentasi->ReadOnly || $Page->Dokumentasi->Disabled) ? " disabled" : "" ?>
        <?= $Page->Dokumentasi->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Dokumentasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Dokumentasi->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Dokumentasi" id= "fn_x_Dokumentasi" value="<?= $Page->Dokumentasi->Upload->FileName ?>">
<input type="hidden" name="fa_x_Dokumentasi" id= "fa_x_Dokumentasi" value="0">
<table id="ft_x_Dokumentasi" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Dokumentasi"<?= $Page->Dokumentasi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Dokumentasi"><?= $Page->Dokumentasi->caption() ?><?= $Page->Dokumentasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Dokumentasi->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Dokumentasi">
<div id="fd_x_Dokumentasi" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Dokumentasi"
        name="x_Dokumentasi"
        class="form-control ew-file-input"
        title="<?= $Page->Dokumentasi->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
        data-field="x_Dokumentasi"
        data-size="255"
        data-accept-file-types="<?= $Page->Dokumentasi->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Dokumentasi->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Dokumentasi->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Dokumentasi_help"
        <?= ($Page->Dokumentasi->ReadOnly || $Page->Dokumentasi->Disabled) ? " disabled" : "" ?>
        <?= $Page->Dokumentasi->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Dokumentasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Dokumentasi->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Dokumentasi" id= "fn_x_Dokumentasi" value="<?= $Page->Dokumentasi->Upload->FileName ?>">
<input type="hidden" name="fa_x_Dokumentasi" id= "fa_x_Dokumentasi" value="0">
<table id="ft_x_Dokumentasi" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Daftar_Hadir->Visible) { // Daftar_Hadir ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Daftar_Hadir"<?= $Page->Daftar_Hadir->rowAttributes() ?>>
        <label id="elh_laporan_pengabdian_Daftar_Hadir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Daftar_Hadir->caption() ?><?= $Page->Daftar_Hadir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Daftar_Hadir->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Daftar_Hadir">
<div id="fd_x_Daftar_Hadir" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Daftar_Hadir"
        name="x_Daftar_Hadir"
        class="form-control ew-file-input"
        title="<?= $Page->Daftar_Hadir->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
        data-field="x_Daftar_Hadir"
        data-size="255"
        data-accept-file-types="<?= $Page->Daftar_Hadir->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Daftar_Hadir->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Daftar_Hadir->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Daftar_Hadir_help"
        <?= ($Page->Daftar_Hadir->ReadOnly || $Page->Daftar_Hadir->Disabled) ? " disabled" : "" ?>
        <?= $Page->Daftar_Hadir->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Daftar_Hadir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Daftar_Hadir->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Daftar_Hadir" id= "fn_x_Daftar_Hadir" value="<?= $Page->Daftar_Hadir->Upload->FileName ?>">
<input type="hidden" name="fa_x_Daftar_Hadir" id= "fa_x_Daftar_Hadir" value="0">
<table id="ft_x_Daftar_Hadir" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Daftar_Hadir"<?= $Page->Daftar_Hadir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_laporan_pengabdian_Daftar_Hadir"><?= $Page->Daftar_Hadir->caption() ?><?= $Page->Daftar_Hadir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Daftar_Hadir->cellAttributes() ?>>
<span id="el_laporan_pengabdian_Daftar_Hadir">
<div id="fd_x_Daftar_Hadir" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Daftar_Hadir"
        name="x_Daftar_Hadir"
        class="form-control ew-file-input"
        title="<?= $Page->Daftar_Hadir->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="laporan_pengabdian"
        data-field="x_Daftar_Hadir"
        data-size="255"
        data-accept-file-types="<?= $Page->Daftar_Hadir->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Daftar_Hadir->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Daftar_Hadir->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Daftar_Hadir_help"
        <?= ($Page->Daftar_Hadir->ReadOnly || $Page->Daftar_Hadir->Disabled) ? " disabled" : "" ?>
        <?= $Page->Daftar_Hadir->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Daftar_Hadir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Daftar_Hadir->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Daftar_Hadir" id= "fn_x_Daftar_Hadir" value="<?= $Page->Daftar_Hadir->Upload->FileName ?>">
<input type="hidden" name="fa_x_Daftar_Hadir" id= "fa_x_Daftar_Hadir" value="0">
<table id="ft_x_Daftar_Hadir" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="flaporan_pengabdianadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="flaporan_pengabdianadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("laporan_pengabdian");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#flaporan_pengabdianadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(flaporan_pengabdianadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#flaporan_pengabdianadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

<?php

namespace PHPMaker2023\new2023;

// Page object
$DosenEdit = &$Page;
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
<form name="fdosenedit" id="fdosenedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dosen: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fdosenedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdosenedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["NIDN", [fields.NIDN.visible && fields.NIDN.required ? ew.Validators.required(fields.NIDN.caption) : null], fields.NIDN.isInvalid],
            ["Id_Sinta", [fields.Id_Sinta.visible && fields.Id_Sinta.required ? ew.Validators.required(fields.Id_Sinta.caption) : null], fields.Id_Sinta.isInvalid],
            ["Nama_Lengkap", [fields.Nama_Lengkap.visible && fields.Nama_Lengkap.required ? ew.Validators.required(fields.Nama_Lengkap.caption) : null], fields.Nama_Lengkap.isInvalid],
            ["Alamat", [fields.Alamat.visible && fields.Alamat.required ? ew.Validators.required(fields.Alamat.caption) : null], fields.Alamat.isInvalid],
            ["_Email", [fields._Email.visible && fields._Email.required ? ew.Validators.required(fields._Email.caption) : null, ew.Validators.email], fields._Email.isInvalid],
            ["Jenis_Kelamin", [fields.Jenis_Kelamin.visible && fields.Jenis_Kelamin.required ? ew.Validators.required(fields.Jenis_Kelamin.caption) : null], fields.Jenis_Kelamin.isInvalid],
            ["Program_Studi", [fields.Program_Studi.visible && fields.Program_Studi.required ? ew.Validators.required(fields.Program_Studi.caption) : null], fields.Program_Studi.isInvalid],
            ["Jenjang_Pendidikan", [fields.Jenjang_Pendidikan.visible && fields.Jenjang_Pendidikan.required ? ew.Validators.required(fields.Jenjang_Pendidikan.caption) : null], fields.Jenjang_Pendidikan.isInvalid],
            ["Jabatan_Fungsional", [fields.Jabatan_Fungsional.visible && fields.Jabatan_Fungsional.required ? ew.Validators.required(fields.Jabatan_Fungsional.caption) : null], fields.Jabatan_Fungsional.isInvalid],
            ["Kepakaran", [fields.Kepakaran.visible && fields.Kepakaran.required ? ew.Validators.required(fields.Kepakaran.caption) : null], fields.Kepakaran.isInvalid],
            ["Rumpun_Ilmu", [fields.Rumpun_Ilmu.visible && fields.Rumpun_Ilmu.required ? ew.Validators.required(fields.Rumpun_Ilmu.caption) : null], fields.Rumpun_Ilmu.isInvalid],
            ["Aktif", [fields.Aktif.visible && fields.Aktif.required ? ew.Validators.required(fields.Aktif.caption) : null], fields.Aktif.isInvalid],
            ["Validasi", [fields.Validasi.visible && fields.Validasi.required ? ew.Validators.required(fields.Validasi.caption) : null], fields.Validasi.isInvalid]
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
            "Jenis_Kelamin": <?= $Page->Jenis_Kelamin->toClientList($Page) ?>,
            "Jenjang_Pendidikan": <?= $Page->Jenjang_Pendidikan->toClientList($Page) ?>,
            "Jabatan_Fungsional": <?= $Page->Jabatan_Fungsional->toClientList($Page) ?>,
            "Kepakaran": <?= $Page->Kepakaran->toClientList($Page) ?>,
            "Rumpun_Ilmu": <?= $Page->Rumpun_Ilmu->toClientList($Page) ?>,
            "Aktif": <?= $Page->Aktif->toClientList($Page) ?>,
            "Validasi": <?= $Page->Validasi->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="dosen">
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
<table id="tbl_dosenedit" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->NIDN->Visible) { // NIDN ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_NIDN"<?= $Page->NIDN->rowAttributes() ?>>
        <label id="elh_dosen_NIDN" for="x_NIDN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIDN->caption() ?><?= $Page->NIDN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIDN->cellAttributes() ?>>
<span id="el_dosen_NIDN">
<input type="<?= $Page->NIDN->getInputTextType() ?>" name="x_NIDN" id="x_NIDN" data-table="dosen" data-field="x_NIDN" value="<?= $Page->NIDN->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->NIDN->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIDN->formatPattern()) ?>"<?= $Page->NIDN->editAttributes() ?> aria-describedby="x_NIDN_help">
<?= $Page->NIDN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIDN->getErrorMessage() ?></div>
<input type="hidden" data-table="dosen" data-field="x_NIDN" data-hidden="1" data-old name="o_NIDN" id="o_NIDN" value="<?= HtmlEncode($Page->NIDN->OldValue ?? $Page->NIDN->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_NIDN"<?= $Page->NIDN->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_NIDN"><?= $Page->NIDN->caption() ?><?= $Page->NIDN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->NIDN->cellAttributes() ?>>
<span id="el_dosen_NIDN">
<input type="<?= $Page->NIDN->getInputTextType() ?>" name="x_NIDN" id="x_NIDN" data-table="dosen" data-field="x_NIDN" value="<?= $Page->NIDN->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->NIDN->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIDN->formatPattern()) ?>"<?= $Page->NIDN->editAttributes() ?> aria-describedby="x_NIDN_help">
<?= $Page->NIDN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIDN->getErrorMessage() ?></div>
<input type="hidden" data-table="dosen" data-field="x_NIDN" data-hidden="1" data-old name="o_NIDN" id="o_NIDN" value="<?= HtmlEncode($Page->NIDN->OldValue ?? $Page->NIDN->CurrentValue) ?>">
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Id_Sinta"<?= $Page->Id_Sinta->rowAttributes() ?>>
        <label id="elh_dosen_Id_Sinta" for="x_Id_Sinta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Id_Sinta->caption() ?><?= $Page->Id_Sinta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Id_Sinta->cellAttributes() ?>>
<span id="el_dosen_Id_Sinta">
<input type="<?= $Page->Id_Sinta->getInputTextType() ?>" name="x_Id_Sinta" id="x_Id_Sinta" data-table="dosen" data-field="x_Id_Sinta" value="<?= $Page->Id_Sinta->EditValue ?>" size="30" maxlength="7" placeholder="<?= HtmlEncode($Page->Id_Sinta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Id_Sinta->formatPattern()) ?>"<?= $Page->Id_Sinta->editAttributes() ?> aria-describedby="x_Id_Sinta_help">
<?= $Page->Id_Sinta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Id_Sinta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Id_Sinta"<?= $Page->Id_Sinta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Id_Sinta"><?= $Page->Id_Sinta->caption() ?><?= $Page->Id_Sinta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Id_Sinta->cellAttributes() ?>>
<span id="el_dosen_Id_Sinta">
<input type="<?= $Page->Id_Sinta->getInputTextType() ?>" name="x_Id_Sinta" id="x_Id_Sinta" data-table="dosen" data-field="x_Id_Sinta" value="<?= $Page->Id_Sinta->EditValue ?>" size="30" maxlength="7" placeholder="<?= HtmlEncode($Page->Id_Sinta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Id_Sinta->formatPattern()) ?>"<?= $Page->Id_Sinta->editAttributes() ?> aria-describedby="x_Id_Sinta_help">
<?= $Page->Id_Sinta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Id_Sinta->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Nama_Lengkap"<?= $Page->Nama_Lengkap->rowAttributes() ?>>
        <label id="elh_dosen_Nama_Lengkap" for="x_Nama_Lengkap" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama_Lengkap->caption() ?><?= $Page->Nama_Lengkap->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el_dosen_Nama_Lengkap">
<input type="<?= $Page->Nama_Lengkap->getInputTextType() ?>" name="x_Nama_Lengkap" id="x_Nama_Lengkap" data-table="dosen" data-field="x_Nama_Lengkap" value="<?= $Page->Nama_Lengkap->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Nama_Lengkap->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama_Lengkap->formatPattern()) ?>"<?= $Page->Nama_Lengkap->editAttributes() ?> aria-describedby="x_Nama_Lengkap_help">
<?= $Page->Nama_Lengkap->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama_Lengkap->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Nama_Lengkap"<?= $Page->Nama_Lengkap->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Nama_Lengkap"><?= $Page->Nama_Lengkap->caption() ?><?= $Page->Nama_Lengkap->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el_dosen_Nama_Lengkap">
<input type="<?= $Page->Nama_Lengkap->getInputTextType() ?>" name="x_Nama_Lengkap" id="x_Nama_Lengkap" data-table="dosen" data-field="x_Nama_Lengkap" value="<?= $Page->Nama_Lengkap->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Nama_Lengkap->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama_Lengkap->formatPattern()) ?>"<?= $Page->Nama_Lengkap->editAttributes() ?> aria-describedby="x_Nama_Lengkap_help">
<?= $Page->Nama_Lengkap->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama_Lengkap->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Alamat"<?= $Page->Alamat->rowAttributes() ?>>
        <label id="elh_dosen_Alamat" for="x_Alamat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Alamat->caption() ?><?= $Page->Alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Alamat->cellAttributes() ?>>
<span id="el_dosen_Alamat">
<input type="<?= $Page->Alamat->getInputTextType() ?>" name="x_Alamat" id="x_Alamat" data-table="dosen" data-field="x_Alamat" value="<?= $Page->Alamat->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->Alamat->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Alamat->formatPattern()) ?>"<?= $Page->Alamat->editAttributes() ?> aria-describedby="x_Alamat_help">
<?= $Page->Alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Alamat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Alamat"<?= $Page->Alamat->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Alamat"><?= $Page->Alamat->caption() ?><?= $Page->Alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Alamat->cellAttributes() ?>>
<span id="el_dosen_Alamat">
<input type="<?= $Page->Alamat->getInputTextType() ?>" name="x_Alamat" id="x_Alamat" data-table="dosen" data-field="x_Alamat" value="<?= $Page->Alamat->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->Alamat->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Alamat->formatPattern()) ?>"<?= $Page->Alamat->editAttributes() ?> aria-describedby="x_Alamat_help">
<?= $Page->Alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Alamat->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <label id="elh_dosen__Email" for="x__Email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Email->caption() ?><?= $Page->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Email->cellAttributes() ?>>
<span id="el_dosen__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x__Email" id="x__Email" data-table="dosen" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Email->formatPattern()) ?>"<?= $Page->_Email->editAttributes() ?> aria-describedby="x__Email_help">
<?= $Page->_Email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen__Email"><?= $Page->_Email->caption() ?><?= $Page->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Email->cellAttributes() ?>>
<span id="el_dosen__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x__Email" id="x__Email" data-table="dosen" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Email->formatPattern()) ?>"<?= $Page->_Email->editAttributes() ?> aria-describedby="x__Email_help">
<?= $Page->_Email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Jenis_Kelamin"<?= $Page->Jenis_Kelamin->rowAttributes() ?>>
        <label id="elh_dosen_Jenis_Kelamin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jenis_Kelamin->caption() ?><?= $Page->Jenis_Kelamin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el_dosen_Jenis_Kelamin">
<template id="tp_x_Jenis_Kelamin">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="dosen" data-field="x_Jenis_Kelamin" name="x_Jenis_Kelamin" id="x_Jenis_Kelamin"<?= $Page->Jenis_Kelamin->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_Jenis_Kelamin" class="ew-item-list"></div>
<selection-list hidden
    id="x_Jenis_Kelamin"
    name="x_Jenis_Kelamin"
    value="<?= HtmlEncode($Page->Jenis_Kelamin->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_Jenis_Kelamin"
    data-target="dsl_x_Jenis_Kelamin"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Jenis_Kelamin->isInvalidClass() ?>"
    data-table="dosen"
    data-field="x_Jenis_Kelamin"
    data-value-separator="<?= $Page->Jenis_Kelamin->displayValueSeparatorAttribute() ?>"
    <?= $Page->Jenis_Kelamin->editAttributes() ?>></selection-list>
<?= $Page->Jenis_Kelamin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Jenis_Kelamin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Jenis_Kelamin"<?= $Page->Jenis_Kelamin->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Jenis_Kelamin"><?= $Page->Jenis_Kelamin->caption() ?><?= $Page->Jenis_Kelamin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el_dosen_Jenis_Kelamin">
<template id="tp_x_Jenis_Kelamin">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="dosen" data-field="x_Jenis_Kelamin" name="x_Jenis_Kelamin" id="x_Jenis_Kelamin"<?= $Page->Jenis_Kelamin->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_Jenis_Kelamin" class="ew-item-list"></div>
<selection-list hidden
    id="x_Jenis_Kelamin"
    name="x_Jenis_Kelamin"
    value="<?= HtmlEncode($Page->Jenis_Kelamin->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_Jenis_Kelamin"
    data-target="dsl_x_Jenis_Kelamin"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Jenis_Kelamin->isInvalidClass() ?>"
    data-table="dosen"
    data-field="x_Jenis_Kelamin"
    data-value-separator="<?= $Page->Jenis_Kelamin->displayValueSeparatorAttribute() ?>"
    <?= $Page->Jenis_Kelamin->editAttributes() ?>></selection-list>
<?= $Page->Jenis_Kelamin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Jenis_Kelamin->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Program_Studi"<?= $Page->Program_Studi->rowAttributes() ?>>
        <label id="elh_dosen_Program_Studi" for="x_Program_Studi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Program_Studi->caption() ?><?= $Page->Program_Studi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Program_Studi->cellAttributes() ?>>
<span id="el_dosen_Program_Studi">
<input type="<?= $Page->Program_Studi->getInputTextType() ?>" name="x_Program_Studi" id="x_Program_Studi" data-table="dosen" data-field="x_Program_Studi" value="<?= $Page->Program_Studi->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Program_Studi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Program_Studi->formatPattern()) ?>"<?= $Page->Program_Studi->editAttributes() ?> aria-describedby="x_Program_Studi_help">
<?= $Page->Program_Studi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Program_Studi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Program_Studi"<?= $Page->Program_Studi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Program_Studi"><?= $Page->Program_Studi->caption() ?><?= $Page->Program_Studi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Program_Studi->cellAttributes() ?>>
<span id="el_dosen_Program_Studi">
<input type="<?= $Page->Program_Studi->getInputTextType() ?>" name="x_Program_Studi" id="x_Program_Studi" data-table="dosen" data-field="x_Program_Studi" value="<?= $Page->Program_Studi->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Program_Studi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Program_Studi->formatPattern()) ?>"<?= $Page->Program_Studi->editAttributes() ?> aria-describedby="x_Program_Studi_help">
<?= $Page->Program_Studi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Program_Studi->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Jenjang_Pendidikan"<?= $Page->Jenjang_Pendidikan->rowAttributes() ?>>
        <label id="elh_dosen_Jenjang_Pendidikan" for="x_Jenjang_Pendidikan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jenjang_Pendidikan->caption() ?><?= $Page->Jenjang_Pendidikan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jenjang_Pendidikan->cellAttributes() ?>>
<span id="el_dosen_Jenjang_Pendidikan">
    <select
        id="x_Jenjang_Pendidikan"
        name="x_Jenjang_Pendidikan"
        class="form-select ew-select<?= $Page->Jenjang_Pendidikan->isInvalidClass() ?>"
        <?php if (!$Page->Jenjang_Pendidikan->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Jenjang_Pendidikan"
        <?php } ?>
        data-table="dosen"
        data-field="x_Jenjang_Pendidikan"
        data-value-separator="<?= $Page->Jenjang_Pendidikan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Jenjang_Pendidikan->getPlaceHolder()) ?>"
        <?= $Page->Jenjang_Pendidikan->editAttributes() ?>>
        <?= $Page->Jenjang_Pendidikan->selectOptionListHtml("x_Jenjang_Pendidikan") ?>
    </select>
    <?= $Page->Jenjang_Pendidikan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Jenjang_Pendidikan->getErrorMessage() ?></div>
<?= $Page->Jenjang_Pendidikan->Lookup->getParamTag($Page, "p_x_Jenjang_Pendidikan") ?>
<?php if (!$Page->Jenjang_Pendidikan->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Jenjang_Pendidikan", selectId: "fdosenedit_x_Jenjang_Pendidikan" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Jenjang_Pendidikan?.lookupOptions.length) {
        options.data = { id: "x_Jenjang_Pendidikan", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Jenjang_Pendidikan", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Jenjang_Pendidikan.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Jenjang_Pendidikan"<?= $Page->Jenjang_Pendidikan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Jenjang_Pendidikan"><?= $Page->Jenjang_Pendidikan->caption() ?><?= $Page->Jenjang_Pendidikan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Jenjang_Pendidikan->cellAttributes() ?>>
<span id="el_dosen_Jenjang_Pendidikan">
    <select
        id="x_Jenjang_Pendidikan"
        name="x_Jenjang_Pendidikan"
        class="form-select ew-select<?= $Page->Jenjang_Pendidikan->isInvalidClass() ?>"
        <?php if (!$Page->Jenjang_Pendidikan->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Jenjang_Pendidikan"
        <?php } ?>
        data-table="dosen"
        data-field="x_Jenjang_Pendidikan"
        data-value-separator="<?= $Page->Jenjang_Pendidikan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Jenjang_Pendidikan->getPlaceHolder()) ?>"
        <?= $Page->Jenjang_Pendidikan->editAttributes() ?>>
        <?= $Page->Jenjang_Pendidikan->selectOptionListHtml("x_Jenjang_Pendidikan") ?>
    </select>
    <?= $Page->Jenjang_Pendidikan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Jenjang_Pendidikan->getErrorMessage() ?></div>
<?= $Page->Jenjang_Pendidikan->Lookup->getParamTag($Page, "p_x_Jenjang_Pendidikan") ?>
<?php if (!$Page->Jenjang_Pendidikan->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Jenjang_Pendidikan", selectId: "fdosenedit_x_Jenjang_Pendidikan" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Jenjang_Pendidikan?.lookupOptions.length) {
        options.data = { id: "x_Jenjang_Pendidikan", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Jenjang_Pendidikan", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Jenjang_Pendidikan.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Jabatan_Fungsional"<?= $Page->Jabatan_Fungsional->rowAttributes() ?>>
        <label id="elh_dosen_Jabatan_Fungsional" for="x_Jabatan_Fungsional" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jabatan_Fungsional->caption() ?><?= $Page->Jabatan_Fungsional->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jabatan_Fungsional->cellAttributes() ?>>
<span id="el_dosen_Jabatan_Fungsional">
    <select
        id="x_Jabatan_Fungsional"
        name="x_Jabatan_Fungsional"
        class="form-select ew-select<?= $Page->Jabatan_Fungsional->isInvalidClass() ?>"
        <?php if (!$Page->Jabatan_Fungsional->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Jabatan_Fungsional"
        <?php } ?>
        data-table="dosen"
        data-field="x_Jabatan_Fungsional"
        data-value-separator="<?= $Page->Jabatan_Fungsional->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Jabatan_Fungsional->getPlaceHolder()) ?>"
        <?= $Page->Jabatan_Fungsional->editAttributes() ?>>
        <?= $Page->Jabatan_Fungsional->selectOptionListHtml("x_Jabatan_Fungsional") ?>
    </select>
    <?= $Page->Jabatan_Fungsional->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Jabatan_Fungsional->getErrorMessage() ?></div>
<?= $Page->Jabatan_Fungsional->Lookup->getParamTag($Page, "p_x_Jabatan_Fungsional") ?>
<?php if (!$Page->Jabatan_Fungsional->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Jabatan_Fungsional", selectId: "fdosenedit_x_Jabatan_Fungsional" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Jabatan_Fungsional?.lookupOptions.length) {
        options.data = { id: "x_Jabatan_Fungsional", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Jabatan_Fungsional", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Jabatan_Fungsional.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Jabatan_Fungsional"<?= $Page->Jabatan_Fungsional->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Jabatan_Fungsional"><?= $Page->Jabatan_Fungsional->caption() ?><?= $Page->Jabatan_Fungsional->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Jabatan_Fungsional->cellAttributes() ?>>
<span id="el_dosen_Jabatan_Fungsional">
    <select
        id="x_Jabatan_Fungsional"
        name="x_Jabatan_Fungsional"
        class="form-select ew-select<?= $Page->Jabatan_Fungsional->isInvalidClass() ?>"
        <?php if (!$Page->Jabatan_Fungsional->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Jabatan_Fungsional"
        <?php } ?>
        data-table="dosen"
        data-field="x_Jabatan_Fungsional"
        data-value-separator="<?= $Page->Jabatan_Fungsional->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Jabatan_Fungsional->getPlaceHolder()) ?>"
        <?= $Page->Jabatan_Fungsional->editAttributes() ?>>
        <?= $Page->Jabatan_Fungsional->selectOptionListHtml("x_Jabatan_Fungsional") ?>
    </select>
    <?= $Page->Jabatan_Fungsional->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Jabatan_Fungsional->getErrorMessage() ?></div>
<?= $Page->Jabatan_Fungsional->Lookup->getParamTag($Page, "p_x_Jabatan_Fungsional") ?>
<?php if (!$Page->Jabatan_Fungsional->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Jabatan_Fungsional", selectId: "fdosenedit_x_Jabatan_Fungsional" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Jabatan_Fungsional?.lookupOptions.length) {
        options.data = { id: "x_Jabatan_Fungsional", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Jabatan_Fungsional", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Jabatan_Fungsional.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Kepakaran"<?= $Page->Kepakaran->rowAttributes() ?>>
        <label id="elh_dosen_Kepakaran" for="x_Kepakaran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kepakaran->caption() ?><?= $Page->Kepakaran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kepakaran->cellAttributes() ?>>
<span id="el_dosen_Kepakaran">
    <select
        id="x_Kepakaran"
        name="x_Kepakaran"
        class="form-select ew-select<?= $Page->Kepakaran->isInvalidClass() ?>"
        <?php if (!$Page->Kepakaran->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Kepakaran"
        <?php } ?>
        data-table="dosen"
        data-field="x_Kepakaran"
        data-value-separator="<?= $Page->Kepakaran->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kepakaran->getPlaceHolder()) ?>"
        <?= $Page->Kepakaran->editAttributes() ?>>
        <?= $Page->Kepakaran->selectOptionListHtml("x_Kepakaran") ?>
    </select>
    <?= $Page->Kepakaran->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Kepakaran->getErrorMessage() ?></div>
<?= $Page->Kepakaran->Lookup->getParamTag($Page, "p_x_Kepakaran") ?>
<?php if (!$Page->Kepakaran->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Kepakaran", selectId: "fdosenedit_x_Kepakaran" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Kepakaran?.lookupOptions.length) {
        options.data = { id: "x_Kepakaran", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Kepakaran", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Kepakaran.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Kepakaran"<?= $Page->Kepakaran->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Kepakaran"><?= $Page->Kepakaran->caption() ?><?= $Page->Kepakaran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Kepakaran->cellAttributes() ?>>
<span id="el_dosen_Kepakaran">
    <select
        id="x_Kepakaran"
        name="x_Kepakaran"
        class="form-select ew-select<?= $Page->Kepakaran->isInvalidClass() ?>"
        <?php if (!$Page->Kepakaran->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Kepakaran"
        <?php } ?>
        data-table="dosen"
        data-field="x_Kepakaran"
        data-value-separator="<?= $Page->Kepakaran->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kepakaran->getPlaceHolder()) ?>"
        <?= $Page->Kepakaran->editAttributes() ?>>
        <?= $Page->Kepakaran->selectOptionListHtml("x_Kepakaran") ?>
    </select>
    <?= $Page->Kepakaran->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Kepakaran->getErrorMessage() ?></div>
<?= $Page->Kepakaran->Lookup->getParamTag($Page, "p_x_Kepakaran") ?>
<?php if (!$Page->Kepakaran->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Kepakaran", selectId: "fdosenedit_x_Kepakaran" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Kepakaran?.lookupOptions.length) {
        options.data = { id: "x_Kepakaran", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Kepakaran", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Kepakaran.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Rumpun_Ilmu"<?= $Page->Rumpun_Ilmu->rowAttributes() ?>>
        <label id="elh_dosen_Rumpun_Ilmu" for="x_Rumpun_Ilmu" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Rumpun_Ilmu->caption() ?><?= $Page->Rumpun_Ilmu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Rumpun_Ilmu->cellAttributes() ?>>
<span id="el_dosen_Rumpun_Ilmu">
    <select
        id="x_Rumpun_Ilmu"
        name="x_Rumpun_Ilmu"
        class="form-select ew-select<?= $Page->Rumpun_Ilmu->isInvalidClass() ?>"
        <?php if (!$Page->Rumpun_Ilmu->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Rumpun_Ilmu"
        <?php } ?>
        data-table="dosen"
        data-field="x_Rumpun_Ilmu"
        data-value-separator="<?= $Page->Rumpun_Ilmu->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Rumpun_Ilmu->getPlaceHolder()) ?>"
        <?= $Page->Rumpun_Ilmu->editAttributes() ?>>
        <?= $Page->Rumpun_Ilmu->selectOptionListHtml("x_Rumpun_Ilmu") ?>
    </select>
    <?= $Page->Rumpun_Ilmu->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Rumpun_Ilmu->getErrorMessage() ?></div>
<?= $Page->Rumpun_Ilmu->Lookup->getParamTag($Page, "p_x_Rumpun_Ilmu") ?>
<?php if (!$Page->Rumpun_Ilmu->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Rumpun_Ilmu", selectId: "fdosenedit_x_Rumpun_Ilmu" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Rumpun_Ilmu?.lookupOptions.length) {
        options.data = { id: "x_Rumpun_Ilmu", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Rumpun_Ilmu", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Rumpun_Ilmu.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Rumpun_Ilmu"<?= $Page->Rumpun_Ilmu->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Rumpun_Ilmu"><?= $Page->Rumpun_Ilmu->caption() ?><?= $Page->Rumpun_Ilmu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Rumpun_Ilmu->cellAttributes() ?>>
<span id="el_dosen_Rumpun_Ilmu">
    <select
        id="x_Rumpun_Ilmu"
        name="x_Rumpun_Ilmu"
        class="form-select ew-select<?= $Page->Rumpun_Ilmu->isInvalidClass() ?>"
        <?php if (!$Page->Rumpun_Ilmu->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Rumpun_Ilmu"
        <?php } ?>
        data-table="dosen"
        data-field="x_Rumpun_Ilmu"
        data-value-separator="<?= $Page->Rumpun_Ilmu->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Rumpun_Ilmu->getPlaceHolder()) ?>"
        <?= $Page->Rumpun_Ilmu->editAttributes() ?>>
        <?= $Page->Rumpun_Ilmu->selectOptionListHtml("x_Rumpun_Ilmu") ?>
    </select>
    <?= $Page->Rumpun_Ilmu->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Rumpun_Ilmu->getErrorMessage() ?></div>
<?= $Page->Rumpun_Ilmu->Lookup->getParamTag($Page, "p_x_Rumpun_Ilmu") ?>
<?php if (!$Page->Rumpun_Ilmu->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Rumpun_Ilmu", selectId: "fdosenedit_x_Rumpun_Ilmu" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Rumpun_Ilmu?.lookupOptions.length) {
        options.data = { id: "x_Rumpun_Ilmu", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Rumpun_Ilmu", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Rumpun_Ilmu.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Aktif->Visible) { // Aktif ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Aktif"<?= $Page->Aktif->rowAttributes() ?>>
        <label id="elh_dosen_Aktif" for="x_Aktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Aktif->caption() ?><?= $Page->Aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Aktif->cellAttributes() ?>>
<span id="el_dosen_Aktif">
    <select
        id="x_Aktif"
        name="x_Aktif"
        class="form-select ew-select<?= $Page->Aktif->isInvalidClass() ?>"
        <?php if (!$Page->Aktif->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Aktif"
        <?php } ?>
        data-table="dosen"
        data-field="x_Aktif"
        data-value-separator="<?= $Page->Aktif->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Aktif->getPlaceHolder()) ?>"
        <?= $Page->Aktif->editAttributes() ?>>
        <?= $Page->Aktif->selectOptionListHtml("x_Aktif") ?>
    </select>
    <?= $Page->Aktif->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Aktif->getErrorMessage() ?></div>
<?php if (!$Page->Aktif->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Aktif", selectId: "fdosenedit_x_Aktif" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Aktif?.lookupOptions.length) {
        options.data = { id: "x_Aktif", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Aktif", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Aktif.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Aktif"<?= $Page->Aktif->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Aktif"><?= $Page->Aktif->caption() ?><?= $Page->Aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Aktif->cellAttributes() ?>>
<span id="el_dosen_Aktif">
    <select
        id="x_Aktif"
        name="x_Aktif"
        class="form-select ew-select<?= $Page->Aktif->isInvalidClass() ?>"
        <?php if (!$Page->Aktif->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Aktif"
        <?php } ?>
        data-table="dosen"
        data-field="x_Aktif"
        data-value-separator="<?= $Page->Aktif->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Aktif->getPlaceHolder()) ?>"
        <?= $Page->Aktif->editAttributes() ?>>
        <?= $Page->Aktif->selectOptionListHtml("x_Aktif") ?>
    </select>
    <?= $Page->Aktif->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Aktif->getErrorMessage() ?></div>
<?php if (!$Page->Aktif->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Aktif", selectId: "fdosenedit_x_Aktif" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Aktif?.lookupOptions.length) {
        options.data = { id: "x_Aktif", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Aktif", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Aktif.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Validasi->Visible) { // Validasi ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Validasi"<?= $Page->Validasi->rowAttributes() ?>>
        <label id="elh_dosen_Validasi" for="x_Validasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Validasi->caption() ?><?= $Page->Validasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Validasi->cellAttributes() ?>>
<span id="el_dosen_Validasi">
    <select
        id="x_Validasi"
        name="x_Validasi"
        class="form-select ew-select<?= $Page->Validasi->isInvalidClass() ?>"
        <?php if (!$Page->Validasi->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Validasi"
        <?php } ?>
        data-table="dosen"
        data-field="x_Validasi"
        data-value-separator="<?= $Page->Validasi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Validasi->getPlaceHolder()) ?>"
        <?= $Page->Validasi->editAttributes() ?>>
        <?= $Page->Validasi->selectOptionListHtml("x_Validasi") ?>
    </select>
    <?= $Page->Validasi->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Validasi->getErrorMessage() ?></div>
<?php if (!$Page->Validasi->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Validasi", selectId: "fdosenedit_x_Validasi" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Validasi?.lookupOptions.length) {
        options.data = { id: "x_Validasi", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Validasi", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Validasi.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Validasi"<?= $Page->Validasi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Validasi"><?= $Page->Validasi->caption() ?><?= $Page->Validasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Validasi->cellAttributes() ?>>
<span id="el_dosen_Validasi">
    <select
        id="x_Validasi"
        name="x_Validasi"
        class="form-select ew-select<?= $Page->Validasi->isInvalidClass() ?>"
        <?php if (!$Page->Validasi->IsNativeSelect) { ?>
        data-select2-id="fdosenedit_x_Validasi"
        <?php } ?>
        data-table="dosen"
        data-field="x_Validasi"
        data-value-separator="<?= $Page->Validasi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Validasi->getPlaceHolder()) ?>"
        <?= $Page->Validasi->editAttributes() ?>>
        <?= $Page->Validasi->selectOptionListHtml("x_Validasi") ?>
    </select>
    <?= $Page->Validasi->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Validasi->getErrorMessage() ?></div>
<?php if (!$Page->Validasi->IsNativeSelect) { ?>
<script>
loadjs.ready("fdosenedit", function() {
    var options = { name: "x_Validasi", selectId: "fdosenedit_x_Validasi" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdosenedit.lists.Validasi?.lookupOptions.length) {
        options.data = { id: "x_Validasi", form: "fdosenedit" };
    } else {
        options.ajax = { id: "x_Validasi", form: "fdosenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dosen.fields.Validasi.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdosenedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdosenedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("dosen");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fdosenedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdosenedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>

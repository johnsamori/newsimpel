<?php

namespace PHPMaker2023\new2023;

// Page object
$UsersAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fusersadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fusersadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["_Username", [fields._Username.visible && fields._Username.required ? ew.Validators.required(fields._Username.caption) : null], fields._Username.isInvalid],
            ["_Password", [fields._Password.visible && fields._Password.required ? ew.Validators.required(fields._Password.caption) : null, ew.Validators.passwordStrength], fields._Password.isInvalid],
            ["First_Name", [fields.First_Name.visible && fields.First_Name.required ? ew.Validators.required(fields.First_Name.caption) : null], fields.First_Name.isInvalid],
            ["Last_Name", [fields.Last_Name.visible && fields.Last_Name.required ? ew.Validators.required(fields.Last_Name.caption) : null], fields.Last_Name.isInvalid],
            ["_Email", [fields._Email.visible && fields._Email.required ? ew.Validators.required(fields._Email.caption) : null, ew.Validators.email], fields._Email.isInvalid],
            ["User_Level", [fields.User_Level.visible && fields.User_Level.required ? ew.Validators.required(fields.User_Level.caption) : null], fields.User_Level.isInvalid],
            ["Report_To", [fields.Report_To.visible && fields.Report_To.required ? ew.Validators.required(fields.Report_To.caption) : null], fields.Report_To.isInvalid],
            ["Activated", [fields.Activated.visible && fields.Activated.required ? ew.Validators.required(fields.Activated.caption) : null], fields.Activated.isInvalid],
            ["Locked", [fields.Locked.visible && fields.Locked.required ? ew.Validators.required(fields.Locked.caption) : null], fields.Locked.isInvalid],
            ["Photo", [fields.Photo.visible && fields.Photo.required ? ew.Validators.fileRequired(fields.Photo.caption) : null], fields.Photo.isInvalid]
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
            "User_Level": <?= $Page->User_Level->toClientList($Page) ?>,
            "Activated": <?= $Page->Activated->toClientList($Page) ?>,
            "Locked": <?= $Page->Locked->toClientList($Page) ?>,
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
<form name="fusersadd" id="fusersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
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
<table id="tbl_usersadd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->_Username->Visible) { // Username ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r__Username"<?= $Page->_Username->rowAttributes() ?>>
        <label id="elh_users__Username" for="x__Username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Username->caption() ?><?= $Page->_Username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Username->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("add")) { // Non system admin ?>
<span id="el_users__Username">
    <select
        id="x__Username"
        name="x__Username"
        class="form-select ew-select<?= $Page->_Username->isInvalidClass() ?>"
        <?php if (!$Page->_Username->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x__Username"
        <?php } ?>
        data-table="users"
        data-field="x__Username"
        data-value-separator="<?= $Page->_Username->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_Username->getPlaceHolder()) ?>"
        <?= $Page->_Username->editAttributes() ?>>
        <?= $Page->_Username->selectOptionListHtml("x__Username") ?>
    </select>
    <?= $Page->_Username->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->_Username->getErrorMessage() ?></div>
<?php if (!$Page->_Username->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x__Username", selectId: "fusersadd_x__Username" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists._Username?.lookupOptions.length) {
        options.data = { id: "x__Username", form: "fusersadd" };
    } else {
        options.ajax = { id: "x__Username", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields._Username.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_users__Username">
<input type="<?= $Page->_Username->getInputTextType() ?>" name="x__Username" id="x__Username" data-table="users" data-field="x__Username" value="<?= $Page->_Username->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_Username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Username->formatPattern()) ?>"<?= $Page->_Username->editAttributes() ?> aria-describedby="x__Username_help">
<?= $Page->_Username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Username->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r__Username"<?= $Page->_Username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users__Username"><?= $Page->_Username->caption() ?><?= $Page->_Username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Username->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("add")) { // Non system admin ?>
<span id="el_users__Username">
    <select
        id="x__Username"
        name="x__Username"
        class="form-select ew-select<?= $Page->_Username->isInvalidClass() ?>"
        <?php if (!$Page->_Username->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x__Username"
        <?php } ?>
        data-table="users"
        data-field="x__Username"
        data-value-separator="<?= $Page->_Username->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_Username->getPlaceHolder()) ?>"
        <?= $Page->_Username->editAttributes() ?>>
        <?= $Page->_Username->selectOptionListHtml("x__Username") ?>
    </select>
    <?= $Page->_Username->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->_Username->getErrorMessage() ?></div>
<?php if (!$Page->_Username->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x__Username", selectId: "fusersadd_x__Username" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists._Username?.lookupOptions.length) {
        options.data = { id: "x__Username", form: "fusersadd" };
    } else {
        options.ajax = { id: "x__Username", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields._Username.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_users__Username">
<input type="<?= $Page->_Username->getInputTextType() ?>" name="x__Username" id="x__Username" data-table="users" data-field="x__Username" value="<?= $Page->_Username->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_Username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Username->formatPattern()) ?>"<?= $Page->_Username->editAttributes() ?> aria-describedby="x__Username_help">
<?= $Page->_Username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Username->getErrorMessage() ?></div>
</span>
<?php } ?>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->_Password->Visible) { // Password ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r__Password"<?= $Page->_Password->rowAttributes() ?>>
        <label id="elh_users__Password" for="x__Password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Password->caption() ?><?= $Page->_Password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Password->cellAttributes() ?>>
<span id="el_users__Password">
<div class="input-group" id="ig__Password">
    <input type="password" autocomplete="new-password" data-password-strength="pst__Password" data-table="users" data-field="x__Password" name="x__Password" id="x__Password" size="30" maxlength="64" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>"<?= $Page->_Password->editAttributes() ?> aria-describedby="x__Password_help">
    <button type="button" class="btn btn-default ew-toggle-password" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
    <button type="button" class="btn btn-default ew-password-generator rounded-end" title="<?= HtmlTitle($Language->phrase("GeneratePassword")) ?>" data-password-field="x__Password" data-password-confirm="c__Password" data-password-strength="pst__Password"><?= $Language->phrase("GeneratePassword") ?></button>
</div>
<div class="progress ew-password-strength-bar form-text mt-1 d-none" id="pst__Password">
    <div class="progress-bar" role="progressbar"></div>
</div>
<?= $Page->_Password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r__Password"<?= $Page->_Password->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users__Password"><?= $Page->_Password->caption() ?><?= $Page->_Password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Password->cellAttributes() ?>>
<span id="el_users__Password">
<div class="input-group" id="ig__Password">
    <input type="password" autocomplete="new-password" data-password-strength="pst__Password" data-table="users" data-field="x__Password" name="x__Password" id="x__Password" size="30" maxlength="64" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>"<?= $Page->_Password->editAttributes() ?> aria-describedby="x__Password_help">
    <button type="button" class="btn btn-default ew-toggle-password" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
    <button type="button" class="btn btn-default ew-password-generator rounded-end" title="<?= HtmlTitle($Language->phrase("GeneratePassword")) ?>" data-password-field="x__Password" data-password-confirm="c__Password" data-password-strength="pst__Password"><?= $Language->phrase("GeneratePassword") ?></button>
</div>
<div class="progress ew-password-strength-bar form-text mt-1 d-none" id="pst__Password">
    <div class="progress-bar" role="progressbar"></div>
</div>
<?= $Page->_Password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->First_Name->Visible) { // First_Name ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_First_Name"<?= $Page->First_Name->rowAttributes() ?>>
        <label id="elh_users_First_Name" for="x_First_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->First_Name->caption() ?><?= $Page->First_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->First_Name->cellAttributes() ?>>
<span id="el_users_First_Name">
<input type="<?= $Page->First_Name->getInputTextType() ?>" name="x_First_Name" id="x_First_Name" data-table="users" data-field="x_First_Name" value="<?= $Page->First_Name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->First_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->First_Name->formatPattern()) ?>"<?= $Page->First_Name->editAttributes() ?> aria-describedby="x_First_Name_help">
<?= $Page->First_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->First_Name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_First_Name"<?= $Page->First_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_First_Name"><?= $Page->First_Name->caption() ?><?= $Page->First_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->First_Name->cellAttributes() ?>>
<span id="el_users_First_Name">
<input type="<?= $Page->First_Name->getInputTextType() ?>" name="x_First_Name" id="x_First_Name" data-table="users" data-field="x_First_Name" value="<?= $Page->First_Name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->First_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->First_Name->formatPattern()) ?>"<?= $Page->First_Name->editAttributes() ?> aria-describedby="x_First_Name_help">
<?= $Page->First_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->First_Name->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Last_Name->Visible) { // Last_Name ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Last_Name"<?= $Page->Last_Name->rowAttributes() ?>>
        <label id="elh_users_Last_Name" for="x_Last_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Last_Name->caption() ?><?= $Page->Last_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Last_Name->cellAttributes() ?>>
<span id="el_users_Last_Name">
<input type="<?= $Page->Last_Name->getInputTextType() ?>" name="x_Last_Name" id="x_Last_Name" data-table="users" data-field="x_Last_Name" value="<?= $Page->Last_Name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Last_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Last_Name->formatPattern()) ?>"<?= $Page->Last_Name->editAttributes() ?> aria-describedby="x_Last_Name_help">
<?= $Page->Last_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Last_Name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Last_Name"<?= $Page->Last_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Last_Name"><?= $Page->Last_Name->caption() ?><?= $Page->Last_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Last_Name->cellAttributes() ?>>
<span id="el_users_Last_Name">
<input type="<?= $Page->Last_Name->getInputTextType() ?>" name="x_Last_Name" id="x_Last_Name" data-table="users" data-field="x_Last_Name" value="<?= $Page->Last_Name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Last_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Last_Name->formatPattern()) ?>"<?= $Page->Last_Name->editAttributes() ?> aria-describedby="x_Last_Name_help">
<?= $Page->Last_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Last_Name->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <label id="elh_users__Email" for="x__Email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Email->caption() ?><?= $Page->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Email->cellAttributes() ?>>
<span id="el_users__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x__Email" id="x__Email" data-table="users" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="50" maxlength="100" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Email->formatPattern()) ?>"<?= $Page->_Email->editAttributes() ?> aria-describedby="x__Email_help">
<?= $Page->_Email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users__Email"><?= $Page->_Email->caption() ?><?= $Page->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Email->cellAttributes() ?>>
<span id="el_users__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x__Email" id="x__Email" data-table="users" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="50" maxlength="100" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Email->formatPattern()) ?>"<?= $Page->_Email->editAttributes() ?> aria-describedby="x__Email_help">
<?= $Page->_Email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->User_Level->Visible) { // User_Level ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_User_Level"<?= $Page->User_Level->rowAttributes() ?>>
        <label id="elh_users_User_Level" for="x_User_Level" class="<?= $Page->LeftColumnClass ?>"><?= $Page->User_Level->caption() ?><?= $Page->User_Level->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->User_Level->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_users_User_Level">
<span class="form-control-plaintext"><?= $Page->User_Level->getDisplayValue($Page->User_Level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_users_User_Level">
    <select
        id="x_User_Level"
        name="x_User_Level"
        class="form-select ew-select<?= $Page->User_Level->isInvalidClass() ?>"
        <?php if (!$Page->User_Level->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x_User_Level"
        <?php } ?>
        data-table="users"
        data-field="x_User_Level"
        data-value-separator="<?= $Page->User_Level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->User_Level->getPlaceHolder()) ?>"
        <?= $Page->User_Level->editAttributes() ?>>
        <?= $Page->User_Level->selectOptionListHtml("x_User_Level") ?>
    </select>
    <?= $Page->User_Level->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->User_Level->getErrorMessage() ?></div>
<?= $Page->User_Level->Lookup->getParamTag($Page, "p_x_User_Level") ?>
<?php if (!$Page->User_Level->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x_User_Level", selectId: "fusersadd_x_User_Level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists.User_Level?.lookupOptions.length) {
        options.data = { id: "x_User_Level", form: "fusersadd" };
    } else {
        options.ajax = { id: "x_User_Level", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.User_Level.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_User_Level"<?= $Page->User_Level->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_User_Level"><?= $Page->User_Level->caption() ?><?= $Page->User_Level->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->User_Level->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_users_User_Level">
<span class="form-control-plaintext"><?= $Page->User_Level->getDisplayValue($Page->User_Level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_users_User_Level">
    <select
        id="x_User_Level"
        name="x_User_Level"
        class="form-select ew-select<?= $Page->User_Level->isInvalidClass() ?>"
        <?php if (!$Page->User_Level->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x_User_Level"
        <?php } ?>
        data-table="users"
        data-field="x_User_Level"
        data-value-separator="<?= $Page->User_Level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->User_Level->getPlaceHolder()) ?>"
        <?= $Page->User_Level->editAttributes() ?>>
        <?= $Page->User_Level->selectOptionListHtml("x_User_Level") ?>
    </select>
    <?= $Page->User_Level->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->User_Level->getErrorMessage() ?></div>
<?= $Page->User_Level->Lookup->getParamTag($Page, "p_x_User_Level") ?>
<?php if (!$Page->User_Level->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x_User_Level", selectId: "fusersadd_x_User_Level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists.User_Level?.lookupOptions.length) {
        options.data = { id: "x_User_Level", form: "fusersadd" };
    } else {
        options.ajax = { id: "x_User_Level", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.User_Level.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Report_To->Visible) { // Report_To ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Report_To"<?= $Page->Report_To->rowAttributes() ?>>
        <label id="elh_users_Report_To" for="x_Report_To" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Report_To->caption() ?><?= $Page->Report_To->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Report_To->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_users_Report_To">
    <select
        id="x_Report_To"
        name="x_Report_To"
        class="form-select ew-select<?= $Page->Report_To->isInvalidClass() ?>"
        <?php if (!$Page->Report_To->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x_Report_To"
        <?php } ?>
        data-table="users"
        data-field="x_Report_To"
        data-value-separator="<?= $Page->Report_To->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Report_To->getPlaceHolder()) ?>"
        <?= $Page->Report_To->editAttributes() ?>>
        <?= $Page->Report_To->selectOptionListHtml("x_Report_To") ?>
    </select>
    <?= $Page->Report_To->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Report_To->getErrorMessage() ?></div>
<?php if (!$Page->Report_To->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x_Report_To", selectId: "fusersadd_x_Report_To" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists.Report_To?.lookupOptions.length) {
        options.data = { id: "x_Report_To", form: "fusersadd" };
    } else {
        options.ajax = { id: "x_Report_To", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.Report_To.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_users_Report_To">
<input type="<?= $Page->Report_To->getInputTextType() ?>" name="x_Report_To" id="x_Report_To" data-table="users" data-field="x_Report_To" value="<?= $Page->Report_To->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Report_To->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Report_To->formatPattern()) ?>"<?= $Page->Report_To->editAttributes() ?> aria-describedby="x_Report_To_help">
<?= $Page->Report_To->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Report_To->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Report_To"<?= $Page->Report_To->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Report_To"><?= $Page->Report_To->caption() ?><?= $Page->Report_To->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Report_To->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_users_Report_To">
    <select
        id="x_Report_To"
        name="x_Report_To"
        class="form-select ew-select<?= $Page->Report_To->isInvalidClass() ?>"
        <?php if (!$Page->Report_To->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x_Report_To"
        <?php } ?>
        data-table="users"
        data-field="x_Report_To"
        data-value-separator="<?= $Page->Report_To->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Report_To->getPlaceHolder()) ?>"
        <?= $Page->Report_To->editAttributes() ?>>
        <?= $Page->Report_To->selectOptionListHtml("x_Report_To") ?>
    </select>
    <?= $Page->Report_To->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Report_To->getErrorMessage() ?></div>
<?php if (!$Page->Report_To->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x_Report_To", selectId: "fusersadd_x_Report_To" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists.Report_To?.lookupOptions.length) {
        options.data = { id: "x_Report_To", form: "fusersadd" };
    } else {
        options.ajax = { id: "x_Report_To", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.Report_To.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_users_Report_To">
<input type="<?= $Page->Report_To->getInputTextType() ?>" name="x_Report_To" id="x_Report_To" data-table="users" data-field="x_Report_To" value="<?= $Page->Report_To->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Report_To->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Report_To->formatPattern()) ?>"<?= $Page->Report_To->editAttributes() ?> aria-describedby="x_Report_To_help">
<?= $Page->Report_To->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Report_To->getErrorMessage() ?></div>
</span>
<?php } ?>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Activated->Visible) { // Activated ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Activated"<?= $Page->Activated->rowAttributes() ?>>
        <label id="elh_users_Activated" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Activated->caption() ?><?= $Page->Activated->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Activated->cellAttributes() ?>>
<span id="el_users_Activated">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->Activated->isInvalidClass() ?>" data-table="users" data-field="x_Activated" data-boolean name="x_Activated" id="x_Activated" value="1"<?= ConvertToBool($Page->Activated->CurrentValue) ? " checked" : "" ?><?= $Page->Activated->editAttributes() ?> aria-describedby="x_Activated_help">
    <div class="invalid-feedback"><?= $Page->Activated->getErrorMessage() ?></div>
</div>
<?= $Page->Activated->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Activated"<?= $Page->Activated->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Activated"><?= $Page->Activated->caption() ?><?= $Page->Activated->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Activated->cellAttributes() ?>>
<span id="el_users_Activated">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->Activated->isInvalidClass() ?>" data-table="users" data-field="x_Activated" data-boolean name="x_Activated" id="x_Activated" value="1"<?= ConvertToBool($Page->Activated->CurrentValue) ? " checked" : "" ?><?= $Page->Activated->editAttributes() ?> aria-describedby="x_Activated_help">
    <div class="invalid-feedback"><?= $Page->Activated->getErrorMessage() ?></div>
</div>
<?= $Page->Activated->getCustomMessage() ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Locked->Visible) { // Locked ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Locked"<?= $Page->Locked->rowAttributes() ?>>
        <label id="elh_users_Locked" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Locked->caption() ?><?= $Page->Locked->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Locked->cellAttributes() ?>>
<span id="el_users_Locked">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->Locked->isInvalidClass() ?>" data-table="users" data-field="x_Locked" data-boolean name="x_Locked" id="x_Locked" value="1"<?= ConvertToBool($Page->Locked->CurrentValue) ? " checked" : "" ?><?= $Page->Locked->editAttributes() ?> aria-describedby="x_Locked_help">
    <div class="invalid-feedback"><?= $Page->Locked->getErrorMessage() ?></div>
</div>
<?= $Page->Locked->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Locked"<?= $Page->Locked->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Locked"><?= $Page->Locked->caption() ?><?= $Page->Locked->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Locked->cellAttributes() ?>>
<span id="el_users_Locked">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->Locked->isInvalidClass() ?>" data-table="users" data-field="x_Locked" data-boolean name="x_Locked" id="x_Locked" value="1"<?= ConvertToBool($Page->Locked->CurrentValue) ? " checked" : "" ?><?= $Page->Locked->editAttributes() ?> aria-describedby="x_Locked_help">
    <div class="invalid-feedback"><?= $Page->Locked->getErrorMessage() ?></div>
</div>
<?= $Page->Locked->getCustomMessage() ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Photo"<?= $Page->Photo->rowAttributes() ?>>
        <label id="elh_users_Photo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Photo->caption() ?><?= $Page->Photo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Photo->cellAttributes() ?>>
<span id="el_users_Photo">
<div id="fd_x_Photo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Photo"
        name="x_Photo"
        class="form-control ew-file-input"
        title="<?= $Page->Photo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="users"
        data-field="x_Photo"
        data-size="100"
        data-accept-file-types="<?= $Page->Photo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Photo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Photo->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Photo_help"
        <?= ($Page->Photo->ReadOnly || $Page->Photo->Disabled) ? " disabled" : "" ?>
        <?= $Page->Photo->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Photo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Photo" id= "fn_x_Photo" value="<?= $Page->Photo->Upload->FileName ?>">
<input type="hidden" name="fa_x_Photo" id= "fa_x_Photo" value="0">
<table id="ft_x_Photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Photo"<?= $Page->Photo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Photo"><?= $Page->Photo->caption() ?><?= $Page->Photo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Photo->cellAttributes() ?>>
<span id="el_users_Photo">
<div id="fd_x_Photo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Photo"
        name="x_Photo"
        class="form-control ew-file-input"
        title="<?= $Page->Photo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="users"
        data-field="x_Photo"
        data-size="100"
        data-accept-file-types="<?= $Page->Photo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Photo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Photo->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Photo_help"
        <?= ($Page->Photo->ReadOnly || $Page->Photo->Disabled) ? " disabled" : "" ?>
        <?= $Page->Photo->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Photo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Photo" id= "fn_x_Photo" value="<?= $Page->Photo->Upload->FileName ?>">
<input type="hidden" name="fa_x_Photo" id= "fa_x_Photo" value="0">
<table id="ft_x_Photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fusersadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fusersadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("users");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fusersadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
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

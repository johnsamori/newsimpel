<?php

namespace PHPMaker2023\new2023;

// Page object
$Userpriv = &$Page;
?>
<style>
main .tooltip {
    --bs-tooltip-max-width: 500px;
}
th.jtable-column-header.jtable-column-header-sortable {
  z-index:5 !important;
  position: fixed;
  width: 300px !important;
  cursor: pointer;
}
th:not(.jtable-column-header.jtable-column-header-sortable) {
  width: 80px !important;
  z-index: 4 !important;
}
td:first-child,
th:first-child {
  width: 300px !important;
  position:sticky;
  left: -5px;
  z-index: 4 !important;
  background-color:#dedede;
}
table {
  table-layout: fixed;
  width:100%;
}
thead tr th {
  background-color:#dedede !important;
  position:sticky;
  top:0;
}
tr.jtable-data-row {
  background-color: #d4d4d4;
}
tr.jtable-data-row.jtable-row-even {
  background-color: #f4f4f4;
}
.dark-mode th.jtable-column-header.jtable-column-header-sortable {
  z-index: 5 !important;
  position: fixed;
  width: 300px !important;
}
.dark-mode th:not(.jtable-column-header.jtable-column-header-sortable) {
  width: 80px !important;
  z-index: 4 !important;
}
.dark-mode td:first-child,
.dark-mode th:first-child {
  width: 300px !important;
  left: -10px;
  z-index: 4 !important;
  background-color:#343a40;
}
.dark-mode thead tr th {
  background-color:#343a40 !important;
  border-color: #6c757d;
  position: absolute;
}
.dark-mode tr.jtable-data-row {
  background-color: #495057;
}
.dark-mode tr.jtable-data-row.jtable-row-even {
  background-color: #6c757d;
}
</style>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { userlevels: currentTable } });
var currentPageID = ew.PAGE_ID = "userpriv";
var currentForm;
var fuserpriv;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fuserpriv")
        .setPageId("userpriv")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
var headerSortTristate = false,
    tableOptions = {
        locale: ew.LANGUAGE_ID,
        langs: {
            [ew.LANGUAGE_ID]: {
                "data": {
                    "loading": ew.language.phrase("Loading"),
                    "error": ew.language.phrase("Error")
                }
            }
        }
    },
    priv = <?= JsonEncode($Page->Privileges) ?>;
</script>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<?php
$Page->showMessage();
?>
<main>
<form name="fuserpriv" id="fuserpriv" class="ew-form ew-user-priv-form w-100" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="x_User_Level_ID" id="x_User_Level_ID" value="<?= $Page->User_Level_ID->CurrentValue ?>">
<div class="ew-desktop">
<div class="card ew-card ew-user-priv">
<div class="card-header">
    <h3 class="card-title"><?= $Language->phrase("UserLevel") ?><?= $Security->getUserLevelName((int)$Page->User_Level_ID->CurrentValue) ?> (<?= $Page->User_Level_ID->CurrentValue ?>)</h3>
    <div class="card-tools float-none float-sm-end">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" name="table-name" id="table-name" class="form-control form-control-sm" placeholder="<?= HtmlEncode($Language->phrase("Search", true)) ?>">
        </div>
    </div>
</div>
<div class="card-body ew-card-body p-0 <?= $Page->ResponsiveTableClass ?>"></div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-submit" id="btn-submit" type="submit"<?= $Page->Disabled ?>><?= $Language->phrase("Update") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</div>
</form>
</main>
<?php if (MS_ENABLE_PERMISSION_FOR_EXPORT_DATA == TRUE) { ?>
<script>
var useFixedHeaderTable = true,
    tableHeight = "400px",
    priv = <?= JsonEncode($Page->Privileges) ?>;
ew.ready("makerjs", [
    ew.PATH_BASE + "jquery/jquery.jtable.min.js",
    ew.PATH_BASE + "js/userprivmod.js?v=1666171579"
]);
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your startup script here, no need to add script tags.
});
</script>
<script>
ew.ready("head", ew.PATH_BASE + "js/ewfixedheadertable.js", "fixedheadertable");
</script>

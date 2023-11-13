<?php

namespace PHPMaker2023\new2023;

// Page object
$HelpPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { help: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid <?= $Page->TableGridClass ?>" style="width: 100%;"><!-- .card -->
<div class="card-header ew-grid-upper-panel ew-preview-upper-panel"><!-- .card-header -->
<?= $Page->Pager->render() ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
</div><!-- /.card-header -->
<div class="card-body ew-preview-middle-panel ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>"><!-- .table-responsive -->
<table class="<?= $Page->TableClass ?>"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->Help_ID->Visible) { // Help_ID ?>
    <?php if (!$Page->Help_ID->Sortable || !$Page->SortUrl($Page->Help_ID)) { ?>
        <th class="<?= $Page->Help_ID->headerCellClass() ?>"><?= $Page->Help_ID->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Help_ID->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Help_ID->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Help_ID->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Help_ID->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Help_ID->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_Language->Visible) { // Language ?>
    <?php if (!$Page->_Language->Sortable || !$Page->SortUrl($Page->_Language)) { ?>
        <th class="<?= $Page->_Language->headerCellClass() ?>"><?= $Page->_Language->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_Language->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->_Language->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->_Language->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_Language->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_Language->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Topic->Visible) { // Topic ?>
    <?php if (!$Page->Topic->Sortable || !$Page->SortUrl($Page->Topic)) { ?>
        <th class="<?= $Page->Topic->headerCellClass() ?>"><?= $Page->Topic->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Topic->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Topic->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Topic->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Topic->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Topic->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
    <?php if (!$Page->Category->Sortable || !$Page->SortUrl($Page->Category)) { ?>
        <th class="<?= $Page->Category->headerCellClass() ?>"><?= $Page->Category->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Category->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Category->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Category->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Category->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Category->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Order->Visible) { // Order ?>
    <?php if (!$Page->Order->Sortable || !$Page->SortUrl($Page->Order)) { ?>
        <th class="<?= $Page->Order->headerCellClass() ?>"><?= $Page->Order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Order->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Order->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Order->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Order->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Display_in_Page->Visible) { // Display_in_Page ?>
    <?php if (!$Page->Display_in_Page->Sortable || !$Page->SortUrl($Page->Display_in_Page)) { ?>
        <th class="<?= $Page->Display_in_Page->headerCellClass() ?>"><?= $Page->Display_in_Page->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Display_in_Page->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Display_in_Page->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Display_in_Page->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Display_in_Page->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Display_in_Page->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Updated_By->Visible) { // Updated_By ?>
    <?php if (!$Page->Updated_By->Sortable || !$Page->SortUrl($Page->Updated_By)) { ?>
        <th class="<?= $Page->Updated_By->headerCellClass() ?>"><?= $Page->Updated_By->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Updated_By->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Updated_By->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Updated_By->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Updated_By->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Updated_By->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Last_Updated->Visible) { // Last_Updated ?>
    <?php if (!$Page->Last_Updated->Sortable || !$Page->SortUrl($Page->Last_Updated)) { ?>
        <th class="<?= $Page->Last_Updated->headerCellClass() ?>"><?= $Page->Last_Updated->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Last_Updated->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Last_Updated->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Last_Updated->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Last_Updated->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Last_Updated->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecCount = 0;
$Page->RowCount = 0;
while ($Page->Recordset && !$Page->Recordset->EOF) {
    // Init row class and style
    $Page->RecCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->Recordset);

    // Render row
    $Page->RowType = ROWTYPE_PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->Help_ID->Visible) { // Help_ID ?>
        <!-- Help_ID -->
        <td<?= $Page->Help_ID->cellAttributes() ?>>
<span<?= $Page->Help_ID->viewAttributes() ?>>
<?= $Page->Help_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_Language->Visible) { // Language ?>
        <!-- Language -->
        <td<?= $Page->_Language->cellAttributes() ?>>
<span<?= $Page->_Language->viewAttributes() ?>>
<?= $Page->_Language->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Topic->Visible) { // Topic ?>
        <!-- Topic -->
        <td<?= $Page->Topic->cellAttributes() ?>>
<span<?= $Page->Topic->viewAttributes() ?>>
<?= $Page->Topic->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
        <!-- Category -->
        <td<?= $Page->Category->cellAttributes() ?>>
<span<?= $Page->Category->viewAttributes() ?>>
<?= $Page->Category->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Order->Visible) { // Order ?>
        <!-- Order -->
        <td<?= $Page->Order->cellAttributes() ?>>
<span<?= $Page->Order->viewAttributes() ?>>
<?= $Page->Order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Display_in_Page->Visible) { // Display_in_Page ?>
        <!-- Display_in_Page -->
        <td<?= $Page->Display_in_Page->cellAttributes() ?>>
<span<?= $Page->Display_in_Page->viewAttributes() ?>>
<?= $Page->Display_in_Page->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Updated_By->Visible) { // Updated_By ?>
        <!-- Updated_By -->
        <td<?= $Page->Updated_By->cellAttributes() ?>>
<span<?= $Page->Updated_By->viewAttributes() ?>>
<?= $Page->Updated_By->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Last_Updated->Visible) { // Last_Updated ?>
        <!-- Last_Updated -->
        <td<?= $Page->Last_Updated->cellAttributes() ?>>
<span<?= $Page->Last_Updated->viewAttributes() ?>>
<?= $Page->Last_Updated->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    $Page->Recordset->moveNext();
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { // No record ?>
<?php //////////////////// Begin of Empty Table in Preview Page //////////////////////// ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { ?>
<div class="card ew-grid <?= $Page->TableGridClass ?>" style="width: 100%;"><!-- .card -->
<div class="card-body ew-preview-middle-panel ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>"><!-- .table-responsive -->
<table class="<?= $Page->TableClass ?>"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->Help_ID->Visible) { // Help_ID ?>
    <?php if (!$Page->Help_ID->Sortable || !$Page->SortUrl($Page->Help_ID)) { ?>
        <th class="<?= $Page->Help_ID->headerCellClass() ?>"><?= $Page->Help_ID->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Help_ID->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Help_ID->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Help_ID->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Help_ID->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Help_ID->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_Language->Visible) { // Language ?>
    <?php if (!$Page->_Language->Sortable || !$Page->SortUrl($Page->_Language)) { ?>
        <th class="<?= $Page->_Language->headerCellClass() ?>"><?= $Page->_Language->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_Language->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->_Language->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->_Language->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_Language->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_Language->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Topic->Visible) { // Topic ?>
    <?php if (!$Page->Topic->Sortable || !$Page->SortUrl($Page->Topic)) { ?>
        <th class="<?= $Page->Topic->headerCellClass() ?>"><?= $Page->Topic->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Topic->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Topic->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Topic->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Topic->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Topic->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
    <?php if (!$Page->Category->Sortable || !$Page->SortUrl($Page->Category)) { ?>
        <th class="<?= $Page->Category->headerCellClass() ?>"><?= $Page->Category->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Category->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Category->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Category->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Category->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Category->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Order->Visible) { // Order ?>
    <?php if (!$Page->Order->Sortable || !$Page->SortUrl($Page->Order)) { ?>
        <th class="<?= $Page->Order->headerCellClass() ?>"><?= $Page->Order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Order->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Order->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Order->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Order->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Display_in_Page->Visible) { // Display_in_Page ?>
    <?php if (!$Page->Display_in_Page->Sortable || !$Page->SortUrl($Page->Display_in_Page)) { ?>
        <th class="<?= $Page->Display_in_Page->headerCellClass() ?>"><?= $Page->Display_in_Page->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Display_in_Page->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Display_in_Page->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Display_in_Page->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Display_in_Page->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Display_in_Page->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Updated_By->Visible) { // Updated_By ?>
    <?php if (!$Page->Updated_By->Sortable || !$Page->SortUrl($Page->Updated_By)) { ?>
        <th class="<?= $Page->Updated_By->headerCellClass() ?>"><?= $Page->Updated_By->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Updated_By->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Updated_By->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Updated_By->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Updated_By->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Updated_By->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Last_Updated->Visible) { // Last_Updated ?>
    <?php if (!$Page->Last_Updated->Sortable || !$Page->SortUrl($Page->Last_Updated)) { ?>
        <th class="<?= $Page->Last_Updated->headerCellClass() ?>"><?= $Page->Last_Updated->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Last_Updated->headerCellClass() ?>"><div role="button" data-table="help" data-sort="<?= HtmlEncode($Page->Last_Updated->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Last_Updated->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Last_Updated->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Last_Updated->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
    <tr class="border-bottom-0" style="height:36px;">
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->Help_ID->Visible) { // Help_ID ?>
        <!-- Help_ID -->
        <td<?= $Page->Help_ID->cellAttributes() ?>>
<span<?= $Page->Help_ID->viewAttributes() ?>>
<?= $Page->Help_ID->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_Language->Visible) { // Language ?>
        <!-- Language -->
        <td<?= $Page->_Language->cellAttributes() ?>>
<span<?= $Page->_Language->viewAttributes() ?>>
<?= $Page->_Language->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Topic->Visible) { // Topic ?>
        <!-- Topic -->
        <td<?= $Page->Topic->cellAttributes() ?>>
<span<?= $Page->Topic->viewAttributes() ?>>
<?= $Page->Topic->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
        <!-- Category -->
        <td<?= $Page->Category->cellAttributes() ?>>
<span<?= $Page->Category->viewAttributes() ?>>
<?= $Page->Category->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Order->Visible) { // Order ?>
        <!-- Order -->
        <td<?= $Page->Order->cellAttributes() ?>>
<span<?= $Page->Order->viewAttributes() ?>>
<?= $Page->Order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Display_in_Page->Visible) { // Display_in_Page ?>
        <!-- Display_in_Page -->
        <td<?= $Page->Display_in_Page->cellAttributes() ?>>
<span<?= $Page->Display_in_Page->viewAttributes() ?>>
<?= $Page->Display_in_Page->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Updated_By->Visible) { // Updated_By ?>
        <!-- Updated_By -->
        <td<?= $Page->Updated_By->cellAttributes() ?>>
<span<?= $Page->Updated_By->viewAttributes() ?>>
<?= $Page->Updated_By->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Last_Updated->Visible) { // Last_Updated ?>
        <!-- Last_Updated -->
        <td<?= $Page->Last_Updated->cellAttributes() ?>>
<span<?= $Page->Last_Updated->viewAttributes() ?>>
<?= $Page->Last_Updated->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
    </tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { ?>
  <div class="card border-0">
  <div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php } ////////////////// End of Empty Table in Preview Page //////////////////////// ?>
<?php } ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
<?php if ($Page->TotalRecords > 0) { ?>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>

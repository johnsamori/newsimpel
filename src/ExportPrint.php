<?php

namespace PHPMaker2023\new2023;

// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
/**
 * Export Print (Printer Friendly)
 */
class ExportPrint extends AbstractExport
{
    // Table header
    public function exportTableHeader()
    {
		$this->Text .= "<table class=\"table-bi\">";
    }

	public function exportText($txt) {
        $this->Text .= "<th>" . $txt . "</th>";
    }

	function exportRawCaption($val) {
		$this->Text .= "<th>" . $val . "</th>";
	}

    // Export a value (caption, field value, or aggregate)
    protected function exportValueEx($fld, $val)
    {
        // Begin of modification Bold Text for Detail Header Column, by Masino Sinaga, May 5, 2016
		// by adding this new condition: "|| (strval($val) == $fld->ExportCaption())"
        if ($this->RowCnt == 1 || (strval($val) == $fld->ExportCaption())) { 
		// End of modification Bold Text for Detail Header Column, by Masino Sinaga, May 5, 2016
          $this->Text .= "<th>";
          $this->Text .= strval($val);
          $this->Text .= "</th>";      
        } else {
          $this->Text .= "<td>";
          $this->Text .= strval($val);
          $this->Text .= "</td>";
        }
    }

    // Begin a row
    public function beginExportRow($rowCnt = 0)
    {
        $this->RowCnt++;
        $this->FldCnt = 0;       
		$this->Text .= "<tr>";
    }

    // End a row
    public function endExportRow($rowCnt = 0)
    {
        $this->Text .= "</tr>";
		$this->Header = $this->Line;
    }

    // Empty row
    public function exportEmptyRow()
    {
    }

    // Export a field
    public function exportField($fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        if ($this->Horizontal) {
            $this->ExportValue($fld);                      
        } else { // Vertical, export as a row
            $this->RowCnt++;
            $this->Text .= "<tr class=\"" . (($this->FldCnt % 2 == 1) ? "ewExportTableRow" : "ewExportTableAltRow") . "\">" .
                "<th>" . $fld->ExportCaption() . "</th>";
            $this->Text .= "<td" . ((Config("EXPORT_CSS_STYLES")) ? $fld->CellStyles() : "") . ">" . $fld->ExportValue() . "</td></tr>";
        }
    }

    // Add HTML tags
    public function exportHeaderAndFooter()
    {
		global $Language;
        $header = "<!DOCTYPE html><head><title>".$Language->ProjectPhrase("BodyTitle")."</title>\r\n";
        $header .= $this->CharsetMetaTag();
        $header .= "<style type=\"text/css\">.table-bi { background: #fff; border-collapse: collapse; margin-bottom:7px; font-family:'Courier New';font-size:9pt; } .table-bi td { border: 1px solid #bbb; background: #fff; padding: 5px; } .table-bi th { border: 1px solid #aaa; text-align: left; background: #F7F7F7; font-weight: bold; padding: 6px; }</style>\r\n";
        $header .= "</" . "head>\r\n<body>\r\n";
        $this->Text = $header . $this->Text . "</body></html>";
    }

    // Export
    public function export($fileName = "", $output = true, $save = false)
    {
		$this->write();
    }
}

// End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012

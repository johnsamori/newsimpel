<?php

namespace PHPMaker2023\new2023;

/**
 * Langauge class
 */
class Language
{
	public $Data = null;
    public $LanguageId;
    public $LanguageFolder;
    public $Template = ""; // JsRender template
    public $Method = "prependTo"; // JsRender template method
    public $Target = ".navbar-nav.ms-auto"; // JsRender template target
    // public $Type = "LI"; // LI/DROPDOWN (for used with top Navbar) or SELECT/RADIO (NOT for used with top Navbar)
	public $Type = "DROPDOWN"; // available: LI, DROPDOWN, SELECT, or RADIO
	public $LanguageCount = 0; // language count, by Masino Sinaga, April 26, 2022

    // Constructor
    public function __construct()
    {
        global $CurrentLanguage;
        $this->LanguageFolder = Config("LANGUAGE_FOLDER");
        $this->loadFileList(); // Set up file list
        if (Param("language", "") != "" && !EmptyValue($this->getFileName(Param("language")))) {
            $this->LanguageId = Param("language");
            $_SESSION[SESSION_LANGUAGE_ID] = $this->LanguageId;
        } elseif (Session(SESSION_LANGUAGE_ID) != "") {
            $this->LanguageId = Session(SESSION_LANGUAGE_ID);
        } else {
            $this->LanguageId = Config("LANGUAGE_DEFAULT_ID");
        }
        $CurrentLanguage = $this->LanguageId;
        $this->loadLanguage($this->LanguageId);

        // Call Language Load event
        $this->languageLoad();
        SetClientVar("languages", ["languages" => $this->getLanguages()]);
    }

    // Load language file list
    protected function loadFileList()
    {
        global $LANGUAGES;
        if (is_array($LANGUAGES)) {
            foreach ($LANGUAGES as &$lang) {
                $lang[1] = $this->loadFileDesc($this->LanguageFolder . $lang[2]);
            }
        }
    }

    // Parse XML
    protected function parseXml($xml, &$values)
    {
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); // Always return in utf-8
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $xml, $values);
        xml_parser_free($parser);
    }

    // Load language file description
    protected function loadFileDesc($file)
    {
        $xml = substr(file_get_contents($file), 0, 512); // Just parse the first part
        $this->parseXml(trim($xml), $values);
        return $values[0]["attributes"]["desc"] ?? "";
    }

    // Load XML
    protected function loadXml($xml)
    {
        $data = new \Dflydev\DotAccessData\Data();
        $xml = trim($xml);
        if (!$xml) {
            return $data;
        }
        $this->parseXml(trim($xml), $xmlValues);
        if (!is_array($xmlValues)) {
            return $data;
        }
        $tags = [];
        foreach ($xmlValues as $xmlValue) {
            $attributes = null; // Reset attributesfirst
            extract($xmlValue); // Extract as $tag (string), $type (string), $level (int) and $attributes (array)
            if ($level == 1) {
                continue; // Skip root tag
            }
            if ($type == "open" || $type == "complete") { // Open tag like '<tag ...>' or complete tag like '<tag/>'
                if ($attributes["id"] ?? false) { // Has "id" attribute
                    if ($type == "open") {
                        $tag .= "." . $attributes["id"];
                    } elseif ($type == "complete") { // <phrase/>
                        $tag = $attributes["id"];
                    }
                    unset($attributes["id"]);
                }
                $tags[$level] = $tag;
                if (is_array($attributes) && count($attributes) > 0 && $level > 1) {
                    $data->set(implode(".", array_filter(array_slice($tags, 0, $level - 1))), ConvertFromUtf8($attributes));
                }
            }
        }
        return $data;
    }

    // Load language file
    protected function loadLanguage($id)
    {
        global $CURRENCY_CODE, $CURRENCY_SYMBOL, $DECIMAL_SEPARATOR, $GROUPING_SEPARATOR,
            $NUMBER_FORMAT, $CURRENCY_FORMAT, $PERCENT_SYMBOL, $PERCENT_FORMAT, $NUMBERING_SYSTEM,
            $DATE_FORMAT, $TIME_FORMAT, $DATE_SEPARATOR, $TIME_SEPARATOR, $TIME_ZONE;
        $fileName = $this->getFileName($id) ?: $this->getFileName(Config("LANGUAGE_DEFAULT_ID"));
        if ($fileName == "") {
            return;
        }
        $phrases = Session(PROJECT_NAME . "_" . $fileName);
        if (is_array($phrases)) {
            $this->Data = new \Dflydev\DotAccessData\Data($phrases);
        } else {
            $this->Data = $this->loadXml(file_get_contents($fileName));
        }

        // Set up locale for the language
        $locale = LocaleConvert();
        $CURRENCY_CODE = $locale["currency_code"];
        $CURRENCY_SYMBOL = $locale["currency_symbol"];
        $DECIMAL_SEPARATOR = $locale["decimal_separator"];
        $GROUPING_SEPARATOR = $locale["grouping_separator"];
        $NUMBER_FORMAT = $locale["number"];
        $CURRENCY_FORMAT = $locale["currency"];
        $PERCENT_SYMBOL = $locale["percent_symbol"];
        $PERCENT_FORMAT = $locale["percent"];
        $NUMBERING_SYSTEM = $locale["numbering_system"];
        $DATE_FORMAT = $locale["date"];
        $TIME_FORMAT = $locale["time"];
        $DATE_SEPARATOR = $locale["date_separator"];
        $TIME_SEPARATOR = $locale["time_separator"];
        $TIME_ZONE = $locale["time_zone"];

        // Set up time zone from locale file (see https://www.php.net/timezones for supported time zones)
        if (!empty($TIME_ZONE)) {
            date_default_timezone_set($TIME_ZONE);
        }
    }

    // Get language file name
    protected function getFileName($id)
    {
        global $LANGUAGES;
        if (is_array($LANGUAGES)) {
            foreach ($LANGUAGES as $lang) {
                if ($lang[0] == $id) {
                    return $this->LanguageFolder . $lang[2];
                }
            }
        }
        return "";
    }

    // Compact value (return value only)
    protected function compact($value)
    {
		unset($value["class"]);
        return $value["value"] ?? (is_array($value) ? array_map(fn($v) => $this->compact($v), $value) : $value);
    }

	// Has data
    public function hasData($id)
    {
        return $this->Data->has(strtolower($id ?? ""));
    }

    // Set data
    public function setData($id, $value)
    {
        $this->Data->set(strtolower($id ?? ""), $value);
    }

    // Get data
    public function getData($id)
    {
        return $this->Data->get(strtolower($id ?? ""), "");
    }

    /**
     * Get phrase
     *
     * @param string $id Phrase ID
     * @param mixed $useText (true => text only, false => icon only, null => both)
     * @return string
     */
    public function phrase($id, $useText = false)
    {
        $className = $this->getData("global." . $id . ".class");
        if ($this->hasData("global." . $id)) {
            $value = $this->getData("global." . $id);
            $text = $this->compact($value);
			if (is_array($text) && count($text) == 0) {
                $text = "";
            }
        } else {
            $text = $id;
        }
        $res = $text;
        if (is_string($res) && $useText !== true && $className != "") {
            if ($useText === null && $text !== "") { // Use both icon and text
                AppendClass($className, "me-2");
            }
            if (preg_match('/\bspinner\b/', $className)) { // Spinner
                $res = '<div class="' . $className . '" role="status"><span class="visually-hidden">' . $text . '</span></div>';
            } else { // Icon
                $res = '<i data-phrase="' . $id . '" class="' . $className . '"><span class="visually-hidden">' . $text . '</span></i>';
            }
            if ($useText === null && $text !== "") { // Use both icon and text
                $res .= $text;
            }
        }
        return $res;
    }

    // Set phrase
    public function setPhrase($id, $value)
    {
        $this->setPhraseAttr($id, "value", $value);
    }

    // Get project phrase
    public function projectPhrase($id)
    {
        return $this->getData("project." . $id . ".value");
    }

    // Set project phrase
    public function setProjectPhrase($id, $value)
    {
        $this->setData("project." . $id . ".value", $value);
    }

    // Get menu phrase
    public function menuPhrase($menuId, $id)
    {
        return $this->getData("project.menu." . $menuId . "." . $id . ".value");
    }

    // Set menu phrase
    public function setMenuPhrase($menuId, $id, $value)
    {
        $this->setData("project.menu." . $menuId . "." . $id . ".value", $value);
    }

    // Get table phrase
    public function tablePhrase($tblVar, $id)
    {
        return $this->getData("project.table." . $tblVar .  "." . $id . ".value");
    }

    // Set table phrase
    public function setTablePhrase($tblVar, $id, $value)
    {
        $this->setData("project.table." . $tblVar .  "." . $id . ".value", $value);
    }

	// Begin of modification Displaying Breadcrumbs in All Pages, by Masino Sinaga, May 25, 2012   
    // Get breadcrumb phrase
    function breadcrumbPhrase($id) {
        return $this->Data->get("global.breadcrumb." . $id . ".value", "");
    }
    // Set breadcrumb phrase
    function setBreadcrumbPhrase($id, $Value) {
        $this->setData("global.breadcrumb." . $id . ".value", $value);
    }  
// End of modification Displaying Breadcrumbs in All Pages, by Masino Sinaga, May 25, 2012

    // Get chart phrase
    public function chartPhrase($tblVar, $chtVar, $id)
    {
        return $this->getData("project.table." . $tblVar .  ".chart." . $chtVar . "." . $id . ".value");
    }

    // Set chart phrase
    public function setChartPhrase($tblVar, $chtVar, $id, $value)
    {
        $this->setData("project.table." . $tblVar .  ".chart." . $chtVar . "." . $id . ".value", $value);
    }

    // Get field phrase
    public function fieldPhrase($tblVar, $fldVar, $id)
    {
        return $this->getData("project.table." . $tblVar .  ".field." . $fldVar . "." . $id . ".value");
    }

    // Set field phrase
    public function setFieldPhrase($tblVar, $fldVar, $id, $value)
    {
        $this->setData("project.table." . $tblVar .  ".field." . $fldVar . "." . $id . ".value", $value);
    }

    // Get phrase attribute
    protected function phraseAttr($id, $name)
    {
        return $this->getData("global." . $id . "." . $name);
    }

    // Set phrase attribute
    protected function setPhraseAttr($id, $name, $value)
    {
        $this->setData("global." . $id . "." . $name, $value);
    }

    // Get phrase class
    public function phraseClass($id)
    {
        return $this->PhraseAttr($id, "class");
    }

    // Set phrase attribute
    public function setPhraseClass($id, $value)
    {
        $this->setPhraseAttr($id, "class", $value);
    }

    // Output array as JSON
    public function arrayToJson()
    {
        $ar = $this->getData("global");
        $keys = array_keys($ar);
        $res = array_combine($keys, array_map(fn($id) => $this->phrase($id, true), $keys));
        return JsonEncode($res);
    }

    // Output phrases to client side as JSON
    public function toJson()
    {
        return "ew.language.phrases = " . $this->arrayToJson() . ";";
    }

    // Output languages as array
    protected function getLanguages()
    {
        global $LANGUAGES, $CurrentLanguage;
        $ar = [];
        if (is_array($LANGUAGES) && count($LANGUAGES) > 1) {
            $ar = array_map(function ($lang) use ($CurrentLanguage) {
                $langId = $lang[0];
                $phrase = $this->phrase($langId);
                if ($phrase == $langId && $lang[1]) {
                    $phrase = $lang[1];
                }
                return ["id" => $langId, "desc" => $phrase, "selected" => $langId == $CurrentLanguage];
            }, $LANGUAGES);
			$this->LanguageCount = count($LANGUAGES); // Added by Masino Sinaga, September 23, 2022
        }
        return $ar;
    }

    // Get template
    public function getTemplate()
    {
        global $basePath;
		$basePath = BasePath(true);
        if ($this->Template == "" && $this->LanguageCount > 1) { // only display the language selector if language count is greater than 1 (one), modified by Masino Sinaga, April 26, 2022
            if (SameText($this->Type, "LI")) { // LI (one line desc and flag)
                return '{{for languages}}<li class="nav-item"><a class="nav-link{{if selected}} active{{/if}} " data-ew-action="language" data-language="{{:id}}"><img src="'.$basePath.'assets/media/flags/{{:id}}.svg" width="24px" height="17px" alt="" /> <span class="ew-language-option">{{:desc}}</span></a></li>{{/for}}';
            } elseif (SameText($this->Type, "DROPDOWN")) { // DROPDOWN (dropdown menu)        
				return '<li class="nav-item ew-language-option dropdown" style="cursor: pointer;"><a class="nav-link" data-bs-toggle="dropdown">{{for languages}}{{if selected}}<img src="'.$basePath.'assets/media/flags/{{:id}}.svg" width="24px" height="17px"  alt="" />{{/if}}{{/for}}</a><div class="dropdown-menu dropdown-menu-end p0">{{for languages}}<a class="dropdown-item nav-link{{if selected}} active{{/if}}" data-ew-action="language" data-language="{{:id}}"><img class="" src="'.$basePath.'assets/media/flags/{{:id}}.svg" width="24px" height="17px" alt="" />{{>desc}}</a>{{/for}}</div></li>';
            } elseif (SameText($this->Type, "SELECT")) { // COMBOBOX (select option)
				if (Language()->phrase("dir") != "rtl") {
					return '<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround kt-hidden-desktop" style="position: absolute;will-change: transform;top: 0px;left: 0px;transform: translate3d(64px, 75px, 0px);right: auto;"><ul class="kt-nav kt-margin-t-10 kt-margin-b-10 user-profile">{{for languages}}<li class="kt-nav__item {{if selected}} kt-nav__item--active{{/if}}"><a href="javascript:void(0);" class="kt-nav__link" onclick="ew.setLanguage(this);" data-language="{{:id}}"><span class="kt-header__topbar-icon"><img class="" src="'.$basePath.'assets/media/flags/{{:id}}.svg" alt="" /></span>&nbsp;<span class="kt-nav__link-text"> {{:desc}}</span></a>{{/for}}</li></ul></div>
					<div class="ew-language-option kt-margin-t-20 kt-margin-b-10 user-profile kt-hidden-tablet-and-mobile" style="vertical-align:middle;"><select class="form-control" id="ew-language" name="ew-language" onchange="ew.setLanguage(this);" style="width:150px;">{{for languages}}<option value="{{:id}}"{{if selected}} selected{{/if}} data-image="'.$basePath.'plugins/language-selector-combobox/images/msdropdown/icons/blank.gif" data-imagecss="flag {{:id}}" data-title="{{:desc}}">&nbsp;{{:desc}}</option>{{/for}}</select></div>';
				} else {
					return '<div class="ew-language-option"><select class="form-control" id="ew-language" name="ew-language" onchange="ew.setLanguage(this);" style="width:150px;">{{for languages}}<option value="{{:id}}"{{if selected}} selected{{/if}} data-image="'.$basePath.'plugins/language-selector-combobox/images/msdropdown/icons/blank.gif" data-imagecss="flag {{:id}}" data-title="{{:desc}}">&nbsp;&nbsp;{{:desc}}</option>{{/for}}</select></div>';
				}
            } elseif (SameText($this->Type, "RADIO")) { // RADIO (radio button)
                return '<div class="ew-language-option"><div class="btn-group" data-bs-toggle="buttons">{{for languages}}<input type="radio" name="ew-language" id="ew-Language-{{:id}}" onclick="ew.setLanguage(this);" {{if selected}} checked{{/if}} value="{{:id}}"><span class="ew-tooltip" for="ew-language-{{:id}}" data-container="body" data-bs-placement="middle" title="{{>desc}}"> <img class="" src="'.$basePath.'assets/media/flags/{{:id}}.svg" width="24px" height="17px" alt="" /></span>{{/for}}</div></div>';
            }
        }
        return $this->Template;
    }

    // Language Load event
    public function languageLoad()
    {
        // Example:
        //$this->setPhrase("MyID", "MyValue"); // Refer to language file for the actual phrase id
        //$this->setPhraseClass("MyID", "fa-solid fa-xxx ew-icon"); // Refer to https://fontawesome.com/icons?d=gallery&m=free [^] for icon name
    }
}

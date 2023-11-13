/**
 * Create jQuery Number (for PHPMaker 2022)
 * @license (C) 2020 - 2022 Masino Sinaga.
 */
// Global options
ew.jQueryNumberOptions = {};
// Create jQuery Number
ew.createjQueryNumber = function(formid, id, options) {
	if (id.includes("$rowindex$"))
		return;
	var $ = jQuery,
		el = ew.getElement(id, formid),
		sv = ew.getElement("sv_" + id, formid), // AutoSuggest
		$input = $(sv || el),
		format = "";	
	options = Object.assign({}, ew.jQueryNumberOptions, options);
	var the_number = options.number;
	var the_decimals = options.decimals;
	var the_dec_point = options.dec_point;
	var the_thousands_sep = options.thousands_sep;
	var args = {"id": id, "form": formid, "number": true, "options": options};
	$(function() {
		$input.number(true, the_decimals, the_dec_point, the_thousands_sep);
	});
}
<?php
/**
 * spansearch.php in Jimmy Codeviewer, a WordPress plugin
 * @package Jimmy Codeviewer
 * @author Kenta Ishii
 */

/**
 *  Make shortcode [init_spansearch]
 *  e.g. make sure to put [init_spansearch] before [spansearch], [spansearch_all] and [divsearch]
 */
function jimmy_codeviewer_shortcode_spansearch_init() {
	/*
	 * Make sure to NOT use of async or defer on library javascript file
	 */
	$return_str = "<script type=\"text/javascript\" src=\"" . plugins_url( "js/spansearch.min.js", __FILE__ ) . "\"></script>\r\n";

	return $return_str;
}
add_shortcode( 'init_spansearch', 'jimmy_codeviewer_shortcode_spansearch_init' );


/**
 *  Make shortcode [spansearch]
 *  e.g. [spansearch id="" start="" end=""]Something Else[/spansearch]
 *  Search Targeted Strings and Treat These
 */
function jimmy_codeviewer_shortcode_spansearch( $atts, $content = null ) {
	$arr = shortcode_atts(
		array( 'id' => '',
			'start' => '',
			'end' => '',
			'color' => '',
			'background-color' => '',
			'font-family' => '',
			'font-size' => '',
			'font-style' => '',
			'font-weight' => '',
			'vertical-align' => '',
			'regex-enable' => '',
			'regex-modifier' => '',
		),
		$atts );

	$return_str = "<script type=\"text/javascript\" defer>\r\n";

	$return_str .= "\tJIMMY_CODEVIEWER.spanSearch(\"" . $arr['id'] .
						"\", \"" . $arr['start'] .
						"\", \"" . $arr['end'] .
						"\", \"" . htmlspecialchars( $content ) . // target string to change status
						"\", \"" . $arr['color'] .
						"\", \"" . $arr['background-color'] .
						"\", \"" . $arr['font-family'] .
						"\", \"" . $arr['font-size'] .
						"\", \"" . $arr['font-style'] .
						"\", \"" . $arr['font-weight'] .
						"\", \"" . $arr['vertical-align'] .
						"\", \"" . $arr['regex-enable'] .
						"\", \"" . $arr['regex-modifier'] .
						"\");\r\n";

	$return_str .= "</script>\r\n";

	return $return_str;
}
add_shortcode( 'spansearch', 'jimmy_codeviewer_shortcode_spansearch' );


/**
 *  Make shortcode [spansearch_all]
 *  e.g. [spansearch_all id=""]Something Else[/spansearch_all]
 *  Search Targeted Strings and Treat These in all lines
 */
function jimmy_codeviewer_shortcode_spansearch_all( $atts, $content = null ) {
	$arr = shortcode_atts(
		array( 'id' => '',
			'color' => '',
			'background-color' => '',
			'font-family' => '',
			'font-size' => '',
			'font-style' => '',
			'font-weight' => '',
			'vertical-align' => '',
			'regex-enable' => '',
			'regex-modifier' => '',
		),
		$atts );

	$return_str = "<script type=\"text/javascript\" defer>\r\n";

	$return_str .= "\tJIMMY_CODEVIEWER.spanSearch_All(\"" . $arr['id'] .
						"\", \"" . htmlspecialchars( $content ) . // target string to change status
						"\", \"" . $arr['color'] .
						"\", \"" . $arr['background-color'] .
						"\", \"" . $arr['font-family'] .
						"\", \"" . $arr['font-size'] .
						"\", \"" . $arr['font-style'] .
						"\", \"" . $arr['font-weight'] .
						"\", \"" . $arr['vertical-align'] .
						"\", \"" . $arr['regex-enable'] .
						"\", \"" . $arr['regex-modifier'] .
						"\");\r\n";

	$return_str .= "</script>\r\n";

	return $return_str;
}
add_shortcode( 'spansearch_all', 'jimmy_codeviewer_shortcode_spansearch_all' );


/**
 *  Make shortcode [divsearch]
 *  e.g. [divsearch id="" start="" end="" text-align="" line-height=""]
 *  Set text-align, line-height, background-color of line(s)
 */
function jimmy_codeviewer_shortcode_divsearch( $atts ) {
	$arr = shortcode_atts(
		array( 'id' => '',
			'start' => '',
			'end' => '',
			'text-align' => '',
			'line-height' => '',
			'color' => '',
			'background-color' => '',
			'font-family' => '',
			'font-size' => '',
			'font-style' => '',
			'font-weight' => '',
		),
		$atts );

	$return_str = "<script type=\"text/javascript\" defer>\r\n";

	$return_str .= "\tJIMMY_CODEVIEWER.divSearch(\"" . $arr['id'] .
						"\", \"" . $arr['start'] .
						"\", \"" . $arr['end'] .
						"\", \"" . $arr['text-align'] .
						"\", \"" . $arr['line-height'] .
						"\", \"" . $arr['color'] .
						"\", \"" . $arr['background-color'] .
						"\", \"" . $arr['font-family'] .
						"\", \"" . $arr['font-size'] .
						"\", \"" . $arr['font-style'] .
						"\", \"" . $arr['font-weight'] .
						"\");\r\n";

	$return_str .= "</script>\r\n";

	return $return_str;
}
add_shortcode( 'divsearch', 'jimmy_codeviewer_shortcode_divsearch' );

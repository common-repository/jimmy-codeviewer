<?php
/*
Plugin Name: Jimmy Codeviewer
Plugin URI: http://electronics.jimmykenmerchant.com/jimmy-codeviewer/
Description: Multipurpose Text Viewer
Author: Kenta Ishii
Author URI: http://electronics.jimmykenmerchant.com
Version: 1.0.6
Text Domain: jimmy-codeviewer
Domain Path: /languages
License: GPL2 or Later
*/

require "constants.php";

/**
 * Add Custom Post type, article
 */
function jimmy_codeviewer_create_post_type() {
	register_post_type(
		'jarticle',
		array(
		'labels' => array(
			'name' => __( 'jArticles' ),
			'singular_name' => __( 'jArticle' ),
		),
		'supports' => array(
			'title',
			'editor',
			'author',
			'revisions',
		),
		'public' => false,
		'has_archive' => false,
		'show_ui' => true,
		'capability_type' => array( 'jarticle', 'jarticles' ),
		'map_meta_cap' => true,
		'menu_position' => 20,
		)
	);
}
add_action( 'init', 'jimmy_codeviewer_create_post_type' );


/**
 * Role making of "jfellow" to only edit or delete article on activation
 */
function jimmy_codeviewer_roles_customize() {
	$capabilities = array(
			'edit_posts' => 'edit_jarticles',
			'edit_others_posts' => 'edit_others_jarticles',
			'edit_private_posts' => 'edit_private_jarticles',
			'edit_published_posts' => 'edit_published_jarticles',
			'delete_posts' => 'delete_jarticles',
			'delete_others_posts' => 'delete_others_jarticles',
			'delete_private_posts' => 'delete_private_jarticles',
			'delete_published_posts' => 'delete_published_jarticles',
			'publish_posts' => 'publish_jarticles',
			'read_private_posts' => 'read_private_jarticles',
			);

	$role = get_role( 'administrator' );
	foreach ( $capabilities as $cap ) {
		$role->add_cap( $cap );
	}

	$role = get_role( 'editor' );
	foreach ( $capabilities as $cap ) {
		$role->add_cap( $cap );
	}

	add_role( 'jfellow', 'jFellow',
		 array( 'read' => true,
			'edit_jarticles' => true,
			'delete_jarticles' => true,
		) );
}
register_activation_hook( __FILE__, 'jimmy_codeviewer_roles_customize' );


/**
 * Delete Capabilities and the original role on deactivation
 */
function jimmy_codeviewer_roles_retrieve() {
	$capabilities = array(
			'edit_posts' => 'edit_jarticles',
			'edit_others_posts' => 'edit_others_jarticles',
			'edit_private_posts' => 'edit_private_jarticles',
			'edit_published_posts' => 'edit_published_jarticles',
			'delete_posts' => 'delete_jarticles',
			'delete_others_posts' => 'delete_others_jarticles',
			'delete_private_posts' => 'delete_private_jarticles',
			'delete_published_posts' => 'delete_published_jarticles',
			'publish_posts' => 'publish_jarticles',
			'read_private_posts' => 'read_private_jarticles',
			);

	$role = get_role( 'administrator' );
	foreach ( $capabilities as $cap ) {
		$role->remove_cap( $cap );
	}

	$role = get_role( 'editor' );
	foreach ( $capabilities as $cap ) {
		$role->remove_cap( $cap );
	}

	remove_role( 'jfellow' );
}
register_deactivation_hook( __FILE__, 'jimmy_codeviewer_roles_retrieve' );


/**
 * Cancel auto html tagging (<p> and/or <br />) and so on
 * On default of this plugin, post is only capable with Code Viewer. 
 */
function jimmy_codeviewer_cancel_tagging() {
	if ( get_post_type() === "post" ) {
		// Add First Priority not to do after default functions in wp-includes/formatting.php
		add_filter( 'the_content', 'jimmy_codeviewer_changeto_ascii', 0 );
	}
	return true;
}
add_action( 'the_post', 'jimmy_codeviewer_cancel_tagging' );


/**
 * Erase indents of 'codeview' shortcodes for proportional HTML code to review
 */
function jimmy_codeviewer_erase_indents( $content ) {
	// add multi-lines pattern modifier "m" to use beginning of line outside of the delimiter.
	$content = preg_replace( "/^(?:\t+|\s+)(\[codeview_byid[^\]]*\]|\[codeview_byname[^\]]*\])/m", "$1", $content );
	return $content;
}

/**
 * Change several special characters to escape characters with ASCII code
 * Only in enclosed contents of 'spansearch' series
 */
function jimmy_codeviewer_changeto_ascii( $content ) {
	$offset_content = 0;
	$i = 0;

	while ( preg_match( '/(?:\[spansearch(?:_all)?[^\[\]]*\])(.*)(?:\[\/spansearch(?:_all)?\])/', $content, $matches, PREG_OFFSET_CAPTURE, $offset_content ) > 0 && $i < JIMMY_CODEVIEWER_LOOP_LIMITTER ) {
		// $matches[0][0] stores all matched text
		// $matches[0][1] the offset in the target text
		// $matches[1][0] stores words in parenthesis captured [not(?:)]
		// $matches[1][1] the offset in the target text
		$front_content = substr( $content, 0, $matches[0][1] );
		$back_content = substr( $content, $matches[0][1] + strlen( $matches[0][0] ) );
		$front_tag = substr( $content, $matches[0][1], $matches[1][1] - $matches[0][1] );
		$back_tag = substr( $content, $matches[1][1] + strlen( $matches[1][0] ), ( $matches[0][1] + strlen( $matches[0][0] ) ) - ( $matches[1][1] + strlen( $matches[1][0] ) ) );

		// Replace special characters to escape characters
		// Use apostrophes to second argument because of putting escape characters itself
		$matches[1][0] = preg_replace( '/\x5c</', '\x3c', $matches[1][0] );
		$matches[1][0] = preg_replace( '/\x5c>/', '\x3e', $matches[1][0] );
		$matches[1][0] = preg_replace( '/\x5c\[/', '\x5b', $matches[1][0] );
		$matches[1][0] = preg_replace( '/\x5c\]/', '\x5d', $matches[1][0] );
		$matches[1][0] = preg_replace( '/"/', '\x22', $matches[1][0] );
		$matches[1][0] = preg_replace( '/\'/', '\x27', $matches[1][0] );
		//To hide WordPress default conversion '--' to em dash
		$matches[1][0] = preg_replace( '/\-\-/', '\x2d\x2d', $matches[1][0] );
		$matches[1][0] = preg_replace( '/&/', '\x26', $matches[1][0] );

		$content = $front_content . $front_tag . $matches[1][0] . $back_tag;
		$offset_content = strlen( $content );
		$content .= $back_content;

		$i++;
	}

	// Only on 'codeview' shortcodes usage, remove auto tagging and erase these indents
	if ( preg_match( '/\[codeview_(?:byid|byname)[^\]]*\]/', $content ) > 0 ) {
		// Because of First Priority, you can remove and/or add events afterwards
		remove_filter( 'the_content', 'wpautop' );
		add_filter( 'the_content', 'jimmy_codeviewer_erase_indents' );
	}

	return $content;
}


/**
 * Add style in using 'codeview' series
 */
function jimmy_codeviewer_style() {
	wp_enqueue_style( 'jimmy-codeviewer-style',  plugins_url( 'style-codeviewer.css', __FILE__ ), array(), '1.0' );
	return true;
}
add_action( 'wp_enqueue_scripts', 'jimmy_codeviewer_style' );


/**
 *  Make shortcode [codeview_byid]
 *  e.g. [codeview_byid title="something"]articleid[/codeview_byid]
 *  Make Codeview from article by article id
 */
function jimmy_codeviewer_shortcode_codeview_byid( $atts, $content = null ) {
	// To safety, return Error
	if ( empty( $content ) ) return "Error (jimmy-codeviewer: 1000)";

	// Get Content
	$article = get_post( (int)$content );
	if ( isset( $article ) ) {
		if ( ! empty( $article->ID ) && $article->post_status === "publish" && $article->post_type === "jarticle" && empty( $article->post_password ) ) {
			$content_text = $article->post_content;
		} else {
			return "Error (jimmy-codeviewer: 1002)";
		}
	} else {
		return "Error (jimmy-codeviewer: 1001)";
	}

	// To safety, return Error
	if ( empty( $content_text ) ) return "Error (jimmy-codeviewer: 1003)";

	// Erase null character for security
	$content_text = preg_replace( '/\x00/', "", $content_text );

	return jimmy_codeviewer_shortcode_codeview( $atts, $content_text );
}
add_shortcode( 'codeview_byid', 'jimmy_codeviewer_shortcode_codeview_byid' );


/**
 *  Make shortcode [codeview_byname]
 *  e.g. [codeview_byname title="something"]articlename[/codeview_byname]
 *  Make Codeview from article by name (article slug)
 */
function jimmy_codeviewer_shortcode_codeview_byname( $atts, $content = null ) {
	// To safety, return Error
	if ( empty( $content ) ) return "Error (jimmy-codeviewer: 1100)";

	// Get Content
	$article = get_page_by_path( $content, OBJECT, 'jarticle' );
	if ( isset( $article ) ) {
		if ( ! empty( $article->ID ) && $article->post_status === "publish" && $article->post_type === "jarticle" && empty( $article->post_password ) ) {
			$content_text = $article->post_content;
		} else {
			return "Error (jimmy-codeviewer: 1102)";
		}
	} else {
		return "Error (jimmy-codeviewer: 1101)";
	}

	// To safety, return Error
	if ( empty( $content_text ) ) return "Error (jimmy-codeviewer: 1103)";

	// Erase null character for security
	$content_text = preg_replace( '/\x00/', "", $content_text );

	return jimmy_codeviewer_shortcode_codeview( $atts, $content_text );
}
add_shortcode( 'codeview_byname', 'jimmy_codeviewer_shortcode_codeview_byname' );


/**
 * Common function to make html on codeviewer
 */
function jimmy_codeviewer_shortcode_codeview( $atts, $content_text ) {
	// Include a theme. If no value in "theme" attribute, require the default theme
	$pre = (array)$atts; // It's already array by shortcode_parse_atts in shortcodes.php though
	if ( array_key_exists( "theme", $pre ) ) {
		$theme = "theme_" . $pre['theme'] . ".php";
		if ( (include $theme) == FALSE ) {
			require "theme_default.php";

		}
	} else {
		require "theme_default.php";
	}

	// If no value of each attribute from the shortcode, assign value from selected theme
	$arr = shortcode_atts(
		array( 'id' => '',
			'start' => 1,
			'count' => $LINE_COUNT,
			'width' => $BLOCK_WIDTH,
			'number-width' => $NUMBER_WIDTH,
			'text-align' => $TEXT_ALIGN,
			'line-height' => $LINE_HEIGHT,
			'color' => $FONT_COLOR,
			'number-color' => $NUMBER_COLOR,
			'background-color' => $BACK_COLOR,
			'odd-background-color' => $ODD_BACKCOLOR,
			'even-background-color' => $EVEN_BACKCOLOR,
			'font-family' => $FONT_FAMILY,
			'font-size' => $FONT_SIZE,
			'font-style' => $FONT_STYLE,
			'font-weight' => $FONT_WEIGHT,
			'opacity' => $OPACITY,
			'padding-top' => $PADDING_TOP,
			'padding-right' => $PADDING_RIGHT,
			'padding-bottom' => $PADDING_DOWN,
			'padding-left' => $PADDING_LEFT,
			'white-space' => $WHITE_SPACE,
			'title' => '',
			'line10-color' => $LINE10_COLOR,
			'line20-color' => $LINE20_COLOR,
			'line10-1' => 0,
			'line10-2' => 0,
			'line10-3' => 0,
			'line20-1' => 0,
			'line20-2' => 0,
			'line20-3' => 0,
			'edit-instruction' => $EDIT_INSTRUCTION,
		),
		$atts );

	// Set Numbers from attributes
	$incre = (int)$arr['start'];
	$countlimit = (int)$arr['count'] + (int)$arr['start'] - 1;

	// Make sequence numbers for span tags
	$sequence = 1;

	// Start to make the return HTML codes
	// Use double quotations for escape chars such as "\r\n"
	if ( $arr['id'] ) {
		$return_str = "<div class=\"" . $arr['id'] . "\"";
	} else {
		$return_str = "<div";
	}

	$return_str .= " style=\"display: block;margin: 0;padding: 0;width: " . $arr['width'] . ";font-size: " . $arr['font-size'] . ";color: " . $arr['color'] . ";background-color: " . $arr['background-color'] . ";font-family: " . $arr['font-family'] . ";font-style: " . $arr['font-style'] . ";font-weight: " . $arr['font-weight'] . ";line-height: " . $arr['line-height'] . ";opacity: " . $arr['opacity'] . ";\">\r\n";

	// Counter Set
	$i = 0;
	// For Compatibility POSIX and WINDOWS
	$content_text = preg_replace( '/\r/', "", $content_text );
	// explode seems that if empty, returns empty but the empty exists as an item in the array
	$bufferarr = explode( "\n", $content_text );

	// Main loop to make HTML codes
	while ( array_key_exists( $i, $bufferarr ) && $i < $countlimit && $i < JIMMY_CODEVIEWER_LOOP_LIMITTER ) {
		$buffer = $bufferarr[$i];
		if ( !$buffer ) $buffer = " ";
		$i++;
		if ( $i < (int)$arr['start'] ) continue;

		// First, change HTML special chars to HTML entities NOT to be actual codes
		$buffer = htmlentities( $buffer, ENT_QUOTES, 'UTF-8' );

		// "(edit([a-z]+\-[a-z]+[a-zA-Z0-9#\-]*))", Edit Instructions
		if ( $arr['edit-instruction'] === 'true' || $arr['edit-instruction'] === 'TRUE' ) {
			// Escape of "(edit([a-z\-]+))" itself by backslash at first
			$buffer = preg_replace( '/\x5C\(edit\(([a-z]+\-[a-z]+[a-zA-Z0-9#\-]*)\)\)/', "&#40;edit&#40;$1&#41;&#41;", $buffer );

			if ( preg_match_all( '/\(edit\(([a-z]+\-[a-z]+)[a-zA-Z0-9#\-]*\)\)/', $buffer, $matches, PREG_PATTERN_ORDER ) > 0) {
				// $matches[0] stores all matched text
				// $matches[1] and after stores words in parenthesis
				// $matches[1] stores 1st and 2nd word connected with a hyphen. 3rd word is omitted.
				foreach ( $matches[1] as $value ) {
					switch ( $value ) {
						case "hard-hyphen":
							$buffer = preg_replace( '/\(edit\(hard-hyphen\)\)/', "\x2D\r\n", $buffer, 1 );
							break;
						case "soft-hyphen":
							$buffer = preg_replace( '/\(edit\(soft-hyphen\)\)/', "&shy;", $buffer, 1 );
							break;
						case "new-line":
							$buffer = preg_replace( '/\(edit\(new-line\)\)/', "\r\n", $buffer, 1 );
							break;
						case "br-tag":
							$buffer = preg_replace( '/\(edit\(br-tag\)\)/', "</span><br /><span id=\"" . $arr ['id'] . $incre . "-sp" . ++$sequence . "\" style=\"white-space: " . $arr['white-space'] . ";\">", $buffer, 1 );
							break;
						case "ruby-tag":
							$buffer = preg_replace( '/\(edit\(ruby-tag\)\)/', "</span><ruby>" , $buffer, 1 );
							break;
						case "end-ruby":
							$buffer = preg_replace( '/\(edit\(end-ruby\)\)/', "</ruby><span id=\"" . $arr ['id'] . $incre . "-sp" . ++$sequence . "\" style=\"white-space: " . $arr['white-space'] . ";\">", $buffer, 1 );
							break;
						case "rb-tag":
							$buffer = preg_replace( '/\(edit\(rb-tag\)\)/', "<rb>" , $buffer, 1 );
							break;
						case "end-rb":
							$buffer = preg_replace( '/\(edit\(end-rb\)\)/', "</rb>" , $buffer, 1 );
							break;
						case "rt-tag":
							$buffer = preg_replace( '/\(edit\(rt-tag\)\)/', "<rt>" , $buffer, 1 );
							break;
						case "end-rt":
							$buffer = preg_replace( '/\(edit\(end-rt\)\)/', "</rt>" , $buffer, 1 );
							break;
						case "color-tag":
							$buffer = preg_replace( '/\(edit\(color-tag-([a-zA-Z0-9#]+)\)\)/', "</span><span id=\"" . $arr ['id'] . $incre . "-sp" . ++$sequence . "\" style=\"color: $1;white-space: " . $arr['white-space'] . ";\">", $buffer, 1 );
							break;
						case "end-color":
							$buffer = preg_replace( '/\(edit\(end-color\)\)/', "</span><span id=\"" . $arr ['id'] . $incre . "-sp" . ++$sequence . "\" style=\"white-space: " . $arr['white-space'] . ";\">", $buffer, 1 );
							break;
						default:
							$buffer = preg_replace( '/\(edit\(([a-z]+\-[a-z]+)[a-zA-Z0-9#\-]*\)\)/', "", $buffer, 1 );
							break;
					}
				}
			}
		}

		// Then Make HTML codes
		$return_str .= "\t<div style=\"display: block;margin: 0;padding: 0;width: 100%;text-align: left;\">\r\n";

		$return_str .= "\t\t<div style=\"display: inline-block;margin: 0;vertical-align: top;text-align: right;width: " . $arr['number-width'] . ";color: " . $arr['number-color'];

		if ( $arr ['number-width'] > 0 ) {
			$return_str .= ";padding: 0 1% 0 0;\">\r\n";
		} else {
			$return_str .= ";padding: 0;visibility:hidden;\">\r\n";
		}

		$return_str .= "\t\t\t<span>" . $incre . "</span>\r\n";

		// No need to \r\n because of inline-block
		$return_str .= "\t\t</div>";

		// Change Color by line number, odd or even
		// No need to \t\t because of inline-block
		if ( $arr['id'] ) {
			$return_str .= "<div id=\"" . $arr ['id'] . $incre . "\" style=\"";
		} else {
			$return_str .= "<div style=\"";
		}

		if ( $incre == $arr['line10-1'] || $incre == $arr['line10-2'] || $incre == $arr['line10-3'] ) {
			$return_str .= "color: " . $arr['line10-color'] . ";";
		} elseif ( $incre == $arr['line20-1'] || $incre == $arr['line20-2'] || $incre == $arr['line20-3'] ) {
			$return_str .= "color: " . $arr['line20-color'] . ";";
		}

		// Use cast to remove "%"
		$textwidth = 100 - (int)$arr['number-width'];
		$return_str .= "display: inline-block;margin: 0;padding: " . $arr['padding-top'] . " " . $arr['padding-right'] . " " . $arr['padding-bottom'] . " " . $arr['padding-left'] . ";vertical-align: top;text-align: " . $arr['text-align'] . ";width: " . $textwidth . "%;";

		if ( $incre % 2 === 1 ) {
			$return_str .= "background-color: " . $arr['odd-background-color'] . ";\">\r\n";
		} else {
			$return_str .= "background-color: " . $arr['even-background-color'] . ";\">\r\n";
		}

		$return_str .= "\t\t\t<span id=\"" . $arr ['id'] . $incre . "-sp1\" style=\"white-space: " . $arr['white-space'] . ";\">" . $buffer . "</span>\r\n";

		$return_str .= "\t\t</div>\r\n";
		$return_str .= "\t</div>\r\n";

		// Increment line number
		$incre++;
	}

	if ( $arr['title'] ) {
		$return_str .= "</div>\r\n<div style=\"display: block;text-align: center;margin: 0;padding: 0.2em;width: " . $arr['width'] . "\">\r\n";
		$return_str .= "\t<p><em><strong>" . $arr['title'] . "</strong></em></p>\r\n";
		$return_str .= "</div>";
	} else {
		$return_str .= "</div>";
	}

	return $return_str;
}

include "spansearch.php";

include "article-loader.php";

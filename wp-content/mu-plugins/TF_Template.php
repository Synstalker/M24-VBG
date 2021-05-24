<?php

/**
 * Class TF_Template
 *
 * Additional features to assist WordPress templating
 */
class TF_Template {

	private static $modify_css_class_defaults = array(
		'append'        => true,
		'replace'       => false,
		'frontend_only' => true,
	);


	/**
	 * Accepts the same params as get_template_part()
	 * Returns instead of echo the result of get_template_part()
	 *
	 * @see get_template_part()
	 *
	 * @param string    $template_slug
	 * @param string    $template_context
	 *
	 * @return string   $template
	 */
	public static function return_template_part( $template_slug = '', $template_context = '' ){
		ob_start();
		get_template_part( $template_slug, $template_context );
		$template = ob_get_clean();
		return $template;
	}


	/**
	 * Used to replace or add css classes to an html string
	 *
	 * @param string    $target_css_class
	 * @param string    $new_css_class
	 * @param string    $html               The html string you are manipulating
	 * @param array     $args               Additional arguments. Future proofing
	 *
	 * @return string   $html
	 * @internal param bool $append if set to false, it will replace the whole class attribute with this
	 *
	 * @todo match the whole word instead of words that are LIKE the current search, test case large input
	 * @todo maybe include a mapping replace, takes in an array and loops through performing this function
	 *
	 */
	public static function modify_css_class( $target_css_class = '', $new_css_class = '', $html = '', $args = array() ){

		if ( !empty( $html ) && !empty( $target_css_class ) ){

			$args = wp_parse_args( $args, self::$modify_css_class_defaults );

			$allow = ( $args[ 'frontend_only'] === true && is_admin() ) ? false : true;

			if( $allow ){
				$re = '/(class=["\'][^\'"]*)('.$target_css_class.')\s?/';
				$subst = $args[ 'replace' ] === false ? '$1$2 '.$new_css_class.' ' : '$1'.$new_css_class.' ';
				$html = preg_replace( $re, $subst, $html );
			}


		}

		return $html;
	}


	/**
	 * Used to change a html tags in a string
	 *
	 * @param string    $target_html_tag
	 * @param string    $new_html_tag
	 * @param string    $html
	 * @param array     $args
	 *
	 * @return string   $html
	 */
	public static function modify_html_tags ( $target_html_tag = 'div', $new_html_tag = 'div', $html = '', $args = array() ){

		$re = '/<('.$target_html_tag.')/';
		$subst = '<'.$new_html_tag;
		$html = preg_replace( $re, $subst, $html );

		$re = '/(<\/'.$target_html_tag.')/';
		$subst = '</'.$new_html_tag;
		$html = preg_replace($re, $subst, $html);

		return $html;
	}


	public static function replace_tag_contents( $target_html_tag = 'div', $replacement = '', $haystack = '' ){
		$re = '/<'.$target_html_tag.'(?:.*)(?:>)(.*)<\/'.$target_html_tag.'>/';
		$result = preg_replace($re, $replacement, $haystack);
		return $result;

	}

}
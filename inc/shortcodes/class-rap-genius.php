<?php

namespace Shortcake_Bakery\Shortcodes;

class Rap_Genius extends Shortcode {

	public static function get_shortcode_ui_args() {
		return array(
			'label'          => esc_html__( 'Rap Genius', 'shortcake-bakery' ),
			'listItemImage'  => '<img width="100px" height="100px" src="' . esc_url( SHORTCAKE_BAKERY_URL_ROOT . 'assets/images/svg/icon-rap.svg' ) . '" />',
		);
	}

	/**
	 * Render the shortcode on-demand
	 *
	 * @param array $attrs
	 * @param string $content
	 */
	public static function callback( $attrs, $content = '' ) {
		$out = '';
		if ( is_admin() ) {
			$out .= '<div style="display:block;height:30px;text-align:center;background-color:red;">(RapGenius Annotations – No Admin Preview)</div>';
		}
		$out .= '<script async src="https://genius.codes"></script>';
		return $out;
	}

	public static function reversal( $content ) {
		if ( preg_match_all( '#<script async src="https://genius\.codes"></script>#', $content, $matches ) ) {
			$replacements = array();
			$shortcode_tag = self::get_shortcode_tag();
			foreach ( $matches[0] as $key => $value ) {
				$replacements[ $value ] = '[' . $shortcode_tag . ']';
			}
			$content = str_replace( array_keys( $replacements ), array_values( $replacements ), $content );
		}
		return $content;
	}

}

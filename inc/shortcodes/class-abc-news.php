<?php

namespace Shortcake_Bakery\Shortcodes;

class ABC_News extends Shortcode {

	private static $valid_hosts = array( 'abcnews.go.com' );

	public static function get_shortcode_ui_args() {
		return array(
			'label'          => esc_html__( 'ABC News', 'shortcake-bakery' ),
			'listItemImage'  => '<img src="' . esc_url( SHORTCAKE_BAKERY_URL_ROOT . 'assets/images/svg/icon-abc-news.svg' ) . '" />',
			'attrs'          => array(
				array(
					'label'        => esc_html__( 'URL', 'shortcake-bakery' ),
					'attr'         => 'url',
					'type'         => 'text',
					'description'  => esc_html__( 'URL to a ABC News video', 'shortcake-bakery' ),
				),
			),
		);
	}

	public static function reversal( $content ) {

		if ( $iframes = self::parse_iframes( $content ) ) {
			$replacements = array();
			foreach ( $iframes as $iframe ) {
				if ( ! in_array( parse_url( $iframe->src_force_protocol, PHP_URL_HOST ), self::$valid_hosts ) ) {
					continue;
				}
				$replacements[ $iframe->original ] = '[' . self::get_shortcode_tag() . ' url="' . esc_url_raw( $iframe->attrs['src'] ) . '"]';
			}
			$content = self::make_replacements_to_content( $content, $replacements );
		}

		return $content;
	}

	public static function callback( $attrs, $content = '' ) {

		if ( empty( $attrs['url'] ) || ! in_array( parse_url( $attrs['url'], PHP_URL_HOST ), self::$valid_hosts ) ) {
			return '';
		}

		return sprintf( '<iframe class="shortcake-bakery-responsive" width="640" height="480" src="%s" frameborder="0"></iframe>', esc_url( $attrs['url'] ) );
	}

}

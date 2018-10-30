<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class JTDT_Module extends Elementor\Modules\DynamicTags\Module {

	public function get_tag_classes_names() {
		return array(
			'JTDT_Post_Description',
		);
	}

	public function get_groups() {
		return array(
			'jtdt_group' => array(
				'title' => 'JetTricks',
			),
		);
	}

	/**
	 * Register tags.
	 *
	 * Add all the available dynamic tags.
	 *
	 * @since  2.0.0
	 * @access public
	 *
	 * @param Manager $dynamic_tags
	 */
	public function register_tags( $dynamic_tags ) {

		foreach ( $this->get_tag_classes_names() as $tag_class ) {

			$file     = str_replace( 'JTDT_', '', $tag_class );
			$file     = str_replace( '_', '-', strtolower( $file ) ) . '.php';
			$filepath = JTDT_PATH . '/includes/dynamic-tags/' . $file;

			if ( file_exists( $filepath ) ) {
				require $filepath;
			}

			if ( class_exists( $tag_class ) ) {
				$dynamic_tags->register_tag( $tag_class );
			}

		}

	}
}
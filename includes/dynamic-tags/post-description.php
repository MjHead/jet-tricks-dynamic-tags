<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class JTDT_Post_Description extends Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'jtdt-post-description';
	}

	public function get_title() {
		return 'Post Description';
	}

	public function get_group() {
		return 'jtdt_group';
	}

	public function get_categories() {
		return array(
			JTDT_Module::TEXT_CATEGORY,
		);
	}

	public function render() {
		echo get_the_excerpt();
	}

}
<?php
/**
 * Plugin Name: JetTricks Dynamic Tags
 * Description: Adds dynamic tags support for JetTricks tooltip.
 * Plugin URI:
 * Author: Zemez
 * Author URI:
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: text-domain
 * Domain Path: domain/path
 */

define( 'JTDT__FILE__', __FILE__ );
define( 'JTDT_PATH', trailingslashit( plugin_dir_path( JTDT__FILE__ ) ) );
define( 'JTDT_URL', plugins_url( '/', JTDT__FILE__ ) );

class JTDT_Plugin {

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance = null;

	/**
	 * Constructor for the class
	 */
	public function __construct() {

		add_action(
			'elementor/element/common/widget_jet_tricks/after_section_end',
			array( $this, 'add_dynamic_settings' ),
			10, 2
		);

		add_action(
			'jet-tricks/frontend/widget/settings',
			array( $this, 'render_dynamic_settings' ),
			10, 3
		);

		add_action(
			'jet-tricks/frontend/widget-content/settings',
			array( $this, 'render_dynamic_settings' ),
			10, 3
		);

		add_action( 'elementor/init', array( $this, 'init_dynamic_tags' ) );

	}

	/**
	 * Initialize dynamic tags
	 */
	public function init_dynamic_tags() {
		require JTDT_PATH . '/includes/dynamic-tags/module.php';
		new JTDT_Module();
	}

	/**
	 * Add dynamic tags support for tooltip descriptions
	 *
	 * @param [type] $element [description]
	 * @param [type] $args    [description]
	 */
	public function add_dynamic_settings( $element, $args ) {

		$control = $element->get_controls( 'jet_tricks_widget_tooltip_description' );

		$element->update_control(
			'jet_tricks_widget_tooltip_description',
			array( 'dynamic' => array( 'active' => true ) )
		);

	}

	/**
	 * Add rendered dynamic settings to widget data
	 *
	 * @return [type] [description]
	 */
	public function render_dynamic_settings( $widget_settings, $widget, $jet_tricks_ext ) {

		if ( 'jet-tricks/frontend/widget-content/settings' === current_filter() ) {

			$settings = $widget->get_settings_for_display();
			$widget_settings['jet_tricks_widget_tooltip_description'] = isset( $settings['jet_tricks_widget_tooltip_description'] ) ? $settings['jet_tricks_widget_tooltip_description'] : '';

		} else {

			if ( ! empty( $widget_settings['tooltip'] ) && 'true' === $widget_settings['tooltip'] ) {

				$settings = $widget->get_settings_for_display();
				$widget_settings['tooltipDescription'] = isset( $settings['jet_tricks_widget_tooltip_description'] ) ? $settings['jet_tricks_widget_tooltip_description'] : '';
			}

		}

		return $widget_settings;

	}

	/**
	 * Returns plugin instance.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

JTDT_Plugin::get_instance();

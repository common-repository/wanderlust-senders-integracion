<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Shipping_Senders class.
 *
 * @extends WC_Shipping_Method
 */
class WC_Shipping_Senders extends WC_Shipping_Method {
	private $found_rates;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->id                               = 'senders';
		$this->method_title                     = __( 'Senders', 'woocommerce-shipping-senders' );
		$this->init();
	}

	/**
	 * init function.
	 */
	private function init() {
		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables
		$this->title           = $this->get_option( 'title', $this->method_title );
		$this->pickup_address_postal_code          = apply_filters( 'woocommerce_senders_origin_postal_code', str_replace( ' ', '', strtoupper( $this->get_option( 'pickup_address_postal_code' ) ) ) );
		$this->origin_country  = apply_filters( 'woocommerce_senders_origin_country_code', WC()->countries->get_base_country() );
		$this->debug           = ( $bool = $this->get_option( 'debug' ) ) && $bool == 'yes' ? true : false;

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	 * Output a message
	 */
	public function debug( $message, $type = 'notice' ) {
		if ( $this->debug ) {
			wc_add_notice( $message, $type );
		}
	}

	/**
	 * environment_check function.
	 */
	private function environment_check() {
		if ( ! in_array( WC()->countries->get_base_country(), array( 'AR' ) ) ) {
			echo '<div class="error">
				<p>' . __( 'Argentina tiene que ser el pais de Origen.', 'woocommerce-shipping-senders' ) . '</p>
			</div>';
		} elseif ( ! $this->pickup_address_postal_code && $this->enabled == 'yes' ) {
			echo '<div class="error">
				<p>' . __( 'Senders esta activo, pero no hay Codigo Postal.', 'woocommerce-shipping-senders' ) . '</p>
			</div>';
		}
	}

	/**
	 * admin_options function.
	 */
	public function admin_options() {
		// Check users environment supports this method
		$this->environment_check();

		// Show settings
		parent::admin_options();
	}

	/**
	 * init_form_fields function.
	 */
	public function init_form_fields() {
		$this->form_fields  = include( 'data/data-settings.php' );
	}

}
<?php   
/*
	Plugin Name: Wanderlust Senders Shipping
	Plugin URI: http://wanderlust-webdesign.com/
	Description: Gestioná los envíos de tu empresa de forma simple y eficaz.
	Version: 0.3
	Author: Wanderlust Web Design
	Author URI: http://wanderlust-webdesign.com
  WC tested up to: 3.5.3
	Copyright: 2007-2019 wanderlust-webdesign.com.
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/


  /**
   * Required functions
  */
  require_once( 'includes/wanderlust-functions.php' );

  /**
     * Plugin page links
  */
  function wc_senders_plugin_links( $links ) {

    $plugin_links = array(
      '<a href="http://wanderlust-webdesign.com/">' . __( 'Soporte', 'woocommerce-shipping-senders' ) . '</a>',
    );

    return array_merge( $plugin_links, $links );
  }

  add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wc_senders_plugin_links' );

  /**
   * WooCommerce is active
  */
  if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	
    function wc_senders_init() {
      include_once( 'includes/class-wc-shipping-senders.php' );
    }

	add_action( 'woocommerce_shipping_init', 'wc_senders_init' );

    function wc_senders_add_method( $methods ) {
      $methods[] = 'WC_Shipping_Senders';
      return $methods;
    }

	add_filter( 'woocommerce_shipping_methods', 'wc_senders_add_method' );

    function wc_senders_scripts() {
      wp_enqueue_script( 'jquery-ui-sortable' );
    }

	add_action( 'admin_enqueue_scripts', 'wc_senders_scripts' );

	$senders_settings = get_option( 'woocommerce_senders_settings', array() );
	
}
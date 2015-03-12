<?php
/*
Plugin Name: Aramex Shipping
Plugin URI: http://richymiles.wordpress.com
Description: Your shipping method plugin
Version: 1.0
Author: Aramex Shipping
*/
 

add_action('admin_menu', 'add_aramex_options');
function add_aramex_options() {
	add_options_page('My Options', 'User Meta Profile Options', 'manage_options', plugin_dir_path( __FILE__ ) . 'client-test.php');
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
	function aramex_shipping_method_init() {
		if ( ! class_exists( 'Aramex_Shipping_Method' ) ) {
			class Aramex_Shipping_Method extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct() {
					$this->id                 = 'aramex_shipping'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'Aramex Shipping' );  // Title shown in admin
					$this->method_description = __( 'Integrates Aramex Shipping with Woo' ); // Description shown in admin
 
					$this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
					$this->title              = "Aramex Shipping"; // This can be added as an setting but for this example its forced.
 
					$this->init();
				}
 
				/**
				 * Init your settings
				 *
				 * @access public
				 * @return void
				 */
				function init() {
					// Load the settings API
					$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
					$this->init_settings(); // This is part of the settings API. Loads settings you previously init.
 					
					// Save settings in admin if you have any defined
					add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
				}

			function init_form_fields() {
			     $this->form_fields = array(
			     'title' => array(
			          'title' => __( 'Title', 'woocommerce' ),
			          'type' => 'text',
			          'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
			          'default' => __( 'PayPal', 'woocommerce' )
			          ),
			     'description' => array(
			          'title' => __( 'Description', 'woocommerce' ),
			          'type' => 'textarea',
			          'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce' ),
			          'default' => __("Pay via PayPal; you can pay with your credit card if you don't have a PayPal account", 'woocommerce')
			           )
     );
} // End init_form_fields()
 
				/**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $package
				 * @return void
				 */
				public function calculate_shipping( $package ) {
					$rate = array(
						'id' => $this->id,
						'label' => $this->title,
						'cost' => '10.99',
						'calc_tax' => 'per_item'
					);
 
					// Register the rate
					$this->add_rate( $rate );
				}
			}
		}
	}
 
	add_action( 'woocommerce_shipping_init', 'aramex_shipping_method_init' );
 
	function add_aramex_shipping_method( $methods ) {
		$methods[] = 'Aramex_Shipping_Method';
		return $methods;
	}
 
	add_filter( 'woocommerce_shipping_methods', 'add_aramex_shipping_method' );
}
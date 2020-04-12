<?php
/*
 * Plugin Name: CoCart - Product Support Boilerplate
 * Plugin URI:  https://cocart.xyz
 * Description: Example of adding product support in use with CoCart.
 * Author:      Sébastien Dumont
 * Author URI:  https://sebastiendumont.com
 * Version:     0.0.1
 * Text Domain: cocart-product-support-boilerplate
 * Domain Path: /languages/
 *
 * WC requires at least: 3.6.0
 * WC Tested up to: 4.0.1
 *
 * Copyright: © 2020 Sébastien Dumont, (mailme@sebastiendumont.com)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'CoCart_Product_Support_Boilerplate' ) ) {
	class CoCart_Product_Support_Boilerplate {

		public $product_type = 'your-product-type'; // TODO: Replace with your product type slug.

		/**
		 * Load the plugin.
		 *
		 * @access public
		 */
		public function __construct() {
			// Prevent this product type from being added to the cart entirely! - Uncomment the following line to enable.
			//add_filter( 'cocart_add_to_cart_handler_' . $this->product_type, array( $this, 'product_not_allowed_to_add' ), 0, 1 );

			// Filters the handler used to add item to the cart. - Uncomment the following line to enable.
			//add_filter( 'cocart_add_to_cart_handler', array( $this, 'add_to_cart_handler' ), 0, 2 );

			// Validates the item before being added to the cart. - Uncomment the following line to enable.
			//add_filter( 'cocart_add_to_cart_validation', array( $this, 'add_to_cart_validation' ), 0, 7 );

			// Load translation files.
			add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		} // END __construct()

		/**
		 * Error response for product type not allowed to be added to the cart.
		 *
		 * @access public
		 * @param  WC_Product $product_data
		 * @return WP_Error
		 */
		public function product_not_allowed_to_add( $product_data ) {
			/* translators: %1$s: product name, %2$s: product type */
			$message = sprintf( __( 'You cannot add "%1$s" to your cart as it is an "%2$s" product.', 'cart-rest-api-for-woocommerce' ), $product_data->get_name(), $product_data->get_type() );

			return new WP_Error( 'cocart_cannot_add_product_type_to_cart', $message, array( 'status' => 500 ) );
		} // END product_not_allowed_to_add()

		/**
		 * Use this function example to override the handler used to add the product.
		 *
		 * @access public
		 * @static
		 * @param  string     $handler - The name of the original handler to use when adding product to the cart.
		 * @param  WC_Product $product
		 * @return string     $handler - The name of the new handler to use when adding product to the cart.
		 */
		public static function add_to_cart_handler( $handler, $product ) {
			switch ( $handler ) {
				case 'pic-and-mix' :
					$handler = 'variable';
					break;
				case 'video-game' :
					$handler = 'simple';
					break;
			}

			return $handler;
		} // END add_to_cart_handler()

		/**
		 * Validates the product before being added to the cart.
		 *
		 * @access public
		 * @param  int    $product_id     - Contains the ID of the product.
		 * @param  int    $quantity       - Contains the quantity of the item.
		 * @param  int    $variation_id   - Contains the ID of the variation.
		 * @param  array  $variation      - Attribute values.
		 * @param  array  $cart_item_data - Extra cart item data we want to pass into the item.
		 * @param  string $product_type   - The product type.
		 * @return bool
		 */
		public function add_to_cart_validation( $passed_validation, $product_id, $quantity, $variation_id, $variation, $cart_item_data, $product_type ) {
			/**
			 * Developer Notes
			 *
			 * Unlike the `woocommerce_add_to_cart_validation` filter, you can not pass form requests.
			 * If you have custom data for the product that must be validated, 
			 * it must be passed via `$cart_item_data` and checked to see if it exists.
			 *
			 * In addition, to save time identifying the product type it is passed through automatically 
			 * for you via `$product_type` which saves a database request and increases loading speed.
			 *
			 * TODO: Add your validation here and simply return true|false.
			 */

			return true;
		} // END add_to_cart_validation()

		/**
		 * Make the plugin translation ready.
		 *
		 * Translations should be added in the WordPress language directory:
		 *      - WP_LANG_DIR/plugins/cocart-product-support-boilerplate-LOCALE.mo
		 *
		 * @access public
		 * @return void
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'cocart-product-support-boilerplate', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

	} // END class

} // END if class exists

new CoCart_Product_Support_Boilerplate();

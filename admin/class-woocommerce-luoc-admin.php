<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpgenie.org
 * @since      1.0.0
 *
 * @package    woocommerce_luoc
 * @subpackage woocommerce_luoc/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    woocommerce_luoc
 * @subpackage woocommerce_luoc/admin
 * @author     Your Name <email@example.com>
 */
class woocommerce_luoc_admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $woocommerce_luoc    The ID of this plugin.
	 */
	private $woocommerce_luoc;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $woocommerce_luoc       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $woocommerce_luoc, $version ) {

		$this->woocommerce_luoc = $woocommerce_luoc;
		$this->version          = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in woocommerce_luoc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The woocommerce_luoc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->woocommerce_luoc, plugin_dir_url( __FILE__ ) . 'css/woocommerce-luoc-admin.css', array(), $this->version, 'all' );

	}

	public function wc_get_customer_orders( $customer ) {

		// Get 1 customer ordersorder
		$customer_orders = get_posts(
			array(
				'numberposts' => 1,
				'orderby'     => 'date',
				'order'       => 'DESC',
				'meta_key'    => '_customer_user',
				'meta_value'  => $customer,
				'post_type'   => wc_get_order_types(),
				'post_status' => array_keys( wc_get_order_statuses() ),
			)
		);

		//$customer = wp_get_current_user();
		if ( ! empty( $customer_orders[0] ) ) {
			return $customer_orders[0];
		}else if ( ! empty( $customer_orders ) ) {
			return $customer_orders;
		}else {
			return false;
		}

	}


	public function new_modify_user_table( $column ) {
		$column['last_order'] = esc_html__( 'Last WooCommerce Order', 'woocommerce-luoc' );
		return $column;
	}


	public function new_modify_user_table_row( $val, $column_name, $uid ) {

		switch ( $column_name ) {
			case 'last_order':
				$details = $this->wc_get_customer_orders( $uid );
				if ( ! $details ) {
					return esc_html__( 'n/a', 'woocommerce-luoc' );
				} else {
					return '<a href="' . admin_url() . 'post.php?post=' . $details->ID . '&action=edit">' . $details->post_title . '</a>';
				}

				break;
			default:
		}
		return $val;
	}



}

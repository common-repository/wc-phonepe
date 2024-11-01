<?php

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

final class WC_Phonepe_Blocks extends AbstractPaymentMethodType {

	private $gateway;
	protected $name = 'sg-phonepe';

	public function initialize() {
		$this->settings = get_option( 'woocommerce_sg-phonepe_settings', [] );
		$this->gateway = new WC_PhonePe_Gateway();
	}

	public function is_active() {
		return $this->gateway->is_available();
	}

	public function get_payment_method_script_handles() {

		wp_register_script(
			'wc-phonepe-blocks-integration',
            plugin_dir_url(__FILE__) . 'block/checkout.js',
			[
				'wc-blocks-registry',
				'wc-settings',
				'wp-element',
				'wp-html-entities',
				'wp-i18n',
			],
			null,
			true
		);
		if( function_exists( 'wp_set_script_translations' ) ) {			
			wp_set_script_translations( 'wc-phonepe-blocks-integration', 'wc-phonepe', SGPPY_PLUGIN_PATH. 'languages/' );
			
		}
		return [ 'wc-phonepe-blocks-integration' ];
	}

	public function get_payment_method_data() {
		return [
			'title' => $this->gateway->title,
			'description' => $this->gateway->description,
		];
	}

}
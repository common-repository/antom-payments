<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  WC_Gateway_Antom_Card Payment Gateway class
 *
 * @class    WC_Gateway_Antom_Card
 * @version  1.0.0
 */
class WC_Gateway_Antom_Card extends WC_Gateway_Antom_Common {


	/**
	 * Unique id for the gateway.
	 *
	 * @var string
	 */
	public $id = 'antom_card';


	protected function setup_props() {
		parent::setup_props();
	}

	public function field_name( $name ) {
		return $this->supports( 'tokenization' ) ? '' : ' name="' . esc_attr( $this->id . '-' . $name ) . '" ';
	}

	public function payment_fields() {
		wp_enqueue_script( 'wc-credit-card-form' );
		$asset_url = ANTOM_PAYMENT_GATEWAYS_URL . 'assets/images/';
		if ( ! is_user_logged_in() ) {
			echo '<p>' . esc_html( __( 'Please log in before using this payment method.', 'antom-payments' ) ) . '</p>';
		} else {
			?>

		<div class="antom-cards">
			<div class="antom-cards-container bottom-space">
				<p>Card Information</p>
			</div>
			<div class="antom-cards-container">
				<div class="antom-cards-container-item">
					<div class="antom-cards-container-item-line">
						<div class="card-cover">
							<img data-host="<?php echo esc_attr( $asset_url ); ?>"  src="<?php echo esc_attr( $asset_url ); ?>card-gray.svg"/>
						</div>
						<input placeholder="Card number" class="antom-card-number" oninput="format_card_number(this)" />
					</div>
					<div class="antom-cards-container-item-line antom-cards-container-item-error antom-card-number-error"></div>
				</div>
			</div>
			<div class="antom-cards-container">
				<div class="antom-cards-container-item expire-date">
					<div class="antom-cards-container-item-line">
						<input placeholder="Exipre date" class="antom-expire-date" oninput="format_expire_date(this,event)" />
					</div>
					<div class="antom-cards-container-item-line antom-cards-container-item-error antom-expire-date-error"></div>
				</div>
				<div class="antom-cards-container-item">
					<div class="antom-cards-container-item-line">
						<input placeholder="CVC" class="antom-cvc" oninput="format_cvc(this)" />
					</div>
					<div class="antom-cards-container-item-line antom-cards-container-item-error antom-cvc-error"></div>
				</div>
			</div>
			<div class="antom-cards-container">
				<div class="antom-cards-container-item">
					<div class="antom-cards-container-item-line">
						<input placeholder="Holder name" class="antom-holder-name"  />
					</div>
					<div class="antom-cards-container-item-line antom-cards-container-item-error antom-holder-name-error"></div>
				</div>
			</div>
		</div>
		<input type="hidden" value="" name="antom_card_token" id="antom_card_token" />
			
			<?php
			$core_settings = antom_get_core_settings();
			if ( 1 === intval( $core_settings['test_mode'] ) ) {
				?>
				<p class="antom-test-mode-warning">run in antom test mode</p>
				<p class="antom-test-mode-info">you can test with this card number : <span class="strong">4054695723100768</span> . expire date with this format : <span class="strong"> MM / YY</span> , such as <span class="strong">02 / 29</span>, CVC with any Three digits, such as <span class="strong">123</span></p>
				<?php
			}
		}
	}
}

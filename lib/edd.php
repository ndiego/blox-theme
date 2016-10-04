<?php
// EDD Functions

add_action( 'edd_register_account_fields_before', 'blox_register_account_fields_before', 10 );
function blox_register_account_fields_before() {
	echo '<p class="blox-cart-description">Your account will give you instant access to all past purchases and all purchased files. License renewals and priority support are also handled through your personalized account.</p>';
}
add_action( 'edd_purchase_form_before_email', 'blox_purchase_form_before_email', 10 );
function blox_purchase_form_before_email() {
	echo '<p class="blox-cart-description">We need your first name, last name and email address so that we can send you a purchase receipt and downloadable files. Your information will never be shared with a third party.</p>';
}
add_action( 'edd_checkout_login_fields_before', 'blox_checkout_login_fields_before', 10 );
function blox_checkout_login_fields_before() {
	echo '<span><legend>Account Login</legend></span>';
}

add_action( 'edd_payment_mode_before_gateways', 'blox_payment_mode_before_gateways', 10 );
function blox_payment_mode_before_gateways() {
	echo '<p class="blox-cart-description">We currently support PayPal and Amazon Payments. All transactions are handled securely through them. We will never see your credit card information.</p>';
}

remove_action( 'edd_purchase_form_before_submit', 'edd_terms_agreement' );
add_action( 'edd_purchase_form_before_submit', 'blox_terms_agreement' );
function blox_terms_agreement() {
	if ( edd_get_option( 'show_agree_to_terms', false ) ) {
		$agree_text  = edd_get_option( 'agree_text', '' );
		$agree_label = edd_get_option( 'agree_label', __( 'Agree to Terms?', 'easy-digital-downloads' ) );
		?>
		<fieldset id="edd_terms_agreement">
			<span><legend>Terms of Use</legend></span>
			<p class="blox-cart-description">You must check the box below to purchase Blox.</p>
			<label for="edd_agree_to_terms">
				<input name="edd_agree_to_terms" class="required" type="checkbox" id="edd_agree_to_terms" value="1"/>
				By purchasing Blox, you agree to the <a href="https://www.bloxwp.com/terms-conditions/" title="Terms and Conditions" target="_blank">Terms &amp; Conditions</a> of use.
			</label>
		</fieldset>
		<?php
	}
}

remove_action( 'edd_cart_empty', 'edd_empty_checkout_cart' );
add_action( 'edd_cart_empty', 'blox_empty_checkout_cart' );
function blox_empty_checkout_cart() {
	?>
	<div style="text-align: center; max-width: 700px;margin: 0 auto;">
		<h2>Oops... There's nothing in your cart!</h2>
		<p>Head over to the pricing page to learn about the different licensing options for Blox.</p>
		<a class="button" href="/pricing">View Pricing</a>

		<p class="example-block warning" style="margin-top:50px;">Did you actually add a Blox license to your cart and it isn't showing up here? Try clearing your browser cache and then add a license to your cart again.</p>
	</div>
	<?php
}

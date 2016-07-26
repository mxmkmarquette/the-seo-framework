<?php
//* Fetch the required instance within this file.
$instance = $this->get_view_instance( 'the_seo_framework_webmaster_metabox', $instance );

switch ( $instance ) :
	case 'the_seo_framework_webmaster_metabox_main' :
		$site_url = $this->the_home_url_from_cache();
		$language = $this->google_language();

		$bing_site_url = 'https://www.bing.com/webmaster/configure/verify/ownership?url=' . urlencode( $site_url );
		$google_site_url = 'https://www.google.com/webmasters/verification/verification?hl=' . $language . '&siteUrl=' . $site_url;
		$pint_site_url = 'https://analytics.pinterest.com/';
		$yandex_site_url = 'https://webmaster.yandex.com/site/verification.xml';

		?><h4><?php esc_html_e( 'Webmaster Integration Settings', 'autodescription' ); ?></h4><?php
		$this->description( __( "When adding your website to Google, Bing and other Webmaster Tools, you'll be asked to add a code or file to your website for verification purposes. These options will help you easily integrate those codes.", 'autodescription' ) );
		$this->description( __( "Verifying your website has no SEO value whatsoever. But you might gain added benefits such as search ranking insights to help you improve your website's content.", 'autodescription' ) );

		?>
		<hr>

		<p>
			<label for="<?php $this->field_id( 'google_verification' ); ?>" class="toblock">
				<strong><?php esc_html_e( 'Google Webmaster Verification Code', 'autodescription' ); ?></strong>
				<a href="<?php echo esc_url( $google_site_url ); ?>" target="_blank" class="description" title="<?php esc_attr_e( 'Get the Google Verification code', 'autodescription' ); ?>">[?]</a>
			</label>
		</p>
		<p>
			<input type="text" name="<?php $this->field_name( 'google_verification' ); ?>" class="large-text" id="<?php $this->field_id( 'google_verification' ); ?>" placeholder="ABC1d2eFg34H5iJ6klmNOp7qRstUvWXyZaBc8dEfG9" value="<?php echo esc_attr( $this->get_field_value( 'google_verification' ) ); ?>" />
		</p>

		<p>
			<label for="<?php $this->field_id( 'bing_verification' ); ?>" class="toblock">
				<strong><?php esc_html_e( 'Bing Webmaster Verification Code', 'autodescription' ); ?></strong>
				<a href="<?php echo esc_url( $bing_site_url ); ?>" target="_blank" class="description" title="<?php esc_attr_e( 'Get the Bing Verification Code', 'autodescription' ); ?>">[?]</a>
			</label>
		</p>
		<p>
			<input type="text" name="<?php $this->field_name( 'bing_verification' ); ?>" class="large-text" id="<?php $this->field_id( 'bing_verification' ); ?>" placeholder="123A456B78901C2D3456E7890F1A234D" value="<?php echo esc_attr( $this->get_field_value( 'bing_verification' ) ); ?>" />
		</p>

		<p>
			<label for="<?php $this->field_id( 'yandex_verification' ); ?>" class="toblock">
				<strong><?php esc_html_e( 'Yandex Webmaster Verification Code', 'autodescription' ); ?></strong>
				<a href="<?php echo esc_url( $yandex_site_url ); ?>" target="_blank" class="description" title="<?php esc_attr_e( 'Get the Yandex Verification Code', 'autodescription' ); ?>">[?]</a>
			</label>
		</p>
		<p>
			<input type="text" name="<?php $this->field_name( 'yandex_verification' ); ?>" class="large-text" id="<?php $this->field_id( 'yandex_verification' ); ?>" placeholder="12345abc678901d2" value="<?php echo esc_attr( $this->get_field_value( 'yandex_verification' ) ); ?>" />
		</p>

		<p>
			<label for="<?php $this->field_id( 'pint_verification' ); ?>" class="toblock">
				<strong><?php esc_html_e( 'Pinterest Analytics Verification Code', 'autodescription' ); ?></strong>
				<a href="<?php echo esc_url( $pint_site_url ); ?>" target="_blank" class="description" title="<?php esc_attr_e( 'Get the Pinterest Verification Code', 'autodescription' ); ?>">[?]</a>
			</label>
		</p>
		<p>
			<input type="text" name="<?php $this->field_name( 'pint_verification' ); ?>" class="large-text" id="<?php $this->field_id( 'pint_verification' ); ?>" placeholder="123456a7b8901de2fa34bcdef5a67b98" value="<?php echo esc_attr( $this->get_field_value( 'pint_verification' ) ); ?>" />
		</p>
		<?php
		break;

	default :
		break;
endswitch;

<div class=" checkout-login ">
    <form method="post" class="woocommerce-form woocommerce-form-register  register">
        <h2 class="register_title">
            <span class="light"><?php esc_html_e('Register', 'woocommerce'); ?></span></h2>
		<?php do_action('woocommerce_register_form_start'); ?>
		<?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?> <span
                            class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
                       id="reg_username" autocomplete="username"
                       value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
            </p>
		<?php endif; ?>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?> <span
                        class="required">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email"
                   id="reg_email"
                   autocomplete="email"
                   value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
            <input type="hidden" name="stm_role" value="library">

        </p>
        <p class="woocommerce-gzd-reg_data_privacy-checkbox-text stm_email_address">
            A password will be sent to your email address.
        </p>
		<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?> <span
                            class="required">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password"
                       id="reg_password" autocomplete="new-password"/>
            </p>
		<?php endif; ?>
		<?php do_action('woocommerce_register_form'); ?>
        <p class="woocommerce-FormRow form-row">
			<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
            <button type="submit" class="woocommerce-Button button" name="register"
                    value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
        </p>
		<?php do_action('woocommerce_register_form_end'); ?>
    </form>
</div>

<?php wc_print_notices(); ?>
<?php do_action('woocommerce_before_customer_login_form'); ?>

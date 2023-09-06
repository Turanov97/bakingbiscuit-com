<?php

?>
<div class=" checkout-login">

    <form method="post" class=" login wc-auth-login">
    <h2><span class="light"><?php esc_html_e('Login', 'woocommerce'); ?></span></h2>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>&nbsp;<span
                        class="required">*</span></label>
            <input type="text" class="input-text" name="username" id="username"
                   value="<?php echo (!empty($_POST['username'])) ? esc_attr($_POST['username']) : ''; ?>"/><?php //@codingStandardsIgnoreLine ?>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span
                        class="required">*</span></label>
            <input class="input-text" type="password" name="password" id="password"/>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide stm_lost_password">
			<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
            <input type="submit" class="btn btn-lg btn-block btn-orange font-weight-bold login-form-btn "
                   name="login"
                   value="<?php esc_attr_e('Login', 'woocommerce'); ?>">
            <input type="hidden" name="user" value="true"/>
            <!--        <input type="hidden" name="redirect" value="-->
			<?php //echo esc_url( $redirect_url ); ?><!--" />-->

            <span class="checkout-login-remember">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" class="gem-checkbox"/>
					<label for="rememberme" class="inline"> <?php esc_html_e('Remember me', 'woocommerce'); ?></label>
				</span>


        <span class="woocommerce-LostPassword lost_password">
            <a href="/my-account/lost-password/"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
        </span>
        </p>

    </form>

</div>

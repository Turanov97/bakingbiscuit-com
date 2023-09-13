<?php

/** Shortcode show new_form_sign_in*/
add_shortcode('woocommerce_signin', 'new_form_sign_in');
function new_form_sign_in()
{
	// Проверяем, авторизован ли пользователь
	if (!is_user_logged_in()) {
		if (file_exists(get_stylesheet_directory() . '/sign_in.php')) {
			load_template(get_stylesheet_directory() . '/sign_in.php');
		} else {
			echo get_stylesheet_directory() . '/sign_in.php';
			echo 'Файл register.php не существует';
		}
	} else {
		// Пользователь авторизован, не показываем содержимое шорткода
		// Можно вывести сообщение или что-то еще, если нужно
	}
}


/** Shortcode show new_form_register*/
add_shortcode('woocommerce_register', 'new_form_register');
function new_form_register()
{
	// Проверяем, авторизован ли пользователь
	if (!is_user_logged_in()) {
		if (file_exists(get_stylesheet_directory() . '/register.php')) {
			load_template(get_stylesheet_directory() . '/register.php');
		} else {
			echo 'Файл register.php не существует';
		}
	} else {
		// Пользователь авторизован, не показываем содержимое шорткода
		// Можно вывести сообщение или что-то еще, если нужно
	}
}


/** Shortcode show search*/
add_shortcode('elastic_search_stm', 'elastic_search_stm');
function elastic_search_stm()
{
	if (file_exists(get_stylesheet_directory() . '/inc/elastic_search.php')) {
		load_template(get_stylesheet_directory() . '/inc/elastic_search.php');
	} else {
		echo 'Файл register.php не существует';
	}
}

/** Shortcode welcomeUser*/
add_shortcode('welcomeUser', 'welcomeUser');
function welcomeUser()
{
	?>
	<h2 class="welcome_stm_user">
		<?php
		$current_user = wp_get_current_user();
		if (is_user_logged_in()) {
			?> <p style="margin-bottom: 0px !important;"><?php printf(__('Welcome, %s!', 'theGem-elementor-child'), esc_html($current_user->nickname))  ?></p>
			<p><?php printf(__('what are you researching today?', 'theGem-elementor-child'), esc_html($current_user->nickname))  ?></p>
			<?php
		}
		?>
	</h2>
	<?php
}

/** Shortcode welcomeUser*/
add_shortcode('didYouFind', 'didYouFind');
function didYouFind()
{
	?>
	<h2 class="welcome_stm_user">
		<?php
		$current_user = wp_get_current_user();
		if (is_user_logged_in()) {
			?> <p style="margin-bottom: 0px !important;"><?php printf(__('%s!, Did you find everything?', 'theGem-elementor-child'), esc_html($current_user->nickname))  ?></p>
			<p><?php printf(__('Don\'t hasitate to contact us. ', 'theGem-elementor-child'), esc_html($current_user->nickname))  ?></p>
			<?php
		}
		?>
	</h2>
	<?php
}

/** Shortcode welcomeUser*/
add_shortcode('welcomeUserBanner', 'welcomeUserBanner');
function welcomeUserBanner()
{
	if (file_exists(get_stylesheet_directory() . '/parts/single_banner.php')) {
		load_template(get_stylesheet_directory() . '/parts/single_banner.php');
	} else {
		echo 'Файл single_banner.php не существует';
	}
}





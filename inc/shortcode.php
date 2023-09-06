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




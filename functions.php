<?php

require get_stylesheet_directory() . '/inc/shortcode.php';
require get_stylesheet_directory() . '/inc/custom_post_type.php';


add_action('wp_enqueue_scripts', 'theme_name_scripts');
function theme_name_scripts()
{
	wp_enqueue_style('style-name', get_stylesheet_uri());
	wp_enqueue_script('stm_main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
	// Определяем переменную ajaxurl и передаем её в ваш файл JavaScript

	wp_localize_script('stm_main', 'ajaxurl', admin_url('admin-ajax.php'));
}


/**
 * Enqueue a script in the WordPress admin on edit.php.
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function wpdocs_selectively_enqueue_admin_script()
{
	wp_enqueue_style('stm_admin', get_stylesheet_directory_uri() . '/assets/css/admin.style.css', '', '1.0');

//	wp_enqueue_script('stm_main', get_stylesheet_directory_uri() . '/assets/js/main.js', '', '1.0');
}

add_action('admin_enqueue_scripts', 'wpdocs_selectively_enqueue_admin_script');


function add_role_library()
{
	// Проверяем, существует ли роль "Library"
	$library_role = get_role('library');

	// Если роль "Library" не существует, то добавляем ее
	if (empty($library_role)) {
		add_role(
			'library',
			'Library Members',
			get_role('subscriber')->capabilities
		);
	}
}

add_action('init', 'add_role_library');


function assign_role_based_on_registration_form($user_id)
{
	// Проверяем, чтобы выбранная роль была "library"
	$selected_role = sanitize_text_field($_POST['stm_role']);

	if ($selected_role === 'library') {
		// Назначаем роль "Library" пользователю
		$user = new WP_User($user_id);
		$user->set_role('library');
	}
}

add_action('woocommerce_created_customer', 'assign_role_based_on_registration_form');


add_action('wp_ajax_custom_search_action', 'custom_search_action_callback');
add_action('wp_ajax_nopriv_custom_search_action', 'custom_search_action_callback');

function custom_search_action_callback()
{
	$stm_search = sanitize_text_field($_POST['stm_search']); // Санитизация входных данных
	// Создаем массив таксономий, по которым будем искать
	$taxonomies = array('equipment', 'processes', 'services', 'products');

	// Выполняем запросы для каждой таксономии
	$out = '';

	global $wpdb;
	//		foreach ($taxonomies as $taxonomy) {

	// Get the matching term IDs.
	$term_ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT t.term_id FROM {$wpdb->terms} AS t WHERE t.name LIKE %s",
			'%' . $wpdb->esc_like($stm_search) . '%'
		)
	);

	if ( empty( $term_ids ) ) {
		die( 'No results found.' );
	}

	$args = array(
		'post_type' => 'company',
		'posts_per_page' => 15,
		'tax_query' => array(
			array(
				'taxonomy' => 'equipment',
				'field' => 'term_id',
				'terms' => $term_ids,
				'operator' => 'IN',
			),
		),
		'order' => 'ASC',
		'orderby' => 'title'
	);

	$loop = new WP_Query($args);
	$alphabet = array();
	$count_post = 0;



	if ($loop->have_posts()) :
		while ( $loop->have_posts() ) : $loop->the_post();
			$alphabet[] = substr(get_the_title(), 0, 1);
			$count_post++;
		endwhile;
	endif;

	if ( ! empty( $alphabet ) ) {
		$alphabet = array_unique( $alphabet );
		sort($alphabet);
	}

	ob_start();

	?>
    <div class="stm_companys"> <?php

		if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
			$post_id = get_the_ID();
			$payment_status = get_post_meta($post_id, 'payment_status', true);
			?>

            <div class="stm_company_item">
                <a href="<?php echo get_the_permalink(); ?>">
					<?php
						if ($payment_status === 'paid') {
							echo get_the_post_thumbnail();
						} else {
							?>
							<img src="" alt="">
							<?php
						}
					?>
                    <div class="stm_company_description">
						<?php echo get_the_title() ?>
                    </div>
                </a>
            </div>
	<?php
		endwhile;
		endif;
		wp_reset_postdata();
		//		}
	?>
    </div>
	<?php

	$html = ob_get_clean();

	wp_send_json( array('html' => $html, 'letters' => $alphabet, 'count_post' => $count_post) );

	die($out);
}


function add_body_class_for_logged_in_user($classes)
{
	if (is_user_logged_in()) {
		$classes[] = 'stm_user-logged-in'; // Замените 'user-logged-in' на нужный вам класс
	}
	return $classes;
}

add_filter('body_class', 'add_body_class_for_logged_in_user');


// Функция для скрытия остальных колонок
function hide_other_columns($columns)
{
	unset($columns['date']); // Скрыть колонку "Date"
	unset($columns['author']); // Скрыть колонку "Author"
	unset($columns['categories']); // Скрыть колонку "Categories"
	unset($columns['tags']); // Скрыть колонку "Tags"
	unset($columns['wpseo-score']); // Скрыть колонку "Tags"
	unset($columns['wpseo-score-readability']); // Скрыть колонку "Tags"
	unset($columns['wpseo-links']); // Скрыть колонку "Tags"
	unset($columns['wpseo-linked']); // Скрыть колонку "Tags"
	// Удалите или добавьте другие колонки, которые вы хотите скрыть или показать
	return $columns;
}

add_filter('manage_edit-company_columns', 'hide_other_columns');

// Добавляем колонку в таблицу управления постами
function custom_columns_head($columns)
{
	// Добавляем новую колонку с названием "Payment Status"
	$columns['featured_image'] = 'Featured Image';
	$columns['equipment'] = 'Equipment'; // Добавляем колонку для таксономий "terms"
	$columns['payment_status'] = 'Payment Status';
	return $columns;
}

add_filter('manage_company_posts_columns', 'custom_columns_head');

// Выводим данные в созданных колонках
function custom_columns_content($column_name, $post_id)
{
	if ($column_name == 'featured_image') {
		// Выводим изображение "Featured Image" в колонке
		echo get_the_post_thumbnail($post_id, array(50, 50)); // Меняйте размеры изображения по вашему выбору
	}

	if ($column_name == 'equipment') {
		// Получаем список таксономий "terms" для текущего поста
		$terms = get_the_terms($post_id, 'equipment');
		// Проверяем, есть ли таксономии
		if ($terms && !is_wp_error($terms)) {
			$term_names = array();

			// Получаем имена каждой таксономии
			foreach ($terms as $term) {
				$term_names[] = $term->name;
			}

			// Объединяем их через запятую
			$term_string = implode(', ', $term_names);

			// Ограничиваем вывод до 60 слов и добавляем многоточие, если текст длиннее
			$word_limit = 35;
			$term_string = wp_trim_words($term_string, $word_limit, '...');

			echo $term_string;
		} else {
			echo 'No Equipment';
		}
	}
	if ($column_name == 'payment_status') {
		// Выводим данные из поля "payment_status"
		$payment_status = get_post_meta($post_id, 'payment_status', true);
		echo $payment_status;
	}

}

add_action('manage_company_posts_custom_column', 'custom_columns_content', 10, 2);


if (!function_exists('write_log_s')) {
	function write_log_s($log)
	{
		if (WP_DEBUG) {
			if (is_array($log) || is_object($log)) {
				trigger_error(print_r($log, true));
			} else {
				trigger_error($log);
			}
		}
	}
}



function more_post_ajax()
{
	$postId = (isset($_POST["postid"])) ? $_POST["postid"] : '';
	$ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 15;
	$page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
	$companyPosts = get_post_meta($postId, 'add_post_in_company', true);


	header("Content-Type: text/html");

	$args = array(
		'post_type' => 'post',
		'post__in' => $companyPosts,
		'suppress_filters' => true,
		'posts_per_page' => $ppp,
		'paged' => $page,
	);

	$loop = new WP_Query($args);

	$out = '';

	if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
		?>

		<div class="stm_single_company_posts_item">
			<div class="stm_single_company_posts_logo">
				<?php echo get_the_post_thumbnail(); ?>
			</div>
			<a href="<?php echo get_the_permalink() ?>" class="stm_single_company_posts_info">
				<div class="stm_single_company_posts_title">
					<?php echo get_the_title(); ?>
				</div>
				<div class="stm_single_company_posts_desc">
					<?php
					$content = get_the_content();
					$content = wp_strip_all_tags($content); // Удаляем HTML-теги из контента
					$content = strip_shortcodes($content); // Удаляем короткие коды
					$content = trim($content); // Удаляем лишние пробелы в начале и конце

					$word_limit = 25; // Желаемое количество слов

					$words = explode(' ', $content, $word_limit + 1); // Разбиваем контент на слова
					if (count($words) > $word_limit) {
						array_pop($words); // Удаляем последнее слово, чтобы оставить только 70 слов
						$content = implode(' ', $words);
						$content .= '...'; // Добавляем многоточие, если текст обрезан
					}

					echo $content;
					?>
				</div>
				<div class="stm_single_company_posts_author">
					<?php echo get_the_date('j F Y'); ?>
				</div>
			</a>
		</div>
	<?php

	endwhile;
	endif;
	wp_reset_postdata();
	die($out);
}

add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');




function more_company_posts()
{
	$stm_search = sanitize_text_field($_POST['stm_search']); // Санитизация входных данных
	global $wpdb;
	$term_ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT t.term_id FROM {$wpdb->terms} AS t WHERE t.name LIKE %s",
			'%' . $wpdb->esc_like($stm_search) . '%'
		)
	);
	if ( empty( $term_ids ) ) {
		die( 'No results found.' );
	}

	$ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 15;
	$page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;


	header("Content-Type: text/html");

	$args = array(
		'post_type' => 'company',
		'posts_per_page' => $ppp,
		'paged' => $page,
		'tax_query' => array(
			array(
				'taxonomy' => 'equipment',
				'field' => 'term_id',
				'terms' => $term_ids,
				'operator' => 'IN',
			),
		),
	);

	$loop = new WP_Query($args);

	$out = '';

	if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
		$post_id = get_the_ID();
		$payment_status = get_post_meta($post_id, 'payment_status', true);
		?>
		<div class="stm_company_item">
			<a href="<?php echo get_the_permalink(); ?>">
				<?php
				if ($payment_status === 'paid') {
					echo get_the_post_thumbnail();
				} else {
					?>
					<img src="" alt="">
					<?php
				}
				?>
				<div class="stm_company_description">
					<?php echo get_the_title() ?>
				</div>
			</a>
		</div>
	<?php

	endwhile;
	endif;
	wp_reset_postdata();
	die($out);
}

add_action('wp_ajax_nopriv_more_company_posts', 'more_company_posts');
add_action('wp_ajax_more_company_posts', 'more_company_posts');



function check_company_authorization() {
	if (is_single() && strpos($_SERVER['REQUEST_URI'], '/company/') !== false) {
		if (!is_user_logged_in()) {
			// Если пользователь не авторизован, перенаправьте его на страницу входа.
			wp_redirect('/library/');
			exit;
		}
	}
}
add_action('template_redirect', 'check_company_authorization');

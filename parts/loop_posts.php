<?php


$companyPosts = get_post_meta(get_the_ID(), 'add_post_in_company', true);
$args = array(
	'post_type' => 'post',
	'post__in' => $companyPosts,
	'posts_per_page' => 15,
);
if (!empty($companyPosts)) {
// The Query
	$the_query = new WP_Query($args);

	if ($the_query->have_posts()) :
		while ($the_query->have_posts()) : $the_query->the_post();
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
		?>


		<?php

		wp_reset_postdata(); // Сбрасываем данные после цикла
	else :
		esc_attr_e('No posts', 'theGem-elementor-child');
	endif;
} else {
	esc_attr_e('No posts', 'theGem-elementor-child');
}
?>

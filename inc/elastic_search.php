<h2 class="welcome_stm_user">
	<?php
	$current_user = wp_get_current_user();
	if (is_user_logged_in()) {
		printf(__('Welcome, %s! what are you researching today?', 'theGem-elementor-child'), esc_html($current_user->nickname)) . '<br />';
	}
	?>
</h2>
<div style="display:flex;flex-direction: column;">
	<div class="stm_search">
		<form id="stm_search_form" action="" method="post">
			<input type="text" value="" name="stm_search" placeholder="Search...">
			<button id="baking_input_search">Search</button>
		</form>
	</div>

	<div id="baki_pagination" class="pagination" style="margin-bottom: 30px">

	</div>

	<div class="lds-facebook">
		<div></div>
		<div></div>
		<div></div>
	</div>

	<div class="search-results">
		<!-- Здесь будут отображаться результаты поиска -->
		<?php esc_attr_e('Do a search to see companies', 'theGem-elementor-child'); ?>
	</div>
</div>



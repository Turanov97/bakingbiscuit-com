<div style="display:flex;flex-direction: column;">
	<div class="stm_search">
		<form id="stm_search_form" action="" method="post">
			<input type="text" value="" name="stm_search" placeholder="Search...">
			<button id="baking_input_search">Search</button>
		</form>
	</div>
	<h2 class="welcome_stm_user welcome_stm_user--filter" style="display: none;">
		<?php esc_attr_e('Filter Companies alphabetical', 'theGem-elementor-child'); ?>
	</h2>

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

	<div class="single_message" style="margin-top: 30px;"></div>

	<div id="more_posts" class="btn btn-dark more_posts load_company">
		<span class="load_company_btn" >Load More</span>
		<div class="lds-ellipsis">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>

</div>



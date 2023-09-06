<?php get_header();

$stm_title = get_post_meta(get_the_ID(), 'company', true);
$stm_group = get_post_meta(get_the_ID(), 'group', true);
$stm_street = get_post_meta(get_the_ID(), 'street_number', true);
$stm_postal_code = get_post_meta(get_the_ID(), 'postal_code', true);
$stm_city = get_post_meta(get_the_ID(), 'city', true);
$stm_country = get_post_meta(get_the_ID(), 'country', true);
$stm_phone = get_post_meta(get_the_ID(), 'phone', true);
$stm_email = get_post_meta(get_the_ID(), 'e-mail', true);
$stm_website = get_post_meta(get_the_ID(), 'website', true);
$payment_status = get_post_meta(get_the_ID(), 'payment_status', true);


?>
<div class="stm_content">
	<?php while (have_posts()) :
		the_post(); ?>
		<?php if (!empty($payment_status) && $payment_status === 'paid') { ?>
        <div class="logo">
			<?php echo get_the_post_thumbnail() ?>
        </div>
	    <?php } ?>
        <div class="stm_single_company">
            <div class="stm_single_company_bio">
				<?php if (!empty($stm_title)) { ?>
                    <div class="stm_single_title">
						<?php echo $stm_title; ?>
                    </div>
				<?php } ?>
				<?php if (!empty($stm_street)) { ?>
                    <div class="stm_single_street">
						<?php echo $stm_street; ?>
                    </div>
				<?php } ?>
				<?php if (!empty($stm_postal_code)) { ?>
                    <div class="stm_single_postal_code">
						<?php echo $stm_postal_code . $stm_city ?>
                    </div>
				<?php } ?>

				<?php
				if (!empty($payment_status) && $payment_status === 'paid') {
					if (!empty($stm_phone)) { ?>
                        <div class="stm_single_phone">
							<?php echo 'Telefon:' . $stm_phone; ?>
                        </div>
					<?php } ?>
					<?php if (!empty($stm_email)) { ?>
                        <div class="stm_single_email">
							<?php echo 'E-Mail:' . $stm_email; ?>
                        </div>
					<?php } ?>
					<?php if (!empty($stm_website)) { ?>
                        <div class="stm_single_url">
							<?php echo $stm_website; ?>
                        </div>
					<?php }
				} ?>

            </div>
          <div>
			  <div class="stm_single_company_posts">
				  <?php load_template(get_stylesheet_directory() . '/parts/loop_posts.php'); ?>

			  </div>

			  <div id="more_posts" class="btn btn-dark more_posts">
				  <span class="btn_span_ajax" data-id="<?php echo get_the_ID();?>">Load More</span>
				  <div class="lds-ellipsis">
					  <div></div>
					  <div></div>
					  <div></div>
					  <div></div>
				  </div>
			  </div>
		  </div>
        </div>
	<?php endwhile; ?>
</div>


<?php get_footer(); ?>

<?php

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // restict for direct access
}
?>

<h2 class="afwsp_hide_prices_heading"><?php echo esc_html__('Hide Price & Add to Cart', 'addify_wholesale_prices'); ?></h2>

<div class="wrap">
	<form action="" method="post">
	<?php wp_nonce_field('afwholesaleprice_nonce_action', 'afwholesaleprice_nonce_field'); ?>
	<div class="hide_price_divs">
		<div class="hide_div">

			<label><?php echo esc_html__('Enable Hide Price & Add to Cart', 'addify_wholesale_prices'); ?></label>
			<input type="checkbox" name="wsp_enable_hide_pirce" id="wsp_enable_hide_pirce" value="yes" <?php echo checked('yes', esc_attr(get_option('wsp_enable_hide_pirce'))); ?> />
		</div>

		<div id="hide_div">
			<div class="hide_div">
				<label><?php echo esc_html__('Hide for Guest Users', 'addify_wholesale_prices'); ?></label>
				<input type="checkbox" name="wsp_enable_hide_pirce_guest" id="wsp_enable_hide_pirce_guest" value="yes" <?php echo checked('yes', esc_attr(get_option('wsp_enable_hide_pirce_guest'))); ?> />
			</div>

			<div class="hide_div">
				<label><?php echo esc_html__('Hide for Registered Users', 'addify_wholesale_prices'); ?></label>
				<input type="checkbox" name="wsp_enable_hide_pirce_registered" id="wsp_enable_hide_pirce_registered" value="yes" <?php echo checked('yes', esc_attr(get_option('wsp_enable_hide_pirce_registered'))); ?> />
			</div>

			<div class="hide_div" id="userroles">
				<label><?php echo esc_html__('Select User Roles', 'addify_wholesale_prices'); ?></label>
				<div class="wsp_hide_field">

					<select class="select_box wc-enhanced-select sel2" name="wsp_hide_user_role[]" id="wsp_hide_user_role"  multiple='multiple'>

						<?php
						$afrole_hide_user_role = unserialize(get_option('wsp_hide_user_role'));
						
						global $wp_roles;
						$roles = $wp_roles->get_names();
						foreach ($roles as $key => $value) {
							?>
							<option value="<?php echo esc_attr($key); ?>"
								<?php
								if (!empty($afrole_hide_user_role) && in_array($key, $afrole_hide_user_role)) {
									echo 'selected';
								}
								?>
							>
								<?php 
								echo esc_attr($value);
								?>
									
								</option>
						<?php } ?>

					</select>
					<p><?php echo esc_html__('Select User Roles for which users you want to hide price and add to cart on frontend. If no user role is selected then price and add to cart will not be hidden for registered users.', 'addify_wholesale_prices'); ?></p>
				</div>
				
			</div>

			<div class="hide_div">
				<label><?php echo esc_html__('Hide Price', 'addify_wholesale_prices'); ?></label>
				<div class="wsp_hide_field">
					<input type="checkbox" name="wsp_hide_price" id="wsp_hide_price" value="yes" <?php echo checked('yes', esc_attr(get_option('wsp_hide_price'))); ?> />
					<p><?php echo esc_html__('If this option is checked then Price is hidden on the archive and product pages. The price will not be hidden in cart. If you enable the "Add to Cart" Button. ', 'addify_wholesale_prices'); ?></p>
				</div>
			</div>

			<div class="hide_div" id="hp_price">
				<label><?php echo esc_html__('Price Text', 'addify_wholesale_prices'); ?></label>
				<div class="wsp_hide_field">
					<input type="text" name="wsp_price_text" id="wsp_price_text" class="wsp_hp_input_field" value="<?php echo esc_attr(get_option('wsp_price_text')); ?>" />
					<p><?php echo esc_html__('This text will be shown in place of price in archive and product pages.', 'addify_wholesale_prices'); ?></p>
				</div>
			</div>

			<div class="hide_div">
				<label><?php echo esc_html__('Hide Add to Cart Button', 'addify_wholesale_prices'); ?></label>
				<div class="wsp_hide_field">
					<input type="checkbox" name="wsp_hide_cart_button" id="wsp_hide_cart_button" value="yes" <?php echo checked('yes', esc_attr(get_option('wsp_hide_cart_button'))); ?> />
					<p><?php echo esc_html__('If this option is checked then Add To Cart button is hidden on the archive and product pages.', 'addify_wholesale_prices'); ?></p>
				</div>
			</div>

			<div class="hide_div hp_cart">
				<label><?php echo esc_html__('Add to Cart Button Text', 'addify_wholesale_prices'); ?></label>
				<div class="wsp_hide_field">
					<input type="text" name="wsp_cart_button_text" id="wsp_cart_button_text" class="wsp_hp_input_field" value="<?php echo esc_attr(get_option('wsp_cart_button_text')); ?>" />
					<p><?php echo esc_html__('This text will be shown in place of text of Add to Cart Button.', 'addify_wholesale_prices'); ?></p>
				</div>
			</div>

			<div class="hide_div hp_cart">
				<label><?php echo esc_html__('Add to Cart Button Link', 'addify_wholesale_prices'); ?></label>
				<div class="wsp_hide_field">
					<input type="text" name="wsp_cart_button_link" id="wsp_cart_button_link" class="wsp_hp_input_field" value="<?php echo esc_attr(get_option('wsp_cart_button_link')); ?>" />
					<p><?php echo esc_html__('This link will replace Add to Cart Button link.', 'addify_wholesale_prices'); ?></p>
				</div>
			</div>


			<div class="hide_div">
				<label><?php echo esc_html__('Select Products', 'addify_wholesale_prices'); ?></label>
				<div class="wsp_hide_field">
					<select class="select_box wc-enhanced-select sel_pros" name="wsp_hide_products[]" id="wsp_hide_products"  multiple='multiple'>
						<?php
							$wsp_hide_products = unserialize(get_option('wsp_hide_products'));

						if (!empty($wsp_hide_products)) {

							foreach ( $wsp_hide_products as $pro) {

								$prod_post = get_post($pro);

								?>

									<option value="<?php echo intval($pro); ?>" selected="selected"><?php echo esc_attr($prod_post->post_title); ?></option>

								<?php 
							}
						}
						?>
					</select>
					<p><?php echo esc_html__('Select Products for which you want to hide price and add to cart.', 'addify_wholesale_prices'); ?></p>
				</div>
			</div>
			
			<div class="hide_div">
				<label><?php echo esc_html__('Select Categories', 'addify_wholesale_prices'); ?></label>
				<div class="wsp_hide_field">
					
					<div class="">
					<select id="wsp_hide_categories" name="wsp_hide_categories[]" multiple="multiple">
						<?php
						$wsp_hide_categories = unserialize(get_option('wsp_hide_categories'));
						$pre_vals            = !empty($wsp_hide_categories) ? $wsp_hide_categories : array();

						foreach ($af_wsp_categories as $category_id) {
							$selected = in_array($category_id, $pre_vals) ? 'selected' : '';
							$category = get_term_by('id', $category_id, 'product_cat');
							if ($category) {
								echo '<option value="' . esc_attr($category_id) . '" ' . esc_attr($selected) . '>' . esc_html($category->name) . '</option>';
							}
						}
						?>
					</select>
					</div>
					<p><?php echo esc_html__('Select Categories for which you want to hide price and add to cart.', 'addify_wholesale_prices'); ?></p>
				</div>
			</div>

			





		
		</div>

		<p><?php submit_button(esc_html__('Save Settings', 'addify_wholesale_prices' ), 'primary', 'afwholesale_save_hide_price'); ?></p>

		
	</div>


</form>
	
</div>

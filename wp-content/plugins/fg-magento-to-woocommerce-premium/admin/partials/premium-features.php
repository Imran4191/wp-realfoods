				<tr>
					<th scope="row"><?php _e('Meta keywords:', 'fgm2wcp'); ?></th>
					<td><input id="meta_keywords_in_tags" name="meta_keywords_in_tags" type="checkbox" value="1" <?php checked($data['meta_keywords_in_tags'], 1); ?> /> <label for="meta_keywords_in_tags" ><?php _e('Import meta keywords as tags', 'fgm2wcp'); ?></label></td>
				</tr>
				<tr>
					<th scope="row"><?php _e('SEO:', 'fgm2wcp'); ?></th>
					<td>
						<input id="import_meta_seo" name="import_meta_seo" type="checkbox" value="1" <?php checked($data['import_meta_seo'], 1); ?> /> <label for="import_meta_seo" ><?php _e('Import the SEO meta data (compatible with Yoast SEO and Rank Math SEO)', 'fgm2wcp'); ?></label>
					<br />
					<input id="url_redirect" name="url_redirect" type="checkbox" value="1" <?php checked($data['url_redirect'], 1); ?> /> <label for="url_redirect" ><?php _e("Redirect the Magento URLs", 'fgm2wcp'); ?></label>
					</td>
				</tr>
<?php if ( $data['display_multistore'] ): ?>
				<tr>
					<th scope="row"><?php _e('Multisites / Multistores:', 'fgm2wcp'); ?></th>
					<td>
						<label for="website" ><?php _e('Import the web site:', 'fgm2wcp'); ?></label>
						<select id="website" name="website">
							<?php echo $data['websites_options']; ?>
						</select>
						<br />
						<label for="store" ><?php _e('Import the store:', 'fgm2wcp'); ?></label>
						<select id="store" name="store">
							<?php echo $data['stores_options']; ?>
						</select>
						<br />
						<?php _e('Import customers and orders:', 'fgm2wcp'); ?>&nbsp;
						<input type="radio" name="import_customers_orders" id="import_customers_orders_all" value="all" <?php checked($data['import_customers_orders'], 'all', 1); ?> /><label for="import_customers_orders_all"><?php _e('from all stores', 'fgm2wcp'); ?></label>&nbsp;
						<input type="radio" name="import_customers_orders" id="import_customers_orders_selected_store" value="selected_store" <?php checked($data['import_customers_orders'], 'selected_store', 1); ?> /><label for="import_customers_orders_selected_store"><?php _e('from the selected store only', 'fgm2wcp'); ?></label>
					</td>
				</tr>
<?php endif; ?>
				<tr>
					<th scope="row"><?php _e('Partial import:', 'fgm2wcp'); ?></th>
					<td>
						 <div id="partial_import_toggle" style="text-decoration: underline; cursor: pointer; margin-bottom: 4px;"><?php _e('expand / collapse', 'fgm2wcp'); ?></div>
						<div id="partial_import">
						<input id="skip_cms" name="skip_cms" type="checkbox" value="1" <?php checked($data['skip_cms'], 1); ?> /> <label for="skip_cms" ><?php _e('Don\'t import the CMS', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_products_categories" name="skip_products_categories" type="checkbox" value="1" <?php checked($data['skip_products_categories'], 1); ?> /> <label for="skip_products_categories" ><?php _e('Don\'t import the products categories', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_disabled_products_categories" name="skip_disabled_products_categories" type="checkbox" value="1" <?php checked($data['skip_disabled_products_categories'], 1); ?> /> <label for="skip_disabled_products_categories" ><?php _e('Don\'t import the disabled products categories', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_products" name="skip_products" type="checkbox" value="1" <?php checked($data['skip_products'], 1); ?> /> <label for="skip_products" ><?php _e('Don\'t import the products', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_disabled_products" name="skip_disabled_products" type="checkbox" value="1" <?php checked($data['skip_disabled_products'], 1); ?> /> <label for="skip_disabled_products" ><?php _e('Don\'t import the disabled products', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_attributes" name="skip_attributes" type="checkbox" value="1" <?php checked($data['skip_attributes'], 1); ?> /> <label for="skip_attributes" ><?php _e('Don\'t import the product attributes', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_users" name="skip_users" type="checkbox" value="1" <?php checked($data['skip_users'], 1); ?> /> <label for="skip_users" ><?php _e('Don\'t import the users', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_customers" name="skip_customers" type="checkbox" value="1" <?php checked($data['skip_customers'], 1); ?> /> <label for="skip_customers" ><?php _e('Don\'t import the customers', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_inactive_customers" name="skip_inactive_customers" type="checkbox" value="1" <?php checked($data['skip_inactive_customers'], 1); ?> /> <label for="skip_inactive_customers" ><?php _e('Don\'t import the customers without order', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_orders" name="skip_orders" type="checkbox" value="1" <?php checked($data['skip_orders'], 1); ?> /> <label for="skip_orders" ><?php _e('Don\'t import the orders', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_reviews" name="skip_reviews" type="checkbox" value="1" <?php checked($data['skip_reviews'], 1); ?> /> <label for="skip_reviews" ><?php _e('Don\'t import the reviews', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_coupons" name="skip_coupons" type="checkbox" value="1" <?php checked($data['skip_coupons'], 1); ?> /> <label for="skip_coupons" ><?php _e('Don\'t import the coupons', 'fgm2wcp'); ?></label>
						<br />
						<input id="skip_redirects" name="skip_redirects" type="checkbox" value="1" <?php checked($data['skip_redirects'], 1); ?> /> <label for="skip_redirects" ><?php _e('Don\'t import the redirects', 'fgm2wcp'); ?></label>
						<?php do_action('fgm2wc_post_display_partial_import_options', $data); ?>
						</div>
					</td>
				</tr>

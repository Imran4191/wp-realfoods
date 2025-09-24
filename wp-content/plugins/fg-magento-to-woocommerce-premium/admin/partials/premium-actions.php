				<tr>
					<th scope="row"><?php _e('Update:', 'fgm2wcp'); ?></th>
					<td>
						<input id="update_stock_only" name="update_stock_only" type="checkbox" value="1" <?php checked($data['update_stock_only'], 1); ?> /> <label for="update_stock_only" ><?php _e("Update the products stocks only", 'fgm2wcp'); ?></label>
					</td>
				</tr>
				
				<tr>
					<th scope="row">&nbsp;</th>
					<td>
						<div class="submit_button_with_spinner">
							<?php submit_button( __('Update existing products, categories, customers and orders status', 'fgm2wcp'), 'primary', 'update', false ); ?>
							<span id="update_spinner" class="spinner"></span>
						</div>
						<div class="submit_button">
							<?php submit_button( __('Stop update', 'fgm2wcp'), 'secondary', 'stop-update', false ); ?>
						</div>
						<div id="update_message" class="action_message"></div>
					</td>
				</tr>

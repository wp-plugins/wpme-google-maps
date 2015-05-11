<div class="wpmegm-notice wpmegm-alert" style="display: none;">Saving...</div>

<form method="post" action="options.php" class="wpmegm-form-settings">
	<?php
		settings_fields('wpmegm-settings');
		do_settings_sections('wpmegm-settings');

		$options = get_option('wpmegm_options');

		// Options related to this screen only
		$button_appearance = esc_attr($options["general"]["button_appearance"]);
	?>

	<table class="form-table">
		<tr valign="top">
			<th scope="row">Button Appearance</th>
			<td>
				<select name="wpmegm_options[general][button_appearance]">
					<option value="">Default (icon and text)</option>
					<option value="icon" <?php echo ($button_appearance=="icon")?"selected":""; ?>>Icon only</option>
					<option value="text" <?php echo ($button_appearance=="text")?"selected":""; ?>>Text only</option>
				</select>
				<span class="notes">Button appearance on post editor.</span>
			</td>
		</tr>
	</table>

	<?php submit_button(); ?>

</form>
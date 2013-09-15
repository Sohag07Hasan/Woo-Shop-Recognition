<?php 
	
	$enabled = $this->is_recognition_enabled() ? '1' : '0';
	$recognitions = $this->get_recognitions();	
?>

<h3>Add some options to know from your customers how they know your shop</h3>

<p>Please add  your options (One option for a line)</p>

<table class="form-table">
	<tbody>
	
		<tr valign="top">
			<th scope="row" class="titledesc"><label for="woocommerce_shop_recognition_enabled">Shop Recognition Enabled?</label></th>
			<td class="forminp forminp-checkbox">
				<fieldset>
					<legend class="screen-reader-text"><span>Shop Recogniton</span></legend>
					<input <?php checked('1', $enabled); ?> id="woocommerce_shop_recognition_enabled" name="woocommerce_shop_recognition_enabled" type="checkbox" value="1" />										
				</fieldset>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row" class="titledesc"><label for="woocommerce_minimum_order_amount"> Options (one per line) </label></th>
			<td class="forminp forminp-checkbox">
				<fieldset>
					<legend class="screen-reader-text"><span> Options (one per line) </span></legend>
					<textarea rows="10" cols="50" id="woocommerce_shop_recognition_options" name="woocommerce_shop_recognition_options" ><?php echo $recognitions; ?></textarea>										
				</fieldset>
			</td>
		</tr>
		
		
		
	</tbody>
</table>
<?php 
	$recognitions = $this->get_recognitions();
	$recognitions = explode("\n", $recognitions);
?>

<style>
	
	div.shop-recognition{
		float: left;
	}
	
	div.shop-recognition select.shop-recognition_select{
		height: 2.5em;
		width: 40%;
	}
</style>

<?php if(count($recognitions) > 0): ?>

	<div class="shop-recognition">
		<label>How did you hear about us?</label>
		<select name="shop_recognition_select"> 
			<?php foreach($recognitions as $recognition): ?>
			
				<?php $recognition = trim($recognition); ?>
				<option value="<?php echo trim($recognition); ?>"> <?php echo $recognition; ?> </option>
		
			<?php endforeach; ?>
		</select>		
	</div>

<?php endif; ?>


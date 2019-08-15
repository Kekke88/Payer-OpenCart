<?php if (isset($error)) { ?>
	<div class="warning"><?php echo $error; ?></div>
<?php } ?>

<form action="<?php echo $action; ?>" method="post" id="payment">
	<?php foreach (@$fields as $key => $value) { ?>
	    <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
	<?php } ?>
	<div class="buttons">
		<div class="pull-right">
			<input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
		</div>
	</div>
</form>
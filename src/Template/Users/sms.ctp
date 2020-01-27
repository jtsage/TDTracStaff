<div class="card p-3 rounded border shadow-sm">

<h3 class="text-dark mb-4">Send User SMS</h3>

<?php $gdPhone = $this->Pretty->validPhone($user->phone); ?>
<table class="table table-striped w-100">
	<tr><th>Name</th><td><?= $user->full_name ?></td></tr>
	<tr><th>Phone</th><td><?= $gdPhone[1] ?></td></tr> 
</table>
	<?= $this->Form->create(null) ?>
	<fieldset>
		<?php
			echo $this->Form->input('message', ['label' => __("Message to Send"), 'help' => "<span id='charused'>0</span>/1600 characters used"]);
		?>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("send-check") . __(' Send Message'), ["class" => "w-100 btn-lg btn-outline-success", "disabled" =>  ( !$gdPhone[0] ? "true" : "false" )]) ?>
	<?= $this->Form->end() ?>
</div>

<script>
	$('#message').on('keyup', function() {
		var usedchar = $('#message').val().length;
		$('#charused').text(usedchar);
		$('#charused').removeClass('text-warning');
		$('#charused').removeClass('text-danger');
		if ( usedchar > 140 ) {
			$('#charused').addClass('text-warning');
		}
		if ( usedchar > 1600 ) {
			$('#charused').removeClass('text-warning');
			$('#charused').addClass('text-danger');
		}
	})
</script>
<?= $this->Pretty->helpMeStart("SMS User"); ?>
<p>Send a direct SMS message</p>
<?= $this->Pretty->helpMeEnd(); ?>
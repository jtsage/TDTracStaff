<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Send Bulk SMS Messages</h3>
	<p>Note: only those users with a valid phone number will appear on this list</p>

	<?= $this->Form->create(null) ?>
	<fieldset>
		<?php 
			foreach ( $scheduled as $user ) {
				$gdPhone = $this->Pretty->validPhone($user->user->phone);

				if ( $gdPhone[0] ) {
					echo $this->Form->input('users[]', [
						'data-toggle'   => "toggle",
						'data-width'    => '100%',
						'data-height'   => '36px',
						'data-on'       => __('Send to ' . $user->user->full_name . ' (' . $gdPhone[1] . ')'),
						'data-off'      => __('Do Not Send to ' . $user->user->full_name ),
						'data-onstyle'  => 'success',
						'data-offstyle' => 'danger',
						'label'         => '',
						'checked'       => true,
						'value'         => $user->user_id,
						'type'          => 'checkbox'

					]);
				}
			}
		?>
		<?php
			echo $this->Form->input('message', ['label' => __("Message to Send"), 'help' => "<span id='charused'>0</span>/1600 characters used"]);
		?>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("send-check") . __(' Send Message'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
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

<?= $this->Pretty->helpMeStart("Send Bulk SMS"); ?>

<p>Send a bulk SMS to the listed users</p>

<?= $this->Pretty->helpMeEnd(); ?>
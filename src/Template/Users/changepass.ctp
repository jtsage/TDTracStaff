<div class="card p-3 rounded border shadow-sm">

<h3 class="text-dark mb-4">Change Password</h3>

	<?= $this->Form->create($user, ['data-toggle' => 'validator', 'autocomplete' => 'off']) ?>
	<fieldset>
		<?php
			echo $this->Form->input('password', ['label' => __("New Password"), 'data-minlength' => 6, 'value' => '']);
		?>
		<input type="hidden" name="is_password_expired" value="0">
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("lock") . __(' Change Password'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart("Change Password"); ?>
<p>Use this display to change your password, or (adminstrator only), reset the password for the selected user.</p>
<?= $this->Pretty->helpMeEnd(); ?>
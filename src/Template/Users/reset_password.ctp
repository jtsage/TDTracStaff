<div class="users form large-10 medium-9 columns">
	<?= $this->Form->create($user, ['data-toggle' => 'validator', 'autocomplete' => 'off']) ?>
	<fieldset>
		<legend><?= __('Set A New Password') ?></legend>
		<?php
			echo $this->Form->input('password', ['label' => __("New Password"), 'data-minlength' => 6, 'value' => '']);
		?>
		<input type="hidden" name="is_password_expired" value="0">
	</fieldset>
	<?= $this->Form->button($this->Pretty->iconSave("") . __('Set Password'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart(__('Set New Password')); ?>
<p><?= __("This display allows you change your forgotten password."); ?></p>
<?= $this->Pretty->helpMeEnd(); ?>
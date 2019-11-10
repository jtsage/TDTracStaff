<div class="users form large-10 medium-9 columns">
	<?= $this->Form->create($user, ['data-toggle' => 'validator', 'autocomplete' => 'off']) ?>
	<fieldset>
		<legend><?= __('Edit User') ?></legend>
		<?php
			echo $this->Form->input('username', ['label' => __("E-Mail Address")]);
			echo $this->Form->input('first', ['label' => __("First Name")]);
			echo $this->Form->input('last', ['label' => __("Last Name")]);
			echo $this->Form->input('phone', ['label' => __("Phone Number"), "help" => "###-###-#### preferred"]);
		?>
		
		<label>Switches</label>
		<?php
			echo $this->Pretty->check('is_active', $user->is_active, [
				'label-width' => '150',
				'label-text' => __('Is Active'),
				'on-text' => __('YES'),
				'off-text' => __('NO'),
				'on-color' => 'success',
				'off-color' => 'danger'
			]);
			echo $this->Pretty->check('is_verified', $user->is_verified, [
				'label-width' => '150',
				'label-text' => __('Is Verified'),
				'on-text' => __('YES'),
				'off-text' => __('NO'),
				'on-color' => 'success',
				'off-color' => 'danger'
			]);
			echo $this->Pretty->check('is_password_expired', $user->is_password_expired, [
				'label-width' => '150',
				'label-text' => __('Is Password Expired'),
				'on-text' => __('YES'),
				'off-text' => __('NO'),
				'off-color' => 'success',
				'on-color' => 'danger'
			]);
			echo $this->Pretty->check('is_admin', $user->is_admin, [
				'label-width' => '150',
				'label-text' => __('Is Admin'),
				'on-text' => __('YES'),
				'off-text' => __('NO'),
				'off-color' => 'success',
				'on-color' => 'danger'
			]);
		?>
	</fieldset>
	<?= $this->Form->button($this->Pretty->iconSave("") . __('Save Changes'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart("Edit User"); ?>
<p>Edit a user's detail's.  "is Verified" must be left true.  "is Password Expired" will remind a
user to change their password at next login (defaults to true on new accounts).</p>
<?= $this->Pretty->helpMeEnd(); ?>
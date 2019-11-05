<div class="users form large-10 medium-9 columns">
	<?= $this->Form->create($user, ['data-toggle' => 'validator', 'autocomplete' => 'off']) ?>
	<fieldset>
		<legend><?= __('Add User') ?></legend>
		<?php
			echo $this->Form->input('username', ['label' => __("E-Mail Address")]);
			echo $this->Form->input('password', ['label' => 'Password', 'data-minlength' => 6]);
			echo $this->Form->input('first', ['label' => __("First Name")]);
			echo $this->Form->input('last', ['label' => __("Last Name")]);
		?>
		<?php
			function doEet($matches) {
				if ( isset(CINFO[$matches[1]]) ) {
					return CINFO[$matches[1]];
				}
				return "!!Variable-Not-Defined!!";
			}
			$welcomeMailText = $welMail->value_long;
			$welcomeMailText = preg_replace_callback("/{{(\w+)}}/m", "doEet", $welcomeMailText);
		?>
		<div class="form-group">
			<label for="welcomeEmail">Welcome E-Mail</label>
			<textarea class="form-control" id="welcomeEmail" name="welcomeEmail" rows="12"><?= $welcomeMailText ?></textarea>
		</div>
		<?= $this->Pretty->check('welcomeEmailSend', 1, [
				'label-width' => '200',
				'label-text' => __('Send E-Mail'),
				'on-text' => __('YES'),
				'off-text' => __('NO'),
				'on-color' => 'success',
				'off-color' => 'danger'
		]); ?>
		<?= $this->Pretty->check('welcomeEmailSendCopy', 1, [
				'label-width' => '200',
				'label-text' => __('Send E-Mail (copy to admin)'),
				'on-text' => __('YES'),
				'off-text' => __('NO'),
				'on-color' => 'success',
				'off-color' => 'danger'
		]); ?>
	</fieldset>
	<?= $this->Form->button($this->Pretty->iconAdd("") . __('Add User'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

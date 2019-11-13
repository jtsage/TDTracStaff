<div class="card p-3 rounded border shadow-sm">

<h3 class="text-dark mb-4">Add User</h3>

	<?= $this->Form->create($user, ['data-toggle' => 'validator', 'autocomplete' => 'off']) ?>
	<fieldset>
		<?php
			echo $this->Form->input('username', ["autocomplete"=>"new-password", 'label' => __("E-Mail Address")]);
			echo $this->Form->input('password', ["autocomplete"=>"new-password", 'label' => 'Password', 'data-minlength' => 6]);
			echo $this->Form->input('first', ['label' => __("First Name")]);
			echo $this->Form->input('last', ['label' => __("Last Name")]);
			echo $this->Form->input('phone', ['label' => __("Phone Number"), "help" => "###-###-#### preferred"]);
		?>
		<?php
			$welcomeMailText = $CONFIG['welcome-email'];
			$welcomeMailText = preg_replace_callback(
				"/{{([\w-]+)}}/m",
				function ($matches) use ( $CONFIG ) {
					if ( !empty($CONFIG[$matches[1]]) ) {
						return $CONFIG[$matches[1]];
					}
					return "!!Variable-Not-Defined!!";
				},
				$welcomeMailText
			);
		?>
		<div class="form-group">
			<label for="welcomeEmail">Welcome E-Mail</label>
			<textarea class="form-control" id="welcomeEmail" name="welcomeEmail" rows="12"><?= $welcomeMailText ?></textarea>
		</div>
		<?= $this->Form->input('welcomeEmailSend', [
				'type'          => 'checkbox',
				'checked'       => 1,
				'data-toggle'   => "toggle",
				'data-width'    => '100%',
				'data-height'   => '36px',
				'data-on'       => __('Send Welcome E-Mail'),
				'data-off'      => __('Do Not Notify'),
				'data-onstyle'  => 'success',
				'data-offstyle' => 'danger',
				'label'         => ""
			]); ?>
		<?= $this->Form->input('welcomeEmailSendCopy', [
				'type'          => 'checkbox',
				'checked'       => 1,
				'data-toggle'   => "toggle",
				'data-width'    => '100%',
				'data-height'   => '36px',
				'data-on'       => __('Copy E-Mail to Administrator'),
				'data-off'      => __('No Copy'),
				'data-onstyle'  => 'success',
				'data-offstyle' => 'danger',
				'label'         => ""
			]); ?>

		
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("account-plus") . __(' Add User'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart("Add User"); ?>
<p>Allow a user to be added to the system.  Note, this system requires users be added by an administrator
and does not allow new user sign-up</p>
<?= $this->Pretty->helpMeEnd(); ?>
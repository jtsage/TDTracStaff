<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Edit Your Account</h3>
	<?= $this->Form->create($user, ['data-toggle' => 'validator', 'autocomplete' => 'off']) ?>
	<fieldset>
		<?php
			echo $this->Form->input('first', ['label' => __("First Name")]);
			echo $this->Form->input('last', ['label' => __("Last Name")]);
			echo $this->Form->input('phone', ['label' => __("Phone Number"), "help" => "###-###-#### preferred"]);
		?>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("account-check") . __(' Save Changes'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart("Edit Yourself"); ?>
<p>This allows you to change your name.  To change your e-mail address, you must contact your
administrator directly.</p>
<?= $this->Pretty->helpMeEnd(); ?>


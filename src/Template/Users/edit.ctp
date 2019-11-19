<div class="card p-3 rounded border shadow-sm">

<h3 class="text-dark mb-4">Edit User</h3>

	<?= $this->Form->create($user, ['data-toggle' => 'validator', 'autocomplete' => 'off']) ?>
	<fieldset>
		<?php
			echo $this->Form->input('username', ['label' => __("E-Mail Address")]);
			echo $this->Form->input('first', ['label' => __("First Name")]);
			echo $this->Form->input('last', ['label' => __("Last Name")]);
			echo $this->Form->input('phone', ['label' => __("Phone Number"), "help" => "###-###-#### preferred"]);
		?>
		
		<label>Switches</label>
		<div class="row"><div class="col-12 col-md-6">
		<?php
			echo $this->Form->input('is_active', [
				'data-toggle'   => "toggle",
				'data-width'    => '100%',
				'data-height'   => '36px',
				'data-on'       => __('Active User'),
				'data-off'      => __('Inactive User'),
				'data-onstyle'  => 'success',
				'data-offstyle' => 'danger',
				'label'         => ""
			]);
			echo $this->Form->input('is_password_expired', [
				'data-toggle'   => "toggle",
				'data-width'    => '100%',
				'data-height'   => '36px',
				'data-on'       => __('Password Expired'),
				'data-off'      => __('Password Valid'),
				'data-onstyle'  => 'danger',
				'data-offstyle' => 'success',
				'label'         => ""
			]);
			echo $this->Form->input('is_admin', [
				'data-toggle'   => "toggle",
				'data-width'    => '100%',
				'data-height'   => '36px',
				'data-on'       => __('Admin User'),
				'data-off'      => __('Regular User'),
				'data-onstyle'  => 'warning',
				'data-offstyle' => 'success',
				'label'         => ""
			]);
			echo $this->Form->input('is_budget', [
				'data-toggle'   => "toggle",
				'data-width'    => '100%',
				'data-height'   => '36px',
				'data-on'       => __('Budget User'),
				'data-off'      => __('Non-Budget User'),
				'data-onstyle'  => 'warning',
				'data-offstyle' => 'success',
				'label'         => ""
			]);
		?>
		</div></div>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("content-save") . __(' Save Changes'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart("Edit User"); ?>
<p>Edit a user's detail's.  "is Password Expired" will remind a
user to change their password at next login (defaults to true on new accounts).</p>

<p>Budget users may add and view the budget of any job</p>

<p>Administrators have unrestricted access to the system, except budgets (unless also flagged true)</p>

<p>Inactive users will be denied login.</p>
<?= $this->Pretty->helpMeEnd(); ?>
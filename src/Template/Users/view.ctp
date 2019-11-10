<div class="users view large-10 medium-9 columns">
	<h3><?= h($user->first) . " " . h($user->last) ?></h3>
	<div class='btn-group btn-group-sm-vertical w-100 mb-3'>
	<?= $this->Html->link(
		$this->Pretty->iconEdit($user->username) . "Edit User",
		['action' => 'edit', $user->id],
		['escape' => false, 'class' => 'text-left text-md-center w-100 btn btn-outline-dark']
	) ?>
	<?= $this->Html->link(
		$this->Pretty->iconLock($user->username) . "Change Password",
		['action' => 'changepass', $user->id],
		['escape' => false, 'class' => 'text-left text-md-center w-100 btn btn-outline-dark']
	) ?>
	<?= ( $WhoAmI ) ? $this->Html->link(
		$this->Pretty->iconPerm($user->username) . "Change Titles",
		['action' => 'roles', $user->id],
		['escape' => false, 'class' => 'text-left text-md-center w-100 btn btn-outline-info']
	) : "" ?>
	</div>
	<div class="row mb-3">
		<div class="col-md-4">
			<dl class="m-0 mb-2"><dt>Username</dt><dd class="m-0 ml-3"><?= $user->username ?></dd></dl>
			<dl class="m-0 mb-2"><dt>Full Name</dt><dd class="m-0 ml-3"><?= $user->first . " " . $user->last ?></dd></dl>
			<dl class="m-0 mb-2"><dt>Phone Number</dt><dd class="m-0 ml-3"><?= $user->phone ?></dd></dl>
		</div>
		<div class="col-md-4">
			<dl class="m-0 mb-2"><dt>Last Login At</dt><dd class="m-0 ml-3"><?= $user->last_login_at->i18nFormat("EEEE, MMMM d, YYYY @ h:mm a", $tz) ?></dd></dl>
			<dl class="m-0 mb-2"><dt>User Added On</dt><dd class="m-0 ml-3"><?= $user->created_at->i18nFormat("EEEE, MMMM d, YYYY @ h:mm a", $tz) ?></dd></dl>
			<dl class="m-0 mb-2"><dt>Last Updated At</dt><dd class="m-0 ml-3"><?= $user->updated_at->i18nFormat("EEEE, MMMM d, YYYY @ h:mm a", $tz) ?></dd></dl>
		</div>
		<div class="col-md-4">
			<dl class="m-0 mb-2"><dt>Active User?</dt><dd class="m-0 ml-3"><?= $this->Bool->prefYes($user->is_active) ?></dd></dl>
			<dl class="m-0 mb-2"><dt>Expired Password?</dt><dd class="m-0 ml-3"><?= $this->Bool->prefNo($user->is_password_expired) ?></dd></dl>
			<dl class="m-0 mb-2"><dt>E-Mail Verified?</dt><dd class="m-0 ml-3"><?= $this->Bool->prefYes($user->is_verified) ?></dd></dl>
			<dl class="m-0 mb-2"><dt>Administrator?</dt><dd class="m-0 ml-3"><?= $this->Bool->prefNo($user->is_admin) ?></dd></dl>
		</div>
	</div>
	
	<h5>Training Profile</h5>
	<div class="container">
		<ul class="list-group w-100">
			<?php foreach ( $user->roles as $role ) : ?>
				<li class="list-group-item"><?= $role->title ?> <small><em><?= $role->detail ?></em></small></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<?= $this->Pretty->helpMeStart("User View"); ?>
<p>This shows all of the known detail about a user.</p>
<?= $this->Pretty->helpMeEnd(); ?>
